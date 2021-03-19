-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Ago-2020 às 18:30
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
-- Banco de dados: `usuario`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `namespace`
--

CREATE TABLE `namespace` (
  `namespace` varchar(50) NOT NULL,
  `data_expiracao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `namespace`
--

INSERT INTO `namespace` (`namespace`, `data_expiracao`) VALUES
('junkes', '2020-08-01'),
('owlsoftware', '2021-12-31');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `email` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `login` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `senha` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `foto` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT NULL,
  `namespace` varchar(50) DEFAULT NULL,
  `dt_criacao` date DEFAULT NULL,
  `dt_atualizacao` date DEFAULT NULL,
  `usuario_atualizacao` varchar(250) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `login`, `senha`, `data_nascimento`, `foto`, `ativo`, `namespace`, `dt_criacao`, `dt_atualizacao`, `usuario_atualizacao`) VALUES
(0, 'Tiago', 'tiago@tiago.com', 'tiago', '123', '2000-01-01', 'Skype-20200319-094644.jpeg', NULL, 'owlsoftware', NULL, NULL, NULL),
(1, 'Junior', 'fabriciojuniorsc@gmail.com', 'junior', '0801', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'teste', 'teste@ds', 'teste', 'TESTE', '2000-01-01', NULL, NULL, 'owlsoftware', NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `namespace`
--
ALTER TABLE `namespace`
  ADD PRIMARY KEY (`namespace`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `namespace` (`namespace`);

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`namespace`) REFERENCES `namespace` (`namespace`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
