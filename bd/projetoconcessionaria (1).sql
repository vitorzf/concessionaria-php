-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16-Abr-2021 às 00:52
-- Versão do servidor: 10.4.17-MariaDB
-- versão do PHP: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projetoconcessionaria`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carro`
--

CREATE TABLE `carro` (
  `id` int(11) NOT NULL,
  `nome` varchar(240) NOT NULL,
  `modelo` varchar(20) NOT NULL,
  `valor` float NOT NULL,
  `cor` varchar(50) NOT NULL,
  `estoque` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `id_dados_cliente` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dados_cliente`
--

CREATE TABLE `dados_cliente` (
  `id` int(10) NOT NULL,
  `nome` varchar(240) NOT NULL,
  `email` varchar(240) NOT NULL,
  `telefone` int(20) NOT NULL,
  `RG` int(10) NOT NULL,
  `CPF` int(20) NOT NULL,
  `endereco` varchar(240) NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_alteracao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dados_funcionario`
--

CREATE TABLE `dados_funcionario` (
  `id` int(11) NOT NULL,
  `nome` varchar(240) NOT NULL,
  `CPF` int(20) NOT NULL,
  `RG` int(20) NOT NULL,
  `telefone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `dados_funcionario`
--

INSERT INTO `dados_funcionario` (`id`, `nome`, `CPF`, `RG`, `telefone`) VALUES
(3, 'Cayque', 78963245, 546210217, '40028922');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `id` int(10) NOT NULL,
  `id_dados_funcionario` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `funcionario`
--

INSERT INTO `funcionario` (`id`, `id_dados_funcionario`, `email`, `senha`) VALUES
(1, 3, 'cayque.142@gmail.com', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gerente`
--

CREATE TABLE `gerente` (
  `id` int(11) NOT NULL COMMENT 'Id gerado por gerente cadastrado no sistema',
  `nome` varchar(240) NOT NULL,
  `email` varchar(240) NOT NULL,
  `senha` int(10) NOT NULL,
  `idade` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `metodo_pagamento`
--

CREATE TABLE `metodo_pagamento` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `movimentacao_estoque`
--

CREATE TABLE `movimentacao_estoque` (
  `id` int(10) NOT NULL,
  `quantidade` int(10) NOT NULL,
  `carro_id` int(10) NOT NULL,
  `gerente_id` int(10) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE `vendas` (
  `id` int(10) NOT NULL,
  `cliente_id` int(10) NOT NULL,
  `carro_id` int(10) NOT NULL,
  `gerente_id` int(10) NOT NULL,
  `funcionario_id` int(10) NOT NULL,
  `total_venda` float NOT NULL,
  `quantidade` float NOT NULL,
  `data` date NOT NULL,
  `id_forma_pagto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `carro`
--
ALTER TABLE `carro`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idregistro_cliente` (`id_dados_cliente`);

--
-- Índices para tabela `dados_cliente`
--
ALTER TABLE `dados_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `dados_funcionario`
--
ALTER TABLE `dados_funcionario`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_cadastrofunc` (`id_dados_funcionario`);

--
-- Índices para tabela `gerente`
--
ALTER TABLE `gerente`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `metodo_pagamento`
--
ALTER TABLE `metodo_pagamento`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idcarro_adic` (`carro_id`),
  ADD KEY `fk_idgerente_adic` (`gerente_id`);

--
-- Índices para tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idcliente_venda` (`cliente_id`),
  ADD KEY `fk_idgerente_venda` (`gerente_id`),
  ADD KEY `fk_idcarro_venda` (`carro_id`),
  ADD KEY `fk_idfunc_venda` (`funcionario_id`),
  ADD KEY `fk_idformapag_venda` (`id_forma_pagto`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carro`
--
ALTER TABLE `carro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `dados_cliente`
--
ALTER TABLE `dados_cliente`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `dados_funcionario`
--
ALTER TABLE `dados_funcionario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `gerente`
--
ALTER TABLE `gerente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id gerado por gerente cadastrado no sistema';

--
-- AUTO_INCREMENT de tabela `metodo_pagamento`
--
ALTER TABLE `metodo_pagamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_idregistro_cliente` FOREIGN KEY (`id_dados_cliente`) REFERENCES `dados_cliente` (`id`);

--
-- Limitadores para a tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `fk_id_cadastrofunc` FOREIGN KEY (`id_dados_funcionario`) REFERENCES `dados_funcionario` (`id`);

--
-- Limitadores para a tabela `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  ADD CONSTRAINT `fk_idcarro_adic` FOREIGN KEY (`carro_id`) REFERENCES `carro` (`id`),
  ADD CONSTRAINT `fk_idgerente_adic` FOREIGN KEY (`gerente_id`) REFERENCES `gerente` (`id`);

--
-- Limitadores para a tabela `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `fk_idcarro_venda` FOREIGN KEY (`carro_id`) REFERENCES `carro` (`id`),
  ADD CONSTRAINT `fk_idcliente_venda` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `fk_idformapag_venda` FOREIGN KEY (`id_forma_pagto`) REFERENCES `metodo_pagamento` (`id`),
  ADD CONSTRAINT `fk_idfunc_venda` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionario` (`id`),
  ADD CONSTRAINT `fk_idgerente_venda` FOREIGN KEY (`gerente_id`) REFERENCES `gerente` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
