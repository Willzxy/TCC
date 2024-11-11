<?php

namespace App\Models;

require_once '../MinhaFramework/Models/Models.php';

use MF\Models;

class tb_grupos extends Models {
    private $id;
    private $nome;
    private $descricao;

    function __set($attr1, $attr2){
        $this->$attr1 = $attr2;
    }

    function __get($attr){
        return $this->$attr;
    }

    public function ListarGrupos($id){
        $query = " SELECT 
                    g.id,
                    g.nome,
                    g.descricao,
                    CASE 
                        WHEN EXISTS (
                            SELECT 1 
                            FROM tb_seguindo_grupos sg 
                            WHERE sg.id_usuario = ? AND sg.id_grupo = g.id
                        ) 
                        THEN 'ja_segue' 
                        ELSE 'nao_segue' 
                    END AS status_seguimento
                FROM 
                    tb_grupos g;
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
}
