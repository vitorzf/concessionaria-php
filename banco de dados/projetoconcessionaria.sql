-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09-Abr-2021 às 20:52
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
-- Estrutura da tabela `adicionar_carro`
--

CREATE TABLE `adicionar_carro` (
  `id_adicionar_carro` int(10) NOT NULL,
  `quantidade_carros` int(10) NOT NULL,
  `id_carro_adicionado` int(10) NOT NULL,
  `id_gerentequeadic` int(10) NOT NULL,
  `data_adic_carro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastro_funcionario`
--

CREATE TABLE `cadastro_funcionario` (
  `id_cadastro_func` int(10) NOT NULL,
  `nome` int(11) NOT NULL,
  `CPF` int(11) NOT NULL,
  `RG` int(11) NOT NULL,
  `telefone` int(10) NOT NULL,
  `data_cadastro_func` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `carro`
--

CREATE TABLE `carro` (
  `idcarro` int(10) NOT NULL,
  `nome` varchar(240) NOT NULL,
  `modelo` varchar(20) NOT NULL,
  `valor` float NOT NULL,
  `cor` varchar(50) NOT NULL,
  `disponibilidade` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(10) NOT NULL,
  `id_registro_cli` int(10) NOT NULL,
  `historico_compras` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `idfunc` int(10) NOT NULL,
  `descricao_funcao` varchar(500) NOT NULL,
  `id_cadastrofunc` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `gerente`
--

CREATE TABLE `gerente` (
  `idgerente` int(10) NOT NULL COMMENT 'Id gerado por gerente cadastrado no sistema',
  `nome` varchar(240) NOT NULL,
  `email` varchar(240) NOT NULL,
  `senha` int(10) NOT NULL,
  `idade` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `registrar_venda`
--

CREATE TABLE `registrar_venda` (
  `id_registro_venda` int(10) NOT NULL,
  `id_cliente_venda` int(10) NOT NULL,
  `id_carro_venda` int(10) NOT NULL,
  `id_gerente_venda` int(10) NOT NULL,
  `id_func_venda` int(10) NOT NULL,
  `valortotal_venda` float NOT NULL,
  `quant_carrovendido` float NOT NULL,
  `forma_pagamento` tinyint(1) NOT NULL,
  `data_venda` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `registro_cliente`
--

CREATE TABLE `registro_cliente` (
  `id_registro_cliente` int(10) NOT NULL,
  `nome` varchar(240) NOT NULL,
  `email` varchar(240) NOT NULL,
  `telefone` int(20) NOT NULL,
  `RG` int(10) NOT NULL,
  `CPF` int(20) NOT NULL,
  `endereco` varchar(240) NOT NULL,
  `data_registro_cli` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `adicionar_carro`
--
ALTER TABLE `adicionar_carro`
  ADD PRIMARY KEY (`id_adicionar_carro`),
  ADD KEY `fk_idcarro_adic` (`id_carro_adicionado`),
  ADD KEY `fk_idgerente_adic` (`id_gerentequeadic`);

--
-- Índices para tabela `cadastro_funcionario`
--
ALTER TABLE `cadastro_funcionario`
  ADD PRIMARY KEY (`id_cadastro_func`);

--
-- Índices para tabela `carro`
--
ALTER TABLE `carro`
  ADD PRIMARY KEY (`idcarro`);

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `fk_idregistro_cliente` (`id_registro_cli`);

--
-- Índices para tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`idfunc`),
  ADD KEY `fk_id_cadastrofunc` (`id_cadastrofunc`);

--
-- Índices para tabela `gerente`
--
ALTER TABLE `gerente`
  ADD PRIMARY KEY (`idgerente`);

--
-- Índices para tabela `registrar_venda`
--
ALTER TABLE `registrar_venda`
  ADD PRIMARY KEY (`id_registro_venda`),
  ADD KEY `fk_idcliente_venda` (`id_cliente_venda`),
  ADD KEY `fk_idgerente_venda` (`id_gerente_venda`),
  ADD KEY `fk_idcarro_venda` (`id_carro_venda`),
  ADD KEY `fk_idfunc_venda` (`id_func_venda`);

--
-- Índices para tabela `registro_cliente`
--
ALTER TABLE `registro_cliente`
  ADD PRIMARY KEY (`id_registro_cliente`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `adicionar_carro`
--
ALTER TABLE `adicionar_carro`
  MODIFY `id_adicionar_carro` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cadastro_funcionario`
--
ALTER TABLE `cadastro_funcionario`
  MODIFY `id_cadastro_func` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `carro`
--
ALTER TABLE `carro`
  MODIFY `idcarro` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `idfunc` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `gerente`
--
ALTER TABLE `gerente`
  MODIFY `idgerente` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Id gerado por gerente cadastrado no sistema';

--
-- AUTO_INCREMENT de tabela `registrar_venda`
--
ALTER TABLE `registrar_venda`
  MODIFY `id_registro_venda` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `registro_cliente`
--
ALTER TABLE `registro_cliente`
  MODIFY `id_registro_cliente` int(10) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `adicionar_carro`
--
ALTER TABLE `adicionar_carro`
  ADD CONSTRAINT `fk_idcarro_adic` FOREIGN KEY (`id_carro_adicionado`) REFERENCES `carro` (`idcarro`),
  ADD CONSTRAINT `fk_idgerente_adic` FOREIGN KEY (`id_gerentequeadic`) REFERENCES `gerente` (`idgerente`);

--
-- Limitadores para a tabela `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_idregistro_cliente` FOREIGN KEY (`id_registro_cli`) REFERENCES `registro_cliente` (`id_registro_cliente`);

--
-- Limitadores para a tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `fk_id_cadastrofunc` FOREIGN KEY (`id_cadastrofunc`) REFERENCES `cadastro_funcionario` (`id_cadastro_func`);

--
-- Limitadores para a tabela `registrar_venda`
--
ALTER TABLE `registrar_venda`
  ADD CONSTRAINT `fk_idcarro_venda` FOREIGN KEY (`id_carro_venda`) REFERENCES `carro` (`idcarro`),
  ADD CONSTRAINT `fk_idcliente_venda` FOREIGN KEY (`id_cliente_venda`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `fk_idfunc_venda` FOREIGN KEY (`id_func_venda`) REFERENCES `funcionario` (`idfunc`),
  ADD CONSTRAINT `fk_idgerente_venda` FOREIGN KEY (`id_gerente_venda`) REFERENCES `gerente` (`idgerente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
