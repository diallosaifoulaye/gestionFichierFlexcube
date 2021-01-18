<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class PartenaireModel extends BaseModel
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
    public function insertPartenaire($param)
    {
        $this->table = "gestion_partenaire";
        $this->__addParam($param);
        return $this->__insert();
    }

    /**
     * @param $param
     * @return bool|mixed
     */
    public function updatePartenaire($param)
    {
        $this->table = "gestion_partenaire";
        $this->__addParam($param);
        return $this->__update();
    }


    public function getList()
    {
        $this->table = "gestion_partenaire p";
        $this->champs = ["p.id","p.nom","p.code","p.etat"];
        return $this->__processing();
    }

    public function getOnePartenaire($param = null)
    {
        $this->table = "gestion_partenaire p";
        $this->champs = ["p.id","p.nom","p.code","p.etat"];
        $this->__addParam($param);
        return $this->__detail();
    }
}