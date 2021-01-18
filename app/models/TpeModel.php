<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class TpeModel extends BaseModel
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
    public function insertTpe($param)
    {
        $this->table = "equipement";
        $this->__addParam($param);
        return $this->__insert();
    }

    public function insertAffectation($param)
    {
        $this->table = "affectation_materiel";
        $this->__addParam($param);
        return $this->__insert();
    }

    /**
     * @param $param
     * @return bool|mixed
     */
    public function updateTpe($param)
    {
        $this->table = "equipement";
        $this->__addParam($param);
        return $this->__update();
    }

    public function updateAffectation($param)
    {
        $this->table = "affectation_materiel";
        $this->__addParam($param);
        return $this->__update();
    }

    /**
     * @param $param
     * @return bool|mixed
     */
    public function deleteAgence($param)
    {
        $this->table = "agence";
        $this->__addParam($param);
        return $this->__delete();
    }

    /**
     * @param null $param
     * @return array|bool
     */
    public function getAgence($param = null)
    {
        $this->table = "agence a";
        $this->__addParam($param);
        return $this->__select();
    }

    public function getDevices($param = null)
    {
        $this->table = "equipement e";
        $this->__addParam($param);
        return $this->__select();
    }
    public function getOneDevice($param = null)
    {
        $this->table = "equipement e";
        $this->__addParam($param);
        return $this->__detail();
    }

    public function getOneAffectation($param = null)
    {
        $this->table = "affectation_materiel e";
        $this->__addParam($param);
        return $this->__detail();
    }

    public function getList()
    {
        $this->table = "equipement e";
        //$this->champs = ["a.rowid","CONCAT(a.code,' ',a.label) AS agence","a.responsable","r.label AS region","a.adresse","a.tel","a.email","a.etat"];
        $this->champs = ["e.rowid","e.reference","e.nom","e.uiid","u.nom as nameTpe","e.etat"];
        $this->jointure = ["LEFT JOIN user u ON e.affecter = u.id"];
        return $this->__processing();
    }

    public function getCollecteurs($param = null)
    {
       /* $condition['u.etat ='] = "Activer" ;
        $condition['u.flag_authorized ='] = 0 ;
        $condition['u.uiid'] = 'IS NULL' ;*/


        //$condition['u.uiid ='] = 'NULL' ;
        /*if($this->_USER->admin == 0)
            $condition['u.agence='] =$this->_USER->agence  ;*/
        $this->table = "user";
        $this->champs =["id","prenom", "nom"];
        $this->condition =  ["etat = ? AND flag_authorized = ? AND uiid IS NULL AND supp = ?"];
        $this->value = ["Activer",0, 0];
        //if()
        //$this->__addParam($param);
        return $this->__select();
    }

    public function affectationsEncours($param=null){
        $cond['t.etat = '] = 1 ;
        $this->table = "affectation_materiel t";
        $this->champs =["t.rowid as rowid","DATE(t.date_debut) AS datedebut","e.nom AS nom_materiel","c.prenom","c.nom","a.label","t.etat"];
        $this->jointure =["INNER JOIN user c ON c.id = t.fk_collecteur","INNER JOIN agence a ON a.rowid = c.agence","INNER JOIN equipement e ON e.rowid = t.fk_materiel"];

        if(!empty($cond))
            $this->condition = $cond ;
        return $this->__processing();
    }


    public function affectationsEncoursByTpe($param=null){

        $cond = [];
        if($param[0])
           $cond['t.fk_materiel = '] = $param[0] ;

        $this->table = "affectation_materiel t";
        $this->champs =["t.rowid as rowid","DATE(t.date_debut) AS datedebut","e.nom AS nom_materiel","c.prenom ", "c.nom","t.etat"];
        $this->jointure =["INNER JOIN user c ON c.id = t.fk_collecteur","INNER JOIN equipement e ON e.rowid = t.fk_materiel"];

        if(!empty($cond))
            $this->condition = $cond ;
        return $this->__processing();
    }

    public function ListeaffectationsEncours($param=null){
        $this->table = "affectation_materiel t";
        $this->champs =["t.rowid as rowid","DATE(t.date_debut) AS datedebut","e.nom AS nom_materiel","c.prenom ", "c.nom","t.etat","t.fk_materiel as fk_materiel","t.fk_collecteur"];
        $this->jointure =["INNER JOIN user c ON c.id = t.fk_collecteur","INNER JOIN equipement e ON e.rowid = t.fk_materiel"];
        $this->__addParam($param);
        return $this->__detail();
    }

    public function historiqueaffec($param=null){

        $cond =[];
        $cond['DATE(date_debut) >='] = $param[0];
        $cond['DATE(date_debut) <='] = $param[1];

        //$cond['t.etat'] = 0 ;
        $cond['t.etat =']= 0 ;
        $this->table = "affectation_materiel t";
        $this->champs =["t.rowid as rowid","DATE(t.date_debut) AS datedebut","e.nom AS nom_materiel","c.prenom ", "c.nom","DATE(t.date_fin) AS datefin","t.etat"];
        $this->jointure =["INNER JOIN user c ON c.id = t.fk_collecteur","INNER JOIN equipement e ON e.rowid = t.fk_materiel"];
        $this->condition = $cond ;
        return $this->__processing();
    }

    public function getUUID($idtpe)
    {
        $this->table = "equipement";
        $this->champs =["uiid"];
        $this->condition = ["rowid = "=>$idtpe];
        return $this->__detail()->uiid;
    }

    public function updateUUIDUser($param = null)
    {
        $this->table = "user";
        $this->__addParam($param);
        return $this->__update();
    }

    public function updateUser($param)
    {
        $this->table = "user";
        $this->__addParam($param);
        return $this->__update();
    }

    public function exporterTpe($id){

        $this->table = "affectation_materiel t";
        $this->champs =["t.rowid as rowid","DATE(t.date_debut) AS datedebut","e.nom AS nom_materiel","c.prenom","c.nom","a.label","t.etat","a.heuredebut","a.heurefin"];
        $this->condition = ["t.rowid = "=>$id];
        //$this->value = [$id];
        $this->jointure =["INNER JOIN user c ON c.id = t.fk_collecteur","INNER JOIN agence a ON a.rowid = c.agence","INNER JOIN equipement e ON e.rowid = t.fk_materiel"];

        return $this->__select();
    }


}