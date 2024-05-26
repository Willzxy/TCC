<?php

namespace App\Controllers;

require_once '../MinhaFramework/Controllers/action.php';
require_once '../App/Models/Usuarios.php';

use App\Models\Usuarios;
use MF\Action;

class PerfilController extends Action {
    function atualizarperfil(){
        $nome = trim($_POST['nome']);
        $descricao = trim($_POST['descricao']);

        $usuario = new Usuarios;
        $usuario->__set("nome", $nome);
        $usuario->__set("sobremim", $descricao);
        $usuario->__set('id', $usuario->buscarID($_SESSION['email']));

        $usuario->atualizar_perfil();
        $usuario->AtualizarDadosSecao();
        $this->redirect('/perfil');
    }
}