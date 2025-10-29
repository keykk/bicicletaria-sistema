-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: bikesystem
-- ------------------------------------------------------
-- Server version	5.5.5-10.6.22-MariaDB-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agendamentos_servicos`
--

DROP TABLE IF EXISTS `agendamentos_servicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agendamentos_servicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) DEFAULT NULL,
  `nome_cliente` varchar(255) NOT NULL,
  `telefone_cliente` varchar(50) DEFAULT NULL,
  `email_cliente` varchar(255) DEFAULT NULL,
  `id_servico` int(11) NOT NULL,
  `data_agendamento` datetime NOT NULL,
  `observacoes` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Agendado',
  PRIMARY KEY (`id`),
  KEY `id_servico` (`id_servico`),
  CONSTRAINT `agendamentos_servicos_ibfk_1` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agendamentos_servicos`
--

LOCK TABLES `agendamentos_servicos` WRITE;
/*!40000 ALTER TABLE `agendamentos_servicos` DISABLE KEYS */;
/*!40000 ALTER TABLE `agendamentos_servicos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atividades_usuarios`
--

DROP TABLE IF EXISTS `atividades_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `atividades_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `descricao` text NOT NULL,
  `dados_extras` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`dados_extras`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_usuario_data` (`usuario_id`,`data_criacao`),
  KEY `idx_tipo` (`tipo`),
  CONSTRAINT `atividades_usuarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atividades_usuarios`
--

