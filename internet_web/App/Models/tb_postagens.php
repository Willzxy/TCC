<?php

namespace App\Models;

require_once '../MinhaFramework/Models/Models.php';

use MF\Models;

class tb_postagens extends Models {
    private $id;
    private $id_usuario;
    private $descricao;
    private $imagem;
    private $privacidade;
    private $data_postagem;

    function __set($attr1, $attr2){
        $this->$attr1 = $attr2;
    }

    function __get($attr){
        return $this->$attr;
    }

    function publicar_postagem(){
        if($this->imagem != ''){
            $query = "
                INSERT INTO tb_postagens (id_usuario, descricao, imagem, privacidade, data_postagem) VALUES (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                );
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bind_param("issss", $this->__get('id_usuario'), $this->__get('descricao'), $this->__get('imagem'), $this->__get('privacidade'), $this->__get('data_postagem'));
            $stmt->execute();

            return true;
        }else{
            $query = "
                INSERT INTO tb_postagens (id_usuario, descricao, privacidade, data_postagem) VALUES (
                    ?,
                    ?,
                    ?,
                    ?
                );
            ";

            $stmt = $this->db->prepare($query);
            $stmt->bind_param("isss", $this->__get('id_usuario'), $this->__get('descricao'), $this->__get('privacidade'), $this->__get('data_postagem'));
            $stmt->execute();

            return true;
        }

        return false;
    }

    public function listar_postagens($id_usuario){
        $query = "
            SELECT p.*, u.nome as nome_usuario, u.email as email, u.sobremim as sobre_usuario
            FROM tb_postagens p
            JOIN tb_usuarios u ON p.id_usuario = u.id
            WHERE p.id_usuario = ?
            ORDER BY p.data_postagem DESC;
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        $result = $stmt->get_result();
        $postagens = [];
        while ($row = $result->fetch_assoc()) {
            $postagens[] = $row;
        }

        return $postagens;
    }

    public function apagar_postagem(){
        $query = "
            DELETE FROM tb_postagens WHERE id = ?;
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $this->__get('id'));
        $stmt->execute();
    }

    public function atualizar_timeline($id_usuario){
        $query = "
            SELECT 
                p.*, 
                u.nome AS nome_usuario, 
                u.sobremim AS sobre_usuario
            FROM 
                tb_postagens p
            JOIN 
                tb_usuarios u ON p.id_usuario = u.id
            WHERE 
                p.privacidade = 'publico' 
                AND u.id IN (
                    SELECT id_usuario_seguindo 
                    FROM tb_seguidores 
                    WHERE id_usuario = ?
                )
            ORDER BY 
                p.data_postagem DESC;

        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        $result = $stmt->get_result();
        $postagens = [];
        while ($row = $result->fetch_assoc()) {
            $postagens[] = $row;
        }

        return $postagens;
    }

    public function quantidade_postagem($id_usuario){
        $query = "
        SELECT COUNT(*) as numero_de_postagens
        FROM tb_postagens
        WHERE id_usuario = ?;
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()['numero_de_postagens'];
    }
}
