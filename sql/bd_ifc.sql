-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Fev-2022 às 14:25
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_ifc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogador`
--

CREATE TABLE `jogador` (
  `jogadorId` int(10) NOT NULL,
  `jogadorNome` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `jogadorpartida` (
  `jogadorPartidaId` int(11) NOT NULL,
  `partidaId` int(11) DEFAULT NULL,
  `timeId` int(11) DEFAULT NULL,
  `jogadorId` int(11) DEFAULT NULL,
  `vitoriaEmpate` int(2) NOT NULL,
  `derrota` int(2) NOT NULL,
  `empate` int(2) NOT NULL,
  `ponto` int(2) NOT NULL,
  `gol` int(11) DEFAULT NULL,
  `ca` int(11) DEFAULT NULL,
  `cv` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `partida` (
  `partidaId` int(11) NOT NULL,
  `dia` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `juiz` varchar(50) NOT NULL,
  `golAzul` varchar(2) NOT NULL,
  `golBranco` varchar(2) NOT NULL,
  `nPartida` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `time` (
  `timeId` int(11) NOT NULL,
  `timeNome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `time` (`timeId`, `timeNome`) VALUES
(1, 'AZUL'),
(2, 'BRANCO');

CREATE TABLE `timepartida` (
  `timepartidaId` int(11) NOT NULL,
  `timeId` int(11) NOT NULL,
  `partidaId` int(11) NOT NULL,
  `vitoriaEmpate` int(2) NOT NULL,
  `derrota` int(2) NOT NULL,
  `empate` int(2) NOT NULL,
  `ponto` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(120) NOT NULL,
  `senha` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'Fabio', 'fabio79siqueira@gmail.com', '123456');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `jogador`
--
ALTER TABLE `jogador`
  ADD PRIMARY KEY (`jogadorId`);

--
-- Índices para tabela `jogadorpartida`
--
ALTER TABLE `jogadorpartida`
  ADD PRIMARY KEY (`jogadorPartidaId`);

--
-- Índices para tabela `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`partidaId`);

--
-- Índices para tabela `time`
--
ALTER TABLE `time`
  ADD PRIMARY KEY (`timeId`);

--
-- Índices para tabela `timepartida`
--
ALTER TABLE `timepartida`
  ADD PRIMARY KEY (`timepartidaId`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `jogador`
--
ALTER TABLE `jogador`
  MODIFY `jogadorId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de tabela `jogadorpartida`
--
ALTER TABLE `jogadorpartida`
  MODIFY `jogadorPartidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de tabela `partida`
--
ALTER TABLE `partida`
  MODIFY `partidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de tabela `time`
--
ALTER TABLE `time`
  MODIFY `timeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de tabela `timepartida`
--
ALTER TABLE `timepartida`
  MODIFY `timepartidaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
