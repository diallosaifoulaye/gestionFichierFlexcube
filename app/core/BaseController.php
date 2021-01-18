<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 17/08/2017
 * Time: 11:01
 */

namespace app\core;

use app\controllers\WebserviceClientController;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

abstract class BaseController
{
    private $url;
    protected $appConfig;
    protected $apiClient;
    protected $_USER;
    protected $paramGET = [];
    protected $paramPOST = [];
    protected $paramFILE = [];
    protected $lang;
    protected $views;


    /**
     * BaseController constructor.
     * @param bool $testUserCon
     */
    public function __construct($testUserCon = true)
    {
        $this->appConfig = \parse_ini_file(ROOT . 'config/app.config.ini');

        if($this->appConfig['law_generate'] == 1) $this->addDroitControllers();

        $this->url = Session::getAttributArray('url');

        if ($this->appConfig['use_api_client'] == "1") $this->apiClient = new WebserviceClientController();

        if ($testUserCon) Session::isConnected(SESSIONNAME);

        if (Session::existeAttribut(SESSIONNAME)) $this->_USER = Session::getAttributArray(SESSIONNAME)[0];

        if (!Session::existeAttribut("lang")) Session::setAttribut("lang", "fr");

        $this->lang = Language::getLang(Session::getAttribut('lang'));
        $this->views = new BaseViews($this->lang, [$this->url[0], $this->url[1]], ["header" => $this->appConfig[SPACE . '_header'], "sidebar" => $this->appConfig[SPACE . '_sidebar'], "footer" => $this->appConfig[SPACE . '_footer']], $this->appConfig);
        $this->appConfig = (object)$this->appConfig;
    }

    private function addDroitControllers() {
        try {
            Session::setAttribut("total", 0);
            Session::setAttribut("nbr", 0);
            $controllers = $this->getControllers();
            foreach ($controllers as $oneCont) {
                if(is_file(ROOT."app/controllers/".$oneCont."Controller.php")) $this->addDroitController($oneCont);
                elseif(is_dir(ROOT."app/controllers/".$oneCont)){
                    $dirCont = $this->getControllers($oneCont);
                    foreach ($dirCont as $oneContDir) $this->addDroitController($oneContDir,$oneCont);
                }
            }
            if(intval(Session::getAttribut("nbr")) > 0) Utils::setMessageALert(["success","configuration des droits ".Session::getAttribut("nbr")."/".Session::getAttribut("total")." ajouté(s)"]);
            Session::destroyAttributSession("total");
            Session::destroyAttributSession("nbr");
        } catch (\ReflectionException $ex) {
            var_dump($ex->getMessage());die;
        }
    }

    /**
     * @param $classe
     * @param null $espace
     * @throws \ReflectionException
     */
    private function addDroitController($classe, $espace = null) {
        $model = new Model();
        $classe = is_null($espace) ? 'app\controllers\\'.$classe.'Controller' : 'app\controllers\\'.$espace.'\\'.$classe.'Controller';
        $reflection = new \ReflectionClass($classe);
        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        $methods = array_map(function ($item){return  in_array($item->name, ['__construct', 'authorized', 'setParamGET', 'setParamPOST', 'setParamFILE']) || Utils::endsWith($item->name, '__') || Utils::endsWith($item->name, 'Processing') || Utils::endsWith($item->name, 'Modal') ? '' : $item;},$methods);
        $methods = @Utils::setPurgeArray($methods);

        foreach ($methods as $oneMethod) {
            $action = $oneMethod->name;
            $controller = $oneMethod->class;
            $controller = str_replace('Controller', '', $controller);
            $controller = (is_null($espace)) ? str_replace('app\controllers\\', '', $controller) : str_replace('app\controllers\\'.$espace.'\\', '', $controller);
            $doc = $oneMethod->getDocComment();
            if($doc != false) {
                $droit = explode("@droit", $doc)[1];
                if(!is_null($droit)) {
                    Session::setAttribut("total", (intval(Session::getAttribut("total"))+1));
                    if(count($model->get(["table"=>"droit", "champs"=>["id"], "condition"=>["espace ="=>(!is_null($espace) ? $espace : "default"), "controller ="=>$controller, "action ="=>$action]])) === 0){
                        $droit = trim(preg_replace("#\n|\t|\r|\*/|\*#", "",$droit));
                        $droit = explode("-", $droit);
                        $param = [
                            "droit" => $droit[0],
                            "fk_sous_module" => $droit[1],
                            "controller" => $controller,
                            "action" => $action
                        ];
                        if(!is_null($espace)) $param['espace'] = $espace;
                        $param = array_map(function ($one){return trim($one);}, $param);
                        $rst = $model->set(["table"=>"droit", "champs"=>$param]);
                        if($rst !== false) Session::setAttribut("nbr", (intval(Session::getAttribut("nbr"))+1));
                    }
                }
            }
        }
    }

