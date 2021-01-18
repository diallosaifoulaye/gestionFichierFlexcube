<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class DroitModel extends BaseModel
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
    public function insertDroit($param)
    {
        $this->table = "droit";
        $this->__addParam($param);
        return $this->__insert();
    }
    /**
     * Processing module
     */
    public function getListeProcess()
    {
        $this->table = "droit d";
        $this->champs = ["d.id","d.droit","sm.sous_module","d.controller","d.action"];
        $this->jointure = [
            "   INNER JOIN sous_module sm ON d.fk_sous_module = sm.id"
        ];
        return $this->__processing();
    }

    /**
     * @param null $param
     * @return array|bool
     */
    public function getDroit($param = null)
    {
        $this->table = "droit";
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * @param $param
     * @return bool|mixed
     */
    public function updateDroit($param)
    {
        $this->table = "droit";
        $this->__addParam($param);
        return $this->__update();
    }

    /**
     * @param $param
     * @return null|string
     */
    public function deleteDroit($param)
    {
        $this->table = "droit";
        $this->__addParam($param);
        return $this->__delete();
    }


}