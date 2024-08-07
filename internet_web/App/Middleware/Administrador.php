<?php

namespace App\Middleware;

require_once '../MinhaFramework/Controllers/action.php';

use MF\Action;

class Administrador extends Action {
    public function action(){
        session_start();

        if($_SESSION['administrador'] != true ){
            $this->redirect('/timeline');
        }
    }
}