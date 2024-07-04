-- Modelo fisico do projeto: FriendCircle 27/06/2024

DROP TABLE IF EXISTS tb_curtidas_comentarios;
DROP TABLE IF EXISTS tb_comentarios_postagens;
DROP TABLE IF EXISTS tb_curtidas_postagens;
DROP TABLE IF EXISTS tb_denuncias;
DROP TABLE IF EXISTS tb_postagens;
DROP TABLE IF EXISTS tb_seguindo_grupos;
DROP TABLE IF EXISTS tb_seguidores;
DROP TABLE IF EXISTS tb_pedidos_seguidores_pendentes;
DROP TABLE IF EXISTS tb_grupos;
DROP TABLE IF EXISTS tb_usuarios;

CREATE TABLE tb_usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    senha VARCHAR(32) NOT NULL,
    email VARCHAR(200) NOT NULL,
    sobremim VARCHAR(200) DEFAULT 'sem descrição',
    fotoperfil VARCHAR(200),
    administrador BOOLEAN DEFAULT FALSE
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
    descricao VARCHAR(1000) NOT NULL,
    imagem VARCHAR(200) DEFAULT'sem imagem',
    privacidade VARCHAR(40) not null,
    data_postagem DATE not null,
    
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

CREATE TABLE tb_pedidos_seguidores_pendentes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario_pedido INT NOT NULL,
    id_usuario_requisitado INT NOT NULL,
    
    FOREIGN KEY (id_usuario_pedido) REFERENCES tb_grupos(id),
    FOREIGN KEY (id_usuario_requisitado) REFERENCES tb_usuarios(id)
);

CREATE TABLE tb_seguindo_grupos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_grupo INT NOT NULL,
    id_usuario INT NOT NULL,
    
    FOREIGN KEY (id_grupo) REFERENCES tb_grupos(id),
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id)
);

INSERT INTO tb_usuarios (nome, senha, email, sobremim, administrador) VALUES ('admin', MD5('admin'), 'admin@example.com', 'Administrador do sistema', TRUE);
INSERT INTO tb_usuarios (nome, senha, email, sobremim, administrador) VALUES ('willian', MD5('senha123'), 'willian.silva@example.com', 'Apaixonado por gastronomia e esportes.', FALSE);
INSERT INTO tb_usuarios (nome, senha, email, sobremim, administrador) VALUES ('Maria Oliveira', MD5('senha123'), 'maria.oliveira@example.com', 'Entusiasta de livros e viagens.', FALSE);
INSERT INTO tb_usuarios (nome, senha, email, sobremim, administrador) VALUES ('Carlos Santos', MD5('senha123'), 'carlos.santos@example.com', 'Engenheiro com interesse em astronomia.', FALSE);
INSERT INTO tb_usuarios (nome, senha, email, sobremim, administrador) VALUES ('Ana Costa', MD5('senha123'), 'ana.costa@example.com', 'Amante de culinária e artes.', FALSE);
INSERT INTO tb_usuarios (nome, senha, email, sobremim, administrador) VALUES ('Paulo Lima', MD5('senha123'), 'paulo.lima@example.com', 'Aficionado por esportes e investimentos.', FALSE);

-- Postagens para o usuário 'willian'
INSERT INTO tb_postagens (id_usuario, descricao, privacidade, data_postagem) 
VALUES 
(2, 'Adorei o novo restaurante japonês no centro da cidade! Recomendo a todos.', 'publico', '2024-06-27'),
(2, 'Treino de corrida finalizado! Agora é hora de descansar.', 'privado', '2024-06-26'),
(2, 'O clima está ótimo para um passeio no parque hoje.', 'publico', '2024-06-25');

-- Postagens para a usuária 'Maria Oliveira'
INSERT INTO tb_postagens (id_usuario, descricao, privacidade, data_postagem) 
VALUES 
(3, 'Acabei de ler um livro incrível sobre desenvolvimento pessoal. Super recomendo!', 'publico', '2024-06-27'),
(3, 'Mais um dia produtivo no trabalho. Grata por todas as oportunidades.', 'privado', '2024-06-26'),
(3, 'Estou planejando uma viagem para a serra no próximo mês. Alguém tem dicas?', 'publico', '2024-06-25');

-- Postagens para o usuário 'Carlos Santos'
INSERT INTO tb_postagens (id_usuario, descricao, privacidade, data_postagem) 
VALUES 
(4, 'Assistindo a um documentário sobre astronomia. Fascinante!', 'publico', '2024-06-27'),
(4, 'Preparando um novo projeto de engenharia. Muitos desafios pela frente.', 'privado', '2024-06-26'),
(4, 'Passeio de bicicleta pelas montanhas no fim de semana foi incrível.', 'publico', '2024-06-25');

-- Postagens para a usuária 'Ana Costa'
INSERT INTO tb_postagens (id_usuario, descricao, privacidade, data_postagem) 
VALUES 
(5, 'Nova receita de bolo de chocolate saiu perfeita! Quem quer a receita?', 'publico', '2024-06-27'),
(5, 'Tarde de pintura e relaxamento. Nada melhor.', 'privado', '2024-06-26'),
(5, 'Aproveitando o dia de sol na praia.', 'publico', '2024-06-25');

-- Postagens para o usuário 'Paulo Lima'
INSERT INTO tb_postagens (id_usuario, descricao, privacidade, data_postagem) 
VALUES 
(6, 'Jogando futebol com os amigos. Que partida!', 'publico', '2024-06-27'),
(6, 'Estudando novas estratégias de investimento. Sempre aprendendo.', 'privado', '2024-06-26'),
(6, 'Visita ao museu de arte contemporânea foi inspiradora.', 'publico', '2024-06-25');
