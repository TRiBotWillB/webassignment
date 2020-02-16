<?php


class app
{


    protected $controller = 'home';
    protected $method = 'index';

    protected $params = [];

    protected $routes = array();

    public function __construct()
    {
        $url = $this->parseUrl();


        // Check if a basController exists for the requested url
        if (file_exists("../app/controllers/$url[0].php")) {

            // Set the basController
            $this->controller = $url[0];
            unset($url[0]);
        }

        $this->controller = new $this->controller;

        if (isset($url[1])) {

            // Check if the method exists
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }


        // if params exist in array, set to $parms, else to empty
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }


    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            // Split URL Params into Array
            // 0 = Controller, 1 = Method, remainder = 'Params'
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }

}