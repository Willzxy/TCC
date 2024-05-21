<?php

namespace MF;

abstract class Action{
    protected $diretorioAvatar = '../App/database/avatar/';
    protected $diretorioPosts = '../App/database/posts/';
    protected $view;

    public function __construct(){
        $this->view = new \stdClass();
    }

    function render($name){
        $split = explode('.', $name);
        require_once '../App/Views/'.$split[0].'/'.$split[1].'.phtml';
    }

    function redirect($route){
        header("location: $route");
    }

    function layout($name){
        include_once "../App/Layouts/$name.phtml";
    }

    function show($var){
        if(!isset($_SESSION[$var])){
            echo 'Variavel não encontrada na sessão';
            return;
        }

        echo $_SESSION[$var];
    }

    function saveFileAvatar($file){
        try {
            $diretoriosalvar = $this->diretorioAvatar . $file['name'];

            move_uploaded_file($file["tmp_name"], $diretoriosalvar);
        } catch (\Throwable $th) {
         
        }
    }
}