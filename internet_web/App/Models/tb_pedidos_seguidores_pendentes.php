<?php

namespace App\Models;

require_once '../MinhaFramework/Models/Models.php';

use MF\Models;

class tb_pedidos_seguidores_pendentes extends Models
{
    private $id;
    private $id_usuario_pedido;
    private $id_usuario_requisitado;

    function __set($attr1, $attr2)
    {
        $this->$attr1 = $attr2;
    }

    function __get($attr)
    {
        return $this->$attr;
    }

    function pedirParaSeguir()
    {
        $query = "
            INSERT INTO tb_pedidos_seguidores_pendentes (id_usuario_pedido, id_usuario_requisitado)
            VALUES (?, ?);
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $this->__get('id_usuario_pedido'), $this->__get('id_usuario_requisitado'));
        $stmt->execute();
    }

    function verificarPedido()
    {
        $query = "SELECT *
            FROM tb_pedidos_seguidores_pendentes
            WHERE id_usuario_pedido = ?
            AND id_usuario_requisitado = ?;
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $this->__get('id_usuario_pedido'), $this->__get('id_usuario_requisitado'));
        $stmt->execute();

        $results = $stmt->get_result();
        $registro = $results->fetch_assoc();

        if ($registro) {
            return true;
        }
    }

    function apagarPedido()
    {
        $query = "
            DELETE FROM tb_pedidos_seguidores_pendentes 
            WHERE id_usuario_pedido = ? AND id_usuario_requisitado = ?;
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $this->__get('id_usuario_pedido'), $this->__get('id_usuario_requisitado'));
        $stmt->execute();
    }

    function MinhasSolicitacoes()
    {
        $query = "
                SELECT 
                    p.id AS pedido_id,
                    p.id_usuario_pedido AS id_usuario_pedido,
                    u.nome AS nome_usuario_pedido,
                    u.sobremim AS sobremim_usuario_pedido
                FROM 
                    tb_pedidos_seguidores_pendentes p
                JOIN 
                    tb_usuarios u ON p.id_usuario_pedido = u.id
                WHERE 
                    p.id_usuario_requisitado = ?;
            ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $this->__get('id_usuario_requisitado'));
        $stmt->execute();

        $results = $stmt->get_result();

        $registros = array();
        while ($row = $results->fetch_assoc()) {
            array_push($registros, $row);
        }

        return $registros;
    }
}
