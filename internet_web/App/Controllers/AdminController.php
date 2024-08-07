<?php

namespace App\Controllers;

require_once '../MinhaFramework/Controllers/action.php';
require_once '../App/Models/tb_usuarios.php';
require_once '../App/Models/tb_postagens.php';

use App\Models\tb_usuarios;
use App\Models\tb_postagens;
use MF\Action;

class AdminController extends Action {
    public function index(){
        $this->render('administrador.index');
    }
}