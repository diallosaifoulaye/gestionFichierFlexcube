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

class AdministrationController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model("admin");
    }

    //--------------------------REGION CRUD


    /**
     * @droit Liste régions - 7
     */
    public function listeRegion(){

        //echo'<pre>', var_dump('teste');
        //echo'<pre>', var_dump(phpinfo());die;
        $this->views->getTemplate('admin/listeRegion');
    }

    public function julien__(){
        $julien = 120203 ;
        echo $this->julien2Gregorien($julien) ;
    }
    function est_bissextile($annee)
    {
        return date("m-d", strtotime("$annee-02-29")) == "02-29";
    }
    public function julien2Gregorien($julien){
        try{
            if (strlen($julien) != 6)
                throw new \Exception("La date doit exactement comporter 6 caractées et non ".strlen($julien)) ;
            $anneeJulien = intval(substr($julien, 0, 3)) ;
            $jourJulien = intval(substr($julien, 3, 3)) ;
            $anneeFinal = $anneeJulien + 1900 ;
            $moisFevrier = ($this->est_bissextile($anneeFinal)) ? 29 : 28 ;
            $tabMois = ["1"=>"31","2"=>$moisFevrier,"3"=>"31","4"=>"30","5"=>"31","6"=>"30","7"=>"31","8"=>"31","9"=>"30","10"=>"31","11"=>"30","12"=>"31"];

            $isMoisTrouve = false ;
            $moisFinal = 1 ;
            $jourFinal = 1 ;
            while(!$isMoisTrouve){
                $jour = intval($tabMois[$moisFinal]) ;
                if ($jour < $jourJulien){
                    $jourJulien = $jourJulien - $jour ;
                    $moisFinal ++ ;
                }else{
                    $isMoisTrouve = true ;
                    $jourFinal = $jourJulien ;
                }
            }

            $strMois = str_pad($moisFinal, 2, "0", STR_PAD_LEFT) ;
            $strJour = str_pad($jourFinal, 2, "0", STR_PAD_LEFT) ;

            return $strJour."/".$strMois."/".$anneeFinal ;


        }catch (\Exception $e){
            echo $e->getMessage() ;
        }

       return null ;
    }

    public function regionProcessing__(){

        $param = [
            "button"=> [
                "modal" => [
                    ["administration/regionModal","admin/regionModal","fa fa-edit"]
                ],
                "default" => [
                    ["champ"=>"etat","val"=>["Désactiver"=>["administration/activateRegion","fa fa-toggle-off"],"Activer"=>["administration/disableRegion","fa fa-toggle-on"]]],
                    //["utilisateur/detailUtilisateur","fa fa-search"]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [
                    $this->lang["tooltipModif"]
                ],
                "default" => [
                    ["champ"=>"etat","val"=>["Désactiver"=>$this->lang["tooltipActive"]."e","Activer"=>$this->lang["tooltipDesactive"]."e"]],
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
                ["champ"=>"etat","val"=>["Désactiver"=>["<span style='.temp::before{text-align: right;}' class='temp text-danger'>".$this->lang["tooltipDesactive"]."e"."</span>"],"Activer"=>["<span  class='temp text-success' >".$this->lang["tooltipActive"]."</span><style>.temp::before{text-align: right;}</style>"]]]

        ],
            "fonction"=>[]
        ];
        /* if($this->appConfig->profile_level == 2)
             array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->model, "getRegionProcess", $param);

    }

    /**
     * @droit Activer régions - 7
     */
    public function activateRegion()
    {
        if(intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "region", "champs" => ["etat"=>"Activer"],"condition" => ["rowid = "=>$this->paramGET[0]]]);
            if($result !== false){
                $tab=["action"=>"Activation region ", "commentaire"=>"Succès: Région activée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success",$this->lang["succesactiveregion"]]);
            }


            else
                {
                    $tab=["action"=>"Activation region ", "commentaire"=>"Echec: Région non active","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                    $this->model->logsUser(["champs"=>$tab]);
                    Utils::setMessageALert(["danger",$this->lang["echecactiveregion"]]);
            }

        }
        else {
            Utils::setMessageALert(["danger",$this->lang["echecactiveregion"]]);
            Utils::redirect("administration", "listeRegion");
        }

    }

    /**
     * @droit Désactiver régions - 7
     */
    public function disableRegion()
    {
        if(intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "region", "champs" => ["etat"=>"Désactiver"],"condition" => ["rowid = "=>$this->paramGET[0]]]);
            if($result !== false){
                $tab=["action"=>"Désactivation region ", "commentaire"=>"Succès: Région désactivée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success",$this->lang["succesdesactiveregion"]]);
            }

            else {
                $tab=["action"=>"Désactivation region", "commentaire"=>"Echec: Région non désactivée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger",$this->lang["echecdesactiveregion"]]);
            }

        }
        else Utils::setMessageALert(["danger",$this->lang["echecdesactiveregion"]]);
        Utils::redirect("administration", "listeRegion");
    }

    public function regionModal__()
    {
        if($this->paramGET[2]) {
            $param = [
                "champs"=>["*"],
                "condition"=>["rowid = "=>$this->paramGET[2]]
            ];
            $data['region'] = $this->model->getOneRegion($param)[0];
            $this->views->setData($data);
        }
        $this->modal();
    }

    /**
     * @droit Ajouter région - 7
     */
    public function ajoutRegion()
    {
        //parent::validateToken("exemples", "exemples");

        //if(Utils::validateMail($this->paramPOST["label"])) {
            $result = $this->model->insertRegion(["champs"=>$this->paramPOST]);
            if($result !== false) {
                $tab=["action"=>"Ajout region", "commentaire"=>"Succès: Région ajoutée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            }
            else{
                $tab=["action"=>"Ajout region", "commentaire"=>"Echec: Région non ajoutée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
                Utils::redirect("administration", "listeRegion");
            }

    }

    /**
     * @droit Modifier région - 7
     */
    public function modifRegion()
    {
        //parent::validateToken("exemples", "exemples");

        $param['condition'] = ["rowid = "=>$this->paramPOST['id']];
        $param['champs'] = [
            "label"=>$this->paramPOST["label"]
        ];
        $result = $this->model->updateRegion($param);
        if($result !== false)
        {
            $tab=["action"=>"Modification region", "commentaire"=>"Succès: Région modifiée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            Utils::redirect("administration", "listeRegion");
        }

        else
        {
            $tab=["action"=>"Modification region", "commentaire"=>"Succès: Région non modifiée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
            Utils::redirect("administration", "listeRegion");
        }



    }

    //--------------------------DEPARTEMENT CRUD

    /**
     * @droit Liste département - 8
     */
    public function listeDept(){
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar"]);
        $this->views->getTemplate('admin/listeDepartement');
    }

    public function deptProcessing__()
    {
        $param = [
            "button"=> [
                "modal" => [
                    ["administration/deptModal","admin/departementModal","fa fa-edit"]
                ],
                "default" => [
                    ["champ"=>"etat","val"=>["Désactiver"=>["administration/activateDept","fa fa-toggle-off"],"Activer"=>["administration/disableDept","fa fa-toggle-on"]]],
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
                    $this->lang["lesDetails"]
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
                ["champ"=>"etat","val"=>["Désactiver"=>["<span style='.temp::before{text-align: right;}' class='temp text-danger'>".$this->lang["tooltipDesactive"]."</span>"],"Activer"=>["<span  class='temp text-success' >".$this->lang["tooltipActive"]."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[]
        ];
       /* if($this->appConfig->profile_level == 2)
            array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->model, "getDeptProcess", $param);
    }

    /**
     * @droit Activer département - 8
     */
    public function activateDept()
    {
        if(intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "departement", "champs" => ["etat"=>"Activer"],"condition" => ["rowid = "=>$this->paramGET[0]]]);
            if($result !== false)
            {
                $tab=["action"=>"Activation département", "commentaire"=>"Succès: département activé","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success",$this->lang["success_active_depart"]]);
            }


            else
                {
                    $tab=["action"=>"Activation département", "commentaire"=>"Echec: département non activé","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                    $this->model->logsUser(["champs"=>$tab]);
                    Utils::setMessageALert(["danger",$this->lang["echec_active_depart"]]);
                }

        }
        else Utils::setMessageALert(["danger",$this->lang["echec_active_depart"]]);
        Utils::redirect("administration", "listeDept");
    }

    /**
     * @droit Désactiver département - 8
     */
    public function disableDept()
    {
        if(intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "departement", "champs" => ["etat"=>"Désactiver"],"condition" => ["rowid = "=>$this->paramGET[0]]]);
            if($result !== false)
            {
                $tab=["action"=>"Désactivation departement", "commentaire"=>"Succès: département désactivé","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success",$this->lang["success_desactive_depart"]]);

            }

            else
            {
                $tab=["action"=>"Désactivation département", "commentaire"=>"Echec: département non désactivé","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger",$this->lang["echec_desactive_depart"]]);
            }

        }
        else Utils::setMessageALert(["danger",$this->lang["echec_desactive_depart"]]);
        Utils::redirect("administration", "listeDept");
    }

    public function deptModal__()
    {
        if($this->paramGET[2]) {
            $param = [
                "champs"=>["*"],
                "condition"=>["rowid = "=>$this->paramGET[2]]
            ];
            $data['departement'] = $this->model->getOneDept($param)[0];
        }
        $param = [
            "table"=>"region"
        ];
        $data['region'] = $this->model->get($param);
        $this->views->setData($data);
        $this->modal();
    }

    /**
     * @droit Ajouter département - 8
     */
    public function ajoutDept()
    {
        //parent::validateToken("exemples", "exemples");

       // if(Utils::validateMail($this->paramPOST["label"])) {
            $result = $this->model->insertDept(["champs"=>$this->paramPOST]);
            if($result !== false)
            {
                $tab=["action"=>"Ajout département", "commentaire"=>"Succès: département ajotué","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
                Utils::redirect("administration", "listeDept");
            }
            else
            {
                $tab=["action"=>"Ajout département", "commentaire"=>"Echec: département non ajotué","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
                Utils::redirect("administration", "listeDept");
            }


    }

    /**
     * @droit Modifier département - 8
     */
    public function modifDept()
    {
        //parent::validateToken("exemples", "exemples");

        $param['condition'] = ["rowid = "=>$this->paramPOST['id']];
        $param['champs'] = [
            "label"=>$this->paramPOST["label"],
            "fk_region"=>$this->paramPOST["fk_region"]
        ];
        $result = $this->model->updateDept($param);
        if($result !== false)
        {
            $tab=["action"=>"Modification département", "commentaire"=>"Succès: département modifié","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            Utils::redirect("administration", "listeDept");

        }

        else
        {
            $tab=["action"=>"Modification département", "commentaire"=>"Echec: département non modifié","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
            Utils::redirect("administration", "listeDept");


        }

    }

    //--------------------------COMMUNE CRUD

    /**
     * @droit Liste des communes - 9
     */
    public function listeCom(){
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar"]);
        $this->views->getTemplate('admin/listeCommune');
    }

    public function comProcessing__()
    {
        $param = [
            "button"=> [
                "modal" => [
                    ["administration/comModal","admin/communeModal","fa fa-edit"]
                ],
                "default" => [
                    ["champ"=>"etat","val"=>["Désactiver"=>["administration/activateCom","fa fa-toggle-off"],"Activer"=>["administration/disableCom","fa fa-toggle-on"]]],
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
                ["champ"=>"etat","val"=>["Désactiver"=>["<span style='.temp::before{text-align: right;}' class='temp text-danger'>".$this->lang["tooltipDesactive"]."</span>"],"Activer"=>["<span  class='temp text-success' >".$this->lang["tooltipActive"]."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[]
        ];
       /* if($this->appConfig->profile_level == 2)
            array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->model, "getComProcess", $param);
    }

    /**
     * @droit Activer commune - 9
     */
    public function activateCom()
    {
        if(intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "commune", "champs" => ["etat"=>"Activer"],"condition" => ["id = "=>$this->paramGET[0]]]);
            if($result !== false)
            {
                $tab=["action"=>"Activation commune", "commentaire"=>"Succès: commune activé","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success",$this->lang["success_active_commune"]]);
                Utils::redirect("administration", "listeCom");
            }
            else
            {
                $tab=["action"=>"Activation commune", "commentaire"=>"Echec: commune non activé ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger",$this->lang["echec_active_commune"]]);
                Utils::redirect("administration", "listeCom");
            }
        }
        else
        {
            Utils::setMessageALert(["danger",$this->lang["echec_active_commune"]]);
            Utils::redirect("administration", "listeCom");

        }
    }

    /**
     * @droit Désactiver commune - 9
     */
    public function disableCom()
    {
        if(intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "commune", "champs" => ["etat"=>"Désactiver"],"condition" => ["id = "=>$this->paramGET[0]]]);
            if($result !== false)
            {
                $tab=["action"=>"Désactivation commune", "commentaire"=>"Succès: commune désactivée ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success",$this->lang["success_desactive_commune"]]);
                Utils::redirect("administration", "listeCom");
            }
            else
            {
                $tab=["action"=>"Désactivation commune", "commentaire"=>"Echec: commune non désactivée ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger",$this->lang["echec_desactive_commune"]]);
                Utils::redirect("administration", "listeCom");
            }
        }
        else
            Utils::setMessageALert(["danger",$this->lang["echec_desactive_commune"]]);
        Utils::redirect("administration", "listeCom");
    }

    public function comModal__()
    {
        if($this->paramGET[2]) {
            $param = [
                "champs"=>["*"],
                "condition"=>["id = "=>$this->paramGET[2]]
            ];
            $data['commune'] = $this->model->getOneCom($param)[0];
        }
        $param = [
            "table"=>"departement"
        ];
        $data['departement'] = $this->model->get($param);
        $this->views->setData($data);
        $this->modal();
    }

    /**
     * @droit Ajouter commune - 9
     */
    public function ajoutCom()
    {
        //parent::validateToken("exemples", "exemples");

       // if(Utils::validateMail($this->paramPOST["label"])) {
            $result = $this->model->insertCom(["champs"=>$this->paramPOST]);
            if($result !== false)
            {
                $tab=["action"=>"Ajout commune", "commentaire"=>"Succès: commune ajoutée ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
                Utils::redirect("administration", "listeCom");

            }
            else
            {
                $tab=["action"=>"Ajout commune", "commentaire"=>"Echec: commune non ajoutée ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
                Utils::redirect("administration", "listeCom");

            }

    }

    /**
     * @droit Modifier commune - 9
     */
    public function modifCom()
    {
        //parent::validateToken("exemples", "exemples");

        $param['condition'] = ["id = "=>$this->paramPOST['id']];
        $param['champs'] = [
            "libelle"=>$this->paramPOST["libelle"],
            "fk_departement"=>$this->paramPOST["fk_departement"]
        ];
        $result = $this->model->updateCom($param);
        if($result !== false)
        {
            $tab=["action"=>"Modification commune", "commentaire"=>"Succès: commune modifiée ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            Utils::redirect("administration", "listeCom");

        }
        else
        {
            $tab=["action"=>"Modification commune", "commentaire"=>"Echec: commune non modifiée ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
            Utils::redirect("administration", "listeCom");
        }

    }

    //--------------------------DEVISE CRUD

    /**
     * @droit Liste devise - 10
     */
    public function listeDevise()
    {
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar"]);
        $this->views->getTemplate('admin/liste');
    }

    public function listeProcessing__()
    {
        $param = [
            "button" => [
                "modal" => [
                    ["administration/newParametrage", "admin/create", "fa fa-edit"]
                ],
                "default" => [
                    ["champ" => "etat", "val" => ["Désactiver" => ["administration/activate", "fa fa-toggle-off"], "Activer" => ["administration/deactivate", "fa fa-toggle-on"]]],
                    //["utilisateur/detailUtilisateur","fa fa-search"]
                ],
                "custom" => []
            ],
            "tooltip" => [
                "modal" => [
                    $this->lang["tooltipModif"]
                ],
                "default" => [
                    ["champ"=>"etat","val"=>["Désactiver"=>$this->lang["tooltipActive"],"Activer"=>$this->lang["tooltipDesactive"]]],
                    $this->lang["detail"]
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
                ["champ"=>"etat","val"=>["Désactiver"=>["<span style='.temp::before{text-align: right;}' class='temp text-danger'>".$this->lang["tooltipDesactive"]."</span>"],"Activer"=>["<span  class='temp text-success' >".$this->lang["tooltipActive"]."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction" => []
        ];
        $this->processing($this->model, "getList", $param);
    }

    public function newParametrage__()
    {
        if($this->paramGET[2]) {
            $param = [
                "champs" => ["*"],
                "condition" => ["rowid = " => $this->paramGET[2]]
            ];
            $data['parametrage'] = $this->model->getParametrage($param)[0];
            $this->views->setData($data);
        }
        $this->modal();
    }

    /**
     * @droit Ajouter devise - 10
     */
    public function create()
    {
        $result = $this->model->insertParametrage(["champs" => $this->paramPOST]);
        if ($result !== false) {
            $tab=["action"=>"Ajout devise", "commentaire"=>"Succès: devise ajouté ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
            Utils::redirect("administration", "listeDevise");
        }
        else
        {
            $tab=["action"=>"Ajout devise", "commentaire"=>"Echec: devise non ajouté ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
            Utils::redirect("administration", "listeDevise");
        }

    }

    /**
     * @droit Modifier devise - 10
     */
    public function edit()
    {
        $param['condition'] = ["rowid = " => $this->paramPOST['id']];
        unset($this->paramPOST['id']);
        $param['champs'] = $this->paramPOST;
        $result = $this->model->updateParametrage($param);
        if ($result !== false)
        {
            $tab=["action"=>"Modification devise", "commentaire"=>"Succès: devise modifié ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
            Utils::redirect("administration", "listeDevise");
        }
        else
        {
            $tab=["action"=>"Modification devise", "commentaire"=>"Echec: devise non modifié ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
            Utils::redirect("administration", "listeDevise");
        }

    }

    /**
     * @droit Activer devise - 10
     */
    public function activate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "parametrage", "champs" => ["etat" => "Activer"], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false)
            {
                $tab=["action"=>"Activation devise", "commentaire"=>"Succès: devise activé ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
                Utils::redirect("administration", "listeDevise");

            }
            else
            {
                $tab=["action"=>"Activation devise", "commentaire"=>"Echec: devise non activé ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
                Utils::redirect("administration", "listeDevise");

            }
        }
        else
        {
            Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
            Utils::redirect("administration", "listeDevise");
        }

    }

    /**
     * @droit Désactiver devise - 10
     */
    public function deactivate()
    {
        if (intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "parametrage", "champs" => ["etat" => "Désactiver"], "condition" => ["rowid = " => $this->paramGET[0]]]);
            if ($result !== false)
            {
                $tab=["action"=>"Désactivation devise", "commentaire"=>"Succès: devise désactivé ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
                Utils::redirect("administration", "listeDevise");
            }

            else
            {
                $tab=["action"=>"Désactivation devise", "commentaire"=>"Echec: devise non désactivé ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
                Utils::redirect("administration", "listeDevise");
            }
        }
        else
        {
            Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
            Utils::redirect("administration", "listeDevise");
        }


    }


    public function listeHours(){
        $this->views->getTemplate('admin/listeHours');
    }

    public function hoursProcessing__()
    {
        $param = [
            "button" => [
                "modal" => [
                    ["administration/editHours", "admin/hourModal", "fa fa-edit"]
                ],
//                "default" => [
//                    ["champ" => "etat", "val" => ["Désactiver" => ["administration/activate", "fa fa-toggle-off"], "Activer" => ["administration/deactivate", "fa fa-toggle-on"]]],
//                    //["utilisateur/detailUtilisateur","fa fa-search"]
//                ],
                "custom" => []
            ],
//            "tooltip" => [
//                "modal" => [
//                    "Modifier"
//                ],
//                "default" => [
//                    ["champ" => "etat", "val" => ["Désactiver" => "Activer", "Activer" => "Desactiver"]],
//                    "Détail"
//                ]
//            ],
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
                ["champ"=>"etat","val"=>["Désactiver"=>["<span style='.temp::before{text-align: right;}' class='temp text-danger'>".$this->lang["tooltipDesactive"]."</span>"],"Activer"=>["<span  class='temp text-success' >".$this->lang["tooltipActive"]."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction" => []
        ];
        $this->processing($this->model, "getListHours", $param);
    }

    public function editHours__()
    {
        if($this->paramGET[2]) {
            $param = [
                "champs" => ["*"],
                "condition" => ["rowid = " => $this->paramGET[2]]
            ];
            $hour = $this->model->getOneHour($param)[0];
            //echo'<pre>', var_dump($hour);die;
            $this->views->setData($hour);
        }
        $this->modal();
    }

    /**
     * @droit Liste des actions - 6
     */
    public function suiviListe()
    {
        if (isset($this->paramPOST["datedebut"]) & isset($this->paramPOST["datefin"])) {
            $param['datedebut'] = $this->paramPOST['datedebut'];
            $param['datefin'] = $this->paramPOST['datefin'];
        }else{

            $param['datedebut'] = date('Y-m-d');
            $param['datefin'] = date('Y-m-d');
        }

        $this->views->setData($param);
        $this->views->getTemplate('admin/listeSuivi');
    }

    /**
     *
     */
    public function actionProcessing__(){
        $param = [
            "button"=> [
                "modal" => [
                    //["champ"=>"_flag_","val"=>[0=>["carte/receptionModal","gestioncarte/receptionModal","fa fa-edit"],1=>[]]],


                ],
                "default" => [
                   // ["carte/detailCarteReception","fa fa-search"]
                    //["champ"=>"etat","val"=>["Désactiver"=>["administration/activateDept","fa fa-toggle-off"],"Activer"=>["administration/disableDept","fa fa-toggle-on"]]],
                    //["utilisateur/detailUtilisateur","fa fa-search"]
                ],
                "custom" => []
            ],
            "tooltip"=> [
               /* "modal" => [
                    "Modifier"
                ],
                "default" => [
                    $this->lang["detail"]
                ]*/
            ],
            "classCss"=> [
                "modal" => [],
                //"default" => ["confirm"]
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>$this->paramGET,
            "dataVal"=>[
                // ["champ"=>"etat","val"=>["Désactiver"=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>Désactiver</span>"],"Activer"=>["<span  class='temp text-success' >Activer</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                'date'=>'getDateFR',
                //'dateExp'=>'getMoisAnnee',
            ]
        ];
        $this->processing($this->model, "getActionProcess", $param);
    }



    public function dictionnaire(){
        $this->views->getTemplate('admin/dictionnaire');
    }


    public function dictionnaireProcessing__(){

        $param = [
            "button"=> [
                "modal" => [
                    ["administration/dictionnaireModal","admin/dictionnaireModal","fa fa-edit"]
                ],
                "default" => [
                    ["champ"=>"etat","val"=>[0=>["administration/activateDictionnaire","fa fa-toggle-off"],1=>["administration/disableDictionnaire","fa fa-toggle-on"]]],
                    //["utilisateur/detailUtilisateur","fa fa-search"]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [
                    $this->lang["tooltipModif"]
                ],
                "default" => [
                    ["champ"=>"etat","val"=>[0=>$this->lang["tooltipActive"]."e",1=>$this->lang["tooltipDesactive"]."e"]],
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
                ["champ"=>"etat","val"=>[0=>["<span style='.temp::before{text-align: right;}' class='temp text-danger'>".$this->lang["tooltipDesactive"]."e"."</span>"],1=>["<span  class='temp text-success' >".$this->lang["tooltipActive"]."</span><style>.temp::before{text-align: right;}</style>"]]]

            ],
            "fonction"=>[]
        ];
        /* if($this->appConfig->profile_level == 2)
             array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->model, "getDictionnaireMattriculeCompteProcess", $param);

    }

    /**
     * @droit Activer dictionnaire- 7
     */
    public function activateDictionnaire()
    {
        if(intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "dictionnaire_mat_compte_banque", "champs" => ["statut"=>1, 'user_modif' => $this->_USER->id, 'date_modif' => date('Y-m-d H:i:s')],"condition" => ["rowid = "=>$this->paramGET[0]]]);
            if($result !== false){
                $tab=["action"=>"Activation dictionnaire ", "commentaire"=>"Succès: dictionnaire activée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success",$this->lang["succesactivedictionnaire"]]);
            }


            else
            {
                $tab=["action"=>"Activation dictionnaire ", "commentaire"=>"Echec: dictionnaire non active","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger",$this->lang["echecactivedictionnaire"]]);
            }
            Utils::redirect("administration", "dictionnaire");
        }
        else {
            Utils::setMessageALert(["danger",$this->lang["echecactivedictionnaire"]]);
            Utils::redirect("administration", "dictionnaire");
        }

    }

    /**
     * @droit Désactiver Dictionnaire - 7
     */
    public function disableDictionnaire()
    {
        if(intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "dictionnaire_mat_compte_banque", "champs" => ["statut"=>0, 'user_modif' => $this->_USER->id, 'date_modif' => date('Y-m-d H:i:s')],"condition" => ["rowid = "=>$this->paramGET[0]]]);
            if($result !== false){
                $tab=["action"=>"Désactivation dictionnaire ", "commentaire"=>"Succès: dictionnaire désactivée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success",$this->lang["succesdesactivedictionnaire"]]);
            }

            else {
                $tab=["action"=>"Désactivation dictionnaire", "commentaire"=>"Echec: dictionnaire non désactivée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger",$this->lang["echecdesactivedictionnaire"]]);
            }

        }
        else Utils::setMessageALert(["danger",$this->lang["echecdesactivedictionnaire"]]);
        Utils::redirect("administration", "dictionnaire");
    }

    public function dictionnaireModal__()
    {
        if($this->paramGET[2]) {
            $param = [
                "champs"=>["*"],
                "condition"=>["rowid = "=>$this->paramGET[2]]
            ];
            $data['dictionnaire'] = $this->model->getOneMattriculeCompte($param)[0];
            $this->views->setData($data);
        }
        $this->modal();
    }

    public function loadDictionnaireModal__()
    {
        Session::destroyAttributSession('insert_ko');
        Session::destroyAttributSession('compte_ko');
        $compte_ok = array();
        $compte_ko = array();
        $insert_ko = array();
        if(isset($this->paramFILE['fichier'])){
            $files = Utils::setUploadFiles($this->paramFILE['fichier'], 'dictionnaires');
            $fichier = ROOT."dictionnaires/$files";
            $file = fopen($fichier, "r");
            while (($column = fgetcsv($file, 10000, "\n")) !== FALSE) {
                $tableau = explode(";", $column[0]);
                //var_dump($tableau); die;

                $matricule = str_replace(' ', '', trim($tableau[0]));
                $numero_compte = str_replace(' ', '', trim($tableau[1]));
                $code_agence = str_replace(' ', '', trim($tableau[2]));
                $compte = $this->model->verifmatriculeCompte($matricule,$numero_compte);
                if(count($compte) === 0){
                    $compte_ok[] = array('matricule' => $matricule, 'numcompte' => $numero_compte, 'codeagence' =>$code_agence);
                }
                else{
                    $erreur = '';
                    if($compte[0]->matricule == $matricule){
                        $erreur .= 'Matricule';
                    }
                    if($compte[0]->num_compte == $numero_compte){
                        if(strlen($erreur) > 5)
                            $erreur .= '/Num. compte';
                        else
                            $erreur .= 'Num. compte';
                    }
                    if($compte[0]->code_agence == $code_agence){
                        $erreur .= 'Agence';
                    }
                    $compte_ko[] = array('matricule' => $matricule, 'numcompte' => $numero_compte, 'codeagence' =>$code_agence,'erreur' => $erreur);
                }
            }


            if(count($compte_ko) === 0){
                $nb_insert = 0;
                $nb = 0;
                foreach ($compte_ok as $one){
                    $nb++;
                    $param = ['champs' => ['matricule' => $one['matricule'], 'num_compte' => $one['numcompte'],'code_agence'=>$one['codeagence'], 'user_creation' => $this->_USER->id, 'date_creation' => date('Y-m-d H:i:s')]];
                    $res = $this->model->insertDictionnaireMattriculeCompte($param);

                    if($res != false){
                        $nb_insert++;
                    }
                    else{
                        $insert_ko[] = array('matricule' => $one['matricule'], 'numcompte' => $one['numcompte'],'code_agence'=>$one['codeagence']);

                    }
                }
                Session::setAttributArray('insert_ko', $insert_ko);
                if($nb == $nb_insert && $nb_insert > 0){
                    Utils::setMessageALert(["success","Tous les comptes ont été ajouté dans le dictionnaire avec succès."]);
                }
                else{
                    Utils::setMessageALert(["danger",$nb_insert."/".$nb." compte ont été ajouté dans le dictionnaire avec succès"]);
                }
                Utils::redirect("administration", "loadDictionnaire/".base64_encode('insert_ko'));
                exit();
            }
            else{
                Session::setAttributArray('compte_ko', $compte_ko);
                Utils::setMessageALert(["danger","Le fichier chargé contient des numéros de compte ou matricule déjà enregistré"]);
                Utils::redirect("administration", "loadDictionnaire/".base64_encode('compte_ko'));
                exit();
            }
        }
        $this->modal();
    }





    /**
     * @droit Ajouter Dictionnaire - 7
     */
    public function ajoutDictionnaire()
    {
        //parent::validateToken("exemples", "exemples");

        //if(Utils::validateMail($this->paramPOST["label"])) {
        $this->paramPOST['user_creation'] = $this->_USER->id;
        $this->paramPOST['date_creation'] = date('Y-m-d H:i:s');
        $result = $this->model->insertDictionnaireMattriculeCompte(["champs"=>$this->paramPOST]);
        if($result !== false) {
            $tab=["action"=>"Ajout dictionnaire", "commentaire"=>"Succès: Dictionnaire ajoutée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
        }
        else{
            $tab=["action"=>"Ajout dictionnaire", "commentaire"=>"Echec: Dictionnaire non ajoutée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["danger",$this->lang["actionechec"]]);

        }
        Utils::redirect("administration", "dictionnaire");
    }

    /**
     * @droit Modifier Dictionnaire - 7
     */
    public function modifDictionnaire()
    {
        //parent::validateToken("exemples", "exemples");

        $param['condition'] = ["rowid = "=>$this->paramPOST['id']];
        $param['champs'] = [
            "matricule"=>$this->paramPOST["matricule"],
            "num_compte"=>$this->paramPOST["num_compte"],
            "code_agence"=>$this->paramPOST["code_agence"],
            "user_modif"=>$this->_USER->id,
            "date_modif"=>date('Y-m-d H:i:s')
        ];

        $result = $this->model->updateDictionnaireMattriculeCompte($param);
        if($result !== false)
        {
            $tab=["action"=>"Modification dictionnaire", "commentaire"=>"Succès: Dictionnaire modifiée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            Utils::redirect("administration", "dictionnaire");
        }

        else
        {
            $tab=["action"=>"Modification dictionnaire", "commentaire"=>"Succès: Dictionnaire non modifiée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
            Utils::redirect("administration", "dictionnaire");
        }



    }


    public function loadDictionnaire(){

        if(isset($this->paramGET[0])){
            $res = $this->paramGET[0];
            if($res == 'insert_ko'){
                $data['comptes'] = Session::getAttributArray('insert_ko');
            }
            if($res == 'compte_ko'){
                $data['comptes'] = Session::getAttributArray('compte_ko');
                $data['compte_ko'] = 1;
            }
        }

        $this->views->setData($data);
        $this->views->getTemplate('admin/result_insert_dico');
    }
}