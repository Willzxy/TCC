<?php

namespace App\Models;

require_once '../MinhaFramework/Models/Models.php';

use MF\Models;

class tb_curtida_postagens extends Models {
    private $id;
    private $id_usuario;
    private $id_postagem;

    function __set($attr1, $attr2){
        $this->$attr1 = $attr2;
    }

    function __get($attr){
        return $this->$attr;
    }

    public function buscarCurtidas($id){
        $query = "SELECT c.id AS total_curtidas
            FROM tb_curtidas_postagens c
            JOIN tb_postagens p ON c.id_postagem = p.id
            WHERE p.id_usuario = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $resultados = [];
        while ($row = $result->fetch_assoc()) {
            $resultados[] = $row;
        }

        return $resultados;
    }

    public function Curtir(){
        $query = "INSERT INTO tb_curtidas_postagens (id_usuario, id_postagem) 
        VALUES (?, ?);";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $this->__get('id_usuario'), $this->__get('id_postagem'));
        $stmt->execute();
    }

    public function DesCurtir(){
        $query = "DELETE FROM tb_curtidas_postagens
            WHERE id_postagem = ? 
            AND id_usuario = ?;";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $this->__get('id_postagem'), $this->__get('id_usuario'));
        $stmt->execute();
    }
}
