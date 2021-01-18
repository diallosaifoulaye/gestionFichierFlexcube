<?php
/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 17/08/2017
 * Time: 11:01
 */

namespace app\core;

use GuzzleHttp\Client;

abstract class ApiClient
{
    private $uri;
    public  $soap;
    private $_USER;
    private $client;
    private $params;
    private $result;
    private $resultRequest;
    private $method = "get";
    private $paramGET  = [];
    private $paramPOST = [];
    private $paramFILE = [];

    public function __construct()
    {
        $this->params = ["headers"=>['Content-Type' => 'application/json; charset=utf-8','Accept' => 'application/json']];
        if(Session::existeAttribut(SESSIONNAME)) $this->_USER = Session::getAttributArray(SESSIONNAME)[0];
    }

    protected function useInstanceSoap()
    {
        $this->soap = new ApiClientSoap($this->uri);
    }

    /**
     * @return mixed
     */
    protected function getUri()
    {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri)
    {
        $this->method = (isset($this->paramGET[0])) ? $this->paramGET[0] : $this->method;
        $this->uri = (isset($this->paramGET[1])) ? $uri."/".$this->paramGET[1].".php" : $uri;
        if(isset($this->params['get_params'])){
            $this->uri .= "?";
            foreach ($this->params['get_params'] as $key => $item) $this->uri .= "$key=$item&";
        }
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        if(isset($this->paramGET[1])) $this->setParams($data[$this->paramGET[1]]);
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @param mixed $service
     */
    public function setService($service)
    {
        $this->paramGET[1] = $service;
    }

    /**
     * @param mixed $params
     */
    protected function setParams($params)
    {
        if(isset($params["headers"])) {
            $this->params["headers"] = array_merge($this->params["headers"], $params["headers"]);
            unset($params["headers"]);
        }
        if(isset($params["auth"])) {
            $this->params["auth"] = $params["auth"];
            unset($params["auth"]);
        }

        $get = $params["get"];
        unset($params["get"]);

        if(strtolower($this->method) == "get") $this->params["get_params"] = $params;
        elseif(strtolower($this->method) == "post") $this->params["form_params"] = $params;

        if(isset($get))
            $this->params["get_params"] = (is_array($this->params["get_params"])) ? array_merge($this->params["get_params"], $get) : $get;
    }

    protected function result()
    {
        $this->result = (is_null(\json_decode($this->result))) ? (string)$this->result : $this->result;
        return $this->result;
    }

    protected function request()
    {
        try{
            $this->client = new Client(["headers"=>$this->params["headers"]]);
            $method = strtolower($this->method);
            unset($this->params["get_params"]);

            $promise = $this->client->requestAsync($method, $this->uri, $this->params)->then(function ($response) {
                var_dump($response);die;
                $this->resultRequest = $response;
                $this->result = $this->resultRequest->getBody();
            });
            $promise->wait();
        }catch(\Exception $ex){
            $this->result = [
                "status"=>$ex->getCode(),
                "message"=>$ex->getMessage()
            ];
        }
    }

    /**
     * @param $paramGET
     */
    public function setParamGET($paramGET)
    {
        $this->paramGET = $paramGET;
    }

    /**
     * @param $paramPOST
     */
    public function setParamPOST($paramPOST)
    {
        $this->paramPOST = $paramPOST;
    }

    /**
     * @param $paramFILE
     */
    public function setParamFILE($paramFILE)
    {
        $this->paramFILE = $paramFILE;
    }
}