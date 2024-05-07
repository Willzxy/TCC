<?php

namespace App\Models;

require_once '../MinhaFramework/Models/Models.php';

use MF\Models;

class Usuarios extends Models  {
    private $id;
    private $nome;
    private $senha;
    private $email;
    private $sobremim;
    private $foto_perfil;

    function __set($attr1, $attr2){
        $this->$attr1 = $attr2;
    }

    function __get($attr){
        return $this->$attr;
    }

    function Cadastrar(){
        $query = "
            insert into tb_usuarios(nome, senha, email)values(
                ?,
                ?,
                ?
            );
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sss", $this->__get('nome'), $this->__get('senha'), $this->__get('email'));
        $stmt->execute();
    }

    function autenticar(){
        $query = "select * from tb_usuarios where nome = ? or email = ? and senha = ?;";
        
    }
}