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

class AgenceController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model("agence");
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
                    ["agence/newAgence","agence/create","fa fa-edit"]
                ],
                "default" => [
                    ["champ"=>"etat","val"=>["Désactiver"=>["agence/activate","fa fa-toggle-off"],"Activer"=>["agence/deactivate","fa fa-toggle-on"]]],
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
                ["champ"=>"etat","val"=>["Désactiver"=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>". $this->lang['btn_desactiver'] ."</span>"],"Activer"=>["<span  class='temp text-success' >". $this->lang['btn_activer'] ."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[]
        ];
        $this->processing($this->model, "getList", $param);
    }


    public function newAgence__()
    {
        if($this->paramGET[2]) {
            $param = [
                "champs"=>["a.*", "r.libelle AS commune", "d.label AS dept", "c.label AS reg"],
                "jointure"=>[
                    "INNER JOIN commune r ON a.fk_commune = r.id", "INNER JOIN departement d ON d.rowid = r.fk_departement", "INNER JOIN region c ON c.rowid = d.fk_region"
                ],
                "condition"=>["a.rowid = "=>$this->paramGET[2]]
            ];
            $data['agence'] = $this->model->getAgence($param)[0];
            $data['regions'] = $this->model->getRegion();
            $data['dpts'] = $this->model->getDept();
            $data['coms'] = $this->model->getCom();
        }

        $data['region'] = $this->model->getRegion();
        $this->views->setData($data);
        $this->modal();
    }

    public function getDepartementByRegion()
    {
        $data['departement'] = $this->model->getDepartementByRegion($this->paramPOST);
        print_r(json_encode($data['departement'])) ;

    }

    public function getCommuneByDepartement()
    {
        $data['commune'] = $this->model->getCommuneByDepartement($this->paramPOST);
        print_r(json_encode($data['commune'])) ;

    }
    /**
     * @droit Créer Agence - 4
     */
    public function create()
    {
        //var_dump($this->paramPOST);die;
        if(Utils::validateMail($this->paramPOST["email"])) {

            $this->paramPOST['solde'] = 0;
            $this->paramPOST['user_crea'] = $this->_USER->id;
            $this->paramPOST['date_crea'] = date('Y-m-d H:i:s');
            $result = $this->model->insertAgence(["champs"=>$this->paramPOST]);
            if($result !== false) {
                $tab=["action"=>"Ajout agence", "commentaire"=>"Succès: Agence créée ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
                Utils::redirect("agence", "liste");
            }
            else {
                $tab=["action"=>"Ajout agence", "commentaire"=>"Echec: Agence créée ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
                Utils::redirect("agence", "liste");
            }
        }
        else {
            $tab=["action"=>"Ajout agence", "commentaire"=>"Echec: Adresse mail déjà existante","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["warning","email invalide"]);
            Utils::redirect("agence", "liste");
        }
    }

    /**
     * @droit Modifier Agence - 4
     */
    public function edit()
    {
        //var_dump($this->paramPOST);die;
        if(Utils::validateMail($this->paramPOST["email"])) {

            //$this->paramPOST['solde'] = 0;
            $this->paramPOST['user_modif'] = $this->_USER->id;
            $this->paramPOST['date_modif'] = date('Y-m-d H:i:s');
            $param['condition'] = ["rowid = "=>$this->paramPOST['id']];

            unset($this->paramPOST['id']);
            $param['champs'] = $this->paramPOST;
            $result = $this->model->updateAgence($param);
            if($result !== false) {
                $tab=["action"=>"Modification agence", "commentaire"=>"Succès: Agence modifée ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
                Utils::redirect("agence", "liste");
            }
            else {
                $tab=["action"=>"Modification agence", "commentaire"=>"Echec: Agence modifiée ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
                Utils::redirect("agence", "liste");
            }
        }
        else {
            $tab=["action"=>"Modification agence", "commentaire"=>"Echec: Adresse mail déjà existante","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["warning","email invalide"]);
            Utils::redirect("agence", "liste");
        }

    }

    /**
     * @droit Activer Agence - 4
     */
    public function activate()
    {
        if(intval($this->paramGET[0]) > 0)
        {
            $result = $this->model->set(["table" => "agence", "champs" => ["etat"=>"Activer"],"condition" => ["rowid = "=>$this->paramGET[0]]]);
            if($result !== false){
                $tab=["action"=>"Activation agence", "commentaire"=>"Succès: Agence activée ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success",$this->lang["success_active_agence"]]);
                Utils::redirect("agence", "liste");
            }

            else{
                $tab=["action"=>"Activation agence", "commentaire"=>"Echec: Agence activée ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger",$this->lang["echec_active_agence"]]);
                Utils::redirect("agence", "liste");
            }
        }
        else {
            $tab=["action"=>"Activation agence", "commentaire"=>"Echec: Pas de paramètres envoyés ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["danger",$this->lang["echec_active_agence"]]);
            Utils::redirect("agence", "liste");
        }
    }

    /**
     * @droit Désactiver Agence - 4
     */
    public function deactivate()
    {
        if(intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "agence", "champs" => ["etat"=>"Désactiver"],"condition" => ["rowid = "=>$this->paramGET[0]]]);
            if($result !== false){
                $tab=["action"=>"Désactivation agence", "commentaire"=>"Succès: Agence désactivée ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success",$this->lang["success_desactive_agence"]]);
                Utils::redirect("agence", "liste");

            }
            else{
                $tab=["action"=>"Désactivation agence", "commentaire"=>"Echec: Agence désactivée ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger",$this->lang["echec_desactive_agence"]]);
                Utils::redirect("agence", "liste");

            }
        }
        else{
            $tab=["action"=>"Activation agence", "commentaire"=>"Echec: Pas de paramètres envoyés ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["danger",$this->lang["echec_desactive_agence"]]);
            Utils::redirect("agence", "liste");
        }

    }
}