<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class SousModuleModel extends BaseModel
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
    public function insertSousModule($param)
    {
        $this->table = "sous_module";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Processing module
     */
    public function getListeProcess()
    {
        $this->table = "sous_module sm";
        $this->champs = ["sm.id","m.module","sm.sous_module"];
        $this->jointure = [
            "INNER JOIN module m ON sm.fk_module = m.id"
        ];
        return $this->__processing();
    }

    /**
     * @param null $param
     * @return array|bool
     */
    public function getSousModule($param = null)
    {
        $this->table = "sous_module";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * @param $param
     * @return bool|mixed
     */
    public function updateSousModule($param)
    {
        $this->table = "sous_module";
        $this->__addParam($param);
        return $this->__update();
    }

    /**
     * @param $param
     * @return null|string
     */
    public function deleteSousModule($param)
    {
        $this->table = "sous_module";
        $this->__addParam($param);
        return $this->__delete();
    }


}