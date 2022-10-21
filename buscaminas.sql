-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-10-2022 a las 18:47:43
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `buscaminas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugador`
--

CREATE TABLE `jugador` (
  `ID` varchar(5) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `passw` varchar(10) NOT NULL,
  `correo` varchar(99) NOT NULL,
  `realizadas` int(5) NOT NULL,
  `ganadas` int(5) NOT NULL,
  `perdidas` int(5) NOT NULL,
  `verificado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `jugador`
--

INSERT INTO `jugador` (`ID`, `nombre`, `passw`, `correo`, `realizadas`, `ganadas`, `perdidas`, `verificado`) VALUES
('1C', 'Maria Antonia', '9876', 'miriamoliver99@gmail.com', 0, 0, 0, 0),
('2C', 'Maria', '9876', 'miriamoliver99@gmail.com', 9, 3, 6, 1),
('7A', 'Pablo', '9876', 'miriamoliver99@gmail.com', 2, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `IDjugador` varchar(5) NOT NULL,
  `IDtablero` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `partida`
--

INSERT INTO `partida` (`IDjugador`, `IDtablero`) VALUES
('7A', '53133'),
('7A', '81583'),
('2C', '63666'),
('2C', '78791'),
('2C', '24340'),
('2C', '82581'),
('2C', '66495'),
('2C', '57275'),
('2C', '34595'),
('2C', '53452'),
('2C', '37647'),
('2C', '10805');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablero`
--

CREATE TABLE `tablero` (
  `ID` varchar(5) NOT NULL,
  `tablero` varchar(999) NOT NULL,
  `tableroHumano` varchar(999) NOT NULL,
  `mina` int(10) NOT NULL,
  `completado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tablero`
--

INSERT INTO `tablero` (`ID`, `tablero`, `tableroHumano`, `mina`, `completado`) VALUES
('10805', '1#*', '-#-', 1, 0),
('24340', '-#-#1#*#1', '0#0#1#-#1', 1, 1),
('34595', '*#1', '*#-', 1, 1),
('37647', '*#1', '*#-', 1, 1),
('53133', '*#1#1#*#1#-#-#1#*#1', '*#-#-#-#-#-#-#-#-#-', 3, 1),
('53452', '*#1', '-#1', 1, 1),
('57275', '*#1', '*#-', 1, 1),
('63666', '-#1#*#1#-', '-#-#-#-#-', 1, 1),
('66495', '*#2#*#*', '*#-#-#-', 3, 1),
('78791', '*#1#-#1#*#1#-#-#1#*', '-#1#0#1#-#1#0#0#1#-', 3, 1),
('81583', '-#-#-#1#*#2#*#2#*#1', '0#0#0#1#-#2#-#2#-#1', 3, 1),
('82581', '-#*#1#-#-#-#1#*#2#*', '0#-#1#0#-#-#-#-#-#*', 3, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `jugador`
--
ALTER TABLE `jugador`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `partida`
--
ALTER TABLE `partida`
  ADD KEY `fk_partida2` (`IDtablero`),
  ADD KEY `fk_partida` (`IDjugador`);

--
-- Indices de la tabla `tablero`
--
ALTER TABLE `tablero`
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `fk_partida` FOREIGN KEY (`IDjugador`) REFERENCES `jugador` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_partida2` FOREIGN KEY (`IDtablero`) REFERENCES `tablero` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
