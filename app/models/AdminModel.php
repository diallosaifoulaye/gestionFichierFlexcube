<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class AdminModel extends BaseModel
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

    //--------------------REGION

    public function getRegionProcess()
    {
        $this->table = "region r";
        $this->champs = ["r.rowid","r.label","r.etat as etat"];
        return $this->__processing();
    }

    public function insertRegion($param)
    {
        $this->table = "region";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function updateRegion($param)
    {
        $this->table = "region";
        $this->__addParam($param);
        return $this->__update();
    }

    public function deleteRegion($param)
    {
        $this->table = "region";
        $this->__addParam($param);
        return $this->__delete();
    }

    public function getOneRegion($param = null)
    {
        $this->table = "region";
        $this->__addParam($param);
        return $this->__select();
    }

    //--------------------DEPARTEMENT

    public function getDeptProcess()
    {
        $this->table    = "departement d";
        $this->champs   = ["d.rowid","d.label","r.label AS nomregion","d.etat as etat"];
        $this->jointure = ["INNER JOIN region r ON r.rowid = d.fk_region"];
        return $this->__processing();
    }

    public function insertDept($param)
    {
        $this->table = "departement";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function updateDept($param)
    {
        $this->table = "departement";
        $this->__addParam($param);
        return $this->__update();
    }

    public function deleteDept($param)
    {
        $this->table = "departement";
        $this->__addParam($param);
        return $this->__delete();
    }

    public function getOneDept($param = null)
    {
        $this->table = "departement";
        $this->__addParam($param);
        return $this->__select();
    }

    //--------------------COMMUNE

    public function getComProcess()
    {
        $this->table    = "commune c";
        $this->champs   = ["c.id","c.libelle","d.label","c.etat"];
        $this->jointure = ["INNER JOIN departement d ON d.rowid = c.fk_departement"];
        return $this->__processing();
    }

    public function insertCom($param)
    {
        $this->table = "commune";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function updateCom($param)
    {
        $this->table = "commune";
        $this->__addParam($param);
        return $this->__update();
    }

    public function deleteCom($param)
    {
        $this->table = "commune";
        $this->__addParam($param);
        return $this->__delete();
    }

    public function getOneCom($param = null)
    {
        $this->table = "commune";
        $this->__addParam($param);
        return $this->__select();
    }

    //-----------------DEVISE
    /**
     * @param $param
     * @return bool|mixed
     */
    public function insertParametrage($param)
    {
        $this->table = "parametrage";
        $this->__addParam($param);
        return $this->__insert();
    }

    /**
     * @param $param
     * @return bool|mixed
     */
    public function updateParametrage($param)
    {
        $this->table = "parametrage";
        $this->__addParam($param);
        return $this->__update();
    }

    /**
     * @param $param
     * @return bool|mixed
     */
    public function deleteParametrage($param)
    {
        $this->table = "parametrage";
        $this->__addParam($param);
        return $this->__delete();
    }

    /**
     * @param null $param
     * @return array|bool
     */
    public function getParametrage($param = null)
    {
        $this->table = "parametrage";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * @param null $param
     * @return array|bool
     */
    public function getList()
    {
        $this->table = "parametrage";
        $this->champs = ["rowid","libelle","etat"];
        return $this->__processing();
    }

     public function getListHours()
        {
            $this->table = "hours";
            $this->champs = ["rowid","min","max"];
            $this->condition=["etat ="=>"Activer"];
            return $this->__processing();
        }


    //region hours CRUD
    public function getHoursProcess()
    {
        $this->table = "hours";
        $this->champs = ["rowid","CONCAT(min,' à ',max) as label","etat"];
        return $this->__processing();
    }

    public function getOneHour($param = null)
    {
        $this->table = "hours";
        $this->__addParam($param);
        return $this->__select();
    }

    public function insertHour($param)
    {
        $this->table = "hours";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function updateHour($param)
    {
        $this->table = "hours";
        $this->__addParam($param);
        return $this->__update();
    }
    //endregion

    public function getActionProcess($param)
    {
        $cond = ["DATE(date) >="=>$param[0], "DATE(date) <="=>$param[1]];
        $this->table = "action_utilisateur a";
        $this->champs = ["a.id","a.action","a.commentaire","CONCAT(prenom,' ',nom)","ag.label","a.date"];
        $this->jointure = ["INNER JOIN user u ON u.id = a.fk_user","INNER JOIN agence ag ON ag.rowid = a.fk_agence"];
        $this->condition = $cond ;
        return $this->__processing();
    }


    public function insertDictionnaireMattriculeCompte($param)
    {
        $this->table = "dictionnaire_mat_compte_banque";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function updateDictionnaireMattriculeCompte($param)
    {
        $this->table = "dictionnaire_mat_compte_banque";
        $this->__addParam($param);
        return $this->__update();
    }

    public function getOneMattriculeCompte($param = null)
    {
        $this->table = "dictionnaire_mat_compte_banque";
        $this->__addParam($param);
        return $this->__select();
    }


    public function getDictionnaireMattriculeCompteProcess()
    {
        $this->table    = "dictionnaire_mat_compte_banque";
        $this->champs   = ["rowid","matricule","num_compte","statut as etat"];
       // $this->champs   = ["rowid","matricule","num_compte","code_agence","statut as etat"];
        //$this->jointure = ["INNER JOIN departement d ON d.rowid = c.fk_departement"];
        return $this->__processing();
    }


    public function verifmatriculeCompte($matricule, $compte){
        $this->table        = "dictionnaire_mat_compte_banque";
        $this->champs       = ["*"];
        $this->condition    = ["matricule = ? OR num_compte = ?"];
        $this->value        = [$matricule, $compte];
        return $this->__select();
    }

}