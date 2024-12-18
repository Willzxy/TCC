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
    fotoperfil VARCHAR(200) DEFAULT 'PerfilVazia.jpg',
    token VARCHAR(200) DEFAULT NULL,
    token_validade_hora TIME DEFAULT NULL,
    token_validade_data DATE DEFAULT NULL,
    administrador BOOLEAN DEFAULT FALSE,
    ativo BOOLEAN DEFAULT TRUE
);

CREATE TABLE tb_seguidores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_usuario_seguindo INT NOT NULL,
    
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id),
    FOREIGN KEY (id_usuario_seguindo) REFERENCES tb_usuarios(id),
    CHECK (id_usuario <> id_usuario_seguindo)
);

CREATE TABLE tb_postagens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    descricao VARCHAR(1000) NOT NULL,
    imagem VARCHAR(200) DEFAULT 'sem imagem',
    privacidade VARCHAR(40) NOT NULL,
    data_postagem DATE NOT NULL,
    
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id)
);

CREATE TABLE tb_curtidas_postagens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_postagem INT NOT NULL,
    
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id),
    FOREIGN KEY (id_postagem) REFERENCES tb_postagens(id) ON DELETE CASCADE
);

CREATE TABLE tb_comentarios_postagens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_postagem INT NOT NULL,
    comentario VARCHAR(400) NOT NULL,
    data_postagem DATE NOT NULL,
    
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id),
    FOREIGN KEY (id_postagem) REFERENCES tb_postagens(id) ON DELETE CASCADE
);

CREATE TABLE tb_curtidas_comentarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_comentario INT NOT NULL,
    
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id),
    FOREIGN KEY (id_comentario) REFERENCES tb_comentarios_postagens(id) ON DELETE CASCADE
);

CREATE TABLE tb_denuncias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_postagem INT NOT NULL,
    id_usuario_denunciou INT NOT NULL,
    
    FOREIGN KEY (id_postagem) REFERENCES tb_postagens(id) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario_denunciou) REFERENCES tb_usuarios(id)
);

CREATE TABLE tb_grupos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(200) NOT NULL,
    descricao VARCHAR(400) DEFAULT 'grupo sem descrição'
);

CREATE TABLE tb_pedidos_seguidores_pendentes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario_pedido INT NOT NULL,
    id_usuario_requisitado INT NOT NULL,
    
    FOREIGN KEY (id_usuario_pedido) REFERENCES tb_usuarios(id),
    FOREIGN KEY (id_usuario_requisitado) REFERENCES tb_usuarios(id),
    CHECK (id_usuario_pedido <> id_usuario_requisitado)
);

CREATE TABLE tb_seguindo_grupos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_grupo INT NOT NULL,
    id_usuario INT NOT NULL,
    
    FOREIGN KEY (id_grupo) REFERENCES tb_grupos(id),
    FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id)
);

INSERT INTO tb_usuarios (nome, senha, email, sobremim, administrador) VALUES ('admin', MD5('admin12345'), 'admin@gmail.com', 'Administrador do sistema', TRUE);
INSERT INTO tb_usuarios (nome, senha, email, sobremim, administrador) VALUES ('willian carlos', MD5('senha123'), 'w2569129@gmail.com', 'Desenvolvedor da rede social | FriendCircle', FALSE);
INSERT INTO tb_usuarios (nome, senha, email, sobremim, administrador) VALUES ('Maria Oliveira', MD5('senha123'), 'maria.oliveira@gmail.com', 'Entusiasta de livros e viagens.', FALSE);
INSERT INTO tb_usuarios (nome, senha, email, sobremim, administrador) VALUES ('Carlos Santos', MD5('senha123'), 'carlos.santos@gmail.com', 'Engenheiro com interesse em astronomia.', FALSE);
INSERT INTO tb_usuarios (nome, senha, email, sobremim, administrador) VALUES ('Ana Costa', MD5('senha123'), 'ana.costa@gmail.com', 'Amante de culinária e artes.', FALSE);
INSERT INTO tb_usuarios (nome, senha, email, sobremim, administrador) VALUES ('Paulo Lima', MD5('senha123'), 'paulo.lima@gmail.com', 'Aficionado por esportes e investimentos.', FALSE);

