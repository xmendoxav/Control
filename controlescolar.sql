-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-05-2018 a las 08:12:29
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
(1011228, 'Diego Escorza García', 1);

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
(1, 78, 1, 1),
(2, 70, 1, 2),
(3, 46, 1, 3),
(4, 64, 2, 3),
(5, 58, 1, 4),
(6, 75, 2, 4),
(7, 56, 1, 5),
(8, 85, 2, 5),
(9, 80, 1, 6),
(10, 85, 1, 7),
(11, 84, 1, 8),
(12, 79, 1, 9),
(13, 91, 1, 10),
(14, 45, 1, 11),
(15, 60, 2, 11),
(16, 80, 1, 12),
(17, 92, 1, 14),
(18, 81, 2, 15),
(19, 60, 1, 17);

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
(1, 1, 'L00062'),
(2, 1, 'L00070'),
(3, 3, 'L41001'),
(4, 2, 'L41002'),
(5, 4, 'L41003'),
(6, 5, 'L41010'),
(7, 6, 'L41011'),
(8, 7, 'L41012'),
(9, 8, 'L41013'),
(10, 9, 'L41020'),
(11, 10, 'L41032'),
(12, 11, 'L41053'),
(13, 13, 'L41054'),
(14, 13, 'L41065'),
(15, 12, 'L41104'),
(16, 13, 'L41104'),
(17, 15, 'L41109');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `id_salon` int(11) NOT NULL,
  `dia_hora` varchar(40) NOT NULL,
  `id_grupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ins_alu_grupo`
--

CREATE TABLE `ins_alu_grupo` (
  `id_inscripcion` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ins_alu_grupo`
--

INSERT INTO `ins_alu_grupo` (`id_inscripcion`, `id_alumno`, `id_grupo`) VALUES
(1, 1011228, 1),
(2, 1011228, 2),
(3, 1011228, 3),
(4, 1011228, 4),
(5, 1011228, 5),
(6, 1011228, 6),
(7, 1011228, 7),
(8, 1011228, 8),
(9, 1011228, 9),
(10, 1011228, 10),
(11, 1011228, 11),
(12, 1011228, 12),
(13, 1011228, 13),
(14, 1011228, 14),
(15, 1011228, 15),
(16, 1011228, 16),
(17, 1011228, 17);

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
('L41032', 'Automatas y Lenguajes Formales'),
('L41053', 'Programacion Avanzada'),
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
(1, 'F2', 'ICO');

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
(1, 'Susana'),
(2, 'Brenda'),
(3, 'Cecilia'),
(4, 'Oscar'),
(5, 'Bernardo'),
(6, 'Zoriel'),
(7, 'Chong'),
(8, 'Maria Rosa'),
(9, 'Jose Caballero'),
(10, 'Solis'),
(11, 'Coria'),
(12, 'Toche'),
(13, 'Elfego'),
(14, 'Felipe Camacho'),
(15, 'Karla'),
(18, 'XAVIER ANGELES'),
(19, 'JORGE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salon`
--

CREATE TABLE `salon` (
  `id_salon` int(11) NOT NULL,
  `salon` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `salon`
--

INSERT INTO `salon` (`id_salon`, `salon`) VALUES
(1, 'I201'),
(2, 'I301'),
(3, 'I302'),
(4, 'I303'),
(5, 'I304'),
(6, 'C401'),
(7, 'C402'),
(8, 'C403'),
(9, 'C404'),
(10, 'C405'),
(11, 'C406'),
(12, 'C407'),
(13, 'C408'),
(14, 'E201'),
(15, 'I202'),
(16, 'I203'),
(17, 'I203'),
(18, 'I204'),
(19, 'G201');

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
('Diego Escorza García', '12345', 'Administrador'),
('XAVIER ANGELES', '12345', 'Docente'),
('JORGE RODRIGUEZ', '12345', 'Alumno');

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
  ADD KEY `id_salon` (`id_salon`),
  ADD KEY `id_grupo` (`id_grupo`);

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
  MODIFY `id_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1011229;

--
-- AUTO_INCREMENT de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  MODIFY `id_calificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ins_alu_grupo`
--
ALTER TABLE `ins_alu_grupo`
  MODIFY `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `plan_estudio`
--
ALTER TABLE `plan_estudio`
  MODIFY `id_plan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `profesor`
--
ALTER TABLE `profesor`
  MODIFY `id_profesor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `salon`
--
ALTER TABLE `salon`
  MODIFY `id_salon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`id_salon`) REFERENCES `salon` (`id_salon`),
  ADD CONSTRAINT `horario_ibfk_2` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`);

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
