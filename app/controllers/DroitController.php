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

class DroitController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model("droit");
    }

    public function liste()
    {
        Utils::setDefaultSort(2, "ASC");
        $this->views->getTemplate();
    }

    public function listeProcessing()
    {
        $param = [
            "button"=> [
                "modal" => [
                    ["droit/droitModal","droit/droitModal","fa fa-edit"]
                ],
                "default" => [
                    ["droit/deleteDroit/","fa fa-trash"]
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
                ["champ"=>"etat","val"=>["Désactiver"=>["<span style='.temp::before{text-align: right;}' class='temp text-danger'>Désactiver</span>"],"Activer"=>["<span  class='temp text-success' >Activer</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[]
        ];
        $this->processing($this->model, "getListeProcess", $param);
    }

    public function droitModal()
    {
        if($this->paramGET[2])
            $data['droit'] = $this->model->getDroit(["condition"=>["id = "=>$this->paramGET[2]]])[0];
        $data['sousModule'] = $this->model->get(["table"=>"sous_module"]);
        $this->views->setData($data);
        $this->modal();
    }

    public function ajoutDroit()
    {
        //parent::validateToken("exemples", "exemples");

        $result = $this->model->insertDroit(["champs"=>$this->paramPOST]);
        if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
        else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);

        Utils::redirect("droit", "liste");
    }

    public function modifDroit()
    {
        //parent::validateToken("exemples", "exemples");

        $param['condition'] = ["id = "=>$this->paramPOST['id']];
        $param['champs'] = [
            "droit ="=>$this->paramPOST["droit"],
            "fk_sous_module ="=>$this->paramPOST["fk_sous_module"],
            "controller ="=>$this->paramPOST["controller"],
            "action ="=>$this->paramPOST["action"]
        ];
        $result = $this->model->updateDroit($param);
        if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
        else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);

        Utils::redirect("droit", "liste");
    }

    public function deleteDroit()
    {
        //parent::validateToken("exemples", "exemples");

        if(isset($this->paramGET[0])) {
            $param['condition'] = ["id = "=>$this->paramGET[0]];
            $result = $this->model->deleteDroit($param);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
        }
        Utils::redirect("droit", "liste");
    }
}