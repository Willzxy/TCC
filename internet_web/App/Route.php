<?php

namespace App;

require_once '../MinhaFramework/Init/Bootstrap.php';

use MF\BootStrap;

Class Route extends BootStrap {
    function InitRoutes(){
        $routes['home'] = array(
            'route' => '/',
            'controller' => 'IndexController',
            'action' => 'index',
            'name' => 'index',
            'middleware' => 'PermitirCadastro'
        );

        $routes['cadastrar'] = array(
            'route' => '/cadastrar',
            'controller' => 'AuthController',
            'action' => 'cadastrar',
            'name' => 'cadastrar',
            'middleware' => 'PermitirCadastro'
        );

        $routes['autenticar'] = array(
            'route' => '/autenticar',
            'controller' => 'AuthController',
            'action' => 'autenticar',
            'name' => 'autenticar',
            'middleware' => 'PermitirCadastro'
        );

        $routes['sair'] = array(
            'route' => '/sair',
            'controller' => 'AuthController',
            'action' => 'sair',
            'name' => 'sair',
            'middleware' => ''
        );

        $routes['timeline'] = array(
            'route' => '/timeline',
            'controller' => 'TimelineController',
            'action' => 'timeline',
            'name' => 'timeline',
            'middleware' => 'VerificarAutenticacao'
        );

        $routes['perfil'] = array(
            'route' => '/perfil',
            'controller' => 'TimelineController',
            'action' => 'perfil',
            'name' => 'perfil',
            'middleware' => 'VerificarAutenticacao'
        );


        $this->setRoutes($routes);
    }
}