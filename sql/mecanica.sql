-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/08/2023 às 10:18
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mecanica`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `manutencoes`
--

CREATE TABLE `manutencoes` (
  `id` int(11) NOT NULL,
  `placa` varchar(10) NOT NULL,
  `estado_do_veiculo` varchar(120) NOT NULL,
  `data_manutencao` date NOT NULL,
  `previsaoTermino` date NOT NULL,
  `tipo_servico` varchar(200) NOT NULL,
  `observacoes` varchar(500) NOT NULL,
  `custo` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `manutencoes`
--

INSERT INTO `manutencoes` (`id`, `placa`, `estado_do_veiculo`, `data_manutencao`, `previsaoTermino`, `tipo_servico`, `observacoes`, `custo`) VALUES
(160, 'EFG4H56', 'Em manutenção', '2023-08-20', '2023-08-20', 'Troca de pneus', 'Um pneu careca.\r\nCortesia por ser cliente recorrente só custo do pneu.', 243.50),
(161, 'IJK7L89', 'Entrega agendada para o dia: 2023-08-22', '2023-08-22', '0000-00-00', '', '', 0.00),
(162, 'DCB3A21', 'Entrega agendada para o dia: 2023-08-29', '2023-08-29', '0000-00-00', '', '', 0.00),
(163, 'LPV7U24', 'Manutenção concluída', '2023-08-20', '2023-08-20', 'Troca de óleo', 'Troca de óleo apenas', 240.00),
(164, 'UVW7X89', 'Em manutenção', '2023-08-20', '2023-08-23', 'Troca de bateria', 'Bateria não funciona mais.\r\nNecessário troca.', 329.00),
(170, 'ACK8Z76', 'Entregue ao proprietario', '2023-08-20', '0000-00-00', '', '', 0.00),
(171, 'ACK8Z76', 'Entregue ao proprietario', '2023-08-20', '2023-08-20', 'Troca de óleo', 'troca de oleo velho', 78.00),
(172, 'ACK8Z76', 'Entrega agendada para o dia: 2023-08-20', '2023-08-20', '0000-00-00', '', '', 0.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `id` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `data_notificacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `lida` tinyint(1) NOT NULL DEFAULT 0,
  `usuario_id` int(11) NOT NULL,
  `manutencaoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `notificacoes`
--

INSERT INTO `notificacoes` (`id`, `mensagem`, `data_notificacao`, `lida`, `usuario_id`, `manutencaoId`) VALUES
(76, 'Agendamento de manutenção realizado para o veículo de placa: EFG4H56', '2023-08-20 02:58:30', 0, 32, 160),
(77, 'Agendamento de manutenção realizado para o veículo de placa: IJK7L89', '2023-08-20 02:58:41', 0, 32, 161),
(78, 'Agendamento de manutenção realizado para o veículo de placa: DCB3A21', '2023-08-20 03:01:43', 0, 29, 162),
(79, 'Agendamento de manutenção realizado para o veículo de placa: LPV7U24', '2023-08-20 03:01:51', 0, 29, 163),
(80, 'Agendamento de manutenção realizado para o veículo de placa: UVW7X89', '2023-08-20 03:04:42', 0, 30, 164),
(81, 'Manutenção atualizada referente ao veículo de placa: EFG4H56', '2023-08-20 03:06:24', 0, 32, 160),
(82, 'Manutenção atualizada referente ao veículo de placa: EFG4H56', '2023-08-20 03:07:15', 0, 32, 160),
(83, 'Manutenção atualizada referente ao veículo de placa: UVW7X89', '2023-08-20 03:07:55', 0, 30, 164),
(84, 'Manutenção atualizada referente ao veículo de placa: UVW7X89', '2023-08-20 03:09:06', 0, 30, 164),
(85, 'Manutenção atualizada referente ao veículo de placa: LPV7U24', '2023-08-20 03:09:51', 0, 29, 163),
(86, 'Manutenção atualizada referente ao veículo de placa: EFG4H56', '2023-08-20 03:11:17', 0, 32, 160),
(87, 'Manutenção finalizada referente ao veículo de placa: LPV7U24', '2023-08-20 03:11:36', 0, 29, 163),
(101, 'Agendamento de manutenção realizado para o veículo de placa: ACK8Z76', '2023-08-20 04:27:13', 1, 38, 170),
(102, 'Cancelamento de agendamento de manutenção realizado para o veículo de placa: ACK8Z76', '2023-08-20 04:27:48', 1, 38, 170),
(103, 'Agendamento de manutenção realizado para o veículo de placa: ACK8Z76', '2023-08-20 04:28:00', 1, 38, 171),
(104, 'Manutenção atualizada referente ao veículo de placa: ACK8Z76', '2023-08-20 04:28:53', 1, 38, 171),
(105, 'Manutenção finalizada referente ao veículo de placa: ACK8Z76', '2023-08-20 04:29:14', 1, 38, 171),
(106, 'Entrega de veículo ao proprietário. Veículo de placa: ACK8Z76', '2023-08-20 04:30:16', 1, 38, 171),
(107, 'Agendamento de manutenção realizado para o veículo de placa: ACK8Z76', '2023-08-20 04:31:40', 1, 38, 172);

-- --------------------------------------------------------

--
-- Estrutura para tabela `proprietarios`
--

CREATE TABLE `proprietarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `senha` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `proprietarios`
--

