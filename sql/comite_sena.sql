-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-06-2024 a las 18:26:40
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
-- Base de datos: `comite_sena`
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
  `ID_Ficha` int(11) DEFAULT NULL,
  `Imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aprendiz`
--

INSERT INTO `aprendiz` (`ID_Aprendiz`, `Numero_Documento`, `Tipo_Documento`, `Primer_Nombre`, `Segundo_Nombre`, `Primer_Apellido`, `Segundo_Apellido`, `Email`, `Telefono`, `ID_Ficha`, `Imagen`) VALUES
(49, '1048264905', 'CE', 'omar', 'Daviddddddddd', 'Camargo', 'Narvaez', 'stivencito123@gmail.com', '3007097628', 16, 'R.jpg'),
(59, '10828352977', 'CC', 'Steven', 'raul', 'alfonso', 'mosquera', 'omar123@gmail.com', '2017281410', 0, '3155cae422f11de4a94b92337751b0d1.jpg'),
(60, '10828352977', 'CC', 'Steven', 'raul', 'alfonso', 'mosquera', 'omar123@gmail.com', '2017281410', 0, '3155cae422f11de4a94b92337751b0d1.jpg'),
(61, '1048264905', 'CC', 'Omar', 'Alfonso', 'Camargo', 'Mosquera', 'stivencito123@gmail.com', '3007097628', 18, 'descarga.png'),
(63, '1048264905', 'CC', 'Antony ', 'Osorio', 'Camargo', 'Mosquera', 'stivencito123@gmail.com', '3007097628', 16, '3155cae422f11de4a94b92337751b0d1 (1).jpg'),
(66, '1048264905', 'TI', 'esteban', 'Osorio', 'Camargo', 'Mosquera', 'stivencito123@gmail.com', '3007097628', 17, '3155cae422f11de4a94b92337751b0d1 (1).jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro`
--

CREATE TABLE `centro` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `regional_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `centro`
--

INSERT INTO `centro` (`id`, `nombre`, `direccion`, `regional_id`) VALUES
(26, 'Centro Biotecnológico del Caribe', 'Carrera 17 No. 14-20, Valledupar', 12),
(27, 'Centro de Operación y Mantenimiento Minero', 'Calle 13 No. 8-34, Valledupar', 12),
(28, 'Centro de Recursos Naturales, Industria y Biodiversidad', 'Carrera 1 No. 4-56, Quibdó', 13),
(29, 'Centro Agropecuario y de Biotecnología El Porvenir', 'Carrera 2 No. 3-45, Montería', 14),
(30, 'Centro de Comercio, Industria y Turismo', 'Carrera 5 No. 4-12, Montería', 14),
(31, 'Centro de Biotecnología Agropecuaria', 'Calle 8 No. 9-57, Mosquera', 15),
(32, 'Centro de Desarrollo Agroempresarial', 'Carrera 9 No. 8-23, Chía', 15),
(33, 'Centro Industrial y de Desarrollo Empresarial de Soacha', 'Calle 13 No. 10-45, Soacha', 15),
(34, 'Centro Ambiental y Ecoturístico del Nororiente Amazónico', 'Carrera 4 No. 5-67, Inírida', 16),
(35, 'Centro Ambiental y Ecológico del Guaviare', 'Calle 7 No. 3-56, San José del Guaviare', 17),
(36, 'Centro de la Industria, la Empresa y los Servicios', 'Carrera 5 No. 8-23, Neiva', 18),
(37, 'Centro Agroempresarial y Desarrollo Pecuario del Huila', 'Calle 6 No. 7-45, Garzón', 18),
(38, 'Centro Agroempresarial y Minero', 'Carrera 10 No. 9-34, Riohacha', 19),
(39, 'Centro de Logística y Promoción Ecoturística del Magdalena', 'Calle 11 No. 4-23, Riohacha', 19),
(40, 'Centro Acuícola y Agroindustrial de Gaira', 'Calle 12 No. 13-45, Santa Marta', 20),
(41, 'Centro de Logística y Promoción Ecoturística del Magdalena', 'Carrera 1 No. 5-67, Santa Marta', 20),
(42, 'Centro Agroindustrial del Meta', 'Carrera 7 No. 4-56, Villavicencio', 21),
(43, 'Centro de Industria y Servicios del Meta', 'Calle 10 No. 6-34, Villavicencio', 21),
(44, 'Centro Internacional de Producción Limpia Lope', 'Calle 11 No. 8-23, Pasto', 22),
(45, 'Centro Surcolombiano de Logística Internacional', 'Carrera 5 No. 9-45, Pasto', 22),
(46, 'Centro de la Industria, la Empresa y los Servicios', 'Calle 14 No. 8-23, Cúcuta', 23),
(47, 'Centro de Formación para el Desarrollo Rural y Minero', 'Carrera 6 No. 7-34, Ocaña', 23),
(48, 'Centro Agroforestal y Acuícola Arapaima', 'Calle 7 No. 5-23, Mocoa', 24),
(49, 'Centro Agroindustrial del Quindío', 'Calle 10 No. 6-34, Armenia', 25),
(50, 'Centro de Comercio y Turismo del Quindío', 'Carrera 9 No. 8-45, Armenia', 25),
(51, 'Centro de Diseño e Innovación Tecnológica Industrial', 'Calle 13 No. 7-45, Pereira', 26);

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
(1, 1, 1, 'cambiar', 1),
(2, 1, 1, 'adasdsss', 2),
(4, 1, 1, 'sddddddd', 1),
(6, 1, 1, 'fffffffffffffhhh', 1),
(7, 1, 1, 'ewqeqweqqq', 2),
(8, 5, 1, 'el,wpfomwepofmwpofmwoemffwfo ahhahahahah', 1),
(9, 10, 11, 'se porta demasiado mal ', 2),
(10, 1, 1, 'el aprendiz debe ser remitido a bienestar', 1),
(11, 1, 16, 'esta persona fue aplazada', 2),
(12, 1, 16, 'esta persona fue expulada', 6),
(13, 1, 16, 'lo en encontraron vendiendo perico en los baños', 5),
(14, 22, 17, 'esta persona se porta muy mal en clases y no asiste', 1),
(15, 22, 17, 'lo mismo que el comite pasado', 2),
(16, 22, 17, 'no mijo todavia?', 3),
(17, 22, 17, 'vamos es a sacarte del sena', 4),
(18, 22, 17, 'vendiendo?', 5),
(19, 22, 17, 'comprando?', 6),
(20, 46, 16, 'gggg', 1),
(21, 53, 17, 'esta persona tiene que entregar un informe completo', 5),
(22, 54, 21, 'esta persona fue aplazada', 1),
(23, 54, 21, 'esta persona fue encontrada metiendo vicio', 2),
(24, 36, 16, 'que es la vaina mija', 5),
(25, 36, 16, 'aja y entonces', 6),
(26, 36, 16, 'malooo', 2),
(27, 36, 16, 'locooo', 3),
(28, 52, 16, 'locooo', 5),
(29, 52, 16, 'locooo', 2),
(30, 52, 16, 'klk', 6),
(31, 52, 16, 'klkl mamawebo', 6),
(32, 52, 16, 'ajaaaaaaaaaaaaaaa', 2),
(33, 47, 16, 'este man tenia una gorra', 3),
(34, 63, 16, 'este man tiene el dedo mocho', 1),
(35, 66, 17, 'esteban va para comite', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comite_general`
--

CREATE TABLE `comite_general` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `puntos_destacados` text NOT NULL,
  `objetivos` text NOT NULL,
  `ID_Ficha` int(11) NOT NULL,
  `desarrollo` text NOT NULL,
  `asistentes` varchar(255) NOT NULL,
  `actividad` text NOT NULL,
  `responsable` text NOT NULL,
  `fecha_compromiso` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comite_general`
--

INSERT INTO `comite_general` (`id`, `nombre`, `fecha`, `hora_inicio`, `hora_fin`, `puntos_destacados`, `objetivos`, `ID_Ficha`, `desarrollo`, `asistentes`, `actividad`, `responsable`, `fecha_compromiso`) VALUES
(3, 'sancion ', '2024-06-06', '12:00:00', '12:00:00', 'hhhhhhhhhggg', 'hhhh', 2, '', '', '', '', NULL),
(16, 'sancion 23', '2024-06-06', '17:44:00', '21:41:00', 'nhhhhhhh', 'hjjkjkjk', 1, '', '', '', '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha`
--

CREATE TABLE `ficha` (
  `ID_Ficha` int(11) NOT NULL,
  `Numero_Ficha` int(20) NOT NULL,
  `Nombre_Ficha` varchar(255) NOT NULL,
  `modalidad_id` int(11) DEFAULT NULL,
  `formacion_id` int(11) DEFAULT NULL,
  `centro_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ficha`
--

INSERT INTO `ficha` (`ID_Ficha`, `Numero_Ficha`, `Nombre_Ficha`, `modalidad_id`, `formacion_id`, `centro_id`) VALUES
(16, 123456, 'Electricidad Industrial', 1, 1, 1),
(17, 234567, 'Mantenimiento de Equipos Biomédicos', 2, 2, 2),
(18, 345678, 'Diseño Gráfico Digital', 1, 1, 3),
(19, 456789, 'Administración de Empresas Agropecuarias', 1, 1, 4),
(20, 567890, 'Ingeniería de Sistemas', 2, 2, 5),
(21, 12345678, 'sistemas', 1, 2, 27),
(22, 12121212, 'construccion', 1, 2, 35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formacion`
--

CREATE TABLE `formacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `formacion`
--

INSERT INTO `formacion` (`id`, `nombre`) VALUES
(1, 'tecnólogo'),
(2, 'técnico'),
(3, 'operario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidad`
--

CREATE TABLE `modalidad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modalidad`
--

INSERT INTO `modalidad` (`id`, `nombre`) VALUES
(1, 'presencial'),
(2, 'virtual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regional`
--

CREATE TABLE `regional` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `regional`
--

INSERT INTO `regional` (`id`, `nombre`) VALUES
(1, 'Amazonas'),
(2, 'Antioquia'),
(3, 'Arauca'),
(4, 'Atlántico'),
(5, 'Bogotá D.C.'),
(6, 'Bolívar'),
(7, 'Boyacá'),
(8, 'Caldas'),
(9, 'Caquetá'),
(10, 'Casanare'),
(11, 'Cauca'),
(12, 'Cesar'),
(13, 'Chocó'),
(14, 'Córdoba'),
(15, 'Cundinamarca'),
(16, 'Guainía'),
(17, 'Guaviare'),
(18, 'Huila'),
(19, 'La Guajira'),
(20, 'Magdalena'),
(21, 'Meta'),
(22, 'Nariño'),
(23, 'Norte de Santander'),
(24, 'Putumayo'),
(25, 'Quindío'),
(26, 'Risaralda'),
(27, 'San Andrés y Providencia'),
(28, 'Santander'),
(29, 'Sucre'),
(30, 'Tolima'),
(31, 'Valle del Cauca'),
(32, 'Vaupés'),
(33, 'Vichada');

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
(1, 'Esteban', 'Esteban@gmail.com', 12, '$2y$10$iV2zom2yRzkU71f1qBL2o.tuslzLAhaJU8P3CEdlrOVSJFqcp6Y1.'),
(2, 'steven', 'stevencito123@gmail.com', 20, '$2y$10$Con2S3E2Biet0t/HjVX65eigGPMoEMlivn3QisnFqXPCGtWRko2Ai');

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
-- Indices de la tabla `centro`
--
ALTER TABLE `centro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regional_id` (`regional_id`);

--
-- Indices de la tabla `comite`
--
ALTER TABLE `comite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_aprendiz` (`id_aprendiz`),
  ADD KEY `id_ficha` (`id_ficha`);

--
-- Indices de la tabla `comite_general`
--
ALTER TABLE `comite_general`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_ficha` (`ID_Ficha`);

--
-- Indices de la tabla `ficha`
--
ALTER TABLE `ficha`
  ADD PRIMARY KEY (`ID_Ficha`),
  ADD KEY `modalidad_id` (`modalidad_id`),
  ADD KEY `formacion_id` (`formacion_id`),
  ADD KEY `centro_id` (`centro_id`);

--
-- Indices de la tabla `formacion`
--
ALTER TABLE `formacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modalidad`
--
ALTER TABLE `modalidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `regional`
--
ALTER TABLE `regional`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `ID_Aprendiz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `centro`
--
ALTER TABLE `centro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `comite`
--
ALTER TABLE `comite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `comite_general`
--
ALTER TABLE `comite_general`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `ficha`
--
ALTER TABLE `ficha`
  MODIFY `ID_Ficha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `formacion`
--
ALTER TABLE `formacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `modalidad`
--
ALTER TABLE `modalidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `regional`
--
ALTER TABLE `regional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `centro`
--
ALTER TABLE `centro`
  ADD CONSTRAINT `centro_ibfk_1` FOREIGN KEY (`regional_id`) REFERENCES `regional` (`id`);

--
-- Filtros para la tabla `ficha`
--
ALTER TABLE `ficha`
  ADD CONSTRAINT `ficha_ibfk_1` FOREIGN KEY (`modalidad_id`) REFERENCES `modalidad` (`id`),
  ADD CONSTRAINT `ficha_ibfk_2` FOREIGN KEY (`formacion_id`) REFERENCES `formacion` (`id`),
  ADD CONSTRAINT `ficha_ibfk_3` FOREIGN KEY (`centro_id`) REFERENCES `centro` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
