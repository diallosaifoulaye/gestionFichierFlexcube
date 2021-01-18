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
use PHPMailer\PHPMailer\Exception;

class UtilisateurController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model("user");
    }
    /**
     * @droit Liste Utilisateur - 4
     */
    public function liste()
    {
        //Utils::setDefaultSort(2, "ASC");
        $this->views->getTemplate();
    }

    public function renewPassword__()
    {

        $data['rowid'] = $this->paramGET[0];
        $data['pass'] = $this->paramGET[1];
        $this->views->setData($data);
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => ""]);
        $this->views->getPage('utilisateur/renewpassword');
    }

    public function checkOldPassword__()
    {
        $thepass = $this->paramPOST['thepass'];
        $oldpwd = $this->paramPOST['oldpwd'];
        $param = [
            "champs"=>["password"],
            "condition"=>["u.id = "=>$thepass]
        ];
        $user = $this->model->getUser($param)[0];

        if (password_verify($oldpwd, $user->password)){
            echo true;
        }
        else echo false;
    }

    public function myProfil__()
    {
        //var_dump($this->paramGET);die;
        $param = [
            "champs"=>["u.*", "p.profil", "a.label"],
            "jointure"=>[
                "INNER JOIN profil p ON u.fk_profil = p.id",
                "INNER JOIN agence a ON u.agence = a.rowid"
            ],
            "condition"=>["u.id = "=>$this->paramGET[0]]
        ];
        $data['utilisateur'] = $this->model->getUser($param)[0];
        $this->views->setData($data);
        $this->views->getTemplate();
    }

    public function saveNewPassword__()
    {

        $this->paramPOST['password'] = Utils::getPassCrypt($this->paramPOST['confirmpwd']);
        $this->paramPOST['connect'] = 0;
        $param['condition'] = ["id = "=>$this->paramPOST['id']];
        $param['champs'] = [
            "password"=>$this->paramPOST["password"],
            "connect"=>$this->paramPOST["connect"],
            "user_modif"=>$this->_USER->id,
            "date_modif"=>date('Y-m-d H:i:s')
        ];

        $result = $this->model->updateUser($param);

        if ($result !== false) {
            Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
        } else Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
        Utils::redirect("utilisateur", "myProfil", [$this->paramPOST['id']]);
    }



    public function saveNewPasswordFirst__()
    {

        $this->paramPOST['password'] = Utils::getPassCrypt($this->paramPOST['confirmpwd']);
        $this->paramPOST['connect'] = 0;
        $param['condition'] = ["id = "=>$this->paramPOST['id']];
        $param['champs'] = [
            "password"=>$this->paramPOST["password"],
            "connect"=>$this->paramPOST["connect"],
            "user_modif"=>$this->_USER->id,
            "pwdUpdated"=>1,
            "date_modif"=>date('Y-m-d H:i:s')
        ];

        $result = $this->model->updateUser($param);

        if ($result !== false) {
            Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
        } else Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
        //Utils::redirect("utilisateur", "myProfil", [$this->paramPOST['id']]);
        Utils::redirect("home", "index");
        //Utils::redirect(
        //$this->views->getPage('home/index');
    }

    public function listeProcessing__()
    {
        $param = [
            "button"=> [
                "modal" => [
                    ["utilisateur/utilisateurModal","utilisateur/utilisateurModalDetails","fa fa-info-circle"],
                    ["utilisateur/utilisateurModal","utilisateur/utilisateurModal","fa fa-edit"],
                    //["utilisateur/regenerationModal","utilisateur/regenerationModal","fa fa-recycle"]
                ],

                "default" => [
                    ["champ"=>"etat",
                        "val"=>["Désactiver"=>
                                    ["utilisateur/activate","fa fa-toggle-off"],
                                "Activer"=>["utilisateur/deactivate","fa fa-toggle-on"]]
                                ],
                    ["utilisateur/regenerationPwd/_login_","fa fa-recycle"], //send notified data on [1], id always on [0]
                    //["utilisateur/detailUtilisateur","fa fa-search"]
                   ["utilisateur/deleteUser/_login_","fa fa-trash-o"]
                ],

                "custom" => []
            ],

            "tooltip"=> [
                "modal" => [
                    $this->lang["tooltipConsulter"],
                    $this->lang["tooltipModif"]
                ],
                "default" => [
                    ["champ"=>"etat","val"=>["Désactiver"=>$this->lang["tooltipActive"],"Activer"=>$this->lang["tooltipDesactive"]]],
                    $this->lang["tooltipRegenerer"],
                    $this->lang["tooltipRegenerer"],
                ]
            ],

            "classCss"=> [
                "modal" => [],
                "default" => ["confirm","confirm","confirm"],

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
        if($this->appConfig->profile_level == 2)
            array_push($param["button"]["default"],["utilisateur/affectation/","fa fa-male"]);
        $this->processing($this->model, "getListeProcess", $param);
    }

    public function utilisateurModal__()
    {
        //var_dump($this->paramGET);die;
        if($this->paramGET[2]) {
            $param = [
                "champs"=>["u.*", "p.profil", "a.label"],
                "jointure"=>[
                    "INNER JOIN profil p ON u.fk_profil = p.id",
                    "INNER JOIN agence a ON u.agence = a.rowid"
                ],
                "condition"=>["u.id = "=>$this->paramGET[2]]
            ];
            $data['utilisateur'] = $this->model->getUser($param)[0];
        }
        //var_dump($data);die;
        $param = [
            "table"=>"profil",
            "condition"=>["etat = "=>'Activer']
        ];
        $param1 = [
            "table"=>"agence",
            "condition"=>["etat = "=>'Activer']
        ];
        $data['profil'] = $this->model->get($param);
        $data['agence'] = $this->model->get($param1);
        $this->views->setData($data);
        $this->modal();
    }
    public function utilisateurModalDetails__()
    {
        //var_dump($this->paramGET);die;
        if($this->paramGET[2]) {
            $param = [
                "champs"=>["u.*", "p.profil", "a.label"],
                "jointure"=>[
                    "INNER JOIN profil p ON u.fk_profil = p.id",
                    "INNER JOIN agence a ON u.agence = a.rowid"
                ],
                "condition"=>["u.id = "=>$this->paramGET[2]]
            ];
            $data['utilisateur'] = $this->model->getUser($param)[0];
        }
        $param = [
            "table"=>"profil",
            "condition"=>["etat = "=>'Activer']
        ];
        $param1 = [
            "table"=>"agence",
            "condition"=>["etat = "=>'Activer']
        ];

        $this->views->setData($data);
        $this->modal();
    }

    public function regenerationModal__()
    {
        //var_dump($this->paramGET[2]);die;
        $data['rowid'] = $this->paramGET[2];
        $this->views->setData($data);
        $this->modal();
    }

    /**
     * @droit Regénérer mot de passe - 4
     */
    public function regenerationPwd()
    {
        $pass = Utils::getGeneratePassword();
        $this->paramPOST['password'] = $pass["crypt"];
        $this->paramPOST['connect'] = 1;
        $param['condition'] = ["id = "=>$this->paramGET[0]];
        $param['champs'] = [
            "password"=>$this->paramPOST["password"],
            "connect"=>$this->paramPOST["connect"],
            "user_modif"=>$this->_USER->id,
            "date_modif"=>date('Y-m-d H:i:s'),
            "pwdUpdated" => 0
        ];

        $result = $this->model->updateUser($param);

        $param = [
            "condition" => ["id = " => $this->paramGET[0]]
        ];
        $user = $this->model->getUser($param)[0];
        
        $code_collecteur = '';
        if($user->fk_profil == 2){ //Si le user à générer le mot de passe est un collecteur lui envoyé son code
            $code_collecteur = $this->lang["labcodeCollect"].' : '.$user->code_collecteur;
        }

        //

        if ($result !== false) {
            $data = [
                "subject" => $this->lang["reload_pwd1"],
                "email" => $user->email,
                "content" => "template-mail/tpl-user-create",
                "data" => [
                    "nom_client" => $user->prenom . " " . $user->nom,
                    "contenue" => $this->lang["regenere_password"]." <br>".$this->lang["alerte_connect"]." <a href='" . HOST . RACINE . "'>lien</a> <br> login: " . $this->paramGET[1] . "<br>". $this->lang["mot_de_passe"] ." ". $pass["pass"]. "<br>". $code_collecteur
                ]
            ];
            $this->sendMail($data);
            Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
        } else Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
        Utils::redirect("utilisateur", "liste");
    }


    //Supprimer un utilisateur si il n'y a pas de transaction

    public function deleteUser($param){

        $trans = $this->model->getTransactUser([intval($this->paramGET[0]), 1]);//meczy_Transactions
        $affect = $this->model->getAffectationUser([intval($this->paramGET[0])]);//meczy_affectation_materiel
        $verse = $this->model->getVersementUser([intval($this->paramGET[0]), 1]);//meczy_versement


        if ($trans[0]->nbreT > 0 || $affect[0]->nbreT > 0 || $verse[0]->nbreT > 0  ) {

            Utils::setMessageALert(["danger", $this->lang["actionechecDeleteUser"]]);

        }else{
            $param['condition'] = ["id = "=>$this->paramGET[0]];
            $param['champs'] = [
                "supp"=>1
            ];
            $result = $this->model->updateUser($param);
            Utils::setMessageALert(["success", $this->lang["actionsuccessDeleteUser"]]);
        }
        Utils::redirect("utilisateur", "liste");

    }




    /**
     * @droit Ajouter Utilisateur - 4
     */
    public function ajoutUtilisateur()
    {
        //parent::validateToken("exemples", "exemples");
        if(Utils::validateMail($this->paramPOST["email"])) {
                Utils::redirect("utilisateur", "liste");
                $pass = Utils::getGeneratePassword();
                $this->paramPOST['password'] = $pass["crypt"];
                if($this->paramPOST['flag_authorized'] == 1){
                    $this->paramPOST['connect'] = 1;
                }else { $this->paramPOST['connect'] = 0;}
                $this->paramPOST['user_crea'] = $this->_USER->id;
                $this->paramPOST['date_crea'] = date('Y-m-d H:i:s');
                //$this->paramPOST['login'] = strtolower($this->paramPOST["prenom"].$this->paramPOST["nom"]);
                $this->paramPOST['login'] = $this->paramPOST["email"];
                $result = $this->model->insertUser(["champs"=>$this->paramPOST]);

                if($result !== false) {
                    $tab=["action"=>"Ajout utilisateur", "commentaire"=>"Succès: Création d'un nouvel utilisateur","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                    $this->model->logsUser(["champs"=>$tab]);
                    if($this->paramPOST['flag_authorized'] == 1){
                        $data = [
                            "subject"=>"Création de compte utilisateur",
                            "email"=>$this->paramPOST["email"],
                            "content"=>"template-mail/tpl-user-create",
                            "data"=>[
                                "nom_client"=>$this->paramPOST["prenom"]. " " .$this->paramPOST["nom"],
                                "contenue"=>$this->lang["notification_collecteur_connect"]."  <a href='https://numherit-preprod.com/generation/'>lien</a> <br> Login: ".$this->paramPOST["login"]."<br>". $this->lang["mot_de_passe"] ." ".$pass["pass"]
                            ]
                        ];
                        $this->sendMail($data);
                        Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
                    }
                    else {
                        $data = [
                            "subject"=>"Création de compte collecteur",
                            "email"=>$this->paramPOST["email"],
                            "content"=>"template-mail/tpl-user-create",
                            "data"=>[
                                "nom_client"=>$this->paramPOST["prenom"]. " " .$this->paramPOST["nom"],
                                "contenue"=>$this->lang["notification_collecteur"]." <br> Login: ".$this->paramPOST["code_collecteur"]."<br>". $this->lang["mot_de_passe"] ." ".$pass["pass"]
                            ]
                        ];
                        $this->sendMail($data);
                        Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
                        Utils::redirect("utilisateur", "liste");
                    }

                }
                else {
                    $tab=["action"=>"Ajout utilisateur", "commentaire"=>"Echec: Création d'un nouvel utilisateur","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                    $this->model->logsUser(["champs"=>$tab]);
                    Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
                    Utils::redirect("utilisateur", "liste");
                }
            }
            else {
            Utils::setMessageALert(["warning",$this->lang["email_invalide"]]);
            Utils::redirect("utilisateur", "liste");
            }
    }

    /**
     * @droit Modifier Utilisateur - 4
     */
    public function modifUtilisateur()
    {
        //var_dump($this->paramPOST);die;
        $code_collecteur ="NULL";
        if($this->paramPOST["fk_profil"] == 2){
            $code_collecteur = $this->paramPOST["code_collecteur"];
        }

        if(Utils::validateMail($this->paramPOST["email"])) {
            if ($this->paramPOST["fk_profil"] != 2){
                $param['condition'] = ["id = "=>$this->paramPOST['id']];
                unset($this->paramPOST['id']);
                $param['champs'] = [
                    "fk_profil"=>$this->paramPOST["fk_profil"],
                    "prenom"=>$this->paramPOST["prenom"],
                    "nom"=>$this->paramPOST["nom"],
                    "user_flexcube_id"=>$this->paramPOST["user_flexcube_id"],
                    "email"=>$this->paramPOST["email"],
                    "agence"=>$this->paramPOST["agence"],
                    "code_collecteur"=>$code_collecteur,
                    "user_modif"=>$this->_USER->id,
                    "date_modif"=>date('Y-m-d H:i:s'),
                    "flag_authorized"=>1
                ];
                $result = $this->model->updateUser($param);

                if($result != false){
                    $tab=["action"=>"Modification utilisateur", "commentaire"=>"Succès: Modification informations utilisateur","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                    $this->model->logsUser(["champs"=>$tab]);
                    Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
                    Utils::redirect("utilisateur", "liste");
                }
                else {
                    $tab=["action"=>"Modification utilisateur", "commentaire"=>"Echec: Modification informations utilisateur","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                    $this->model->logsUser(["champs"=>$tab]);
                    Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
                    Utils::redirect("utilisateur", "liste");
                }
            }
            else{
                $param['condition'] = ["id = "=>$this->paramPOST['id']];
                unset($this->paramPOST['id']);
                $param['champs'] = [
                    "fk_profil"=>$this->paramPOST["fk_profil"],
                    "prenom"=>$this->paramPOST["prenom"],
                    "nom"=>$this->paramPOST["nom"],
                    "user_flexcube_id"=>$this->paramPOST["user_flexcube_id"],
                    "email"=>$this->paramPOST["email"],
                    "agence"=>$this->paramPOST["agence"],
                    "code_collecteur"=>$code_collecteur,
                    "minDepot"=>$this->paramPOST["minDepot"],
                    "maxDepot"=>$this->paramPOST["maxDepot"],
                    "minRetrait"=>$this->paramPOST["minRetrait"],
                    "maxRetrait"=>$this->paramPOST["maxRetrait"],
                    "user_modif"=>$this->_USER->id,
                    "date_modif"=>date('Y-m-d H:i:s')
                ];
                $result = $this->model->updateUser($param);

                if($result != false){
                    $tab=["action"=>"Modification utilisateur", "commentaire"=>"Succès: Modification informations utilisateur","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                    $this->model->logsUser(["champs"=>$tab]);
                    Utils::setMessageALert(["success",$this->lang["actionsuccess"]]);
                    Utils::redirect("utilisateur", "liste");
                }
                else {
                    $tab=["action"=>"Modification utilisateur", "commentaire"=>"Echec: Modification informations utilisateur","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                    $this->model->logsUser(["champs"=>$tab]);
                    Utils::setMessageALert(["danger",$this->lang["actionechec"]]);
                    Utils::redirect("utilisateur", "liste");
                }
            }
            //var_dump("HELLO");exit;



        }
        else {
            Utils::setMessageALert(["warning",$this->lang["email_invalide"]]);
            Utils::redirect("utilisateur", "liste");
        }

    }

    /**
     * @droit Activer Utilisateur - 4
     */
    public function activate()
    {
        if(intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "user", "champs" => ["etat"=>"Activer"],"condition" => ["id = "=>$this->paramGET[0]]]);
            if($result !== false) {
                $tab=["action"=>"Activation utilisateur", "commentaire"=>"Succès: Activation utilisateur","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
                Utils::redirect("utilisateur", "liste");
            }
            else {
                $tab=["action"=>"Activation utilisateur", "commentaire"=>"Echec: Activation utilisateur","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
                Utils::redirect("utilisateur", "liste");
            }
        }
        else {
            $tab=["action"=>"Activation utilisateur", "commentaire"=>"Echec: Activation utilisateur","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
            Utils::redirect("utilisateur", "liste");
        }
    }

    /**
     * @droit Désactiver Utilisateur - 4
     */
    public function deactivate()
    {
        if(intval($this->paramGET[0]) > 0) {
            $result = $this->model->set(["table" => "user", "champs" => ["etat"=>"Désactiver"],"condition" => ["id = "=>$this->paramGET[0]]]);
            if($result !== false) {
                $tab=["action"=>"Désactivation utilisateur", "commentaire"=>"Succès: Désactivation utilisateur","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
            }
            else {
                $tab=["action"=>"Désactivation utilisateur", "commentaire"=>"Echec: Désactivation utilisateur","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
                $this->model->logsUser(["champs"=>$tab]);
                Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
                Utils::redirect("utilisateur", "liste");
            }
        }
        else {
            $tab=["action"=>"Désactivation utilisateur", "commentaire"=>"Echec: Désactivation utilisateur","date"=>date('Y-m-d H:i:s'),"fk_user"=>$this->_USER->id,"fk_agence"=>$this->_USER->agence];
            $this->model->logsUser(["champs"=>$tab]);
            Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
            Utils::redirect("utilisateur", "liste");
        }
    }

    public function affectation()
    {
        $data['idUser'] = $this->paramGET[0];
        $param = [
            "champs" => ["u.id","u.prenom","u.nom","u.email","p.id as idProfil","p.profil","u.etat"],
            "jointure" => ["INNER JOIN profil p ON u.fk_profil = p.id"],
            "condition" => ["u.id = " => $data['idUser']]
        ];
        $result = $this->model->getUser($param);

        if(count($result) == 0) Utils::redirect("utilisateur", "liste");
        else $result = $result[0];

        $data['idProfil'] = $result->idProfil;
        $data['nomProfil'] = $result->profil;
        $param = [
            'table'=>'droit d',
            'champs'=> ['d.id', 'd.droit', 'sm.sous_module', 'm.module', 'd.id AS id_aff', 'd.id AS etat_aff', 'd.id AS id_aff_user', 'd.id AS etat_aff_user'],
            'jointure'=> [
                'INNER JOIN sous_module sm on d.fk_sous_module = sm.id',
                'INNER JOIN module m on sm.fk_module = m.id',
                'INNER JOIN affectation_droit ad on ad.fk_droit = d.id'
            ],
            'condition'=> ['ad.fk_profil = '=>$data['idProfil'], 'ad.etat = '=>1]
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

            $param = [
                'table'=>'affectation_droit_user',
                'champs'=>['id', 'etat'],
                'condition'=>['fk_affectation_droit ='=>$data['droit'][$key]->id_aff,'fk_user ='=>$data['idUser']]
            ];
            $temp = $this->model->get($param);

            $data['droit'][$key]->id_aff_user = $temp[0]->id;
            $data['droit'][$key]->etat_aff_user = $temp[0]->etat;
        }
        $data['droit'] = Utils::setArrayDroit($data['droit'], $this->appConfig->profile_level == 1);

        $this->views->setData($data);
        $this->views->getTemplate();
    }

    public function ajoutAffectation()
    {
        //parent::validateToken("exemples", "exemples");

        $param = [
            'table'=>'droit d',
            'champs'=>['adu.id'],
            'jointure'=>[
                "INNER JOIN affectation_droit ad ON ad.fk_droit = d.id",
                "INNER JOIN affectation_droit_user adu on adu.fk_affectation_droit = ad.id"
            ],
            'condition'=>['ad.fk_profil ='=>$this->paramPOST['idProfil'],'adu.fk_user ='=>$this->paramPOST['idUser'], 'ad.etat ='=>1, 'adu.etat ='=>1]
        ];
        $data['droit'] = $this->model->get($param);

        if (count($this->paramPOST['update'])>0) {
            foreach ($data['droit'] as $item)
                if (!in_array($item->id, $this->paramPOST['update']))
                    $this->model->set(["table" => "affectation_droit_user","champs" => ['etat' => 0],"condition" => ['id =' => $item->id]]);

            foreach ($this->paramPOST['update'] as $item)
                $this->model->set(["table" => "affectation_droit_user","champs" => ['etat' => 1],"condition" => ['id =' => $item]]);

        }
        elseif(count($data['droit'])>0)
            foreach ($data['droit'] as $item)
                $this->model->set(["table" => "affectation_droit_user","champs" => ['etat' => 0],"condition" => ['id =' => $item->id]]);

        if (count($this->paramPOST['add'])>0)
            foreach ($this->paramPOST['add'] as $item)
                $this->model->set(["table" => "affectation_droit_user","champs" => ['fk_affectation_droit' => $item, 'fk_user' => $this->paramPOST['idUser']]]);

        Utils::redirect("utilisateur", "affectation", [$this->paramPOST['idUser']]);
    }


    public function verifie(){
        $donnees = $this->paramPOST ;
        $param['condition'] = [$donnees["champ"]."= "=>$donnees["valeur"]];
        $param['champs'] = ["id"];
        $resultat = count($this->model->getUser($param));

        echo $resultat ;
    }


    public function convertToLetter(){
        $resultat = \app\core\Utils::ConvNumberLetter(intval($this->paramPOST['valeur'] ),'','');
        echo $resultat ;
    }
}