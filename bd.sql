-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 24-Nov-2019 às 13:38
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `microservice_sofevent`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `certificado`
--

CREATE TABLE IF NOT EXISTS `certificado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_inscricao` int(11) NOT NULL,
  `id_registro` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `certificado`
--

INSERT INTO `certificado` (`id`, `id_inscricao`, `id_registro`, `id_usuario`, `id_evento`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 2, 1, 0),
(3, 1, 2, 3, 3),
(4, 1, 2, 1, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`id`, `date`, `token`, `id_usuario`) VALUES
(1, '2019-11-21 01:07:12', 'd690caea5ae5641c9cceec11628c6aef', 3),
(2, '2019-11-23 15:44:48', '7bfce082bfd83d30fa0d78819077a283', 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `documento` varchar(20) CHARACTER SET latin1 NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 NOT NULL,
  `senha` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `tipo` int(11) NOT NULL COMMENT '0 = usuário comum; 1 = usuário administrativo',
  `deletado` int(11) NOT NULL DEFAULT '0' COMMENT '0  ativo; 1 = desativado',
  PRIMARY KEY (`id`),
  UNIQUE KEY `documento` (`documento`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `documento`, `email`, `senha`, `tipo`, `deletado`) VALUES
(1, 'Anderson', '00000000000', 'anderson@anderson.com', 'anderson', 1, 0),
(2, 'Nick', '00000000020', 'ander@ander.com', 'ander', 0, 1),
(3, 'Nick', '00000000333', 'elias@elias.com', 'elias', 0, 0),
(5, 'Elias', '00000000004', 'elias4@elias.com', 'elias', 0, 0),
(6, 'Ninguem', '00000000008', 'email@email.com', 'zero1', 1, 0),
(7, NULL, '00000000009', 'fast@fast.com', NULL, 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
