-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-02-2023 a las 02:50:49
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `muebles_giannis`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(100) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`, `activo`) VALUES
(1, 'Comedor', 1),
(2, 'Dormitorio', 1),
(3, 'Living', 1),
(4, 'Oficina', 1),
(7, 'Jardin', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(255) NOT NULL,
  `id_usuario` int(255) NOT NULL,
  `total` int(255) NOT NULL,
  `id_transaccion` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `id` int(7) NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `texto` varchar(500) NOT NULL,
  `respondido` tinyint(1) NOT NULL DEFAULT 0,
  `usuario_id` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`id`, `email`, `nombre`, `apellido`, `texto`, `respondido`, `usuario_id`) VALUES
(21, 'davidbenedette@gmail.com', 'Diegote', 'Benedette', 'asdsadsa', 0, NULL),
(22, 'davidbenedette@gmail.com', 'dasdsa', 'dsadas', 'dsadsadsa', 0, NULL),
(23, NULL, 'sdasd', 'dsadsa', 'dsadsadsa', 0, 11),
(24, NULL, 'Marcos', 'Maradona', 'Que tarjetas aceptan?', 0, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `precio` int(10) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorito`
--

CREATE TABLE `favorito` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `favorito`
--

INSERT INTO `favorito` (`id`, `id_producto`, `id_usuario`) VALUES
(26, 5, 12),
(30, 34, 12),
(32, 1, 12),
(33, 25, 12),
(34, 10, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen_categorias`
--

CREATE TABLE `imagen_categorias` (
  `id` int(255) NOT NULL,
  `id_categoria` int(255) NOT NULL,
  `destination` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `imagen_categorias`
--

INSERT INTO `imagen_categorias` (`id`, `id_categoria`, `destination`) VALUES
(1, 1, 'images/categorias/1.png'),
(2, 2, 'images/categorias/2.png'),
(3, 3, 'images/categorias/3.png'),
(4, 4, 'images/categorias/4.png'),
(5, 7, 'images/categorias/7.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen_productos`
--

CREATE TABLE `imagen_productos` (
  `id` int(255) NOT NULL,
  `id_producto` int(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `portada` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `imagen_productos`
--

INSERT INTO `imagen_productos` (`id`, `id_producto`, `destination`, `portada`) VALUES
(3, 1, 'images/1/5/1/portada.png', 1),
(4, 2, 'images/1/5/2/portada.png', 1),
(5, 3, 'images/1/5/3/portada.png', 1),
(14, 5, 'images/1/5/5/portada.png', 1),
(15, 6, 'images/1/5/6/portada.png', 1),
(16, 7, 'images/1/8/7/portada.png', 1),
(17, 8, 'images/1/8/8/portada.png', 1),
(18, 9, 'images/1/8/9/portada.png', 1),
(19, 10, 'images/1/8/10/portada.png', 1),
(20, 11, 'images/1/8/11/portada.png', 1),
(21, 12, 'images/1/8/12/portada.png', 1),
(22, 13, 'images/1/10/13/portada.png', 1),
(23, 14, 'images/1/10/14/portada.png', 1),
(24, 15, 'images/1/10/15/portada.png', 1),
(25, 16, 'images/1/10/16/portada.png', 1),
(26, 17, 'images/1/10/17/portada.png', 1),
(27, 18, 'images/1/10/18/portada.png', 1),
(28, 19, 'images/2/2/19/portada.png', 1),
(29, 20, 'images/2/2/20/portada.png', 1),
(30, 21, 'images/2/2/21/portada.png', 1),
(31, 22, 'images/2/2/22/portada.png', 1),
(32, 23, 'images/2/2/23/portada.png', 1),
(33, 24, 'images/2/2/24/portada.png', 1),
(34, 25, 'images/2/3/25/portada.png', 1),
(35, 26, 'images/2/3/26/portada.png', 1),
(36, 27, 'images/2/3/27/portada.png', 1),
(37, 28, 'images/2/3/28/portada.png', 1),
(38, 29, 'images/2/3/29/portada.png', 1),
(39, 30, 'images/2/3/30/portada.png', 1),
(40, 31, 'images/2/7/31/portada.png', 1),
(41, 32, 'images/2/7/32/portada.png', 1),
(42, 33, 'images/2/7/33/portada.png', 1),
(43, 34, 'images/2/7/34/portada.png', 1),
(44, 35, 'images/2/7/35/portada.png', 1),
(45, 36, 'images/2/7/36/portada.png', 1),
(46, 37, 'images/2/9/37/portada.png', 1),
(47, 38, 'images/2/9/38/portada.png', 1),
(48, 39, 'images/2/9/39/portada.png', 1),
(49, 40, 'images/2/9/40/portada.png', 1),
(50, 41, 'images/2/9/41/portada.png', 1),
(51, 42, 'images/2/9/42/portada.png', 1),
(52, 43, 'images/3/4/43/portada.png', 1),
(53, 44, 'images/3/4/44/portada.png', 1),
(54, 45, 'images/3/4/45/portada.png', 1),
(55, 46, 'images/3/4/46/portada.png', 1),
(56, 47, 'images/3/4/47/portada.png', 1),
(57, 48, 'images/3/4/48/portada.png', 1),
(58, 49, 'images/3/12/49/portada.png', 1),
(59, 50, 'images/3/12/50/portada.png', 1),
(60, 51, 'images/3/12/51/portada.png', 1),
(61, 52, 'images/3/12/52/portada.png', 1),
(62, 53, 'images/3/12/53/portada.png', 1),
(63, 54, 'images/3/12/54/portada.png', 1),
(64, 55, 'images/4/1/55/portada.png', 1),
(65, 56, 'images/4/1/56/portada.png', 1),
(66, 57, 'images/4/1/57/portada.png', 1),
(67, 58, 'images/4/1/58/portada.png', 1),
(68, 59, 'images/4/1/59/portada.png', 1),
(69, 60, 'images/4/1/60/portada.jpg', 1),
(70, 61, 'images/4/6/61/portada.png', 1),
(71, 62, 'images/4/6/62/portada.png', 1),
(72, 63, 'images/4/6/63/portada.png', 1),
(73, 64, 'images/4/6/64/portada.png', 1),
(74, 65, 'images/4/6/65/portada.png', 1),
(75, 66, 'images/4/6/66/portada.png', 1),
(76, 67, 'images/4/11/67/portada.png', 1),
(77, 68, 'images/4/11/68/portada.png', 1),
(78, 69, 'images/4/11/69/portada.png', 1),
(79, 70, 'images/4/11/70/portada.png', 1),
(80, 71, 'images/4/11/71/portada.png', 1),
(81, 72, 'images/4/11/72/portada.png', 1),
(82, 74, 'images/2/7/74/portada.png', 1),
(97, 103, 'images/7/23/103/portada.png', 1),
(98, 104, 'images/7/23/104/portada.png', 1),
(100, 106, '../images/4/1/106/portada.png', 1),
(101, 107, 'images/7/23/107/portada.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen_subcategorias`
--

CREATE TABLE `imagen_subcategorias` (
  `id` int(255) NOT NULL,
  `id_subcategoria` int(255) NOT NULL,
  `destination` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `imagen_subcategorias`
--

INSERT INTO `imagen_subcategorias` (`id`, `id_subcategoria`, `destination`) VALUES
(1, 4, 'images/subcategorias/4.png'),
(2, 1, 'images/subcategorias/1.png'),
(3, 2, 'images/subcategorias/2.png'),
(4, 3, 'images/subcategorias/3.png'),
(5, 5, 'images/subcategorias/5.png'),
(6, 6, 'images/subcategorias/6.png'),
(7, 7, 'images/subcategorias/7.png'),
(8, 8, 'images/subcategorias/8.png'),
(9, 9, 'images/subcategorias/9.png'),
(10, 10, 'images/subcategorias/10.png'),
(11, 11, 'images/subcategorias/11.png'),
(12, 12, 'images/subcategorias/12.png'),
(16, 23, 'images/subcategorias/23.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `material` varchar(100) NOT NULL,
  `color` varchar(20) NOT NULL,
  `caracteristicas` varchar(500) NOT NULL,
  `marca` varchar(30) NOT NULL,
  `stock` int(6) NOT NULL,
  `precio` decimal(6,0) NOT NULL,
  `id_categoria` int(100) NOT NULL,
  `id_subcategoria` int(100) NOT NULL,
  `descuento` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `codigo`, `descripcion`, `material`, `color`, `caracteristicas`, `marca`, `stock`, `precio`, `id_categoria`, `id_subcategoria`, `descuento`) VALUES
(1, 'come1', 'Mesa nordica escandinava', 'Madera', 'Blanco', 'Alto: 77cm,ancho: 60cm,profundidad: cm', 'Stockhoy', 3, '6999', 1, 5, 0),
(2, 'come2', 'Mesa comedor escandinava nordica', 'Madera', 'Blanco', 'Alto: 90cm,ancho: 85cm', 'Nordico muebles', 30, '9698', 1, 5, 3),
(3, 'come3', 'Mesa comedor eco laqueada extensible', 'Madera', 'Blanco', 'Alto: 80cm,ancho: 85cm', 'Living style', 20, '12169', 1, 5, 0),
(5, 'come5', 'Mesa nordica escandinava comedor', 'Madera', 'Negro', 'Alto: 77cm,ancho: 70cm,profundidad: cm', 'Stockhoy', 4, '8999', 1, 5, 0),
(6, 'come6', 'Mesa tulip saarinen', 'Madera laqueada', 'Blanco', 'Alto: 80cm,ancho: 90cm', 'Emuebles', 4, '6500', 1, 5, 0),
(7, 'como1', 'Modular cristalero vajillero orlandi', 'Melamina', 'Beige', 'Alto: 183cm,ancho: 185cm,profundidad: 35.8cm', 'Muebles orlandi', 4, '27959', 1, 8, 0),
(8, 'como2', 'Modular comoda vajillero', 'Madera', 'Marron', 'Alto: 183cm,ancho: 185cm,profundidad: 35cm', 'Orlandi', 4, '25999', 1, 8, 0),
(9, 'como3', 'Organizador vajillero biblioteca modular despenser', 'Madera', 'Marron', 'Alto: 80cm,ancho: 35cm,profundidad: 35.8cm', 'Centro estant', 4, '17599', 1, 8, 0),
(10, 'como4', 'Modular rack para tv', 'Melanina', 'Blanco', 'Alto: 165cm,ancho: 200cm,profundidad: 30cm', 'Fiplasto', 4, '18999', 1, 8, 0),
(11, 'como5', 'Modular vajillero vitrina organizador vintage', 'Madera', 'Blanco', 'Alto: 180cm,ancho: 80cm,profundidad: 30cm', 'Cuatro cedros muebles', 4, '19999', 1, 8, 0),
(12, 'como6', 'Modular organizador aparador funcional', 'Melanina', 'Blanco', 'Alto: 1.41cm,ancho: 60cm,profundidad: 20cm', 'Orlandi', 3, '19489', 1, 8, 0),
(13, 'cosi1', 'Silla eames base nordica moderno', 'Madera y polipropileno', 'Blanco', 'Alto: 141cm,ancho: 35cm', 'Eames', 4, '3499', 1, 10, 0),
(14, 'cosi2', 'Silla de escritorio mobilarg lisy fija', 'Metal y cuero sintético proveniente de dubai', 'Negro', 'Alto: 141cm,ancho: 35cm', 'Mobilarg', 4, '6290', 1, 10, 0),
(15, 'cosi3', 'Silla fija cromada greta de diseño', 'Madera', 'Blanco', 'Alto: 141cm,ancho: 35cm', 'Jmi', 4, '8600', 1, 10, 0),
(16, 'cosi4', 'Silla tulip', 'Madera', 'Blanco', 'Alto: 141cm,ancho: 35cm', 'Decoto', 4, '6500', 1, 10, 0),
(17, 'cosi5', 'Silla grace', 'Madera', 'Negro', 'Alto: 141cm,ancho: 35cm', 'Decoto', 4, '6550', 1, 10, 0),
(18, 'cosi6', 'Silla fija cromada tulip de diseño', 'Madera', 'Negro', 'Alto: 141cm,ancho: 35cm', 'Jmi', 4, '8600', 1, 10, 0),
(19, 'doca1', 'Cama corredera telescopica', 'Melanina', 'Blanco', 'Plazas: 2,largo: 205cm,ancho: 160cm', 'Mobilarg', 4, '43990', 2, 2, 0),
(20, 'doca2', 'Cama repisa estantes porta', 'Madera', 'Marron', 'Plazas: 2,largo: 210cm,ancho: 150cm', 'Orlandi', 4, '11990', 2, 2, 0),
(21, 'doca3', 'Cama con 4 cajones', 'Madera y eco cuero', 'Rojo', 'Plazas: 2,largo: 200cm,ancho: 160cm', 'Tu mejor sommier', 4, '25199', 2, 2, 0),
(22, 'doca4', 'Cama box sommier 2 plazas con 6 cajones', 'Madera', 'Marron', 'Plazas: 2,largo: 192cm,ancho: 143cm', 'Móbica', 4, '22950', 2, 2, 0),
(23, 'doca5', 'Cama box sommier', 'Madera', 'Negro', 'Plazas: 2,largo: 205cm,ancho: 160cm', 'Mobilarg', 4, '83990', 2, 2, 0),
(24, 'doca6', 'Box sommier cajonera cama', 'Melanina', 'Beige', 'Plazas: 2,largo: 200cm,ancho: 200cm', 'Mari mar', 4, '34700', 2, 2, 0),
(25, 'doco1', 'Colchón cannon espuma tropical', 'Tela de algodón', 'Blanco', 'Largo: 190cm,ancho: 80cm,alto: 18cm', 'Cannon', 4, '8472', 2, 3, 0),
(26, 'doco2', 'Colchón cannon espuma exclusive', 'Tela de jacquard', 'Beige', 'Largo: 190cm,ancho: 140cm,alto: 29cm', 'Cannon', 4, '28601', 2, 3, 0),
(27, 'doco3', 'Colchón cannon espuma princess', 'Tela de jackard', 'Blanco', 'Largo: 190cm,ancho: 80cm,alto: 20cm', 'Cannon', 4, '10979', 2, 3, 0),
(28, 'doco4', 'Colchón cannon espuma exclusivele', 'Tela de jacquard', 'Beige', 'Largo: 190cm,ancho: 80cm,alto: 20cm', 'Cannon', 4, '18214', 2, 3, 0),
(29, 'doco5', 'Plaza de resortes cannon resortes soñar', 'Tela de algodón', 'Blanco', 'Largo: 190cm,ancho: 80cm,alto: 23cm', 'Cannon', 4, '13024', 2, 3, 0),
(30, 'doco6', 'Plaza de resortes piero sonno', 'Tela de jackard', 'Blanco', 'Largo: 190cm,ancho: 90cm,alto: 26cm', 'Piero', 4, '17195', 2, 3, 0),
(31, 'dome1', 'Mesa de luz 1 cajón', 'Madera', 'Marron', 'Alto: 55cm,ancho: 47cm,profundidad: 31cm', 'Mosconi', 4, '4621', 2, 7, 0),
(32, 'dome2', 'Mesa de luz escandinava - vintage', 'Melanina', 'Marron', 'Alto: 60cm,ancho: 40cm,profundidad: 24cm', 'Mjmaderas', 4, '3099', 2, 7, 0),
(33, 'dome3', 'Mesa de luz cajon puerta sajo', 'Madera', 'Negro', 'Alto: 60cm,ancho: 42cm,profundidad:30cm', 'Sajo', 4, '2999', 2, 7, 0),
(34, 'dome4', 'Mesa mesita luz flotante con cajon correderan', 'Madera pino', 'Blanco', 'Alto: 30cm,ancho: 35cm,profundidad:29cm', 'Su ferretería online', 4, '4300', 2, 7, 0),
(35, 'dome5', 'Mesa de luz mesita con botinero', 'Melanina', 'Blanco', 'Alto: 71cm,ancho: 38cm,profundidad:38cm', 'Centro estant', 4, '6399', 2, 7, 0),
(36, 'dome6', 'Mesa de luz premium', 'Melanina', 'Gris', 'Alto: 67cm,ancho: 53cm,profundidad:35cm', 'Orlandi', 4, '6399', 2, 7, 0),
(37, 'dopl1', 'Placard ropero 2 puertas', 'Melanina', 'Blanco', 'Alto: 182cm,ancho: 60cm,profundidad:47cm', 'Mosconi', 4, '10300', 2, 9, 0),
(38, 'dopl2', 'Placard puertas corredizas', 'Madera', 'Blanco viejo', 'Alto: 184cm,ancho: 182cm,profundidad:53cm', 'Orlandi', 3, '28479', 2, 9, 0),
(39, 'dopl3', 'Placard wengue mogno', 'Madera', 'Blanco', 'Alto: 184cm,ancho: 181cm,profundidad:47cm', 'Orlandi', 4, '19499', 2, 9, 0),
(40, 'dopl4', 'Placard vestidor moderno ', 'Madera', 'Blanco', 'Alto: 180cm,ancho: 180cm,profundidad:55cm', 'Carpintería rivadavia', 4, '20921', 2, 9, 0),
(41, 'dopl5', 'Placard ropero 12 puertas 4 cajones', 'Madera', 'Blanco viejo', 'Alto: 215cm,ancho: 212cm,profundidad:47cm', 'Orlandi', 4, '32299', 2, 9, 0),
(42, 'dopl6', 'Ropero placard 2 puertas 4 estantes infantil cubo ', 'Madera', 'Beige', 'Alto: 147cm,ancho: 87cm,profundidad:38cm', 'Diseños modernos', 4, '8998', 2, 9, 0),
(43, 'lifu1', 'Futon rustico', 'Madera', 'Blanco', 'Alto: 100cm,ancho: 205cm,profundidad:140cm', 'Bek', 4, '16899', 3, 4, 0),
(44, 'lifu2', 'Futon modelo owen', 'Madera', 'Blanco', 'Alto: 76cm,ancho: 100cm,profundidad:100cm', 'Tribeca', 4, '35939', 3, 4, 0),
(45, 'lifu3', 'Futon 3 cpos cipres', 'Madera', 'Rosa', 'Alto: 80cm,ancho: 200cm,profundidad:100cm', 'Oeste amoblamientos', 4, '22705', 3, 4, 0),
(46, 'lifu4', 'Futon sillón cama más colchón de tres cuerpos', 'Madera', 'Blanco', 'Alto: 100cm,ancho: 205cm,profundidad:100cm', 'Maderera pino hogar', 4, '19000', 3, 4, 0),
(47, 'lifu5', 'Sofa cama bed napa lino ', 'Madera', 'Negro', 'Alto: 80cm,ancho: 180cm,profundidad:80cm', 'Living style', 4, '25579', 3, 4, 0),
(48, 'lifu6', 'Futon napa', 'Metal', 'Blanco', 'Alto: 80cm,ancho: 179cm,profundidad:100cm', 'Tribeca', 4, '27720', 3, 4, 0),
(49, 'lisi1', 'Sillon escandinavo', 'Chenille y madera', 'Gris', 'Alto: 80cm,ancho: 160cm,profundidad:80cm', 'Dadaa muebles', 4, '32999', 3, 12, 0),
(50, 'lisi2', 'Sillón 2 cuerpos', 'Madera y tela', 'Verde', 'Alto: 75cm,ancho: 150cm,profundidad:70cm', 'Carbatt', 4, '15500', 3, 12, 0),
(51, 'lisi3', 'Sillon nordico', 'Chenille', 'Gris', 'Alto: 80cm,ancho: 180cm,profundidad:80cm', 'Dadaa muebles', 4, '32999', 3, 12, 0),
(52, 'lisi4', 'Sofa basic especial', 'Madera', 'Negro', 'Alto: 80cm,ancho: 120cm,profundidad:75cm', 'Chera', 4, '19729', 3, 12, 0),
(53, 'lisi5', 'Sillón sofá escandinavo nórdico retro vintage', 'Chenille antidesgarros y madera', 'Gris', 'Alto: 95cm,ancho: 150cm,profundidad:80cm', 'Interliving', 4, '38990', 3, 12, 0),
(54, 'lisi6', 'Sillon rinconero', 'Chenille y madera', 'Morado', 'Alto: 75cm,ancho: 180cm,profundidad:70cm', 'Carbatt', 4, '24900', 3, 12, 0),
(55, 'ofbi1', 'Biblioteca de pino', 'Madera', 'Marron', 'Alto: 180cm,ancho: 25cm,profundidad: 25cm', 'Colonial', 4, '5654', 4, 1, 0),
(56, 'ofbi2', 'Biblioteca estantería industrial', 'Hierro y madera', 'Marron', 'Alto: 190cm,ancho: 120cm,profundidad: 30cm', 'Almamuebleshym', 4, '20900', 4, 1, 0),
(57, 'ofbi3', 'Biblioteca estantería escandinava', 'Madera', 'Blanco', 'Alto: 180cm,ancho: 90cm,profundidad: 30cm', 'Pazionne', 4, '14799', 4, 1, 0),
(58, 'ofbi4', 'Biblioteca de pino', 'Madera', 'Marron', 'Alto: 180cm,ancho: 100cm,profundidad: 25cm', 'Cruz', 4, '5000', 4, 1, 0),
(59, 'ofbi5', 'Bibilioteca estanteria madera pino organizador emm', 'Madera', 'Blanco', 'Alto: 153cm,ancho: 72cm,profundidad: 35cm', 'Corfam', 4, '10994', 4, 1, 0),
(60, 'ofbi6', 'Biblioteca alta organizador estantes escalera', 'Madera', 'Marron', 'Alto: Mcm,ancho: ocm,profundidad: dcm', 'Muebles eco', 30, '9000', 4, 1, 3),
(61, 'ofme1', 'Escritorio cerradura', 'Madera', 'Beige', 'Alto: 74cm,ancho: 120cm,profundidad: 70cm', 'Platinum', 4, '9599', 4, 6, 0),
(62, 'ofme2', 'Mesa de pc con alzada owen', 'Madera', 'Marron', 'Alto: 75cm,ancho: 18cm,profundidad: 45cm', 'Su-office', 4, '6990', 4, 6, 0),
(63, 'ofme3', 'Escritorio pc notebook mod', 'Madera', 'Blanco', 'Alto: 75cm,ancho: 100cm,profundidad: 45cm', 'Platinum', 4, '5199', 4, 6, 0),
(64, 'ofme4', 'Mesa escritorio pc extraible', 'Madera', 'Negro', 'Alto: 121cm,ancho: 101cm,profundidad: 45cm', 'Mosconi', 4, '7989', 4, 6, 0),
(65, 'ofme5', 'Mesa escritorio para pc- notebooks', 'Madera', 'Beige', 'Alto: 75cm,ancho: 95cm,profundidad: 44cm', 'Piro', 4, '12695', 4, 6, 0),
(66, 'ofme6', 'Escritorio mesa pc impresora biblioteca oficina', 'Madera', 'Blanco', 'Alto: 121cm,ancho: 101cm,profundidad: 45cm', 'Mosconi', 4, '8570', 4, 6, 0),
(67, 'ofsi1', 'Tisera silla baut ergonómica', 'Algodon y metal', 'Negro', 'Altura del respaldo: 80cm,altura del piso al asiento: 50cm', 'Tisera', 4, '16999', 4, 11, 0),
(68, 'ofsi2', 'Silla ejecutiva mesh', 'Algodon y metal', 'Negro', 'Altura del respaldo: 69cm,altura del piso al asiento: 53cm', 'Baires4', 4, '18990', 4, 11, 0),
(69, 'ofsi3', 'Silla de escritorio de outlet diva', 'Algodon y metal', 'Negro', 'Altura del respaldo: 55cm,altura del piso al asiento: 30cm', 'Sillas de outlet', 4, '13640', 4, 11, 0),
(70, 'ofsi4', 'Sillon ejecutivo silla oficina pc', 'Algodon y metal', 'Negro', 'Altura del respaldo: 66cm,altura del piso al asiento: 43cm', 'Rd', 4, '17520', 4, 11, 0),
(71, 'ofsi5', 'Silla ergonómica', 'Algodon y metal', 'Negro', 'Altura del respaldo: 55cm,altura del piso al asiento: 47cm', 'Baires4', 4, '13040', 4, 11, 0),
(72, 'ofsi6', 'Silla butaca gamer ', 'Algodon y metal', 'Negro', 'Altura del respaldo: 87cm,altura del piso al asiento: 50cm', 'Iqual', 4, '39999', 4, 11, 0),
(74, 'dome7', 'Mesa De Luz En Dos Tonos Con Estantes Y Cajón Deca', 'Pino', 'Blanco', 'Alto: 45cm,ancho: 50cm,profundidad: 55cm', 'Básquet shop', 22, '5555', 2, 7, 0),
(103, 'jasi1', 'Silla de jardin blancas', 'Chenille y madera', 'Blanco', 'Alto: 60cm,ancho: 40cm,profundidad: 40cm', 'Platinum', 4, '1000', 7, 23, 2),
(104, 'jasi2', 'Silla de jardin negras nordicas', 'Madera', 'Negro', 'Alto: 40cm,ancho: 40cm,profundidad: 60cm', 'Bek', 20, '5000', 7, 23, 1),
(106, 'jasi4', 'Ddfsdfdsfsd', 'Chenille y madera', 'Azul', 'Alto: 20cm,ancho: 20cm,profundidad: 20cm', 'Centro estant', 23, '321312', 4, 1, 0),
(107, 'jasi5', 'Dasdsadas', 'Chenille', 'Amarillo', 'Alto: 20cm,ancho: 20cm,profundidad: 20cm', 'Básquet shop', 2321, '321312', 7, 23, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategoria`
--

CREATE TABLE `subcategoria` (
  `id_subcategoria` int(100) NOT NULL,
  `nombre_subcategoria` varchar(100) NOT NULL,
  `id_categoria` int(100) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `subcategoria`
--

INSERT INTO `subcategoria` (`id_subcategoria`, `nombre_subcategoria`, `id_categoria`, `activo`) VALUES
(1, 'Bibliotecas', 4, 1),
(2, 'Camas', 2, 1),
(3, 'Colchones', 2, 1),
(4, 'Futones', 3, 1),
(5, 'Mesas', 1, 1),
(6, 'Mesas de escritorio', 4, 1),
(7, 'Mesas de luz', 2, 1),
(8, 'Modulares', 1, 1),
(9, 'Placares', 2, 1),
(10, 'Sillas', 1, 1),
(11, 'Sillas de oficina', 4, 1),
(12, 'Sillones', 3, 1),
(23, 'Sillas de jardin', 7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(7) NOT NULL,
  `nombre_usuario` varchar(30) NOT NULL,
  `contrasena` varchar(250) NOT NULL,
  `perfil` varchar(2) NOT NULL,
  `nro_dni` varchar(8) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `provincia` varchar(30) NOT NULL,
  `ciudad` varchar(30) NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `suscripcion` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre_usuario`, `contrasena`, `perfil`, `nro_dni`, `nombre`, `apellido`, `email`, `provincia`, `ciudad`, `direccion`, `suscripcion`) VALUES
(1, 'caelenaShar', '0e5cd0a77778f353ca0863d3ca43f35e4f71d74c33e6524383e75349c6f42ac1ac0e7de58a0438a42891d9a497f62454b7bdaf8a93286f64314a433b7e4b7f3f', 'U', '41689734', 'caelena', 'shar', 'caeShar@hotmail.com', 'buenos aires', 'bahia blanca', 'avenida alem', 0),
(2, 'AnaLopez', 'e686859d8a43300614ee7767fc287d6d227cb16cd1204f11150f8207302edeb7e15883561621a13a9c54e63a913528a8ec759eb00fb8cfd445e8cbc66b32edf4', 'E', '12345678', 'Ana', 'Lopez', 'analopez@hotmail.com', 'Buenos Aires', 'Bahia Blanca', 'Calle 1', 0),
(11, 'RomanRiquelme', '', 'U', '40978231', 'David', 'Benedette', 'davidbenedette@gmail.com', 'Córdoba', 'Achiras', 'Av. Colón 10 , 444', 1),
(12, 'MarcosMaradona', 'ed2952d515792817bed01984d7fbd7f74d62b9b37db8939ea35f2a3109d19776e36bccf696a7362351ca9c9d0d0675220fa33bb9e95e30b01cd1a1c872b72eb0', 'U', '22222222', 'Diego', 'Maradona', 'd@hotmail.com', 'Buenos Aires', 'Almirante Brown', 'Colon 3', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rs`
--

CREATE TABLE `usuario_rs` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_social` varchar(255) NOT NULL,
  `servicio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario_rs`
--

INSERT INTO `usuario_rs` (`id`, `id_usuario`, `id_social`, `servicio`) VALUES
(8, 11, '100332424155947279275', 'Google');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compras_ibfk_1` (`id_usuario`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_ibfk_1` (`usuario_id`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_compra_ibkf_1` (`id_compra`);

--
-- Indices de la tabla `favorito`
--
ALTER TABLE `favorito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorito_ibfk_1` (`id_producto`),
  ADD KEY `favorito_ibfk_2` (`id_usuario`);

--
-- Indices de la tabla `imagen_categorias`
--
ALTER TABLE `imagen_categorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `imagen_productos`
--
ALTER TABLE `imagen_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `imagen_subcategorias`
--
ALTER TABLE `imagen_subcategorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_subcategoria` (`id_subcategoria`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `producto_ibfk_1` (`id_categoria`),
  ADD KEY `producto_ibfk_2` (`id_subcategoria`);

--
-- Indices de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD PRIMARY KEY (`id_subcategoria`),
  ADD KEY `subcategoria_ibkf_1` (`id_categoria`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario_rs`
--
ALTER TABLE `usuario_rs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `favorito`
--
ALTER TABLE `favorito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `imagen_categorias`
--
ALTER TABLE `imagen_categorias`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `imagen_productos`
--
ALTER TABLE `imagen_productos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `imagen_subcategorias`
--
ALTER TABLE `imagen_subcategorias`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  MODIFY `id_subcategoria` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuario_rs`
--
ALTER TABLE `usuario_rs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `detalle_compra_ibkf_1` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `favorito`
--
ALTER TABLE `favorito`
  ADD CONSTRAINT `favorito_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorito_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `imagen_categorias`
--
ALTER TABLE `imagen_categorias`
  ADD CONSTRAINT `imagen_categorias_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`);

--
-- Filtros para la tabla `imagen_productos`
--
ALTER TABLE `imagen_productos`
  ADD CONSTRAINT `imagen_productos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `imagen_subcategorias`
--
ALTER TABLE `imagen_subcategorias`
  ADD CONSTRAINT `imagen_subcategorias_ibfk_1` FOREIGN KEY (`id_subcategoria`) REFERENCES `subcategoria` (`id_subcategoria`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`id_subcategoria`) REFERENCES `subcategoria` (`id_subcategoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD CONSTRAINT `subcategoria_ibkf_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_rs`
--
ALTER TABLE `usuario_rs`
  ADD CONSTRAINT `usuario_rs_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
