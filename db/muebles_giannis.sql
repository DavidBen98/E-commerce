-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-02-2022 a las 15:31:38
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
  `id_categoria` int(100) PRIMARY KEY AUTO_INCREMENT
  `nombre_categoria` varchar(100) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`nombre_categoria`) VALUES
('Comedor'),
('Dormitorio'),
('Living'),
('Oficina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(255) PRIMARY KEY AUTO_INCREMENT,
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
  `id` int(7) PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(40) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `texto` varchar(500) NOT NULL,
  `respondido` tinyint(1) NOT NULL,
  `usuario_id` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`email`, `nombre`, `apellido`, `texto`, `respondido`, `usuario_id`) VALUES
('romanriquelme@hotmail.com', 'dsa', 'dsa', 'ff', 0, 3),
('romanriquelme@hotmail.com', 'f', 'f', 'dfsfs', 0, 3),
('romanriquelme@hotmail.com', 'Roman', 'Riquelme', 'Buen dia, hacen envios a Montevideo?', 0, 3),
('davidbenedette@hotmail.com', 'das', 'dsa', 'Buen dia, tienen stock de sillas?', 0, 6),
('davidbenedette@hotmail.com', 'dsa', 'dsa', 's', 0, 6),
('davidbenedette@hotmail.com', 'dsad', 'dsa', 'ss', 0, 6),
('davidbenedette@gmail.com', 'fsd', 'fsd', 'aaa', 0, 8),
('davidbenedette@gmail.com', 'dsa', 'dsa', 'dsa', 0, 8),
('davidbenedette@gmail.com', 'dsa', 'sa', 'sda', 0, 8),
('davidbenedette@gmail.com', 'y', 'y', 'ppp', 0, 8),
('romanriquelme@hotmail.com', 'fdsf', 'fds', 'dsadsa', 0, 3),
('davidbenedette@hotmail.com', 'dsad', 'dsad', 'Hola', 0, 6),
('romanriquelme@hotmail.com', 'fsdf', 'ff', 'Buenas', 0, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
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
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `favorito`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `id_producto` int(255) NOT NULL,
  `imagen` longblob NOT NULL,
  `portada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `imagen`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(255) PRIMARY KEY AUTO_INCREMENT,
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
  `descuento` tinyint(2) NOT NULL DEFAULT 0,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codigo`, `descripcion`, `material`, `color`, `caracteristicas`, `marca`, `stock`, `precio`, `id_categoria`, `id_subcategoria`, `descuento`) VALUES
