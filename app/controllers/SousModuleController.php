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

class sousModuleController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model("sousModule");
    }
    /**
     * @droit Liste sous module - 2
     */
    public function liste()
    {
        $this->views->getTemplate();
    }

    public function listeProcessing__()
    {
        $param = [
            "button"=> [
                "modal" => [
                    ["sousModule/sousModuleModal","sousModule/sousModuleModal","fa fa-edit"]
                ],
                "default" => [
                    ["sousModule/deleteSousModule/","fa fa-trash"]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [
                    $this->lang["tooltipModif"]
                ],
                "default" => [
                    $this->lang["remove"]
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
                ["champ"=>"etat","val"=>["Désactiver"=>["<span style='.temp::before{text-align: right;}' class='temp text-danger'>". $this->lang['btn_desactiver'] ."</span>"],"Activer"=>["<span  class='temp text-success' >". $this->lang['btn_activer'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[]
        ];
        $this->processing($this->model, "getListeProcess", $param);
    }


    public function sousModuleModal__()
    {
        if($this->paramGET[2])
            $data['sousModule'] = $this->model->getSousModule(["condition"=>["id = "=>$this->paramGET[2]]])[0];
        $data['module'] = $this->model->get(["table"=>"module"]);
        $this->views->setData($data);
        $this->modal();
    }

    /**
     * @droit Ajouter sous module - 2
     */
    public function ajoutSousModule()
    {
        //parent::validateToken("exemples", "exemples");

        $result = $this->model->insertSousModule(["champs"=>$this->paramPOST]);
        if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
        else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);

        Utils::redirect("sousModule", "liste");
    }

    /**
     * @droit Modifier sous module - 2
     */
    public function modifSousModule()
    {
        //parent::validateToken("exemples", "exemples");

        //var_dump($this->paramPOST);die;

        $param['condition'] = ["id = "=>$this->paramPOST['id']];
        $param['champs'] = ["fk_module ="=>$this->paramPOST["fk_module"],"sous_module ="=>$this->paramPOST["sous_module"]];
        $result = $this->model->updateSousModule($param);
        if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
        else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);

        Utils::redirect("sousModule", "liste");
    }

    /**
     * @droit Supprimer sous module - 2
     */
    public function deleteSousModule()
    {
        //parent::validateToken("exemples", "exemples");

        if(isset($this->paramGET[0])) {
            $param['condition'] = ["id = "=>$this->paramGET[0]];
            $result = $this->model->deleteSousModule($param);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("sousModule", "liste");
    }
}