<?php

namespace App\Controllers;

require_once '../MinhaFramework/Controllers/action.php';
require_once '../App/Models/tb_usuarios.php';
require_once '../App/Models/tb_postagens.php';

use App\Models\tb_usuarios;
use App\Models\tb_postagens;
use MF\Action;

class TimelineController extends Action {
    public function timeline(){
        $usuarios = new tb_usuarios;
        $postagens = new tb_postagens;

        $id = $usuarios->buscarID($_SESSION['email']);
        $this->view->timeline = $postagens->atualizar_timeline($id);
        $this->view->quantidade_postagens = $postagens->quantidade_postagem($id);

        $this->render('autenticado.timeline');
    }

    public function criarpostagem(){
        $conteudo = $_POST['texto'];
        $privacidade = $_POST['privacidade'];
        $imagem = $_FILES['imagem'];
        $data = date('Y-m-d');

        $postagens = new tb_postagens;
        $usuarios = new tb_usuarios;

        $id = $usuarios->buscarID($_SESSION['email']);

        if($imagem['name'] == ''){
            $imagem = '';
        }else{
             $imagem =  $imagem['name'];
        }

        $postagens->__set('descricao', $conteudo);
        $postagens->__set('imagem', $imagem);
        $postagens->__set('data_postagem', $data);
        $postagens->__set('privacidade', $privacidade);
        $postagens->__set('id_usuario', $id);

        $postagens->publicar_postagem();
        $this->redirect('/timeline');
    }
}