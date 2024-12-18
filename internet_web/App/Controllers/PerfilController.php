<?php

namespace App\Controllers;

require_once '../MinhaFramework/Controllers/action.php';
require_once '../App/Models/tb_usuarios.php';
require_once '../App/Models/tb_postagens.php';

use App\Models\tb_usuarios;
use App\Models\tb_postagens;
use MF\Action;

class PerfilController extends Action {
    function atualizarperfil(){
        $nome = trim($_POST['nome']);
        $descricao = trim($_POST['descricao']);

        $imagem = $_FILES['imagem'];

        if(isset($imagem)){
            $arquivo = $_FILES['imagem']; 
            $nomeOriginal = $arquivo['name']; 
            $extensao = pathinfo($nomeOriginal, PATHINFO_EXTENSION); 
            $nomeUnico = uniqid() . '-' . time(); 
            $imagem = $nomeUnico . '.' . $extensao; 

            $caminhotemporario = $_FILES['imagem']['tmp_name'];
            $caminhofinal = '../public/Img/'.$imagem;

            move_uploaded_file($caminhotemporario, $caminhofinal);
        }

        $usuario = new tb_usuarios;
        $usuario->__set("nome", $nome);
        $usuario->__set("sobremim", $descricao);
        $usuario->__set('foto_perfil', $imagem);
        $usuario->__set('id', $usuario->buscarID($_SESSION['email']));

        $usuario->atualizar_perfil();
        $usuario->AtualizarDadosSecao();
        $this->redirect('/perfil');
    }

    public function deletarpostagem(){
        $postagens = new tb_postagens;
        $postagens->__set('id', $_POST['id']);
        $postagens->apagar_postagem();

        $this->redirect('/perfil');
    }

    public function perfil(){
        $usuarios = new tb_usuarios;
        $postagens = new tb_postagens;

        $id = $usuarios->buscarID($_SESSION['email']);

        $this->view->minhas_postagens = $postagens->listar_postagens($id);
        $this->render('autenticado.perfil');
    }
}