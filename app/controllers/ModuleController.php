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

class ModuleController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model("module");
    }

    /**
     * @droit Liste module - 1
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
                    ["module/moduleModal","module/moduleModal","fa fa-edit"]
                ],
                "default" => [
                    ["module/deleteModule/","fa fa-trash"]
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

    public function moduleModal__()
    {
        if($this->paramGET[2]){
            $data['module'] = $this->model->getModule(["condition"=>["id = "=>$this->paramGET[2]]])[0];
            $this->views->setData($data);
        }
        $this->modal();
    }

    /**
     * @droit Ajouter module - 1
     */
    public function ajoutModule()
    {
        //parent::validateToken("exemples", "exemples");

        if(isset($this->paramPOST["module"])) {
            $result = $this->model->insertModule(["champs"=>$this->paramPOST]);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("module", "liste");
    }

    /**
     * @droit Modifier module - 1
     */
    public function modifModule()
    {
        //parent::validateToken("exemples", "exemples");

        if(isset($this->paramPOST["module"])) {
            $param['condition'] = ["id = "=>$this->paramPOST['id']];
            $param['champs'] = ["module ="=>$this->paramPOST["module"]];
            $result = $this->model->updateModule($param);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("module", "liste");
    }

    /**
     * @droit Supprimer module - 1
     */
    public function deleteModule()
    {
        //parent::validateToken("exemples", "exemples");

        if(isset($this->paramGET[0])) {
            $param['condition'] = ["id = "=>$this->paramGET[0]];
            $result = $this->model->deleteModule($param);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("module", "liste");
    }
}