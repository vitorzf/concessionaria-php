-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 27-Abr-2021 às 01:20
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `concessionaria`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carro`
--

CREATE TABLE `carro` (
  `id` int(11) NOT NULL,
  `nome` varchar(240) NOT NULL,
  `modelo` varchar(20) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `cor` varchar(50) NOT NULL,
  `estoque` int(11) NOT NULL DEFAULT '0',
  `tipo_id` int(11) NOT NULL,
  `visivel` tinyint(1) NOT NULL DEFAULT '1',
  `marca` varchar(255) NOT NULL,
  `fotos` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `carro`
--

INSERT INTO `carro` (`id`, `nome`, `modelo`, `valor`, `cor`, `estoque`, `tipo_id`, `visivel`, `marca`, `fotos`) VALUES
(1, 'Porsche Cayman', '2.7 I6 24V GASOLINA ', '850000.00', 'Prata', 1, 3, 1, 'Porsche', '[{\"url\":\"https://imganuncios.mitula.net/porsche_2020_gasolina_porsche_718_cayman_2_0_300cv_2020_gasolina_prata_5900109612447077903.jpg\"},{\"url\":\"https://i.pinimg.com/736x/de/c2/18/dec2182bf9155e5ec0e39f1ef85ae965.jpg\"}]');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `id_dados_cliente` int(10) NOT NULL,
  `visivel` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`id`, `id_dados_cliente`, `visivel`) VALUES
(1, 1, 1);

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
  `endereco_id` int(11) NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_alteracao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `dados_cliente`
--

INSERT INTO `dados_cliente` (`id`, `nome`, `email`, `telefone`, `RG`, `CPF`, `endereco_id`, `data_registro`, `data_alteracao`) VALUES
(1, 'Vitor', 'vitor@gmail.com', 2147483647, 45855922, 2147483647, 1, '2021-04-22 23:48:33', '2021-04-27');

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
(3, 'Cayque', 78963245, 546210217, '40028922'),
(4, 'Valdir', 2147483647, 15785562, '14988562214'),
(5, 'Vendedor Teste', 2147483647, 15488520, '14998905233');

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE `endereco` (
  `id` int(11) NOT NULL,
  `rua` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bairro` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` int(11) NOT NULL,
  `cep` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`id`, `rua`, `bairro`, `cidade`, `estado`, `numero`, `cep`) VALUES
(1, 'AmÃ©lia Volta Laplechade', 'Jardim MarÃ­lia', 'MarÃ­lia', 'SP', 57, '17511802');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `id` int(10) NOT NULL,
  `id_dados_funcionario` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `gerente` tinyint(1) NOT NULL DEFAULT '0',
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `funcionario`
--

INSERT INTO `funcionario` (`id`, `id_dados_funcionario`, `email`, `senha`, `gerente`, `ativo`) VALUES
(1, 3, 'cayque.142@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 1),
(2, 4, 'valdir@unimar.br', '202cb962ac59075b964b07152d234b70', 1, 1),
(3, 5, 'vendas@vivc.com.br', '202cb962ac59075b964b07152d234b70', 0, 1);

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
  `novo_estoque` int(11) NOT NULL,
  `carro_id` int(10) NOT NULL,
  `gerente_id` int(10) NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estoque_anterior` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `movimentacao_estoque`
--

INSERT INTO `movimentacao_estoque` (`id`, `novo_estoque`, `carro_id`, `gerente_id`, `data`, `estoque_anterior`) VALUES
(1, 3, 1, 2, '2021-04-26 22:39:56', 1),
(2, 2, 1, 2, '2021-04-26 22:42:42', 3),
(3, 1, 1, 2, '2021-04-26 22:44:22', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_carro`
--

CREATE TABLE `tipo_carro` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visivel` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tipo_carro`
--

INSERT INTO `tipo_carro` (`id`, `nome`, `visivel`) VALUES
(1, 'Hatch', 1),
(2, 'Sedan', 1),
(3, 'CupÃª', 1);

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
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `forma_pagto` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `observacoes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `vendas`
--

INSERT INTO `vendas` (`id`, `cliente_id`, `carro_id`, `gerente_id`, `funcionario_id`, `total_venda`, `quantidade`, `data`, `forma_pagto`, `status`, `observacoes`) VALUES
(2, 1, 1, 2, 3, 850000, 1, '2021-04-26 22:44:22', 'credito', 1, 'Teste de venda');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carro`
--
ALTER TABLE `carro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_id` (`tipo_id`);

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idregistro_cliente` (`id_dados_cliente`);

--
-- Indexes for table `dados_cliente`
--
ALTER TABLE `dados_cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `endereco_id` (`endereco_id`);

--
-- Indexes for table `dados_funcionario`
--
ALTER TABLE `dados_funcionario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_cadastrofunc` (`id_dados_funcionario`);

--
-- Indexes for table `metodo_pagamento`
--
ALTER TABLE `metodo_pagamento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idcarro_adic` (`carro_id`),
  ADD KEY `fk_idgerente_adic` (`gerente_id`);

--
-- Indexes for table `tipo_carro`
--
ALTER TABLE `tipo_carro`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idcliente_venda` (`cliente_id`),
  ADD KEY `fk_idgerente_venda` (`gerente_id`),
  ADD KEY `fk_idcarro_venda` (`carro_id`),
  ADD KEY `fk_idfunc_venda` (`funcionario_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carro`
--
ALTER TABLE `carro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dados_cliente`
--
ALTER TABLE `dados_cliente`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dados_funcionario`
--
ALTER TABLE `dados_funcionario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `metodo_pagamento`
--
ALTER TABLE `metodo_pagamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tipo_carro`
--
ALTER TABLE `tipo_carro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `carro`
--
ALTER TABLE `carro`
  ADD CONSTRAINT `carro_ibfk_1` FOREIGN KEY (`tipo_id`) REFERENCES `tipo_carro` (`id`);

--
-- Limitadores para a tabela `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_idregistro_cliente` FOREIGN KEY (`id_dados_cliente`) REFERENCES `dados_cliente` (`id`);

--
-- Limitadores para a tabela `dados_cliente`
--
ALTER TABLE `dados_cliente`
  ADD CONSTRAINT `dados_cliente_ibfk_1` FOREIGN KEY (`endereco_id`) REFERENCES `endereco` (`id`);

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
  ADD CONSTRAINT `fk_idgerente_adic` FOREIGN KEY (`gerente_id`) REFERENCES `funcionario` (`id`);

--
-- Limitadores para a tabela `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `fk_idcarro_venda` FOREIGN KEY (`carro_id`) REFERENCES `carro` (`id`),
  ADD CONSTRAINT `fk_idcliente_venda` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
