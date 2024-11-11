<?php

class App{
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        if (isset($url[0]) && file_exists('../app/Controllers/' . $url[0] . 'Controller.php')) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        }
        require_once '../app/Controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
    public function parseUrl(){
        if (isset($_GET['url'])) {
            return array_values(array_filter(explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL))));

        }
        else {
             return []; // Return an empty array if 'url' is not set
        }
    }
}