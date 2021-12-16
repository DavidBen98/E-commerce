-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-12-2021 a las 22:42:31
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `catato_hogar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `nombre_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`nombre_categoria`) VALUES
('comedor'),
('dormitorio'),
('living'),
('oficina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `id` int(7) NOT NULL,
  `email` varchar(40) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `texto` varchar(500) NOT NULL,
  `respondido` tinyint(1) NOT NULL,
  `id_usuario` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`id`, `email`, `nombre`, `apellido`, `texto`, `respondido`, `id_usuario`) VALUES
(1, 'caeShar@hotmail.com', 'caele', 'shardi', 'Esta es una consulta', 0, NULL),
(2, 'marcoPOlo@hotmail.com', 'Marco', 'Polo', 'esta NO es una consulta de un usuario', 0, NULL),
(3, 'paMartinez@hotmail.com', 'pablo', 'martinez', 'esta es otra consulta de un visitante', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int(10) NOT NULL,
  `precio_unidad` decimal(20,0) NOT NULL,
  `cantidad` int(250) NOT NULL,
  `producto_codigo` varchar(10) DEFAULT NULL,
  `usuario_id` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `precio_unidad`, `cantidad`, `producto_codigo`, `usuario_id`) VALUES
(1, '27959', 1, 'como1', 1),
(2, '25199', 1, 'doca3', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codigo` varchar(10) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL,
  `nombre_subcategoria` varchar(100) NOT NULL,
  `material` varchar(100) NOT NULL,
  `color` varchar(20) NOT NULL,
  `caracteristicas` varchar(500) NOT NULL,
  `marca` varchar(30) NOT NULL,
  `stock` int(6) NOT NULL,
  `precio` decimal(6,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codigo`, `descripcion`, `nombre_categoria`, `nombre_subcategoria`, `material`, `color`, `caracteristicas`, `marca`, `stock`, `precio`) VALUES
