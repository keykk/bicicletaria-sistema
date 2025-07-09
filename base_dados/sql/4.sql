INSERT INTO config_update(descricao, sql_num, sql_script)
values(
    'Campo Empresa nas tabelas de preço e estoque',
    4,
    '
    ALTER TABLE tabelas_preco ADD COLUMN empresa_id INT NOT NULL;
    UPDATE tabelas_preco SET empresa_id = (SELECT id_pessoa FROM pessoa_empresa LIMIT 1);
    ALTER TABLE tabelas_preco ADD CONSTRAINT fk_tabelas_preco_empresa FOREIGN KEY (empresa_id) REFERENCES pessoa_empresa(id_pessoa);


    ALTER TABLE estoque ADD COLUMN empresa_id INT NOT NULL;
    UPDATE estoque SET empresa_id = (SELECT id_pessoa FROM pessoa_empresa LIMIT 1);
    ALTER TABLE estoque ADD CONSTRAINT fk_estoque_empresa FOREIGN KEY (empresa_id) REFERENCES pessoa_empresa(id_pessoa);
    '
);

ALTER TABLE tabelas_preco ADD COLUMN empresa_id INT NOT NULL;
UPDATE tabelas_preco SET empresa_id = (SELECT id_pessoa FROM pessoa_empresa LIMIT 1);
ALTER TABLE tabelas_preco ADD CONSTRAINT fk_tabelas_preco_empresa FOREIGN KEY (empresa_id) REFERENCES pessoa_empresa(id_pessoa);


ALTER TABLE estoque ADD COLUMN empresa_id INT NOT NULL;
UPDATE estoque SET empresa_id = (SELECT id_pessoa FROM pessoa_empresa LIMIT 1);
ALTER TABLE estoque ADD CONSTRAINT fk_estoque_empresa FOREIGN KEY (empresa_id) REFERENCES pessoa_empresa(id_pessoa);