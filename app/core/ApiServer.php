<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 17/08/2017
 * Time: 11:01
 */

namespace app\core;

use app\controllers\WebserviceClientController;
use Jacwright\RestServer\RestServer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

abstract class ApiServer
{
    protected $serv;
    protected $apiClient;
    protected $appConfig;
    protected $token;
    protected $data;
    protected static $paramGET  = [];
    protected static $paramPOST = [];
    protected static $paramFILE = [];

    public function __construct($type = null)
    {
        $this->token = $_SERVER['HTTP_AUTHORIZATION_TOKEN'];
        $this->appConfig = (object)\parse_ini_file(ROOT . 'config/app.config.ini');
        if($this->appConfig->use_api_client == "1") $this->apiClient = new WebserviceClientController();
        if($type == null) {
            try{
                $mode = (ENV == "PROD") ? 'production' : 'debug';
                $this->serv = new RestServer($mode);
                $_GET['format'] = "json";
            }catch(\Exception $ex) {
                $this->serv->setStatus(500);
                $this->serv->sendData(['error' => ['code' => 500, 'message' => 'Internal Server Error']]);
            }
        }
    }

    /**
     * @param null $data
     */
    public function setData($data)
    {
        if(!is_array($this->data)) $this->data = (is_null($this->data)) ? [] : [$this->data];
        $this->data = (!is_array($data)) ? array_merge($this->data,[$data]) : array_merge($this->data,$data);
    }

    /**
     * @param $class
     * @return string
     */
    public function setClass($class)
    {
        $class = explode("::", $class)[1];
        return "app\webservice\\".$class;
    }

    /**
     * @param $patch
     * @return string
     */
    public function setPatch($patch)
    {
        $patch = explode("::", $patch)[1];
        return "webserviceServer/".$patch;
    }

    /**
     * @param mixed $paramGET
     */
    public function setParamGET($paramGET)
    {
        unset($paramGET[0]);
        self::$paramGET = $paramGET;
    }

    /**
     * @param mixed $paramPOST
     */
    public function setParamPOST($paramPOST)
    {
        self::$paramPOST = $paramPOST;
        unset($_POST);
    }

    /**
     * @param mixed $paramFILE
     */
    public function setParamFILE($paramFILE)
    {
        self::$paramFILE = $paramFILE;
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
     * @param $page
     * @param null $namePDF
     * @param string $output
     * @return bool|string
     */
    public function exportToPdf($page, $namePDF = null, $output = 'I')
    {
        if(count($this->data) > 0) extract($this->data);

        if(file_exists(ROOT . Prefix_View . $page . '.php')){
            ob_start();
            include(ROOT . Prefix_View . $page . '.php');
            $content = ob_get_clean();
        }else  $content = $page;

        if(count($this->data) > 0) extract($this->data);

        $namePDF = ($namePDF === null) ? (explode("/",$page)[1]) : $namePDF;

        try {
            $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', 0);
            $html2pdf->setDefaultFont('Times');
            $html2pdf->writeHTML($content);
            return $html2pdf->Output($namePDF.'.pdf',$output);
        }
        catch(Html2PdfException $e)
        {
            Utils::setMessageError([$e->getMessage()]);
            Utils::redirect("error","error", [], "default");
            return false;
        }
    }

    protected function sendMail(array $param)
    {
        if(count($param) > 0) {
            extract($param);
            if(isset($subject) && isset($content) && isset($email)) {
                try {
                    if(isset($data)) extract($data);
                    $mail = new PHPMailer();
                    $mail->SetLanguage(Session::getAttribut('lang'));
                    $mail->CharSet = 'UTF-8';
                    $mail->isHTML(true);
                    $mail->setFrom($this->appConfig->mail_from);
                    $mail->addAddress($email);
                    $mail->Subject = $subject;
                    $email->Body = '<html><head><meta charset="utf-8"></head><body>';
                    if(file_exists(ROOT . Prefix_View . $content . '.php')){
                        ob_start();
                        include(ROOT . Prefix_View . $content . '.php');
                        $mail->Body .= ob_get_clean();
                    }else $mail->Body .= $content;
                    $email->Body .= '</body></html>';
                    if (isset($joint) && count($joint) > 0) {
                        $file = [];
                        $index = 1;
                        foreach ($joint as $onpj) {
                            if($onpj['path'] == "serveur") {
                                $file["file"] = ROOT.$onpj['content'];
                                $file["ext"]  = explode(".",$onpj['content'])[1];
                                $mail->addAttachment($file["file"], $index.'.'.$file["ext"]);
                            } elseif($onpj['path'] == "generate") {
                                $file["file"] = $this->exportToPdf($onpj['content'],$index, 'S');
                                $file["ext"]  = "pdf";
                                $mail->addStringAttachment($file["file"], $index.'.'.$file["ext"]);
                            }
                            $index++;
                        }
                    }
                    return $mail->send();
                }catch(Exception $e) {
                    return $e->getMessage();
                }
            }
        }
        return false;
    }

}