-- phpMyAdmin SQL Dump
-- version 4.3.7
-- http://www.phpmyadmin.net
--
-- Host: mysql04-farm76.kinghost.net
-- Tempo de geração: 26/06/2019 às 19:51
-- Versão do servidor: 5.6.38-log
-- Versão do PHP: 5.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `syscoffe01`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `check_doc`
--

CREATE TABLE IF NOT EXISTS `check_doc` (
  `idCheck` int(11) NOT NULL,
  `numberBank` varchar(10) NOT NULL,
  `numberAgency` varchar(20) NOT NULL,
  `numberAccount` varchar(50) NOT NULL,
  `numberCheck` varchar(10) NOT NULL,
  `nameHolder` varchar(100) NOT NULL,
  `docCpfOrCnpj` varchar(20) NOT NULL,
  `date` varchar(10) NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `idPouch_Check` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `check_doc`
--

INSERT INTO `check_doc` (`idCheck`, `numberBank`, `numberAgency`, `numberAccount`, `numberCheck`, `nameHolder`, `docCpfOrCnpj`, `date`, `value`, `idPouch_Check`) VALUES
(1, '001', '3188-7', '30546-4', '850085', 'Anderson Caye', '000.000.000-00', '20/06/2019', '36.00', 1),
(2, '748', '0119', '12607-0', '000958', 'Anderson Caye', '00.000.000/0000-00', '16/06/2019', '285.00', 1),
(9, '001', '3188-7', '12607-0', '850001', 'Bruno', '000.000.000-00', '30/06/2019', '2.99', 7),
(10, '3232', '3213', '2331', '23324342', 'Bruno Bencke', '00.000.000/0000-00', '30/06/2019', '200.00', 7),
(11, '001', '3188', '30546', '850001', 'Bruninho', '00.000.000/0000-00', '26/06/2019', '200.00', 8),
(6, '104', '0119', '12607-0', '900855', 'Caye Pedras', '000.000.000-00', '04/06/1997', '4.96', 1),
(7, '001', '3188-7', '30546-4', '000987', 'Anderson Caye', '036.149.690-70', '21/06/2019', '1.99', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `idClient` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `client`
--

INSERT INTO `client` (`idClient`, `code`, `name`, `email`) VALUES
(1, '7001', 'AndersonCaye', 'andersoncaye@gmail.com'),
(2, '183047', 'Bruno', 'bruninho@nits.com'),
(3, '022860', 'teutostone1972', 'admin@admin.com'),
(5, '794053', 'Alan', 'alan@g.com'),
(7, '56587', 'Alee', 'alee@alee.com'),
(8, '666', 'popai', 'popai@olivia.brutos'),
(9, '19835995400119', 'EmpresaUM', 'empresaum@cb.com'),
(10, '19835995400112', 'EmpresaDOIS', 'empresadois@cb.com'),
(11, '789569', 'BrunoB', 'a@a.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pouch_check`
--

CREATE TABLE IF NOT EXISTS `pouch_check` (
  `idPouch` int(11) NOT NULL,
  `idClient_Pousch` int(11) NOT NULL,
  `date_e` varchar(12) NOT NULL,
  `reference` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `pouch_check`
--

INSERT INTO `pouch_check` (`idPouch`, `idClient_Pousch`, `date_e`, `reference`) VALUES
(1, 1, '20/07/2019', 'teste de INSERT teste 2 - jh'),
(2, 8, '20/06/2019', 'segundo teste'),
(3, 7, '21/06/2019', 'Teste da 16h'),
(4, 9, '24/06/2019', 'PEDIDO NR 2019'),
(5, 10, '24/06/2019', 'PEDIDO 2'),
(6, 9, '23/06/2019', 'UM PEDIDO QUALQUER'),
(7, 8, '26/06/2019', 'cheque'),
(8, 11, '26/06/2019', 'Cheque novos, novos produtos');

-- --------------------------------------------------------

--
-- Estrutura para tabela `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `user`
--

INSERT INTO `user` (`idUser`, `email`, `password`) VALUES
(1, 'admin@admin.com', 'admin'),
(2, 'a@a.com', 'a');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `check_doc`
--
ALTER TABLE `check_doc`
  ADD PRIMARY KEY (`idCheck`);

--
-- Índices de tabela `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idClient`), ADD UNIQUE KEY `code` (`code`);

--
-- Índices de tabela `pouch_check`
--
ALTER TABLE `pouch_check`
  ADD PRIMARY KEY (`idPouch`);

--
-- Índices de tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`), ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `check_doc`
--
ALTER TABLE `check_doc`
  MODIFY `idCheck` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de tabela `client`
--
ALTER TABLE `client`
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de tabela `pouch_check`
--
ALTER TABLE `pouch_check`
  MODIFY `idPouch` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
