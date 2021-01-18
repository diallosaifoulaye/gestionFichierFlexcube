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
use app\models\CarteModel ;

class CarteController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new CarteModel() ;
        //$this->model = $this->model("carte");
    }


    //--------------------------RECEPTION DE CARTE CRUD
    /**
     * @droit Liste réception - 11
     */
    public function reception()
    {

        if($this->paramGET[0] == 'open-modal'){
            //var_dump($this->paramGET);die;
            $param = [
                "modal-controller"=>"carte/importFichierModal",
                "modal-view"=>base64_encode("gestioncarte") . "/" . base64_encode("importFichierModal"),
                "modal-param"=>[$this->paramGET[1],$this->paramGET[2],$this->paramGET[3]]
            ];
            $this->views->setData($param);
        }
        //$data['params'] = $this->paramGET[0];

        //$this->views->setData($data);
       //$this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar"]);
        $this->views->getTemplate('gestioncarte/listeReception');
    }

    public function importFichierModal()
    {


        if(count($this->paramGET) == 5){
            $data['num_debut'] =$this->paramGET[2];
            $data['num_fin'] =$this->paramGET[3];
            $data['stock'] =$this->paramGET[4];

            $this->views->setData($data);
        }
        $this->modal();
    }

    public function receptionProcessing()
    {
        $param = [
            "button"=> [
                "modal" => [
                    //["champ"=>"_flag_","val"=>[0=>["carte/receptionModal","gestioncarte/receptionModal","fa fa-edit"],1=>[]]],


                ],
                "default" => [
                    ["carte/detailCarteReception","fa fa-search"]
                    //["champ"=>"etat","val"=>["Désactiver"=>["administration/activateDept","fa fa-toggle-off"],"Activer"=>["administration/disableDept","fa fa-toggle-on"]]],
                    //["utilisateur/detailUtilisateur","fa fa-search"]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [
                    "Modifier"
                ],
                "default" => [
                    $this->lang["detail"]
                ]
            ],
            "classCss"=> [
                "modal" => [],
                //"default" => ["confirm"]
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>1,
            "dataVal"=>[
               // ["champ"=>"etat","val"=>["Désactiver"=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>Désactiver</span>"],"Activer"=>["<span  class='temp text-success' >Activer</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                'date_reception'=>'getDateFR',
                //'dateExp'=>'getMoisAnnee',
            ]
        ];
       /* if($this->appConfig->profile_level == 2)
            array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->model, "getReceptionProcess", $param);
    }

    /**
     * @droit Détail lot réception - 11
     */
    public function detailCarteReception()
    {
        $id = $this->paramGET[0];

        if($id) {
            $data['stock_recu'] = $this->model->getStockRecu($id)[0];
            $data['stock_restant'] = $this->model->getStockRestant($id)[0];


            //$data['stock_initial'] = $this->model->getStockInitial($id)[0];
            //$data['en_stock'] = $this->model->getEnstock($id)[0];

            $data['endommage'] = $this->model->getEndommages($id)[0];
            $data['distribue'] = $this->model->getDistribue($id)[0];
            $data['embosse'] = $this->model->getEmbosse($id)[0];
            $data['enrolle'] = $this->model->getEnrolle($id)[0];
            $this->views->setData($data);
            $this->views->getTemplate('gestioncarte/detailCarte');
        }
    }

    /**
     * @droit Détail carte embossée - 17
     */
    public function detailCarteEmbosse(){
        //echo "<pre>"; var_dump($this->paramGET);die();
        $id = $this->paramGET[0];
        //echo "<pre>"; var_dump($this->paramGET);die();
        if($id) {

            $data['detail'] = $this->model->getDetailCarte($id)[0];
            //$data['embosse'] = $this->model->updateEtatCarte($id)[0];

            $this->views->setData($data);
            $this->views->getTemplate('gestioncarte/detailCarteEmbosse');
        }
    }

    /**
     * @droit Embosser carte - 17
     */
    public function updateCarteStock()
    {
      //echo "<pre>"; var_dump($this->paramPOST['numseriecarte']);die;
        //parent::validateToken("exemples", "exemples");
        $numseriecarte = $this->paramPOST['numseriecarte'];
        $agence = $this->paramPOST['agence'];
        unset($this->paramPOST['agence']);

        $result = $this->model->updateStocks($numseriecarte);
        if($result !== false)
        {
            $res = $this->model->updateEtatCarte($numseriecarte);
            if ($res){
                $this->model->updateVenteCarte($numseriecarte,$agence);
                Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
                Utils::redirect("carte", "carteListe");
            }
            else
            {
                Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
                Utils::redirect("carte", "carteListe");
            }

        }

        else
            {
            Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
            Utils::redirect("carte", "carteListe");
        }

    }

    public function receptionModal()
    {
        if($this->paramGET[2]) {
            $param = [
                "champs"=>["id","num_debut","num_fin","date_reception","dateExp"],
                "condition"=>["id = "=>$this->paramGET[2]]
            ];
            $data['reception'] = $this->model->getOneReception($param)[0];
            $this->views->setData($data);
        }

        $this->modal();
    }

    /**
     * @droit Ajouter réception - 11
     */
    public function ajoutReception()
    {
        //parent::validateToken("exemples", "exemples");
        if ($this->paramPOST['num_debut'] > $this->paramPOST['num_fin']) {
            Utils::setMessageALert(["warning", $this->lang['debutinffin']]);
            Utils::redirect("carte", "reception");
        }
        else{

            $ref="";
            $found = 0;
            do
            {
                //$dateexp = date('m-Y');
                //if($dateexp == $dateexp.date_format($dateexp,'Y-m'))
                $dateexp =$this->paramPOST['moisexp'].'/'.$this->paramPOST['anexp'];
                //var_dump($dateexp);die;
                $ref = Utils::getAlphaNumerique();

                $check = $this->model->verifyNumLot($ref,"num_reference","lotcarte_reception");

                if($check == 1){
                    $found = 1;
                    break;
                }
            }
            while($found == 0);


            $this->paramPOST['num_reference']=$ref;
            $this->paramPOST['stock_init'] = (intval($this->paramPOST['num_fin']) - intval($this->paramPOST['num_debut'])) +1;
            $this->paramPOST['stock'] = (intval($this->paramPOST['num_fin']) - intval($this->paramPOST['num_debut'])) +1;
            $this->paramPOST['user_add']= $this->_USER->id;
            $this->paramPOST['date_add']= date('Y-m-d H:i:s');
            //$this->paramPOST['dateExp']= date('Y-m-d');
            $this->paramPOST['dateExp']=Utils::getDateUS2($this->paramPOST['dateExp']);
            $this->paramPOST['date_reception']=Utils::getDateUS2($this->paramPOST['date_reception']);
            //$this->paramPOST['dateExp'] = $dateexp;

            //$this->paramPOST['dateExp']=$dateexp;
            //var_dump($dateexp);die;
            unset($this->paramPOST['moisexp'],$this->paramPOST['anexp']);

            $check=$this->model->chevauchement_reception($this->paramPOST['num_debut'],$this->paramPOST['num_fin']);
            //var_dump($check);exit;

            if($check == 1){
                $result = $this->model->insertReception(["champs" => $this->paramPOST]);
                if ($result !== false){
                    $tab=["action"=>"Ajout Reception Carte", "commentaire"=>" Succès : lot de carte ajoutée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                    $this->model->logsUser(["champs"=>$tab]);
                    Utils::setMessageALert(["success", $this->lang['add_lot_success']]);
                    Utils::redirect("carte", "reception");
                }
                else {
                    $tab=["action"=>"Ajout Reception Carte", "commentaire"=>" Error : carte non  ajoutée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                    $this->model->logsUser(["champs"=>$tab]);
                    Utils::setMessageALert(["danger", $this->lang['add_lot_error']]);
                    Utils::redirect("carte", "reception");
                }
            }else{
                Utils::setMessageALert(["danger", $this->lang['chevauch_recept']]);
                Utils::redirect("carte", "reception");
            }
        }
    }

    /**
     * @droit Modifier réception - 11
     */
    public function modifReception()
    {
       //echo "<pre>"; var_dump($this->paramPOST);die;
        $dateexp =$this->paramPOST['moisexp'].'/'.$this->paramPOST['anexp'];
        //parent::validateToken("exemples", "exemples");
        if ($this->paramPOST['num_debut'] > $this->paramPOST['num_fin']) {
            Utils::setMessageALert(["warning", $this->lang['debutinffin']]);
            Utils::redirect("carte", "reception");
        }
        else{

            $param['condition'] = ["id = "=>$this->paramPOST['id']];
            $param['champs'] = [
                "user_modif"=>$this->_USER->id,
                "date_modif"=>date('Y-m-d H:i:s'),
                "num_debut"=>$this->paramPOST["num_debut"],
                "num_fin"=>$this->paramPOST["num_fin"],
                "dateExp"=>Utils::getDateUS2($this->paramPOST["dateExp"]),
                "date_reception"=>Utils::getDateUS2($this->paramPOST["date_reception"]),
                //"dateExp"=>$dateexp,
                "stock_init"=>(intval($this->paramPOST['num_fin']) - intval($this->paramPOST['num_debut'])) +1,
                "stock"=>(intval($this->paramPOST['num_fin']) - intval($this->paramPOST['num_debut'])) +1
            ];
            unset($this->paramPOST['moisexp'],$this->paramPOST['anexp']);
            //var_dump($dateexp);die;

            $result = $this->model->updateReception($param);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);

            Utils::redirect("carte", "reception");
        }

    }

//--------------------------DISTRIBUTION DE CARTE CRUD
    /**
     * @droit Liste distribution - 12
     */
    public function distribution()
    {
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar"]);
        $this->views->getTemplate('gestioncarte/listeDistribution');
    }

    public function distributionProcessing()
    {
        $param = [
            "button"=> [
                "modal" => [
                    ["carte/distributionModal","gestioncarte/distributionModal","fa fa-edit"]
                ],
                "default" => [
                    //["champ"=>"etat","val"=>["Désactiver"=>["administration/activateDept","fa fa-toggle-off"],"Activer"=>["administration/disableDept","fa fa-toggle-on"]]],
                    //["utilisateur/detailUtilisateur","fa fa-search"]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [
                    $this->lang["tooltipModif"]
                ],
                "default" => [
                   // ["champ"=>"etat","val"=>["Désactiver"=>"Activer","Activer"=>"Desactiver"]],
                   // "Détail"
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
               // ["champ"=>"etat","val"=>["Désactiver"=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>Désactiver</span>"],"Activer"=>["<span  class='temp text-success' >Activer</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                'date_distribution'=>'getDateFR',
            ]
        ];
       /* if($this->appConfig->profile_level == 2)
            array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->model, "getDistributionProcess", $param);
    }

    public function distributionModal()
    {
        if($this->paramGET[2]) {
            $param = [
                "champs"=>["id AS rowid","num_debut","num_fin","date_distribution","fk_agence_dest","fk_lot_origine"],
                "condition"=>["id = "=>$this->paramGET[2]]
            ];
            $data['distribution'] = $this->model->getOneDistribution($param)[0];
        }
        $param = ["table"=>"agence"];
        $param['condition'] = ["etat = " => "Activer"];
        $data['agence'] = $this->model->get($param);
        $param = ["table"=>"lotcarte_reception"];
        $param['condition'] = ["stock > " => 0];
        $data['lotorigne'] = $this->model->get($param);
        $param = ["table"=>"lotcarte_reception"];
        $data['lotorigneSS'] = $this->model->get($param);
        $this->views->setData($data);
        $this->modal();
    }

    /**
     * @droit Ajouter distribution - 11
     */
    public function ajoutDistribution()
    {

        //parent::validateToken("exemples", "exemples");
        if ($this->paramPOST['num_debut'] > $this->paramPOST['num_fin']) {
            Utils::setMessageALert(["warning", $this->lang['debutinffin']]);
            Utils::redirect("carte", "distribution");
        }
        else{

            $ref="";
            $found = 0;
            do
            {
                $ref = Utils::getAlphaNumerique();

                $check = $this->model->verifyNumLot($ref,"num_reference","lotcarte");

                if($check == 1){
                    $found = 1;
                    break;
                }
            }
            while($found == 0);

            $this->paramPOST['num_reference']=$ref;
            $agence=$this->paramPOST['fk_agence_dest'];
            $this->paramPOST['stock_init'] = (intval($this->paramPOST['num_fin']) - intval($this->paramPOST['num_debut'])) +1;
            $this->paramPOST['stock'] = (intval($this->paramPOST['num_fin']) - intval($this->paramPOST['num_debut'])) +1;
            $this->paramPOST['user_add']= $this->_USER->id;
            $this->paramPOST['date_add']= date('Y-m-d H:i:s');
            $this->paramPOST['date_distribution']=Utils::getDateUS2($this->paramPOST['date_distribution']);
            $this->paramPOST['fk_agence_source']=$this->_USER->agence;
            //$check=$this->model->chevauchement_distribution($this->paramPOST['num_debut'],$this->paramPOST['num_fin'],$agence);
            //var_dump($check);exit;

            //if($check == 1){
                $result = $this->model->insertDistribution(["champs" => $this->paramPOST]);

                //Update dans meczy_stockCartes

                //$t = $this->paramPOST['stock'];

                $deb = $this->paramPOST['num_debut'];
               $fin = $this->paramPOST['num_fin'];
            if ($result == true) {
                $tab=["action"=>"Ajout Distribution Carte", "commentaire"=>" Succès : lot de carte distribuée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);

                for ($i = $deb; $i <= $fin; $i++) {

                    $this->model->updateStockCarteBis(intval($i),$agence);

                }
            }


                if ($result !== false){
                    $tab=["action"=>"Ajout Reception Carte", "commentaire"=>" Error : lot de carte non distribuée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                    $this->model->logsUser(["champs"=>$tab]);
                    $param['condition'] = ["id = "=>$this->paramPOST['fk_lot_origine']];
                    $param['champs'] = [
                        "user_modif"=>$this->_USER->id,
                        "date_modif"=>date('Y-m-d H:i:s'),
                        "stock = stock - "=>(intval($this->paramPOST['stock'])),
                        "flag = "=>1,
                    ];
                    $result1 = $this->model->updateReception($param);
                    Utils::setMessageALert(["success", $this->lang['add_distribution_success']]);
                    Utils::redirect("carte", "distribution");
                }
                else {
                    Utils::setMessageALert(["danger", $this->lang['add_distribution_error']]);
                    Utils::redirect("carte", "distribution");
                }
           /* }else{
                Utils::setMessageALert(["danger", $this->lang['chevauch_dist']]);
                Utils::redirect("carte", "distribution");
            }*/
        }
    }


    public function modifDistribution()
    {
        //parent::validateToken("exemples", "exemples");
        $param['condition'] = ["id = "=>$this->paramPOST['id']];
        $param['champs'] = [
            "user_modif" => $this->_USER->id,
            "date_modif" => date('Y-m-d H:i:s'),
            "num_debut" => $this->paramPOST["num_debut"],
            "num_fin" => $this->paramPOST["num_fin"],
            "date_distribution" => Utils::getDateUS2($this->paramPOST["date_distribution"]),
            "fk_agence_dest" => $this->paramPOST["fk_agence_dest"],
            "stock_init = (stock_init - stock_init) +" => (intval($this->paramPOST['num_fin']) - intval($this->paramPOST['num_debut'])) +1,
            "stock = (stock - stock) +" => (intval($this->paramPOST['num_fin']) - intval($this->paramPOST['num_debut'])) +1,
            "fk_agence_source" => $this->_USER->agence
        ];
        $result = $this->model->updateDistribution($param);
        if($result !== false)
        {
            Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            $param['condition'] = ["id = "=>$this->paramPOST['fk_lot_origine']];
            $param['champs'] = [
                "user_modif"=>$this->_USER->id,
                "date_modif"=>date('Y-m-d H:i:s'),
                "stock = stock_init - "=>(intval($this->paramPOST['num_fin']) - intval($this->paramPOST['num_debut'])) +1
            ];
            $result1 = $this->model->updateReception($param);
        }

        else Utils::setMessageALert(["danger",$this->lang["actionechec"]]);

        Utils::redirect("carte", "distribution");
    }

    //--------------------------DISPONIBILITE DE CARTE
    /**
     * @droit Liste carte disponible - 14
     */
    public function disponibilite()
    {
        $data["agences"] = $this->model->getAgences() ;
        Utils::setDefaultSort(1, "DESC");
        if (isset($this->paramPOST["agence"])) {
            $data['agence'] = $this->paramPOST['agence'];
        }
        else{
            $data['agence'] = '';
        }
        $this->views->setData($data);
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar"]);
        $this->views->getTemplate('gestioncarte/disponibilite');
    }


    public function disponibiliteProcessing(){
        $param = [
            "button"=> [
                "modal" => [],
                "default" => [],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [],
                "default" => []
            ],
            "classCss"=> [
                "modal" => [],
                "default" => ["confirm"]
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>$this->paramGET,
            "dataVal"=>[],
            "fonction"=>['stock_init'=>'alignCenter','stock'=>'alignCenter','vente'=>'alignCenter','retour'=>'alignCenter']
        ];
        /* if($this->appConfig->profile_level == 2)
             array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->model, "getDisponibiliteProcess", $param);
    }

    //--------------------------OPERATION SUR LES CARTES
    /**
     * @droit Réactiver carte - 18
     */
    public function cardToCustomeractivateCarte(){
        if(intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "carte", "champs" => ["etat"=>"Activer"],"condition" => ["id = "=>$this->paramGET[0]]]);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
        }
        else Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
        Utils::redirect("carte", "cardToCustomer");
    }

    /**
     * @droit Désactiver carte - 18
     */
    public function cardToCustomerdisableCarte(){
        if(intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "carte", "champs" => ["etat"=>"Désactiver"],"condition" => ["id = "=>$this->paramGET[0]]]);
            if($result !== false) Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            else Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
        }
        else Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
        Utils::redirect("carte", "cardToCustomer");
    }

   /* public function cardToCustomer(){
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar"]);
        $this->views->getTemplate('gestioncarte/carteToclient');
    }*/
    /**
     * @droit Liste carte activée - 18
     */
   public function cardToCustomer()
   {
       $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar"]);
       $this->views->getTemplate('gestioncarte/listeCarteClient');
   }

    /**
     * @droit Liste carte à embosser - 17
     */
    public function carteListe()
    {
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar"]);
        $this->views->getTemplate('gestioncarte/listeCarte');
    }

    public function carteProcessing()
    {
        $param = [
            "button"=> [
                "modal" => [
                    //["carte/distributionModal","gestioncarte/distributionModal","fa fa-edit"]
                ],
                "default" => [
                    //["champ"=>"etat","val"=>["Enroler"=>["carte/activateCarte","fa fa-toggle-off"],"Activer"=>["carte/disableCarte","fa fa-toggle-on"]]],
                    ["carte/detailCarteEmbosse","fa fa-search"]
                    //["utilisateur/detailUtilisateur","fa fa-search"]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [
                    //  "Modifier"
                ],
                "default" => [
                    // ["champ"=>"etat","val"=>["Désactiver"=>"Activer","Activer"=>"Desactiver"]],
                    $this->lang["detail"]
                ]
            ],
            "classCss"=> [
                "modal" => [],
                "default" => []
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>null,
            "dataVal"=>[
                //["champ"=>"etat","val"=>["Enroler"=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>Activer</span>"],"Activer"=>["<span  class='temp text-success' >Enroler</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                'date_expiration' => 'getMonthYearFR',
                'numero' => 'truncate_carte',
            ]
        ];
        /* if($this->appConfig->profile_level == 2)
             array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->model, "getCarteProcess", $param);
    }

    public function carteClientProcessing(){
        $param = [
            "button"=> [
                "modal" => [
                    //["carte/distributionModal","gestioncarte/distributionModal","fa fa-edit"]
                ],
                "default" => [
                    ["champ"=>"etat","val"=>["Désactiver"=>["carte/cardToCustomeractivateCarte","fa fa-toggle-off"],"Activer"=>["carte/cardToCustomerdisableCarte","fa fa-toggle-on"]]],
                    ["carte/cardToCustomerdetailCarteClient","fa fa-search"]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [
                    //  "Modifier"
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
                ["champ"=>"etat","val"=>["Désactiver"=>["<span style='.temp::before{text-align: right;}' class='temp text-info'>".$this->lang["btn_desactiver"]."</span>"],"Activer"=>["<span  class='temp text-success' >".$this->lang["btn_activer"]."</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[
                'date_expiration' => 'getMonthYearFR',
                'numero' => 'truncate_carte',
            ]
        ];
        /* if($this->appConfig->profile_level == 2)
             array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->model, "getCarteClientProcess", $param);
    }

    public function cardToCustomerdetailCarteClient()
    {

        $id = $this->paramGET[0];

        if($id) {

            $data['detail'] = $this->model->getDetailCarte($id)[0];
            $this->views->setData($data);
            $this->views->getTemplate('gestioncarte/detailCarteClient');
    }
    }

    //region Edited by YETE A. Abigail

    public function searchClient__()
    {
        //var_dump($this->paramPOST);die;
      $this->apiClient->setMethod('post');
       $this->apiClient->setService('ges-api');
        $param = [
            "ges-api"=>[
                "get"=>["action"=>"rechercherClient"],
                "code"=>"0100000002"
            ]
        ];
      //$param = json_encode($param);
       $this->apiClient->setData($param);
       $rstApi1 = $this->apiClient->safClient();
       print ''.$rstApi1;

//
//
//        $rstApi = '{
//    "statusMessage": [
//        {
//            "COD_CLIENTE": "0100000008",
//            "NOM_CLIENTE": "MOUSTAPHA CISSE",
//            "TEL_PRINCIPAL": "",
//            "COD_AGENCIA": "01",
//            "NUM_ID": "12128403238",
//            "DES_TIPO_ID": "CARTE D\'IDENTITE NATIONALE",
//            "SAL_DISPONIBLE": "3500.00",
//            "COD_PRODUCTO": "CC001",
//            "DES_PRODUCTO": "CAPITAL SOCIAL",
//            "NUM_CUENTA": "0100100000008"
//        },
//        {
//            "COD_CLIENTE": "0100000002",
//            "NOM_CLIENTE": "MARIAMA BOYE",
//            "TEL_PRINCIPAL": "",
//            "COD_AGENCIA": "01",
//            "NUM_ID": "12128403238",
//            "DES_TIPO_ID": "CARTE D\'IDENTITE NATIONALE",
//            "SAL_DISPONIBLE": "3500.00",
//            "COD_PRODUCTO": "CC001",
//            "DES_PRODUCTO": "CAPITAL SOCIAL",
//            "NUM_CUENTA": "0100100000002"
//        },
//        {
//            "COD_CLIENTE": "0100000003",
//            "NOM_CLIENTE": "MAME DABA SARR",
//            "TEL_PRINCIPAL": "",
//            "COD_AGENCIA": "01",
//            "NUM_ID": "12128403238",
//            "DES_TIPO_ID": "CARTE D\'IDENTITE NATIONALE",
//            "SAL_DISPONIBLE": "3500.00",
//            "COD_PRODUCTO": "CC001",
//            "DES_PRODUCTO": "CAPITAL SOCIAL",
//            "NUM_CUENTA": "0100100000003"
//        }
//    ],
//    "statusCode": "200"
//}';
//       /* $rstApi = '{
//    "statusMessage": [
//        {
//            "Error": "Ce client n\'existe pas"
//        }
//    ],
//    "statusCode": "201"
//}';*/
//
//        $rstApi = json_decode($rstApi);
//        //$rstApi = '';
//
//        if($rstApi->statusCode == '200'){
//            foreach ($rstApi->statusMessage as $item){
//                $client = $item->NOM_CLIENTE; break;
//            }
//            echo $client;exit;
//        }
//        else{
//            echo false;
//        }

    }

    public function checkCard__()
    {
        //var_dump($this->paramPOST);die;

        $param = [
            "champs"=>["id"],
            "condition"=>["numero = "=>$this->paramPOST['numero'], "numero_serie = "=>$this->paramPOST['numero_serie']]
        ];
        $carte = count($this->model->getCarte($param)[0]);
        //var_dump($carte);die;
        if ($carte > 0) echo true;
        else echo false;
    }

    public function saveClientCard()
    {
        //var_dump($this->paramPOST);die;

        $this->paramPOST['solde'] = 0;
        $this->paramPOST['user_crea'] = $this->_USER->id;
        $this->paramPOST['date_crea'] = date('Y-m-d H:i:s');
        $this->paramPOST['date_activation'] = date('Y-m-d H:i:s');
        $this->paramPOST['fk_agence'] = $this->_USER->agence;
        $this->paramPOST['cle_secrete'] = Utils::genererReference(5);
        $this->paramPOST['date_expiration'] = $this->paramPOST['anexp'].'-'.$this->paramPOST['moisexp'];
        unset($this->paramPOST['moisexp'],$this->paramPOST['anexp']);
        $result = $this->model->insertCarte(["champs"=>$this->paramPOST]);
        //var_dump($result);exit;
        if ($result == -1)
        {
            Utils::setMessageALert(["danger", $this->lang["cartedejaenrollee"]]);
            Utils::redirect("carte", "carteListe");
        }
        elseif($result == -2)
        {
            Utils::setMessageALert(["danger", $this->lang["vente_echec"]]);
            Utils::redirect("carte", "carteListe");
        }
        elseif($result == -3)
        {
            Utils::setMessageALert(["danger", $this->lang["enrollement_echec"]]);
            Utils::redirect("carte", "carteListe");
        }
        else
        {
            Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
            Utils::redirect("carte", "carteListe");
        }
    }

    //endregion

    //----------------------------------RETOUR CARTE
    public function retourcarte()
    {
        $data['agences'] = $this->model->agenceWithLot();
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar"]);
        $this->views->setData($data);
        $this->views->getTemplate('gestioncarte/retourCarte');
    }

    public function getLotCarteByAgence()
    {
        $data = $this->model->getLotByAgence($this->paramPOST['idagence']);
        $result = '';
        foreach($data as $lot)
            $result = '<option value="">Séléctionner le lot de carte</option>';
            //$result .= '<option value="'.$lot->stock.'-'.$lot->num_debut.'-'.$lot->num_fin.'">'.$lot->num_debut.' ==> '.$lot->num_fin.' ==> '.$lot->stock.'</option>';
            $result .= '<option value="'.$lot->stock.'">'.$lot->num_debut.' ==> '.$lot->num_fin.' ==> '.$lot->stock.'</option>';
        echo $result;
    }

    public function validerRetour(){
        //echo "<pre>"; var_dump($this->paramPOST["lotCarte"]);exit;
        $data['retour'] = $this->model->getLotRetourner($this->paramPOST["lotCarte"]);
        //echo "<pre>"; var_dump($data['retour']);exit;
        $data['agences'] = $this->model->agenceWithLot();
        $this->paramPOST['lotCarte'] = explode('-',$this->paramPOST['lotCarte']);
        $data['idlotcarte'] = $this->paramPOST['lotCarte'][0];
        $this->paramPOST['debut'] = $this->paramPOST['lotCarte'][1];
        $this->paramPOST['fin'] = $this->paramPOST['lotCarte'][2];
        $this->paramPOST['idagence'] = $this->paramPOST['rowid'];
        $data['idagence'] = $this->paramPOST['idagence'];
        unset($this->paramPOST['lotCarte']);
        $carteSale = $this->model->getCartesSaleByIntevale(['debut'=>$this->paramPOST['debut'],'fin'=>$this->paramPOST['fin'],'idagence'=>$this->paramPOST['idagence']]);
        $data['lotRestant'] = $this->getFreeInterval(['debut'=>$this->paramPOST['debut'],'fin'=>$this->paramPOST['fin']],$carteSale);
        //var_dump($data['lotRestant']);exit;
        Session::setAttributArray('lotRestant',$data['lotRestant']);
        //$this->getSession()->setAttributArray('lotRestant',$data['lotRestant']);
        //$data['reference'] = $_POST['reference'];
        //$data['date_reception'] = $_POST['date_reception'];
        //var_dump($data['lotRestant']);exit;
        $this->views->setData($data);
        $this->views->getTemplate('gestioncarte/listeretourcarte');
    }

    public function getFreeInterval($interval = ['debut'=>null,'fin'=>null], array $data)
    {
        asort($data);
        $current = null;
        $result = [];
        foreach ($data as $oneData) {
            if($oneData > $interval['debut']) {
                array_push($result,['idlot'=>null,'debut'=>$interval['debut'],'fin'=> intval($oneData) - 1,'stock'=>(((intval($oneData) - 1) - intval($interval['debut'])) +1)]);
                $result[(count($result) - 1)]['idlot'] = (count($result) - 1);
                $interval['debut'] = intval($oneData) + 1;
            }else
                $interval['debut'] = intval($interval['debut']);
        }
        if(intval($result[(count($result)-1)]['fin']) < intval($interval['fin'])) {
            array_push($result,['idlot'=>null,'debut'=>$interval['debut'],'fin'=>$interval['fin'],'stock'=>((intval($interval['fin']) - intval($interval['debut']))+1)]);
            $result[(count($result) - 1)]['idlot'] = (count($result) - 1);
        }
        return $result;
    }

    /**
     * @droit Retourner lot de carte - 16
     */
    public function retournerLot()
    {
      //echo "<pre>"; var_dump($this->paramPOST);die;

        /*$stock = (intval($this->paramPOST['num_fin']) - intval($this->paramPOST['num_debut'])) +1;
        $fk_lot_origine = $this->paramPOST["fk_lot_origine"];
        $result = $this->model->updateLotCarte($stock,$fk_lot_origine);*/

        $id =  $this->paramPOST['id'];
        $stock =  $this->paramPOST['stock'];
        $num_reference =  $this->paramPOST['num_reference'];
        $num_debut =  $this->paramPOST['num_debut'];
        $num_fin =  $this->paramPOST['num_fin'];
        $fk_agence_dest =  $this->paramPOST['fk_agence_dest'];
        $fk_lot_origine =  $this->paramPOST['fk_lot_origine'];
        $motif =  $this->paramPOST['motif'];
        $date_retour =  $this->paramPOST['date_retour'];

       for ($i=0;$i<sizeof($stock);$i++)
       {
           $result = $this->model->updateLotCarte($stock[$i],$id[$i]);


       }
       if ($result == true)
       {
           for ($i=0;$i<=sizeof($stock);$i++)
           {
               for($j=intval($num_debut[$i]);$j<=intval($num_fin[$i]);$j++)
               {
                   if ($motif[$i] ==1)
                   {

                       $statut = 0;

                       //$reception = $this->model->updateStockReception($stock[$i],$fk_lot_origine[$i]);

                   }
                  if ($motif[$i] ==2){
                       $statut = 4;

                   }
                   $updateStatut = $this->model->updateStockCarte($j,$statut);


               }
           }
           if ($updateStatut == true){
               //var_dump($updateStatut);exit();
               $lotcarte = $this->model->updateStockLotCarte($stock[$i],$id[$i]);

           }

       }

       if ($updateStatut == true){

           for ($i=0;$i<sizeof($stock);$i++)
           {

               $param['champs'] = [
                   "num_reference"=>$num_reference[$i],
                   "num_debut"=>$num_debut[$i],
                   "num_fin"=>$num_fin[$i],
                   "date_retour"=>$date_retour,
                   "fk_agence_dest"=>$fk_agence_dest[$i],
                   "fk_lot_origine"=>$fk_lot_origine[$i],
                   "stock" => $stock[$i],
                   "idmotif" => $motif[$i],


               ];
               $insert = $this->model->insertCarteRetourne($param);
               if ($insert > 0 )
               {
                   for($j=intval($num_debut[$i]);$j<=intval($num_fin[$i]);$j++)
                   {
                       $this->model->updateVenteRetour($j);

                   }

                   Utils::setMessageALert(["success", $this->lang["operation_reussie"]]);
                   Utils::redirect("carte", "listeretourcarte");
               }
               else{
                   Utils::setMessageALert(["danger", $this->lang["operation_echec"]]);
                   Utils::redirect("carte", "validerRetour");
               }

           }

       }

    }

    public function listeretourcarte()
    {
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar"]);
        $this->views->getTemplate('gestioncarte/listecarteRetourne');
    }

    public function retourcarteProcessing(){
        $param = [
            "button"=> [
                "modal" => [
                    //["carte/distributionModal","gestioncarte/distributionModal","fa fa-edit"]
                ],
                "default" => [
                    ["champ"=>'libellemotif',"val"=>["Non vendue"=>["carte/detailDistribution","fa fa-search"]]]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [

                ],
                "default" => [
                    $this->lang["distribuer"]
                ],
            ],
            "classCss"=> [
                "modal" => [],
                "default" => []
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>null,

            "fonction"=>[
                'date_retour' => 'getDateFR',

            ]
        ];
        /* if($this->appConfig->profile_level == 2)
             array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);*/
        $this->processing($this->model, "getCarteRetournes", $param);
    }

    /**
     * @droit Liste carte retournée - 16
     */
    public function carteRetournes()
    {
        $data['motif'] = $this->model->getMotif();
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar"]);
        $this->views->setData($data);
        $this->views->getTemplate('gestioncarte/carteRetournes');
    }

    public function verifNumeroSerie()
    {
        $numdebut = ($this->paramPOST['num_debut']);
        $numfin =($this->paramPOST['num_fin']) ;
        $quantite =($this->paramPOST['stock']) ;
        $data['serie'] = $this->model->getLotCarteRetourner($numdebut,$numfin,$quantite);
        print_r(json_encode($data['serie'])) ;

    }

    public function ajoutCarteStock()
    {

        $mod ='open-modal';

        $files = Utils::setUploadFiles($this->paramFILE['file'], 'loadcartes');
        $fichier = ROOT."loadcartes/$files";
        $file = fopen($fichier, "r");
        $i = 1 ;


        $fk_lot = $this->model->nombreCarteStock();
        $date_reception = date("Y-m-d");


        $found = 0;
        do
        {
            $ref = Utils::getAlphaNumerique();
            $check = $this->model->verifyNumLot($ref,"num_reference","lotcarte_reception");
            if($check == 1){
                $found = 1;
                break;
            }
        }
        while($found == 0);



        $nb_insert = 0  ;
        $echec_insert = 0 ;

        $this->model->beginTransaction() ;
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $tableau = explode(";", $column[0]);

            $number_card = $tableau[0];
            $date_expire = $tableau[1];
            $num_serie = $tableau[2];
            $code_bar = $tableau[3];

            $rs = $this->model->insertCarteStock($number_card,$date_expire,$num_serie,$code_bar,$fk_lot,$date_reception);
            $nb_insert ++ ;

        }

        $insrecept = -1 ;
        if ($rs > 0){
            $num_series = $this->model->DebutCarteStock($fk_lot);
            $num_debut = $num_series[0]->num_debut;
            $num_fin = $num_series[0]->num_fin;
            $num_ref =  $ref;

            $tab=["action"=>"Ajout Stock Carte", "commentaire"=>" Succès : Carte ajoutée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);

            $insrecept = $this->model->insertReceptionCarte($nb_insert,$num_debut,$num_fin,$num_ref,$date_expire,$date_reception);
        }

        if ($rs > 0 && $insrecept > 0){
            $this->model->commit() ;
            Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            Utils::redirect("carte", "reception",[$mod,$num_debut,$num_fin,$nb_insert]);
        }else{
            $this->model->rollBack() ;
            $tab=["action"=>"Ajout Stock Carte", "commentaire"=>" Error : Carte non ajoutée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);

            Utils::setMessageALert(["danger", $this->lang['doublon_carte']]);
            Utils::redirect("carte", "reception");
            exit();

        }



    }

    public function detailDistribution()
    {
        $id = $this->paramGET[0];
        if ($id > 0){
            $data['distribution'] =  $this->model->getDistributionLotCarte($id)[0];
            $this->views->setData($data);
            $this->views->getTemplate('gestioncarte/detailDistribution');
        }

    }

    /**
     * @droit Reintégrer lot carte - 16
     */
    public function nouveauDistribution()
    {
        $ref="";
        $found = 0;
        do
        {
            $ref = Utils::getAlphaNumerique();

            $check = $this->model->verifyNumLot($ref,"num_reference","lotcarte_reception");

            if($check == 1){
                $found = 1;
                break;
            }
        }
        while($found == 0);


        $id = $this->paramPOST['id'];
        $this->paramPOST['num_reference']=$ref;
        $this->paramPOST['num_debut'] = $this->paramPOST['num_debut'];
        $this->paramPOST['num_fin']=$this->paramPOST['num_fin'];
        $this->paramPOST['stock_init']=$this->paramPOST['stock_init'];
        $this->paramPOST['stock']=$this->paramPOST['stock'];
        $this->paramPOST['idagence']=$this->_USER->agence;
        $this->paramPOST['user_add']=$this->paramPOST['user_add'];
        $this->paramPOST['date_add']=$this->paramPOST['date_add'];
        $this->paramPOST['date_reception']=$this->paramPOST['date_reception'];
        $this->paramPOST['dateExp']=$this->model->getDateExp($this->paramPOST['num_debut'],$this->paramPOST['num_fin']);

        unset($this->paramPOST['id']);




        $resultat = $this->model->insertReception(["champs" => $this->paramPOST]);


        $this->paramPOST['id']= $id ;

            if ($resultat){
                $tab=["action"=>"Ajout Reception", "commentaire"=>" Succès : lot de reception ajoutée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);

                for($j=intval($this->paramPOST['num_debut']);$j<=intval($this->paramPOST['num_fin']);$j++)
                {
                    $this->model->updateStockCarteTer($j,$resultat);
                }

                $rs = $this->model->updateStatutRetourCarte($id);

                Utils::setMessageALert(["success", $this->lang['carte_integre']]);
                Utils::redirect("carte", "distribution");
                exit();
            }
            else {
                $tab=["action"=>"Ajout Reception", "commentaire"=>" Error : lot de reception non ajoutée","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger", $this->lang['add_distribution_error']]);
                Utils::redirect("carte", "distribution");
                exit();
            }



    }

    public function test()
    {



        $file = ROOT."loadcartes/data_meczy.csv";
        $fic=fopen($file ,"r");
        $fk_lot = $this->model->nombreCarteStock();
        $date_reception = date("Y-m-d");
        $ref = Utils::getAlphaNumerique();
        $stock = 0;


            $i = 0;
            $nb_insert =0;
             $echec_insert =0;
            $tab = fgets($fic);


            $tableau = explode(";", $tab);
        $this->model->beginTransaction() ;

          for ($i=1;$i<sizeof($tableau); $i++ ){


                if (($i>1) && (($i%4) == 0))
                {
                    for($j=($i-4) ; $j< $i; $j++){
                        if ($i-$j == 4){
                            $number_card = $tableau[$j];
                        }
                        if ($i-$j == 3){
                            $date_expire = $tableau[$j];
                        }
                        if ($i-$j == 2){
                            $num_serie = $tableau[$j];
                        }
                        if ($i-$j == 1){
                            $code_bar =$tableau[$j];
                        }
                        //echo 'I-J='.($i-$j) ;
                       //echo $tableau[$j].' ' ;
                    }
                    $rs = $this->model->insertCarteStock($number_card,$date_expire,$num_serie,$code_bar,$fk_lot,$date_reception);
                    $nb_insert ++;

                }
                else{
                    $echec_insert++;
                }

            }


        $num_series = $this->model->DebutCarteStock($fk_lot);
        $num_debut = $num_series[0]->num_debut;
        $num_fin = $num_series[0]->num_fin;
        $num_ref =  $ref;



        if ($rs > 0){
            $rs = $this->model->insertReceptionCarte($nb_insert,$num_debut,$num_fin,$num_ref);
            $this->model->commit() ;
            Utils::redirect("carte", "reception");


        }
        else{

            $this->model->rollBack();
            Utils::redirect("carte", "reception");

        }

    }
}