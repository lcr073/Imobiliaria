-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 14-Jun-2018 às 18:03
-- Versão do servidor: 10.1.26-MariaDB-0+deb9u1
-- PHP Version: 7.0.27-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imob_db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `contratos`
--

CREATE TABLE `contratos` (
  `id` int(20) NOT NULL,
  `valor` float NOT NULL,
  `img_contrato` blob NOT NULL,
  `periodo` int(11) NOT NULL,
  `valido` tinyint(1) NOT NULL,
  `id_imovel` int(20) NOT NULL,
  `id_proprietario` int(20) NOT NULL,
  `id_inquilino` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `imoveis`
--

CREATE TABLE `imoveis` (
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
  `id_responsavel` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `id` int(11) NOT NULL,
  `data_pagamento` date NOT NULL,
  `id_contrato` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reclamacoes`
--

CREATE TABLE `reclamacoes` (
  `id` int(20) NOT NULL,
  `descr_reclamacao` varchar(6000) NOT NULL,
  `id_contrato` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tab_user`
--

CREATE TABLE `tab_user` (
  `id` int(20) NOT NULL,
  `senha` varchar(300) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tab_user`
--

INSERT INTO `tab_user` (`id`, `senha`, `email`) VALUES
(1, '$2y$10$5bWhrafCUJvQ4oq.YDvh1e8GAuXdnMBtSCEa3/jGggfQ4EG7wPw3C', 'email5'),
(2, '$2y$10$RxA/PFPRDuZAUi7XXJ4C3e4y3foGEvsM/a00ur2TyG5VseRmMp4Dm', 'email6'),
(6, '$2y$10$vAJfbgVnScRgjol.BiRURe5zvkLt1tOG0HVEohqIns6GK6Vln/Fwe', 'email7'),
(9, '$2y$10$59zxkq1YjN5Ux56BDJ/Kee/ftVjKKoBLwBbTPkl3wG0wPK8jZjIqe', 'email8'),
(10, '$2y$10$ZsK2f.PMIwENZEccqpxk/utG42BlxxwMRYG.vC1Z2GGqITHB9vczG', 'email9'),
(11, '$2y$10$zNlYmTj9hNq37J16e1o2guYB/L6IdAGFzQ/LdjDMO1xKdf/FV8LLC', 'email19'),
(14, '$2y$10$zRvqfhvtzHMl/qRcW1T2LeZqmMAJtlXfahImUKLuTDgqkok7/ZyeG', 'email191');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` int(20) NOT NULL,
  `nome_completo` varchar(300) NOT NULL,
  `cpf` varchar(30) NOT NULL,
  `rg` varchar(30) NOT NULL,
  `tel_contato` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `nome_completo`, `cpf`, `rg`, `tel_contato`) VALUES
(1, '', '', '', ''),
(14, 'nome_Completo_usuario5', '22222222222', '2213232312323', '29292929'),
(11, 'nome_Completo_usuario5', '2222222222', '221323232323', '29292929'),
(1, 'nome_Completo_usuario5', '222222222', '22323232323', '29292929');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chave_imovel` (`id_imovel`),
  ADD KEY `chave_inquilino_imovel` (`id_inquilino`),
  ADD KEY `chave_proprietario_imovel` (`id_proprietario`);

--
-- Indexes for table `imoveis`
--
ALTER TABLE `imoveis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chave_dono_imovel` (`id_responsavel`);

--
-- Indexes for table `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chave_contrato` (`id_contrato`);

--
-- Indexes for table `reclamacoes`
--
ALTER TABLE `reclamacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chave_contrato_rec` (`id_contrato`);

--
-- Indexes for table `tab_user`
--
ALTER TABLE `tab_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD UNIQUE KEY `rg` (`rg`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `chave_user` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `imoveis`
--
ALTER TABLE `imoveis`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reclamacoes`
--
ALTER TABLE `reclamacoes`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tab_user`
--
ALTER TABLE `tab_user`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `contratos`
--
ALTER TABLE `contratos`
  ADD CONSTRAINT `chave_imovel` FOREIGN KEY (`id_imovel`) REFERENCES `imoveis` (`id`),
  ADD CONSTRAINT `chave_inquilino_imovel` FOREIGN KEY (`id_inquilino`) REFERENCES `tab_user` (`id`),
  ADD CONSTRAINT `chave_proprietario_imovel` FOREIGN KEY (`id_proprietario`) REFERENCES `tab_user` (`id`);

--
-- Limitadores para a tabela `imoveis`
--
ALTER TABLE `imoveis`
  ADD CONSTRAINT `chave_dono_imovel` FOREIGN KEY (`id_responsavel`) REFERENCES `tab_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `chave_contrato` FOREIGN KEY (`id_contrato`) REFERENCES `contratos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `reclamacoes`
--
ALTER TABLE `reclamacoes`
  ADD CONSTRAINT `chave_contrato_rec` FOREIGN KEY (`id_contrato`) REFERENCES `contratos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `chave_user` FOREIGN KEY (`id_user`) REFERENCES `tab_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
