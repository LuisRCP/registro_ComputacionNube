-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `registro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cat_carrera`
--

CREATE TABLE `tbl_cat_carrera` (
  `carreraId` int(11) NOT NULL,
  `carrera_Nombre` varchar(60) DEFAULT NULL,
  `carrera_Siglas` varchar(20) DEFAULT NULL,
  `activo` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_cat_carrera`
--

INSERT INTO `tbl_cat_carrera` (`carreraId`, `carrera_Nombre`, `carrera_Siglas`, `activo`) VALUES
(1, 'LICENCIATURA EN PEDAGOGÍA', 'LPED', 1),
(2, 'LICENCIATURA EN ADMINISTRACIÓN DE EMPRESAS', 'LAE', 1),
(3, 'LICENCIATURA EN CULTURA FÍSICA Y EDUCACIÓN DEL DEPORTE', 'LCFED', 1),
(4, 'LICENCIATURA EN RELACIONES INTERNACIONALES', 'LRI', 1),
(5, 'LICENCIATURA EN PSICOLOGÍA', 'LPSIC', 1),
(6, 'INGENIERO ARQUITECTO', 'IAR', 1),
(7, 'LICENCIATURA EN ADMINISTRACIÓN DE EMPRESAS TURÍSTICAS', 'LAET', 1),
(8, 'LICENCIATURA EN DISEÑO GRÁFICO', 'LDG', 1),
(9, 'LICENCIATURA EN GASTRONOMÍA', 'LGAS', 1),
(10, 'LICENCIATURA EN DERECHO', 'LIDER', 1),
(11, 'INGENIERÍA EN SISTEMAS COMPUTACIONALES', 'ISC', 1),
(12, 'LICENCIATURA EN INGENIERÍA EN LOGÍSTICA Y TRANSPORTE', 'ILT', 1),
(13, 'LICENCIATURA EN DISEÑO DE MODAS', 'LDM', 1),
(14, 'LICENCIATURA EN MERCADOTECNIA Y PUBLICIDAD', 'LMP', 1),
(15, 'LICENCIATURA EN CONTADURÍA PÙBLICA Y FINANZAS', 'LCPF', 1),
(17, 'LICENCIATURA EN DISEÑO DE INTERIORES', 'LDI', 1),
(18, 'INGENIERÍA MECÁNICA AUTOMOTRIZ', 'IMA', 1),
(19, 'LICENCIATURA EN PERIODISMO Y CIENCIAS DE LA COMUNICACIÓN', 'LPCC', 1),
(20, 'LICENCIATURA EN IDIOMAS', 'LIDIO', 1),
(21, 'LICENCIATURA EN INFORMÁTICA ADMINISTRATIVA Y FISCAL', 'LIAF', 1),
(22, 'LICENCIATURA EN PEDAGOGÍA MIXTA', 'LPEDMX', 1),
(23, 'LICENCIATURA EN ADMINISTRACIÓN DE EMPRESAS', 'LAEMX', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cat_grado`
--

CREATE TABLE `tbl_cat_grado` (
  `gradoId` int(11) NOT NULL,
  `grado_Nombre` varchar(50) DEFAULT NULL,
  `activo` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_cat_grado`
--

INSERT INTO `tbl_cat_grado` (`gradoId`, `grado_Nombre`, `activo`) VALUES
(1, '1', 1),
(2, '2', 1),
(3, '3', 1),
(4, '4', 1),
(5, '5', 1),
(6, '6', 1),
(7, '7', 1),
(8, '8', 1),
(9, '9', 1),
(10, '10', 1),
(11, '11', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cat_turno`
--

CREATE TABLE `tbl_cat_turno` (
  `turnoId` int(11) NOT NULL,
  `turno_Nombre` varchar(50) DEFAULT NULL,
  `turno_Sigla` varchar(10) DEFAULT NULL,
  `activo` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_cat_turno`
--

INSERT INTO `tbl_cat_turno` (`turnoId`, `turno_Nombre`, `turno_Sigla`, `activo`) VALUES
(1, 'Matutino', 'M', 1),
(2, 'Vespertino', 'V', 1),
(3, 'Mixto', 'MX', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ope_alumno`
--

CREATE TABLE `tbl_ope_alumno` (
  `alumnoId` int(11) NOT NULL,
  `nombre_Alumno` varchar(50) DEFAULT NULL,
  `nombre_ApellidoPat` varchar(50) DEFAULT NULL,
  `nombre_ApellidoMat` varchar(50) DEFAULT NULL,
  `grupoId` int(11) DEFAULT NULL,
  `activo` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ope_grupo`
--

CREATE TABLE `tbl_ope_grupo` (
  `grupoId` int(11) NOT NULL,
  `turnoId` int(11) DEFAULT NULL,
  `gradoId` int(11) DEFAULT NULL,
  `carreraId` int(11) DEFAULT NULL,
  `grupo_Nombre` varchar(50) DEFAULT NULL,
  `activo` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_cat_carrera`
--
ALTER TABLE `tbl_cat_carrera`
  ADD PRIMARY KEY (`carreraId`);

--
-- Indices de la tabla `tbl_cat_grado`
--
ALTER TABLE `tbl_cat_grado`
  ADD PRIMARY KEY (`gradoId`);

--
-- Indices de la tabla `tbl_cat_turno`
--
ALTER TABLE `tbl_cat_turno`
  ADD PRIMARY KEY (`turnoId`);

--
-- Indices de la tabla `tbl_ope_alumno`
--
ALTER TABLE `tbl_ope_alumno`
  ADD PRIMARY KEY (`alumnoId`);

--
-- Indices de la tabla `tbl_ope_grupo`
--
ALTER TABLE `tbl_ope_grupo`
  ADD PRIMARY KEY (`grupoId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_cat_carrera`
--
ALTER TABLE `tbl_cat_carrera`
  MODIFY `carreraId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `tbl_cat_grado`
--
ALTER TABLE `tbl_cat_grado`
  MODIFY `gradoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tbl_cat_turno`
--
ALTER TABLE `tbl_cat_turno`
  MODIFY `turnoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_ope_alumno`
--
ALTER TABLE `tbl_ope_alumno`
  MODIFY `alumnoId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_ope_grupo`
--
ALTER TABLE `tbl_ope_grupo`
  MODIFY `grupoId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
