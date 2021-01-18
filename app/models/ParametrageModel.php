<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class ParametrageModel extends BaseModel
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

    public function getList()
    {
        $this->table = "parametrage";
        $this->champs = ["rowid","libelle","etat"];
        return $this->__processing();
    }
}