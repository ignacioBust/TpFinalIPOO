-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-05-2017 a las 02:36:26
-- Versión del servidor: 10.1.22-MariaDB
-- Versión de PHP: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdtienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item`
--

CREATE TABLE `item` (
  `codigobarra` bigint(20) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `codigo` bigint(20) UNSIGNED NOT NULL,
  `importe` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codigobarra` bigint(20) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `marca` varchar(64) NOT NULL,
  `color` varchar(64) NOT NULL,
  `descripcion` varchar(128) NOT NULL,
  `cantstock` int(11) NOT NULL,
  `importe` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tienda`
--

CREATE TABLE `tienda` (
  `cuit` bigint(20) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `direccion` varchar(128) NOT NULL,
  `telefono` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `codigo` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `denominacioncliente` varchar(128) NOT NULL,
  `descuento` double NOT NULL,
  `incremento` double NOT NULL,
  `importefinal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventacredito`
--

CREATE TABLE `ventacredito` (
  `codigo` bigint(20) UNSIGNED NOT NULL,
  `nombretitular` varchar(64) NOT NULL,
  `numerotarjeta` int(11) NOT NULL,
  `empresaemisora` varchar(64) NOT NULL,
  `cuotas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventadebito`
--

CREATE TABLE `ventadebito` (
  `codigo` bigint(20) UNSIGNED NOT NULL,
  `red` varchar(64) NOT NULL,
  `bancoemisor` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `item`
--
ALTER TABLE `item`
  ADD KEY `codigobarra` (`codigobarra`),
  ADD KEY `codigo` (`codigo`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codigobarra`);

--
-- Indices de la tabla `tienda`
--
ALTER TABLE `tienda`
  ADD PRIMARY KEY (`cuit`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `ventacredito`
--
ALTER TABLE `ventacredito`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codigo` (`codigo`);

--
-- Indices de la tabla `ventadebito`
--
ALTER TABLE `ventadebito`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codigo` (`codigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `codigo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`codigobarra`) REFERENCES `producto` (`codigobarra`),
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`codigo`) REFERENCES `venta` (`codigo`);

--
-- Filtros para la tabla `ventacredito`
--
ALTER TABLE `ventacredito`
  ADD CONSTRAINT `ventacredito_ibfk_1` FOREIGN KEY (`codigo`) REFERENCES `venta` (`codigo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventadebito`
--
ALTER TABLE `ventadebito`
  ADD CONSTRAINT `ventadebito_ibfk_1` FOREIGN KEY (`codigo`) REFERENCES `venta` (`codigo`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
