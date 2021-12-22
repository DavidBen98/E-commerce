-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-12-2021 a las 15:39:59
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.12

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
  `nombre_categoria` varchar(100) NOT NULL,
  `id_categoria` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`nombre_categoria`, `id_categoria`) VALUES
('comedor', 1),
('dormitorio', 2),
('living', 3),
('oficina', 4);

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
(1, 'romanriquelme@hotmail.com', 'roman', 'riquelme', 'sadas', 0, NULL);

--
-- Disparadores `consulta`
--
DELIMITER $$
CREATE TRIGGER `bi_obtenerUsuarioConsulta` BEFORE INSERT ON `consulta` FOR EACH ROW BEGIN    
    
    DECLARE newEmail VARCHAR(100);
    SET newEmail = new.email;

    SELECT u.id INTO @id_Usuario
    				FROM usuario as u
        			WHERE u.email = newEmail  ;   
   	 
    	IF(@id_Usuario != 0) THEN
   			UPDATE usuario SET consulta.id_usuario = usuario.id;
    	END IF;
    END
$$
DELIMITER ;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codigo` varchar(10) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `material` varchar(100) NOT NULL,
  `color` varchar(20) NOT NULL,
  `caracteristicas` varchar(500) NOT NULL,
  `marca` varchar(30) NOT NULL,
  `stock` int(6) NOT NULL,
  `precio` decimal(6,0) NOT NULL,
  `id_categoria` int(100) NOT NULL,
  `id_subcategoria` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codigo`, `descripcion`, `material`, `color`, `caracteristicas`, `marca`, `stock`, `precio`, `id_categoria`, `id_subcategoria`) VALUES
