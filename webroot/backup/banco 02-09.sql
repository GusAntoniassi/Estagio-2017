-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 02-Set-2017 às 05:02
-- Versão do servidor: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recanto`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `baixa_produtos`
--

CREATE TABLE `baixa_produtos` (
  `id` int(11) NOT NULL,
  `data_baixa` date NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `lote_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Acionadores `baixa_produtos`
--
DELIMITER $$
CREATE TRIGGER `baixa_produto_e_zera_lote` AFTER INSERT ON `baixa_produtos` FOR EACH ROW BEGIN
	UPDATE lote SET qtde_estoque = 0
    WHERE id = NEW.lote_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidades`
--

CREATE TABLE `cidades` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `estado_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cidades`
--

INSERT INTO `cidades` (`id`, `nome`, `status`, `estado_id`) VALUES
(1, 'Umuarama', 1, 1),
(2, 'Perobal', 1, 1),
(3, 'Blumenau', 1, 2),
(4, 'Floripa', 1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `comandas`
--

CREATE TABLE `comandas` (
  `id` int(11) NOT NULL,
  `num_cartao` int(11) DEFAULT NULL COMMENT 'Número do cartão plástico recebido na entrada',
  `data_entrada` datetime NOT NULL,
  `data_saida` datetime DEFAULT NULL,
  `num_mesa` int(11) DEFAULT NULL,
  `encomenda` tinyint(1) NOT NULL,
  `data_hora_retirada` datetime DEFAULT NULL,
  `nome_retirar` varchar(80) DEFAULT NULL,
  `valor_liquido` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `descontos` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `valor_total` decimal(10,4) NOT NULL,
  `comentários` text,
  `funcionario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `data_compra` date NOT NULL,
  `valor_liquido` decimal(10,4) NOT NULL,
  `descontos` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `valor_total` decimal(10,4) NOT NULL,
  `comentarios` text,
  `status` tinyint(1) NOT NULL,
  `pedido_compra_id` int(11) DEFAULT NULL,
  `forma_pagamento_id` int(11) NOT NULL,
  `fornecedor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta_pagars`
--

