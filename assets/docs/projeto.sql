-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.6.24 - MySQL Community Server (GPL)
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura do banco de dados para prospects
DROP DATABASE IF EXISTS `prospects`;
CREATE DATABASE IF NOT EXISTS `prospects` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `prospects`;


-- Copiando estrutura para tabela prospects.historico_acoes
DROP TABLE IF EXISTS `historico_acoes`;
CREATE TABLE IF NOT EXISTS `historico_acoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acao` text NOT NULL,
  `data_acao` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela prospects.historico_acoes: ~45 rows (aproximadamente)
DELETE FROM `historico_acoes`;
/*!40000 ALTER TABLE `historico_acoes` DISABLE KEYS */;
INSERT INTO `historico_acoes` (`id`, `acao`, `data_acao`) VALUES
	(1, 'Usuário inserido com sucesso', '2015-04-22 14:14:44'),
	(2, 'Usuário inserido com sucesso', '2015-04-22 14:16:07'),
	(3, 'Usuario exclusaoOK', '2015-04-22 14:16:54'),
	(4, 'Usuário inserido com sucesso', '2015-04-22 14:19:24'),
	(5, 'Usuário inserido com sucesso', '2016-04-14 17:06:40'),
	(6, 'Atualizacao', '2016-04-22 19:55:39'),
	(7, 'Atualizacao', '2016-04-22 19:56:23'),
	(8, 'Atualizacao de usuário', '2016-04-22 19:57:38'),
	(9, 'Cadastro de usuário', '2016-04-22 19:58:06'),
	(10, 'Exclusao de usuário', '2016-04-22 19:59:19'),
	(11, 'Cadastro de usuário', '2016-04-22 21:28:01'),
	(12, 'Exclusao de usuário', '2016-04-22 21:32:12'),
	(13, 'Cadastro de usuário', '2016-04-22 21:35:24'),
	(14, 'Cadastro de setor', '2016-04-22 22:02:17'),
	(15, 'Atualizacao de setor', '2016-04-22 22:05:31'),
	(16, 'Exclusao de setor', '2016-04-22 22:05:45'),
	(17, 'Cadastro de setor', '2016-04-22 22:06:16'),
	(18, 'Atualizacao de Status do Prospect ID 1', '2016-04-23 03:32:17'),
	(19, 'Atualizacao de Status do Prospect ID 1', '2016-04-22 22:38:12'),
	(20, 'Atualizacao de Status do Prospect ID 1', '2016-04-22 22:38:22'),
	(21, 'Atualizacao de Status do Prospect ID 1', '2016-04-22 22:39:48'),
	(22, 'Atualizacao de Status do Prospect ID 1', '2016-04-22 22:39:51'),
	(23, 'Atualizacao de Status do Prospect ID 1', '2016-04-22 22:39:53'),
	(24, 'Atualizacao de Status do Prospect ID 1', '2016-04-22 22:40:01'),
	(25, 'O usuário Bruno Marques Nogueira - bmarquesn@gmail.com logou no sistema', '2016-04-23 05:24:15'),
	(26, 'Cadastro de prospect', '2016-04-23 05:46:15'),
	(27, 'Atualizacao de Status do Prospect ID 1', '2016-04-23 05:55:36'),
	(28, 'Atualizacao de Status do Prospect ID 1', '2016-04-23 05:55:41'),
	(29, 'Atualizacao de Status do Prospect ID 1', '2016-04-23 05:55:50'),
	(30, 'Exclusao de prospect', '2016-04-23 05:56:59'),
	(31, 'Cadastro de setor', '2016-04-23 05:57:43'),
	(32, 'Exclusao de setor', '2016-04-23 05:57:53'),
	(33, 'Cadastro de setor', '2016-04-23 05:58:03'),
	(34, 'Atualizacao de setor', '2016-04-23 05:58:14'),
	(35, 'Cadastro de prospect', '2016-04-23 05:59:09'),
	(36, 'Exclusao de prospect', '2016-04-23 05:59:30'),
	(37, 'Atualizacao de prospect', '2016-04-23 06:05:02'),
	(38, 'Atualizacao de Status do Prospect ID 3', '2016-04-23 06:52:30'),
	(39, 'Atualizacao de Status do Prospect ID 3', '2016-04-23 06:52:32'),
	(40, 'Atualizacao de Status do Prospect ID 3', '2016-04-23 10:07:31'),
	(41, 'Atualizacao de Status do Prospect ID 3', '2016-04-23 10:07:35'),
	(42, 'O usuário Bruno Marques Nogueira - bmarquesn@gmail.com logou no sistema', '2016-04-23 10:16:04'),
	(43, 'O usuário Bruno Marques Nogueira - bmarquesn@gmail.com logou no sistema', '2016-04-23 10:17:40'),
	(44, 'Cadastro de usuário', '2016-04-23 10:18:07'),
	(45, 'O usuário Novo usuario Teste - teste@teste.com.br logou no sistema', '2016-04-23 10:18:24'),
	(46, 'O usuário Novo usuario Teste - teste@teste.com.br logou no sistema', '2016-04-23 10:22:51');
/*!40000 ALTER TABLE `historico_acoes` ENABLE KEYS */;


