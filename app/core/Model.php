<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 25/04/2018
 * Time: 14:51
 */

namespace app\core;


class Model extends BaseModel
{
    /**
     * Model constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Model destruct.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * @param $profil
     * @param $controller
     * @param $action
     * @param null $module
     * @param null $sousModule
     * @return bool
     */
    public function __authorized($profil, $controller, $action, $module = null, $sousModule = null)
    {
        return parent::__authorized($profil, $controller, $action, $module, $sousModule);
    }

    /**
     * @param $controller
     * @param $action
     * @param null $module
     * @param null $sousModule
     * @return bool|mixed
     */
    public function authorized($controller, $action, $module = null, $sousModule = null)
    {
        return parent::__authorized($this->_USER->fk_profil, $controller, $action, $module, $sousModule);
    }
}