    /**
     * @param null $espace
     * @return array
     */
    private function getControllers($espace = null) {
        $controllers = is_null($espace) ? scandir(ROOT.'app/controllers/') : scandir(ROOT.'app/controllers/'.$espace);
        $controllers = array_map(function ($item){return Utils::startsWith($item,'.') || Utils::startsWith($item,'Webservice') || Utils::startsWith($item,'Error') || Utils::startsWith($item,'Language') ? '' : str_replace("Controller.php", "", $item);},$controllers);
        return @Utils::setPurgeArray($controllers);
    }

    /**
     * @param $controller
     * @param $action
     */
    public function authorized($controller, $action)
    {
        if ($this->_USER && !Utils::endsWith($action, "Processing") && !Utils::endsWith($action, "Modal")) {
          //  var_dump((new Model())->__authorized($this->_USER->fk_profil, $controller, $action)); exit;
            if ((!isset($this->_USER->admin) || $this->_USER->admin != 1) && !(new Model())->__authorized($this->_USER->fk_profil, $controller, $action)) {
                Utils::setMessageError(['401', []]);
                Utils::redirect("error", "error");
                exit();
            }
        }
    }

    /**
     * @param null $controller
     * @param null $action
     */
    protected function validateToken($controller = null, $action = null)
    {
        $token = Session::getAttributArray("_token_");

        if (count($this->paramPOST) > 0) {
            if ((isset($this->paramPOST[$token['name']]) && password_verify($token['value'], $this->paramPOST[$token['name']]))) {
                unset($this->paramPOST[$token['name']]);
                $token["used"] = 1;
                Session::setAttributArray("_token_", $token);
                Session::setAttribut("token", sprintf('<input type="hidden" name="%s" value="%s" />', $token["name"], Utils::getPassCrypt($token["value"])));
            } else {
                Utils::setMessageALert(["warning", "Token invalide"]);
                Utils::redirect($controller, $action);
                exit();
            }
        } else {
            Utils::setMessageALert(["warning", "Données invalides"]);
            Utils::redirect($controller, $action);
            exit();
        }
    }

    /**
     * @param $model
     * @return mixed
     */
    protected function model($model)
    {
        $model = Prefix_Model . ucfirst($model) . 'Model';
        return new $model();
    }

