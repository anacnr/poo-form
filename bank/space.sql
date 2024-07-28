-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/07/2024 às 01:09
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
-- Banco de dados: `space`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `astro`
--

CREATE TABLE `astro` (
  `id` int(11) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `pass` varchar(10) NOT NULL,
  `register` date NOT NULL DEFAULT curtime()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `astro`
--

INSERT INTO `astro` (`id`, `nickname`, `pass`, `register`) VALUES
(1, 'aninha', 'rj2019', '2024-07-20');

-- --------------------------------------------------------

--
-- Estrutura para tabela `astrologin`
--

CREATE TABLE `astrologin` (
  `id_astro` int(11) NOT NULL,
  `register_login` date DEFAULT curtime()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `astrologin`
--

INSERT INTO `astrologin` (`id_astro`, `register_login`) VALUES
(1, '2024-07-28'),
(1, '2024-07-28');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `astro`
--
ALTER TABLE `astro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nickname` (`nickname`);

--
-- Índices de tabela `astrologin`
--
ALTER TABLE `astrologin`
  ADD KEY `id_astro` (`id_astro`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `astro`
--
ALTER TABLE `astro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `astrologin`
--
ALTER TABLE `astrologin`
  ADD CONSTRAINT `astrologin_ibfk_1` FOREIGN KEY (`id_astro`) REFERENCES `astro` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
