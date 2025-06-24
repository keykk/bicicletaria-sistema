-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/06/2025 às 08:30
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bikesystem`
--
CREATE DATABASE IF NOT EXISTS `bikesystem` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `bikesystem`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamentos_servicos`
--

CREATE TABLE `agendamentos_servicos` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `nome_cliente` varchar(255) NOT NULL,
  `telefone_cliente` varchar(50) DEFAULT NULL,
  `email_cliente` varchar(255) DEFAULT NULL,
  `id_servico` int(11) NOT NULL,
  `data_agendamento` datetime NOT NULL,
  `observacoes` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Agendado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `atividades_usuarios`
--

CREATE TABLE `atividades_usuarios` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `descricao` text NOT NULL,
  `dados_extras` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`dados_extras`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `atividades_usuarios`
--

INSERT INTO `atividades_usuarios` (`id`, `usuario_id`, `tipo`, `descricao`, `dados_extras`, `ip_address`, `user_agent`, `data_criacao`) VALUES
(1, 1, 'login', 'Login realizado com sucesso', '{\"ip\": \"127.0.0.1\", \"navegador\": \"Sistema\"}', NULL, NULL, '2025-06-24 05:05:07'),
(2, 1, 'perfil_atualizado', 'Perfil atualizado pelo usuário', '{\"campos_alterados\": [\"nome\", \"email\"]}', NULL, NULL, '2025-06-24 05:05:07');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 0,
  `data_atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `estoque`
--

INSERT INTO `estoque` (`id`, `id_produto`, `quantidade`, `data_atualizacao`) VALUES
(1, 1, 10, '2025-06-22 05:57:11'),
(2, 2, 28, '2025-06-22 08:49:12'),
(3, 3, 50, '2025-06-22 05:57:11');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_orcamento`
--

