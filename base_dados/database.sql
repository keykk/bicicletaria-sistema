
-- Tabela de produtos
CREATE TABLE IF NOT EXISTS `produtos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255) NOT NULL,
    `descricao` TEXT,
    `preco_venda` DECIMAL(10, 2) NOT NULL,
    `unidade_medida` VARCHAR(50) NOT NULL,
    `marca` VARCHAR(100),
    `modelo` VARCHAR(100),
    `aro` VARCHAR(50),
    `tipo` VARCHAR(100),
    `categoria` VARCHAR(100) NOT NULL
);

-- Tabela de estoque
CREATE TABLE IF NOT EXISTS `estoque` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_produto` INT NOT NULL,
    `quantidade` INT NOT NULL DEFAULT 0,
    `data_atualizacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`id_produto`) REFERENCES `produtos`(`id`) ON DELETE CASCADE
);

-- Tabela de tabelas de preço
CREATE TABLE IF NOT EXISTS `tabelas_preco` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255) NOT NULL,
    `data_criacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de itens da tabela de preço
CREATE TABLE IF NOT EXISTS `itens_tabela_preco` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_tabela` INT NOT NULL,
    `id_produto` INT NOT NULL,
    `preco` DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (`id_tabela`) REFERENCES `tabelas_preco`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_produto`) REFERENCES `produtos`(`id`) ON DELETE CASCADE
);

-- Tabela de orçamentos
CREATE TABLE IF NOT EXISTS `orcamentos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `cliente` VARCHAR(255) NOT NULL,
    `telefone` VARCHAR(50),
    `email` VARCHAR(255),
    `data` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `valor_total` DECIMAL(10, 2) NOT NULL
);

-- Tabela de itens do orçamento
CREATE TABLE IF NOT EXISTS `itens_orcamento` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_orcamento` INT NOT NULL,
    `id_produto` INT NOT NULL,
    `quantidade` INT NOT NULL,
    `preco` DECIMAL(10, 2) NOT NULL,
    `subtotal` DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (`id_orcamento`) REFERENCES `orcamentos`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_produto`) REFERENCES `produtos`(`id`) ON DELETE CASCADE
);

-- Tabela de serviços (para manutenções e reparos)
CREATE TABLE IF NOT EXISTS `servicos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome_servico` VARCHAR(255) NOT NULL,
    `descricao` TEXT,
    `preco` DECIMAL(10, 2) NOT NULL
);

-- Tabela de agendamentos de serviços (exemplo)
CREATE TABLE IF NOT EXISTS `agendamentos_servicos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_cliente` INT, -- Pode ser FK para uma futura tabela de clientes, ou apenas nome/contato
    `nome_cliente` VARCHAR(255) NOT NULL,
    `telefone_cliente` VARCHAR(50),
    `email_cliente` VARCHAR(255),
    `id_servico` INT NOT NULL,
    `data_agendamento` DATETIME NOT NULL,
    `observacoes` TEXT,
    `status` VARCHAR(50) DEFAULT 'Agendado',
    FOREIGN KEY (`id_servico`) REFERENCES `servicos`(`id`) ON DELETE CASCADE
);

-- Tabela de usuários (para controle de acesso)
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome_usuario` VARCHAR(100) NOT NULL UNIQUE,
    `senha` VARCHAR(255) NOT NULL,
    `nivel_acesso` VARCHAR(50) NOT NULL DEFAULT 'usuario' -- 'admin', 'gerente', 'vendedor'
);

-- Tabela de vendas (para relatórios de vendas)
CREATE TABLE IF NOT EXISTS `vendas` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_orcamento` INT UNIQUE, -- Se a venda for gerada a partir de um orçamento
    `data_venda` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `valor_total` DECIMAL(10, 2) NOT NULL,
    `id_usuario` INT NOT NULL,
    FOREIGN KEY (`id_orcamento`) REFERENCES `orcamentos`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
);

-- Tabela de itens da venda
CREATE TABLE IF NOT EXISTS `itens_venda` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_venda` INT NOT NULL,
    `id_produto` INT NOT NULL,
    `quantidade` INT NOT NULL,
    `preco_unitario` DECIMAL(10, 2) NOT NULL,
    `subtotal` DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (`id_venda`) REFERENCES `vendas`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_produto`) REFERENCES `produtos`(`id`) ON DELETE CASCADE
);

-- Inserção de dados de exemplo (opcional)
INSERT INTO `usuarios` (`nome_usuario`, `senha`, `nivel_acesso`) VALUES
('admin', SHA2('admin123', 256), 'admin'),
('vendedor1', SHA2('vendedor123', 256), 'vendedor');

INSERT INTO `produtos` (`nome`, `descricao`, `preco_venda`, `unidade_medida`, `marca`, `modelo`, `aro`, `tipo`, `categoria`) VALUES
('Bicicleta Mountain Bike Aro 29', 'Bicicleta para trilhas, quadro de alumínio', 1500.00, 'unidade', 'Caloi', 'Elite Carbon', '29', 'Mountain Bike', 'Bicicletas'),
('Capacete de Ciclismo', 'Capacete leve e ventilado', 150.00, 'unidade', 'Specialized', 'Echelon II', 'N/A', 'N/A', 'Acessórios'),
('Corrente de Bicicleta 9v', 'Corrente para 9 velocidades', 80.00, 'unidade', 'Shimano', 'HG53', 'N/A', 'N/A', 'Peças'),
('Serviço de Revisão Básica', 'Limpeza, lubrificação e ajustes básicos', 75.00, 'serviço', NULL, NULL, NULL, NULL, 'Serviços');

INSERT INTO `estoque` (`id_produto`, `quantidade`) VALUES
(1, 10),
(2, 25),
(3, 50);


