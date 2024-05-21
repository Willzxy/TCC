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

        $routes['minharede'] = array(
            'route' => '/minharede',
            'controller' => 'MinhaRedeController',
            'action' => 'minharede',
            'name' => 'minharede',
            'middleware' => 'VerificarAutenticacao'
        );

        $routes['pesquisar'] = array(
            'route' => '/pesquisar',
            'controller' => 'MinhaRedeController',
            'action' => 'pesquisar',
            'name' => 'pesquisar',
            'middleware' => 'VerificarAutenticacao'
        );

        $routes['perfil'] = array(
            'route' => '/perfil',
            'controller' => 'TimelineController',
            'action' => 'perfil',
            'name' => 'perfil',
            'middleware' => 'VerificarAutenticacao'
        );

        $routes['atualizarperfil'] = array(
            'route' => '/atualizarperfil',
            'controller' => 'PerfilController',
            'action' => 'atualizarperfil',
            'name' => 'atualizarperfil',
            'middleware' => 'VerificarAutenticacao'
        );

        $this->setRoutes($routes);
    }
}