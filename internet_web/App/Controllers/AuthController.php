<?php

namespace App\Controllers;

require_once '../MinhaFramework/Controllers/action.php';
require_once '../App/Models/Usuarios.php';

use App\Models\Usuarios;
use MF\Action;

class AuthController extends Action {
    public function cadastrar(){
        $senhaMD5 = md5($_POST['senha']);

        $classe = new Usuarios();

        $classe->__set('nome', $_POST['nome']);
        $classe->__set('senha', $senhaMD5);
        $classe->__set('email', $_POST['email']);
        $classe->Cadastrar();

        session_start();
        $_SESSION['autenticado'] = true;
        $_SESSION['nome'] = $_POST['nome'];

        $this->redirect('/timeline');
    }

    public function autenticar(){
        
    }

    public function sair(){
        session_start();
        session_destroy();
    }
}