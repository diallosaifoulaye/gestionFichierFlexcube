<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class ModuleModel extends BaseModel
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
    public function insertModule($param)
    {
        $this->table = "module";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Processing module
     */
    public function getListeProcess()
    {
        $this->table = "module";
        $this->champs = ["id","module"];
        return $this->__processing();
    }

    /**
     * @param null $param
     * @return array|bool
     */
    public function getModule($param = null)
    {
        $this->table = "module";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * @param $param
     * @return bool|mixed
     */
    public function updateModule($param)
    {
        $this->table = "module";
        $this->__addParam($param);
        return $this->__update();
    }

    /**
     * @param $param
     * @return null|string
     */
    public function deleteModule($param)
    {
        $this->table = "module";
        $this->__addParam($param);
        return $this->__delete();
    }


}