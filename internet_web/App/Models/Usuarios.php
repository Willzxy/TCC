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

    function cadastrar(){
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

    function verificar_email(){
        $query = "select * from tb_usuarios where email = ?;";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $this->__get('email'));
        $stmt->execute();
        
        $results = $stmt->get_result();
        $registro = $results->fetch_assoc();

        if($registro){
            return true;
        }
    }

    function autenticar(){
        $query = "select * from tb_usuarios where email = ? and senha = ?;";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $this->__get('email'), $this->__get('senha'));
        $stmt->execute();
        
        $results = $stmt->get_result();
        $registro = $results->fetch_assoc();

        if($registro){
            return true;
        }
    }

    function procurarUsuarios($procurar){
        $procurar = '%' . $procurar . '%';
        $query = 'select id, nome from tb_usuarios where email != ? and nome like ? limit 25;';

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $this->__get('email'), $procurar);
        $stmt->execute();

        $results = $stmt->get_result();

       $registros = array();
        while ($row = $results->fetch_assoc()) {
            array_push($registros, $row);
        }

        return $registros;
    }
}