<?php

namespace MF;

abstract class BootStrap {
    private $routes;

    function setRoutes($attr1){
        $this->routes = $attr1;
    }

    function __construct(){
        $this->InitRoutes();
        $this->run($this->getUrl());
    }

    abstract protected function InitRoutes();

    function run(){
        $erro404 = true;
        foreach ($this->getRoutes() as $key => $value) {
            if($value['route'] == $this->getUrl()){
                $erro404 = false;

                if($value['middleware'] != ''){
                    require_once '../App/Middleware/'. $value['middleware'] . '.php';

                    $class = 'App\\Middleware\\'.$value['middleware'];
                
                    $instance = new $class;
                    $action = 'action';

                    $instance->$action();
                }

                $controller = $value['controller'] . '.php';
                
                require_once '../App/Controllers/'.$controller;

                $class = 'App\\Controllers\\'.$value['controller'];
                
                $instance = new $class;
                $action = $value['action'];

                $instance->$action();
            }
        }

        if($erro404){
            echo 'Rota não encontrada';
            print($this->getUrl());
        }
    }

    function getRoutes(){
        return $this->routes;
    }

    function getUrl(){
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}