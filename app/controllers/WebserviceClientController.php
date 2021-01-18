<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 20:02
 */

namespace app\controllers;

use app\core\ApiClient;
use app\core\ApiClientSoap;

class WebserviceClientController extends ApiClient
{
    public function __construct()
    {
        parent::__construct();
    }

    public function safClient()
    {
        $this->setUri("40.71.97.56/meczy/api");
        //$this->setUri("https://www.numherit-labs.com".WEBROOT."vendor/api");
        $this->request();
        return $this->result();
    }

}