-- Copiando estrutura para procedure prospects.ListarCopiasProspectsInseridos
DROP PROCEDURE IF EXISTS `ListarCopiasProspectsInseridos`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `ListarCopiasProspectsInseridos`()
    COMMENT 'Listagem da cópia de prospects inseridos'
BEGIN
SELECT
ProspectCopy.*,
Setor.nome AS nomeSetor
FROM
prospect_copy AS ProspectCopy
LEFT JOIN setor AS Setor ON Setor.id = ProspectCopy.setor_id
ORDER BY ProspectCopy.data_insercao DESC;
END//
DELIMITER ;


-- Copiando estrutura para tabela prospects.prospects
DROP TABLE IF EXISTS `prospects`;
CREATE TABLE IF NOT EXISTS `prospects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `contatos` text NOT NULL,
  `setor_id` int(11) NOT NULL,
  `acao_id` int(11) NOT NULL,
  `data_insercao` datetime NOT NULL,
  `data_proxima_acao` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `setor_id` (`setor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela prospects.prospects: ~1 rows (aproximadamente)
DELETE FROM `prospects`;
/*!40000 ALTER TABLE `prospects` DISABLE KEYS */;
INSERT INTO `prospects` (`id`, `nome`, `contatos`, `setor_id`, `acao_id`, `data_insercao`, `data_proxima_acao`) VALUES
	(3, 'Novo Prospect Pão Maçã Jiló eee', 'Pão\r\nMaçã\r\nJiló', 2, 5, '2016-04-23 05:59:09', '2016-04-22 13:00:00');
/*!40000 ALTER TABLE `prospects` ENABLE KEYS */;


-- Copiando estrutura para tabela prospects.prospect_copy
DROP TABLE IF EXISTS `prospect_copy`;
CREATE TABLE IF NOT EXISTS `prospect_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `contatos` text NOT NULL,
  `setor_id` int(11) NOT NULL,
  `acao_id` int(11) NOT NULL,
  `data_insercao` datetime NOT NULL,
  `data_proxima_acao` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela prospects.prospect_copy: ~3 rows (aproximadamente)
DELETE FROM `prospect_copy`;
/*!40000 ALTER TABLE `prospect_copy` DISABLE KEYS */;
INSERT INTO `prospect_copy` (`id`, `nome`, `contatos`, `setor_id`, `acao_id`, `data_insercao`, `data_proxima_acao`) VALUES
	(1, 'Nome Prospect 1', 'C', 2, 1, '0000-00-00 00:00:00', '2016-04-22 22:18:00'),
	(2, 'Prospect 2', 'Contato 1\r\nContato 2', 2, 2, '2016-04-23 05:46:15', '2016-04-23 00:00:00'),
	(3, 'Novo Prospect Pão Maçã Jiló', 'Pão\r\nMaçã\r\nJiló', 4, 2, '2016-04-23 05:59:09', '2016-04-22 13:00:00');
/*!40000 ALTER TABLE `prospect_copy` ENABLE KEYS */;


-- Copiando estrutura para tabela prospects.setor
DROP TABLE IF EXISTS `setor`;
CREATE TABLE IF NOT EXISTS `setor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela prospects.setor: ~2 rows (aproximadamente)
DELETE FROM `setor`;
/*!40000 ALTER TABLE `setor` DISABLE KEYS */;
INSERT INTO `setor` (`id`, `nome`) VALUES
	(2, 'Setor 1'),
	(4, 'Setor 2 Atualizado');
/*!40000 ALTER TABLE `setor` ENABLE KEYS */;


-- Copiando estrutura para tabela prospects.usuario
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` text NOT NULL,
  `email` text NOT NULL,
  `senha` text NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela prospects.usuario: ~5 rows (aproximadamente)
DELETE FROM `usuario`;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `ativo`) VALUES
	(4, 'Bruno Marques Nogueira', 'bmarquesn@gmail.com', '6b8e07663a2fbd4d0562a2fd4c9e216e', 1),
	(5, 'Novo usuario Atualizado', 'aaa@aaa.com.br', '6c492baa150f940c0178649a4bb5a580', 1),
	(7, 'Usuário 3', 'ccc@ccc.com.br', 'b59718b2f1ef41e5f98e39c4b52cb4ae', 1),
	(9, 'hjhghg', 'abc@aaa.com.br', 'aaf8c11bd39f6214b7976cab6b3009ab', 1),
	(10, 'Novo usuario Teste', 'teste@teste.com.br', 'b59718b2f1ef41e5f98e39c4b52cb4ae', 1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;


-- Copiando estrutura para trigger prospects.prospects_after_insert
DROP TRIGGER IF EXISTS `prospects_after_insert`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE TRIGGER `prospects_after_insert` AFTER INSERT ON `prospects` FOR EACH ROW BEGIN
	INSERT INTO
		prospect_copy
	SET
		prospect_copy.id = NEW.id,
		prospect_copy.nome = NEW.nome,
		prospect_copy.contatos = NEW.contatos,
		prospect_copy.setor_id = NEW.setor_id,
		prospect_copy.acao_id = NEW.acao_id,
		prospect_copy.data_insercao = NEW.data_insercao,
		prospect_copy.data_proxima_acao = NEW.data_proxima_acao;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
