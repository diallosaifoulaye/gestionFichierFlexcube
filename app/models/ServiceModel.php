<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class ServiceModel extends BaseModel
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
    public function insertService($param)
    {
        $this->table = "service";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Processing module
     */
    public function getListeProcess()
    {
        $this->table = "service s";
        $this->champs = ["s.id","s.label","p.etat","p.id as _id_profil_"];
        $this->jointure = ["INNER JOIN profil p ON s.fk_profil = p.id"];
        return $this->__processing();
    }

    /**
     * @param null $param
     * @return array|bool
     */
    public function getService($param = null)
    {
        $this->table = "service";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * @param $param
     * @return bool|mixed
     */
    public function updateService($param)
    {
        $this->table = "service";
        $this->__addParam($param);
        return $this->__update();
    }

    /**
     * @param $param
     * @return null|string
     */
    public function deleteService($param)
    {
        $this->table = "service";
        $this->__addParam($param);
        return $this->__delete();
    }

}