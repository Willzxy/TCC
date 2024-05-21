<?php

namespace App\Middleware;

require_once '../MinhaFramework/Controllers/action.php';

use MF\Action;

class VerificarAutenticacao extends Action {
    public function action(){
        session_start();

        if(!isset($_SESSION['autenticado'])){
            $this->redirect('/');
        }

        
    }
}