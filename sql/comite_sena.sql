-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-06-2024 a las 17:56:50
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
(1, '1139425046', 'CC', 'William', 'Esteban', 'Giraldo', 'Ariza', 'Esteban@gmail.com', '3195964478', 11, ''),
(2, '11394250468888', 'CC', 'Alberto', 'Esteban', 'Giraldo', 'Ariza', 'Esteban@gmail.com', '3195964478', 11, '');

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
(1, 'Centro de la Amazonia', 'Calle 10 No. 15-75, Leticia', 1),
(2, 'Centro de Formación para el Trabajo Antioquia', 'Calle 51 No. 40-27, Medellín', 2),
(3, 'Centro Agroindustrial y de Fortalecimiento Empresarial', 'Calle 20 No. 6-39, Arauca', 3),
(4, 'Centro de Comercio y Servicios del Atlántico', 'Calle 9 No. 45-31, Barranquilla', 4),
(5, 'Centro de Gestión de Mercados, Logística y Tecnologías de la Información', 'Calle 15 No. 31-42, Bogotá D.C.', 5),
(6, 'Centro para la Industria Petroquímica', 'Carrera 17 No. 32-18, Cartagena', 6),
(7, 'Centro de Gestión Administrativa y Fortalecimiento Empresarial del Boyacá', 'Carrera 9 No. 18-56, Tunja', 7),
(8, 'Centro para la Industria de la Comunicación Gráfica', 'Carrera 8 No. 22-39, Manizales', 8),
(9, 'Centro de Formación Agroindustrial de Caquetá', 'Carrera 2 No. 1-15, Florencia', 9),
(10, 'Centro de Formación para la Industria y los Servicios del Casanare', 'Carrera 10 No. 15-28, Yopal', 10),
(11, 'Centro de Comercio y Servicios del Cauca', 'Carrera 6 No. 7-12, Popayán', 11),
(12, 'Centro de Formación Agroindustrial del Cesar', 'Carrera 7 No. 10-56, Valledupar', 12),
(13, 'Centro de Recursos Naturales, Industria y Biodiversidad del Chocó', 'Carrera 1 No. 4-56, Quibdó', 13),
(14, 'Centro de Formación para el Desarrollo Agroindustrial y Minero', 'Calle 8 No. 11-23, Montería', 14),
(15, 'Centro de Formación para el Trabajo Cundinamarca', 'Carrera 5 No. 6-45, Chía', 15),
(16, 'Centro Ambiental y Ecoturístico del Nororiente Amazónico', 'Carrera 4 No. 5-67, Inírida', 16),
(17, 'Centro Ambiental y Ecológico del Guaviare', 'Calle 7 No. 3-56, San José del Guaviare', 17),
(18, 'Centro de la Industria, la Empresa y los Servicios del Huila', 'Carrera 5 No. 8-23, Neiva', 18),
(19, 'Centro Agroempresarial y Desarrollo Pecuario del Huila', 'Calle 6 No. 7-45, Garzón', 18),
(20, 'Centro Agroempresarial y Minero de La Guajira', 'Carrera 10 No. 9-34, Riohacha', 19),
(21, 'Centro de Logística y Promoción Ecoturística del Magdalena', 'Calle 11 No. 4-23, Santa Marta', 20),
(22, 'Centro Agroindustrial del Meta', 'Carrera 7 No. 4-56, Villavicencio', 21),
(23, 'Centro de Industria y Servicios del Meta', 'Calle 10 No. 6-34, Villavicencio', 21),
(24, 'Centro Internacional de Producción Limpia Lope', 'Calle 11 No. 8-23, Pasto', 22),
(25, 'Centro Surcolombiano de Logística Internacional', 'Carrera 5 No. 9-45, Pasto', 22),
(26, 'Centro de la Industria, la Empresa y los Servicios del Norte de Santander', 'Calle 14 No. 8-23, Cúcuta', 23),
(27, 'Centro de Formación para el Desarrollo Rural y Minero de Ocaña', 'Carrera 6 No. 7-34, Ocaña', 23),
(28, 'Centro Agroforestal y Acuícola Arapaima', 'Calle 7 No. 5-23, Mocoa', 24),
(29, 'Centro Agroindustrial del Quindío', 'Calle 10 No. 6-34, Armenia', 25),
(30, 'Centro de Comercio y Turismo del Quindío', 'Carrera 9 No. 8-45, Armenia', 25),
(31, 'Centro de Diseño e Innovación Tecnológica Industrial del Risaralda', 'Calle 13 No. 7-45, Pereira', 26),
(32, 'Centro Agropecuario y de Biotecnología El Porvenir', 'Carrera 2 No. 3-45, Montería', 14),
(33, 'Centro de Formación para la Industria y los Servicios de San Andrés y Providencia', 'Calle 10 No. 11-23, San Andrés', 27),
(34, 'Centro de Logística y Promoción Ecoturística de Santander', 'Calle 15 No. 6-45, Bucaramanga', 28),
(35, 'Centro de Formación Agroindustrial de Sucre', 'Calle 9 No. 10-34, Sincelejo', 29),
(36, 'Centro de Formación para el Trabajo de Tolima', 'Carrera 12 No. 15-23, Ibagué', 30),
(37, 'Centro de la Industria, la Empresa y los Servicios del Valle del Cauca', 'Calle 14 No. 8-23, Cali', 31),
(38, 'Centro de Formación para la Industria de Vaupés', 'Calle 7 No. 8-56, Mitú', 32),
(39, 'Centro de Formación para el Trabajo de Vichada', 'Calle 9 No. 10-67, Puerto Carreño', 33);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comite_extraordinario`
--

CREATE TABLE `comite_extraordinario` (
  `ID_extraordinario` int(11) NOT NULL,
  `Acta_Num` varchar(10) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Fecha` date NOT NULL DEFAULT current_timestamp(),
  `Hora_inicio` time NOT NULL,
  `Hora_fin` time NOT NULL,
  `Agendas` varchar(500) NOT NULL,
  `Objetivo` varchar(500) NOT NULL,
  `Desarrollo` varchar(500) NOT NULL,
  `Actividad` varchar(500) NOT NULL,
  `Responsable` varchar(600) NOT NULL,
  `ruta_foto` varchar(300) NOT NULL,
  `ID_ficha` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comite_extraordinario`
--

INSERT INTO `comite_extraordinario` (`ID_extraordinario`, `Acta_Num`, `Nombre`, `Fecha`, `Hora_inicio`, `Hora_fin`, `Agendas`, `Objetivo`, `Desarrollo`, `Actividad`, `Responsable`, `ruta_foto`, `ID_ficha`) VALUES
(1, '11', 'Nombre ', '2000-12-12', '12:12:00', '12:00:00', 'Agendas ', 'Objetivos ', 'Desarrollo ', 'Actividad', 'Responsable', '../uploads/GQXgy08bAAA2zFW.png', 11),
(2, '11', 'AAA', '2000-12-12', '00:12:00', '00:12:00', '12', '12', '121222', '121222', '121222', '../uploads/GQXgy08bAAA2zFW.png', 11),
(3, '11', '12', '2222-02-22', '14:22:00', '14:22:00', '22', '22', '22', '22', '222', '../uploads/GQXgy08bAAA2zFW.png', 11);

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
(11, 2620652, 'Análisis y desarrollo de Software', 1, 1, 1),
(12, 10002, 'Tecnología en Gestión Administrativa', 1, 2, 2),
(13, 10003, 'Tecnología en Mantenimiento Electromecánico Industrial', 1, 2, 2),
(14, 10004, 'Tecnología en Diseño Gráfico', 1, 1, 1),
(15, 10005, 'Tecnología en Logística', 1, 2, 1),
(16, 10006, 'Tecnología en Producción Agrícola', 1, 2, 1),
(17, 10007, 'Tecnología en Contabilidad y Finanzas', 1, 1, 2),
(18, 10008, 'Tecnología en Gestión del Talento Humano', 1, 2, 1),
(19, 10009, 'Tecnología en Electricidad Industrial', 1, 2, 2),
(20, 10010, 'Tecnología en Producción Multimedia', 1, 1, 1);

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
(1, 'Tecnologo'),
(2, 'Tecnico');

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
(1, 'Presencial'),
(2, 'Virtual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observaciones`
--

