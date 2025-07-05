INSERT INTO config_update(descricao, sql_num, sql_script)
values(
    'Criação das tabelas vendas e itens_venda',
    3,
    'ALTER TABLE itens_tabela_preco ADD UNIQUE INDEX idx_tabela_produto (id_tabela, id_produto);
    DROP TABLE if exists itens_venda;
    DROP TABLE if exists vendas;

    CREATE TABLE IF NOT EXISTS vendas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cliente_nome VARCHAR(255) NULL,
        cliente_telefone VARCHAR(20) NULL,
        cliente_email VARCHAR(255) NULL,
        subtotal DECIMAL(10,2) NOT NULL,
        desconto DECIMAL(10,2) DEFAULT 0,
        total DECIMAL(10,2) NOT NULL,
        forma_pagamento ENUM(''dinheiro'', ''cartao_debito'', ''cartao_credito'', ''pix'') NOT NULL,
        valor_pago DECIMAL(10,2) NULL,
        troco DECIMAL(10,2) NULL,
        observacoes TEXT NULL,
        status ENUM(''finalizada'', ''cancelada'', ''pendente'') DEFAULT ''finalizada'',
        motivo_cancelamento TEXT NULL,
        data_cancelamento TIMESTAMP NULL,
        usuario_id INT NOT NULL,
        data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        empresa_id INT NOT NULL,
        INDEX idx_data_venda (data_venda),
        INDEX idx_forma_pagamento (forma_pagamento),
        INDEX idx_status (status),
        INDEX idx_usuario (usuario_id),
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE RESTRICT,
        CONSTRAINT fk_venda_empresa FOREIGN KEY (empresa_id) REFERENCES pessoa_empresa(id_pessoa) ON DELETE RESTRICT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

    CREATE TABLE IF NOT EXISTS itens_venda (
        id INT AUTO_INCREMENT PRIMARY KEY,
        venda_id INT NOT NULL,
        produto_id INT NOT NULL,
        quantidade DECIMAL(10,3) NOT NULL,
        preco_unitario DECIMAL(10,2) NOT NULL,
        subtotal DECIMAL(10,2) NOT NULL,
        desconto_item DECIMAL(10,2) DEFAULT 0,
        tabela_preco_id INT NOT NULL,
        INDEX idx_venda (venda_id),
        INDEX idx_produto (produto_id),
        FOREIGN KEY (venda_id) REFERENCES vendas(id) ON DELETE CASCADE,
        FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE RESTRICT,
        CONSTRAINT fk_itens_tabela_preco FOREIGN KEY (tabela_preco_id, produto_id) REFERENCES itens_tabela_preco(id_tabela, id_produto) ON DELETE RESTRICT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;'
);

ALTER TABLE itens_tabela_preco ADD UNIQUE INDEX idx_tabela_produto (id_tabela, id_produto);

DROP TABLE if exists itens_venda;
DROP TABLE if exists vendas;

CREATE TABLE IF NOT EXISTS vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_nome VARCHAR(255) NULL,
    cliente_telefone VARCHAR(20) NULL,
    cliente_email VARCHAR(255) NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    desconto DECIMAL(10,2) DEFAULT 0,
    total DECIMAL(10,2) NOT NULL,
    forma_pagamento ENUM('dinheiro', 'cartao_debito', 'cartao_credito', 'pix') NOT NULL,
    valor_pago DECIMAL(10,2) NULL,
    troco DECIMAL(10,2) NULL,
    observacoes TEXT NULL,
    status ENUM('finalizada', 'cancelada', 'pendente') DEFAULT 'finalizada',
    motivo_cancelamento TEXT NULL,
    data_cancelamento TIMESTAMP NULL,
    usuario_id INT NOT NULL,
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    empresa_id INT NOT NULL,
    INDEX idx_data_venda (data_venda),
    INDEX idx_forma_pagamento (forma_pagamento),
    INDEX idx_status (status),
    INDEX idx_usuario (usuario_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE RESTRICT,
    CONSTRAINT fk_venda_empresa FOREIGN KEY (empresa_id) REFERENCES pessoa_empresa(id_pessoa) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS itens_venda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venda_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade DECIMAL(10,3) NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    desconto_item DECIMAL(10,2) DEFAULT 0,
    tabela_preco_id INT NOT NULL,
    INDEX idx_venda (venda_id),
    INDEX idx_produto (produto_id),
    FOREIGN KEY (venda_id) REFERENCES vendas(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE RESTRICT,
    CONSTRAINT fk_itens_tabela_preco FOREIGN KEY (tabela_preco_id, produto_id) REFERENCES itens_tabela_preco(id_tabela, id_produto) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;