<?php

namespace App\Controllers;

require_once '../MinhaFramework/Controllers/action.php';
require_once '../App/Models/tb_usuarios.php';

use App\Models\tb_usuarios;
use MF\Action;

class IndexController extends Action {
    public function index(){
        $this->render('index.login');
    }
}