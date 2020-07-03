-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03-Jul-2020 às 20:48
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dbaulads`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `idcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `datacriacao` datetime NOT NULL,
  `datamodificacao` datetime NOT NULL,
  PRIMARY KEY (`idcategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`idcategoria`, `nome`, `ativo`, `datacriacao`, `datamodificacao`) VALUES
(1, 'LIMPEZA', 'S', '2020-06-12 00:00:00', '2020-06-12 00:00:00'),
(2, 'HIGIENE', 'N', '2020-06-12 00:00:00', '2020-06-12 00:00:00'),
(3, 'PADARIA', 'S', '1970-01-01 01:00:00', '1970-01-01 01:00:00'),
(4, 'COMPUTADORES', 'S', '1970-01-01 01:00:00', '1970-01-01 01:00:00'),
(5, 'LAPTOP', 'S', '1970-01-01 01:00:00', '2020-07-02 11:34:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `ativo` char(1) NOT NULL,
  `datacriacao` datetime NOT NULL,
  `datamodificacao` datetime NOT NULL,
  PRIMARY KEY (`idcliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `formas_pagamento`
--

CREATE TABLE IF NOT EXISTS `formas_pagamento` (
  `idformas_pagamento` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `tera_troco` char(1) NOT NULL,
  `tera_parcelamento` char(1) NOT NULL,
  `ativo` char(1) NOT NULL,
  `datacriacao` datetime NOT NULL,
  `datamodificacao` datetime NOT NULL,
  PRIMARY KEY (`idformas_pagamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_venda`
--

CREATE TABLE IF NOT EXISTS `itens_venda` (
  `iditens_venda` int(11) NOT NULL AUTO_INCREMENT,
  `idvenda` int(11) NOT NULL,
  `idproduto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor_unitario` decimal(7,2) NOT NULL,
  `subtotal` decimal(7,2) NOT NULL,
  PRIMARY KEY (`iditens_venda`),
  KEY `fk_vendas_has_produtos_produtos1_idx` (`idproduto`),
  KEY `fk_vendas_has_produtos_vendas1_idx` (`idvenda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `idproduto` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `descricao` text NOT NULL,
  `estoque` int(11) NOT NULL,
  `estoque_min` int(11) NOT NULL,
  `valor` decimal(7,2) NOT NULL,
  `ativo` char(1) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `datacriacao` datetime NOT NULL,
  `datamodificacao` datetime NOT NULL,
  PRIMARY KEY (`idproduto`),
  KEY `fk_produtos_categorias_idx` (`idcategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE IF NOT EXISTS `vendas` (
  `idvenda` int(11) NOT NULL AUTO_INCREMENT,
  `data_venda` datetime NOT NULL,
  `total_venda` decimal(7,2) NOT NULL,
  `situacao` char(1) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idformas_pagamento` int(11) DEFAULT NULL,
  PRIMARY KEY (`idvenda`),
  KEY `fk_vendas_clientes1_idx` (`idcliente`),
  KEY `fk_vendas_formas_pagamento1_idx` (`idformas_pagamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD CONSTRAINT `fk_vendas_has_produtos_produtos1` FOREIGN KEY (`idproduto`) REFERENCES `produtos` (`idproduto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_vendas_has_produtos_vendas1` FOREIGN KEY (`idvenda`) REFERENCES `vendas` (`idvenda`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produtos_categorias` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `fk_vendas_clientes1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_vendas_formas_pagamento1` FOREIGN KEY (`idformas_pagamento`) REFERENCES `formas_pagamento` (`idformas_pagamento`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