('come1', 'mesa nordica escandinava', 'comedor', 'mesas', 'madera', 'blanco y marron', 'ancho: 60,altura: 77', 'stockhoy', 4, '6999'),
('come2', 'mesa comedor escandinava nordica', 'comedor', 'mesas', 'madera', 'blanco y marron', 'ancho: 80,altura: 77', 'nordico muebles', 4, '9698'),
('come3', 'mesa comedor eco laqueada extensible', 'comedor', 'mesas', 'madera', 'blanco', 'ancho: 85,altura: 80', 'living style', 4, '12169'),
('come4', 'mesa comedor escandinava nordica laqueada paraiso', 'comedor', 'mesas', 'madera', 'blanco y marron', 'ancho: 85,altura: 80', 'mesas mp', 4, '9152'),
('come5', 'mesa nordica escandinava comedor', 'comedor', 'mesas', 'madera', 'blanco y negro', 'ancho: 70,altura: 77', 'stockhoy', 4, '8999'),
('come6', 'mesa tulip saarinen', 'comedor', 'mesas', 'madera laqueada', 'blanco', 'ancho: 90,altura: 80', 'emuebles', 4, '6500'),
('como1', 'modular cristalero vajillero orlandi', 'comedor', 'modulares', 'melamina', 'beige', 'ancho: 185,altura: 183,profundidad: 35.8', 'muebles orlandi', 3, '27959'),
('como2', 'modular comoda vajillero orlandi', 'comedor', 'modulares', 'madera', 'marron', 'ancho: 185,altura: 183,profundidad: 35', 'orlandi', 4, '25999'),
('como3', 'organizador vajillero biblioteca modular despenser', 'comedor', 'modulares', 'madera', 'negro', 'ancho: 80,altura: 35,profundidad:35', 'centro estant', 4, '17599'),
('como4', 'modular rack para tv', 'comedor', 'modulares', 'melanina', 'blanco', 'ancho: 208,altura: 165,profundidad:30', 'fiplasto', 4, '18999'),
('como5', 'modular vajillero vitrina organizador vintage', 'comedor', 'modulares', 'madera', 'blanco', 'ancho: ,altura: ,profundidad:', 'cuatro cedros muebles', 4, '19999'),
('como6', 'modular organizador aparador funcional', 'comedor', 'modulares', 'melanina', 'blanco', 'ancho: 0.35,altura: 1.41,profundidad: 0.35', 'orlandi', 4, '19489'),
('cosi1', 'silla eames base nordica moderno', 'comedor', 'sillas', 'madera y polipropileno', 'blanco', 'ancho: 0.35,altura: 1.41', 'eames', 4, '3499'),
('cosi2', 'silla de escritorio mobilarg lisy fija', 'comedor', 'sillas', 'metal y cuero sintético', 'negro', 'ancho: 0.35,altura: 1.41', 'mobilarg', 4, '6290'),
('cosi3', 'silla fija cromada greta de diseño', 'comedor', 'sillas', 'madera', 'blanco', 'ancho: 30,altura: 100', 'jmi', 4, '8600'),
('cosi4', 'silla tulip', 'comedor', 'sillas', 'madera', 'blanco y marron', 'ancho: 30,altura: 100', 'decoto', 4, '7'),
('cosi5', 'silla grace', 'comedor', 'sillas', 'madera', 'negro y marron', 'ancho: 30,altura: 100', 'decoto', 4, '7'),
('cosi6', 'silla fija cromada tulip de diseño', 'comedor', 'sillas', 'madera', 'negro', 'ancho: 30,altura: 100', 'jmi', 4, '8600'),
('doca1', 'cama corredera telescopica', 'dormitorio', 'camas', 'melanina', 'blanco', '2 plazas,largo: 205,ancho: 160', 'mobilarg', 4, '43990'),
('doca2', 'cama repisa estantes porta', 'dormitorio', 'camas', 'madera', 'marron', '2 plazas,largo: 210,ancho: 150', 'orlandi', 4, '11990'),
('doca3', 'cama con 4 cajones', 'dormitorio', 'camas', 'madera y eco cuero', 'rosa', '2 plazas,largo: 200,ancho: 160', 'tu mejor sommier', 3, '25199'),
('doca4', 'cama box sommier 2 plazas con 6 cajones', 'dormitorio', 'camas', 'madera', 'marron', '2 plazas,largo: 192,ancho: 143', 'móbica', 4, '22950'),
('doca5', 'cama box sommier', 'dormitorio', 'camas', 'madera', 'negro', '2 plazas,largo: 205,ancho: 160', 'mobilarg', 4, '83990'),
('doca6', 'box sommier cajonera cama', 'dormitorio', 'camas', 'melanina', 'beige', '2 plazas,largo: 200,ancho: 200', 'mari mar', 4, '34700'),
('doco1', 'colchón cannon espuma tropical', 'dormitorio', 'colchones', 'tela de algodón', 'blanco', 'ancho: 80cm,largo: 190cm,altura: 18cm', 'cannon', 4, '8472'),
('doco2', 'colchón cannon espuma exclusive', 'dormitorio', 'colchones', 'tela de jacquard', 'beige y marron', 'ancho: 140,largo: 190,altura: 29', 'cannon', 4, '28601'),
('doco3', 'colchón cannon espuma princess', 'dormitorio', 'colchones', 'tela de jackard', 'blanco', 'ancho: ,largo: ,altura:80 x 190 x 20', 'cannon', 4, '10979'),
('doco4', 'colchón cannon espuma exclusivele', 'dormitorio', 'colchones', 'tela de jacquard', 'beige y marron', 'ancho: 80,largo: 190,altura: 29', 'cannon', 4, '18214'),
('doco5', 'plaza de resortes cannon resortes soñar', 'dormitorio', 'colchones', 'tela de algodón', 'blanco', 'ancho: 80,largo: 190,altura: 23', 'cannon', 4, '13024'),
('doco6', 'plaza de resortes piero sonno', 'dormitorio', 'colchones', 'tela de jackard', 'blanco', 'ancho: 90,largo: 190,altura:26', 'piero', 4, '17195'),
('dome1', 'mesa de luz 1 cajón', 'dormitorio', 'mesas de luz', 'madera', 'marron', 'ancho: 47, profundidad: 31, altura: 55', 'mosconi', 4, '4621'),
('dome2', 'mesa de luz escandinava - vintage', 'dormitorio', 'mesas de luz', 'melanina', 'marron y blanco', 'ancho: 40, profundidad: 24, altura: 60', 'mjmaderas', 4, '3099'),
('dome3', 'mesa de luz cajon puerta sajo', 'dormitorio', 'mesas de luz', 'madera', 'negro', 'ancho: 42,profundidad: 30, altura:60', 'sajo', 4, '2999'),
('dome4', 'mesa mesita luz flotante con cajon correderan', 'dormitorio', 'mesas de luz', 'madera pino', 'blanco y marron', 'ancho: 35,profundidad: 29, altura:30', 'su ferretería online', 4, '4300'),
('dome5', 'mesa de luz mesita con botinero', 'dormitorio', 'mesas de luz', 'melanina', 'blanco', 'ancho: 38, profundidad: 0.38, altura:71', 'centro estant', 4, '6399'),
('dome6', 'mesa de luz premium', 'dormitorio', 'mesas de luz', 'melanina', 'gris', 'ancho: 53, profundidad: 35.5, altura:67', 'orlandi', 4, '6399'),
('dopl1', 'placard ropero 2 puertas', 'dormitorio', 'placares', 'melanina', 'blanco', 'ancho: 60, profundidad: 47,altura: 182', 'mosconi', 4, '10300'),
('dopl2', 'placard puertas corredizas', 'dormitorio', 'placares', 'madera', 'blanco viejo', 'ancho: 182, profundidad: 53,altura: 184', 'orlandi', 4, '28479'),
('dopl3', 'placard wengue mogno', 'dormitorio', 'placares', 'madera', 'blanco', 'ancho: 181, profundidad: 47,altura: 184', 'orlandi', 4, '19499'),
('dopl4', 'placard vestidor moderno ', 'dormitorio', 'placares', 'madera', 'blanco', 'ancho:180,profundidad: 55,altura: 180', 'carpintería rivadavia', 4, '20921'),
('dopl5', 'placard ropero 12 puertas 4 cajones', 'dormitorio', 'placares', 'madera', 'blanco viejo', 'ancho:212,profundidad: 47,altura: 215', 'orlandi', 4, '32299'),
('dopl6', 'ropero placard 2 puertas 4 estantes infantil cubo ', 'dormitorio', 'placares', 'madera', 'beige', 'ancho:87,profundidad: 38,altura: 147', 'diseños modernos', 4, '8998'),
('lifu1', 'futon rustico', 'living', 'futones', 'madera', 'blanco y marron', 'ancho: 205,altura: 100,profundidad: 140', 'bek', 4, '16899'),
('lifu2', 'futon modelo owen', 'living', 'futones', 'madera', 'blanco', 'ancho: 100,altura: 76,profundidad: 100', 'tribeca', 4, '35939'),
('lifu3', 'futon 3 cpos cipres', 'living', 'futones', 'madera', 'rosa y marron', 'ancho: 200,altura: 80,profundidad: 100', 'oeste amoblamientos', 4, '22705'),
('lifu4', 'futon sillón cama más colchón de tres cuerpos', 'living', 'futones', 'madera', 'blanco y marron', 'ancho: 205,altura: 100,profundidad: 100', 'maderera pino hogar', 4, '19000'),
('lifu5', 'sofa cama bed napa lino ', 'living', 'futones', 'madera', 'negro', 'ancho: 180,altura: 80,profundidad: 80', 'living style', 4, '25579'),
('lifu6', 'futon napa', 'living', 'futones', 'metal', 'blanco', 'ancho: 179,altura: 79,profundidad: 100', 'tribeca', 4, '27720'),
('lisi1', 'sillon escandinavo', 'living', 'sillones', 'chenille y madera', 'gris', 'ancho: 160,profundidad: 80,altura: 80', 'dadaa muebles', 4, '32999'),
('lisi2', 'sillón 2 cuerpos', 'living', 'sillones', 'madera y tela', 'verde', 'ancho: 150,profundidad: 70,altura: 75', 'carbatt', 4, '15500'),
('lisi3', 'sillon nordico', 'living', 'sillones', 'chenille', 'gris', 'ancho: 180,profundidad: 80,altura: 80', 'dadaa muebles', 4, '32999'),
('lisi4', 'sofa basic especial', 'living', 'sillones', 'madera', 'negro', 'ancho: 123,profundidad: 73,altura: 81', 'chera', 4, '19729'),
('lisi5', 'sillón sofá escandinavo nórdico retro vintage', 'living', 'sillones', 'chenille antidesgarros y madera', 'gris', 'ancho: 150,profundidad: 80,altura: 95', 'interliving', 2, '38990'),
('lisi6', 'sillon rinconero', 'living', 'sillones', 'chenille y madera', 'morado', 'ancho: 180,profundidad: 0.7,altura: 75', 'carbatt', 4, '24900'),
('ofbi1', 'biblioteca de pino', 'oficina', 'bibliotecas', 'madera', 'marron', 'ancho: 25,profundidad: 25,altura: 180', 'colonial', 4, '5654'),
('ofbi2', 'biblioteca estantería industrial', 'oficina', 'bibliotecas', 'hierro y madera', 'marron', 'ancho: 120,profundidad: 30,altura: 190', 'almamuebleshym', 4, '20900'),
('ofbi3', 'biblioteca estantería escandinava', 'oficina', 'bibliotecas', 'madera', 'blanco y marron', 'ancho: 90,profundidad: 30,altura: 180', 'pazionne', 4, '14799'),
('ofbi4', 'biblioteca de pino', 'oficina', 'bibliotecas', 'madera', 'marron', 'ancho: 100,profundidad: 25,altura: 180', 'cruz', 4, '5000'),
('ofbi5', 'bibilioteca estanteria madera pino organizador emm', 'oficina', 'bibliotecas', 'madera', 'blanco', 'ancho: 72,profundidad: 35,altura: 153', 'corfam', 4, '10994'),
('ofbi6', 'biblioteca alta organizador estantes escalera', 'oficina', 'bibliotecas', 'madera', 'marron', 'ancho: 90,profundidad: 25,altura: 183', 'muebles eco', 4, '8760'),
('ofme1', 'escritorio cerradura', 'oficina', 'mesas de escritorio', 'madera', 'beige y negro', 'altura: 74,ancho: 120,profundidad: 70', 'platinum', 4, '9599'),
('ofme2', 'mesa de pc con alzada owen', 'oficina', 'mesas de escritorio', 'madera', 'marron', 'altura: 75,ancho: 18,profundidad: 45', 'su-office', 4, '6990'),
('ofme3', 'escritorio pc notebook mod', 'oficina', 'mesas de escritorio', 'madera', 'blanco', 'altura: 75,ancho: 100,profundidad: 45', 'platinum', 4, '5199'),
('ofme4', 'mesa escritorio pc extraible', 'oficina', 'mesas de escritorio', 'madera', 'negro', 'altura: 121,ancho: 101,profundidad: 45', 'mosconi', 4, '7989'),
('ofme5', 'mesa escritorio para pc- notebooks', 'oficina', 'mesas de escritorio', 'madera', 'beige y marron', 'altura: 75,ancho: 95,profundidad: 44', 'piro', 4, '12695'),
('ofme6', 'escritorio mesa pc impresora biblioteca oficina', 'oficina', 'mesas de escritorio', 'madera', 'blanco', 'altura: 121,ancho: 101,profundidad: 45', 'mosconi', 4, '8570'),
('ofsi1', 'tisera silla baut ergonómica', 'oficina', 'sillas de oficina', 'algodon y metal', 'negro', 'altura del respaldo: 80,altura del piso al asiento: 50', 'tisera', 4, '16999'),
('ofsi2', 'silla ejcutiva mesh', 'oficina', 'sillas de oficina', 'algodon y metal', 'negro', 'altura del respaldo: 69,altura del piso al asiento: 53', 'baires4', 4, '18990'),
('ofsi3', 'silla de escritorio de outlet diva', 'oficina', 'sillas de oficina', 'algodon y metal', 'negro', 'altura del respaldo: 55,altura del piso al asiento: 30', 'sillas de outlet', 4, '13640'),
('ofsi4', 'sillon ejecutivo silla oficina pc', 'oficina', 'sillas de oficina', 'algodon y metal', 'negro', 'altura del respaldo: 66,altura del piso al asiento: 43', 'rd', 4, '17520'),
('ofsi5', 'silla ergonómica', 'oficina', 'sillas de oficina', 'algodon y metal', 'negro', 'altura del respaldo: 55,altura del piso al asiento: 47', 'baires4', 4, '13040'),
('ofsi6', 'silla butaca gamer ', 'oficina', 'sillas de oficina', 'algodon y metal', 'negro', 'altura del respaldo: 87.5,altura del piso al asiento: 50', 'iqual', 4, '39999');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategoria`
--

CREATE TABLE `subcategoria` (
  `nombre_subcategoria` varchar(100) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `subcategoria`
--

INSERT INTO `subcategoria` (`nombre_subcategoria`, `nombre_categoria`) VALUES
('mesas', 'comedor'),
('modulares', 'comedor'),
('sillas', 'comedor'),
('camas', 'dormitorio'),
('colchones', 'dormitorio'),
('mesas de luz', 'dormitorio'),
('placares', 'dormitorio'),
('futones', 'living'),
('sillones', 'living'),
('bibliotecas', 'oficina'),
('mesas de escritorio', 'oficina'),
('sillas de oficina', 'oficina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(7) NOT NULL,
  `nombreUsuario` varchar(30) NOT NULL,
  `contrasena` varchar(250) NOT NULL,
  `perfil` varchar(2) NOT NULL,
  `nroDni` varchar(8) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `provincia` varchar(30) NOT NULL,
  `ciudad` varchar(30) NOT NULL,
  `direccion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombreUsuario`, `contrasena`, `perfil`, `nroDni`, `nombre`, `apellido`, `email`, `provincia`, `ciudad`, `direccion`) VALUES
(1, 'caelenaShar', '0e5cd0a77778f353ca0863d3ca43f35e4f71d74c33e6524383e75349c6f42ac1ac0e7de58a0438a42891d9a497f62454b7bdaf8a93286f64314a433b7e4b7f3f', 'U', '41689734', 'caelena', 'shar', 'caeShar@hotmail.com', 'buenos aires', 'bahia blanca', 'avenida alem'),
(2, 'AnaLopez', 'e686859d8a43300614ee7767fc287d6d227cb16cd1204f11150f8207302edeb7e15883561621a13a9c54e63a913528a8ec759eb00fb8cfd445e8cbc66b32edf4', 'E', '12345678', 'Ana', 'Lopez', 'analopez@hotmail.com', 'Buenos Aires', 'Bahia Blanca', 'Calle 1'),
(3, 'RomanRiquelme', '3bd0ec7e54237c798afb6ede6ebc0feaadce5ab191d7d2f6310ad92072f332251aa7e66af79ee9e8f77e62ef2df0dde0e8872ca92e2d4a57adc334c6f8f830b9', 'U', '12345678', 'Roman', 'Riquelme', 'romanriquelme@hotmail.com', 'Buenos Aires', 'San Fernando', 'Calle 2'),
(4, 'ChinaSuarez', 'ab4a301aa40357605ddce7b47ed7bcba32206defa7e8a6638528cecf7c4f2a8991fc51fa459e2d328c54af0051161557f280d9e8175606ee7b53da9a53de6866', 'E', '12345678', 'China', 'Suarez', 'chinasuarez@hotmail.com', 'Buenos Aires', 'Olavarria', 'Calle 3');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`nombre_categoria`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_codigo` (`producto_codigo`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `nombre_categoria` (`nombre_categoria`),
  ADD KEY `nombre_subcategoria` (`nombre_subcategoria`);

--
-- Indices de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD PRIMARY KEY (`nombre_subcategoria`),
  ADD KEY `nombre_categoria` (`nombre_categoria`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `consulta_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`producto_codigo`) REFERENCES `producto` (`codigo`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`nombre_categoria`) REFERENCES `categoria` (`nombre_categoria`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`nombre_subcategoria`) REFERENCES `subcategoria` (`nombre_subcategoria`);

--
-- Filtros para la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD CONSTRAINT `subcategoria_ibfk_1` FOREIGN KEY (`nombre_categoria`) REFERENCES `categoria` (`nombre_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
