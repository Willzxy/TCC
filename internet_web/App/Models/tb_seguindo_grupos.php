<?php

namespace App\Models;

require_once '../MinhaFramework/Models/Models.php';

use MF\Models;

class tb_seguindo_grupos extends Models {
    private $id;
    private $id_grupo;
    private $id_usuario;

    function __set($attr1, $attr2){
        $this->$attr1 = $attr2;
    }

    function __get($attr){
        return $this->$attr;
    }

    public function SeguirGrupo(){
        $query = "INSERT INTO tb_seguindo_grupos (id_usuario, id_grupo) VALUES (?, ?);";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $this->__get('id_usuario'), $this->__get('id_grupo'));

        $stmt->execute();
    }

    public function GruposSeguindo($id){
        $query = " 
            SELECT sg.*, g.nome AS nome_grupo 
            FROM tb_seguindo_grupos sg
            JOIN tb_grupos g ON sg.id_grupo = g.id
            WHERE sg.id_usuario = ?;
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $results = $stmt->get_result();

        $registros = array();
        while ($row = $results->fetch_assoc()) {
            array_push($registros, $row);
        }

        return $registros;
    }

    public function DeixarDeSeguirGrupo(){
        $query = "DELETE FROM tb_seguindo_grupos 
            WHERE id_usuario = ? AND id_grupo = ?;
            ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $this->__get('id_usuario'), $this->__get('id_grupo'));

        $stmt->execute();
    }

    
}
