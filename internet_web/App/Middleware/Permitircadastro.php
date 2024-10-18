<?php

namespace App\Middleware;

require_once '../MinhaFramework/Controllers/action.php';

use MF\Action;

class PermitirCadastro extends Action {
    public function action(){
        session_start();

        if(isset($_SESSION['administrador']) && $_SESSION['administrador'] === 1 ){
            $this->redirect('/admin');
        }

        if(isset($_SESSION['autenticado'])){
            $this->redirect('/timeline');
        }
    }
}