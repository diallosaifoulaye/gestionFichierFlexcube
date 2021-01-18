<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 21:11
 */

namespace app\controllers;

use app\core\BaseController;
use app\core\Language;
use app\core\Session;

class LanguageController extends BaseController
{

    public function __construct()
    {
        parent::__construct(false);
    }

    public function index()
    {
        $this->paramPOST['arg'] = strtolower($this->paramPOST['arg']);
        Session::setAttribut("lang",$this->paramPOST['arg']);
        echo Session::getAttribut("arg");
    }

    public function getLang()
    {
        if (!Session::existeAttribut("lang")) Session::setAttribut("lang", "fr");
        echo json_encode(Language::getLang(Session::getAttribut('lang')));
        exit();
    }
}