CREATE TABLE `itens_orcamento` (
  `id` int(11) NOT NULL,
  `id_orcamento` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `itens_orcamento`
--

INSERT INTO `itens_orcamento` (`id`, `id_orcamento`, `id_produto`, `quantidade`, `preco`, `subtotal`) VALUES
(29, 25, 1, 1, 3000.00, 3000.00),
(30, 25, 2, 1, 214.29, 214.29),
(31, 25, 3, 1, 114.29, 114.29);

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_tabela_preco`
--

CREATE TABLE `itens_tabela_preco` (
  `id` int(11) NOT NULL,
  `id_tabela` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `preco` decimal(15,2) NOT NULL,
  `modelo_lucratividade` int(11) DEFAULT NULL,
  `porcentual_lucratividade` decimal(7,3) DEFAULT NULL,
  `valor_revenda` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `itens_tabela_preco`
--

INSERT INTO `itens_tabela_preco` (`id`, `id_tabela`, `id_produto`, `preco`, `modelo_lucratividade`, `porcentual_lucratividade`, `valor_revenda`) VALUES
(20, 25, 2, 150.00, 1, 30.000, 214.29),
(21, 25, 3, 80.00, 1, 30.000, 114.29),
(22, 25, 1, 1500.00, 0, 100.000, 3000.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_venda`
--

CREATE TABLE `itens_venda` (
  `id` int(11) NOT NULL,
  `id_venda` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `orcamentos`
--

CREATE TABLE `orcamentos` (
  `id` int(11) NOT NULL,
  `cliente` varchar(255) NOT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `valor_total` decimal(10,2) NOT NULL,
  `id_tabela_preco` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `orcamentos`
--

INSERT INTO `orcamentos` (`id`, `cliente`, `telefone`, `email`, `data`, `valor_total`, `id_tabela_preco`) VALUES
(25, 'Edson', '(14) 99685-4401', 'keykkashi@gmail.com', '2025-06-24 04:39:58', 3328.58, 25);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco_venda` decimal(10,2) NOT NULL,
  `unidade_medida` varchar(50) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `aro` varchar(50) DEFAULT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco_venda`, `unidade_medida`, `marca`, `modelo`, `aro`, `tipo`, `categoria`) VALUES
(1, 'Bicicleta Mountain Bike Aro 29', 'Bicicleta para trilhas, quadro de alumínio', 1500.00, 'unidade', 'Caloi', 'Elite Carbon', '29', 'Mountain Bike', 'Bicicletas'),
(2, 'Capacete de Ciclismo', 'Capacete leve e ventilado', 150.00, 'unidade', 'Specialized', 'Echelon II', 'N/A', 'N/A', 'Acessórios'),
(3, 'Corrente de Bicicleta 9v', 'Corrente para 9 velocidades', 80.00, 'unidade', 'Shimano', 'HG53', 'N/A', 'N/A', 'Peças'),
(4, 'Serviço de Revisão Básica', 'Limpeza, lubrificação e ajustes básicos', 75.00, 'serviço', NULL, NULL, NULL, NULL, 'Serviços');

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `id` int(11) NOT NULL,
  `nome_servico` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabelas_preco`
--

CREATE TABLE `tabelas_preco` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tabelas_preco`
--

INSERT INTO `tabelas_preco` (`id`, `nome`, `data_criacao`) VALUES
(25, 'Tabela teste', '2025-06-23 16:20:58');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome_usuario` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel_acesso` varchar(50) NOT NULL DEFAULT 'usuario',
  `nome` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `receber_notificacoes` tinyint(1) DEFAULT 1,
  `mostrar_atividades` tinyint(1) DEFAULT 1,
  `ultima_alteracao_senha` timestamp NULL DEFAULT NULL,
  `total_logins` int(11) DEFAULT 0,
  `ultimo_ip` varchar(45) DEFAULT NULL,
  `ativo` smallint(6) NOT NULL,
  `dths_cadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `ultimo_acesso` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome_usuario`, `senha`, `nivel_acesso`, `nome`, `email`, `avatar`, `receber_notificacoes`, `mostrar_atividades`, `ultima_alteracao_senha`, `total_logins`, `ultimo_ip`, `ativo`, `dths_cadastro`, `ultimo_acesso`) VALUES
(1, 'admin', '$argon2id$v=19$m=65536,t=4,p=1$ZXlqcEs3NldFU0JoTmNoVQ$Q70bqBOeeVNgPXV3JFHe2tx/iHOiXPSnJ48gDtYqP0Q', 'admin', 'Gabriel', 'keykkashi@gmail.com', NULL, 1, 1, NULL, 0, NULL, 1, '2025-06-23 04:08:39', NULL),
(2, 'vendedor1', '56976bf24998ca63e35fe4f1e2469b5751d1856003e8d16fef0aafef496ed044', 'vendedor', 'Teste', '', NULL, 1, 1, NULL, 0, NULL, 0, '2025-06-23 04:08:39', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id` int(11) NOT NULL,
  `id_orcamento` int(11) DEFAULT NULL,
  `data_venda` timestamp NOT NULL DEFAULT current_timestamp(),
  `valor_total` decimal(10,2) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendamentos_servicos`
--
ALTER TABLE `agendamentos_servicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_servico` (`id_servico`);

--
-- Índices de tabela `atividades_usuarios`
--
ALTER TABLE `atividades_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario_data` (`usuario_id`,`data_criacao`),
  ADD KEY `idx_tipo` (`tipo`);

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `itens_orcamento`
--
ALTER TABLE `itens_orcamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_orcamento` (`id_orcamento`),
  ADD KEY `idx_produto` (`id_produto`);

--
-- Índices de tabela `itens_tabela_preco`
--
ALTER TABLE `itens_tabela_preco`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tabela` (`id_tabela`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_venda` (`id_venda`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `orcamentos`
--
ALTER TABLE `orcamentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tabelas_preco`
--
ALTER TABLE `tabelas_preco`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_usuario` (`nome_usuario`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_orcamento` (`id_orcamento`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos_servicos`
--
ALTER TABLE `agendamentos_servicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `atividades_usuarios`
--
ALTER TABLE `atividades_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `itens_orcamento`
--
ALTER TABLE `itens_orcamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `itens_tabela_preco`
--
ALTER TABLE `itens_tabela_preco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `orcamentos`
--
ALTER TABLE `orcamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tabelas_preco`
--
ALTER TABLE `tabelas_preco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `agendamentos_servicos`
--
ALTER TABLE `agendamentos_servicos`
  ADD CONSTRAINT `agendamentos_servicos_ibfk_1` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `atividades_usuarios`
--
ALTER TABLE `atividades_usuarios`
  ADD CONSTRAINT `atividades_usuarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `itens_orcamento`
--
ALTER TABLE `itens_orcamento`
  ADD CONSTRAINT `itens_orcamento_ibfk_1` FOREIGN KEY (`id_orcamento`) REFERENCES `orcamentos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `itens_orcamento_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `itens_tabela_preco`
--
ALTER TABLE `itens_tabela_preco`
  ADD CONSTRAINT `itens_tabela_preco_ibfk_1` FOREIGN KEY (`id_tabela`) REFERENCES `tabelas_preco` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `itens_tabela_preco_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD CONSTRAINT `itens_venda_ibfk_1` FOREIGN KEY (`id_venda`) REFERENCES `vendas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `itens_venda_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`id_orcamento`) REFERENCES `orcamentos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vendas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
