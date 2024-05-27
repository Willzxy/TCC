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
        $query = 'select id, nome, sobremim from tb_usuarios where email != ? and nome like ? limit 25;';

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

    function atualizar_perfil(){
        $query = "
        UPDATE tb_usuarios
        SET nome = ?, sobremim = ?
        WHERE id = ?;
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sss", $this->__get('nome'), $this->__get('sobremim'), $this->__get('id') );
        $stmt->execute();
    }

    function AtualizarDadosSecao(){
        session_start(); 
        $id = $this->buscarID($_SESSION['email']);
        $dadosAtualizados = $this->BuscarDados($id);

        $_SESSION['nome'] = $dadosAtualizados['nome'];
        $_SESSION['sobremim'] = $dadosAtualizados['sobremim'];
    }

    function BuscarDados($id){
        $query = "select nome, sobremim, email from tb_usuarios where id = ?;";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        
        $results = $stmt->get_result();

        while ($row = $results->fetch_assoc()) {
            return $row;
        }
    }

    function buscarID($email){
        $query = "select id from tb_usuarios where email = ?;";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        
        $results = $stmt->get_result();

        while ($row = $results->fetch_assoc()) {
            return $row['id'];
        }
    }
}