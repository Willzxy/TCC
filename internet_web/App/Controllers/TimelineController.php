<?php

namespace App\Controllers;

require_once '../MinhaFramework/Controllers/action.php';
require_once '../App/Models/Usuarios.php';

use App\Models\Usuarios;
use MF\Action;

class TimelineController extends Action {
    public function timeline(){
        $this->render('autenticado.timeline');
    }

    public function perfil(){
        $this->render('autenticado.perfil');
    }
}