('come7', 'Mesa Industrial Comedor', 'Madera y Hierro', 'Marron', 'Alto: 80cm,ancho: 80cm', 'Cambá Muebles', 3, '13900', 1, 17, 0),
('come1', 'Mesa nordica escandinava', 'Madera', 'Blanco', 'Alto: 77cm,ancho: 60cm', 'Stockhoy', 3, '6999', 1, 17, 0),
('come2', 'Mesa comedor escandinava nordica', 'Madera', 'Blanco', 'Alto: 77cm,ancho: 80cm', 'Nordico muebles', 4, '9698', 1, 17, 0),
('come3', 'Mesa comedor eco laqueada extensible', 'Madera', 'Blanco', 'Alto: 80cm,ancho: 85cm', 'Living style', 2, '12169', 1, 17, 0),
('come4', 'Mesa comedor escandinava nordica laqueada paraiso', 'Madera', 'Marron', 'Alto: 80cm,ancho: 85cm', 'Mesas mp', 4, '9152', 1, 17, 0),
('come5', 'Mesa nordica escandinava comedor', 'Madera', 'Negro', 'Alto: 77cm,ancho: 70cm', 'Stockhoy', 4, '8999', 1, 17, 0),
('come6', 'Mesa tulip saarinen', 'Madera laqueada', 'Blanco', 'Alto: 80cm,ancho: 90cm', 'Emuebles', 4, '6500', 1, 17, 0),
('como1', 'Modular cristalero vajillero orlandi', 'Melamina', 'Beige', 'Alto: 183cm,ancho: 185cm,profundidad: 35.8cm', 'Muebles orlandi', 4, '27959', 1, 20, 0),
('como2', 'Modular comoda vajillero', 'Madera', 'Marron', 'Alto: 183cm,ancho: 185cm,profundidad: 35cm', 'Orlandi', 4, '25999', 1, 20, 0),
('como3', 'Organizador vajillero biblioteca modular despenser', 'Madera', 'Marron', 'Alto: 80cm,ancho: 35cm,profundidad: 35.8cm', 'Centro estant', 4, '17599', 1, 20, 0),
('como4', 'Modular rack para tv', 'Melanina', 'Blanco', 'Alto: 165cm,ancho: 200cm,profundidad: 30cm', 'Fiplasto', 4, '18999', 1, 20, 0),
('como5', 'Modular vajillero vitrina organizador vintage', 'Madera', 'Blanco', 'Alto: 180cm,ancho: 80cm,profundidad: 30cm', 'Cuatro cedros muebles', 4, '19999', 1, 20, 0),
('como6', 'Modular organizador aparador funcional', 'Melanina', 'Blanco', 'Alto: 1.41cm,ancho: 60cm,profundidad: 20cm', 'Orlandi', 3, '19489', 1, 20, 0),
('cosi1', 'Silla eames base nordica moderno', 'Madera y polipropileno', 'Blanco', 'Alto: 141cm,ancho: 35cm', 'Eames', 4, '3499', 1, 22, 0),
('cosi2', 'Silla de escritorio mobilarg lisy fija', 'Metal y cuero sintético proveniente de dubai', 'Negro', 'Alto: 141cm,ancho: 35cm', 'Mobilarg', 4, '6290', 1, 22, 0),
('cosi3', 'Silla fija cromada greta de diseño', 'Madera', 'Blanco', 'Alto: 141cm,ancho: 35cm', 'Jmi', 4, '8600', 1, 22, 0),
('cosi4', 'Silla tulip', 'Madera', 'Blanco', 'Alto: 141cm,ancho: 35cm', 'Decoto', 4, '6500', 1, 22, 0),
('cosi5', 'Silla grace', 'Madera', 'Negro', 'Alto: 141cm,ancho: 35cm', 'Decoto', 4, '6550', 1, 22, 0),
('cosi6', 'Silla fija cromada tulip de diseño', 'Madera', 'Negro', 'Alto: 141cm,ancho: 35cm', 'Jmi', 4, '8600', 1, 22, 0),
('doca1', 'Cama corredera telescopica', 'Melanina', 'Blanco', 'Plazas: 2,largo: 205cm,ancho: 160cm', 'Mobilarg', 4, '43990', 2, 14, 0),
('doca2', 'Cama repisa estantes porta', 'Madera', 'Marron', 'Plazas: 2,largo: 210cm,ancho: 150cm', 'Orlandi', 4, '11990', 2, 14, 0),
('doca3', 'Cama con 4 cajones', 'Madera y eco cuero', 'Rojo', 'Plazas: 2,largo: 200cm,ancho: 160cm', 'Tu mejor sommier', 4, '25199', 2, 14, 0),
('doca4', 'Cama box sommier 2 plazas con 6 cajones', 'Madera', 'Marron', 'Plazas: 2,largo: 192cm,ancho: 143cm', 'Móbica', 4, '22950', 2, 14, 0),
('doca5', 'Cama box sommier', 'Madera', 'Negro', 'Plazas: 2,largo: 205cm,ancho: 160cm', 'Mobilarg', 4, '83990', 2, 14, 0),
('doca6', 'Box sommier cajonera cama', 'Melanina', 'Beige', 'Plazas: 2,largo: 200cm,ancho: 200cm', 'Mari mar', 4, '34700', 2, 14, 0),
('doco1', 'Colchón cannon espuma tropical', 'Tela de algodón', 'Blanco', 'Largo: 190cm,ancho: 80cm,alto: 18cm', 'Cannon', 4, '8472', 2, 15, 0),
('doco2', 'Colchón cannon espuma exclusive', 'Tela de jacquard', 'Beige', 'Largo: 190cm,ancho: 140cm,alto: 29cm', 'Cannon', 4, '28601', 2, 15, 0),
('doco3', 'Colchón cannon espuma princess', 'Tela de jackard', 'Blanco', 'Largo: 190cm,ancho: 80cm,alto: 20cm', 'Cannon', 4, '10979', 2, 15, 0),
('doco4', 'Colchón cannon espuma exclusivele', 'Tela de jacquard', 'Beige', 'Largo: 190cm,ancho: 80cm,alto: 20cm', 'Cannon', 4, '18214', 2, 15, 0),
('doco5', 'Plaza de resortes cannon resortes soñar', 'Tela de algodón', 'Blanco', 'Largo: 190cm,ancho: 80cm,alto: 23cm', 'Cannon', 4, '13024', 2, 15, 0),
('doco6', 'Plaza de resortes piero sonno', 'Tela de jackard', 'Blanco', 'Largo: 190cm,ancho: 90cm,alto: 26cm', 'Piero', 4, '17195', 2, 15, 0),
('dome1', 'Mesa de luz 1 cajón', 'Madera', 'Marron', 'Alto: 55cm,ancho: 47cm,profundidad: 31cm', 'Mosconi', 4, '4621', 2, 19, 0),
('dome2', 'Mesa de luz escandinava - vintage', 'Melanina', 'Marron', 'Alto: 60cm,ancho: 40cm,profundidad: 24cm', 'Mjmaderas', 4, '3099', 2, 19, 0),
('dome3', 'Mesa de luz cajon puerta sajo', 'Madera', 'Negro', 'Alto: 60cm,ancho: 42cm,profundidad:30cm', 'Sajo', 4, '2999', 2, 19, 0),
('dome4', 'Mesa mesita luz flotante con cajon correderan', 'Madera pino', 'Blanco', 'Alto: 30cm,ancho: 35cm,profundidad:29cm', 'Su ferretería online', 4, '4300', 2, 19, 0),
('dome5', 'Mesa de luz mesita con botinero', 'Melanina', 'Blanco', 'Alto: 71cm,ancho: 38cm,profundidad:38cm', 'Centro estant', 4, '6399', 2, 19, 0),
('dome6', 'Mesa de luz premium', 'Melanina', 'Gris', 'Alto: 67cm,ancho: 53cm,profundidad:35cm', 'Orlandi', 4, '6399', 2, 19, 0),
('dopl1', 'Placard ropero 2 puertas', 'Melanina', 'Blanco', 'Alto: 182cm,ancho: 60cm,profundidad:47cm', 'Mosconi', 4, '10300', 2, 21, 0),
('dopl2', 'Placard puertas corredizas', 'Madera', 'Blanco viejo', 'Alto: 184cm,ancho: 182cm,profundidad:53cm', 'Orlandi', 3, '28479', 2, 21, 0),
('dopl3', 'Placard wengue mogno', 'Madera', 'Blanco', 'Alto: 184cm,ancho: 181cm,profundidad:47cm', 'Orlandi', 4, '19499', 2, 21, 0),
('dopl4', 'Placard vestidor moderno ', 'Madera', 'Blanco', 'Alto: 180cm,ancho: 180cm,profundidad:55cm', 'Carpintería rivadavia', 4, '20921', 2, 21, 0),
('dopl5', 'Placard ropero 12 puertas 4 cajones', 'Madera', 'Blanco viejo', 'Alto: 215cm,ancho: 212cm,profundidad:47cm', 'Orlandi', 4, '32299', 2, 21, 0),
('dopl6', 'Ropero placard 2 puertas 4 estantes infantil cubo ', 'Madera', 'Beige', 'Alto: 147cm,ancho: 87cm,profundidad:38cm', 'Diseños modernos', 4, '8998', 2, 21, 0),
('lifu1', 'Futon rustico', 'Madera', 'Blanco', 'Alto: 100cm,ancho: 205cm,profundidad:140cm', 'Bek', 4, '16899', 3, 16, 0),
('lifu2', 'Futon modelo owen', 'Madera', 'Blanco', 'Alto: 76cm,ancho: 100cm,profundidad:100cm', 'Tribeca', 4, '35939', 3, 16, 0),
('lifu3', 'Futon 3 cpos cipres', 'Madera', 'Rosa', 'Alto: 80cm,ancho: 200cm,profundidad:100cm', 'Oeste amoblamientos', 4, '22705', 3, 16, 0),
('lifu4', 'Futon sillón cama más colchón de tres cuerpos', 'Madera', 'Blanco', 'Alto: 100cm,ancho: 205cm,profundidad:100cm', 'Maderera pino hogar', 4, '19000', 3, 16, 0),
('lifu5', 'Sofa cama bed napa lino ', 'Madera', 'Negro', 'Alto: 80cm,ancho: 180cm,profundidad:80cm', 'Living style', 4, '25579', 3, 16, 0),
('lifu6', 'Futon napa', 'Metal', 'Blanco', 'Alto: 80cm,ancho: 179cm,profundidad:100cm', 'Tribeca', 4, '27720', 3, 16, 0),
('lisi1', 'Sillon escandinavo', 'Chenille y madera', 'Gris', 'Alto: 80cm,ancho: 160cm,profundidad:80cm', 'Dadaa muebles', 4, '32999', 3, 24, 0),
('lisi2', 'Sillón 2 cuerpos', 'Madera y tela', 'Verde', 'Alto: 75cm,ancho: 150cm,profundidad:70cm', 'Carbatt', 4, '15500', 3, 24, 0),
('lisi3', 'Sillon nordico', 'Chenille', 'Gris', 'Alto: 80cm,ancho: 180cm,profundidad:80cm', 'Dadaa muebles', 4, '32999', 3, 24, 0),
('lisi4', 'Sofa basic especial', 'Madera', 'Negro', 'Alto: 80cm,ancho: 120cm,profundidad:75cm', 'Chera', 4, '19729', 3, 24, 0),
('lisi5', 'Sillón sofá escandinavo nórdico retro vintage', 'Chenille antidesgarros y madera', 'Gris', 'Alto: 95cm,ancho: 150cm,profundidad:80cm', 'Interliving', 4, '38990', 3, 24, 0),
('lisi6', 'Sillon rinconero', 'Chenille y madera', 'Morado', 'Alto: 75cm,ancho: 180cm,profundidad:70cm', 'Carbatt', 4, '24900', 3, 24, 0),
('ofbi1', 'Biblioteca de pino', 'Madera', 'Marron', 'Alto: 180cm,ancho: 25cm,profundidad: 25cm', 'Colonial', 4, '5654', 4, 13, 0),
('ofbi2', 'Biblioteca estantería industrial', 'Hierro y madera', 'Marron', 'Alto: 190cm,ancho: 120cm,profundidad: 30cm', 'Almamuebleshym', 4, '20900', 4, 13, 0),
('ofbi3', 'Biblioteca estantería escandinava', 'Madera', 'Blanco', 'Alto: 180cm,ancho: 90cm,profundidad: 30cm', 'Pazionne', 4, '14799', 4, 13, 0),
('ofbi4', 'Biblioteca de pino', 'Madera', 'Marron', 'Alto: 180cm,ancho: 100cm,profundidad: 25cm', 'Cruz', 4, '5000', 4, 13, 0),
('ofbi5', 'Bibilioteca estanteria madera pino organizador emm', 'Madera', 'Blanco', 'Alto: 153cm,ancho: 72cm,profundidad: 35cm', 'Corfam', 4, '10994', 4, 13, 0),
('ofbi6', 'Biblioteca alta organizador estantes escalera', 'Madera', 'Marron', 'Alto: 185cm,ancho: 90cm,profundidad: 25cm', 'Muebles eco', 4, '8760', 4, 13, 0),
('ofme1', 'Escritorio cerradura', 'Madera', 'Beige', 'Alto: 74cm,ancho: 120cm,profundidad: 70cm', 'Platinum', 4, '9599', 4, 18, 0),
('ofme2', 'Mesa de pc con alzada owen', 'Madera', 'Marron', 'Alto: 75cm,ancho: 18cm,profundidad: 45cm', 'Su-office', 4, '6990', 4, 18, 0),
('ofme3', 'Escritorio pc notebook mod', 'Madera', 'Blanco', 'Alto: 75cm,ancho: 100cm,profundidad: 45cm', 'Platinum', 4, '5199', 4, 18, 0),
('ofme4', 'Mesa escritorio pc extraible', 'Madera', 'Negro', 'Alto: 121cm,ancho: 101cm,profundidad: 45cm', 'Mosconi', 4, '7989', 4, 18, 0),
('ofme5', 'Mesa escritorio para pc- notebooks', 'Madera', 'Beige', 'Alto: 75cm,ancho: 95cm,profundidad: 44cm', 'Piro', 4, '12695', 4, 18, 0),
('ofme6', 'Escritorio mesa pc impresora biblioteca oficina', 'Madera', 'Blanco', 'Alto: 121cm,ancho: 101cm,profundidad: 45cm', 'Mosconi', 4, '8570', 4, 18, 0),
('ofsi1', 'Tisera silla baut ergonómica', 'Algodon y metal', 'Negro', 'Altura del respaldo: 80cm,altura del piso al asiento: 50cm', 'Tisera', 4, '16999', 4, 23, 0),
('ofsi2', 'Silla ejecutiva mesh', 'Algodon y metal', 'Negro', 'Altura del respaldo: 69cm,altura del piso al asiento: 53cm', 'Baires4', 4, '18990', 4, 23, 0),
('ofsi3', 'Silla de escritorio de outlet diva', 'Algodon y metal', 'Negro', 'Altura del respaldo: 55cm,altura del piso al asiento: 30cm', 'Sillas de outlet', 4, '13640', 4, 23, 0),
('ofsi4', 'Sillon ejecutivo silla oficina pc', 'Algodon y metal', 'Negro', 'Altura del respaldo: 66cm,altura del piso al asiento: 43cm', 'Rd', 4, '17520', 4, 23, 0),
('ofsi5', 'Silla ergonómica', 'Algodon y metal', 'Negro', 'Altura del respaldo: 55cm,altura del piso al asiento: 47cm', 'Baires4', 4, '13040', 4, 23, 0),
('ofsi6', 'Silla butaca gamer ', 'Algodon y metal', 'Negro', 'Altura del respaldo: 87cm,altura del piso al asiento: 50cm', 'Iqual', 4, '39999', 4, 23, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategoria`
--

CREATE TABLE `subcategoria` (
  `id_subcategoria` int(100) PRIMARY KEY AUTO_INCREMENT,
  `nombre_subcategoria` varchar(100) NOT NULL,
  `id_categoria` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `subcategoria`
--

INSERT INTO `subcategoria` (`nombre_subcategoria`, `id_categoria`) VALUES
('Bibliotecas', 4),
('Camas', 2),
('Colchones', 2),
('Futones', 3),
('Mesas', 1),
('Mesas de escritorio', 4),
('Mesas de luz', 2),
('Modulares', 1),
('Placares', 2),
('Sillas', 1),
('Sillas de oficina', 4),
('Sillones', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(7) PRIMARY KEY AUTO_INCREMENT,
  `nombreUsuario` varchar(30) NOT NULL,
  `contrasena` varchar(250) NOT NULL,
  `perfil` varchar(2) NOT NULL,
  `nroDni` varchar(8) NOT NULL,
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

INSERT INTO `usuario` (`nombreUsuario`, `contrasena`, `perfil`, `nroDni`, `nombre`, `apellido`, `email`, `provincia`, `ciudad`, `direccion`, `suscripcion`) VALUES
('caelenaShar', '0e5cd0a77778f353ca0863d3ca43f35e4f71d74c33e6524383e75349c6f42ac1ac0e7de58a0438a42891d9a497f62454b7bdaf8a93286f64314a433b7e4b7f3f', 'U', '41689734', 'caelena', 'shar', 'caeShar@hotmail.com', 'buenos aires', 'bahia blanca', 'avenida alem', 0),
('AnaLopez', 'e686859d8a43300614ee7767fc287d6d227cb16cd1204f11150f8207302edeb7e15883561621a13a9c54e63a913528a8ec759eb00fb8cfd445e8cbc66b32edf4', 'E', '12345678', 'Ana', 'Lopez', 'analopez@hotmail.com', 'Buenos Aires', 'Bahia Blanca', 'Calle 1', 0),
('RomanRiquelme', '3bd0ec7e54237c798afb6ede6ebc0feaadce5ab191d7d2f6310ad92072f332251aa7e66af79ee9e8f77e62ef2df0dde0e8872ca92e2d4a57adc334c6f8f830b9', 'U', '12345678', 'Roman', 'Riquelme', 'romanriquelme@hotmail.com', 'Neuquén', 'Aguada San Roque', 'Av. Independencia 6 , 5H', 0),
('ChinaSuarez', 'ab4a301aa40357605ddce7b47ed7bcba32206defa7e8a6638528cecf7c4f2a8991fc51fa459e2d328c54af0051161557f280d9e8175606ee7b53da9a53de6866', 'E', '12345678', 'China', 'Suarez', 'chinasuarez@hotmail.com', 'Buenos Aires', 'Olavarria', 'Calle 3', 0),
('DavidBen', 'e686859d8a43300614ee7767fc287d6d227cb16cd1204f11150f8207302edeb7e15883561621a13a9c54e63a913528a8ec759eb00fb8cfd445e8cbc66b32edf4', 'U', '40978231', 'David', 'Benedette', 'davidbenedette@hotmail.com', 'Misiones', 'Colonia Polana', 'Av. Libertador 760 , 14A', 0),
('VickyArenzo', 'e686859d8a43300614ee7767fc287d6d227cb16cd1204f11150f8207302edeb7e15883561621a13a9c54e63a913528a8ec759eb00fb8cfd445e8cbc66b32edf4', 'U', '42391952', 'victoria', 'arenzo', 'vicky.16@hotmail.com.ar', 'Buenos Aires', 'Bahía Blanca', 'Berutti 47 , 14', 0),
('DavidBenedette', '', 'U', '41412412', 'David', 'Benedette', 'davidbenedette@gmail.com', 'San Luis', 'Fraga', '', 0),
('Davi', '', 'U', '40978231', 'Ladislao', 'Benedette', '', 'Mendoza', 'Capital', '9 de Julio 33 , 4H', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rs`
--

CREATE TABLE `usuario_rs` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_social` varchar(255) NOT NULL,
  `servicio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario_rs`
--

INSERT INTO `usuario_rs` (`id_usuario`, `id_social`, `servicio`) VALUES
(8, '100332424155947279275', 'Google'),
(9, '318788939', 'Twitter');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD KEY `compras_ibfk_1` (`id_usuario`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD KEY `cliente_ibfk_1` (`usuario_id`);

--
-- Indices de la tabla `detalle_compra`
--

--
-- Indices de la tabla `favorito`
--
ALTER TABLE `favorito`
  ADD KEY `favorito_ibfk_1` (`id_producto`),
  ADD KEY `favorito_ibfk_2` (`id_usuario`);

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD KEY `imagen_ibkf_1` (`id_producto`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `producto_ibfk_1` (`id_categoria`),
  ADD KEY `producto_ibfk_2` (`id_subcategoria`);

--
-- Indices de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD KEY `subcategoria_ibkf_1` (`id_categoria`);

--
-- Indices de la tabla `usuario`
--

--
-- Indices de la tabla `usuario_rs`
--
ALTER TABLE `usuario_rs`
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `favorito`
--
ALTER TABLE `favorito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  MODIFY `id_subcategoria` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuario_rs`
--
ALTER TABLE `usuario_rs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `favorito`
--
ALTER TABLE `favorito`
  ADD CONSTRAINT `favorito_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `favorito_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD CONSTRAINT `imagen_ibkf_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`id_subcategoria`) REFERENCES `subcategoria` (`id_subcategoria`);

--
-- Filtros para la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD CONSTRAINT `subcategoria_ibkf_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`);

--
-- Filtros para la tabla `usuario_rs`
--
ALTER TABLE `usuario_rs`
  ADD CONSTRAINT `usuario_rs_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
