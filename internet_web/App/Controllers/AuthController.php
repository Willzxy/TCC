<?php

namespace App\Controllers;

require_once '../MinhaFramework/Controllers/action.php';
require_once '../App/Models/Usuarios.php';

use App\Models\Usuarios;
use MF\Action;

class AuthController extends Action {
    public function cadastrar(){
        $debug = $this->validarDados($_POST['nome'], $_POST['senha'], $_POST['email']);

        $classe = new Usuarios();
        $classe->__set('email', $_POST['email']);

        $verificar_email = $classe->verificar_email();
        if(!$debug){
            $this->redirect('/?login=1');
        }elseif($verificar_email){
            $this->redirect('/?login=2');
        }else{
            $senhaMD5 = md5($_POST['senha']);
            $classe->__set('nome', $_POST['nome']);
            $classe->__set('senha', $senhaMD5);
            $classe->cadastrar();

            session_start();
            $_SESSION['autenticado'] = true;
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['nome'] = $_POST['nome'];

            $this->redirect('/timeline');
        }
    }

    public function autenticar(){
        $senhaMD5 = md5($_POST['senha']);

        $classe = new Usuarios();

        $classe->__set('email', $_POST['email']);
        $classe->__set('senha', $senhaMD5);

        $autenticado = $classe->autenticar();

        if($autenticado){
            session_start();
            $_SESSION['autenticado'] = true;
            $_SESSION['nome'] = 'depois nós faz isso kakakaka';

            $this->redirect('/timeline');
        }else {
            $this->redirect('/?login=3');
        }
    }

    public function validarDados($nome, $senha, $email){
        $debug = true;

        $nome = str_replace(' ', '', $nome);
        $email = str_replace(' ', '', $email);

        if($nome == '' || $email == ''){
            $debug = false;
        }

        if(strlen($senha) > 32) {
            $debug = false;
        }

        if(strlen($nome) > 120) {
            $debug = false;
        }

        if(strlen($email) > 200) {
            $debug = false;
        }

        return $debug;
    }


    public function sair(){
        session_start();
        session_destroy();

        $this->redirect('/');
    }
}