-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for prospects
CREATE DATABASE IF NOT EXISTS `prospects` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `prospects`;

-- Dumping structure for table prospects.historico_acoes
CREATE TABLE IF NOT EXISTS `historico_acoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acao` text NOT NULL,
  `data_acao` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for procedure prospects.ListarCopiasProspectsInseridos
DELIMITER //
CREATE PROCEDURE `ListarCopiasProspectsInseridos`()
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

-- Dumping structure for table prospects.prospects
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table prospects.prospect_copy
CREATE TABLE IF NOT EXISTS `prospect_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `contatos` text NOT NULL,
  `setor_id` int(11) NOT NULL,
  `acao_id` int(11) NOT NULL,
  `data_insercao` datetime NOT NULL,
  `data_proxima_acao` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table prospects.setor
CREATE TABLE IF NOT EXISTS `setor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table prospects.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` text NOT NULL,
  `email` text NOT NULL,
  `senha` text NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for trigger prospects.prospects_after_insert
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
