<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class UserModel extends BaseModel
{

    /**
     * HomeModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * HomeModel destruct.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * @param $param
     * @return bool|mixed
     */
    public function insertUser($param)
    {
        $this->table = "user";
        $this->__addParam($param);
        return $this->__insert();
    }

    /**
     * @param $param
     * @return bool|mixed
     */
    public function updateUser($param)
    {
       $this->table = "user";
        $this->__addParam($param);
        return $this->__update();
    }

    /**
     * @param $param
     * @return bool|mixed
     */
    public function deleteUser($param)
    {
        $this->table = "user";
        $this->__addParam($param);
        return $this->__delete();
    }

    /**
     * @param null $param
     * @return array|bool
     */
    public function getUser($param = null)
    {
        $this->table = "user u";
        $this->__addParam($param);
        //$this->condition = ["u.supp="=>0];
        return $this->__select();
    }
    /**
     * @param null $param
     * @return array|bool
     */
    public function getTransactUser($param)
    {
        $this->table = "transaction t";
        $this->champs = ["count(t.idtransaction) as nbreT"];
        $this->condition = ["t.idcollecteur="=>$param[0], "t.statut="=>$param[1]];
        return $this->__select();
    }
    /**
     * @param null $param
     * @return array|bool
     */
    public function getAffectationUser($param)
    {
        $this->table = "affectation_materiel t";
        $this->champs = ["count(t.rowid) as nbreT"];
        $this->condition = ["t.fk_collecteur="=>$param[0]];
        return $this->__select();
    }
    /**
     * @param null $param
     * @return array|bool
     */
    public function getVersementUser($param)
    {
        $this->table = "versement t";
        $this->champs = ["count(t.rowid) as nbreT"];
        $this->condition = ["t.fk_collecteur="=>$param[0]];
        return $this->__select();
    }

    public function getAgence($param = null)
    {
        $this->table = "agence ";
        $this->__addParam($param);
        return $this->__detail();
    }

    //La devise encours d'utilisation
    public function laDevise($entite)
    {
        $this->table = "parametrage p";
        $this->champs = ["p.libelle"];
        //$this->__addParam($param);
        $this->condition = ["p.rowid="=>$entite[0], "etat="=>$entite[1]];
        return $this->__select();
    }

    public function getListeProcess()
    {
        $this->table = "user u";
        $this->champs = ["u.id","u.prenom","u.nom","u.email","p.profil","a.label","u.etat","u.login AS _login_"];
        $this->jointure = [
            "INNER JOIN profil p ON u.fk_profil = p.id",
            "INNER JOIN agence a ON u.agence = a.rowid"
        ];
        $this->condition = ["u.supp="=>0];
        return $this->__processing();
    }
}