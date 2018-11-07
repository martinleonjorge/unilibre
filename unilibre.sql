-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 07-11-2018 a las 22:15:18
-- Versión del servidor: 10.1.24-MariaDB
-- Versión de PHP: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `unilibre`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blocks`
--

CREATE TABLE `blocks` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `blocks`
--

INSERT INTO `blocks` (`id`, `name`) VALUES
(2, 'Bloque A'),
(3, 'Bloque B'),
(4, 'Bloque C');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(5, 'f'),
(2, 'Hardware'),
(3, 'Laboratorios'),
(4, 'sdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `stock_total` int(11) DEFAULT NULL,
  `stock_loan` int(11) DEFAULT NULL,
  `stock_available` int(11) NOT NULL,
  `categorie_id` int(11) UNSIGNED NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `stock_total`, `stock_loan`, `stock_available`, `categorie_id`, `date`) VALUES
(5, 'prueba3', 10, 0, 10, 2, '2018-10-17 19:35:22'),
(6, 'pruebaprueba3', 10, 0, 10, 3, '2018-10-17 20:34:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(4, 'Jorge', 'jm', '112f489f6b265cdf4e4892f7b952cd36fc0ecd5f', 1, 'libre.jpg', 1, '2018-10-17 21:09:15'),
(5, 'Test', 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 2, 'tazmania.jpg', 1, '2018-10-17 20:14:57'),
(6, 'Usuario', 'usuario', 'b665e217b51994789b02b1838e730d6b93baa30f', 3, 'marvin.png', 1, '2018-10-17 21:08:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'test', 2, 1),
(3, 'User', 3, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `user_level` (`user_level`);

--
-- Indices de la tabla `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_level` (`group_level`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_products` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
