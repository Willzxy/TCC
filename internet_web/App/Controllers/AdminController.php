<?php

namespace App\Controllers;

require_once '../MinhaFramework/Controllers/action.php';
require_once '../App/Models/tb_usuarios.php';
require_once '../App/Models/tb_postagens.php';
require_once '../MinhaFramework/Controllers/action.php';
require_once '../App/Models/tb_usuarios.php';
require_once '../App/Models/tb_pedidos_seguidores_pendentes.php';
require_once '../App/Models/tb_seguidores.php';
require_once '../App/Models/tb_grupos.php';
require_once '../App/Models/tb_seguindo_grupos.php';

use App\Models\tb_postagens;
use App\Models\tb_usuarios;
use App\Models\tb_pedidos_seguidores_pendentes;
use App\Models\tb_seguidores;
use App\Models\tb_grupos;
use App\Models\tb_seguindo_grupos;

use MF\Action;

class AdminController extends Action {
    public function index(){
        $this->render('administrador.index');
    }

    public function usuarios(){
        $usuarios = new tb_usuarios;

        $this->view->tabela = 'tb_usuarios';
        $this->view->dados = $usuarios->select();
        $this->render('administrador.tb_usuarios');
    }

    public function excluir_tb_usuarios(){
        $usuarios = new tb_usuarios;
        $usuarios->__set('id', $_POST['id']);

        $usuarios->deletar();

        $this->redirect('/adm_usuarios');
    }

    public function editar_tb_usuarios(){
        $usuarios = new tb_usuarios;
        $dados = $_POST;
        
        $imagem = $_FILES['fotoperfil'];

        if(isset($imagem)){
            $arquivo = $_FILES['fotoperfil']; 
            $nomeOriginal = $arquivo['name']; 
            $extensao = pathinfo($nomeOriginal, PATHINFO_EXTENSION); 
            $nomeUnico = uniqid() . '-' . time(); 
            $imagem = $nomeUnico . '.' . $extensao; 

            $caminhotemporario = $_FILES['imagem']['tmp_name'];
            $caminhofinal = '../public/Img/'.$imagem;

            move_uploaded_file($caminhotemporario, $caminhofinal);
        }

        $usuarios->__set('id', $dados['id']);
        $usuarios->__set('nome', $dados['nome']);
        $usuarios->__set('senha', $dados['senha']);
        $usuarios->__set('email', $dados['email']);
        $usuarios->__set('sobremim', $dados['sobremim']);
        $usuarios->__set('fotoperfil', $imagem);
        $usuarios->__set('token', $dados['token']);
        $usuarios->__set('token_validade_hora', $dados['token_validade_hora']);
        $usuarios->__set('token_validade_data', $dados['token_validade_data']);
        $usuarios->__set('administrador', $dados['administrador']);
        $usuarios->__set('ativo', $dados['ativo']);

        #$usuarios->editar();

        echo "<pre>";
        print_r($_POST);
        echo "</pre> <br> -------------------- <br>";
        print_r($_FILES['fotoperfil']);

        #$this->redirect('/adm_usuarios');
    }

}