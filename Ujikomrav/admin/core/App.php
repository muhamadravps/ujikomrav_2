<?php

class App{
    protected $controller   = 'Portofolio'; //controller default
    protected $method       = 'index';      //method defaul
    protected $params       = [];           //parameter jika ada

    public function __construct()
    {
        $url = $this->parseURL();

        
        if (file_exists('../admin/controllers/'.$url[0].'.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }
        require_once '../admin/controllers/'.$this->controller.'.php';
        $this->controller = new $this->controller;

        
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        
        call_user_func_array([$this->controller,$this->method],$this->params);
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            
            $url = rtrim($_GET['url'],'/');


            $url = filter_var($url, FILTER_SANITIZE_URL);

            
            $url = explode('/', $url);
            return $url;
        }
    }

}

?>