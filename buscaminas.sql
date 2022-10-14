-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-10-2022 a las 20:31:04
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
  `realizadas` int(5) NOT NULL,
  `ganadas` int(5) NOT NULL,
  `perdidas` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `jugador`
--

INSERT INTO `jugador` (`ID`, `nombre`, `passw`, `realizadas`, `ganadas`, `perdidas`) VALUES
('7A', 'Pablo', '9876', 8, 0, 8),
('8A', 'Ana', '9876', 2, 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `IDjugador` varchar(5) NOT NULL,
  `IDtablero` varchar(5) NOT NULL,
  `tablero` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `partida`
--

INSERT INTO `partida` (`IDjugador`, `IDtablero`, `tablero`) VALUES
('7A', '16552', '-#-#0#-#-#-#-#-#*#1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablero`
--

CREATE TABLE `tablero` (
  `ID` varchar(5) NOT NULL,
  `tablero` varchar(999) NOT NULL,
  `tableroHumano` varchar(999) NOT NULL,
  `IDJugador` varchar(5) NOT NULL,
  `mina` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tablero`
--

INSERT INTO `tablero` (`ID`, `tablero`, `tableroHumano`, `IDJugador`, `mina`) VALUES
('83819', '-#-#-#-#-#1#*#1#-#1#*#*#1#-#-', '0#0#0#0#-#-#-#-#-#-#-#-#-#-#0', '7A', 3),
('34296', '*#1#-#1#*#1#1#*#1#-', '-#1#0#1#-#-#-#-#-#-', '8A', 3);

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
  ADD PRIMARY KEY (`IDtablero`),
  ADD KEY `fk_partida` (`IDjugador`);

--
-- Indices de la tabla `tablero`
--
ALTER TABLE `tablero`
  ADD PRIMARY KEY (`IDJugador`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `fk_partida` FOREIGN KEY (`IDjugador`) REFERENCES `jugador` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tablero`
--
ALTER TABLE `tablero`
  ADD CONSTRAINT `fk_tablero` FOREIGN KEY (`IDJugador`) REFERENCES `jugador` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