('come1', 'mesa nordica escandinava', 'madera', 'blanco y marron', 'ancho: 60,altura: 77', 'stockhoy', 4, '6999', 1, 17),
('come2', 'mesa comedor escandinava nordica', 'madera', 'blanco y marron', 'ancho: 80,altura: 77', 'nordico muebles', 4, '9698', 1, 17),
('come3', 'mesa comedor eco laqueada extensible', 'madera', 'blanco', 'ancho: 85,altura: 80', 'living style', 4, '12169', 1, 17),
('come4', 'mesa comedor escandinava nordica laqueada paraiso', 'madera', 'blanco y marron', 'ancho: 85,altura: 80', 'mesas mp', 4, '9152', 1, 17),
('come5', 'mesa nordica escandinava comedor', 'madera', 'blanco y negro', 'ancho: 70,altura: 77', 'stockhoy', 4, '8999', 1, 17),
('come6', 'mesa tulip saarinen', 'madera laqueada', 'blanco', 'ancho: 90,altura: 80', 'emuebles', 4, '6500', 1, 17),
('como1', 'modular cristalero vajillero orlandi', 'melamina', 'beige', 'ancho: 185,altura: 183,profundidad: 35.8', 'muebles orlandi', 4, '27959', 1, 20),
('como2', 'modular comoda vajillero orlandi', 'madera', 'marron', 'ancho: 185,altura: 183,profundidad: 35', 'orlandi', 4, '25999', 1, 20),
('como3', 'organizador vajillero biblioteca modular despenser', 'madera', 'negro', 'ancho: 80,altura: 35,profundidad:35', 'centro estant', 4, '17599', 1, 20),
('como4', 'modular rack para tv', 'melanina', 'blanco', 'ancho: 208,altura: 165,profundidad:30', 'fiplasto', 4, '18999', 1, 20),
('como5', 'modular vajillero vitrina organizador vintage', 'madera', 'blanco', 'ancho: ,altura: ,profundidad:', 'cuatro cedros muebles', 4, '19999', 1, 20),
('como6', 'modular organizador aparador funcional', 'melanina', 'blanco', 'ancho: 0.35,altura: 1.41,profundidad: 0.35', 'orlandi', 4, '19489', 1, 20),
('cosi1', 'silla eames base nordica moderno', 'madera y polipropileno', 'blanco', 'ancho: 0.35,altura: 1.41', 'eames', 4, '3499', 1, 22),
('cosi2', 'silla de escritorio mobilarg lisy fija', 'metal y cuero sintético', 'negro', 'ancho: 0.35,altura: 1.41', 'mobilarg', 4, '6290', 1, 22),
('cosi3', 'silla fija cromada greta de diseño', 'madera', 'blanco', 'ancho: 30,altura: 100', 'jmi', 4, '8600', 1, 22),
('cosi4', 'silla tulip', 'madera', 'blanco y marron', 'ancho: 30,altura: 100', 'decoto', 4, '6500', 1, 22),
('cosi5', 'silla grace', 'madera', 'negro y marron', 'ancho: 30,altura: 100', 'decoto', 4, '6550', 1, 22),
('cosi6', 'silla fija cromada tulip de diseño', 'madera', 'negro', 'ancho: 30,altura: 100', 'jmi', 4, '8600', 1, 22),
('doca1', 'cama corredera telescopica', 'melanina', 'blanco', '2 plazas,largo: 205,ancho: 160', 'mobilarg', 4, '43990', 2, 14),
('doca2', 'cama repisa estantes porta', 'madera', 'marron', '2 plazas,largo: 210,ancho: 150', 'orlandi', 4, '11990', 2, 14),
('doca3', 'cama con 4 cajones', 'madera y eco cuero', 'rosa', '2 plazas,largo: 200,ancho: 160', 'tu mejor sommier', 4, '25199', 2, 14),
('doca4', 'cama box sommier 2 plazas con 6 cajones', 'madera', 'marron', '2 plazas,largo: 192,ancho: 143', 'móbica', 4, '22950', 2, 14),
('doca5', 'cama box sommier', 'madera', 'negro', '2 plazas,largo: 205,ancho: 160', 'mobilarg', 4, '83990', 2, 14),
('doca6', 'box sommier cajonera cama', 'melanina', 'beige', '2 plazas,largo: 200,ancho: 200', 'mari mar', 4, '34700', 2, 14),
('doco1', 'colchón cannon espuma tropical', 'tela de algodón', 'blanco', 'ancho: 80cm,largo: 190cm,altura: 18cm', 'cannon', 4, '8472', 2, 15),
('doco2', 'colchón cannon espuma exclusive', 'tela de jacquard', 'beige y marron', 'ancho: 140,largo: 190,altura: 29', 'cannon', 4, '28601', 2, 15),
('doco3', 'colchón cannon espuma princess', 'tela de jackard', 'blanco', 'ancho: ,largo: ,altura:80 x 190 x 20', 'cannon', 4, '10979', 2, 15),
('doco4', 'colchón cannon espuma exclusivele', 'tela de jacquard', 'beige y marron', 'ancho: 80,largo: 190,altura: 29', 'cannon', 4, '18214', 2, 15),
('doco5', 'plaza de resortes cannon resortes soñar', 'tela de algodón', 'blanco', 'ancho: 80,largo: 190,altura: 23', 'cannon', 4, '13024', 2, 15),
('doco6', 'plaza de resortes piero sonno', 'tela de jackard', 'blanco', 'ancho: 90,largo: 190,altura:26', 'piero', 4, '17195', 2, 15),
('dome1', 'mesa de luz 1 cajón', 'madera', 'marron', 'ancho: 47, profundidad: 31, altura: 55', 'mosconi', 4, '4621', 2, 19),
('dome2', 'mesa de luz escandinava - vintage', 'melanina', 'marron y blanco', 'ancho: 40, profundidad: 24, altura: 60', 'mjmaderas', 4, '3099', 2, 19),
('dome3', 'mesa de luz cajon puerta sajo', 'madera', 'negro', 'ancho: 42,profundidad: 30, altura:60', 'sajo', 4, '2999', 2, 19),
('dome4', 'mesa mesita luz flotante con cajon correderan', 'madera pino', 'blanco y marron', 'ancho: 35,profundidad: 29, altura:30', 'su ferretería online', 4, '4300', 2, 19),
('dome5', 'mesa de luz mesita con botinero', 'melanina', 'blanco', 'ancho: 38, profundidad: 0.38, altura:71', 'centro estant', 4, '6399', 2, 19),
('dome6', 'mesa de luz premium', 'melanina', 'gris', 'ancho: 53, profundidad: 35.5, altura:67', 'orlandi', 4, '6399', 2, 19),
('dopl1', 'placard ropero 2 puertas', 'melanina', 'blanco', 'ancho: 60, profundidad: 47,altura: 182', 'mosconi', 4, '10300', 2, 21),
('dopl2', 'placard puertas corredizas', 'madera', 'blanco viejo', 'ancho: 182, profundidad: 53,altura: 184', 'orlandi', 4, '28479', 2, 21),
('dopl3', 'placard wengue mogno', 'madera', 'blanco', 'ancho: 181, profundidad: 47,altura: 184', 'orlandi', 4, '19499', 2, 21),
('dopl4', 'placard vestidor moderno ', 'madera', 'blanco', 'ancho:180,profundidad: 55,altura: 180', 'carpintería rivadavia', 4, '20921', 2, 21),
('dopl5', 'placard ropero 12 puertas 4 cajones', 'madera', 'blanco viejo', 'ancho:212,profundidad: 47,altura: 215', 'orlandi', 4, '32299', 2, 21),
('dopl6', 'ropero placard 2 puertas 4 estantes infantil cubo ', 'madera', 'beige', 'ancho:87,profundidad: 38,altura: 147', 'diseños modernos', 4, '8998', 2, 21),
('lifu1', 'futon rustico', 'madera', 'blanco y marron', 'ancho: 205,altura: 100,profundidad: 140', 'bek', 4, '16899', 3, 16),
('lifu2', 'futon modelo owen', 'madera', 'blanco', 'ancho: 100,altura: 76,profundidad: 100', 'tribeca', 4, '35939', 3, 16),
('lifu3', 'futon 3 cpos cipres', 'madera', 'rosa y marron', 'ancho: 200,altura: 80,profundidad: 100', 'oeste amoblamientos', 4, '22705', 3, 16),
('lifu4', 'futon sillón cama más colchón de tres cuerpos', 'madera', 'blanco y marron', 'ancho: 205,altura: 100,profundidad: 100', 'maderera pino hogar', 4, '19000', 3, 16),
('lifu5', 'sofa cama bed napa lino ', 'madera', 'negro', 'ancho: 180,altura: 80,profundidad: 80', 'living style', 4, '25579', 3, 16),
('lifu6', 'futon napa', 'metal', 'blanco', 'ancho: 179,altura: 79,profundidad: 100', 'tribeca', 4, '27720', 3, 16),
('lisi1', 'sillon escandinavo', 'chenille y madera', 'gris', 'ancho: 160,profundidad: 80,altura: 80', 'dadaa muebles', 4, '32999', 3, 24),
('lisi2', 'sillón 2 cuerpos', 'madera y tela', 'verde', 'ancho: 150,profundidad: 70,altura: 75', 'carbatt', 4, '15500', 3, 24),
('lisi3', 'sillon nordico', 'chenille', 'gris', 'ancho: 180,profundidad: 80,altura: 80', 'dadaa muebles', 4, '32999', 3, 24),
('lisi4', 'sofa basic especial', 'madera', 'negro', 'ancho: 123,profundidad: 73,altura: 81', 'chera', 4, '19729', 3, 24),
('lisi5', 'sillón sofá escandinavo nórdico retro vintage', 'chenille antidesgarros y madera', 'gris', 'ancho: 150,profundidad: 80,altura: 95', 'interliving', 4, '38990', 3, 24),
('lisi6', 'sillon rinconero', 'chenille y madera', 'morado', 'ancho: 180,profundidad: 0.7,altura: 75', 'carbatt', 4, '24900', 3, 24),
('ofbi1', 'biblioteca de pino', 'madera', 'marron', 'ancho: 25,profundidad: 25,altura: 180', 'colonial', 4, '5654', 4, 13),
('ofbi2', 'biblioteca estantería industrial', 'hierro y madera', 'marron', 'ancho: 120,profundidad: 30,altura: 190', 'almamuebleshym', 4, '20900', 4, 13),
('ofbi3', 'biblioteca estantería escandinava', 'madera', 'blanco y marron', 'ancho: 90,profundidad: 30,altura: 180', 'pazionne', 4, '14799', 4, 13),
('ofbi4', 'biblioteca de pino', 'madera', 'marron', 'ancho: 100,profundidad: 25,altura: 180', 'cruz', 4, '5000', 4, 13),
('ofbi5', 'bibilioteca estanteria madera pino organizador emm', 'madera', 'blanco', 'ancho: 72,profundidad: 35,altura: 153', 'corfam', 4, '10994', 4, 13),
('ofbi6', 'biblioteca alta organizador estantes escalera', 'madera', 'marron', 'ancho: 90,profundidad: 25,altura: 183', 'muebles eco', 4, '8760', 4, 13),
('ofme1', 'escritorio cerradura', 'madera', 'beige y negro', 'altura: 74,ancho: 120,profundidad: 70', 'platinum', 4, '9599', 4, 18),
('ofme2', 'mesa de pc con alzada owen', 'madera', 'marron', 'altura: 75,ancho: 18,profundidad: 45', 'su-office', 4, '6990', 4, 18),
('ofme3', 'escritorio pc notebook mod', 'madera', 'blanco', 'altura: 75,ancho: 100,profundidad: 45', 'platinum', 4, '5199', 4, 18),
('ofme4', 'mesa escritorio pc extraible', 'madera', 'negro', 'altura: 121,ancho: 101,profundidad: 45', 'mosconi', 4, '7989', 4, 18),
('ofme5', 'mesa escritorio para pc- notebooks', 'madera', 'beige y marron', 'altura: 75,ancho: 95,profundidad: 44', 'piro', 4, '12695', 4, 18),
('ofme6', 'escritorio mesa pc impresora biblioteca oficina', 'madera', 'blanco', 'altura: 121,ancho: 101,profundidad: 45', 'mosconi', 4, '8570', 4, 18),
('ofsi1', 'tisera silla baut ergonómica', 'algodon y metal', 'negro', 'altura del respaldo: 80,altura del piso al asiento: 50', 'tisera', 4, '16999', 4, 23),
('ofsi2', 'silla ejecutiva mesh', 'algodon y metal', 'negro', 'altura del respaldo: 69,altura del piso al asiento: 53', 'baires4', 4, '18990', 4, 23),
('ofsi3', 'silla de escritorio de outlet diva', 'algodon y metal', 'negro', 'altura del respaldo: 55,altura del piso al asiento: 30', 'sillas de outlet', 4, '13640', 4, 23),
('ofsi4', 'sillon ejecutivo silla oficina pc', 'algodon y metal', 'negro', 'altura del respaldo: 66,altura del piso al asiento: 43', 'rd', 4, '17520', 4, 23),
('ofsi5', 'silla ergonómica', 'algodon y metal', 'negro', 'altura del respaldo: 55,altura del piso al asiento: 47', 'baires4', 4, '13040', 4, 23),
('ofsi6', 'silla butaca gamer ', 'algodon y metal', 'negro', 'altura del respaldo: 87.5,altura del piso al asiento: 50', 'iqual', 4, '39999', 4, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategoria`
--

CREATE TABLE `subcategoria` (
  `nombre_subcategoria` varchar(100) NOT NULL,
  `id_subcategoria` int(100) NOT NULL,
  `id_categoria` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `subcategoria`
--

INSERT INTO `subcategoria` (`nombre_subcategoria`, `id_subcategoria`, `id_categoria`) VALUES
('bibliotecas', 13, 4),
('camas', 14, 2),
('colchones', 15, 2),
('futones', 16, 3),
('mesas', 17, 1),
('mesas de escritorio', 18, 4),
('mesas de luz', 19, 2),
('modulares', 20, 1),
('placares', 21, 2),
('sillas', 22, 1),
('sillas de oficina', 23, 4),
('sillones', 24, 3);

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
  ADD PRIMARY KEY (`id_categoria`);

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  MODIFY `id_subcategoria` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`id_subcategoria`) REFERENCES `subcategoria` (`id_subcategoria`);

--
-- Filtros para la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD CONSTRAINT `subcategoria_ibkf_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
