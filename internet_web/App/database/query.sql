create table tb_usuarios(
	id int primary key auto_increment,
	nome varchar(100) not null,
    senha varchar(32) not null,
    email varchar(200) not null,
    sobremim varchar(200) default'sem descrição',
    fotoperfil varchar(200)
);

create table tb_seguidores(
	id int primary key auto_increment,
    id_usuario int,
    id_usuario_seguindo int,
    
    foreign key (id_usuario) references tb_usuarios(id),
    foreign key (id_usuario_seguindo) references tb_usuarios(id)
);

create table tb_postagens(
	id int primary key auto_increment,
    id_usuario int not null,
    descricao varchar(1000),
    imagem varchar(200),
    privacidade varchar(40),
    data_postagem date,
    
    foreign key (id_usuario) references tb_usuarios(id)
);

create table tb_curtidas_postagens(
	id int primary key auto_increment,
    id_usuario int not null,
    id_postagem int not null,
    
    foreign key (id_usuario) references tb_usuarios(id),
    foreign key (id_postagem) references tb_postagens(id)
);

create table tb_comentarios_postagens(
	id int primary key auto_increment,
    id_usuario int not null,
    id_postagem int not null,
    comentario varchar(400) not null,
    data_postagem date,
    
    foreign key (id_usuario) references tb_usuarios(id)
);

create table tb_curtidas_comentarios(
	id int primary key auto_increment,
    id_usuario int not null,
    id_comentario int not null,
    
    foreign key (id_usuario) references tb_usuarios(id),
    foreign key (id_comentario) references tb_comentarios_postagens(id)
);

create table tb_denuncias(
	id int primary key auto_increment,
    id_postagem int not null,
    id_usuario_denunciou int not null,
    
    foreign key (id_postagem) references tb_postagens(id),
    foreign key (id_usuario_denunciou) references tb_usuarios(id)
);

create table tb_grupos(
	id int primary key auto_increment,
    nome varchar(200) not null,
    descricao varchar(400)
);

create table tb_seguindo_grupos(
	id int primary key auto_increment,
    id_grupo int not null,
    id_usuario int not null,
    
    foreign key (id_grupo) references tb_grupos(id),
    foreign key (id_usuario) references tb_usuarios(id)
);

