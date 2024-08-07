<?php

namespace App\Controllers;

require_once '../MinhaFramework/Controllers/action.php';
require_once '../App/Models/tb_usuarios.php';

use App\Models\tb_usuarios;
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
                $pesquisar = $_GET['search'];
                $usuarios = new tb_usuarios;

                $usuarios->__set('email', $_SESSION['email']);
                $this->view->usuarios = $registros = $usuarios->procurarUsuarios($_GET['search']);
                $this->render('autenticado.minharede');
                break;
            default:
                # code...
                break;
        }
    }
}