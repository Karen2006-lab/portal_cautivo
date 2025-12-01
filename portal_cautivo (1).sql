-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-12-2025 a las 16:49:06
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
-- Base de datos: `portal_cautivo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_navegacion`
--

CREATE TABLE `historial_navegacion` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `ip` varchar(45) NOT NULL,
  `fecha` datetime NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('usuario','administrador') NOT NULL DEFAULT 'usuario',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `cedula`, `correo`, `contrasena`, `rol`, `fecha_registro`) VALUES
(26, 'karen', 'ushca', '0605320720', 'karitojhona17@gmail.com', '$2y$10$c0l0wJk2JHitLSxKETFgw.9qRRlb912V9IR1wfHq8ggR20yVUF952', 'administrador', '2025-06-20 00:00:39'),
(28, 'elizabeth ', 'cajamarca', '0602678955', 'elizabeth@gmail.com', '', 'usuario', '2025-07-10 20:27:46'),
(29, 'Mauricio', 'Paltán', '0603459249', 'tareasdeberes386@gmail.com', '', 'usuario', '2025-07-15 20:00:36'),
(30, 'Diana', 'Naula', '060628086-5', 'dianamarcatoma93@gmail.com', '', 'usuario', '2025-07-15 20:08:58'),
(31, 'Stalyn', 'Taday', '065037154-7', 'stalyntaday1232@gmail.com', '', 'usuario', '2025-07-15 20:08:58'),
(32, 'Josue', 'Larrea', '060599194-2', 'josuelarreac@gmail.com', '', 'usuario', '2025-07-15 20:08:58'),
(33, 'Maribel', 'Yambay', '065026414-6', 'yamabymaribel0@gmail.com', '', 'usuario', '2025-07-15 20:08:58'),
(34, 'Wilmer', 'Obando', '060473974-8', 'obandowilmer59@gmail.com', '', 'usuario', '2025-07-15 20:08:58'),
(35, 'Junior', 'Inchiglema', '060608768-2', 'Inchiglemajunior@gmail.com', '', 'usuario', '2025-07-15 20:08:58'),
(113, 'Brando ', 'Tingo ', '0605886779', 'brandotingo@gmail.com', '', 'usuario', '2025-07-17 14:50:14'),
(114, 'Kevin', 'Moncayo', '0954494951', 'kevinmoncayo@gmail.com', '', 'usuario', '2025-07-17 14:53:23'),
(115, 'David', 'Rivera', '0605796697', 'davichochili26@gmail.com', '', 'usuario', '2025-07-17 14:53:23'),
(116, 'Deyvi', 'Vera', '1206881334', 'deyvivera2004@gmail.com', '', 'usuario', '2025-07-17 14:53:23'),
(122, 'Angelo', 'Quito', '0605908805', 'aaqp2004@gmail.com', '', 'usuario', '2025-07-22 20:04:02'),
(123, 'Jefferson ', 'Caguano', '0606149896', 'leonciocaguano13@gmail.com', '', 'usuario', '2025-07-22 20:04:02'),
(124, 'Wendy ', 'Casa', '0606166692', 'brigithchicaiza51@gmail.com', '', 'usuario', '2025-07-22 20:04:02'),
(125, 'Katherin', 'Quispe', '0650249212', 'katherinsquispe18@gmail.com', '', 'usuario', '2025-07-22 20:04:02'),
(126, 'Jhonatan', 'Nono', '0650271281', 'jhonatannono22@gmail.com', '', 'usuario', '2025-07-22 20:04:02'),
(127, 'Joselyn', 'Yupa', '0605826700', 'josyxd23@gmail.com', '', 'usuario', '2025-07-22 20:04:02'),
(128, 'Carolina', 'Cargua', '0605756014', 'carmen12quiguiri@gmail.com', '', 'usuario', '2025-07-22 20:04:02'),
(129, 'Ylenea', 'Vimos', '0605975986', 'Vimosylenea10c@gmail.com', '', 'usuario', '2025-07-22 20:04:02'),
(130, 'Kennedy ', 'Figueroa ', '2200290274', 'kennedyfigueroa016@gmail.com', '', 'usuario', '2025-07-22 20:04:02'),
(131, 'Joseph ', 'Lozada', '1805339833', 'Vinilozada.25@gmail.com', '', 'usuario', '2025-07-22 20:04:02'),
(132, 'Dionís ', 'Cabezas', '0605740760', 'dionis.cabezas86@gmail.com', '', 'usuario', '2025-07-22 20:04:02');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `historial_navegacion`
--
ALTER TABLE `historial_navegacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `historial_navegacion`
--
ALTER TABLE `historial_navegacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial_navegacion`
--
ALTER TABLE `historial_navegacion`
  ADD CONSTRAINT `historial_navegacion_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
