<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 27/02/2017
 * Time: 16:03
 */

namespace app\models;

use app\core\BaseModel;

class HomeModel extends BaseModel
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

    public function getUtilisateur($param = null)
    {
        $this->table = "utilisateur";
        $this->__addParam($param);
        return $this->__select();
    }
    public function getOneUtilisateur($param = null)
    {
        $this->table = "utilisateur";
        $this->__addParam($param);
        return $this->__detail();
    }


}