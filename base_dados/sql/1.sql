INSERT INTO config_update(descricao, sql_num, sql_script)
values(
    'Criação da tabela pessoa',
    1,
    'CREATE TABLE pessoa (
    id int not null auto_increment primary key,
    nome varchar(150) not null,
    nome_fantasia varchar(150),
    tipo char(1) not null,
    data_nascimento date,
    cpf_cnpj varchar(20),
    email varchar(150),
    telefone varchar(20),
    whatsapp varchar(20),
    endereco varchar(255),
    cidade varchar(150),
    estado char(2),
    cep varchar(10),
    data_cadastro datetime not null default current_timestamp
);'

);
CREATE TABLE pessoa (
    id int not null auto_increment primary key,
    nome varchar(150) not null,
    nome_fantasia varchar(150),
    tipo char(1) not null,
    data_nascimento date,
    cpf_cnpj varchar(20),
    email varchar(150),
    telefone varchar(20),
    whatsapp varchar(20),
    endereco varchar(255),
    cidade varchar(150),
    estado char(2),
    cep varchar(10),
    data_cadastro datetime not null default current_timestamp
);