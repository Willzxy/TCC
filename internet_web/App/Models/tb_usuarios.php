<?php

namespace App\Models;

require_once '../MinhaFramework/Models/Models.php';

use MF\Models;

class tb_usuarios extends Models
{
    private $id;
    private $nome;
    private $senha;
    private $email;
    private $sobremim;
    private $foto_perfil;
    private $administrador;
    private $token;
    private $token_validade;
    private $ativo;

    function __set($attr1, $attr2)
    {
        $this->$attr1 = $attr2;
    }

    function __get($attr)
    {
        return $this->$attr;
    }

    function atualizarSenha()
    {
        $query = "
            UPDATE tb_usuarios
            SET senha = MD5(?)
            WHERE id = ?;
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $this->__get('senha'), $this->__get('id'));
        $stmt->execute();
    }

    function cadastrar()
    {
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

    function verificar_email()
    {
        $query = "select * from tb_usuarios where email = ?;";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $this->__get('email'));
        $stmt->execute();

        $results = $stmt->get_result();
        $registro = $results->fetch_assoc();

        if ($registro) {
            return true;
        }
    }

    function autenticar()
    {
        $query = "select * from tb_usuarios where email = ? and senha = ?;";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $this->__get('email'), $this->__get('senha'));
        $stmt->execute();

        $results = $stmt->get_result();
        $registro = $results->fetch_assoc();

        if ($registro) {
            return true;
        }
    }

    function procurarUsuarios($procurar)
    {
        $procurar = '%' . $procurar . '%';
        $query = "
             SELECT 
                u.id, 
                u.nome, 
                u.sobremim, 
                CASE 
                    WHEN p.id_usuario_pedido IS NOT NULL THEN 'pedido_pendente'
                    ELSE 'sem_pedido'
                END AS status_pedido
            FROM 
                tb_usuarios u
            LEFT JOIN 
                tb_pedidos_seguidores_pendentes p 
                ON u.id = p.id_usuario_requisitado 
                AND p.id_usuario_pedido = ?  
            WHERE 
                u.administrador = false 
                AND u.email != ? 
                AND u.nome LIKE ?
                AND u.id NOT IN (
                    SELECT id_usuario_seguindo 
                    FROM tb_seguidores 
                    WHERE id_usuario = ?
                )
            LIMIT 25;


        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("issi", $this->__get('id'), $this->__get('email'), $procurar, $this->__get('id'));
        $stmt->execute();

        $results = $stmt->get_result();

        $registros = array();
        while ($row = $results->fetch_assoc()) {
            array_push($registros, $row);
        }

        return $registros;
    }

    function atualizar_perfil()
    {
        $query = "
        UPDATE tb_usuarios
        SET nome = ?, sobremim = ?
        WHERE id = ?;
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sss", $this->__get('nome'), $this->__get('sobremim'), $this->__get('id'));
        $stmt->execute();
    }

    function AtualizarDadosSecao()
    {
        session_start();
        $id = $this->buscarID($_SESSION['email']);
        $dadosAtualizados = $this->BuscarDados($id);

        $_SESSION['administrador'] = $dadosAtualizados['administrador'];
        $_SESSION['nome'] = $dadosAtualizados['nome'];
        $_SESSION['sobremim'] = $dadosAtualizados['sobremim'];
    }

    function BuscarDados($id)
    {
        $query = "select id, nome, sobremim, email, administrador from tb_usuarios where id = ?;";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $results = $stmt->get_result();

        while ($row = $results->fetch_assoc()) {
            return $row;
        }
    }

    function verificarToken($token)
    {
        $query = "
            SELECT id, nome, email, token, token_validade_data, token_validade_hora
            FROM tb_usuarios
            WHERE token = ? -- O token que você deseja verificar
            AND token_validade_data >= CURDATE()
            AND (token_validade_data > CURDATE() OR token_validade_hora >= CURTIME())
            AND token_validade_data IS NOT NULL
            AND token_validade_hora IS NOT NULL;
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $token);
        $stmt->execute();

        $results = $stmt->get_result();

        while ($row = $results->fetch_assoc()) {
            return $row['id'];
        }
    }

    function atualizartoken($token)
    {
        $query = "
            UPDATE tb_usuarios
            SET token = ?, 
                token_validade_hora = TIME(NOW() + INTERVAL 5 MINUTE),
                token_validade_data = CURDATE()
            WHERE id = ?; 
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $token, $this->__get('id'));
        $stmt->execute();
    }

    function buscarID($email)
    {
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
