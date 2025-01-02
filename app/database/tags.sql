-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 03/01/2025 às 00:22
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tags`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `paginas`
--

CREATE TABLE `paginas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `conteudo` text NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo` varchar(255) DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `paginas`
--

INSERT INTO `paginas` (`id`, `titulo`, `conteudo`, `data_criacao`, `tipo`) VALUES
(60, 'Homepage', 'Homepage do site da Azul Turquesa', '2025-01-02 23:03:00', 'normal'),
(61, 'Sobre nós', 'Sobre a banda Azul Turquesa', '2025-01-02 23:03:02', 'normal'),
(62, 'Downloads', 'Downloads das músicas da Azul Turquesa', '2025-01-02 23:03:03', 'normal'),
(63, 'Letras de nossas músicas', 'Letras das músicas da Azul Turquesa', '2025-01-02 23:03:05', 'normal'),
(64, 'Galeria de fotos', 'Fotos promocionais da banda Azul Turquesa', '2025-01-02 23:03:07', 'galeria'),
(65, 'Onde nos ouvir', 'Onde ouvir a Azul Turquesa', '2025-01-02 23:03:10', 'links');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagina_tags`
--

CREATE TABLE `pagina_tags` (
  `pagina_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pagina_tags`
--

INSERT INTO `pagina_tags` (`pagina_id`, `tag_id`) VALUES
(60, 37),
(60, 38),
(61, 39),
(61, 40),
(61, 41),
(61, 42),
(62, 43),
(62, 44),
(62, 45),
(63, 42),
(63, 46),
(63, 47),
(64, 42),
(64, 48),
(64, 49),
(64, 50),
(64, 51),
(65, 52),
(65, 53),
(65, 54),
(65, 55),
(65, 56);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tags`
--

INSERT INTO `tags` (`id`, `nome`) VALUES
(42, 'azul turquesa'),
(51, 'Azul Turquesa Duo'),
(55, 'azul turquesa spotify'),
(56, 'azul turquesa youtube'),
(45, 'baixar musicas da azul turquesa'),
(41, 'curiosidades azul turquesa'),
(43, 'downloads'),
(44, 'downloads da azul turquesa'),
(50, 'Efemera'),
(48, 'fotos da azul turquesa'),
(40, 'historia da azul turquesa'),
(37, 'homepage do site azul turquesa'),
(46, 'letras da azul turquesa'),
(53, 'links turquesa'),
(47, 'musicas da azul turquesa'),
(54, 'onde achar azul turquesa'),
(52, 'onde ouvir azul turquesa'),
(57, 'ondeouvir'),
(38, 'posts'),
(39, 'sobre a azul turquesa'),
(49, 'Soturna Crosta');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `paginas`
--
ALTER TABLE `paginas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `titulo` (`titulo`);

--
-- Índices de tabela `pagina_tags`
--
ALTER TABLE `pagina_tags`
  ADD PRIMARY KEY (`pagina_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Índices de tabela `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `paginas`
--
ALTER TABLE `paginas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de tabela `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `pagina_tags`
--
ALTER TABLE `pagina_tags`
  ADD CONSTRAINT `pagina_tags_ibfk_1` FOREIGN KEY (`pagina_id`) REFERENCES `paginas` (`id`),
  ADD CONSTRAINT `pagina_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
