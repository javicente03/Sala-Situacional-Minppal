-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-05-2023 a las 08:33:41
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `minppal_sala_situacional_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cnae_carga`
--

CREATE TABLE `cnae_carga` (
  `id_cnae_carga` int(11) NOT NULL,
  `cnae_por_municipio_id_cnae_carga` int(11) DEFAULT NULL,
  `matricula_atendida_cnae_carga` int(11) NOT NULL,
  `instituciones_atendidas_cnae_carga` int(11) NOT NULL,
  `proteina_despachada_cnae_carga` decimal(20,2) NOT NULL,
  `claps_despachados_cnae_carga` int(11) NOT NULL,
  `fruta_despachada_cnae_carga` decimal(20,2) NOT NULL,
  `fecha_entrega_cnae_carga` date DEFAULT NULL,
  `fecha_creacion_cnae_carga` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cnae_por_mes`
--

CREATE TABLE `cnae_por_mes` (
  `id_cnae_por_mes` int(11) NOT NULL,
  `fecha_inicio_cnae_por_mes` date DEFAULT NULL,
  `fecha_fin_cnae_por_mes` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cnae_por_mes`
--

INSERT INTO `cnae_por_mes` (`id_cnae_por_mes`, `fecha_inicio_cnae_por_mes`, `fecha_fin_cnae_por_mes`) VALUES
(15, '2023-05-01', '2023-05-31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cnae_por_municipio`
--

CREATE TABLE `cnae_por_municipio` (
  `id_cnae_por_municipio` int(11) NOT NULL,
  `municipio_id_cnae_por_municipio` int(11) DEFAULT NULL,
  `mes_id_cnae_por_municipio` int(11) DEFAULT NULL,
  `proteina_asignada_cnae_por_municipio` decimal(20,2) NOT NULL,
  `clap_asignados_cnae_por_municipio` int(11) NOT NULL,
  `fruta_asignada_cnae_por_municipio` decimal(20,2) NOT NULL,
  `instituciones_cnae_por_municipio` int(11) NOT NULL,
  `matricula_cnae_por_municipio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cnae_por_municipio`
--

INSERT INTO `cnae_por_municipio` (`id_cnae_por_municipio`, `municipio_id_cnae_por_municipio`, `mes_id_cnae_por_municipio`, `proteina_asignada_cnae_por_municipio`, `clap_asignados_cnae_por_municipio`, `fruta_asignada_cnae_por_municipio`, `instituciones_cnae_por_municipio`, `matricula_cnae_por_municipio`) VALUES
(151, 2, 15, '0.00', 0, '0.00', 0, 0),
(152, 3, 15, '0.00', 0, '0.00', 0, 0),
(153, 4, 15, '0.00', 0, '0.00', 0, 0),
(154, 5, 15, '0.00', 0, '0.00', 0, 0),
(155, 6, 15, '28.00', 10, '120.23', 1020, 201),
(156, 7, 15, '40.20', 0, '0.00', 0, 420),
(157, 8, 15, '0.00', 0, '0.00', 0, 0),
(158, 9, 15, '0.00', 0, '0.00', 0, 0),
(159, 10, 15, '0.00', 0, '0.00', 0, 0),
(160, 11, 15, '0.00', 0, '0.00', 0, 0),
(161, 12, 15, '0.00', 0, '0.00', 0, 0),
(162, 13, 15, '0.00', 0, '0.00', 0, 0),
(163, 14, 15, '0.00', 0, '0.00', 0, 0),
(164, 15, 15, '0.00', 0, '0.00', 0, 0),
(165, 16, 15, '0.00', 0, '0.00', 0, 0),
(166, 17, 15, '0.00', 0, '0.00', 0, 0),
(167, 18, 15, '0.00', 0, '0.00', 0, 0),
(168, 19, 15, '0.00', 0, '0.00', 0, 0),
(169, 20, 15, '0.00', 0, '0.00', 0, 0),
(170, 21, 15, '0.00', 0, '0.00', 0, 0),
(171, 22, 15, '0.00', 0, '0.00', 0, 0),
(172, 23, 15, '0.00', 0, '0.00', 0, 0),
(173, 24, 15, '0.00', 0, '0.00', 0, 0),
(174, 25, 15, '0.00', 0, '0.00', 0, 0),
(175, 26, 15, '0.00', 0, '0.00', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companies`
--

CREATE TABLE `companies` (
  `id_company` int(11) NOT NULL,
  `name_company` text NOT NULL,
  `mision_company` text NOT NULL,
  `vision_company` text NOT NULL,
  `logo_company` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `companies`
--

INSERT INTO `companies` (`id_company`, `name_company`, `mision_company`, `vision_company`, `logo_company`) VALUES
(2, 'Instituto Nacional de Nutrición (INN)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'media/companies/logos/INN editado.png'),
(3, 'Comités Locales de Abastecimiento y Producción (CLAP)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'media/companies/logos/CLAP.png'),
(4, 'Superintendencia Nacional de Gestión Agroalimentaria (Sunagro)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'media/companies/logos/SUNAGRO.png'),
(5, 'Mercado de Alimentos MERCAL', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'media/companies/logos/MERCAL.png'),
(6, 'Productora y Distribuidora Venezolana de Alimentos (PDVAL)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'media/companies/logos/PDVAL.png'),
(7, 'Fundación Programa de Alimentos Estratégicos (FUNDAPROAL)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'media/companies/logos/FUNDAPROAL.png'),
(8, 'EPS JOSEFA CAMEJO', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'media/companies/logos/EPS JOSEFA CAMEJO.png'),
(9, 'La Corporación Nacional de Alimentación Escolar (CNAE)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'media/companies/logos/CNAE.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id_municipio` int(11) NOT NULL,
  `name_municipio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id_municipio`, `name_municipio`) VALUES
(2, 'Acosta'),
(3, 'Bolívar'),
(4, 'Buchivacoa'),
(5, 'Cacique Manaure'),
(6, 'Carirubana'),
(7, 'Colina'),
(8, 'Dabajuro'),
(9, 'Democracia'),
(10, 'Falcón'),
(11, 'Federación'),
(12, 'Jacura'),
(13, 'Los Taques'),
(14, 'Mauroa'),
(15, 'Miranda'),
(16, 'Monseñor Iturriza'),
(17, 'Palmasola'),
(18, 'Petit'),
(19, 'Píritu'),
(20, 'San Francisco'),
(21, 'Silva'),
(22, 'Sucre'),
(23, 'Tocópero'),
(24, 'Unión'),
(25, 'Urumaco'),
(26, 'Zamora');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `name_user` text DEFAULT NULL,
  `email_user` text NOT NULL,
  `password_user` text NOT NULL,
  `role_user` varchar(20) NOT NULL DEFAULT 'reader',
  `active_user` tinyint(4) NOT NULL DEFAULT 1,
  `createdAt_user` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt_user` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `name_user`, `email_user`, `password_user`, `role_user`, `active_user`, `createdAt_user`, `updatedAt_user`) VALUES
(1, 'Javier Gerardo 2', 'javicentego@gmail.com', '$2y$10$2w1D/QkaCGL6l60kBD5RduZRou.T.bfbSpnB1.nbh5LfYFA/ngXrm', 'admin', 1, '2023-04-02 18:21:12', '2023-04-02 18:21:12'),
(2, 'Milimar Cumare', 'milimarjose@gmail.com', '$2y$10$2w1D/QkaCGL6l60kBD5RduZRou.T.bfbSpnB1.nbh5LfYFA/ngXrm', 'reader', 1, '2023-04-11 12:30:35', '2023-04-11 12:30:35'),
(3, 'Maria Cumare', 'mariacumare@gmail.com', '$2y$10$2w1D/QkaCGL6l60kBD5RduZRou.T.bfbSpnB1.nbh5LfYFA/ngXrm', 'reader', 1, '2023-04-12 13:56:37', '2023-04-12 13:56:37'),
(5, 'Javier', 'gabriel@gmail.com', '$2y$10$XoMvdO4Al.pwZakAAptU5eBDrRSNyONDjhQnqk4zH9.kF.my2NgO6', 'admin', 1, '2023-04-12 17:54:58', '2023-04-12 17:54:58'),
(6, 'Erick Colina editadooo', 'erickeditado@gmail.com', '$2y$10$hnj8nRW9d4tgZtLkje8TvO8qneY/F3I8OsklyWJs4bfwDodkczymu', 'admin', 1, '2023-04-12 22:56:13', '2023-04-12 22:56:13'),
(7, 'aaa', 'xddd@gmail.com', '$2y$10$.13h3n/I0YoIYr/B84lRV.tAbawRaTVzM8hNehJXvwlDKX3HQVynG', 'reader', 1, '2023-05-27 14:56:36', '2023-05-27 14:56:36');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cnae_carga`
--
ALTER TABLE `cnae_carga`
  ADD PRIMARY KEY (`id_cnae_carga`),
  ADD KEY `fk_cnae_por_mes` (`cnae_por_municipio_id_cnae_carga`);

--
-- Indices de la tabla `cnae_por_mes`
--
ALTER TABLE `cnae_por_mes`
  ADD PRIMARY KEY (`id_cnae_por_mes`);

--
-- Indices de la tabla `cnae_por_municipio`
--
ALTER TABLE `cnae_por_municipio`
  ADD PRIMARY KEY (`id_cnae_por_municipio`),
  ADD KEY `fk_municipio` (`municipio_id_cnae_por_municipio`),
  ADD KEY `fk_cnae_por_mes` (`mes_id_cnae_por_municipio`);

--
-- Indices de la tabla `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id_company`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id_municipio`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cnae_carga`
--
ALTER TABLE `cnae_carga`
  MODIFY `id_cnae_carga` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cnae_por_mes`
--
ALTER TABLE `cnae_por_mes`
  MODIFY `id_cnae_por_mes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `cnae_por_municipio`
--
ALTER TABLE `cnae_por_municipio`
  MODIFY `id_cnae_por_municipio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `id_company` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id_municipio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cnae_carga`
--
ALTER TABLE `cnae_carga`
  ADD CONSTRAINT `cnae_carga_ibfk_1` FOREIGN KEY (`cnae_por_municipio_id_cnae_carga`) REFERENCES `cnae_por_municipio` (`id_cnae_por_municipio`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cnae_por_municipio`
--
ALTER TABLE `cnae_por_municipio`
  ADD CONSTRAINT `cnae_por_municipio_ibfk_1` FOREIGN KEY (`municipio_id_cnae_por_municipio`) REFERENCES `municipios` (`id_municipio`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `cnae_por_municipio_ibfk_2` FOREIGN KEY (`mes_id_cnae_por_municipio`) REFERENCES `cnae_por_mes` (`id_cnae_por_mes`) ON DELETE SET NULL ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
