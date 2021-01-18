<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class AgenceModel extends BaseModel
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
    public function insertAgence($param)
    {
        $this->table = "agence";
        $this->__addParam($param);
        return $this->__insert();
    }

    /**
     * @param $param
     * @return bool|mixed
     */
    public function updateAgence($param)
    {
        $this->table = "agence";
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
    public function getRegion()
    {
        $this->table    = "region c";
        $this->champs   = ["*"];
        $this->condition=["etat="=>"Activer"];
        return $this->__select();
    }
    public function getDept()
    {
        $this->table    = "departement";
        $this->champs   = ["*"];
        $this->condition=["etat="=>"Activer"];
        return $this->__select();
    }
    public function getCom()
    {
        $this->table    = "commune";
        $this->champs   = ["*"];
        $this->condition=["etat="=>"Activer"];
        return $this->__select();
    }
    public function getDepartementByRegion($idtyped)
    {

        $this->table = "departement";
        $this->champs = ['*'];
        $this->condition = ["fk_region="=>$idtyped["region_rowid"],"etat = "=>"Activer"];
        return $this->__select();

    }

    public function getCommuneByDepartement($idtyped)
    {

        $this->table = "commune";
        $this->champs = ['*'];
        $this->condition = ["fk_departement="=>$idtyped["dept_rowid"],"etat = "=>"Activer"];
        return $this->__select();

    }

    public function getList()
    {
        $this->table = "agence a";
        //$this->champs = ["a.rowid","CONCAT(a.code,' ',a.label) AS agence","a.responsable","r.label AS region","a.adresse","a.tel","a.email","a.etat"];
        $this->champs = ["a.rowid","a.code","a.label","a.responsable","r.libelle AS commune","a.adresse","a.tel","a.email","a.etat"];
        //$this->jointure = ["INNER JOIN region r ON a.fk_region = r.rowid"];
        $this->jointure = ["INNER JOIN commune r ON a.fk_commune = r.id"];
        return $this->__processing();
    }
}