<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 17/08/2017
 * Time: 11:01
 */

namespace app\core;

class ApiClientSoap
{
    private $server;
    private $uri;
    public  $response;
    public  $error;
    public  $service;
    public  $params;

    public function __construct($uri)
    {
        $this->uri = $uri;
        $this->server = new \nusoap_client($this->uri,true);
    }

    public function call()
    {
        $this->response = $this->server->call($this->service, $this->params);
        $this->error = $this->server->getError();
    }

}