<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 21:11
 */

namespace app\controllers;

use app\core\BaseController;
use app\core\Session;
use app\core\Utils;

class PartenaireController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model("partenaire");
    }

    /**
     * @droit Lister Agence - 4
     */
    public function liste()
    {
        $this->views->getTemplate();
    }

    public function listeProcessing()
    {
        $param = [
            "button"=> [
                "modal" => [
                    ["partenaire/editPartner","partenaire/editPartnerModal","fa fa-edit"]
                ],
                "default" => [
                    ["champ" => "etat","val" => ["0" => ["partenaire/activate/","fa fa-toggle-off"],"1" => ["partenaire/deactivate/", "fa fa-toggle-on"]]],
                    //["utilisateur/detailUtilisateur","fa fa-search"]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [
                    $this->lang["tooltipModif"]
                ],
                "default" => [
                    ["champ"=>"etat","val"=>["Désactiver"=>$this->lang["tooltipActive"],"Activer"=>$this->lang["tooltipDesactive"]]],

                    $this->lang["detail"]
                ]
            ],
            "classCss"=> [
                "modal" => [],
                "default" => ["confirm"]
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>null,
            "dataVal"=>[
                ["champ" => "etat", "val" => ["0" => ["<i class='text-danger'>".$this->lang['desactiver']." </i>"], "1" => ["<i class='text-success'>".$this->lang['activer']."</i>"]]]

            ],
            "fonction"=>[]
        ];
        $this->processing($this->model, "getList", $param);
    }


    public function ajoutPartenaireModal__()
    {
        $this->modal();
    }


    /**
     * @droit Créer Partentaire - 4
     */
    public function ajoutPartenaire()
    {
        $this->paramPOST['user_creation'] = $this->_USER->id;
        $result = $this->model->insertPartenaire(["champs"=>$this->paramPOST]);
        //var_dump($result);die;
        if($result !== false) {
            Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            Utils::redirect("partenaire", "liste");
        }
        else {
            Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
            Utils::redirect("partenaire", "liste");
        }
    }


    /**
     * @droit Modifier Agence - 4
     */
    public function editPartner()
    {
        $data['partenaire'] = $this->model->getOnePartenaire(["condition" => ["id = " => $this->paramGET[2]]]);
        $this->views->setData($data);
        $this->modal();

    }

    public function updatePartenaire(){
        //var_dump();die;

        $data['condition'] = ["id = " => $this->paramPOST['id']];
        unset($this->paramPOST['id']);
        $data['champs'] = $this->paramPOST;
        $result = $this->model->updatePartenaire($data);

        //var_dump($result);die;
        if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_update_partenaire"]]);
        else Utils::setMessageALert(["danger",$this->lang["echec_update_partenaire"]]);
        Utils::redirect("partenaire", "liste");
    }

    /**
     * @droit Activer Agence - 4
     */
    public function activate()
    {
        if(intval($this->paramGET[0]) > 0)
        {
            if (intval($this->paramGET[0]) > 0) {
                $result = $this->model->updatePartenaire(["champs" => ["etat" => 1], "condition" => ["id = " => $this->paramGET[0]]]);
                if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_activate_partenaire"]]);
                else Utils::setMessageALert(["danger", $this->lang["echec_activate_partenaire"]]);
            } else Utils::setMessageALert(["danger", $this->lang["echec_activate_partenaire"]]);
            Utils::redirect("partenaire", "liste");
        }
    }

    /**
     * @droit Désactiver Agence - 4
     */
    public function deactivate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->model->updatePartenaire(["champs" => ["etat" => 0], "condition" => ["id = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["succes_desactivate_partenaire"]]);
            else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_partenaire"]]);
        } else Utils::setMessageALert(["danger", $this->lang["echec_desactivate_partenaire"]]);
        Utils::redirect("partenaire", "liste");

    }
}