-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 02-11-2017 a las 21:57:13
-- Versión del servidor: 5.5.53
-- Versión de PHP: 5.3.10-1ubuntu3.25

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `execforums`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto_cobro`
--

CREATE TABLE IF NOT EXISTS `presupuesto_cobro` (
  `presupuestocobro_id` int(11) NOT NULL,
  `cobro_id` int(11) NOT NULL,
  PRIMARY KEY (`presupuestocobro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`execforums`@`localhost` EVENT `Update Forum Leaders` ON SCHEDULE EVERY 1 DAY STARTS '2017-04-18 00:00:00' ON COMPLETION PRESERVE ENABLE DO UPDATE  `miembro` m JOIN grupos g ON g.gru_id = m.grupo_id SET m.`forum_usu_id` = g.gru_forum$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
