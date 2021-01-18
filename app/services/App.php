<?php

/**
 * Created by PhpStorm.
 * User: Seyni FAYE
 * Date: 15/02/2017
 * Time: 19:44
 */

namespace app\services;
use app\controllers\ErrorController;
use app\core\Security;
use app\core\Utils;
use app\core\Session;

class App extends Security
{
    private $method = null;
    private $controller = null;
    private $params = [];

    /**
     * App constructor.
     */
    public function __construct()
    {
        parent::__construct();

        foreach ($this->appConfig as $key => $value) {
            if(Utils::startsWith($key, 'CONST_')) {
                $key = \strtoupper(\str_replace('CONST_','',$key));
                define($key, $value);
            }
        }

        Session::setAttributArray("url",$this->url);
        $paramError = array_values($this->url);

        if(\array_key_exists($this->url[0]."_prefix_controller", $this->appConfig)) {
            define('SPACE', $this->url[0]);
            define('WEBROOT', \str_replace('index.php', $this->url[0]."/", $_SERVER['SCRIPT_NAME']));
            define('SESSIONNAME', $this->appConfig['session_name']."_".$this->url[0]);
            define('Prefix_Controller', $this->appConfig[$this->url[0]."_prefix_controller"]);
            define('Prefix_Model', $this->appConfig[$this->url[0]."_prefix_model"]);
            define('Prefix_View', $this->appConfig[$this->url[0]."_prefix_view"]);
            unset($this->url[0]);
            $this->url = (!empty($this->url)) ? array_values($this->url) : ['Home', 'index'];
        }
        else {
            define('SPACE', "default");
            define('WEBROOT', \str_replace('index.php','', $_SERVER['SCRIPT_NAME']));
            define('SESSIONNAME', $this->appConfig['session_name']);
            define('Prefix_Controller', $this->appConfig["default_prefix_controller"]);
            define('Prefix_Model', $this->appConfig["default_prefix_model"]);
            define('Prefix_View', $this->appConfig["default_prefix_view"]);
        }

        $this->controller = new ErrorController();
        $this->method = 'error';

        $file = sprintf(ROOT . str_replace("\\","/",Prefix_Controller) .'%sController.php', ucfirst($this->url[0]));
        if (file_exists($file)) {
            $this->controller = Prefix_Controller . ucfirst($this->url[0]) . 'Controller';
            $controller = $this->url[0];
            unset($this->url[0]);
            $this->controller = new $this->controller();
            if (method_exists($this->controller, $this->url[1]) || method_exists($this->controller, $this->url[1]."__")) {
                $this->method = (method_exists($this->controller, $this->url[1])) ? $this->url[1] : $this->url[1]."__";
                unset($this->url[1]);
                if(method_exists($this->controller, "authorized")
                    && !in_array(strtolower($controller), ['error', 'language'])
                    && !Utils::endsWith($this->method,"__"))
                    $this->controller->authorized($controller,$this->method);
                if(count($this->url) > 0) foreach ($this->url as $key => $val) (is_int($key)) ? array_push($this->params, $val) : $this->params[$key] = $val;
            } else{
                $this->controller = new ErrorController();
                Utils::setMessageError(['404',$paramError]);
            }
        }else Utils::setMessageError(['404',$paramError]);

        if(count($this->params) > 0) $this->controller->setParamGET(Utils::setBase64_decode_array($this->params));
        if(count($_POST) > 0) $this->controller->setParamPOST(Utils::setBase64_decode_array($_POST));
//        if(count($_POST) > 0) $this->controller->setParamPOST($_POST);
        if(count($_FILES) > 0) $this->controller->setParamFILE($_FILES);
        @call_user_func_array([$this->controller, $this->method],[]);
    }
}