LOCK TABLES `atividades_usuarios` WRITE;
/*!40000 ALTER TABLE `atividades_usuarios` DISABLE KEYS */;
INSERT INTO `atividades_usuarios` VALUES (1,1,'login','Login realizado com sucesso','{\"ip\": \"127.0.0.1\", \"navegador\": \"Sistema\"}',NULL,NULL,'2025-06-24 05:05:07'),(2,1,'perfil_atualizado','Perfil atualizado pelo usuário','{\"campos_alterados\": [\"nome\", \"email\"]}',NULL,NULL,'2025-06-24 05:05:07');
/*!40000 ALTER TABLE `atividades_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config_update`
--

DROP TABLE IF EXISTS `config_update`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `config_update` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(150) DEFAULT NULL,
  `sql_num` int(11) DEFAULT NULL,
  `sql_script` text DEFAULT NULL,
  `dths_cadastro` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_update`
--

LOCK TABLES `config_update` WRITE;
/*!40000 ALTER TABLE `config_update` DISABLE KEYS */;
INSERT INTO `config_update` VALUES (1,'Criação da tabela pessoa',1,'CREATE TABLE pessoa (\n    id int not null auto_increment primary key,\n    nome varchar(150) not null,\n    nome_fantasia varchar(150),\n    tipo char(1) not null,\n    data_nascimento date,\n    cpf_cnpj varchar(20),\n    email varchar(150),\n    telefone varchar(20),\n    whatsapp varchar(20),\n    endereco varchar(255),\n    cidade varchar(150),\n    estado char(2),\n    cep varchar(10),\n    data_cadastro datetime not null default current_timestamp\n);','2025-06-25 11:45:30'),(2,'Criação da tabela pessoa_empresa',2,'CREATE table pessoa_empresa(\n    id_pessoa integer not null,\n    slogan varchar(255),\n    website varchar(255),\n    facebook varchar(255),\n    instagram varchar(255),\n    linkedin varchar(255),\n    twitter varchar(255),\n    youtube varchar(255),\n    caminho_logo varchar(255),\n    caminho_favicon varchar(255),\n    cor_primaria varchar(255),\n    cor_secundaria varchar(255),\n    inscricao_estadual varchar(255),\n    regime_tributario varchar(255),\n    nome_responsavel varchar(255),\n    constraint fk_pessoa_empresa foreign key (id_pessoa) references pessoa(id) on delete cascade,\n    constraint pk_pessoa_empresa primary key (id_pessoa)\n);','2025-06-25 12:08:45'),(3,'Criação das tabelas vendas e itens_venda',3,'ALTER TABLE itens_tabela_preco ADD UNIQUE INDEX idx_tabela_produto (id_tabela, id_produto);\n    DROP TABLE if exists itens_venda;\n    DROP TABLE if exists vendas;\n\n    CREATE TABLE IF NOT EXISTS vendas (\n        id INT AUTO_INCREMENT PRIMARY KEY,\n        cliente_nome VARCHAR(255) NULL,\n        cliente_telefone VARCHAR(20) NULL,\n        cliente_email VARCHAR(255) NULL,\n        subtotal DECIMAL(10,2) NOT NULL,\n        desconto DECIMAL(10,2) DEFAULT 0,\n        total DECIMAL(10,2) NOT NULL,\n        forma_pagamento ENUM(\'dinheiro\', \'cartao_debito\', \'cartao_credito\', \'pix\') NOT NULL,\n        valor_pago DECIMAL(10,2) NULL,\n        troco DECIMAL(10,2) NULL,\n        observacoes TEXT NULL,\n        status ENUM(\'finalizada\', \'cancelada\', \'pendente\') DEFAULT \'finalizada\',\n        motivo_cancelamento TEXT NULL,\n        data_cancelamento TIMESTAMP NULL,\n        usuario_id INT NOT NULL,\n        data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n        empresa_id INT NOT NULL,\n        INDEX idx_data_venda (data_venda),\n        INDEX idx_forma_pagamento (forma_pagamento),\n        INDEX idx_status (status),\n        INDEX idx_usuario (usuario_id),\n        FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE RESTRICT,\n        CONSTRAINT fk_venda_empresa FOREIGN KEY (empresa_id) REFERENCES pessoa_empresa(id_pessoa) ON DELETE RESTRICT\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n    CREATE TABLE IF NOT EXISTS itens_venda (\n        id INT AUTO_INCREMENT PRIMARY KEY,\n        venda_id INT NOT NULL,\n        produto_id INT NOT NULL,\n        quantidade DECIMAL(10,3) NOT NULL,\n        preco_unitario DECIMAL(10,2) NOT NULL,\n        subtotal DECIMAL(10,2) NOT NULL,\n        desconto_item DECIMAL(10,2) DEFAULT 0,\n        tabela_preco_id INT NOT NULL,\n        INDEX idx_venda (venda_id),\n        INDEX idx_produto (produto_id),\n        FOREIGN KEY (venda_id) REFERENCES vendas(id) ON DELETE CASCADE,\n        FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE RESTRICT,\n        CONSTRAINT fk_itens_tabela_preco FOREIGN KEY (tabela_preco_id, produto_id) REFERENCES itens_tabela_preco(id_tabela, id_produto) ON DELETE RESTRICT\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;','2025-07-09 12:51:34'),(4,'Campo Empresa nas tabelas de preço e estoque',4,'\n    ALTER TABLE tabelas_preco ADD COLUMN empresa_id INT NOT NULL;\n    UPDATE tabelas_preco SET empresa_id = (SELECT id_pessoa FROM pessoa_empresa LIMIT 1);\n    ALTER TABLE tabelas_preco ADD CONSTRAINT fk_tabelas_preco_empresa FOREIGN KEY (empresa_id) REFERENCES pessoa_empresa(id_pessoa);\n\n\n    ALTER TABLE estoque ADD COLUMN empresa_id INT NOT NULL;\n    UPDATE estoque SET empresa_id = (SELECT id_pessoa FROM pessoa_empresa LIMIT 1);\n    ALTER TABLE estoque ADD CONSTRAINT fk_estoque_empresa FOREIGN KEY (empresa_id) REFERENCES pessoa_empresa(id_pessoa);\n    ','2025-07-11 10:30:19');
/*!40000 ALTER TABLE `config_update` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estoque`
--

DROP TABLE IF EXISTS `estoque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estoque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 0,
  `data_atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `empresa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_produto` (`id_produto`),
  KEY `fk_estoque_empresa` (`empresa_id`),
  CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_estoque_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `pessoa_empresa` (`id_pessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estoque`
--

LOCK TABLES `estoque` WRITE;
/*!40000 ALTER TABLE `estoque` DISABLE KEYS */;
INSERT INTO `estoque` VALUES (1,1,7,'2025-07-11 13:40:27',1),(2,2,29,'2025-07-11 13:30:23',1),(6,7,6,'2025-07-24 14:04:31',1),(7,8,2,'2025-07-11 13:30:23',1),(8,9,2,'2025-07-11 13:30:23',1),(9,10,1,'2025-07-11 13:30:23',1),(10,11,0,'2025-07-11 13:30:23',1),(11,12,0,'2025-07-11 13:30:23',1),(12,13,0,'2025-07-11 13:30:23',1),(13,14,0,'2025-07-11 13:30:23',1),(14,15,0,'2025-07-11 13:30:23',1),(15,16,0,'2025-07-11 13:30:23',1),(16,17,0,'2025-07-11 13:30:23',1),(17,18,0,'2025-07-11 13:30:23',1),(18,19,0,'2025-07-11 13:30:23',1),(19,20,0,'2025-07-11 13:30:23',1),(20,21,0,'2025-07-11 13:30:23',1),(21,22,0,'2025-07-11 13:30:23',1),(22,23,0,'2025-07-11 13:30:23',1),(23,24,0,'2025-07-11 13:30:23',1),(24,25,0,'2025-07-11 13:30:23',1),(25,26,0,'2025-07-11 13:30:23',1),(26,27,0,'2025-07-11 13:30:23',1),(27,28,-3,'2025-07-23 15:44:31',1),(28,29,-2,'2025-07-23 15:54:07',1),(29,30,-1,'2025-07-23 15:44:31',1),(30,31,0,'2025-07-11 13:30:23',1),(31,32,-1,'2025-07-15 14:18:13',1),(32,33,0,'2025-07-11 13:30:23',1),(33,34,-1,'2025-07-23 15:44:31',1),(34,35,0,'2025-07-11 13:30:23',1),(35,36,0,'2025-07-11 13:30:23',1),(36,37,-1,'2025-07-23 15:44:31',1),(37,38,0,'2025-07-11 13:30:23',1),(38,39,0,'2025-07-11 13:30:23',1),(39,40,0,'2025-07-11 13:30:23',1),(40,41,0,'2025-07-11 13:30:23',1),(41,42,0,'2025-07-11 13:30:23',1),(42,43,0,'2025-07-11 13:30:23',1),(43,44,0,'2025-07-11 13:30:23',1),(44,45,-1,'2025-07-23 15:44:31',1),(45,46,0,'2025-07-11 13:30:23',1),(46,47,0,'2025-07-11 13:30:23',1),(47,48,0,'2025-07-11 13:30:23',1),(48,49,1,'2025-07-11 13:30:23',1),(49,50,10,'2025-07-11 13:30:23',1),(50,51,10,'2025-07-11 13:30:23',1),(51,52,10,'2025-07-11 13:30:23',1),(52,53,9,'2025-07-19 14:15:05',1),(53,54,4,'2025-07-11 13:44:39',1),(54,55,3,'2025-07-11 13:30:23',1),(55,56,4,'2025-07-11 13:30:23',1),(56,57,2,'2025-07-11 13:30:23',1),(57,58,1,'2025-07-11 13:30:23',1),(58,59,10,'2025-07-11 13:30:23',1),(59,60,2,'2025-07-11 13:30:23',1),(60,61,5,'2025-07-11 13:30:23',1),(61,62,3,'2025-07-11 13:30:23',1),(62,63,5,'2025-07-11 13:30:23',1),(63,64,3,'2025-07-11 13:30:23',1),(64,65,2,'2025-07-11 13:30:23',1),(65,66,1,'2025-07-11 13:30:23',1),(66,67,2,'2025-07-11 13:30:23',1),(67,68,1,'2025-07-11 13:30:23',1),(68,69,2,'2025-07-11 13:30:23',1),(69,70,1,'2025-07-11 13:30:23',1),(70,71,1,'2025-07-11 13:30:23',1),(71,72,1,'2025-07-15 14:18:13',1),(72,73,1,'2025-07-15 13:40:19',1),(73,74,0,'2025-07-15 14:48:16',1),(74,75,0,'2025-07-15 14:56:46',1),(75,76,5,'2025-07-15 16:43:19',1),(76,77,4,'2025-07-15 16:42:24',1),(77,78,3,'2025-07-15 16:42:09',1),(78,79,2,'2025-07-15 16:40:32',1),(79,80,1,'2025-07-15 16:40:15',1),(80,81,1,'2025-07-15 16:42:39',1),(81,82,2,'2025-07-15 16:42:58',1),(82,83,1,'2025-07-15 16:40:50',1),(83,84,1,'2025-07-15 16:46:33',1),(84,85,1,'2025-07-23 19:17:17',1),(85,86,0,'2025-07-15 16:49:11',1),(86,87,12,'2025-07-23 19:16:56',1),(87,88,2,'2025-07-23 18:50:21',1),(88,89,0,'2025-07-15 16:54:47',1),(89,90,4,'2025-07-24 13:39:26',1),(90,91,2,'2025-07-24 13:35:01',1),(91,92,3,'2025-07-24 13:39:05',1),(92,93,2,'2025-07-24 13:35:46',1),(93,94,4,'2025-07-24 13:36:42',1),(94,95,7,'2025-07-24 13:38:03',1),(95,96,6,'2025-07-24 13:37:32',1),(96,97,2,'2025-07-24 13:33:52',1),(97,98,1,'2025-07-24 13:33:17',1),(98,99,9,'2025-07-24 13:38:34',1),(99,100,8,'2025-07-24 13:31:37',1),(100,101,2,'2025-07-23 17:42:28',1),(101,102,25,'2025-07-23 18:53:34',1),(102,103,3,'2025-07-23 17:41:28',1),(103,104,3,'2025-07-23 18:58:47',1),(104,105,1,'2025-07-23 18:56:48',1),(105,106,0,'2025-07-15 17:40:35',1),(106,107,0,'2025-07-15 17:41:46',1),(107,108,2,'2025-07-24 13:42:50',1),(108,109,1,'2025-07-24 13:42:31',1),(109,110,2,'2025-07-24 13:53:03',1),(110,111,0,'2025-07-15 17:51:37',1),(111,112,0,'2025-07-15 17:54:31',1),(112,113,2,'2025-07-24 13:40:19',1),(113,114,0,'2025-07-15 17:57:43',1),(114,115,2,'2025-07-23 19:52:49',1),(115,116,0,'2025-07-15 18:00:47',1),(116,117,3,'2025-07-23 19:24:48',1),(117,118,0,'2025-07-15 18:03:38',1),(118,119,2,'2025-07-23 19:23:59',1),(119,120,0,'2025-07-15 18:06:16',1),(120,121,1,'2025-07-23 19:52:24',1),(121,122,0,'2025-07-15 18:08:59',1),(122,123,2,'2025-07-24 13:41:22',1),(123,124,1,'2025-07-24 13:41:07',1),(124,125,0,'2025-07-15 18:13:32',1),(125,126,8,'2025-07-23 18:51:44',1),(126,127,0,'2025-07-15 18:16:10',1),(127,128,0,'2025-07-15 18:17:27',1),(128,129,0,'2025-07-15 18:18:37',1),(129,130,0,'2025-07-15 18:20:05',1),(130,131,0,'2025-07-15 18:25:08',1),(131,132,0,'2025-07-15 18:27:25',1),(132,133,0,'2025-07-15 18:28:47',1),(133,134,0,'2025-07-15 18:44:54',1),(134,135,0,'2025-07-15 18:46:58',1),(135,136,0,'2025-07-15 18:48:23',1),(136,137,0,'2025-07-15 18:49:38',1),(137,138,0,'2025-07-15 18:52:10',1),(138,139,0,'2025-07-15 18:53:08',1),(139,140,0,'2025-07-15 18:56:34',1),(140,141,0,'2025-07-15 18:57:34',1),(141,142,0,'2025-07-15 18:58:38',1),(142,143,0,'2025-07-15 18:59:27',1),(143,144,10,'2025-07-23 19:16:26',1),(144,145,0,'2025-07-15 20:19:01',1),(145,146,25,'2025-07-23 17:40:10',1),(146,147,33,'2025-07-23 18:49:28',1),(147,148,30,'2025-07-23 17:40:30',1),(148,149,4,'2025-07-23 18:59:09',1),(149,150,4,'2025-07-23 19:12:15',1),(150,151,0,'2025-07-15 20:28:52',1),(151,152,0,'2025-07-15 20:30:03',1),(152,153,0,'2025-07-15 20:31:22',1),(153,154,0,'2025-07-15 20:32:34',1),(154,155,0,'2025-07-15 20:34:10',1),(155,156,0,'2025-07-15 20:39:24',1),(156,157,0,'2025-07-15 20:40:42',1),(157,158,0,'2025-07-15 20:41:45',1),(158,159,2,'2025-07-24 13:34:35',1),(159,160,1,'2025-07-23 17:49:28',1),(160,161,0,'2025-07-16 13:37:32',1),(161,162,0,'2025-07-16 13:39:04',1),(162,163,1,'2025-07-23 19:26:39',1),(163,164,0,'2025-07-16 13:43:33',1),(164,165,0,'2025-07-16 13:44:55',1),(165,166,0,'2025-07-16 13:46:14',1),(166,167,0,'2025-07-16 13:47:29',1),(167,168,0,'2025-07-16 13:48:18',1),(168,169,0,'2025-07-16 13:49:31',1),(169,170,0,'2025-07-16 13:50:12',1),(170,171,0,'2025-07-16 13:51:06',1),(171,172,0,'2025-07-16 13:51:58',1),(172,173,0,'2025-07-16 13:53:01',1),(173,174,0,'2025-07-16 13:54:09',1),(174,175,0,'2025-07-16 13:56:59',1),(175,176,0,'2025-07-16 13:58:46',1),(176,177,0,'2025-07-16 14:00:34',1),(177,178,4,'2025-08-06 20:34:27',1),(178,179,0,'2025-07-16 14:02:46',1),(179,180,2,'2025-07-24 14:03:47',1),(180,181,2,'2025-08-06 20:33:46',1),(181,182,5,'2025-08-06 20:34:53',1),(182,183,1,'2025-07-16 17:31:45',1),(183,184,0,'2025-07-16 14:09:36',1),(184,185,20,'2025-07-24 14:02:51',1),(185,186,10,'2025-07-24 14:02:34',1),(186,187,1,'2025-07-24 14:52:05',1),(187,188,3,'2025-07-24 14:53:15',1),(188,189,1,'2025-07-24 14:38:25',1),(189,190,2,'2025-07-24 14:39:07',1),(190,191,0,'2025-07-16 14:20:15',1),(191,192,0,'2025-07-16 14:21:25',1),(192,193,0,'2025-07-16 14:22:22',1),(193,194,3,'2025-07-24 14:52:38',1),(194,195,0,'2025-07-16 14:24:43',1),(195,196,0,'2025-07-16 14:25:23',1),(196,197,0,'2025-07-16 16:37:53',1),(197,198,3,'2025-07-23 19:00:24',1),(198,199,0,'2025-07-16 16:40:17',1),(199,200,2,'2025-07-24 14:05:45',1),(200,201,2,'2025-07-24 14:37:02',1),(201,202,0,'2025-07-16 16:43:08',1),(202,203,4,'2025-07-23 18:56:02',1),(203,204,0,'2025-07-16 16:46:27',1),(204,205,0,'2025-07-16 16:47:10',1),(205,206,0,'2025-07-16 16:48:17',1),(206,207,4,'2025-07-23 18:50:03',1),(207,208,0,'2025-07-16 16:51:35',1),(208,209,40,'2025-07-23 19:12:51',1),(209,210,20,'2025-07-23 19:12:36',1),(210,211,0,'2025-07-16 16:54:16',1),(211,212,0,'2025-07-16 16:56:35',1),(212,213,0,'2025-07-16 16:58:18',1),(213,214,6,'2025-07-23 19:15:37',1),(214,215,0,'2025-07-16 17:01:42',1),(215,216,0,'2025-07-16 17:03:03',1),(216,217,0,'2025-07-16 17:03:58',1),(217,218,0,'2025-07-16 17:05:08',1),(218,219,0,'2025-07-16 17:06:16',1),(219,220,0,'2025-07-16 17:06:59',1),(220,221,0,'2025-07-16 17:10:32',1),(221,222,0,'2025-07-16 17:12:19',1),(222,223,0,'2025-07-16 17:13:23',1),(223,224,0,'2025-07-16 17:15:18',1),(224,225,0,'2025-07-16 17:16:21',1),(225,226,1,'2025-07-16 17:31:29',1),(226,227,0,'2025-07-16 17:18:08',1),(227,228,0,'2025-07-16 17:20:32',1),(228,229,2,'2025-07-23 19:13:10',1),(229,230,1,'2025-07-19 14:14:32',1),(230,231,0,'2025-07-22 20:56:02',1),(231,232,0,'2025-07-22 20:59:14',1),(232,233,0,'2025-07-22 21:02:02',1),(233,234,0,'2025-07-22 21:03:54',1),(234,235,0,'2025-07-22 21:06:53',1),(235,236,0,'2025-07-22 21:09:59',1),(236,237,0,'2025-07-22 21:11:37',1),(237,238,0,'2025-07-22 21:14:50',1),(238,239,0,'2025-07-22 21:16:58',1),(239,240,0,'2025-07-22 21:23:14',1),(240,241,0,'2025-07-23 15:44:31',1),(241,242,1,'2025-07-23 15:44:31',1),(242,243,0,'2025-07-23 15:44:31',1),(243,244,1,'2025-07-23 15:44:31',1),(244,245,0,'2025-07-23 15:44:31',1),(245,246,-1,'2025-07-23 15:44:31',1),(246,247,0,'2025-07-23 15:39:30',1),(247,248,0,'2025-07-23 15:41:10',1),(248,249,2,'2025-07-24 13:45:08',1),(249,250,2,'2025-07-24 13:51:54',1),(250,251,0,'2025-07-24 13:57:40',1),(251,252,0,'2025-07-24 14:29:17',1),(252,253,3,'2025-07-24 14:32:56',1),(253,254,3,'2025-07-24 14:51:35',1),(254,255,0,'2025-07-24 14:56:03',1),(255,256,2,'2025-07-24 15:00:55',1),(256,257,1,'2025-07-24 15:03:42',1),(257,258,3,'2025-07-29 15:40:20',1),(258,259,3,'2025-07-29 20:00:38',1),(259,260,0,'2025-08-06 20:37:41',1),(260,261,0,'2025-08-06 20:41:54',1),(261,262,0,'2025-08-07 15:11:11',1),(262,263,0,'2025-08-07 15:14:43',1);
/*!40000 ALTER TABLE `estoque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itens_orcamento`
--

DROP TABLE IF EXISTS `itens_orcamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itens_orcamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_orcamento` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_orcamento` (`id_orcamento`),
  KEY `idx_produto` (`id_produto`),
  CONSTRAINT `itens_orcamento_ibfk_1` FOREIGN KEY (`id_orcamento`) REFERENCES `orcamentos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `itens_orcamento_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itens_orcamento`
--

LOCK TABLES `itens_orcamento` WRITE;
/*!40000 ALTER TABLE `itens_orcamento` DISABLE KEYS */;
INSERT INTO `itens_orcamento` VALUES (29,25,1,1,3000.00,3000.00),(30,25,2,1,214.29,214.29),(32,26,1,1,2500.00,2500.00),(33,26,2,3,250.00,750.00);
/*!40000 ALTER TABLE `itens_orcamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itens_tabela_preco`
--

DROP TABLE IF EXISTS `itens_tabela_preco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itens_tabela_preco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tabela` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `preco` decimal(15,2) NOT NULL,
  `modelo_lucratividade` int(11) DEFAULT NULL,
  `porcentual_lucratividade` decimal(7,3) DEFAULT NULL,
  `valor_revenda` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_tabela_produto` (`id_tabela`,`id_produto`),
  KEY `id_tabela` (`id_tabela`),
  KEY `id_produto` (`id_produto`),
  CONSTRAINT `itens_tabela_preco_ibfk_1` FOREIGN KEY (`id_tabela`) REFERENCES `tabelas_preco` (`id`) ON DELETE CASCADE,
  CONSTRAINT `itens_tabela_preco_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itens_tabela_preco`
--

LOCK TABLES `itens_tabela_preco` WRITE;
/*!40000 ALTER TABLE `itens_tabela_preco` DISABLE KEYS */;
INSERT INTO `itens_tabela_preco` VALUES (33,31,8,7.50,1,50.000,15.00),(34,30,7,12.99,1,50.000,25.98),(36,31,9,17.50,1,50.000,35.00),(37,31,10,30.00,1,50.000,60.00),(38,31,11,65.00,1,50.000,130.00),(39,31,12,12.50,1,50.000,25.00),(40,31,49,7.50,1,0.000,7.50),(41,31,48,12.50,1,50.000,25.00),(42,31,47,15.00,1,50.000,30.00),(43,31,46,10.00,1,50.000,20.00),(44,31,45,10.00,1,50.000,20.00),(45,31,44,20.00,1,50.000,40.00),(46,31,43,15.00,1,50.000,30.00),(47,31,42,15.00,1,50.000,30.00),(48,31,41,7.50,1,50.000,15.00),(49,31,40,7.50,1,50.000,15.00),(50,31,39,75.00,1,50.000,150.00),(51,31,38,145.00,1,50.000,290.00),(52,31,37,10.00,1,50.000,20.00),(53,31,36,12.50,1,50.000,25.00),(54,31,35,15.00,1,50.000,30.00),(55,31,34,10.00,1,50.000,20.00),(56,31,33,7.50,1,50.000,15.00),(57,31,31,10.00,1,50.000,20.00),(58,31,30,7.50,1,50.000,15.00),(59,31,29,7.50,1,50.000,15.00),(60,31,28,7.50,1,50.000,15.00),(61,31,27,37.50,1,50.000,75.00),(62,31,26,5.00,1,50.000,10.00),(63,31,25,5.00,1,50.000,10.00),(64,31,24,7.50,1,50.000,15.00),(65,31,23,7.50,1,50.000,15.00),(66,31,22,15.00,1,50.000,30.00),(67,31,21,7.50,1,50.000,15.00),(68,31,20,15.00,1,50.000,30.00),(69,31,19,10.00,1,50.000,20.00),(70,31,18,22.50,1,50.000,45.00),(71,31,17,20.00,1,50.000,40.00),(72,31,16,75.00,1,49.980,149.94),(73,31,14,47.50,1,49.990,94.98),(74,31,13,15.00,1,50.000,30.00),(75,30,2,40.00,1,50.000,80.00),(77,30,52,8.50,1,50.000,17.00),(78,30,50,4.20,1,50.000,8.40),(79,30,51,12.50,1,50.000,25.00),(80,30,53,4.20,1,50.000,8.40),(81,30,73,6.99,1,50.000,13.98),(82,30,72,10.99,1,50.000,21.98),(83,31,32,10.00,1,50.000,20.00),(84,31,74,7.50,1,50.000,15.00),(85,31,75,55.00,1,50.000,110.00),(86,30,77,35.52,1,50.000,71.04),(87,30,76,29.80,1,50.000,59.60),(88,30,78,52.30,1,50.000,104.60),(89,30,79,7.20,1,50.000,14.40),(90,30,80,22.30,1,50.000,44.60),(91,30,81,13.20,1,50.000,26.40),(92,30,82,12.50,1,50.000,25.00),(93,30,83,4.00,1,50.000,8.00),(94,30,84,9.99,1,50.000,19.98),(95,30,85,6.54,1,50.000,13.08),(96,30,87,2.50,1,50.000,5.00),(97,30,88,17.35,1,50.000,34.70),(98,30,89,12.50,1,50.000,25.00),(99,30,86,9.65,1,50.000,19.30),(100,30,91,22.90,1,50.000,45.80),(101,30,92,22.50,1,50.000,45.00),(102,30,93,22.50,1,50.000,45.00),(103,30,94,22.50,1,50.000,45.00),(104,30,95,22.90,1,50.000,45.80),(105,30,96,21.50,1,50.000,43.00),(106,30,98,20.90,1,50.000,41.80),(107,30,99,19.50,1,50.000,39.00),(108,30,100,16.30,1,50.000,32.60),(109,30,101,16.55,1,50.000,33.10),(110,30,102,4.00,1,50.000,8.00),(111,30,103,33.50,1,50.000,67.00),(112,30,104,16.90,1,50.000,33.80),(113,30,105,68.20,1,50.000,136.40),(114,30,106,12.90,1,50.000,25.80),(115,30,107,19.20,1,50.000,38.40),(116,30,108,23.10,1,50.000,46.20),(117,30,109,22.50,1,50.000,45.00),(118,30,110,5.00,1,50.000,10.00),(119,30,112,5.00,1,50.000,10.00),(120,30,113,35.50,1,50.000,71.00),(121,30,114,15.90,1,50.000,31.80),(122,30,115,8.20,1,50.000,16.40),(123,30,116,7.50,1,50.000,15.00),(124,30,117,26.90,1,50.000,53.80),(125,30,118,23.50,1,50.000,47.00),(126,30,119,10.50,1,50.000,21.00),(127,30,120,9.80,1,50.000,19.60),(128,30,122,2.50,1,50.000,5.00),(129,30,123,22.60,1,50.000,45.20),(130,30,124,35.00,1,50.000,70.00),(131,30,125,8.50,1,50.000,17.00),(132,30,126,4.00,1,50.000,8.00),(133,30,127,13.90,1,50.000,27.80),(134,30,128,14.90,1,50.000,29.80),(135,30,129,16.90,1,50.000,33.80),(136,30,130,23.50,1,50.000,47.00),(137,30,131,4.20,1,50.000,8.40),(138,30,132,2.50,1,50.000,5.00),(139,30,133,10.20,1,50.000,20.40),(140,30,135,11.50,1,50.000,23.00),(141,30,136,11.10,1,50.000,22.20),(142,30,137,15.99,1,50.000,31.98),(143,30,138,9.20,1,50.000,18.40),(144,30,139,10.99,1,50.000,21.98),(145,30,140,9.90,1,50.000,19.80),(146,30,141,12.50,1,50.000,25.00),(147,30,142,9.50,1,50.000,19.00),(148,30,143,8.00,1,50.000,16.00),(149,30,145,2.50,1,50.000,5.00),(150,30,146,23.50,1,50.000,47.00),(151,30,147,23.50,1,50.000,47.00),(152,30,148,23.50,1,50.000,47.00),(153,30,149,7.90,1,50.000,15.80),(154,30,150,12.50,1,50.000,25.00),(155,30,151,18.50,1,50.000,37.00),(156,30,152,22.30,1,50.000,44.60),(157,30,153,12.80,1,50.000,25.60),(158,30,154,44.20,1,50.000,88.40),(159,30,155,89.20,1,50.000,178.40),(160,30,156,10.00,1,50.000,20.00),(161,30,157,4.80,1,50.000,9.60),(162,30,158,4.80,1,50.000,9.60),(163,30,159,239.00,1,50.000,478.00),(164,30,160,41.50,1,50.000,83.00),(165,30,161,15.99,1,50.000,31.98),(166,30,162,15.30,1,50.000,30.60),(167,30,163,15.20,1,50.000,30.40),(168,30,164,15.40,1,50.000,30.80),(169,30,165,15.10,1,50.000,30.20),(170,30,166,1.50,1,50.000,3.00),(171,30,167,1.80,1,50.000,3.60),(172,30,168,2.10,1,50.000,4.20),(173,30,170,1.10,1,50.000,2.20),(174,30,171,1.80,1,50.000,3.60),(175,30,172,1.00,1,50.000,2.00),(176,30,173,1.10,1,50.000,2.20),(177,30,174,41.50,1,50.000,83.00),(178,30,175,2.25,1,50.000,4.50),(179,30,176,2.60,1,50.000,5.20),(180,30,177,7.50,1,50.000,15.00),(181,30,178,10.50,1,50.000,21.00),(182,30,179,11.50,1,50.000,23.00),(183,30,180,12.50,1,50.000,25.00),(184,30,181,14.90,1,50.000,29.80),(185,30,182,9.99,1,50.000,19.98),(186,30,185,2.60,1,50.000,5.20),(187,30,186,2.50,1,50.000,5.00),(188,30,187,14.30,1,50.000,28.60),(189,30,188,16.50,1,50.000,33.00),(190,30,190,14.90,1,50.000,29.80),(191,30,191,15.10,1,50.000,30.20),(192,30,192,24.90,1,50.000,49.80),(193,30,193,18.80,1,50.000,37.60),(194,30,194,18.90,1,50.000,37.80),(195,30,197,25.30,1,50.000,50.60),(196,30,198,24.50,1,50.000,49.00),(197,30,199,39.90,1,50.000,79.80),(198,30,200,42.90,1,50.000,85.80),(199,30,201,43.20,1,50.000,86.40),(200,30,202,23.10,1,50.000,46.20),(201,30,203,4.20,1,50.000,8.40),(202,30,205,78.90,1,50.000,157.80),(203,30,206,17.60,1,50.000,35.20),(204,30,211,1.00,1,50.000,2.00),(205,30,213,5.00,1,50.020,10.00),(206,30,215,11.20,1,50.000,22.40),(207,30,217,33.90,1,50.000,67.80),(208,30,218,35.90,1,50.000,71.80),(209,30,220,35.90,1,50.000,71.80),(210,30,223,26.10,1,50.000,52.20),(211,30,227,26.20,1,50.000,52.40),(212,30,224,10.20,1,50.000,20.40),(213,30,228,27.30,1,50.000,54.60),(215,30,226,34.90,1,50.000,69.80),(216,30,183,32.20,1,50.000,64.40),(217,30,70,34.20,1,50.000,68.40),(218,30,66,35.50,1,50.000,71.00),(219,30,68,35.20,1,50.000,70.40),(220,30,67,39.80,1,49.990,79.58),(221,30,65,47.00,1,50.000,94.00),(222,30,69,48.50,1,50.000,97.00),(223,30,229,38.99,1,50.000,77.98),(224,30,230,10.50,1,50.000,21.00),(225,30,231,10.99,1,50.000,21.98),(226,30,232,6.99,1,50.000,13.98),(227,30,233,29.90,1,50.000,59.80),(228,30,234,24.90,1,50.000,49.80),(229,30,235,24.90,1,50.000,49.80),(230,30,236,49.90,1,50.000,99.80),(231,30,237,9.99,1,50.000,19.98),(232,30,238,16.90,1,50.000,33.80),(233,30,239,33.98,1,50.000,67.96),(234,30,240,66.90,1,50.000,133.80),(235,30,241,49.90,1,50.000,99.80),(236,30,242,25.99,1,50.000,51.98),(237,30,243,16.99,1,50.000,33.98),(238,30,244,27.90,1,50.000,55.80),(239,30,245,24.90,1,50.000,49.80),(240,31,246,12.50,1,50.000,25.00),(241,31,247,10.00,1,50.000,20.00),(242,31,248,10.00,1,50.000,20.00),(243,30,249,17.50,1,50.000,35.00),(244,30,250,14.90,1,50.000,29.80),(245,30,251,4.99,1,50.000,9.98),(246,30,252,24.90,1,50.000,49.80),(247,30,253,25.10,1,50.000,50.20),(248,30,254,27.90,1,50.000,55.80),(249,30,255,17.50,1,50.000,35.00),(250,30,256,14.20,1,50.000,28.40),(251,30,257,14.20,1,50.000,28.40),(252,30,71,82.00,1,50.000,164.00),(253,30,121,32.50,1,50.000,65.00),(254,30,258,10.99,1,50.000,21.98),(255,30,259,29.99,1,50.000,59.98),(256,30,55,40.00,1,50.000,80.00),(257,30,56,40.00,1,50.000,80.00),(258,30,57,40.00,1,49.990,79.98),(259,30,260,34.90,1,49.990,69.79),(260,30,261,32.90,1,49.990,65.79),(261,30,262,15.99,1,50.000,31.98),(262,30,263,36.90,1,50.000,73.80);
/*!40000 ALTER TABLE `itens_tabela_preco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itens_venda`
--

DROP TABLE IF EXISTS `itens_venda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itens_venda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `venda_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` decimal(10,3) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `desconto_item` decimal(10,2) DEFAULT 0.00,
  `tabela_preco_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_venda` (`venda_id`),
  KEY `idx_produto` (`produto_id`),
  KEY `fk_itens_tabela_preco` (`tabela_preco_id`,`produto_id`),
  CONSTRAINT `fk_itens_tabela_preco` FOREIGN KEY (`tabela_preco_id`, `produto_id`) REFERENCES `itens_tabela_preco` (`id_tabela`, `id_produto`),
  CONSTRAINT `itens_venda_ibfk_1` FOREIGN KEY (`venda_id`) REFERENCES `vendas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `itens_venda_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itens_venda`
--

LOCK TABLES `itens_venda` WRITE;
/*!40000 ALTER TABLE `itens_venda` DISABLE KEYS */;
INSERT INTO `itens_venda` VALUES (1,1,7,2.000,25.98,51.96,0.00,30),(2,2,72,1.000,21.98,21.98,0.00,30),(3,2,28,2.000,15.00,30.00,0.00,31),(4,2,32,1.000,20.00,20.00,0.00,31),(5,3,230,1.000,21.00,21.00,0.00,30),(6,4,53,1.000,8.40,8.40,0.00,30),(7,5,241,1.000,89.80,89.80,0.00,30),(8,5,245,1.000,49.80,49.80,0.00,30),(9,5,243,1.000,33.98,33.98,0.00,30),(10,5,244,1.000,55.80,55.80,0.00,30),(11,5,242,1.000,51.98,51.98,0.00,30),(12,5,34,1.000,20.00,20.00,0.00,31),(13,5,30,1.000,15.00,15.00,0.00,31),(14,5,37,1.000,20.00,20.00,0.00,31),(15,5,45,1.000,20.00,20.00,0.00,31),(16,5,246,1.000,25.00,25.00,0.00,31),(17,5,28,1.000,15.00,15.00,0.00,31),(18,6,181,2.000,29.80,59.60,0.00,30),(19,6,29,2.000,15.00,30.00,0.00,31),(20,7,259,3.000,59.98,179.94,0.00,30),(21,7,258,2.000,21.98,43.96,0.00,30);
/*!40000 ALTER TABLE `itens_venda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orcamentos`
--

DROP TABLE IF EXISTS `orcamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orcamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` varchar(255) NOT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `valor_total` decimal(10,2) NOT NULL,
  `id_tabela_preco` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orcamentos`
--

LOCK TABLES `orcamentos` WRITE;
/*!40000 ALTER TABLE `orcamentos` DISABLE KEYS */;
INSERT INTO `orcamentos` VALUES (25,'Edson','(14) 99685-4401','keykkashi@gmail.com','2025-06-24 04:39:58',3328.58,25),(26,'Gabriel Bispo','(14) 99685-4401','keykkashi@gmail.com','2025-06-27 23:18:36',3375.00,25);
/*!40000 ALTER TABLE `orcamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pessoa`
--

DROP TABLE IF EXISTS `pessoa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pessoa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `nome_fantasia` varchar(150) DEFAULT NULL,
  `tipo` char(1) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `cpf_cnpj` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `cidade` varchar(150) DEFAULT NULL,
  `estado` char(2) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pessoa`
--

LOCK TABLES `pessoa` WRITE;
/*!40000 ALTER TABLE `pessoa` DISABLE KEYS */;
INSERT INTO `pessoa` VALUES (1,'Hedynho','Edson','J',NULL,'12.748.081/0001-91','hedynho1@gmail.com','(14) 99687-4787','(14) 99687-4787','Rua 123','Bauru','sp','17023024','2025-06-25 15:06:31');
/*!40000 ALTER TABLE `pessoa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pessoa_empresa`
--

DROP TABLE IF EXISTS `pessoa_empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pessoa_empresa` (
  `id_pessoa` int(11) NOT NULL,
  `slogan` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `caminho_logo` varchar(255) DEFAULT NULL,
  `caminho_favicon` varchar(255) DEFAULT NULL,
  `cor_primaria` varchar(255) DEFAULT NULL,
  `cor_secundaria` varchar(255) DEFAULT NULL,
  `inscricao_estadual` varchar(255) DEFAULT NULL,
  `regime_tributario` varchar(255) DEFAULT NULL,
  `nome_responsavel` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pessoa`),
  CONSTRAINT `fk_pessoa_empresa` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pessoa_empresa`
--

LOCK TABLES `pessoa_empresa` WRITE;
/*!40000 ALTER TABLE `pessoa_empresa` DISABLE KEYS */;
INSERT INTO `pessoa_empresa` VALUES (1,'Sua melhor pedalada começa aqui!','','https://www.facebook.com/','',NULL,'','','',NULL,'#111878','#6c757d','','mei','');
/*!40000 ALTER TABLE `pessoa_empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco_venda` decimal(10,2) NOT NULL,
  `unidade_medida` varchar(50) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `aro` varchar(50) DEFAULT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `categoria` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=264 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (1,'Bicicleta Mountain Bike Aro 29','Bicicleta para trilhas, quadro de alumínio',1500.00,'unidade','Caloi','Elite Carbon','29','Mountain Bike','Bicicletas'),(2,'CAPACETE CICLISMO GTS','Capacete leve e ventilado GTS',40.00,'unidade','Specialized','Echelon II','','','Peças'),(7,'CÂMARA DE AR PACO 29','29X1.95 VALVULA AMERICANA',12.99,'unidade','','','','','Peças'),(8,'TROCA DE CÃMERA','',7.50,'serviço','','','','','Serviços'),(9,'ALINHAMENTO','INDEPENDENTE DA RODA',17.50,'serviço','','','','','Serviços'),(10,'COMPLETAR OLEO','INDEPENDENTE',30.00,'serviço','','','','','Serviços'),(11,'MANUTENÇÃO GERAL S/LV','',65.00,'serviço','','','','','Serviços'),(12,'ANUTENÇÃO CUB DINT','',12.50,'serviço','','','','','Serviços'),(13,'MANUTENÇÃO CUB TRAS','',15.00,'serviço','','','','','Serviços'),(14,'MANUTENÇÃO K7','',47.50,'serviço','','','','','Serviços'),(15,'MANUTENÇÃO GERAL C/LAV','',75.00,'serviço','','','','','Serviços'),(16,'MONTAGEM GERAL ','',75.00,'serviço','','','','','Serviços'),(17,'MONTAGEM RODA DIANT','',20.00,'serviço','','','','','Serviços'),(18,'MONTAGEM RODA TRAS','',22.50,'serviço','','','','','Serviços'),(19,'MONTAGEM GUIDÃO','',10.00,'serviço','','','','','Serviços'),(20,'MONTAGEM GARFO','',15.00,'serviço','','','','','Serviços'),(21,'REGULAGEM FREIO DISCO COM','',7.50,'serviço','','','','','Serviços'),(22,'MONTAGEM FREIO RAPID FIRE','',15.00,'serviço','','','','','Serviços'),(23,'REGULAGEM FREIO DISCO HIDRAUL','',7.50,'serviço','','','','','Serviços'),(24,'REGULAGEM MARCHA TRAS','',7.50,'serviço','','','','','Serviços'),(25,'REGULAGEM MARCHA DIANT','',5.00,'serviço','','','','','Serviços'),(26,'REGULAGEM FREIO V BRAK','',5.00,'serviço','','','','','Serviços'),(27,'SANGRIA FREIO HIDRAUL','',37.50,'serviço','','','','','Serviços'),(28,'TROCA DE CABO 7,5','',7.50,'serviço','','','','','Serviços'),(29,'TROCA DE CÂMARA','',7.50,'serviço','','','','','Serviços'),(30,'TROCA DE CATRACA  ','',7.50,'serviço','','','','','Serviços'),(31,'TROCA DE K7','',10.00,'serviço','','','','','Serviços'),(32,'TROCA DE CAMBIO TRAS ','',10.00,'serviço','','','','','Serviços'),(33,'TROCA DE CAMBIO DIANT','',7.50,'serviço','','','','','Serviços'),(34,'TROCA DE CORRENTE','',10.00,'serviço','','','','','Serviços'),(35,'TROCA EIXO TRAS ','',15.00,'serviço','','','','','Serviços'),(36,'TROCA EIXO DIANT','',12.50,'serviço','','','','','Serviços'),(37,'TROCA DE ENGRENAGEM 34,7','',10.00,'serviço','','','','','Serviços'),(38,'TROCA DO GRUP 10 VELOC','',145.00,'serviço','','','','','Serviços'),(39,'TROCA DO GRUPO PARCIAL','',75.00,'serviço','','','','','Serviços'),(40,'TROCA DO PNEU','',7.50,'serviço','','','','','Serviços'),(41,'TROCA DE SAPATA PIN OU ORB','',7.50,'serviço','','','','','Serviços'),(42,'TROCA DE PÉ DE VALA MONOBLOCO','',15.00,'serviço','','','','','Serviços'),(43,'TROCA DE FEIO A DISCO','',15.00,'serviço','','','','','Serviços'),(44,'TROCA DO FREIO A DISCO HIDRAULIC','',20.00,'serviço','','','','','Serviços'),(45,'TROCA DO FREIO V BRAK ','',10.00,'serviço','','','','','Serviços'),(46,'TROCA DOS MANETES','',10.00,'serviço','','','','','Serviços'),(47,'TROCA DOS ROLAMENTOS TRAS','  ',15.00,'serviço','','','','','Serviços'),(48,'TROCA DOS ROLAMENTOS DIANT','',12.50,'serviço','','','','','Serviços'),(49,'TROCA DAS PASTILHAS','',7.50,'serviço','','','','','Serviços'),(50,'SAPT /FREIO PINO 7MM','Qualidade boa',4.20,'unidade','','','','','Peças'),(51,'SAPT /FREIO PINO 7MM BOA','',12.50,'unidade','','','','','Peças'),(52,'SAPAT PINO 6MM GROSSA','',8.50,'unidade','','','','','Peças'),(53,'SAPATA ORBITAL COMUM','',4.20,'unidade','','','','','Peças'),(54,'SAPATA ORBITAL COMUM','',4.20,'unidade','','','','','Peças'),(55,'ARO VMAX BRA 36F/26 FD','',40.00,'unidade','','','','','Peças'),(56,'ARO VMAX PTO 36F FD','VSAN',40.00,'unidade','','','','','Peças'),(57,'ARO VMAX PTO 36F/26 VBK','VSAMN',40.00,'unidade','','','','','Peças'),(58,'ARO EXTREME PTO 36F/26 FD','VSAN',38.00,'unidade','','','','','Peças'),(59,'ARO NAT/ 36F/20','',19.50,'unidade','','','','','Peças'),(60,'ARO NTAL FINO 36F/26','',25.10,'unidade','','','','','Peças'),(61,'ARO NATL MONARQ 36F/26X1/1.5','',26.20,'unidade','','','','','Peças'),(62,'ARO AERO MONARK 36F PTO  26X1X 1.5','',38.50,'unidade','','','','','Peças'),(63,'ARO NATL MONARQ 36F/26X1/1.5','',25.50,'unidade','','','','','Peças'),(64,'ARO METAL MONARK 36F 26X1X1,5','',38.20,'unidade','','','','','Peças'),(65,'PNEU PTO SLIK PHANTONM TREET 29 X 1,95','',47.00,'unidade','','','','','Peças'),(66,'PNEU PTO  SLIK 26X1,50','',35.50,'unidade','','','','','Peças'),(67,'PNEU PTO K10 27X1X14','',39.80,'unidade','','','','','Peças'),(68,'PNEU PTO 26.105 TOURING','',35.20,'unidade','','','','','Peças'),(69,'PNEU SLIK PTO 700X36C KONCEPT','',48.50,'unidade','','','','','Peças'),(70,'PNEU PTO     20X1.75','',34.20,'unidade','','','','','Peças'),(71,'ALAVANCA PTO CAMB FR/MARC TORNEY ST- TX800 3X7 21V SHIMANO','',82.00,'unidade','','','','','Peças'),(72,'CAMBIO TRAS. C/GANCH CROMO YAMADASORTEM','',10.99,'unidade','','','','','Peças'),(73,'MOVIMENTO DIREÇÃO ABSOLUTE INTEGRADO REFF54933','',6.99,'unidade','','','','','Peças'),(74,'LUBRIFICAÇÃO SIMPLES','',7.50,'serviço','','','','','Serviços'),(75,'LUBRIFICAÇÃO GERAL','',55.00,'serviço','','','','','Serviços'),(76,'CANOTE ALUM IMPOR PTO 25.4 350','',29.80,'unidade','','','','','Peças'),(77,'CANOTE ALUM CARRINHO  31.3  350','',35.52,'unidade','','','','','Peças'),(78,'BOMBA DE PÉ GRAMD ELLEVEM','',52.30,'unidade','','','','','Peças'),(79,'ABRAÇADEIRA QUADR 31MM PTO','',7.20,'unidade','','','','','Peças'),(80,'LIMPA DISCO FREIO ALGO','',22.30,'unidade','','','','','Acessórios'),(81,'EIXO CENTRAL 34,7 3U','',13.20,'unidade','','','','','Peças'),(82,'BUCHA DE QUARO SUSP  FULL','',12.50,'unidade','','','','','Peças'),(83,'ADAPTDR VOLVULA PRESTA COBRE','',4.00,'unidade','','','','','Peças'),(84,'PARA FUSO MESA MONARK','',9.99,'unidade','','','','','Peças'),(85,'REGULAGEM FREIO VBK','',6.54,'unidade','','','','','Peças'),(86,'EIXO SPANDER  C/F DIANT P/ROLA','',9.65,'unidade','','','','','Peças'),(87,'ROLA DINT  10 BILINHAS','',2.50,'unidade','','','','','Peças'),(88,'TINTA SPRAY VERNIZ CHEMI COLOR','',17.35,'unidade','','','','','Acessórios'),(89,'PASTILHA FREIO DISCO TBA ABSOLUTE','',12.50,'unidade','','','','','Peças'),(90,'CUBO TRZ ROL/ALM 36F/ AMAREMO','',23.58,'unidade','','','','','Peças'),(91,'CUBO DINT ROL/ALUM 36F AMARELO','',22.90,'unidade','','','','','Peças'),(92,'CUBO TRAZ ROL/ALUM 36F AZUL','',23.50,'unidade','','','','','Peças'),(93,'CUBO DINT ROL/ALUM 36F AZUL','',22.50,'unidade','','','','','Peças'),(94,'CUBO DINT ROL/ALUM 36F PTO','',22.50,'unidade','','','','','Peças'),(95,'CUBO DISCO TRZ ESF/ALUM 36F PTO','',22.90,'unidade','','','','','Peças'),(96,'CUBO DISCO  DINT ESF/ALUM 36F PTO','',21.50,'unidade','','','','','Peças'),(97,'CUBO TRZ ROL/ALUM 36F VREMELHO','',23.50,'unidade','','','','','Peças'),(98,'CUBO DINT ROL/ALLUM 36F VREMELHO','',20.90,'unidade','','','','','Peças'),(99,'CUBO TRAZ  ESF/AÇO 36F CLOMD','',23.50,'unidade','','','','','Peças'),(100,'KITE REMENDO C/ 2 ESPATULAS ELLEVEM','',16.30,'unidade','','','','','Peças'),(101,'CAPA GEL SELIM LARGO GEL','',16.55,'unidade','','','','','Acessórios'),(102,'PAR TAMPA VALVULA ALUM BALA CORES','',4.00,'unidade','','','','','Acessórios'),(103,'CANIVETE CHAVES 11FUNÇÕES','',33.50,'unidade','','','','','Acessórios'),(104,'ALVANC MARCH SHIFT 6X3','',16.90,'unidade','','','','','Peças'),(105,'ALAVANC MARCHA EZ-FITE  21V','',68.20,'unidade','','','','','Peças'),(106,'ALAVAC MARCH YAMADA 6/V','',12.90,'unidade','','','','','Peças'),(107,'MOVIMENTO ESFER  CEBTRAL 50 MM','',19.20,'unidade','','','','','Peças'),(108,'MANET ALUM VERMELHO VB','',23.10,'unidade','','','','','Peças'),(109,'MANET ALUM AMARELO','',22.50,'unidade','','','','','Peças'),(110,'MANOPLA PONT PRAT AMARELA','',5.00,'unidade','','','','','Peças'),(111,'MANOPLA CORES AMR','',4.00,'unidade','','','','','Peças'),(112,'MANOPLA MTB CORES','',5.00,'unidade','','','','','Peças'),(113,'FAROL ALUNMIN USB USB  RECARR ALUM 180 LMS','',35.50,'unidade','','','','','Peças'),(114,'MOVIMEN CEBTRAL ROL.  34,7','',15.90,'unidade','','','','','Peças'),(115,'BLOCAGEM  P/ EIXO TRAZ  FURADO','',8.20,'unidade','','','','','Peças'),(116,'BLOCAGEM P/ EIXO DINT FURADO','',7.50,'unidade','','','','','Peças'),(117,'PEDAL ALUM PLATAFORMA 1/2 PLG  PTO FIN','',25.90,'unidade','','','','','Peças'),(118,'PEDAL ALUM PLATAFORMA 1/2 PLG FINO PRTA','',23.50,'unidade','','','','','Peças'),(119,'PEDAL NILON  PLATAFORMA 1/2 PTO FINO','',9.90,'unidade','','','','','Peças'),(120,'PEDAL INFNT 1/2 PLG PTO','',9.80,'unidade','','','','','Peças'),(121,'BAR END CURTO ENBORR, 126MM PTO','',32.50,'unidade','','','','','Peças'),(122,'CABO FREIO 150M','',2.50,'unidade','','','','','Peças'),(123,'MESA ALUM OVER PTO/CINZ','',22.60,'unidade','','','','','Peças'),(124,'MESA 0 GRAU  PTO GTS','',35.00,'unidade','','','','','Peças'),(125,'CARRINHO CASTANHA AÇO PTO','',8.50,'unidade','','','','','Peças'),(126,'MANOPLA INFANTIL CORES','',4.00,'unidade','','','','','Acessórios'),(127,'MOVIMENTO DIREÇ HEAD SET OVER ROSC','',13.90,'unidade','','','','','Peças'),(128,'MOVIMENTO DIREÇ STANDART PTO','',14.90,'unidade','','','','','Peças'),(129,'MOVIMENTO  CEBTRAL ROLAM 45MM','',16.90,'unidade','','','','','Peças'),(130,'MOVIMENTO CENTRAL B.B SET 50MM','',23.50,'unidade','','','','','Peças'),(131,'SAPATA ORBTTAL 7MM WG','',4.20,'unidade','','','','','Peças'),(132,'BACIA FUND C/BAT CROM 29MM','',2.50,'unidade','','','','','Peças'),(133,'EIXO TRZ C/B  180MM CROM WG','',9.90,'unidade','','','','','Peças'),(134,'EIXO TRZ C/B  180MM CROM','',11.20,'unidade','','','','','Peças'),(135,'EIXO TRAZ SPANDER C/F B PTO 144MM','',11.50,'unidade','','','','','Peças'),(136,'EIXO DINT SPNDER CONE CON FINO C/B 110MM','',11.10,'unidade','','','','','Peças'),(137,'EIXO TRAZ ROLMEN C/ROL 180MM','',15.99,'unidade','','','','','Peças'),(138,'EIXO DINT C/B CROM CON/FINO C/TRV','',9.20,'unidade','','','','','Peças'),(139,'EIXO TRAZ S/B 200MM PTO','',10.99,'unidade','','','','','Peças'),(140,'EIXO DINT CON/FINO PTO','',9.90,'unidade','','','','','Peças'),(141,'EIXO TRZ P/ROLA PRAT 178','',12.50,'unidade','','','','','Peças'),(142,'EIXO DIANT C/B P/ROLA 144MM','',9.50,'unidade','','','','','Peças'),(143,'EIXO DINT FINO C/FINO','',8.00,'unidade','','','','','Peças'),(144,'ROLAMENTO  9 BOLINHAS EIXO GROSSO','',2.50,'unidade','','','','','Peças'),(145,'ROLAMENT  9 BOLINHAS EIXO GROSSO','',2.50,'unidade','','','','','Peças'),(146,'BAGAGEIRO DE AÇO FINO CROM','',23.50,'unidade','','','','','Acessórios'),(147,'CESTO ARAMADO REFORÇADO GRANDE','',23.50,'unidade','','','','','Acessórios'),(148,'BAGAGEIRO DE AÇO FINO PTO','',23.50,'unidade','','','','','Acessórios'),(149,'ARANHA ESPIGA DO GARFO OVER','',7.90,'unidade','','','','','Peças'),(150,'TAMPA MOVIMEN DIREÇ OVER C/ ARANH','',12.50,'unidade','','','','','Peças'),(151,'PASTILHA FREI/ DISCO  WG CINZA','',18.50,'unidade','','','','','Peças'),(152,'PASTILHA REDON/ MOEDA ZOOM','',22.30,'unidade','','','','','Peças'),(153,'COROA MONOBLOCO PTO 28/38/48','',25.98,'unidade','','','','','Peças'),(154,'PAR FREIO U-BRAKE BMX PTO','',44.20,'unidade','','','','','Peças'),(155,'CATRACA ROD/LIVRE 7V SHIMANO 14-34','',89.20,'unidade','','','','','Peças'),(156,'ROLAMENTO 9001','',10.00,'unidade','','','','','Peças'),(157,'ROLAMENTO 6000','',4.80,'unidade','','','','','Peças'),(158,'ROLAMENTO 6200','',4.80,'unidade','','','','','Peças'),(159,'CUBO BRAND: ARC','',239.00,'unidade','','','','','Peças'),(160,'CAPACETE C/ SINALIZ CINZA/AZUL  TMG','',41.50,'unidade','','','','','Acessórios'),(161,'PASILHA DE FREIO REDONDA PINO FINO','',15.99,'unidade','','','','','Peças'),(162,'PASTILHA REDONDA FINO GROSSO','',15.30,'unidade','','','','','Peças'),(163,'PASTILHA TABBUA COM BERAL','',15.20,'unidade','','','','','Peças'),(164,'PASTILHA REDONDA PTO PINO GROSSO','',15.40,'unidade','','','','','Peças'),(165,'PASTILHA MOEDA PTO','',15.10,'unidade','','','','','Peças'),(166,'BACIA RASA PAR/FINA PTO 30MM','',1.50,'unidade','','','','','Peças'),(167,'BACIA RASA S/BT CINSA PARED/GROSSA 30MM','',1.80,'unidade','','','','','Peças'),(168,'BACIA  RASA  S/BAT PARED/GROSSA CROMO 30MM','',2.10,'unidade','','','','','Peças'),(169,'BACIA FUNDA S/T PTO 29MM','',1.10,'unidade','','','','','Peças'),(170,'BACIA MEDIA  C/BAT FINO CROMO 29MM','',1.10,'unidade','','','','','Peças'),(171,'BACIA FUNDA C/BAT GOSSA TP BITX 30.3MM','',1.80,'unidade','','','','','Peças'),(172,'BACIA FUNDA C/BATEN PTO 24.3MM DINT','',1.00,'unidade','','','','','Peças'),(173,'BACIA RASA PTO S/BATENT 24,2MM DIAN','',1.10,'unidade','','','','','Peças'),(174,'CAPACETE  MTB C/SINALIZ CINZ/AZUL T G','',41.50,'unidade','','','','','Peças'),(175,'CANDUITE PTO WG','',2.25,'metro','','','','','Peças'),(176,'CANDUITE MARCHA PTO  1/5 MT','',2.60,'metro','','','','','Peças'),(177,'MANETE NYLON INFNT PONT/ALUM PTO','',7.50,'unidade','','','','','Peças'),(178,'CAMARA PACO 16X1/1.9','',10.50,'unidade','','','','','Peças'),(179,'CAMARA PACO  24X1.75/190','',10.50,'unidade','','','','','Peças'),(180,'CAMARA PACO 29X1.95/2.125','',13.50,'unidade','','','','','Peças'),(181,'CAMARA KENDA 29X1.9/2.30 VAVUL/COM','',16.99,'unidade','','','','','Peças'),(182,'CAMARA PACO 26X1/190','',8.99,'unidade','','','','','Peças'),(183,'SELIM VAZ PTO MD211A LOGAM','',32.20,'unidade','','','','','Peças'),(184,'CABO FREIO 150M','',2.50,'unidade','','','','','Peças'),(185,'CABO FREIO 170M','',2.60,'unidade','','','','','Peças'),(186,'CABO MARCHA','',2.50,'unidade','','','','','Peças'),(187,'CAMBIO DIANT LONGO PUCHA/BAIXO STANDER PTO YAMADA','',14.30,'unidade','','','','','Peças'),(188,'CAMBIO DIANT CURTO PUCHA/CIMA OVER  PTO YAMADA','',16.50,'unidade','','','','','Peças'),(189,'CAMBIO DIANT LONGO STANDER  PUXA /CIMA CROMO YAMADA','',14.90,'unidade','','','','','Peças'),(190,'CAMBIO DIANT LONGO PUXA/ BAIXO OVER CROMO YAMADA','',14.90,'unidade','','','','','Peças'),(191,'CANBIO DIANT CURTO PUXA/ CIMA STANDER PTO','',15.10,'unidade','','','','','Peças'),(192,'CAMVIO DIANT PUXA/CIMA OVER PTO SHIMANO','',24.90,'unidade','','','','','Peças'),(193,'CAMBIO DINAT LONGO UNIVERSAL CROMO','',18.80,'unidade','','','','','Peças'),(194,'CAMBIO DIANT CURTO UNIVERSAL CROMO WG','',18.90,'unidade','','','','','Peças'),(195,'CAMBIO DIANT CURTO STANDER PUXA/CIMA DEORE XT','',44.60,'unidade','','','','','Peças'),(196,'CAMBIO DINAT TORMEY TRIPLO','',39.90,'unidade','','','','','Peças'),(197,'PÉ VELA MONOBLOCO 165MM CROMO DUQUE','',25.30,'unidade','','','','','Peças'),(198,'ARO NATURAL 24 36F PTO','',24.50,'unidade','','','','','Peças'),(199,'CAMBIO TRAZ TZ31 C/CPNCHEIRA PTO','',39.90,'unidade','','','','','Peças'),(200,'CAMBIO DIANT ALTUS SHIMMANO AÇO','',42.90,'unidade','','','','','Peças'),(201,'CAMBIO DIANT UNIVERSAL WG','',43.20,'unidade','','','','','Peças'),(202,'CAMBIO TRAZ INDX PTO 7V','',23.10,'unidade','','','','','Peças'),(203,'ADAPT VALVU/PREST P/ VALV.AMERICANA  WG','',4.20,'unidade','','','','','Peças'),(204,'CAMARA PACO 20X1.75/2125','',8.99,'unidade','','','','','Peças'),(205,'CADEIRINHA INFANTIL TRAZ SINZA','',78.90,'unidade','','','','','Peças'),(206,'DESCANSO CENTRAL REGUL','',17.60,'unidade','','','','','Peças'),(207,'DESCANSO LATERAL AMR','',10.20,'unidade','','','','','Acessórios'),(208,'PARAFUSO  DE ROTOR PTO WG','',0.60,'unidade','','','','','Peças'),(209,'TERMINAL DE CANDUITE CROMO','',0.18,'unidade','','','','','Peças'),(210,'TERMINAL DE CANDUITE ALUMIN','',1.10,'unidade','','','','','Peças'),(211,'NO DE FRIO CAB/LISA  BV OU CONTIL GROSSO','',1.00,'unidade','','','','','Peças'),(212,'NO DE FRIO CAB/LISA  BV OU CONTIL FINO','',1.00,'unidade','','','','','Peças'),(213,'NO DE FRIO CAB/LISA  BV OU CONTIL SESTAVADO','',5.00,'unidade','','','','','Peças'),(214,'SAPATA MONARK','',9.20,'unidade','','','','','Peças'),(215,'CAMBIO TRAZ C/GANCH YAMADA CROM','',11.20,'unidade','','','','','Peças'),(216,'CAMBIO TRAZ S/GANCH IDX 24V PTO SUNRUN CASE LONG 43D','',21.10,'unidade','','','','','Peças'),(217,'FREIO DISCO MEC PAR C/ROTOR ABSOLUT RET C/ORELH','',33.90,'unidade','','','','','Peças'),(218,'CATRACA7M ROSCA INDEX SUNRACE M2A','',35.90,'unidade','','','','','Peças'),(219,'CORRENTE FIN TEC 7V CINZA C7','',15.30,'unidade','','','','','Peças'),(220,'ENGREN MB FERRO 28/38/48 INDEX PT/PT S/PROT LOGAM','',35.90,'unidade','','','','','Peças'),(221,'ENGREN MB FERRO 28/38/48 INDEX PT/PT S/PROT LOGAM','',35.90,'unidade','','','','','Peças'),(222,'CANOTE SELIM AL 27.2 2X35MM C/CARR PTO GTSGEM','',25.10,'unidade','','','','','Peças'),(223,'CATRACA 7M RSC INDS XINDU MRR/PTO 14/28','',26.10,'unidade','','','','','Peças'),(224,'CORRENTE FINA EC PTO -C-30','',10.20,'unidade','','','','','Peças'),(225,'ENGRENAGEM FERRO 24/24/42 INDX PTO LONGHENG LH','',24.10,'unidade','','','','','Peças'),(226,'SELIM MTB VAZADO PTO LOGAM','',34.90,'unidade','','','','','Peças'),(227,'CANOTE ALUM SELIM 25.4 C/CARR. INPOT PTO','',26.20,'unidade','','','','','Peças'),(228,'CANOTE ALUM SELIM 31.5 350MM PTO ABSOLUT','',27.30,'unidade','','','','','Peças'),(229,'SELIM  CONFORT ZTB PTO GELTHC','',38.99,'unidade','','','','','Peças'),(230,'PEDAL NYLON PLATAFORMA 9/16  ','',10.50,'unidade','','','','','Peças'),(231,'CAMBIO TRAS. C/GANCHE. PTO. YAMADA SORTEM','',10.99,'unidade','','','','','Peças'),(232,'MOVIMENTO DIREÇÃO MEGA S.INTEGRAD AHEAD NERO','',6.99,'unidade','','','','','Peças'),(233,'CATRACA 8M RSC.INDX. MRR MEGA TRI-DIAMOND','',29.90,'unidade','','','','','Peças'),(234,'COORENTE FINA 6/7VCNM54 SUNRANCE','',24.90,'unidade','','','','','Peças'),(235,'GANCHEIRA ALFAMMEG STROL NO9 VELLOH','',24.90,'unidade','','','','','Peças'),(236,'ARO AERO 26 ALUM. 32F PTO EXTREME PRO VZAN FD','',49.90,'unidade','','','','','Peças'),(237,'CAMARA BISPO 24 COMUM ','',9.99,'unidade','','','','','Peças'),(238,'MOVIMENTO CENTRAL45MM C/ROLAMENTO  NÉCO ZNC JA','',16.90,'unidade','','','','','Peças'),(239,'MESA CROSS AL PTO TRAD GTU MOD ANTIGO SOR','',33.98,'unidade','','','','','Peças'),(240,'ARO AERO MONTD 26 ALUM 36F PTO,B VZAN SOR ','',66.90,'unidade','','','','','Peças'),(241,'ALAVANCA RAPT FIRE C/21M YAMADA PTO NOVO ISA','',49.90,'unidade','','','','','Peças'),(242,'CATRACA 7/V RSC INDX  XINDU MARR/PTO 14/28 - CAIXA VERDE','',25.99,'unidade','','','','','Peças'),(243,'CORRENTE FINA INEX 7/V CINSA C7 TEC','',16.99,'unidade','','','','','Peças'),(244,'ENGRENAGEM MB FERRO  24/34/42 INDX PTO GTA C/PROT SIG/SORT','',27.90,'unidade','','','','','Peças'),(245,'FREIO V-BRAK AL PTO (ALLEM) LOGAM 919 MM/SOR','',24.90,'unidade','','','','','Peças'),(246,'TROCA DE ALAVANCA RAPD FIRE','',25.00,'serviço','','','','','Serviços'),(247,'TROCA ALANCA COMUM ALM 6V','',10.00,'serviço','','','','','Serviços'),(248,'TROCA ALAVANCA GRIFT ','',10.00,'serviço','','','','','Serviços'),(249,'MANETE CROSS ROSA','',17.50,'unidade','','','','','Peças'),(250,'ALAVANCA MARCHA GRIFT SHIT','',14.90,'unidade','','','','','Peças'),(251,'MANOPLA  SEM/GEL AMR','',4.99,'unidade','','','','','Peças'),(252,'CAMBIO DINT, TORNEY SHIMMANO ','',224.90,'unidade','','','','','Peças'),(253,'CAMBIO DIANT DEORE SHIMANO FINO','',25.10,'unidade','','','','','Peças'),(254,'CAMBIO DIANT. TORNEY ST SHIMANO  PUCH/CIMA','',27.90,'unidade','','','','','Peças'),(255,'CAMBIO LONGO UNIVERSAL SUNRUM','',17.50,'unidade','','','','','Peças'),(256,'CAMBIO DIANT SHIMANO PUCH/CIM PTO','',14.20,'unidade','','','','','Peças'),(257,'CAMBIO DIANT CURTO PACO PTO PUCH/BAIX','',14.20,'unidade','','','','','Peças'),(258,'CAMARA 20 1,75 KENDA CHINA','',10.99,'unidade','','','','','Peças'),(259,'PNEU 20 CROSS PTO LEV. EXESS EX 20X1.75','',29.99,'unidade','','','','','Peças'),(260,'CAMBIO TRAS. S/GANCHEIRA INDX 27V  PTOSUNRUN CADE LONG40D','',34.90,'unidade','','','','','Peças'),(261,'GANCHEIRA SCHWIN/NF 143/GE016. OGG/TOTEM GROVEHIPE','',32.90,'unidade','','','','','Peças'),(262,'MANETE AL VBRK PTO FG120 SOR','',15.99,'unidade','','','','','Peças'),(263,'PNEU EXCESS 26X1.95 PTO CRVO','',36.90,'unidade','','','','','Peças');
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicos`
--

DROP TABLE IF EXISTS `servicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_servico` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicos`
--

LOCK TABLES `servicos` WRITE;
/*!40000 ALTER TABLE `servicos` DISABLE KEYS */;
/*!40000 ALTER TABLE `servicos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tabelas_preco`
--

DROP TABLE IF EXISTS `tabelas_preco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tabelas_preco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `empresa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tabelas_preco_empresa` (`empresa_id`),
  CONSTRAINT `fk_tabelas_preco_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `pessoa_empresa` (`id_pessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tabelas_preco`
--

LOCK TABLES `tabelas_preco` WRITE;
/*!40000 ALTER TABLE `tabelas_preco` DISABLE KEYS */;
INSERT INTO `tabelas_preco` VALUES (30,'Preço Produtos','2025-06-27 23:30:08',1),(31,'SERVIÇOS','2025-06-28 14:22:48',1);
/*!40000 ALTER TABLE `tabelas_preco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `ultimo_acesso` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_usuario` (`nome_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'admin','$argon2id$v=19$m=65536,t=4,p=1$ZXlqcEs3NldFU0JoTmNoVQ$Q70bqBOeeVNgPXV3JFHe2tx/iHOiXPSnJ48gDtYqP0Q','admin','HEDYNHO','hedynho1@gmail.com',NULL,1,1,NULL,0,NULL,1,'2025-06-23 04:08:39',NULL),(2,'vendedor1','56976bf24998ca63e35fe4f1e2469b5751d1856003e8d16fef0aafef496ed044','vendedor','Teste','',NULL,1,1,NULL,0,NULL,0,'2025-06-23 04:08:39',NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendas`
--

DROP TABLE IF EXISTS `vendas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_nome` varchar(255) DEFAULT NULL,
  `cliente_telefone` varchar(20) DEFAULT NULL,
  `cliente_email` varchar(255) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `desconto` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `forma_pagamento` enum('dinheiro','cartao_debito','cartao_credito','pix') NOT NULL,
  `valor_pago` decimal(10,2) DEFAULT NULL,
  `troco` decimal(10,2) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` enum('finalizada','cancelada','pendente') DEFAULT 'finalizada',
  `motivo_cancelamento` text DEFAULT NULL,
  `data_cancelamento` timestamp NULL DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `data_venda` timestamp NOT NULL DEFAULT current_timestamp(),
  `empresa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_data_venda` (`data_venda`),
  KEY `idx_forma_pagamento` (`forma_pagamento`),
  KEY `idx_status` (`status`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `fk_venda_empresa` (`empresa_id`),
  CONSTRAINT `fk_venda_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `pessoa_empresa` (`id_pessoa`),
  CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendas`
--

LOCK TABLES `vendas` WRITE;
/*!40000 ALTER TABLE `vendas` DISABLE KEYS */;
INSERT INTO `vendas` VALUES (1,'','','',51.96,0.00,51.96,'dinheiro',51.96,0.00,'','finalizada',NULL,NULL,1,'2025-07-09 17:49:35',1),(2,'','','',71.98,0.00,71.98,'cartao_debito',NULL,0.00,'','finalizada',NULL,NULL,1,'2025-07-15 14:18:13',1),(3,'','','',21.00,0.00,21.00,'pix',NULL,0.00,'','finalizada',NULL,NULL,1,'2025-07-19 14:14:32',1),(4,'','','',8.40,0.00,8.40,'pix',NULL,0.00,'','finalizada',NULL,NULL,1,'2025-07-19 14:15:04',1),(5,'','','',396.36,0.00,396.36,'pix',NULL,0.00,'','finalizada',NULL,NULL,1,'2025-07-23 15:44:30',1),(6,'','','',89.60,0.00,89.60,'pix',NULL,0.00,'','finalizada',NULL,NULL,1,'2025-07-23 15:54:07',1),(7,'','','',223.90,0.00,223.90,'pix',NULL,0.00,'','finalizada',NULL,NULL,1,'2025-07-29 15:40:20',1);
/*!40000 ALTER TABLE `vendas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-28 18:32:24
