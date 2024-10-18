<?php

namespace App\Controllers;

require_once '../MinhaFramework/Controllers/action.php';
require_once '../App/Models/tb_usuarios.php';
require_once '../App/Models/tb_pedidos_seguidores_pendentes.php';
require_once '../App/Models/tb_seguidores.php';

use App\Models\tb_usuarios;
use App\Models\tb_pedidos_seguidores_pendentes;
use App\Models\tb_seguidores;

use MF\Action;

class MinhaRedeController extends Action {
    public function minharede(){
        $this->render('autenticado.minharede');
    }

    public function pesquisar(){
        $tip = $_GET['tip'];
        if(!isset($tip)){ return; }

        switch ($tip) {
            case 'usuarios':
                $usuarios = new tb_usuarios;

                $usuarios->__set('email', $_SESSION['email']);
                $usuarios->__set('id', $usuarios->buscarID($_SESSION['email']));
                $this->view->usuarios = $registros = $usuarios->procurarUsuarios($_GET['search']);
                $this->render('autenticado.minharede');
                break;
            case 'solicitacoes':
                $usuarios = new tb_usuarios;
                $pedidos_pendentes = new tb_pedidos_seguidores_pendentes;
                $pedidos_pendentes->__set('id_usuario_requisitado', $usuarios->buscarID($_SESSION['email']));
    
                $this->view->solicitacoes = $registros = $pedidos_pendentes->MinhasSolicitacoes();
                
                $this->render('autenticado.minharede');
                break;
            case 'conexoes':
                $usuarios = new tb_usuarios;
                $seguidores = new tb_seguidores;
    
                $this->view->conexoes = $registros = $seguidores->buscarSeguidores($usuarios->buscarID($_SESSION['email']));
                
                $this->render('autenticado.minharede');
                break;
            default:
                # code...
                break;
        }
    }


    public function pedirSeguir(){
        $usuarios = new tb_usuarios;
        $pedidos_seguidores = new tb_pedidos_seguidores_pendentes;

        $pedidos_seguidores->__set('id_usuario_pedido', $usuarios->buscarID($_SESSION['email']));
        $pedidos_seguidores->__set('id_usuario_requisitado', $_GET['usuario']);

        $pedidos_seguidores->pedirParaSeguir();
        $this->redirect('/pesquisar?tip=usuarios&search=');
    }

    public function aceitarpedido(){
        $usuarios = new tb_usuarios;
        $pedidos_seguidores = new tb_pedidos_seguidores_pendentes;
        $seguidores = new tb_seguidores;

        $pedidos_seguidores->__set('id_usuario_pedido', $_GET['usuario']);
        $pedidos_seguidores->__set('id_usuario_requisitado', $usuarios->buscarID($_SESSION['email']));

        $pedidos_seguidores->apagarPedido();

        $seguidores->__set('id_usuario', $_GET['usuario']);
        $seguidores->__set('id_usuario_seguindo', $usuarios->buscarID($_SESSION['email']));

        $seguidores->seguir();

        $this->redirect('/minharede');
    }
}