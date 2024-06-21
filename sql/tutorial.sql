-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-06-2024 a las 19:12:20
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tutorial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aprendiz`
--

CREATE TABLE `aprendiz` (
  `ID_Aprendiz` int(11) NOT NULL,
  `Numero_Documento` varchar(50) NOT NULL,
  `Tipo_Documento` varchar(20) NOT NULL,
  `Primer_Nombre` varchar(50) NOT NULL,
  `Segundo_Nombre` varchar(50) DEFAULT NULL,
  `Primer_Apellido` varchar(50) NOT NULL,
  `Segundo_Apellido` varchar(50) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `ID_Ficha` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aprendiz`
--

INSERT INTO `aprendiz` (`ID_Aprendiz`, `Numero_Documento`, `Tipo_Documento`, `Primer_Nombre`, `Segundo_Nombre`, `Primer_Apellido`, `Segundo_Apellido`, `Email`, `Telefono`, `ID_Ficha`) VALUES
(1, '12344434444', 'CC', 'Limona', 'Waos', 'Ola', 'Tilin', 'sadasd@gmail.com', '123577777', 1),
(2, '113213', 'CC', '12312', 'asdasd', 'sadadsad', 'asdasda', 'asdadsa@gmail.com', '12312315', 1),
(3, '123', 'TI', 'Ola', 'Soy', 'Esteban', 'xd', 'fdsfsd@gmail.com', '1231253', 1),
(4, '123123321', 'CC', '123ewas', 'adsdas', 'asdasd', 'asdasd', 'asdadsa@gmail.com', '123123123', 1),
(5, '1234', 'CC', 'cwqe', 'ewq', 'qwe', 'qweqwe', 'qweqwe@gmail.com', '1234', 1),
(6, '123123', 'CC', 'sdada', 'dasddddddddd', 'dddddddd', 'ddddddddddd', 'ddasdd@gmail.com', '123123', 1),
(7, '123123333', 'CC', 'saddsa', 'asda', 'asdad', 'asdasasd', 'sdasd@gmail.com', 'asdasdasd', 1),
(8, '12354344323', 'CC', 'cwqe', 'Ana', 'a', 'Ariza', 'a@gmail.com', '3195964478', 1),
(9, '12312333333333333333333333', 'CC', 'dddddd', 'ddddddcccccccccccccc', 'vvvvvvvvvc', 'ccccccccccccc', 'dsasd@gmail.com', '1234444', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comite`
--

CREATE TABLE `comite` (
  `id` int(11) NOT NULL,
  `id_aprendiz` int(11) NOT NULL,
  `id_ficha` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comite`
--

INSERT INTO `comite` (`id`, `id_aprendiz`, `id_ficha`, `descripcion`, `num`) VALUES
(1, 1, 1, 'qwe', 1),
(2, 1, 1, 'adasd', 2),
(3, 1, 1, 'qweqweqwe', 2),
(4, 1, 1, 'sddddddd', 1),
(5, 1, 1, 'sddddddd', 1),
(6, 1, 1, 'ffffffffffffff', 1),
(7, 1, 1, 'ewqeqweq', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha`
--

CREATE TABLE `ficha` (
  `ID_Ficha` int(11) NOT NULL,
  `Numero_Ficha` int(20) NOT NULL,
  `Nombre_Ficha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ficha`
--

INSERT INTO `ficha` (`ID_Ficha`, `Numero_Ficha`, `Nombre_Ficha`) VALUES
(1, 123, 'Waos'),
(2, 2131, 'waeqw'),
(3, 231312, 'asdsa'),
(4, 123, 'dsadsa'),
(5, 123123, 'asddsaasd'),
(6, 234123, 'wadsds'),
(7, 12321312, 'asddfs');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Username` varchar(200) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`Id`, `Username`, `Email`, `Age`, `Password`) VALUES
(1, 'Esteban', 'Esteban@gmail.com', 12, '$2y$10$iV2zom2yRzkU71f1qBL2o.tuslzLAhaJU8P3CEdlrOVSJFqcp6Y1.');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aprendiz`
--
ALTER TABLE `aprendiz`
  ADD PRIMARY KEY (`ID_Aprendiz`),
  ADD KEY `ID_Ficha` (`ID_Ficha`);

--
-- Indices de la tabla `comite`
--
ALTER TABLE `comite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_aprendiz` (`id_aprendiz`),
  ADD KEY `id_ficha` (`id_ficha`);

--
-- Indices de la tabla `ficha`
--
ALTER TABLE `ficha`
  ADD PRIMARY KEY (`ID_Ficha`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aprendiz`
--
ALTER TABLE `aprendiz`
  MODIFY `ID_Aprendiz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `comite`
--
ALTER TABLE `comite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ficha`
--
ALTER TABLE `ficha`
  MODIFY `ID_Ficha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aprendiz`
--
ALTER TABLE `aprendiz`
  ADD CONSTRAINT `aprendiz_ibfk_1` FOREIGN KEY (`ID_Ficha`) REFERENCES `ficha` (`ID_Ficha`);

--
-- Filtros para la tabla `comite`
--
ALTER TABLE `comite`
  ADD CONSTRAINT `comite_ibfk_1` FOREIGN KEY (`id_aprendiz`) REFERENCES `aprendiz` (`ID_Aprendiz`),
  ADD CONSTRAINT `comite_ibfk_2` FOREIGN KEY (`id_ficha`) REFERENCES `ficha` (`ID_Ficha`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
