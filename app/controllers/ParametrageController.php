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

class ParametrageController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model("parametrage");
    }

    
    public function liste()
    {
        $this->views->getTemplate();
    }

    public function listeProcessing()
    {
        $param = [
            "button" => [
                "modal" => [
                    ["parametrage/newParametrage", "parametrage/create", "fa fa-edit"]
                ],
                "default" => [
                    ["champ" => "etat", "val" => ["Désactiver" => ["parametrage/activate", "fa fa-toggle-off"], "Activer" => ["parametrage/deactivate", "fa fa-toggle-on"]]],
                    //["utilisateur/detailUtilisateur","fa fa-search"]
                ],
                "custom" => []
            ],
            "tooltip" => [
                "modal" => [
                    "Modifier"
                ],
                "default" => [
                    ["champ" => "etat", "val" => ["Désactiver" => "Activer", "Activer" => "Desactiver"]],
                    "Détail"
                ]
            ],
            "classCss" => [
                "modal" => [],
                "default" => ["confirm"]
            ],
            "attribut" => [
                "modal" => [],
                "default" => []
            ],
            "args" => null,
            "dataVal" => [
                ["champ" => "etat", "val" => ["Désactiver" => ["<span style='.temp::before{text-align: right;}' class='temp text-danger'>". $this->lang['btn_desactiver'] ."</span>"], "Activer" => ["<span  class='temp text-success' >". $this->lang['btn_activer'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction" => []
        ];
        $this->processing($this->model, "getList", $param);
    }

    public function newParametrage()
    {
        if ($this->paramGET[2]) {
            $param = [
                "champs" => ["a.*", "r.label as region"],
                "jointure" => [
                    "INNER JOIN region r ON a.fk_region = r.rowid"],
                "condition" => ["a.rowid = " => $this->paramGET[2]]
            ];
            $data['parametrage'] = $this->model->getParametrage($param)[0];
        }
        $param = [
            "table" => "region"
        ];
        $data['region'] = $this->model->get($param);
        $this->views->setData($data);
        $this->modal();
    }


    public function create()
    {

        //$this->paramPOST['etat'] = 1;
        //$this->paramPOST['user_crea'] = $this->_USER->id;
        //$this->paramPOST['date_crea'] = date('Y-m-d H:i:s');
        //var_dump($this->paramPOST);die;
        $result = $this->model->insertParametrage(["champs" => $this->paramPOST]);
        if ($result !== false) {
            Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
        } else Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
        Utils::redirect("parametrage", "liste");
    }


    public function edit()
    {
        //$this->paramPOST['solde'] = 0;
        //$this->paramPOST['user_modif'] = $this->_USER->id;
        //$this->paramPOST['date_modif'] = date('Y-m-d H:i:s');
        $param['condition'] = ["rowid = " => $this->paramPOST['id']];

        unset($this->paramPOST['id']);
        $param['champs'] = $this->paramPOST;
        $result = $this->model->updateParametrage($param);
        if ($result !== false) {
            Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
        } else Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
        Utils::redirect("parametrage", "liste");
    }

    public function activate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "parametrage", "champs" => ["etat" => "Activer"], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
        } else Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
        Utils::redirect("parametrage", "liste");
    }


    public function deactivate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "parametrage", "champs" => ["etat" => "Désactiver"], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false) Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
        } else Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
        Utils::redirect("parametrage", "liste");
    }
}