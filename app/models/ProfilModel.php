<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class ProfilModel extends BaseModel
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
    public function insertProfil($param)
    {
        $this->table = "profil";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Processing module
     */
    public function getListeProcess()
    {
        $this->table = "profil p";
        $this->champs = ["p.id","p.profil","p.etat"];
        return $this->__processing();
    }

    /**
     * @param null $param
     * @return array|bool
     */
    public function getProfil($param = null)
    {
        $this->table = "profil";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * @param $param
     * @return bool|mixed
     */
    public function updateProfil($param)
    {
        $this->table = "profil";
        $this->__addParam($param);
        return $this->__update();
    }

    /**
     * @param $param
     * @return null|string
     */
    public function deleteProfil($param)
    {
        $this->table = "profil";
        $this->__addParam($param);
        return $this->__delete();
    }
}