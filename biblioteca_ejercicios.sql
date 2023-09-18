-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 02, 2023 at 10:27 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `biblioteca_ejercicios`
--

-- --------------------------------------------------------

--
-- Table structure for table `articulos`
--

CREATE TABLE `articulos` (
  `id` int(11) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `grupo_muscular_id` int(11) DEFAULT NULL,
  `grupo_muscular` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articulos`
--

INSERT INTO `articulos` (`id`, `titulo`, `contenido`, `fecha`, `grupo_muscular_id`, `grupo_muscular`) VALUES
(18, 'Press Banca', 'Press con barra apollado en banco.', '2023-04-22 19:45:22', 1, ''),
(19, 'Aperturas Inclinadas', 'ASDasdASD', '2023-04-23 09:42:13', 1, ''),
(20, 'Press Inclinado en maquina', 'asdfasdfasdf', '2023-04-23 09:42:25', 1, ''),
(21, 'Fondos para pectoral', 'asdfasdfasdf', '2023-04-23 09:42:35', 1, ''),
(27, 'Sentadilla Hack', 'Montarse en la maquina y subir y bajar generando flexion de rodilla.', '2023-05-02 20:18:48', 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `grupos_musculares`
--

CREATE TABLE `grupos_musculares` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grupos_musculares`
--

INSERT INTO `grupos_musculares` (`id`, `nombre`) VALUES
(1, 'Pecho'),
(2, 'Espalda'),
(3, 'Pierna'),
(4, 'Hombro'),
(5, 'Triceps'),
(6, 'Biceps'),
(7, 'Abdomen');

-- --------------------------------------------------------

--
-- Table structure for table `rutinas_ejercicios`
--

CREATE TABLE `rutinas_ejercicios` (
  `id` int(11) UNSIGNED NOT NULL,
  `rutinas_personalizadas_id` int(11) DEFAULT NULL,
  `articulos_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rutinas_ejercicios`
--

INSERT INTO `rutinas_ejercicios` (`id`, `rutinas_personalizadas_id`, `articulos_id`) VALUES
(82, 25, 18),
(83, 25, 19),
(84, 25, 20),
(85, 26, 18),
(86, 26, 19),
(87, 26, 21),
(89, 27, 18),
(90, 27, 19),
(91, 27, 21),
(92, 28, 18),
(93, 28, 19),
(94, 28, 20),
(95, 29, 18),
(96, 29, 19),
(97, 29, 21),
(98, 29, 27);

-- --------------------------------------------------------

--
-- Table structure for table `rutinas_personalizadas`
--

CREATE TABLE `rutinas_personalizadas` (
  `id` int(11) NOT NULL,
  `usuarios_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rutinas_personalizadas`
--

INSERT INTO `rutinas_personalizadas` (`id`, `usuarios_id`, `nombre`, `descripcion`) VALUES
(25, 9, 'Rutina 12', NULL),
(26, 9, 'Rutina ILERNA 1', NULL),
(27, 9, 'Rutina ILERNA 1', NULL),
(28, 9, 'Rutina ILERNA 1', NULL),
(29, 9, 'Rutina ILERNA 1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tipo_usuario` enum('invitado','registrado','administrador') NOT NULL DEFAULT 'registrado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `contrasena`, `email`, `tipo_usuario`) VALUES
(9, 'Admin', '$2y$10$DLCHSr1RMff2DEVvyvwr7eYnM/pGxa.W9eZGXXj41XjEtNSlquJWS', 'administrador@gmail.com', 'administrador'),
(10, 'Alumno1', '$2y$10$7eDy829r0Z34wZWZzZWAWeLXkvj9NiCU6ZuYBtkQ4VyXMsCGz6S9K', 'alumno1@ilerna.com', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grupo_muscular_id` (`grupo_muscular_id`);

--
-- Indexes for table `grupos_musculares`
--
ALTER TABLE `grupos_musculares`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rutinas_ejercicios`
--
ALTER TABLE `rutinas_ejercicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rutinas_personalizadas_id` (`rutinas_personalizadas_id`),
  ADD KEY `articulos_id` (`articulos_id`);

--
-- Indexes for table `rutinas_personalizadas`
--
ALTER TABLE `rutinas_personalizadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarios_id` (`usuarios_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `grupos_musculares`
--
ALTER TABLE `grupos_musculares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rutinas_ejercicios`
--
ALTER TABLE `rutinas_ejercicios`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `rutinas_personalizadas`
--
ALTER TABLE `rutinas_personalizadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`grupo_muscular_id`) REFERENCES `grupos_musculares` (`id`);

--
-- Constraints for table `rutinas_ejercicios`
--
ALTER TABLE `rutinas_ejercicios`
  ADD CONSTRAINT `rutinas_ejercicios_ibfk_1` FOREIGN KEY (`rutinas_personalizadas_id`) REFERENCES `rutinas_personalizadas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rutinas_ejercicios_ibfk_2` FOREIGN KEY (`articulos_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rutinas_personalizadas`
--
ALTER TABLE `rutinas_personalizadas`
  ADD CONSTRAINT `rutinas_personalizadas_ibfk_1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
