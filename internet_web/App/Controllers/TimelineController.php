<?php

namespace App\Controllers;

require_once '../MinhaFramework/Controllers/action.php';
require_once '../App/Models/tb_usuarios.php';
require_once '../App/Models/tb_postagens.php';
require_once '../App/Models/tb_seguidores.php';
require_once '../App/Models/tb_seguindo_grupos.php';
require_once '../App/Models/tb_curtida_postagens.php';

use App\Models\tb_usuarios;
use App\Models\tb_postagens;
use App\Models\tb_seguidores;
use App\Models\tb_seguindo_grupos;
use App\Models\tb_curtida_postagens;

use MF\Action;

class TimelineController extends Action {
    public function timeline(){
        $usuarios = new tb_usuarios;
        $postagens = new tb_postagens;
        $seguidores = new tb_seguidores;
        $grupos_seguindo = new tb_seguindo_grupos;
        $curtidas = new tb_curtida_postagens;

        $id = $usuarios->buscarID($_SESSION['email']);

        $this->view->timeline = $postagens->atualizar_timeline($id);
        $this->view->quantidade_postagens = $postagens->quantidade_postagem($id);
        $this->view->quantidade_usuarios = count($seguidores->buscarSeguidores($id));
        $this->view->grupos_seguindo = $grupos_seguindo->GruposSeguindo($id);
        $this->view->curtidas = count($curtidas->buscarCurtidas($id));

        $this->render('autenticado.timeline');
    }

    public function curtirPostagem(){
        $curtidas = new tb_curtida_postagens;
        $usuarios = new tb_usuarios;

        $curtidas->__set('id_usuario', $usuarios->buscarID($_SESSION['email']));
        $curtidas->__set('id_postagem', $_GET['postagem']);

        $curtidas->Curtir();

        if(isset($_GET['local'])) {
            $this->redirect('/perfil');
        }else {
            $this->redirect('/timeline');
        }
        
    }

    public function descurtir(){
        $curtidas = new tb_curtida_postagens;
        $usuarios = new tb_usuarios;

        $curtidas->__set('id_usuario', $usuarios->buscarID($_SESSION['email']));
        $curtidas->__set('id_postagem', $_GET['postagem']);

        $curtidas->descurtir();

        if(isset($_GET['local'])) {
            $this->redirect('/perfil');
        }else {
            $this->redirect('/timeline');
        }
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
            $arquivo = $_FILES['imagem']; 
            $nomeOriginal = $arquivo['name']; 
            $extensao = pathinfo($nomeOriginal, PATHINFO_EXTENSION); 
            $nomeUnico = uniqid() . '-' . time(); 
            $imagem = $nomeUnico . '.' . $extensao; 

            $caminhotemporario = $_FILES['imagem']['tmp_name'];
            $caminhofinal = '../public/Img/'.$imagem;

            move_uploaded_file($caminhotemporario, $caminhofinal);
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