CREATE TABLE `conta_pagars` (
  `id` int(11) NOT NULL,
  `descricao` varchar(80) NOT NULL,
  `valor` decimal(10,4) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `data_pagamento` datetime DEFAULT NULL,
  `pago` tinyint(1) NOT NULL,
  `num_parcelas` int(11) NOT NULL DEFAULT '1',
  `comentarios` text,
  `fornecedor_id` int(11) DEFAULT NULL,
  `compra_id` int(11) DEFAULT NULL,
  `forma_pagamento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta_recebers`
--

CREATE TABLE `conta_recebers` (
  `id` int(11) NOT NULL,
  `descricao` varchar(80) NOT NULL,
  `valor` decimal(10,4) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `data_recebimento` date DEFAULT NULL,
  `recebido` tinyint(1) NOT NULL,
  `comentarios` text,
  `pessoa_id` int(11) NOT NULL,
  `comanda_id` int(11) DEFAULT NULL,
  `forma_pagamento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estados`
--

CREATE TABLE `estados` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `sigla` char(2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `pais_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `estados`
--

INSERT INTO `estados` (`id`, `nome`, `sigla`, `status`, `pais_id`) VALUES
(1, 'Paraná', 'PR', 1, 1),
(2, 'Santa Catarina', 'SC', 1, 1),
(3, 'São Paulo', 'SP', 1, 1),
(4, 'Asunción', 'AS', 1, 2),
(5, 'Castillo', 'CS', 1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `forma_pagamentos`
--

CREATE TABLE `forma_pagamentos` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) DEFAULT NULL,
  `num_parcelas` int(11) NOT NULL DEFAULT '1',
  `dias_carencia_primeira_parcela` int(11) NOT NULL DEFAULT '0',
  `entrada` decimal(10,4) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `comentarios` text,
  `dia_semana_visita` tinyint(1) DEFAULT NULL COMMENT 'Número de 1 a 7 representando o dia da semana (segunda, terça, quarta, etc)',
  `pessoa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `fornecedores`
--

INSERT INTO `fornecedores` (`id`, `status`, `comentarios`, `dia_semana_visita`, `pessoa_id`) VALUES
(3, 1, 'Mais liso que quiabo', 1, 6),
(6, 0, 'Teste', 1, 11),
(7, 1, 'Representado pela Sophie que vem de Hilux', 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `horista` tinyint(1) NOT NULL,
  `valor_hora` decimal(10,4) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `pessoa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo_usuarios`
--

CREATE TABLE `grupo_usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `grupo_usuarios`
--

INSERT INTO `grupo_usuarios` (`id`, `nome`, `status`) VALUES
(3, 'Suporte', 1),
(4, 'Gerência', 1),
(5, 'Caixa', 1),
(6, 'Garçom', 1),
(8, 'Serviços Gerais', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_comandas`
--

CREATE TABLE `item_comandas` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `comanda_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor_unitario` decimal(10,4) DEFAULT NULL,
  `data_pedido` datetime NOT NULL,
  `entregue` tinyint(1) NOT NULL DEFAULT '0',
  `data_entrega` datetime DEFAULT NULL,
  `estornado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_compras`
--

CREATE TABLE `item_compras` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor_unitario` decimal(10,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_orcamentos`
--

CREATE TABLE `item_orcamentos` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `orcamento_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor_unitario` decimal(10,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_pedido_compras`
--

CREATE TABLE `item_pedido_compras` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `pedido_compra_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor_unitario` decimal(10,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lancamento_horas`
--

CREATE TABLE `lancamento_horas` (
  `id` int(11) NOT NULL,
  `horas_trabalhadas` int(11) NOT NULL,
  `valor_hora` decimal(10,4) NOT NULL,
  `valor_a_pagar` decimal(10,4) NOT NULL,
  `data_lancamento` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `funcionario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lotes`
--

CREATE TABLE `lotes` (
  `id` int(11) NOT NULL,
  `num_lote` varchar(255) NOT NULL,
  `qtde_estoque` int(11) NOT NULL,
  `data_vencimento` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `produto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `movimentacao_caixas`
--

CREATE TABLE `movimentacao_caixas` (
  `id` int(11) NOT NULL,
  `tipo_movimentacao` char(1) NOT NULL COMMENT '''P para pagamento R para recebimento''',
  `valor_liquido` decimal(10,4) NOT NULL,
  `descontos` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `valor_total` decimal(10,4) NOT NULL,
  `caixa_id` int(11) NOT NULL,
  `pagamento_id` int(11) DEFAULT NULL,
  `recebimento_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamentos`
--

CREATE TABLE `orcamentos` (
  `id` int(11) NOT NULL,
  `data_orcamento` date NOT NULL,
  `data_entrega` date DEFAULT NULL,
  `valor_total` decimal(10,4) NOT NULL,
  `condicoes_pagamento` text NOT NULL,
  `comentarios` text,
  `fornecedor_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `paises`
--

CREATE TABLE `paises` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `sigla` char(3) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `paises`
--

INSERT INTO `paises` (`id`, `nome`, `sigla`, `status`) VALUES
(1, 'Brasil', 'BRA', 1),
(2, 'Paraguay', 'PY', 1),
(5, 'Venezuela', 'VEN', 1),
(6, 'Argentina', 'ARG', 1),
(10, 'Uruguai', 'URU', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `parcela_conta_pagars`
--

CREATE TABLE `parcela_conta_pagars` (
  `id` int(11) NOT NULL,
  `valor` decimal(10,4) NOT NULL,
  `data_vencimento` date NOT NULL,
  `pago` tinyint(1) NOT NULL COMMENT 'Se foi pago ou não',
  `conta_pagar_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `parcela_conta_recebers`
--

CREATE TABLE `parcela_conta_recebers` (
  `id` int(11) NOT NULL,
  `valor` decimal(10,4) NOT NULL,
  `data_vencimento` date NOT NULL,
  `pago` tinyint(1) NOT NULL,
  `conta_receber_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido_compras`
--

CREATE TABLE `pedido_compras` (
  `id` int(11) NOT NULL,
  `data_pedido` date NOT NULL,
  `data_entrega` date DEFAULT NULL,
  `valor_liquido` decimal(10,4) NOT NULL,
  `descontos` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `valor_total` decimal(10,4) NOT NULL,
  `comentarios` text,
  `status` tinyint(1) NOT NULL,
  `orcamento_id` int(11) DEFAULT NULL,
  `forma_pagamento_id` int(11) NOT NULL,
  `fornecedor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoas`
--

CREATE TABLE `pessoas` (
  `id` int(11) NOT NULL,
  `tipo_pessoa` char(1) NOT NULL COMMENT 'F para física e J para jurídica',
  `nome_razaosocial` varchar(255) NOT NULL,
  `sobrenome_nomefantasia` varchar(80) NOT NULL,
  `cpfcnpj` varchar(18) NOT NULL,
  `rua` varchar(80) NOT NULL,
  `numero` varchar(10) DEFAULT 'S/N' COMMENT 'Pode ser "S/N", então tem que ser VARCHAR',
  `bairro` varchar(80) DEFAULT NULL,
  `cep` char(9) DEFAULT NULL,
  `telefone_1` varchar(20) NOT NULL,
  `telefone_2` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cidade_id` int(11) NOT NULL,
  `fornecedor_pertencente_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pessoas`
--

INSERT INTO `pessoas` (`id`, `tipo_pessoa`, `nome_razaosocial`, `sobrenome_nomefantasia`, `cpfcnpj`, `rua`, `numero`, `bairro`, `cep`, `telefone_1`, `telefone_2`, `email`, `cidade_id`, `fornecedor_pertencente_id`) VALUES
(1, 'F', 'Teste', 'teste', '097.190.519-30', 'reasdfs', '4355', 'Ria 4343', '87502-200', '44305614444', '14123120312', 'teste@gosdf.com', 1, NULL),
(5, 'F', 'Teste', 'Gus', '111.111.111-11', 'aaa', '111', '123123', '11111-111', '(12) 31231-2312', '(12) 3123-1231', '123@aaa.ca', 1, NULL),
(6, 'J', 'J MARTINS ATACADO', 'Supermercados Planalto', '76.361.807/0001-11', 'Avenida Paraná', '3321', 'Zona III', '87502-000', '(44) 30000-0000', '(44) 30000-0001', 'sac@planalto.com', 1, NULL),
(11, 'F', 'Fornecedor de Testes', 'Testando', '381.646.135-25', 'Rua Aricanduva', '', 'Zona II', '87502-200', '(44) 3056-1499', '(44) 3051-5112', 'Teste@teazra.csom', 1, NULL),
(12, 'F', 'Teste', 'aae', '269.184.617-29', 'Rua Maraba', '312', 'Zona I', '87501-100', '(44) 34031-4013', '(40) 32043-0402', 'sadfo@casda.com', 1, NULL),
(13, 'J', 'Lavínia e Sophie Comercio de Bebidas ME', 'Lavínia Sophie', '61.806.203/0001-64', 'Avenida Nossa Senhora da Paz', '454', 'Boqueirão', '81730-370', '(41) 3928-8225', '(41) 99977-0390', 'qualidade@laviniasophie.com.br', 2, NULL),
(14, 'F', 'Cauê', 'Levi Alves', '571.392.289-81', 'Rua Coronel Jacinto Ribeiro', '951', 'Ponto Novo', '49097-120', '(79) 2738-6117', '(79) 99122-8457', 'caue.levi.alves@eletrovip.com', 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `produto_acabado` tinyint(1) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `foto_dir` varchar(255) DEFAULT NULL,
  `reduz_estoque` tinyint(1) NOT NULL COMMENT 'Para o caso do passeio de trator',
  `possui_lote` tinyint(1) NOT NULL,
  `qtde_estoque` int(11) DEFAULT NULL,
  `preco` decimal(10,4) DEFAULT NULL,
  `custo` decimal(10,4) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `tipo_produto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Acionadores `produtos`
--
DELIMITER $$
CREATE TRIGGER `verifica_atributos_produto` BEFORE INSERT ON `produtos` FOR EACH ROW BEGIN
	/* Se está marcado que reduz estoque e não possui lote, o campo qtde_estoque passa a ser obrigatório */
	IF (NEW.reduz_estoque = 1 AND NEW.possui_lote = 0 AND NEW.qtde_estoque IS NULL) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Quantidade em estoque não pode ser NULL";
	/* Se está marcado que possui lote ou não rediz estoque, silenciosamente setar o valor da qtde_estoque para NULL */
	ELSEIF ((NEW.possui_lote = 1 OR NEW.reduz_estoque = 0) AND NEW.qtde_estoque IS NOT NULL) THEN
		SET NEW.qtde_estoque = NULL;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_produtos`
--

CREATE TABLE `tipo_produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `login` varchar(80) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `grupo_usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `login`, `senha`, `salt`, `status`, `grupo_usuario_id`) VALUES
(1, 'gus.antoniassi@gmail.com', '123456', 'fdiojdfiojaiosjd9WJD9ajida', 1, 3),
(2, 'kleparde@gmail.com', '123456', NULL, 1, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baixa_produtos`
--
ALTER TABLE `baixa_produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_descarte_lote1_idx` (`lote_id`);

--
-- Indexes for table `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cidades_estados1_idx` (`estado_id`);

--
-- Indexes for table `comandas`
--
ALTER TABLE `comandas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comandas_funcionarios1_idx` (`funcionario_id`);

--
-- Indexes for table `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compras_pedido_compras1_idx` (`pedido_compra_id`),
  ADD KEY `fk_compras_forma_pagamentos1_idx` (`forma_pagamento_id`),
  ADD KEY `fk_compras_fornecedores1_idx` (`fornecedor_id`);

--
-- Indexes for table `conta_pagars`
--
ALTER TABLE `conta_pagars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contas_a_pagars_fornecedores1_idx` (`fornecedor_id`),
  ADD KEY `fk_contas_a_pagars_compras1_idx` (`compra_id`),
  ADD KEY `fk_conta_pagars_forma_pagamentos1_idx` (`forma_pagamento_id`);

--
-- Indexes for table `conta_recebers`
--
ALTER TABLE `conta_recebers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contas_a_recebers_comandas1_idx` (`comanda_id`),
  ADD KEY `fk_conta_recebers_forma_pagamentos1_idx` (`forma_pagamento_id`),
  ADD KEY `fk_conta_recebers_pessoas1_idx` (`pessoa_id`);

--
-- Indexes for table `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_estados_paises1_idx` (`pais_id`);

--
-- Indexes for table `forma_pagamentos`
--
ALTER TABLE `forma_pagamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fornecedor_pessoas1_idx` (`pessoa_id`);

--
-- Indexes for table `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_funcionario_pessoas1_idx` (`pessoa_id`);

--
-- Indexes for table `grupo_usuarios`
--
ALTER TABLE `grupo_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_comandas`
--
ALTER TABLE `item_comandas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_item_comandas_produtos1_idx` (`produto_id`),
  ADD KEY `fk_item_comandas_comandas1_idx` (`comanda_id`);

--
-- Indexes for table `item_compras`
--
ALTER TABLE `item_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compras_produtos_compras1_idx` (`compra_id`),
  ADD KEY `fk_compras_produtos_produtos1_idx` (`produto_id`);

--
-- Indexes for table `item_orcamentos`
--
ALTER TABLE `item_orcamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produtos_has_orcamentos_orcamentos1_idx` (`orcamento_id`),
  ADD KEY `fk_produtos_has_orcamentos_produtos1_idx` (`produto_id`);

--
-- Indexes for table `item_pedido_compras`
--
ALTER TABLE `item_pedido_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedido_compras_produtos_pedido_compras1_idx` (`pedido_compra_id`),
  ADD KEY `fk_pedido_compras_produtos_produtos1_idx` (`produto_id`);

--
-- Indexes for table `lancamento_horas`
--
ALTER TABLE `lancamento_horas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_calculo_horista_funcionarios1_idx` (`funcionario_id`);

--
-- Indexes for table `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lote_produtos1_idx` (`produto_id`);

--
-- Indexes for table `movimentacao_caixas`
--
ALTER TABLE `movimentacao_caixas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_movimentacao_caixas_caixa1_idx` (`caixa_id`),
  ADD KEY `fk_movimentacao_caixas_pagamento1_idx` (`pagamento_id`),
  ADD KEY `fk_movimentacao_caixas_recebimento1_idx` (`recebimento_id`);

--
-- Indexes for table `orcamentos`
--
ALTER TABLE `orcamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orcamentos_fornecedores1_idx` (`fornecedor_id`);

--
-- Indexes for table `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parcela_conta_pagars`
--
ALTER TABLE `parcela_conta_pagars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_parcela_conta_pagars_conta_pagars1_idx` (`conta_pagar_id`);

--
-- Indexes for table `parcela_conta_recebers`
--
ALTER TABLE `parcela_conta_recebers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_parcela_conta_recebers_conta_recebers1_idx` (`conta_receber_id`);

--
-- Indexes for table `pedido_compras`
--
ALTER TABLE `pedido_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedido_compras_orcamentos1_idx` (`orcamento_id`),
  ADD KEY `fk_pedido_compras_forma_pagamentos1_idx` (`forma_pagamento_id`),
  ADD KEY `fk_pedido_compras_fornecedores1_idx` (`fornecedor_id`);

--
-- Indexes for table `pessoas`
--
ALTER TABLE `pessoas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpfcnpj_UNIQUE` (`cpfcnpj`),
  ADD KEY `fk_pessoas_cidades1_idx` (`cidade_id`),
  ADD KEY `fk_pessoas_fornecedores1_idx` (`fornecedor_pertencente_id`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produtos_tipo_produtos1_idx` (`tipo_produto_id`);

--
-- Indexes for table `tipo_produtos`
--
ALTER TABLE `tipo_produtos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login_UNIQUE` (`login`),
  ADD KEY `fk_usuarios_grupo_usuarios1_idx` (`grupo_usuario_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baixa_produtos`
--
ALTER TABLE `baixa_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cidades`
--
ALTER TABLE `cidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `comandas`
--
ALTER TABLE `comandas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conta_pagars`
--
ALTER TABLE `conta_pagars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conta_recebers`
--
ALTER TABLE `conta_recebers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `forma_pagamentos`
--
ALTER TABLE `forma_pagamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `grupo_usuarios`
--
ALTER TABLE `grupo_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `item_comandas`
--
ALTER TABLE `item_comandas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item_compras`
--
ALTER TABLE `item_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item_orcamentos`
--
ALTER TABLE `item_orcamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item_pedido_compras`
--
ALTER TABLE `item_pedido_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lancamento_horas`
--
ALTER TABLE `lancamento_horas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lotes`
--
ALTER TABLE `lotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `movimentacao_caixas`
--
ALTER TABLE `movimentacao_caixas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orcamentos`
--
ALTER TABLE `orcamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `paises`
--
ALTER TABLE `paises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `parcela_conta_pagars`
--
ALTER TABLE `parcela_conta_pagars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `parcela_conta_recebers`
--
ALTER TABLE `parcela_conta_recebers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pedido_compras`
--
ALTER TABLE `pedido_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pessoas`
--
ALTER TABLE `pessoas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tipo_produtos`
--
ALTER TABLE `tipo_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `baixa_produtos`
--
ALTER TABLE `baixa_produtos`
  ADD CONSTRAINT `fk_descarte_lote1` FOREIGN KEY (`lote_id`) REFERENCES `lotes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `cidades`
--
ALTER TABLE `cidades`
  ADD CONSTRAINT `fk_cidades_estados1` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `comandas`
--
ALTER TABLE `comandas`
  ADD CONSTRAINT `fk_comandas_funcionarios1` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `fk_compras_forma_pagamentos1` FOREIGN KEY (`forma_pagamento_id`) REFERENCES `forma_pagamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compras_fornecedores1` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compras_pedido_compras1` FOREIGN KEY (`pedido_compra_id`) REFERENCES `pedido_compras` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `conta_pagars`
--
ALTER TABLE `conta_pagars`
  ADD CONSTRAINT `fk_conta_pagars_forma_pagamentos1` FOREIGN KEY (`forma_pagamento_id`) REFERENCES `forma_pagamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_contas_a_pagars_compras1` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_contas_a_pagars_fornecedores1` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `conta_recebers`
--
ALTER TABLE `conta_recebers`
  ADD CONSTRAINT `fk_conta_recebers_forma_pagamentos1` FOREIGN KEY (`forma_pagamento_id`) REFERENCES `forma_pagamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_conta_recebers_pessoas1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_contas_a_recebers_comandas1` FOREIGN KEY (`comanda_id`) REFERENCES `comandas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `estados`
--
ALTER TABLE `estados`
  ADD CONSTRAINT `fk_estados_paises1` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD CONSTRAINT `fk_fornecedor_pessoas1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD CONSTRAINT `fk_funcionario_pessoas1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `item_comandas`
--
ALTER TABLE `item_comandas`
  ADD CONSTRAINT `fk_item_comandas_comandas1` FOREIGN KEY (`comanda_id`) REFERENCES `comandas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_item_comandas_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `item_compras`
--
ALTER TABLE `item_compras`
  ADD CONSTRAINT `fk_compras_produtos_compras1` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compras_produtos_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `item_orcamentos`
--
ALTER TABLE `item_orcamentos`
  ADD CONSTRAINT `fk_produtos_has_orcamentos_orcamentos1` FOREIGN KEY (`orcamento_id`) REFERENCES `orcamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_produtos_has_orcamentos_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `item_pedido_compras`
--
ALTER TABLE `item_pedido_compras`
  ADD CONSTRAINT `fk_pedido_compras_produtos_pedido_compras1` FOREIGN KEY (`pedido_compra_id`) REFERENCES `pedido_compras` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_compras_produtos_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `lancamento_horas`
--
ALTER TABLE `lancamento_horas`
  ADD CONSTRAINT `fk_calculo_horista_funcionarios1` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `lotes`
--
ALTER TABLE `lotes`
  ADD CONSTRAINT `fk_lote_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `movimentacao_caixas`
--
ALTER TABLE `movimentacao_caixas`
  ADD CONSTRAINT `fk_movimentacao_caixas_caixa1` FOREIGN KEY (`caixa_id`) REFERENCES `caixas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_movimentacao_caixas_pagamento1` FOREIGN KEY (`pagamento_id`) REFERENCES `pagamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_movimentacao_caixas_recebimento1` FOREIGN KEY (`recebimento_id`) REFERENCES `recebimentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `parcela_conta_pagars`
--
ALTER TABLE `parcela_conta_pagars`
  ADD CONSTRAINT `fk_parcela_conta_pagars_conta_pagars1` FOREIGN KEY (`conta_pagar_id`) REFERENCES `conta_pagars` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `parcela_conta_recebers`
--
ALTER TABLE `parcela_conta_recebers`
  ADD CONSTRAINT `fk_parcela_conta_recebers_conta_recebers1` FOREIGN KEY (`conta_receber_id`) REFERENCES `conta_recebers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pedido_compras`
--
ALTER TABLE `pedido_compras`
  ADD CONSTRAINT `fk_pedido_compras_forma_pagamentos1` FOREIGN KEY (`forma_pagamento_id`) REFERENCES `forma_pagamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_compras_fornecedores1` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_compras_orcamentos1` FOREIGN KEY (`orcamento_id`) REFERENCES `orcamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pessoas`
--
ALTER TABLE `pessoas`
  ADD CONSTRAINT `fk_pessoas_cidades1` FOREIGN KEY (`cidade_id`) REFERENCES `cidades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pessoas_fornecedores1` FOREIGN KEY (`fornecedor_pertencente_id`) REFERENCES `fornecedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produtos_tipo_produtos1` FOREIGN KEY (`tipo_produto_id`) REFERENCES `tipo_produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_grupo_usuarios1` FOREIGN KEY (`grupo_usuario_id`) REFERENCES `grupo_usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
