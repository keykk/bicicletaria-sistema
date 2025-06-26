INSERT INTO config_update(descricao, sql_num, sql_script)
values(
    'Criação da tabela pessoa_empresa',
    2,
    'CREATE table pessoa_empresa(
    id_pessoa integer not null,
    slogan varchar(255),
    website varchar(255),
    facebook varchar(255),
    instagram varchar(255),
    linkedin varchar(255),
    twitter varchar(255),
    youtube varchar(255),
    caminho_logo varchar(255),
    caminho_favicon varchar(255),
    cor_primaria varchar(255),
    cor_secundaria varchar(255),
    inscricao_estadual varchar(255),
    regime_tributario varchar(255),
    nome_responsavel varchar(255),
    constraint fk_pessoa_empresa foreign key (id_pessoa) references pessoa(id) on delete cascade,
    constraint pk_pessoa_empresa primary key (id_pessoa)
);'
);
CREATE table pessoa_empresa(
    id_pessoa integer not null,
    slogan varchar(255),
    website varchar(255),
    facebook varchar(255),
    instagram varchar(255),
    linkedin varchar(255),
    twitter varchar(255),
    youtube varchar(255),
    caminho_logo varchar(255),
    caminho_favicon varchar(255),
    cor_primaria varchar(255),
    cor_secundaria varchar(255),
    inscricao_estadual varchar(255),
    regime_tributario varchar(255),
    nome_responsavel varchar(255),
    constraint fk_pessoa_empresa foreign key (id_pessoa) references pessoa(id) on delete cascade,
    constraint pk_pessoa_empresa primary key (id_pessoa)
);