    /**
     * @param $model
     * @param $method
     * @param array $param
     */
    protected function processing($model, $method, $param = [])
    {
        extract($param);
        $requestData = $_REQUEST;
        $queryData = (is_null($args) || count($args) == 0) ? $model->$method() : $model->$method($args);
        $tempData = $queryData[0];
        $totalData = $queryData[1];
        $totalFiltered = $totalData;
        $data = [];
        if (!is_array($tempData)) echo json_encode($tempData);
        else {
            $classModal = (isset($this->paramPOST['id'])) ? $this->paramPOST['id'] : "open-modal-processing";
            foreach ($tempData as $item) {
                $dataId = (isset($item['id'])) ? $item['id'] : $item['rowid'];
                unset($item['id']);
                unset($item['rowid']);

                if(count($fonction) > 0){
                    foreach ($item as $key => $value){
                        if(in_array($key, array_keys($fonction))){
                            $oneMet = explode("/",$fonction[$key])[0];
                            $oneMet = explode("|",$oneMet);
                            foreach ($oneMet as $oneMetItem)
                                $item[$key] = @call_user_func_array([Utils::class, $oneMetItem],((explode("/",$fonction[$key])[1] == "alldata") ? [$item] : [$item[$key]]));
                        }
                    }
                }

                $href = "";
                $initTooltip = "";
                $addClassCss = "";
                $addAttribut = "";

                if (count($button) > 0) {
                    foreach ($button as $indice => $oneButton) {
                        if ($indice == "modal") {
                            if (count($oneButton) > 0) {
                                foreach ($oneButton as $oneButtonKey => $oneButtonElem) {
                                    $this->setProcessing($item, $indice, $oneButtonKey, $oneButtonElem, $initTooltip, $addClassCss, $addAttribut, $tooltip, $classCss, $attribut);
                                    if (count($oneButtonElem) === 3) {
                                        $oneButtonElem[1] = explode("/", $oneButtonElem[1]);
                                        $modalView = $oneButtonElem[1][0] . '/' . $oneButtonElem[1][1];
                                        unset($oneButtonElem[1][0]);
                                        unset($oneButtonElem[1][1]);
                                        $oneButtonElem[1] = array_values($oneButtonElem[1]);
                                        $modalParam = [base64_encode($dataId)];

                                        if (count($oneButtonElem[1]) > 0)
                                            foreach ($oneButtonElem[1] as $oneButtonElemVal)
                                                if (isset($item[$oneButtonElemVal]))
                                                    array_push($modalParam, base64_encode($item[$oneButtonElemVal]));

                                        $href .= '<a class="action ' . $classModal . ' ' . $addClassCss . '" ' . $initTooltip . ' ' . $addAttribut . ' href="javascript:;" data-modal-controller="' . $oneButtonElem[0] . '" data-modal-view="' . $modalView . '" data-modal-param="' . implode("/", $modalParam) . '"><i class="' . $oneButtonElem[2] . '"></i></a> ';
                                        $initTooltip = '';
                                        $addClassCss = '';
                                        $addAttribut = '';
                                    }
                                }
                            }
                        } elseif ($indice == "default") {
                            if (count($oneButton) > 0) {
                                foreach ($oneButton as $oneButtonKey => $oneButtonElem) {
                                    $this->setProcessing($item, $indice, $oneButtonKey, $oneButtonElem, $initTooltip, $addClassCss, $addAttribut, $tooltip, $classCss, $attribut);
                                    if (count($oneButtonElem) === 2) {
                                        $oneButtonElem[0] = explode("/", $oneButtonElem[0]);
                                        $linkHref = $oneButtonElem[0][0] . '/' . $oneButtonElem[0][1];
                                        unset($oneButtonElem[0][0]);
                                        unset($oneButtonElem[0][1]);
                                        $oneButtonElem[0] = array_values($oneButtonElem[0]);

                                        $linkParam = [base64_encode($dataId)];
                                        if (count($oneButtonElem[0]) > 0)
                                            foreach ($oneButtonElem[0] as $oneButtonElemVal)
                                                if (isset($item[$oneButtonElemVal]))
                                                    array_push($linkParam, base64_encode($item[$oneButtonElemVal]));

                                        $href .= "<a class='action " . $addClassCss . "' " . $initTooltip . " " . $addAttribut . " href='" . WEBROOT . $linkHref . '/' . implode("/", $linkParam) . "'><i class='" . $oneButtonElem[1] . "'></i></a> ";
                                        $initTooltip = '';
                                        $addClassCss = '';
                                        $addAttribut = '';

                                    }
                                }
                            }
                        } elseif ($indice == "custom") {
                            if (count($oneButton) > 0) {
                                foreach ($oneButton as $oneButtonElem) {
                                    if (isset($oneButtonElem["champ"]) && isset($oneButtonElem["val"]))
                                        $oneButtonElem = $oneButtonElem["val"][$item[$oneButtonElem["champ"]]];
                                    $href .= "<span class='action'>" . $oneButtonElem . "<span hidden>base64_encode($dataId)</span></span>";
                                }
                            }
                        }
                    }
                }
                if (count($dataVal) > 0)
                    foreach ($dataVal as $oneValue)
                        if (isset($item[$oneValue['champ']]))
                            $item[$oneValue['champ']] = $oneValue['val'][$item[$oneValue['champ']]];

                foreach ($item as $key => $val)
                    if (Utils::startsWith($key, '_')
                        && Utils::endsWith($key, '_'))
                        unset($item[$key]);

                $temp = array_values($item);
                array_push($temp, $href);
                $data[] = $temp;
            }
            $modalJS = '<script>
                            $(".' . $classModal . '").on("click", function() {
                                        let racine = "' . WEBROOT . '";
                                        let controller = $(this).data("modal-controller");
                                        let view = $(this).data("modal-view");
                                        let param = $(this).data("modal-param");
                                        let url = (param === undefined) ? racine+controller+"/"+view : racine+controller+"/"+view+"/"+param;
                                        if(controller !== undefined) {
                                        $.get(url, function(data) {
                                                if(parseInt(data) !== 0){
                                                    let modal = \'<div class="modal fade bs-modal-lg" id="modal"  data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"> <div class="modal-dialog modal-lg"> <div class="modal-content" id="content-modal"> <div class="modal-header"> <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button> <h4 class="modal-title">En cours de chargement</h4> </div> <div class="modal-body"> <div align="center"> <img src="' . WEBROOT . 'assets/_main_/loading.gif" width="25%"/> </div> </div> <div class="modal-footer"> <button class="btn btn-default" type="button" data-dismiss="modal"> <i class="fa fa-times"></i> Annuler </button> </div> </div> </div> </div>\';
                                                    $("#modal-container").html(modal);
                                                    $("#content-modal").html(data);
                                                    $("#modal").modal("show");
                                                }else alert("La vue n\'a pas été définie !")
                                            });
                                        }else alert("Le controller n\'a pas été défini !")
                                    });
                                    $(".confirm-modal").on("click", function (e) {
                                        let type_link = "url";
                                        let link = $(this).attr("href");
                                        if(link === undefined) {
                                            link = $(this).data("form");
                                            type_link = "form"
                                        }
                                        if(link !== undefined){
                                            e.preventDefault();
                                            $.getJSON(racine+"language/getLang", (lang) => {
                                                $.confirm({
                                                title: lang.confirmTitre,
                                                escapeKey: true, // close the modal when escape is pressed.
                                                content: lang.confirmMessage,
                                                backgroundDismiss: false, // for escapeKey to work, backgroundDismiss should be enabled.
                                                icon: "fa fa-question",
                                                theme: "material",
                                                closeIcon: true,
                                                animation: "scale",
                                                type: "red",
                                                buttons: {
                                                    "non" : {
                                                        text: "Non",
                                                        btnClass: "btn-red",
                                                        keys: ["ctrl","shift"],
                                                        action: () => {}
                                                    },
                                                    "oui" : {
                                                        text: "Oui",
                                                        btnClass: "btn-green",
                                                        keys: ["enter"],
                                                        action: () => {
                                                            if(type_link === "url") window.location = link;
                                                            else $("#"+link).submit();
                                                        }
                                                    }
                                                },
                                            });
                                            });
                                        }
                                    });
                                    $(\'a[data-toggle="tooltip"]\').tooltip();
                                </script>';
            if (isset($modalJS)) $data[count($data) - 1][count($data[count($data) - 1]) - 1] .= $modalJS;

            $json_data = array(
                "draw" => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
                "recordsTotal" => intval($totalData),  // total number of records
                "recordsFiltered" => intval($totalFiltered),// total number of records after searching, if there is no searching then totalFiltered = totalData
                "data" => $data   // total data array
            );
            echo json_encode($json_data);  // send data as json format
        }
    }

    /**
     * @param mixed $paramGET
     */
    public function setParamGET($paramGET)
    {
        $paramGET = @Utils::setPurgeArray($paramGET);
        $this->paramGET = $paramGET;
        if (is_object($this->apiClient)) $this->apiClient->setParamGET($paramGET);
    }

    /**
     * @param mixed $paramPOST
     */
    public function setParamPOST($paramPOST)
    {
        $paramPOST = @Utils::setPurgeArray($paramPOST);
        $this->paramPOST = $paramPOST;
        if (is_object($this->apiClient)) $this->apiClient->setParamPOST($paramPOST);
        unset($_POST);
    }

    /**
     * @param mixed $paramFILE
     */
    public function setParamFILE($paramFILE)
    {
        $this->paramFILE = $paramFILE;
        if (is_object($this->apiClient)) $this->apiClient->setParamFILE($paramFILE);
    }

    protected function modal()
    {
        ob_start();
        $this->views->getPage(strtolower($this->paramGET[0]) . '/' . $this->paramGET[1]);

        $content = ob_get_clean();
        echo $content;
    }

    /**
     * @param array $param
     * @return bool
     */
    protected function sendMail(array $param)
    {
        if (count($param) > 0) {
            extract($param);
            if (isset($subject) && isset($content) && isset($email)) {
                try {
                    if (isset($data)) extract($data);
                    $mail = new PHPMailer();
                    $mail->SetLanguage(Session::getAttribut('lang'));
                    $mail->CharSet = 'UTF-8';
                    $mail->isHTML(true);
                    $mail->setFrom($this->appConfig->mail_from);
                    $mail->addAddress($email);
                    $mail->Subject = $subject;
                    $email->Body = '<html><head><meta charset="utf-8"></head><body>';
                    if (file_exists(ROOT . Prefix_View . $content . '.php')) {
                        ob_start();
                        include(ROOT . Prefix_View . $content . '.php');
                        $mail->Body .= ob_get_clean();
                    } else $mail->Body .= $content;
                    $email->Body .= '</body></html>';
                    if (isset($joint) && count($joint) > 0) {
                        $file = [];
                        $index = 1;
                        foreach ($joint as $onpj) {
                            if ($onpj['path'] == "serveur") {
                                $file["file"] = ROOT . $onpj['content'];
                                $file["ext"] = explode(".", $onpj['content'])[1];
                                $mail->addAttachment($file["file"], $index . '.' . $file["ext"]);
                            } elseif ($onpj['path'] == "generate") {
                                $file["file"] = $this->views->exportToPdf($onpj['content'], $index, 'S');
                                $file["ext"] = "pdf";
                                $mail->addStringAttachment($file["file"], $index . '.' . $file["ext"]);
                            }
                            $index++;
                        }
                    }
                    return $mail->send();
                } catch (Exception $e) {
                    Utils::setMessageError([$e->getMessage()]);
                    Utils::redirect("error", "error");
                    return false;
                }
            }
        }
        return false;
    }

    private function setProcessing(&$item, &$indice, &$oneButtonKey, &$oneButtonElem, &$initTooltip, &$addClassCss, &$addAttribut, &$tooltip, &$classCss, &$attribut)
    {
        if (isset($oneButtonElem["champ"]) && isset($oneButtonElem["val"]))
            $oneButtonElem = $oneButtonElem["val"][$item[$oneButtonElem["champ"]]];
        if (isset($tooltip[$indice][$oneButtonKey])) {
            if (isset($tooltip[$indice][$oneButtonKey]["champ"]) && isset($tooltip[$indice][$oneButtonKey]["val"])) {
                $initTooltip = $tooltip[$indice][$oneButtonKey]["val"][$item[$tooltip[$indice][$oneButtonKey]["champ"]]];
                $initTooltip = (is_null($initTooltip)) ? '' : "title='" . $initTooltip . "' data-placement='top' data-toggle='tooltip'";
            } else
                $initTooltip = "title='" . $tooltip[$indice][$oneButtonKey] . "' data-placement='top' data-toggle='tooltip'";
        }
        if (isset($classCss[$indice][$oneButtonKey])) {
            if (isset($classCss[$indice][$oneButtonKey]["champ"]) && isset($classCss[$indice][$oneButtonKey]["val"])) {
                $addClassCss = $classCss[$indice][$oneButtonKey]["val"][$item[$classCss[$indice][$oneButtonKey]["champ"]]];
                $addClassCss = (is_null($addClassCss)) ? '' : str_replace("confirm", "confirm-modal ", $classCss[$indice][$oneButtonKey]);
            } else
                $addClassCss = $addClassCss = str_replace("confirm", "confirm-modal ", $classCss[$indice][$oneButtonKey]);
        }
        if (isset($attribut[$indice][$oneButtonKey])) {
            if (isset($attribut[$indice][$oneButtonKey]["champ"]) && isset($attribut[$indice][$oneButtonKey]["val"])) {
                $addAttribut = $attribut[$indice][$oneButtonKey]["val"][$item[$attribut[$indice][$oneButtonKey]["champ"]]];
                $addAttribut = (is_null($addAttribut)) ? '' : $attribut[$indice][$oneButtonKey];
            } else
                $addAttribut = $attribut[$indice][$oneButtonKey];
        }
    }
}