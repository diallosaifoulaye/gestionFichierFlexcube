<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 20:02
 */

namespace app\controllers;

use app\core\BaseController;
use app\core\Session;
use app\core\Utils;

class HomeController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct(false);
        $this->model = $this->model("user");
    }

    public function index__()
    {
        if(isset($this->paramGET[0])) $this->views->setData(["msg"=>$this->paramGET[0]]);
        $this->views->getPage();
    }

    public function login__()
    {

        $param = [
            "champs" => ["*"],
            "condition" => ["login = ? OR email = ? OR code_collecteur = ?"],
            "value" => [$this->paramPOST["login"], $this->paramPOST["login"], $this->paramPOST["login"]]
        ];
        //echo'<pre>', var_dump($param);die;



        $result = $this->model->getUser($param);

        //echo'<pre>', var_dump($result);die;
        
//        var_dump($this->paramPOST["password"]);
//        var_dump(password_verify($this->paramPOST["password"], $result[0]->password));die;

        /*if(($result[0]->fk_profil != 2) && ($result[0]->pwdUpdated == 0)){

            //echo'<pre>', var_dump('Not a collector change pwd');die;
            //$data['message'] = $this->lang['userdesactive'];
            //$data['updatePwd'] = $result[0]->pwdUpdated;
            //$this->views->getData(0);  // setData($data);
            //die;
            //$this->views->getPage('home/index/0 ');


            $data['lemessage'] = $result[0]->pwdUpdated;
            //echo'<pre>', var_dump($data['message']);die;
            $this->views->setData($data);
            $this->views->getPage('home/index');
        */

        //}//else{
//
            //echo'<pre>', var_dump('a collector');die;
//
//        }

        //echo'<pre>', var_dump($result);die;

        //TESTER SI L'UTILISATEUR EST DESACTIVE OU PAS
        if($result !== false && count($result) > 0){
            if($result[0]->etat == "Désactiver" || $result[0]->supp == 1){
                //Utils::setMessageALert(["danger",$this->lang['userdesactive']]);
                //Utils::redirect("home", "index", [0]);
                //Utils::redirect("home", "index");
                $data['message'] = $this->lang['userdesactive'];
                $this->views->setData($data);
                $this->views->getPage('home/index');
            }
            else{
                if($result[0]->flag_authorized != 0 ){
                    if(password_verify($this->paramPOST["password"], $result[0]->password)) {


                        $param1 = [
                            "champs" => ["*"],
                            "condition" => ["rowid = ?"],
                            "value" => [$result[0]->agence]
                        ];

                        $nomagence = htmlentities($this->model->getAgence($param1)->label)  ;


                        //echo 445466445656; exit;
                        Session::set_User_Connecter($result);
                        $devise = $this->model->laDevise([1, 'Activer']) ;
                        $_SESSION['devise'] = $devise[0]->libelle ;
                        $_SESSION['nomAgence'] = $nomagence ;
                        $_SESSION['codeAgence'] =  htmlentities($this->model->getAgence($param1)->code)  ;
                        //var_dump($this->paramPOST); exit;
                        if (isset($this->paramPOST["lang"]) && ($this->paramPOST["lang"]!= null)){

                            //exit;
                            Session::setAttribut("lang", $this->paramPOST["lang"]);
                        }
                        //Session::setAttribut("lang", "fr");
                        //echo'<pre>', var_dump($_SESSION['devise']);die;
                        if($result[0]->connect == 1){
                            Utils::setMessageALert(["success",$this->lang['userchangepass']]);
                            Utils::redirect("utilisateur", "renewPassword", [$result[0]->id, $result[0]->password]);
                        }
                        else{
                            Utils::setMessageALert(["success",$this->lang['userconnect']]);
                            Utils::redirect("fichier", "liste");
                        }
                    }
                    else {
                        $data['message'] = $this->lang['wrongpass'];
                        $this->views->setData($data);
                        $this->views->getPage('home/index');                    }
                }
                else {
                    $data['message'] = $this->lang['user_no_authorized'];
                    $this->views->setData($data);
                    $this->views->getPage('home/index');
                }

            }

        }
        else{

            $data['message'] = $this->lang['userdontexist'];
           // var_dump($data); exit;
            $this->views->setData($data);
            $this->views->getPage('home/index');
            //Utils::setMessageALert(["danger",$this->lang['userdontexist']]);
            //Utils::redirect("home", "index");
        }



    }

    public function logout__()
    {
        Session::destroySession();
        Utils::redirect();
    }

    public function menu__(){
        $this->views->initTemplate(["header" => "header", "footer" => "footer", "sidebar" => "sidebar"]);
        $this->views->getTemplate('home/menu');
    }


    public function regenerationPwd()
    {
        $pass = Utils::getGeneratePassword();
        $this->paramPOST['password'] = $pass["crypt"];
        $this->paramPOST['connect'] = 1;
        $param['condition'] = ["email = "=>$this->paramPOST['email']];
        $param['champs'] = [
            "password"=>$this->paramPOST["password"],
            "connect"=>$this->paramPOST["connect"],
            "user_modif"=>$this->_USER->id,
            "date_modif"=>date('Y-m-d H:i:s')
        ];

        $result = $this->model->updateUser($param);

        $param = [
            "condition" => ["email = " => $this->paramPOST['email']]
        ];
        $user = $this->model->getUser($param)[0];

        if ($result !== false) {
            $data = [
                "subject" => $this->lang["reload_pwd1"],
                "email" => $user->email,
                "content" => "template-mail/tpl-user-create",
                "data" => [
                    "nom_client" => $user->prenom . " " . $user->nom,
                    "contenue" => $this->lang["contenu_mail_regenerationPwd_1"].",<br>".$this->lang["contenu_mail_regenerationPwd_2"] ."<a href='" . HOST . RACINE . "'>".
                    $this->lang["lien"]."</a><br>".$this->lang["login"].$this->paramGET[1]."<br>".$this->lang["new_password"].$pass["pass"]

                ]
            ];
            $this->sendMail($data);
            //Utils::setMessageALert(["success", $this->lang["actionsuccess"]]);
        } //else Utils::setMessageALert(["danger", $this->lang["actionechec"]]);
        Utils::redirect("home", "index");
    }

    public function sendEmailToAdmin(){
        $email = $this->paramPOST["email"] ;

        $param = [
            "condition" => ["admin = " => 1]
        ];

        $admins = $this->model->getUser($param) ;
        if ($admins  !== false){
            foreach ($admins as $admin){
                $data = [
                    "subject" => $this->lang["reload_pwd1"],
                    "email" => $admin->email,
                    "content" => "template-mail/tpl-user-create",
                    "data" => [
                        "nom_client" => $admin->prenom . " " . $admin->nom,
                        "contenue" => $this->lang["user"].$email.", <br>". $this->lang["contenu_mail_sendEmailToAdmin_1"] ."<br>". $this->lang["contenu_mail_sendEmailToAdmin_2"]  ."<a href='" . HOST . RACINE . "'>Meczy</a> <br> "
                    ]
                ];
                $this->sendMail($data);
            }
            $message = $this->lang["actionsuccess"];
        }else
            $message = $this->lang["actionechec"];
        Utils::redirect("home", "index",[0 => $message]);


    }

    public function verifie(){
        $donnees = $this->paramPOST ;
        $param['condition'] = [$donnees["champ"]."= "=>$donnees["valeur"]];
        $param['champs'] = ["id"];
        $resultat = count($this->model->getUser($param));

        echo $resultat ;
    }


}