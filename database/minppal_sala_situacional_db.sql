-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2023 a las 07:27:00
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
-- Estructura de tabla para la tabla `clap_carga`
--

CREATE TABLE `clap_carga` (
  `id_clap_carga` int(11) NOT NULL,
  `clap_por_municipio_id` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `nota` longtext NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clap_carga`
--

INSERT INTO `clap_carga` (`id_clap_carga`, `clap_por_municipio_id`, `cantidad`, `nota`, `created_at`, `user_id`) VALUES
(1, 24, 120, '', '2023-06-11', NULL),
(2, 5, 30, '', '2023-06-11', NULL),
(3, 9, 450, '', '2023-06-12', NULL),
(4, 12, 10, 'QUE TE PUEDO DECIR', '2023-06-12', NULL),
(5, 35, 5600, 'AH BUENOOO MAL', '2023-06-12', NULL),
(6, 29, 200, 'A', '2023-06-12', NULL),
(7, 2, 1, '', '2023-06-12', NULL),
(8, 35, 20, '', '2023-06-12', NULL),
(9, 31, 2560, 'nottia', '2023-06-12', 1),
(10, 29, 20000, '', '2023-06-12', 1),
(11, 35, 100, 'XDDDDDD Probando vamos a ver como queda uno largo, XDDDDDD Probando vamos a ver como queda uno largo, XDDDDDD Probando vamos a ver como queda uno largo, XDDDDDD Probando vamos a ver como queda uno largo, XDDDDDD Probando vamos a ver como queda uno largo, XDDDDDD Probando vamos a ver como queda uno largo, XDDDDDD Probando vamos a ver como queda uno largo, XDDDDDD Probando vamos a ver como queda uno largo,', '2023-06-13', 1),
(12, 31, 300, 'XDDDDDD Probando vamos a ver como queda uno largo, XDDDDDD Probando vamos a ver como queda uno largo, XDDDDDD Probando vamos a ver como queda uno largo, XDDDDDD Probando vamos a ver como queda uno largo, XDDDDDD Probando vamos a ver como queda uno largo, XDDDDDD Probando vamos a ver como queda uno largo, XDDDDDD Probando vamos a ver como queda uno largo,', '2023-06-13', 1),
(13, 6, 100, '', '2023-06-13', 1),
(14, 30, 2400, 'aka', '2023-06-13', 1),
(15, 30, 1000, 'alalaldasmldsmldmsld', '2023-06-13', 1),
(16, 30, 100, '', '2023-06-13', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clap_por_entrega`
--

CREATE TABLE `clap_por_entrega` (
  `id_clap_por_entrega` int(11) NOT NULL,
  `fecha_inicio_entrega` date NOT NULL,
  `fecha_fin_entrega` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clap_por_entrega`
--

INSERT INTO `clap_por_entrega` (`id_clap_por_entrega`, `fecha_inicio_entrega`, `fecha_fin_entrega`) VALUES
(5, '2023-06-11', '2023-06-17'),
(6, '2023-06-14', '2023-06-29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clap_por_municipio`
--

CREATE TABLE `clap_por_municipio` (
  `id_clap_por_municipio` int(11) NOT NULL,
  `entrega_clap_id` int(11) DEFAULT NULL,
  `municipio_id` int(11) DEFAULT NULL,
  `precio` decimal(20,2) NOT NULL DEFAULT 0.00,
  `fecha_cobro` date DEFAULT NULL,
  `fecha_despacho` date DEFAULT NULL,
  `comercializadora` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clap_por_municipio`
--

INSERT INTO `clap_por_municipio` (`id_clap_por_municipio`, `entrega_clap_id`, `municipio_id`, `precio`, `fecha_cobro`, `fecha_despacho`, `comercializadora`) VALUES
(2, 5, 2, '230.00', '2023-06-11', '2023-06-30', 'PDVISO'),
(3, 5, 3, '0.00', NULL, NULL, ''),
(4, 5, 4, '12.00', NULL, NULL, ''),
(5, 5, 5, '0.00', NULL, NULL, ''),
(6, 5, 6, '0.00', NULL, NULL, ''),
(7, 5, 7, '0.00', NULL, NULL, ''),
(8, 5, 8, '0.00', NULL, NULL, ''),
(9, 5, 9, '0.00', NULL, NULL, ''),
(10, 5, 10, '0.00', NULL, NULL, ''),
(11, 5, 11, '0.00', NULL, '2023-06-06', 'ASUPUAMADRE'),
(12, 5, 12, '0.00', NULL, NULL, ''),
(13, 5, 13, '0.00', NULL, NULL, ''),
(14, 5, 14, '0.00', NULL, NULL, ''),
(15, 5, 15, '0.00', NULL, NULL, ''),
(16, 5, 16, '0.00', NULL, NULL, ''),
(17, 5, 17, '0.00', NULL, NULL, ''),
(18, 5, 18, '0.00', NULL, NULL, ''),
(19, 5, 19, '0.00', NULL, NULL, ''),
(20, 5, 20, '0.00', NULL, NULL, ''),
(21, 5, 21, '0.00', NULL, NULL, ''),
(22, 5, 22, '0.00', NULL, NULL, ''),
(23, 5, 23, '0.00', NULL, NULL, ''),
(24, 5, 24, '20.40', NULL, NULL, 'mERCAL'),
(25, 5, 25, '500.00', NULL, '2023-06-24', ''),
(26, 5, 26, '0.00', '2023-06-11', '2023-06-17', 'PDVALlññl'),
(27, 6, 2, '0.00', NULL, NULL, ''),
(28, 6, 3, '0.00', NULL, NULL, ''),
(29, 6, 4, '0.00', NULL, NULL, ''),
(30, 6, 5, '0.00', NULL, NULL, ''),
(31, 6, 6, '33400.16', '2023-06-13', '2023-06-17', 'MERCAL'),
(32, 6, 7, '0.00', NULL, NULL, ''),
(33, 6, 8, '0.00', NULL, NULL, ''),
(34, 6, 9, '0.00', NULL, NULL, ''),
(35, 6, 10, '300.00', '2020-06-19', '2023-06-21', ''),
(36, 6, 11, '0.00', NULL, NULL, ''),
(37, 6, 12, '0.00', NULL, NULL, ''),
(38, 6, 13, '0.00', NULL, NULL, ''),
(39, 6, 14, '0.00', NULL, NULL, ''),
(40, 6, 15, '0.00', NULL, NULL, ''),
(41, 6, 16, '0.00', NULL, NULL, ''),
(42, 6, 17, '0.00', NULL, NULL, ''),
(43, 6, 18, '0.00', NULL, NULL, ''),
(44, 6, 19, '0.00', NULL, NULL, ''),
(45, 6, 20, '0.00', NULL, NULL, ''),
(46, 6, 21, '0.00', NULL, NULL, ''),
(47, 6, 22, '0.00', NULL, NULL, ''),
(48, 6, 23, '0.00', NULL, NULL, ''),
(49, 6, 24, '0.00', NULL, NULL, ''),
(50, 6, 25, '0.00', NULL, NULL, ''),
(51, 6, 26, '0.00', NULL, NULL, '');

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
  `fecha_creacion_cnae_carga` date NOT NULL DEFAULT current_timestamp(),
  `user_id_cnae_carga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cnae_carga`
--

INSERT INTO `cnae_carga` (`id_cnae_carga`, `cnae_por_municipio_id_cnae_carga`, `matricula_atendida_cnae_carga`, `instituciones_atendidas_cnae_carga`, `proteina_despachada_cnae_carga`, `claps_despachados_cnae_carga`, `fruta_despachada_cnae_carga`, `fecha_entrega_cnae_carga`, `fecha_creacion_cnae_carga`, `user_id_cnae_carga`) VALUES
(20, 226, 0, 0, '0.00', 10, '0.00', '2023-06-05', '2023-06-04', 1),
(21, 226, 0, 0, '0.00', 10, '0.00', '2023-06-05', '2023-06-04', 1),
(22, 230, 10, 0, '0.00', 0, '0.00', '2023-06-05', '2023-06-05', 1),
(23, 230, 100, 0, '0.00', 0, '0.00', '2023-06-05', '2023-06-05', 1),
(24, 230, 91, 0, '0.00', 0, '0.00', '2023-06-05', '2023-06-05', 1),
(25, 227, 0, 0, '0.00', 10, '0.00', '2023-06-08', '2023-06-07', 1),
(26, 227, 0, 0, '0.00', 0, '0.01', '2023-06-08', '2023-06-07', 1),
(27, 227, 0, 0, '0.00', 0, '1.00', '2023-06-08', '2023-06-07', 1),
(28, 227, 0, 0, '0.00', 0, '1.00', '2023-06-08', '2023-06-07', 1),
(29, 227, 0, 0, '0.00', 0, '97.00', '2023-06-08', '2023-06-07', 1),
(30, 227, 0, 0, '0.00', 0, '0.90', '2023-06-08', '2023-06-07', 1),
(31, 227, 0, 0, '0.00', 0, '0.09', '2023-06-08', '2023-06-07', 1),
(32, 250, 0, 0, '0.00', 100, '0.00', '2023-06-11', '2023-06-11', 1),
(33, 250, 0, 0, '20.00', 0, '0.00', '2023-06-11', '2023-06-11', 1),
(34, 175, 0, 0, '0.00', 1, '0.00', '2023-06-11', '2023-06-11', 1),
(35, 250, 0, 0, '0.00', 100, '0.00', '2023-06-11', '2023-06-11', 1),
(36, 175, 0, 2, '0.00', 0, '0.00', '2023-06-11', '2023-06-11', 1),
(37, 175, 0, 10, '0.00', 0, '0.00', '2023-06-11', '2023-06-11', 1),
(38, 175, 0, 0, '20.00', 0, '0.00', '2023-06-11', '2023-06-11', 1);

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
(15, '2023-05-01', '2023-05-31'),
(26, '2023-06-01', '2023-06-30');

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
(151, 2, 15, '300.00', 2, '0.00', 20009, 0),
(152, 3, 15, '40.10', 100, '300.00', 5, 1002),
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
(174, 25, 15, '1000.00', 1400, '0.00', 0, 0),
(175, 26, 15, '70.13', 1022, '0.28', 10000, 200),
(226, 2, 26, '0.00', 20, '0.00', 2, 0),
(227, 3, 26, '0.00', 10, '100.00', 0, 0),
(228, 4, 26, '0.00', 0, '0.00', 0, 0),
(229, 5, 26, '0.00', 0, '0.00', 0, 0),
(230, 6, 26, '28.00', 10, '120.23', 1020, 201),
(231, 7, 26, '40.20', 0, '0.00', 0, 420),
(232, 8, 26, '0.00', 0, '0.00', 0, 10000),
(233, 9, 26, '0.00', 0, '0.00', 0, 0),
(234, 10, 26, '0.00', 0, '0.00', 0, 0),
(235, 11, 26, '0.00', 0, '0.00', 0, 0),
(236, 12, 26, '0.00', 0, '0.00', 0, 0),
(237, 13, 26, '0.00', 0, '0.00', 0, 0),
(238, 14, 26, '0.00', 0, '0.00', 0, 0),
(239, 15, 26, '0.00', 0, '0.00', 0, 0),
(240, 16, 26, '0.00', 0, '0.00', 0, 0),
(241, 17, 26, '0.00', 0, '0.00', 0, 0),
(242, 18, 26, '0.00', 0, '0.00', 0, 0),
(243, 19, 26, '0.00', 0, '0.00', 0, 0),
(244, 20, 26, '0.00', 0, '0.00', 0, 0),
(245, 21, 26, '0.00', 0, '0.00', 0, 0),
(246, 22, 26, '0.00', 0, '0.00', 0, 0),
(247, 23, 26, '0.00', 0, '0.00', 0, 0),
(248, 24, 26, '0.00', 0, '0.00', 0, 0),
(249, 25, 26, '0.00', 0, '0.00', 0, 0),
(250, 26, 26, '40.32', 200, '0.00', 0, 10000);

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
-- Estructura de tabla para la tabla `fundaproal_carga`
--

CREATE TABLE `fundaproal_carga` (
  `id_fundaproal_carga` int(11) NOT NULL,
  `fundaproal_por_municipio_id` int(11) DEFAULT NULL,
  `proteina_despachada` decimal(20,2) NOT NULL,
  `clap_despachados` int(11) NOT NULL,
  `fruta_despachada` decimal(20,2) NOT NULL,
  `plan_paca_despachado` int(11) NOT NULL,
  `plan_papa_despachado` int(11) NOT NULL,
  `fecha_despacho` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fundaproal_por_mes`
--

CREATE TABLE `fundaproal_por_mes` (
  `id_fundaproal_por_mes` int(11) NOT NULL,
  `fecha_inicio_fundaproal_por_mes` date NOT NULL,
  `fecha_fin_ fundaproal _por_mes` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fundaproal_por_municipio`
--

CREATE TABLE `fundaproal_por_municipio` (
  `id_fundaproal_por_municipio` int(11) NOT NULL,
  `mes_id` int(11) DEFAULT NULL,
  `municipio_id` int(11) DEFAULT NULL,
  `cantidad_casas_alimentacion` int(11) NOT NULL,
  `cemr` int(11) NOT NULL,
  `cantidad_misioneros` int(11) NOT NULL,
  `cantidad_madres_elab` int(11) NOT NULL,
  `cantidad_padres_elab` int(11) NOT NULL,
  `proteina_asignada` decimal(20,2) NOT NULL,
  `clap_asignados` int(11) NOT NULL,
  `fruta_asignada` decimal(20,2) NOT NULL,
  `plan_paca_asignado` int(11) NOT NULL,
  `plan_papa_asignado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inn_carga`
--

CREATE TABLE `inn_carga` (
  `id_inn_carga` int(11) NOT NULL,
  `inn_por_municipio_id` int(11) DEFAULT NULL,
  `proteina_despachada` decimal(20,2) NOT NULL,
  `clap_despachados` int(11) NOT NULL,
  `personas_atendidas` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inn_por_mes`
--

CREATE TABLE `inn_por_mes` (
  `id_inn_por_mes` int(11) NOT NULL,
  `fecha_inicio_inn_por_mes` date NOT NULL,
  `fecha_fin_inn_por_mes` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inn_por_municipio`
--

CREATE TABLE `inn_por_municipio` (
  `id_inn_por_municipio` int(11) NOT NULL,
  `mes_id` int(11) DEFAULT NULL,
  `municipio_id` int(11) DEFAULT NULL,
  `clap_asignados` int(11) NOT NULL,
  `proteina_asignada` decimal(20,2) NOT NULL,
  `personas_por_atender` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id_municipio` int(11) NOT NULL,
  `name_municipio` varchar(255) NOT NULL,
  `cantidad_parroquias` int(11) NOT NULL,
  `cantidad_comunidades` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id_municipio`, `name_municipio`, `cantidad_parroquias`, `cantidad_comunidades`) VALUES
(2, 'Acosta', 0, 0),
(3, 'Bolívar', 0, 0),
(4, 'Buchivacoa', 0, 0),
(5, 'Cacique Manaure', 0, 0),
(6, 'Carirubana', 0, 0),
(7, 'Colina', 0, 0),
(8, 'Dabajuro', 0, 0),
(9, 'Democracia', 0, 0),
(10, 'Falcón', 0, 0),
(11, 'Federación', 0, 0),
(12, 'Jacura', 0, 0),
(13, 'Los Taques', 0, 0),
(14, 'Mauroa', 0, 0),
(15, 'Miranda', 0, 0),
(16, 'Monseñor Iturriza', 0, 0),
(17, 'Palmasola', 0, 0),
(18, 'Petit', 0, 0),
(19, 'Píritu', 0, 0),
(20, 'San Francisco', 0, 0),
(21, 'Silva', 0, 0),
(22, 'Sucre', 0, 0),
(23, 'Tocópero', 0, 0),
(24, 'Unión', 0, 0),
(25, 'Urumaco', 0, 0),
(26, 'Zamora', 0, 0);

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
-- Indices de la tabla `clap_carga`
--
ALTER TABLE `clap_carga`
  ADD PRIMARY KEY (`id_clap_carga`),
  ADD KEY `fk_clap_por_municipio` (`clap_por_municipio_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indices de la tabla `clap_por_entrega`
--
ALTER TABLE `clap_por_entrega`
  ADD PRIMARY KEY (`id_clap_por_entrega`);

--
-- Indices de la tabla `clap_por_municipio`
--
ALTER TABLE `clap_por_municipio`
  ADD PRIMARY KEY (`id_clap_por_municipio`),
  ADD KEY `fk_clap_por_entrega` (`entrega_clap_id`),
  ADD KEY `fk_municipio` (`municipio_id`);

--
-- Indices de la tabla `cnae_carga`
--
ALTER TABLE `cnae_carga`
  ADD PRIMARY KEY (`id_cnae_carga`),
  ADD KEY `fk_cnae_por_mes` (`cnae_por_municipio_id_cnae_carga`),
  ADD KEY `fk_user_cnae_carga` (`user_id_cnae_carga`);

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
-- Indices de la tabla `fundaproal_carga`
--
ALTER TABLE `fundaproal_carga`
  ADD PRIMARY KEY (`id_fundaproal_carga`),
  ADD KEY `fundaproal_por_municipio_id` (`fundaproal_por_municipio_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `fundaproal_por_mes`
--
ALTER TABLE `fundaproal_por_mes`
  ADD PRIMARY KEY (`id_fundaproal_por_mes`);

--
-- Indices de la tabla `fundaproal_por_municipio`
--
ALTER TABLE `fundaproal_por_municipio`
  ADD PRIMARY KEY (`id_fundaproal_por_municipio`),
  ADD KEY `mes_id` (`mes_id`),
  ADD KEY `municipio_id` (`municipio_id`);

--
-- Indices de la tabla `inn_carga`
--
ALTER TABLE `inn_carga`
  ADD PRIMARY KEY (`id_inn_carga`),
  ADD KEY `inn_por_municipio_id` (`inn_por_municipio_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `inn_por_mes`
--
ALTER TABLE `inn_por_mes`
  ADD PRIMARY KEY (`id_inn_por_mes`);

--
-- Indices de la tabla `inn_por_municipio`
--
ALTER TABLE `inn_por_municipio`
  ADD PRIMARY KEY (`id_inn_por_municipio`),
  ADD KEY `mes_id` (`mes_id`,`municipio_id`),
  ADD KEY `municipio_id` (`municipio_id`);

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
-- AUTO_INCREMENT de la tabla `clap_carga`
--
ALTER TABLE `clap_carga`
  MODIFY `id_clap_carga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `clap_por_entrega`
--
ALTER TABLE `clap_por_entrega`
  MODIFY `id_clap_por_entrega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `clap_por_municipio`
--
ALTER TABLE `clap_por_municipio`
  MODIFY `id_clap_por_municipio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `cnae_carga`
--
ALTER TABLE `cnae_carga`
  MODIFY `id_cnae_carga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `cnae_por_mes`
--
ALTER TABLE `cnae_por_mes`
  MODIFY `id_cnae_por_mes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `cnae_por_municipio`
--
ALTER TABLE `cnae_por_municipio`
  MODIFY `id_cnae_por_municipio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `id_company` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `fundaproal_carga`
--
ALTER TABLE `fundaproal_carga`
  MODIFY `id_fundaproal_carga` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fundaproal_por_mes`
--
ALTER TABLE `fundaproal_por_mes`
  MODIFY `id_fundaproal_por_mes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fundaproal_por_municipio`
--
ALTER TABLE `fundaproal_por_municipio`
  MODIFY `id_fundaproal_por_municipio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inn_carga`
--
ALTER TABLE `inn_carga`
  MODIFY `id_inn_carga` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inn_por_mes`
--
ALTER TABLE `inn_por_mes`
  MODIFY `id_inn_por_mes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inn_por_municipio`
--
ALTER TABLE `inn_por_municipio`
  MODIFY `id_inn_por_municipio` int(11) NOT NULL AUTO_INCREMENT;

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
-- Filtros para la tabla `clap_carga`
--
ALTER TABLE `clap_carga`
  ADD CONSTRAINT `clap_carga_ibfk_1` FOREIGN KEY (`clap_por_municipio_id`) REFERENCES `clap_por_municipio` (`id_clap_por_municipio`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `clap_carga_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Filtros para la tabla `clap_por_municipio`
--
ALTER TABLE `clap_por_municipio`
  ADD CONSTRAINT `clap_por_municipio_ibfk_1` FOREIGN KEY (`entrega_clap_id`) REFERENCES `clap_por_entrega` (`id_clap_por_entrega`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `clap_por_municipio_ibfk_2` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id_municipio`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cnae_carga`
--
ALTER TABLE `cnae_carga`
  ADD CONSTRAINT `cnae_carga_ibfk_1` FOREIGN KEY (`cnae_por_municipio_id_cnae_carga`) REFERENCES `cnae_por_municipio` (`id_cnae_por_municipio`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `cnae_carga_ibfk_2` FOREIGN KEY (`user_id_cnae_carga`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cnae_por_municipio`
--
ALTER TABLE `cnae_por_municipio`
  ADD CONSTRAINT `cnae_por_municipio_ibfk_1` FOREIGN KEY (`municipio_id_cnae_por_municipio`) REFERENCES `municipios` (`id_municipio`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `cnae_por_municipio_ibfk_2` FOREIGN KEY (`mes_id_cnae_por_municipio`) REFERENCES `cnae_por_mes` (`id_cnae_por_mes`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fundaproal_carga`
--
ALTER TABLE `fundaproal_carga`
  ADD CONSTRAINT `fundaproal_carga_ibfk_1` FOREIGN KEY (`fundaproal_por_municipio_id`) REFERENCES `fundaproal_por_municipio` (`id_fundaproal_por_municipio`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fundaproal_carga_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fundaproal_por_municipio`
--
ALTER TABLE `fundaproal_por_municipio`
  ADD CONSTRAINT `fundaproal_por_municipio_ibfk_1` FOREIGN KEY (`mes_id`) REFERENCES `fundaproal_por_mes` (`id_fundaproal_por_mes`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fundaproal_por_municipio_ibfk_2` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id_municipio`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inn_carga`
--
ALTER TABLE `inn_carga`
  ADD CONSTRAINT `inn_carga_ibfk_1` FOREIGN KEY (`inn_por_municipio_id`) REFERENCES `inn_por_municipio` (`id_inn_por_municipio`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `inn_carga_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inn_por_municipio`
--
ALTER TABLE `inn_por_municipio`
  ADD CONSTRAINT `inn_por_municipio_ibfk_1` FOREIGN KEY (`mes_id`) REFERENCES `inn_por_mes` (`id_inn_por_mes`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `inn_por_municipio_ibfk_2` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id_municipio`) ON DELETE SET NULL ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