CREATE TABLE `observaciones` (
  `ID` int(11) NOT NULL,
  `Contenido` varchar(500) NOT NULL,
  `ID_Aprendiz` int(11) NOT NULL,
  `ID_extraordinario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `observaciones`
--

INSERT INTO `observaciones` (`ID`, `Contenido`, `ID_Aprendiz`, `ID_extraordinario`) VALUES
(1, 'Observación 1', 1, 1),
(2, 'Observación 2', 2, 1),
(3, '12', 1, 2),
(4, '22222', 2, 2),
(5, '222', 1, 3),
(6, '222', 2, 3);

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
-- Indices de la tabla `comite_extraordinario`
--
ALTER TABLE `comite_extraordinario`
  ADD PRIMARY KEY (`ID_extraordinario`),
  ADD KEY `ID_ficha` (`ID_ficha`);

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
-- Indices de la tabla `observaciones`
--
ALTER TABLE `observaciones`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Aprendiz` (`ID_Aprendiz`),
  ADD KEY `ID_extraordinario` (`ID_extraordinario`);

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
  MODIFY `ID_Aprendiz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `centro`
--
ALTER TABLE `centro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `comite`
--
ALTER TABLE `comite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comite_extraordinario`
--
ALTER TABLE `comite_extraordinario`
  MODIFY `ID_extraordinario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ficha`
--
ALTER TABLE `ficha`
  MODIFY `ID_Ficha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `formacion`
--
ALTER TABLE `formacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `modalidad`
--
ALTER TABLE `modalidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `observaciones`
--
ALTER TABLE `observaciones`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `regional`
--
ALTER TABLE `regional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aprendiz`
--
ALTER TABLE `aprendiz`
  ADD CONSTRAINT `fk_aprendiz_ficha` FOREIGN KEY (`ID_Ficha`) REFERENCES `ficha` (`ID_Ficha`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `centro`
--
ALTER TABLE `centro`
  ADD CONSTRAINT `centro_ibfk_1` FOREIGN KEY (`regional_id`) REFERENCES `regional` (`id`);

--
-- Filtros para la tabla `comite`
--
ALTER TABLE `comite`
  ADD CONSTRAINT `fk_comite_aprendiz` FOREIGN KEY (`id_aprendiz`) REFERENCES `aprendiz` (`ID_Aprendiz`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comite_ficha` FOREIGN KEY (`id_ficha`) REFERENCES `ficha` (`ID_Ficha`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comite_extraordinario`
--
ALTER TABLE `comite_extraordinario`
  ADD CONSTRAINT `fk_extraordinario_ficha` FOREIGN KEY (`ID_ficha`) REFERENCES `ficha` (`ID_Ficha`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ficha`
--
ALTER TABLE `ficha`
  ADD CONSTRAINT `fk_ficha_centro` FOREIGN KEY (`centro_id`) REFERENCES `centro` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ficha_formacion` FOREIGN KEY (`formacion_id`) REFERENCES `formacion` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ficha_modalidad` FOREIGN KEY (`modalidad_id`) REFERENCES `modalidad` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `observaciones`
--
ALTER TABLE `observaciones`
  ADD CONSTRAINT `fk_observaciones_aprendiz` FOREIGN KEY (`ID_Aprendiz`) REFERENCES `aprendiz` (`ID_Aprendiz`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_observaciones_extraordinario` FOREIGN KEY (`ID_extraordinario`) REFERENCES `comite_extraordinario` (`ID_extraordinario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
