-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2018 a las 08:46:23
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `controlescolar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id_alumno` int(11) NOT NULL,
  `nom_alumno` varchar(45) NOT NULL,
  `id_plan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id_alumno`, `nom_alumno`, `id_plan`) VALUES
(1011231, 'DIEGO GARCíA', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion`
--

CREATE TABLE `calificacion` (
  `id_calificacion` int(11) NOT NULL,
  `calificacion` float NOT NULL,
  `id_tipo_examen` int(11) NOT NULL,
  `id_inscripcion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `calificacion`
--

INSERT INTO `calificacion` (`id_calificacion`, `calificacion`, `id_tipo_examen`, `id_inscripcion`) VALUES
(1, 7.8, 1, 1),
(2, 8.5, 1, 2),
(3, 4.5, 1, 3),
(4, 6, 2, 3),
(5, 8, 1, 4),
(6, 8.9, 1, 5),
(7, 8.2, 1, 6),
(8, 5.6, 1, 7),
(9, 7.5, 2, 7),
(10, 8.4, 1, 8),
(11, 6, 1, 9),
(12, 4.7, 1, 10),
(13, 5.6, 2, 10),
(14, 8.5, 3, 10),
(15, 9.5, 1, 11),
(16, 6, 1, 12),
(17, 8.5, 1, 13),
(18, 9.2, 1, 14),
(19, 7.6, 1, 15),
(20, 7.3, 1, 16),
(21, 4.9, 1, 17),
(22, 5.6, 2, 17),
(23, 6, 3, 17),
(24, 4.5, 1, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `id_carrera` varchar(10) NOT NULL,
  `nom_carrera` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`id_carrera`, `nom_carrera`) VALUES
('ICO', 'Ingeniería en Computación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id_grupo` int(11) NOT NULL,
  `id_profesor` int(11) NOT NULL,
  `id_materia` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id_grupo`, `id_profesor`, `id_materia`) VALUES
(1, 1, 'L41013'),
(2, 2, 'L41011'),
(3, 3, 'L41001'),
(4, 4, 'L41010'),
(5, 5, 'L00062'),
(6, 6, 'L41104'),
(7, 7, 'L41002'),
(8, 8, 'L00070'),
(9, 9, 'L41107'),
(10, 10, 'L41003'),
(11, 11, 'L41020'),
(12, 12, 'L41109'),
(13, 13, 'L41012'),
(14, 14, 'L41065'),
(15, 15, 'L41054'),
(16, 16, 'L41053'),
(17, 17, 'L41032'),
(18, 18, 'L41109');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `id_salon` varchar(10) NOT NULL,
  `dia` varchar(60) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `h_i` varchar(60) NOT NULL,
  `h_f` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id_horario`, `id_salon`, `dia`, `id_grupo`, `h_i`, `h_f`) VALUES
(1, 'C401', 'Viernes', 1, '11:00', '01:00'),
(2, 'I201', 'Lunes,Miercoles,Viernes', 2, '07:00,07:00,07:00', '08:30,08:30,09:00'),
(3, 'I302', 'Lunes,Miercoles', 3, '07:00,07:00', '09:00,09:00'),
(4, 'I302', 'Lunes,Miercoles,Viernes', 4, '11:00,11:00,11:00', '01:00,01:00,01:00'),
(5, 'E201', 'Lunes,Miercoles', 5, '09:00,09:00', '11:00,11:00'),
(6, 'I302', 'Martes,Jueves', 6, '11:00,11:00', '01:00,01:00'),
(7, 'I201', 'Martes,Jueves', 7, '13:00,13:00', '15:00,15:00'),
(8, 'G201', 'Martes,Jueves', 8, '08:00,08:00', '09:30,09:30'),
(9, 'I203', 'Lunes,Miercoles,Viernes', 9, '13:00,13:00,13:00', '15:00,15:00,15:00'),
(10, 'I302', 'Martes,Jueves', 10, '12:00,12:00', '13:30,13:30'),
(11, 'C401', 'Martes,Jueves', 11, '13:00,13:00', '15:00,15:00'),
(12, 'C401', 'Lunes,Miercoles,Viernes', 12, '13:00,13:00,13:00', '15:00,15:00,15:00'),
(13, 'I302', 'Martes,Jueves', 13, '10:00,10:00', '12:30,12:30'),
(14, 'C403', 'Viernes', 14, '12:00', '15:00'),
(15, 'C406', 'Martes,Jueves', 15, '12:00,12:00', '13:30,13:30'),
(16, 'C403', 'Lunes,Miercoles,Viernes', 16, '07:00,07:00,07:00', '08:30,08:30,08:30'),
(17, 'C402', 'Martes,Jueves', 17, '10:00,10:00', '11:30,11:30'),
(18, 'C401', 'Lunes,Miercoles,Viernes', 18, '07:00,07:00,07:00', '09:00,09:00,09:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ins_alu_grupo`
--

CREATE TABLE `ins_alu_grupo` (
  `id_inscripcion` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `periodo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ins_alu_grupo`
--

INSERT INTO `ins_alu_grupo` (`id_inscripcion`, `id_alumno`, `id_grupo`, `periodo`) VALUES
(1, 1011231, 1, '2018A'),
(2, 1011231, 2, '2018A'),
(3, 1011231, 3, '2018A'),
(4, 1011231, 4, '2018A'),
(5, 1011231, 5, '2018A'),
(6, 1011231, 6, '2018A'),
(7, 1011231, 7, '2018A'),
(8, 1011231, 8, '2018A'),
(9, 1011231, 9, '2018A'),
(10, 1011231, 10, '2018A'),
(11, 1011231, 11, '2018A'),
(12, 1011231, 12, '2018A'),
(13, 1011231, 13, '2018A'),
(14, 1011231, 14, '2018A'),
(15, 1011231, 15, '2018A'),
(16, 1011231, 16, '2018A'),
(17, 1011231, 17, '2018A'),
(18, 1011231, 18, '2018A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE `materia` (
  `id_materia` varchar(40) NOT NULL,
  `nom_materia` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `materia`
--

INSERT INTO `materia` (`id_materia`, `nom_materia`) VALUES
('L00062', 'Ingles C1'),
('L00070', 'Ingles C2'),
('L41001', 'Algebra Superior'),
('L41002', 'Algebra Lineal'),
('L41003', 'Probabilidad y Estadistica'),
('L41010', 'Calculo 1'),
('L41011', 'Geometria Analitica'),
('L41012', 'Programación Estructurada'),
('L41013', 'Sociologia'),
('L41020', 'Fisica Basica'),
('L41032', 'Automatas y Lenguajes'),
('L41053', 'Programación Avanzada'),
('L41054', 'Estructura de Datos'),
('L41065', 'Logica'),
('L41104', 'Ecuaciones Diferenciales'),
('L41107', 'Calculo 2'),
('L41109', 'Calculo 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_estudio`
--

CREATE TABLE `plan_estudio` (
  `id_plan` int(11) NOT NULL,
  `plan_estudio` varchar(30) NOT NULL,
  `id_carrera` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `plan_estudio`
--

INSERT INTO `plan_estudio` (`id_plan`, `plan_estudio`, `id_carrera`) VALUES
(2, 'F2', 'ICO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `id_profesor` int(11) NOT NULL,
  `nom_profesor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`id_profesor`, `nom_profesor`) VALUES
(1, 'Osorio Chong'),
(2, 'Zoriel'),
(3, 'Cecilia'),
(4, 'Bernardo'),
(5, 'Sussana'),
(6, 'José Caballero'),
(7, 'Brenda'),
(8, 'Andrea'),
(9, 'Solis'),
(10, 'Javier'),
(11, 'María Rosa'),
(12, 'Coria'),
(13, 'Trujillo'),
(14, 'Karen'),
(15, 'Felipe Camacho'),
(16, 'Elfego'),
(17, 'Toche'),
(18, 'XAVIER ANGELES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salon`
--

CREATE TABLE `salon` (
  `id_salon` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `salon`
--

INSERT INTO `salon` (`id_salon`) VALUES
('C401'),
('C402'),
('C403'),
('C405'),
('C406'),
('E201'),
('G201'),
('I201'),
('I203'),
('I302'),
('I303'),
('I304');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_examen`
--

CREATE TABLE `tipo_examen` (
  `id_tipo_examen` int(11) NOT NULL,
  `tipo_examen` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_examen`
--

INSERT INTO `tipo_examen` (`id_tipo_examen`, `tipo_examen`) VALUES
(1, 'Ordinario'),
(2, 'Extraordinario'),
(3, 'Titulo'),
(4, 'Especial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nombre` varchar(50) NOT NULL,
  `contraseña` varchar(10) NOT NULL,
  `tipo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nombre`, `contraseña`, `tipo`) VALUES
('XAVIDIEGO', '12345', 'Administrador'),
('DIEGO GARCíA', '12345', 'Alumno'),
('XAVIER ANGELES', '12345', 'Docente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id_alumno`),
  ADD KEY `id_plan` (`id_plan`);

--
-- Indices de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD PRIMARY KEY (`id_calificacion`),
  ADD KEY `id_tipo_examen` (`id_tipo_examen`),
  ADD KEY `id_inscripcion` (`id_inscripcion`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`id_carrera`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id_grupo`),
  ADD KEY `id_profesor` (`id_profesor`),
  ADD KEY `id_materia` (`id_materia`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id_horario`),
  ADD KEY `id_grupo` (`id_grupo`),
  ADD KEY `id_salon` (`id_salon`);

--
-- Indices de la tabla `ins_alu_grupo`
--
ALTER TABLE `ins_alu_grupo`
  ADD PRIMARY KEY (`id_inscripcion`),
  ADD KEY `id_alumno` (`id_alumno`),
  ADD KEY `id_grupo` (`id_grupo`);

--
-- Indices de la tabla `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`id_materia`);

--
-- Indices de la tabla `plan_estudio`
--
ALTER TABLE `plan_estudio`
  ADD PRIMARY KEY (`id_plan`),
  ADD KEY `id_carrera` (`id_carrera`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`id_profesor`);

--
-- Indices de la tabla `salon`
--
ALTER TABLE `salon`
  ADD PRIMARY KEY (`id_salon`);

--
-- Indices de la tabla `tipo_examen`
--
ALTER TABLE `tipo_examen`
  ADD PRIMARY KEY (`id_tipo_examen`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1011232;

--
-- AUTO_INCREMENT de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  MODIFY `id_calificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `ins_alu_grupo`
--
ALTER TABLE `ins_alu_grupo`
  MODIFY `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `plan_estudio`
--
ALTER TABLE `plan_estudio`
  MODIFY `id_plan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `profesor`
--
ALTER TABLE `profesor`
  MODIFY `id_profesor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tipo_examen`
--
ALTER TABLE `tipo_examen`
  MODIFY `id_tipo_examen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `alumno_ibfk_1` FOREIGN KEY (`id_plan`) REFERENCES `plan_estudio` (`id_plan`);

--
-- Filtros para la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD CONSTRAINT `calificacion_ibfk_1` FOREIGN KEY (`id_tipo_examen`) REFERENCES `tipo_examen` (`id_tipo_examen`),
  ADD CONSTRAINT `calificacion_ibfk_2` FOREIGN KEY (`id_inscripcion`) REFERENCES `ins_alu_grupo` (`id_inscripcion`);

--
-- Filtros para la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD CONSTRAINT `grupo_ibfk_1` FOREIGN KEY (`id_profesor`) REFERENCES `profesor` (`id_profesor`),
  ADD CONSTRAINT `grupo_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`);

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_2` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`),
  ADD CONSTRAINT `horario_ibfk_3` FOREIGN KEY (`id_salon`) REFERENCES `salon` (`id_salon`);

--
-- Filtros para la tabla `ins_alu_grupo`
--
ALTER TABLE `ins_alu_grupo`
  ADD CONSTRAINT `ins_alu_grupo_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`),
  ADD CONSTRAINT `ins_alu_grupo_ibfk_2` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
