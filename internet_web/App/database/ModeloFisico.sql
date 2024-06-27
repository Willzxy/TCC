-- Modelo fisico do projeto: FriendCircle 27/06/2024

DROP TABLE IF EXISTS tb_curtidas_comentarios;
DROP TABLE IF EXISTS tb_comentarios_postagens;
DROP TABLE IF EXISTS tb_curtidas_postagens;
DROP TABLE IF EXISTS tb_denuncias;
DROP TABLE IF EXISTS tb_postagens;
DROP TABLE IF EXISTS tb_seguindo_grupos;
DROP TABLE IF EXISTS tb_grupos;
DROP TABLE IF EXISTS tb_seguidores;
DROP TABLE IF EXISTS tb_usuarios;

CREATE TABLE tb_usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    senha VARCHAR(32) NOT NULL,
    email VARCHAR(200) NOT NULL,
    sobremim VARCHAR(200) DEFAULT 'sem descrição',
    fotoperfil VARCHAR(200),
    administrador BOOLEAN
);

CREATE TABLE tb_seguidores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    id_usuario_seguindo INT,
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id),
    FOREIGN KEY (id_usuario_seguindo) REFERENCES tb_usuarios(id)
);

CREATE TABLE tb_postagens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    descricao VARCHAR(1000),
    imagem VARCHAR(200),
    privacidade VARCHAR(40),
    data_postagem DATE,
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id)
);

CREATE TABLE tb_curtidas_postagens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_postagem INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id),
    FOREIGN KEY (id_postagem) REFERENCES tb_postagens(id)
);

CREATE TABLE tb_comentarios_postagens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_postagem INT NOT NULL,
    comentario VARCHAR(400) NOT NULL,
    data_postagem DATE,
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id),
    FOREIGN KEY (id_postagem) REFERENCES tb_postagens(id)
);

CREATE TABLE tb_curtidas_comentarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_comentario INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id),
    FOREIGN KEY (id_comentario) REFERENCES tb_comentarios_postagens(id)
);

CREATE TABLE tb_denuncias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_postagem INT NOT NULL,
    id_usuario_denunciou INT NOT NULL,
    FOREIGN KEY (id_postagem) REFERENCES tb_postagens(id),
    FOREIGN KEY (id_usuario_denunciou) REFERENCES tb_usuarios(id)
);

CREATE TABLE tb_grupos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(200) NOT NULL,
    descricao VARCHAR(400)
);

create table tb_seguindo_grupos(
	id int primary key auto_increment,
    id_grupo int not null,
    id_usuario int not null,
    
    foreign key (id_grupo) references tb_grupos(id),
    foreign key (id_usuario) references tb_usuarios(id)
);

INSERT INTO tb_usuarios (nome, senha, email, administrador) VALUES ('admin', MD5('admin'), 'admin@example.com', TRUE);
INSERT INTO tb_usuarios (nome, senha, email, administrador) VALUES ('willian', MD5('senha123'), 'willian.silva@example.com', FALSE);
INSERT INTO tb_usuarios (nome, senha, email, administrador) VALUES ('Maria Oliveira', MD5('senha123'), 'maria.oliveira@example.com', FALSE);
INSERT INTO tb_usuarios (nome, senha, email, administrador) VALUES ('Carlos Santos', MD5('senha123'), 'carlos.santos@example.com', FALSE);
INSERT INTO tb_usuarios (nome, senha, email, administrador) VALUES ('Ana Costa', MD5('senha123'), 'ana.costa@example.com', FALSE);
INSERT INTO tb_usuarios (nome, senha, email, administrador) VALUES ('Paulo Lima', MD5('senha123'), 'paulo.lima@example.com', FALSE);
