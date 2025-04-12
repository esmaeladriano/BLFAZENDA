-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Abr-2025 às 22:55
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `fazenda`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `imagem` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `data_criacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` text DEFAULT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `email`, `telefone`, `endereco`, `data_registro`) VALUES
(1, 'Cliente A', 'clienteA@example.com', '987654321', 'Rua do Cliente A', '2025-04-12 15:40:41'),
(3, 'Esmael Adriano', 'aluno@gmail.com', '940923748', 'Luanda', '2025-04-12 19:52:38');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` text DEFAULT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `fornecedores`
--

INSERT INTO `fornecedores` (`id`, `nome`, `email`, `telefone`, `endereco`, `data_registro`) VALUES
(1, 'Fornecedor A', 'fornecedorA@example.com', '123456789', 'Rua do Fornecedor A', '2025-04-12 15:40:41'),
(2, 'Fornecedor B', 'fornecedorB@example.com', '987654321', 'Rua do Fornecedor B', '2025-04-12 15:40:41'),
(3, 'Esmael Adriano adriano', 'esmadriano2023@gmail.com', '940923748', 'Angola-Luanda', '2025-04-09 23:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `parceiros`
--

CREATE TABLE `parceiros` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` text DEFAULT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `parceiros`
--

INSERT INTO `parceiros` (`id`, `nome`, `email`, `telefone`, `endereco`, `data_registro`) VALUES
(1, 'Parceiro A', 'parceiroA@example.com', '321654987', 'Rua do Parceiro A', '2025-04-12 15:40:41'),
(2, 'Parceiro B', 'parceiroB@example.com', '987321654', 'Rua do Parceiro B', '2025-04-12 15:40:41'),
(3, 'Esmael Adriano adriano', 'esmadriano2023@gmail.com', '940923748', 'Angola-Luanda', '2025-04-17 23:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_fornecedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `img`, `descricao`, `preco`, `quantidade`, `data_criacao`, `id_fornecedor`) VALUES
(4, 'Esmael Adriano adriano', 'upload/67fac6d142cee_logo BLFAZENDA (1).png', '2', 23.00, 2, '2025-04-16 23:00:00', 2),
(7, 'youi', 'upload/67facc01851ba_logo aldalara.png', 'wwqwqwq', 2343.00, 2, '2025-04-18 23:00:00', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `role` enum('admin','gerente','usuario') DEFAULT 'usuario',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `role`, `data_criacao`) VALUES
(1, 'Esmael Adriano', 'admin@fazenda.com', '$2y$10$8auCxsQ5OMWYPZNPlbJNZObYp/pRzyKEBuYJm1/pJgh63ixaO6w9S', 'admin', '2025-04-12 16:27:39'),
(13, 'Gelson', 'admin@gmail.com', '$2y$10$mdYS3MHjP.Xr82lyBXSImOuMolboiqYcDcbgTh5tjabnTtwMKyI.2', 'usuario', '2025-04-12 17:54:22'),
(17, 'Esmael Adriano adriano', 'bartolomeusapalo@gmail.com', '$2y$10$Afm68y2r0jtW/Glp6XSpA.lvDNRYPjfdNJDvHqJMuvG7Aam/5ZszW', 'usuario', '2025-04-12 20:38:15');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE `vendas` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_total` decimal(10,2) NOT NULL,
  `data_venda` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_venda` enum('grosso','retalho') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `vendas`
--

INSERT INTO `vendas` (`id`, `id_cliente`, `id_produto`, `quantidade`, `preco_total`, `data_venda`, `tipo_venda`) VALUES
(10, 1, 4, 333, 0.00, '2025-04-23 23:00:00', 'grosso'),
(11, 1, 4, 4, 0.00, '2025-04-22 23:00:00', 'grosso');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `parceiros`
--
ALTER TABLE `parceiros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_fornecedor` (`id_fornecedor`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `vendas_ibfk_3` (`id_produto`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `parceiros`
--
ALTER TABLE `parceiros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id`);

--
-- Limitadores para a tabela `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `vendas_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `vendas_ibfk_3` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
