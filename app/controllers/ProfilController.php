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
use Twilio\Rest\Client;




class ProfilController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model("profil");
    }

    /**
     * @droit Liste profil - 13
     */
    public function liste()
    {
        $this->views->getTemplate();
    }

    public function sendMessage(){
     /*   $numero = '+12039022398';
        $sid = 'AC3f62b483c6503454eb1adf8aa73004f7';
        $token = '464ca58cb6becced6e3887a7781376ec';
        $client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!
        $client->messages->create(
        // the number you'd like to send the message to
            '+221773511637',
            [
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $numero,
                // the body of the text message you'd like to send
                'body' => 'Hey Jenny! Good luck on the bar exam!'
            ]
        );*/


    }

    public function listeProcessing__()
    {
        $param = [
            "button"=> [
                "modal" => [
                    ["profil/profilModal","profil/profilModal","fa fa-edit"]
                ],
                "default" => [
                    ["profil/affectation/","fa fa-male"],
                    ["champ"=>"etat",
                        "val"=>["Désactiver"=>
                            ["profil/activate","fa fa-toggle-off"],
                            "Activer"=>["profil/desactivate","fa fa-toggle-on"]]
                    ]
                ],
                "custom" => []
            ],
            "tooltip"=> [
                "modal" => [
                    $this->lang["tooltipModif"]
                ],
                "default" => [
                    $this->lang["affecter_droit"],
                    ["champ"=>"etat","val"=>["Désactiver"=>$this->lang["tooltipActive"],"Activer"=>$this->lang["tooltipDesactive"]]]
                ]
            ],
            "classCss"=> [
                "modal" => [],
                "default" => [null,"confirm"]
            ],
            "attribut"=> [
                "modal" => [],
                "default" => []
            ],
            "args"=>null,
            "dataVal"=>[
                ["champ"=>"etat","val"=>["Désactiver"=>["<span style='.temp::before{text-align: right;}' class='temp text-danger'>Désactivé</span>"],"Activer"=>["<span  class='temp text-success' >Activé</span><style>.temp::before{text-align: right;}</style>"]]]
            ],
            "fonction"=>[]
        ];
        $this->processing($this->model, "getListeProcess", $param);
    }

    /**
     * @droit Affecter droit - 13
     */
    public function affectation()
    {
        $data['idProfil'] = $this->paramGET[0];
        $param = ["condition" => ["id = " => $this->paramGET[0]]];
        $result = $this->model->getProfil($param);

        if(count($result) == 0) Utils::redirect("profil", "liste");
        else $result = $result[0];

        $data['nomProfil'] = $result->profil;
        $param = [
            'table'=>'droit d',
            'champs'=>['d.id', 'd.droit', 'sm.sous_module', 'm.module', 'd.id AS id_aff', 'd.id AS etat_aff'],
            'jointure'=>[
                'INNER JOIN sous_module sm on d.fk_sous_module = sm.id',
                'INNER JOIN module m on sm.fk_module = m.id'
            ]
        ];
        $data['droit'] = $this->model->get($param);

        foreach ($data['droit'] as $key => $droit) {
            $param = [
                'table'=>'affectation_droit',
                'champs'=>['id', 'etat'],
                'condition'=>['fk_profil ='=>$this->paramGET[0],'fk_droit ='=>$droit->id]
            ];
            $temp = $this->model->get($param);
            $data['droit'][$key]->id_aff = $temp[0]->id;
            $data['droit'][$key]->etat_aff = $temp[0]->etat;
        }

        $data['droit'] = Utils::setArrayDroit($data['droit']);
        $this->views->setData($data);
        $this->views->getTemplate();
    }

    public function profilModal__()
    {
        if($this->paramGET[2]) {
            $data['profil'] = $this->model->getProfil(["condition"=>["id = "=>$this->paramGET[2]]])[0];
            $this->views->setData($data);
        }
        $this->modal();
    }

    /**
     * @droit Ajouter profil - 13
     */
    public function ajoutProfil()
    {
        //parent::validateToken("exemples", "exemples");

        $result = $this->model->insertProfil(["champs"=>$this->paramPOST]);
        if($result !== false) {
            $tab=["action"=>"Ajout profil", "commentaire"=>"Succès: Profil ajouté ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            Utils::redirect("profil", "liste");
        }
        else {
            $tab=["action"=>"Ajout profil", "commentaire"=>"Echec: Profil ajouté ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
            Utils::redirect("profil", "liste");
        }

    }

    /**
     * @droit Ajouter affectation profil - 13
     */
    public function ajoutAffectation()
    {
        //parent::validateToken("exemples", "exemples");

        $param = [
            'table'=>'droit d',
            'champs'=>['ad.id'],
            'jointure'=>["INNER JOIN affectation_droit ad ON ad.fk_droit = d.id"],
            'condition'=>['ad.fk_profil ='=>$this->paramPOST['idProfil'], 'ad.etat ='=>1]
        ];
        $data['droit'] = $this->model->get($param);
        if (count($this->paramPOST['update'])>0) {
            foreach ($data['droit'] as $item)
                if (!in_array($item->id, $this->paramPOST['update']))
                    $this->model->set(["table" => "affectation_droit","champs" => ['etat' => 0],"condition" => ['id =' => $item->id]]);

            foreach ($this->paramPOST['update'] as $item)
                $this->model->set(["table" => "affectation_droit","champs" => ['etat' => 1],"condition" => ['id =' => $item]]);

        }elseif(count($data['droit'])>0)
            foreach ($data['droit'] as $item)
                $this->model->set(["table" => "affectation_droit","champs" => ['etat' => 0],"condition" => ['id =' => $item->id]]);

        if (count($this->paramPOST['add'])>0)
            foreach ($this->paramPOST['add'] as $item)
                $this->model->set(["table" => "affectation_droit","champs" => ['fk_profil' => $this->paramPOST['idProfil'], 'fk_droit' => $item]]);

        $tab=["action"=>"Affectation droit au profil", "commentaire"=>"Succès: Affectation droit au profil ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
        $this->model->logsUser(["champs"=>$tab]);
        //Utils::redirect("profil", "affectation", [$this->paramPOST['idProfil']]);
        Utils::redirect("profil", "liste");
        Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
    }

    /**
     * @droit Modifier profil - 13
     */
    public function modifProfil()
    {
        //parent::validateToken("exemples", "exemples");

        $param['condition'] = ["id = "=>$this->paramPOST['id']];
        $param['champs'] = ["profil ="=>$this->paramPOST["profil"]];
        $result = $this->model->updateProfil($param);
        if($result !== false) {
            $tab=["action"=>"Modification profil", "commentaire"=>"Succès: Profil modifié ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
            Utils::redirect("profil", "liste");
        }
        else {
            $tab=["action"=>"Modification profil", "commentaire"=>"Echec: Profil modifié ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
            Utils::redirect("profil", "liste");
        }


    }

    /**
     * @droit Supprimer profil - 13
     */
    public function deleteProfil()
    {
        //parent::validateToken("exemples", "exemples");

        if(isset($this->paramGET[0])) {
            $param['condition'] = ["id = "=>$this->paramGET[0]];
            $result = $this->model->deleteProfil($param);
            if($result !== false) {
                $tab=["action"=>"Suppression profil", "commentaire"=>"Succès: Profil supprimé ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
                Utils::redirect("profil", "liste");
            }
            else {
                $tab=["action"=>"Suppression profil", "commentaire"=>"Succès: Profil supprimé ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
                Utils::redirect("profil", "liste");
            }
        }
    }

    /**
     * @droit Activer profils - 13
     */
    public function activate()
    {
        if(intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "profil", "champs" => ["etat"=>"Activer"],"condition" => ["id = "=>$this->paramGET[0]]]);
            if($result !== false) {
                $tab=["action"=>"Activation profil", "commentaire"=>"Succès: Profil activé ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
                Utils::redirect("profil", "liste");
            }
            else {
                $tab=["action"=>"Activation profil", "commentaire"=>"Succès: Profil activé ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
                Utils::redirect("profil", "liste");
            }
        }
        else {
            $tab=["action"=>"Activation profil", "commentaire"=>"Echec: Pas de données envoyées ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
            Utils::redirect("profil", "liste");
        }
    }

    /**
     * @droit Désactiver profil - 13
     */
    public function desactivate()
    {
        if(intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "profil", "champs" => ["etat"=>"Désactiver"],"condition" => ["id = "=>$this->paramGET[0]]]);
            if($result !== false) {
                $tab=["action"=>"Désactivation profil", "commentaire"=>"Succès: Profil désactivé ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
                Utils::redirect("profil", "liste");

            }
            else {
                $tab=["action"=>"Désactivation profil", "commentaire"=>"Succès: Profil désactivé ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
                Utils::redirect("profil", "liste");

            }
        }
        else {
            $tab=["action"=>"Activation profil", "commentaire"=>"Echec: Pas de données envoyées ","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
            Utils::redirect("profil", "liste");

        }
    }
}