-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 21/06/2018 às 10:48
-- Versão do servidor: 5.5.60-0+deb8u1
-- Versão do PHP: 5.6.33-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `imob_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `contratos`
--

CREATE TABLE IF NOT EXISTS `contratos` (
`id` int(20) NOT NULL,
  `valor` float NOT NULL,
  `img_contrato` blob NOT NULL,
  `periodo` int(11) NOT NULL,
  `valido` tinyint(1) NOT NULL,
  `id_imovel` int(20) NOT NULL,
  `id_proprietario` int(20) NOT NULL,
  `id_inquilino` int(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Fazendo dump de dados para tabela `contratos`
--

INSERT INTO `contratos` (`id`, `valor`, `img_contrato`, `periodo`, `valido`, `id_imovel`, `id_proprietario`, `id_inquilino`) VALUES
(3, 14000, 0x696d6167656d, 20, 1, 1, 11, 14);

-- --------------------------------------------------------

--
-- Estrutura para tabela `imoveis`
--

CREATE TABLE IF NOT EXISTS `imoveis` (
`id` int(20) NOT NULL,
  `n_quartos` int(3) NOT NULL,
  `n_banheiros` int(3) NOT NULL,
  `valor_aluguel` float NOT NULL,
  `rua` varchar(300) NOT NULL,
  `area` float NOT NULL,
  `bairro` varchar(300) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `cidade` varchar(300) NOT NULL,
  `contato_tel` varchar(30) NOT NULL,
  `contato_email` varchar(150) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `tipo` enum('Casa','Apto') NOT NULL,
  `id_responsavel` int(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Fazendo dump de dados para tabela `imoveis`
--

INSERT INTO `imoveis` (`id`, `n_quartos`, `n_banheiros`, `valor_aluguel`, `rua`, `area`, `bairro`, `estado`, `cidade`, `contato_tel`, `contato_email`, `cep`, `tipo`, `id_responsavel`) VALUES
(1, 2, 2, 330, 'Rua dos ouvidores', 300, 'Propolis', 'PR', 'Propolandia', '11111111', 'email_imovel@email.com', '323232', '', 1),
(2, 3, 2, 2000, 'Rua das Palmeiras', 300, 'Bairro das Lagostas', 'São Paulo', 'São Joaquin', '934523453', 'douglas_berg@vascostore.com', '52098200', 'Apto', 14),
(3, 3, 2, 2000, 'Rua das Palmeiras', 300, 'Bairro das Lagostas', 'SÃ£o Paulo', 'SÃ£o Joaquin', '934523453', 'douglas_berg@vascostore.com', '52098200', 'Apto', 14);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamentos`
--