INSERT INTO tb_postagens (id_usuario, descricao, privacidade, data_postagem) 
VALUES 
(2, 'Acabamos de lançar uma nova atualização no FriendCircle! Confira as novidades.', 'publico', '2024-06-27'),
(2, 'Trabalhando em novos recursos para melhorar a experiência dos nossos usuários.', 'privado', '2024-06-26'),
(2, 'O suporte ao cliente do FriendCircle está disponível 24/7. Estamos aqui para ajudar!', 'publico', '2024-06-25'),
(2, 'Participando de uma conferência sobre redes sociais. Muitas ideias novas para o FriendCircle.', 'publico', '2024-06-24'),
(2, 'Testando a nova interface do usuário do FriendCircle. Está ficando incrível!', 'privado', '2024-06-23');

INSERT INTO tb_postagens (id_usuario, descricao, privacidade, data_postagem) 
VALUES 
(3, 'Acabei de ler um livro incrível sobre desenvolvimento pessoal. Super recomendo!', 'publico', '2024-06-27'),
(3, 'Mais um dia produtivo no trabalho. Grata por todas as oportunidades.', 'privado', '2024-06-26'),
(3, 'Estou planejando uma viagem para a serra no próximo mês. Alguém tem dicas?', 'publico', '2024-06-25'),
(3, 'Explorando novas funcionalidades do meu laptop. Muito útil para o trabalho.', 'publico', '2024-06-24'),
(3, 'Participando de um webinar sobre inteligência artificial. Muito informativo!', 'privado', '2024-06-23');

INSERT INTO tb_postagens (id_usuario, descricao, privacidade, data_postagem) 
VALUES 
(4, 'Assistindo a um documentário sobre astronomia. Fascinante!', 'publico', '2024-06-27'),
(4, 'Preparando um novo projeto de engenharia. Muitos desafios pela frente.', 'privado', '2024-06-26'),
(4, 'Passeio de bicicleta pelas montanhas no fim de semana foi incrível.', 'publico', '2024-06-25'),
(4, 'Testando um novo software de modelagem 3D. Ferramenta incrível!', 'publico', '2024-06-24'),
(4, 'Configurando um servidor para um projeto pessoal. Muito aprendizado!', 'privado', '2024-06-23');

INSERT INTO tb_postagens (id_usuario, descricao, privacidade, data_postagem) 
VALUES 
(5, 'Nova receita de bolo de chocolate saiu perfeita! Quem quer a receita?', 'publico', '2024-06-27'),
(5, 'Tarde de pintura e relaxamento. Nada melhor.', 'privado', '2024-06-26'),
(5, 'Aproveitando o dia de sol na praia.', 'publico', '2024-06-25'),
(5, 'Atualizando meu blog com novas dicas de culinária. Confiram!', 'publico', '2024-06-24'),
(5, 'Organizando meu espaço de trabalho. A produtividade agradece!', 'privado', '2024-06-23');

INSERT INTO tb_postagens (id_usuario, descricao, privacidade, data_postagem) 
VALUES 
(6, 'Jogando futebol com os amigos. Que partida!', 'publico', '2024-06-27'),
(6, 'Estudando novas estratégias de investimento. Sempre aprendendo.', 'privado', '2024-06-26'),
(6, 'Visita ao museu de arte contemporânea foi inspiradora.', 'publico', '2024-06-25'),
(6, 'Testando um novo aplicativo de gestão financeira. Parece promissor!', 'publico', '2024-06-24'),
(6, 'Configurando meu novo smartwatch. Muitas funcionalidades úteis.', 'privado', '2024-06-23');

INSERT INTO tb_seguidores (id_usuario, id_usuario_seguindo) VALUES 
(2, 3),
(3, 2),
(3, 4),
(4, 2);

INSERT INTO tb_curtidas_postagens (id_usuario, id_postagem) VALUES 
(1, 1),
(2, 2),
(3, 3);

INSERT INTO tb_comentarios_postagens (id_usuario, id_postagem, comentario, data_postagem) VALUES 
(1, 2, 'Ótima postagem!', '2024-06-27'),
(2, 3, 'Concordo totalmente.', '2024-06-26'),
(3, 1, 'Interessante ponto de vista.', '2024-06-25');

INSERT INTO tb_curtidas_comentarios (id_usuario, id_comentario) VALUES 
(1, 1),
(2, 2),
(3, 3);

INSERT INTO tb_denuncias (id_postagem, id_usuario_denunciou) VALUES 
(1, 3),
(2, 1),
(3, 2);

INSERT INTO tb_grupos (nome, descricao) VALUES 
('Grupo de Desenvolvedores', 'Grupo para discutir novas tecnologias'),
('Leitores Ávidos', 'Amantes de livros de todos os tipos'),
('Entusiastas de Esportes', 'Para todos que amam esportes');
