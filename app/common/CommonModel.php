<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 31/01/2018
 * Time: 12:52
 */

namespace app\common;

use app\core\Session;

trait CommonModel
{
    /*
     * Créer ici des méthodes appelable par toutes les classes models.
     */

    /**
     * @param $param
     * @return mixed
     */
    public function get($param)
    {
        $this->__addParam($param);
        return $this->__select();
    }

    /**
     * @param $param
     * @return mixed
     */
    public function set($param)
    {
        $this->__addParam($param);
        return (isset($param['champs']) && isset($param['condition'])) ? $this->__update() : ((!isset($param['champs']) && isset($param['condition'])) ? $this->__delete() : $this->__insert());
    }

    /**
     * @param $controller
     * @param $action
     * @return mixed
     */
    public function authorized($controller, $action)
    {
        return $this->__authorized($this->_USER->fk_profil, $controller, $action);
    }

    public function logsUser($param)
    {
        $this->table = "action_utilisateur";
        $this->__addParam($param);
        $this->__insert();
    }

}