INSERT INTO `proprietarios` (`id`, `nome`, `email`, `telefone`, `senha`) VALUES
(29, 'João Da Silva', 'joao@example.com', '11223344556', '20eabe5d64b0e216796e834f52d61fd0b70332fc'),
(30, 'Maria Santos', 'maria@example.com', '11987654321', 'bfe54caa6d483cc3887dce9d1b8eb91408f1ea7a'),
(31, 'Pedro Oliveira', 'pedro@example.com', '11335577991', '2fb5e13419fc89246865e7a324f476ec624e8740'),
(32, 'Ana Souza', 'ana@example.com', '11778899008', 'cbfdac6008f9cab4083784cbd1874f76618d2a97'),
(38, 'Patrick', 'patrick@gmail.com', '33994324963', '7c4a8d09ca3762af61e59520943dc26494f8941b');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `cpf`, `senha`) VALUES
(1, 'Admin', '02346176087', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

-- --------------------------------------------------------

--
-- Estrutura para tabela `veiculos`
--

CREATE TABLE `veiculos` (
  `id` int(11) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `ano` int(11) NOT NULL,
  `placa` varchar(10) NOT NULL,
  `proprietario_id` int(11) NOT NULL,
  `estado_do_veiculo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `veiculos`
--

INSERT INTO `veiculos` (`id`, `marca`, `modelo`, `ano`, `placa`, `proprietario_id`, `estado_do_veiculo`) VALUES
(52, 'Ford', 'Fiesta', 2020, 'ABC1D23', 32, 'Com proprietário'),
(53, 'Chevrolet', 'Onyx', 2022, 'EFG4H56', 32, 'Em manutenção'),
(54, 'Volkswagen', 'Gol', 2019, 'IJK7L89', 32, 'Entrega agendada para o dia: 2023-08-22'),
(55, 'Toyota', 'Corolla', 2020, 'DCB3A21', 29, 'Entrega agendada para o dia: 2023-08-29'),
(56, 'Honda', 'Civic', 2011, 'EZH9F50', 29, 'Com proprietário'),
(57, 'Ford', 'Focus', 2014, 'LPV7U24', 29, 'Manutenção concluída'),
(58, 'Volkswagen', 'Golf', 2008, 'QRS4T56', 30, 'Com proprietário'),
(59, 'Nissan', 'Sentra', 2015, 'UVW7X89', 30, 'Em manutenção'),
(60, 'Fiat', 'Uno', 2001, 'MNO1P23', 30, 'Com proprietário'),
(65, 'Honda', 'Civic', 2020, 'ACK8Z76', 38, 'Entrega agendada para o dia: 2023-08-20'),
(66, 'Fiat', 'Uno', 2005, 'ACK8Z70', 38, 'Com proprietário');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `manutencoes`
--
ALTER TABLE `manutencoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_placa_veiculo` (`placa`);

--
-- Índices de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notificacoes_ibfk_1` (`usuario_id`),
  ADD KEY `notificacoes_imfk_2` (`manutencaoId`);

--
-- Índices de tabela `proprietarios`
--
ALTER TABLE `proprietarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emailUnico` (`email`),
  ADD UNIQUE KEY `telefoneUnico` (`telefone`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `veiculos`
--
ALTER TABLE `veiculos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `placa_veiculo` (`placa`),
  ADD KEY `fk_veiculos_proprietario` (`proprietario_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `manutencoes`
--
ALTER TABLE `manutencoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de tabela `proprietarios`
--
ALTER TABLE `proprietarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `veiculos`
--
ALTER TABLE `veiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `manutencoes`
--
ALTER TABLE `manutencoes`
  ADD CONSTRAINT `fk_placa_veiculo` FOREIGN KEY (`placa`) REFERENCES `veiculos` (`placa`) ON DELETE NO ACTION;

--
-- Restrições para tabelas `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD CONSTRAINT `notificacoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `proprietarios` (`id`),
  ADD CONSTRAINT `notificacoes_imfk_2` FOREIGN KEY (`manutencaoId`) REFERENCES `manutencoes` (`id`);

--
-- Restrições para tabelas `veiculos`
--
ALTER TABLE `veiculos`
  ADD CONSTRAINT `fk_veiculos_proprietario` FOREIGN KEY (`proprietario_id`) REFERENCES `proprietarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