CREATE TABLE IF NOT EXISTS `pagamentos` (
`id` int(11) NOT NULL,
  `data_pagamento` date NOT NULL,
  `id_contrato` int(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Fazendo dump de dados para tabela `pagamentos`
--

INSERT INTO `pagamentos` (`id`, `data_pagamento`, `id_contrato`) VALUES
(1, '2018-06-25', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `reclamacoes`
--

CREATE TABLE IF NOT EXISTS `reclamacoes` (
`id` int(20) NOT NULL,
  `descr_reclamacao` varchar(6000) NOT NULL,
  `id_contrato` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Fazendo dump de dados para tabela `reclamacoes`
--

INSERT INTO `reclamacoes` (`id`, `descr_reclamacao`, `id_contrato`) VALUES
(1, 'Anuncio falava que tinha 3 banheiros mas tem 4', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tab_user`
--

CREATE TABLE IF NOT EXISTS `tab_user` (
`id` int(20) NOT NULL,
  `senha` varchar(300) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

--
-- Fazendo dump de dados para tabela `tab_user`
--

INSERT INTO `tab_user` (`id`, `senha`, `email`) VALUES
(1, '$2y$10$5bWhrafCUJvQ4oq.YDvh1e8GAuXdnMBtSCEa3/jGggfQ4EG7wPw3C', 'email5'),
(2, '$2y$10$RxA/PFPRDuZAUi7XXJ4C3e4y3foGEvsM/a00ur2TyG5VseRmMp4Dm', 'email6'),
(6, '$2y$10$vAJfbgVnScRgjol.BiRURe5zvkLt1tOG0HVEohqIns6GK6Vln/Fwe', 'email7'),
(9, '$2y$10$59zxkq1YjN5Ux56BDJ/Kee/ftVjKKoBLwBbTPkl3wG0wPK8jZjIqe', 'email8'),
(10, '$2y$10$ZsK2f.PMIwENZEccqpxk/utG42BlxxwMRYG.vC1Z2GGqITHB9vczG', 'email9'),
(11, '$2y$10$zNlYmTj9hNq37J16e1o2guYB/L6IdAGFzQ/LdjDMO1xKdf/FV8LLC', 'email19'),
(14, '$2y$10$zRvqfhvtzHMl/qRcW1T2LeZqmMAJtlXfahImUKLuTDgqkok7/ZyeG', 'email191'),
(15, '$2y$10$60XyIWJYMOJFseoxcayY9O2l/12BCvHH5lXuac1kNC4dyYtpneOlC', 'email1911'),
(16, '$2y$10$C6Xzsq2RRTAToZUTcmgY5.T33N3mx4BGFiJjqcdVT4c2jBSlnB2hq', 'email12'),
(17, '$2y$10$InD/58XiK0gd0n6tg/tvbOBGf8PxHgNrpJrC8TgqyYrOIUhYNEOsq', 'email144');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_user` int(20) NOT NULL,
  `nome_completo` varchar(300) NOT NULL,
  `cpf` varchar(30) NOT NULL,
  `rg` varchar(30) NOT NULL,
  `tel_contato` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Fazendo dump de dados para tabela `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `nome_completo`, `cpf`, `rg`, `tel_contato`) VALUES
(1, '', '', '', ''),
(17, 'nome_Completo_usuario19', '11111111', '11111111', '1111111'),
(14, 'nome_Completo_usuario5', '22222222222', '2213232312323', '29292929'),
(15, 'nome_Completo_usuario5', '222222222221', '22132323123231', '29292929'),
(11, 'nome_Completo_usuario5', '2222222222', '221323232323', '29292929'),
(1, 'nome_Completo_usuario5', '222222222', '22323232323', '29292929'),
(16, 'nome_Completo_usuario12', '2222222225', '223232323235', '292929295');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `contratos`
--
ALTER TABLE `contratos`
 ADD PRIMARY KEY (`id`), ADD KEY `chave_imovel` (`id_imovel`), ADD KEY `chave_inquilino_imovel` (`id_inquilino`), ADD KEY `chave_proprietario_imovel` (`id_proprietario`);

--
-- Índices de tabela `imoveis`
--
ALTER TABLE `imoveis`
 ADD PRIMARY KEY (`id`), ADD KEY `chave_dono_imovel` (`id_responsavel`);

--
-- Índices de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
 ADD PRIMARY KEY (`id`), ADD KEY `chave_contrato` (`id_contrato`);

--
-- Índices de tabela `reclamacoes`
--
ALTER TABLE `reclamacoes`
 ADD PRIMARY KEY (`id`), ADD KEY `chave_contrato_rec` (`id_contrato`);

--
-- Índices de tabela `tab_user`
--
ALTER TABLE `tab_user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
 ADD UNIQUE KEY `rg` (`rg`), ADD UNIQUE KEY `cpf` (`cpf`), ADD KEY `chave_user` (`id_user`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `contratos`
--
ALTER TABLE `contratos`
MODIFY `id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de tabela `imoveis`
--
ALTER TABLE `imoveis`
MODIFY `id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de tabela `reclamacoes`
--
ALTER TABLE `reclamacoes`
MODIFY `id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de tabela `tab_user`
--
ALTER TABLE `tab_user`
MODIFY `id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `contratos`
--
ALTER TABLE `contratos`
ADD CONSTRAINT `chave_imovel` FOREIGN KEY (`id_imovel`) REFERENCES `imoveis` (`id`),
ADD CONSTRAINT `chave_inquilino_imovel` FOREIGN KEY (`id_inquilino`) REFERENCES `tab_user` (`id`),
ADD CONSTRAINT `chave_proprietario_imovel` FOREIGN KEY (`id_proprietario`) REFERENCES `tab_user` (`id`);

--
-- Restrições para tabelas `imoveis`
--
ALTER TABLE `imoveis`
ADD CONSTRAINT `chave_dono_imovel` FOREIGN KEY (`id_responsavel`) REFERENCES `tab_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `pagamentos`
--
ALTER TABLE `pagamentos`
ADD CONSTRAINT `chave_contrato` FOREIGN KEY (`id_contrato`) REFERENCES `contratos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `reclamacoes`
--
ALTER TABLE `reclamacoes`
ADD CONSTRAINT `chave_contrato_rec` FOREIGN KEY (`id_contrato`) REFERENCES `contratos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
ADD CONSTRAINT `chave_user` FOREIGN KEY (`id_user`) REFERENCES `tab_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
