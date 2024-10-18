<?php

namespace App\Models;

require_once '../MinhaFramework/Models/Models.php';

use MF\Models;

class tb_seguidores extends Models {
    private $id;
    private $id_usuario;
    private $id_usuario_seguindo;

    function __set($attr1, $attr2)
    {
        $this->$attr1 = $attr2;
    }

    function __get($attr)
    {
        return $this->$attr;
    }

    public function seguir(){
        $query = "INSERT INTO tb_seguidores (id_usuario, id_usuario_seguindo) 
        VALUES (?, ?);";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $this->__get('id_usuario'), $this->__get('id_usuario_seguindo'));

        $stmt->execute();

        $query = "INSERT INTO tb_seguidores (id_usuario, id_usuario_seguindo) 
        VALUES (?, ?);";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $this->__get('id_usuario_seguindo'), $this->__get('id_usuario'));

        $stmt->execute();
    }

    public function buscarSeguidores($usuario){
      $query = "
         SELECT 
            u.id, 
            u.nome, 
            u.sobremim
        FROM 
            tb_seguidores s
        JOIN 
            tb_usuarios u ON s.id_usuario = u.id
        WHERE 
            s.id_usuario_seguindo = ?;";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $usuario);
        $stmt->execute();

        $results = $stmt->get_result();

        $registros = array();
        while ($row = $results->fetch_assoc()) {
            array_push($registros, $row);
        }

        return $registros;
    }
}