-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-03-2022 a las 18:20:22
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
  `nombre_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'Comedor'),
(2, 'Dormitorio'),
(3, 'Living'),
(4, 'Oficina'),
(7, 'Jardin');

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

INSERT INTO `consulta` (`id`, `email`, `nombre`, `apellido`, `texto`, `respondido`, `usuario_id`) VALUES
(1, 'romanriquelme@hotmail.com', 'roman', 'riquelme', 'La madera es pino?', 0, 3),
(2, 'romanriquelme@hotmail.com', 'roman', 'riquelme', 'El hierro de donde proviene?', 0, 3),
(3, 'romanriquelme@hotmail.com', 'Roman', 'Riquelme', 'Buen dia, hacen envios a Montevideo?', 0, 3),
(4, 'davidbenedette@hotmail.com', 'david', 'benedette', 'Buen dia, tienen stock de sillas?', 0, 6),
(5, 'davidbenedette@hotmail.com', 'david', 'benedette', 'aceptan paypal?', 0, 6),
(6, 'davidbenedette@gmail.com', 'david', 'benedette', 'los sabados hacen envios?', 0, 8),
(7, 'davidbenedette@gmail.com', 'david', 'benedette', 'se puede retirar por el local?', 0, 8),
(8, 'davidbenedette@gmail.com', 'david', 'benedette', 'tienen sucursal en rosario?', 0, 8),
(9, 'davidbenedette@hotmail.com', 'david', 'benedette', 'aceptan devolucion por fallas tecnicas?', 0, 6),
(10, 'romanriquelme@hotmail.com', 'roman', 'riquelme', 'cuantos dias tarda en llegar?', 0, 3);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `id` int(11) NOT NULL,
  `id_producto` int(255) NOT NULL,
  `imagen` longblob NOT NULL,
  `portada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`id`, `id_producto`, `imagen`, `portada`) VALUES
(2, 74, 0x524946460a2800005745425056503820fe270000d0c8009d012a8601f4013e6d369648a422a5282451da09000d89696efabdd80be0185d7ccd6dff0323ac867f53cb078da2b5effffd86390382d8bf03f40788eda9a497d597f3ffcee0c36be637dc6f61daefb764fa27896fa575cffa475f15defe53c12fed9dc1bb4ffe13c45318fb7533d7a124d8bea6a10b367fc7fa86ff3ef49fffc3cdbff0fbf43d20086ace36af36aec8db85671b579b5747c6903104eaeed2cb7df3fd28bc3bf41623798b8d70e7465c5735946e124ae7b2f83cf47c03c8de46564b3317fe93eda5ef5abe891d5f6087dd51c28aa1a16ae171d41a748e74458254f18d250651c90f3a9c5ed9200ff482301db5927093c1402c6275662b7f36db6634d175d93a4bfb1cc47b2afc47a58b27d1244ee56fcf776af36ab27ffb3e5e4026000fb7e21b24b43d493862ef75d8e012af4b711942f558eddf87b94fc7918752a5189c107caef723d766d83213855c8dbde3d6671373b9b2a7d4cd5275206b22b4c81c07ae36aefc01bc32c844070180509b96346303c9ed03507062c6cdb5856de9e0d380d23e34d3b06f7049c2d588a6369ec8b1e4d33f3c6e9d42266bcc1374f0911faf9dab8a3e020b1805854d4b1216c474f8502d8e06d6e2617eb0bc94d2b62623ab35e64222d5c2958bf0b1cf294455fbe9138074b7230bef8ef5fa7ca863e21af7fcdabb2364856efcc9499d28c57233da7f0825753e008cfbfe6eb872dbbd0783d1c69ef54d7116a360227fef993f704e85448a2a300df966fcaf78fc6532d8b1bafb647238566f48f491608aa1c4a50c6d465cdc4b2ce36af08d11604f567cd98dd5935f8b13e6d5d261e4c9566ff867e1832d7eaf28dabb236d64c83b24a4b5a9375f0c60160a5280113d42f644d73b85671b55e4fe1832d25159c6cd0e6b02a0fbfbac717e3cd3d2bd0f5a57dfa3e0209b2558c332a098c0ce37e8efd8305c2dce65db698e0c04162fdd1f1fe795f3c91aecfb3f0e04b9a691719feaec28029ab58b418fe6f838997cdcee6ebfbc8b1b240b1a6efdc234a8f707e59c6cdb82f02d0e1cd82d364849af91b03b11c20ded518e90697be1108b4ca6d3972153000a79f2fcfa0d3306242a1d3e1e8801bcf9fc41a31186b400c9358cd2e6e39eb55d0237a6d525bc5388fdb236e159bb308a03a64663a2b3338920478ac810305a3099a37228058181cf6d019ca85f0a9299c09a3baf4d9d35963c64c658c9b13b52b689f300829f43b354f47417fc90c1f9671b54fcc962cc04ef013d92f8d377bb4360779603151f86fcaa8f1442bc46f038db9fed66e288f164c2f78c884dd937c467799e2814711b70ace3276d4bcb8819bd1418204e32103a4e73037f33fe96393d91b559c99c6d5e6ceb94ceb7974427a69b3efd1ef12d9a7c7880639e78f5307200b20fcb38daaf3dfe5816790710b777646dc16144d61530c9a38dd62a1d37e59bd119162f5d509fe8eb7d96259e8f800b3d9dd1a6a4849b7e436d978d4e46270dfa3e01ed448fb197f85e5f6c40673af0793ddc93fd23613e33ad9e7776a6ed1cd8897ec71f58ca0e6890ebd33e466e5a61a211cf6338dabcc723c114e2bfdbd28a22c0515976f0348567f8a08952488a881e15749a09c6468927221c2ac348b7c24f3e972016010cf8cad22412d1f540082c601b80bd6db5ab2e82522861836a4882c4203c41c8e3f0b626976dea688f43f7c98aa3d681a8ed8a0eabe58c0e6a8d3abbd71a965e6ecc35fa568fa76a96b308c18c16300df9349f681e25c211688ce13c4adc8e0e166cb44a03d7dc74254423a9acbf04da34caa17b8a1e7ffa67af05f1eea0418e191de688ee0daae1ab702fd6b87fec62aa28f31eef9d6b986fb766e159c6d53d434a39de896bc8df5e36803c1bafae0d0ff55dc8032a6b71babb149f692fb56796427dc0f6975a36631bba0b38636f4df0a6234d71aa5fc2409bea3b16fb369971b62dc5242a68b1806fb0106cd6c28ef31754109eaf48a07d613a3cc4dcd1bd9692c65cb612a299a09e57445e2fe7809d60bb98006c936b056ee736aea4b9e68b6c45852b715dee703d317d4d5a84317d42b4bf84e896cc145ce24198cfa9072899eb304c6d5e6d5d89a57c90a16eb1490002f95f13e2b9415ffbdbeb2dd189582a752d78c01687c8f2962aa6327dc1c3ad66217226cd47ae9ae2ebc4d7c31806ed6ffa4af8082c6022e6b0836bc3791b57646dc2b38dabcdabb236e159c6d5e6d5d91b70ace36af36aec8db85671b579b57646dc2b38daa60000feff70e0000002664fe83c86ed5aee5dd3cdfbc73afec4380d9a79d3dda12ec6465279452446e1cbc0a1ab1c5c820221889167863a97968b52a9d9a36d841ee88e602301a66ca791800726dece3eedb9bcfed0bdd8ed2376f1e922b555126cafd100a79b825ce0139ab4d99d88f3f5a07196a3c0d2fce114a9e71a61493c76cc8fcbec12282a6e4142fd53ab807afbd962ce58912e3de9663998d9a0e9449e53cdaa439e3c033a8f07714db3846da55ac1942868203ede9e4e61f3d6f049e8147fe0af82a54801b42843d9de472952d78003e948d062b153be56305179347a1d8b91e9ba12668feab24a4137a72968ffcb25ed305297c61b360c0d5ea0fb2623d1f33b9dd7eff2a3ba0cfda3f0fdbd4b5b7597b55ec3d3eba75e86bbab76c684e834d9019a662887c47b8c24cc648d3eda63a8638ec5c58d5bcd88742f85484bce8207185cce15cf4c13e1cb28ea5b6b20bb61437a2e5d6fa20d0f620f6ec4dd42e64ee2e3f9d798aa906d468d9d309f855f02106a0c4e1cda2b39517aeeaefe71dcd73435c4633c16c53c86823dc84b09be2e2bacafaec1df80cc7205e140fb78b543b4d063d3007dd62c939d9a5f69a21ac9c646a3a0c1e468b7a03d760516d1883120bd4ccca2c584f4ef30380b7e238fba291f9ec4932e9e5141c5a2881d4edae197872e6a78afef0ebc9f20c72a745476c0f62024e6b04745b13fa593044310014d8a308bc5e9b9cd8f0c4b8e629f61f51af18d31f0bcfcc53f844d00b61dd7ba3ff49b77d2c4845a8f22e29092ec304665af13c8d642b11bc86256b9a731d9c1cbf44c3da92bc377f7bb0c8c9ebb7866d3d307d7a492a4b230d79996c1862898501079fe742a6769aabe1d0c6ce8d764cda6e237d3c89764926bdbfbf8caf122ebe65209f1005f811a6e0cd1ddbf5ab4611ecd0ecf3e06066fd64b0a29106bb5ec6a076d6ef381810fd3ba281a6c710005296e056e39b26e30bfdf61e26618133083bcd5a7890c38c1e9cb48c24debdbdc9fe08b52d76c1ccbea6edf20e3ad1e58d5bc492985ffd2a54fc28cd97fa44d767ad5b13dd8c582c1ce88d1ca9fd7a38da493c20eb5faf4e483fb56a81470e04e7de691e958d2a9914d777ad9502c8dcb23b70e2dd0595a47d3e757f9a5fa6bf8d6362644f9a84c2306c775a7f2485791e18bf907dd3e201fede87fff9a4d173a270cd7bfb28d56cf6fa56c69bd37992e56d78d93f415b11b95c1fd00d8ce0dcc98905e3bcac1f632619b8b8463d107e4a7feb5200e47fc5cb990ed80f2ca6c8a36ae5105dd5a7d6c87865bc40868c00bf93c4afac908a317e6e5da99435be4ffb23105c18a78fb2350cfd31dd88a2f98eb007d090317201792a677fc45543d4471979f575e1496f458df673acecc9def7db85b5a8be2709d98df1abd68bb3edb73d8a5ab1b297b65d53341b36d0e8c110991b18571ef858e1008cf6889fcb13a7aefeb61b999f129acf59ace4435451449ca5db5b03a92a0580a1f10709cd41ff7314658fa72cf36c57bf83ce72eb652450958de7402f1823aab0e99883efa710ab9a9d73cbaf578b6f26010ca5bd5ccde74250c1a0c2c9046c738875f3262967ecbc2cf7d21145769d39051137d0ff61b44ee1b9ddb35826c3db0521a2d1532a21549c16f76c09368760826189214e67df0b96e396adc3eeca6cf128f54c98f2e48d0c4528b98231af1345a7176eb55a34a2fac3e177566e15c640389b2e1e6c7211df465aff45cb5035b5dcd08ba8bf543d4f002d885d4dd793365e967f3e93436a689cca1249b5b4b50826dc7ffce368a2d72e40f9160eff2016a77f54553c289f50024d9006b1ca8f9641eba245b1b8ac21eb89d285434deac7d729498e08a0cdc11dfe31dc179fe99c2c4f1b21dce1c32374c0340c395924ae5859993d0d2232da4a604840ef9df94affae6c9586e711e85e7b5630eff69239f07b7a6d5b2da24c5c14f2e579e37440ad91b9df309df71db37b1d964874023cc363b1a3f6595668a3ba196f8967693c42d84258c6f64746eda681c7b69086f6f584e38fd181fb4ead2dfacf4760e0ba6ad93783910f59af9fe5f282a8468de6f7b0d31385cd64d598dec8e60cd0b0917a10e4e3d97b20c0c3a91023b392ad2d73ceffdd1c6e2902fc5304d06ddac1595da2a1a17130433a7ad1504e8aa006dd7406804b972e63a372b1aed9178ca21f19ffebdbf8f7a9bf7845c475c53a2c56086f0011c852064715641a204a1ac24f58f11c798f87f873cd321a43dd6d72ab605856d42e298153def97b16fcf336e9d1a202a7eb3e17d5bd4fbc49dfbf10526f2d267980177b1a1b96ed2c20cafe13a07b276f8b34f6af5df243b992b1a9037dd5f1be3f5c9863b105cafb41e202fdfb67a8f020ed18bfde4387369138299018109a7d0cab86656b77d3e36a95d75fb77b749047a021ff4bc2f9cda16b0616c9d8a327c7c2d6d9f6e467b58bba6f32cbce1990e759cc846c06201ad7c2eea57ae6ba71fac62f7f8a4966580d2319ede3055db1a870edb374402741ed385b507115b1ab60c4e05f3fb0387b8a647fcc30866b3252ba43d5b28413aae16bfd58574ab0cf26904998568056d0c5c2b2866d4406c1230e8293d5b2ed7b94a506bb3713957c6aa3fd48618912240246afd30782a7d2e4f03a633b22596fde32f814923f7aec4b74b45775152a31bf9702754f01ae60125f444f24b1820dda27dd69b899a6e0dd8836eea242babf2727617e9f597c1c11e885c630de0e076acca6b7fc1f75ca3a4479982ca394e3dff107be4234e363f40fc5872595439ebe15bc72020b4488d02d850186b86b291c4d5c51462f1434a9a0397e0d4a7b6fa057ac94081465f2df9a07f15dc92961f3affd70ce5007a9ec5160249f16ca37a9dec04ca3f4412adc53503e181d9c558c09cb0c2a7aee4466f3938d256b9d2610071344fbaf63fff34d13f3d6b9072b685de75c9c3508ed10a01acf033c50b84c9b4aee54a199a5360c79dec1558d72bfdf87fa442697825b2ec27ac94c8aeefd3e8fc5605d0000f575639731b1d0e78c0524efc32e30ee0ed12c808d6c1954a8670b8e89a701dc8bdbcc8737ac73d9391ce7eb40ada1075b5c1ea54e1be41619133aac4056f536d0b5b0007369936a7d44432c9ce08f91a00267a54d74de08fd2da2d52399d1cf8b50869d7390be1c2671050dbd357cb35939b88ce9efd8edd138374cb8aacb66add6e79d7520b728f11d50d6d0d1b85eeeefb0a0dbfffcdbe21e056904a15b6c3ec65557f3ea96b8e7eb722363200ad18e7e15459dbfffb9a56c843ff40fd0e959427aaa624c81b7c08059a12a478449bbbfbe083616b255f9f0e3ff2a1cf13b5a91f560b097836c9a1f6d4badffb9c91375414a6bced4a5957a8dca4574d9da5a96f20ca9641f8da6a1321f5507de16ffe4147437320d03bc25cc1ddf7ae0b47f12f297a91a9d61208a0479705a866570a060f4def3d5a86c322c3b480b0ed9a805b7a1ed9773cd3c8aac21be2ae39d38698d6d97c499fa36b7eb5a67bda574524125014af85aafbd83b02b59f7130ed3d381cbaf89c593b1c123ba2ec0dfd988c0dbb2ae2008a211c20812afb2929ff540c016755b8696b9b09dc6a379a87e43652ba91b62359c3477d0f8e318ffcacad4b51ae5abd550728e9a2dfe5d4ec1737b9d42647ca098555d7a66bc69cab800e66a9c24ae2e7a3a4fba63de01ce812bcb563daee9e49e31fd3eb48b189fe2c03b4343e3a5a2618f15f1f9aa48bfd41940f7ee7e96a4fc909dd7c001dbc82bb3d0fb82cf0c24991de1fdd653cc665d93bf87a1625d9a1053c28949b65363826c1c252389a9068724b8ba1a711fbf23d6fb742db600bdfa83960d37df32e60933b5b05568d94bc79d7a7a7d6ed0805040bcff5fb8a147dc414f3dba1b0bcf776d90596ae9581e7b2eacb3e10a306147484c102fc8fed94a6a6ced6723a92c2841c066b8244385324b7fb28a4202520d9eddc35b37a5edf13056c04efea6946fc450ab0790fd087d4b8f1f2acba046cbd49fe2ac35603677caaf80f7f4ffaa6832e8a56adbc5330cea5b4540e58069ed10f9224f7728377cbd9be80d1158e00006110dadb5059baca900de156562b4f184962a0e9ebb0a776bfbc9478ac3708cb429d525723527af11372139f46df688142e938c426226c72c99cea38006194389e28a330b20ff7f93fa11c36b435068f07777c678b06f72be7538db0923b99541254a3e3ca598d9b9931ac0372ff93c856a8f669028a2d7e8f67641f800137f8d883fe142f75117d77b5616500e6f7dc6854398c8a3344cb8af122585cac08dd8e7d951d3000aa631e1f13f4500b8a537aef6ebac73c75f9ef72bf8008a561800c399138dd28ffd0d3a701aed7ec488fa835dab3f43268cfc3884fbf370f8acae19c6f199027e0027206b6ffde9498821b25ea4fc1e38a9f3cbabb1c1e769bc4486851b94aec5b13e1d5034595b4ee0a5d4e7a49b279fd045de4d04408fa332220e446a54e225c431bb77baa9c74ed83aebdcdf5a8ce098551d0325f6e815e53a2dc2ca7ee3706d5388c00fd2db554d19a4db0da9490d94df3c745623a92663068a65c71d763beb7ff39a00907227646d4999ae4c63b554e0cffd65928ab14f3921b0d77625c41aa203ac8ba1da7ec0b8005abf6a73aaa595e778ff72e99cf7e0f055e0ed255b2d4d960dde45b27323480c54b851b400ad1d2870c88f8d148558ec6545c978cb953c52313ce6e749802f4283f54c1fb7b24950e1bafddd0bc811e0a752902321034a2e49e2b58b1e5640873a159800d3b2a898780c6798ec5a9862253db0ef969a02f3534968b3fe0f7955586a0ba568080d16c0e9a4d259cc6b15239843015827bf4234d16d542cc3c4469cc2f6b667c1916d00bb67f1b0514a85e23e606a5a1cf4bb9bf7f194184dc3e2c1241110cf0449ea1bf024a462ba57d8703b073b2bfd552ac69d7bd0e990d6175c28bd13f895f634da8d0bbcfe28ec64d431cf434f8229e99b897ff7bafa33fd5f2195d9cfdb513c37f4d582367d30904ca7052f41aa671d856fc80661b8f58f93efcfe3817d69052679ce704be1dbd68a15aa08939c46fc94ab1b51007424e8dbc7f1aef9a7af0797c300f08805d1bc1c55bb8560a4264527ff68a0414140ba4ba0a1422a9da2618e80619de904da54198c03d54af3d900a4f8fc5280cfda5d7fa113f4420fc58dd0f8a04238bbcfed518638f3ef4090a3fc51a9b0da1848b0c74ec1323de111380542ba78d1d19c00c3d0d7938651fc18feb53a4f50c8555388c8a704dc52752df6ea585d53b59a2954d4611f5b81a30db83bc43b7449bf5a4afa5aba0c8f5677d1beb147571347852cf9b30a0db0e2dadf11993fc3904494ef84d5b5a1c443acb118577b3a1284f17a8670a560c2e0c11209aebe8f9050c4547119a3cb6ce10c16cb753125959416f8688e22a074f13162bdd191b450ec0c20711be16c1b8773c2e3ad73afc8cbd00edfe59d673308ec978fbf190d696580451320da04fafe33859c6991317252c05704fe51a09c4c81ff2bf8e0ff498ef2c052aa73c44d7312cd3e0fe7e8781ac52365b24a86366d417c8219c0738d150c636b984083201bfaa392f852a29a0231ebe0c4edd44de838ce3c2dd2609124147064c12af771d377466d911ad62d4a5a19551fc075c922c4ff90dc868b76dbe99fa0a2c975aed9af262071a81450516fe89cba8204c4ece19ce82f6ad99955df307415fe9e104a85158975a12cd4760e2155385f9ee8d84a4884edb94c23a97c8fcd115014d0a11c1e6f68bd11682bd215627f3f68a372c19df05286a2cdf26335e35e4e6fb5beb13dc9c5d4fb4174c56d46af366b05f4cdd9c9c62e8747b2250cfd485c4f84e96e284218b2df1edef0328210db0ee59db3f2077056f0a78b67f70403059ab86546524538bccb967f787e80947c835913ad9978887ef289e21221a07e3905f518186df8273eefd62ea353a063a19fea44453ff24ea563a5568ee7479d1312facd7cb07617a97596b0f58e8ec275b981f1e6e2baa66a9c9ad755794291f7b870c0bbb0503d36bb4276983b00f8d6001217ee7069e0e2e3870cfdc3d005249baef1ef0e132caee2546142f6ce77f77c674905cfe86d149acd6188fe79a45c73b826c1befe9caf032925b3cf59158e906a27f7165ed1f3fbf7a9532853e681e94da5a527bf0c1e3f8d06f6a7408a0c714df15926114eff818045398929de4c525890842212bee1365070653e3f4bb51e0a3fe5b06328a5f81536cbe73d2d5ee3e08efc5bb30fb686183031d20e3864ab6cd4562399c278fc3b56ee31e594aa7a759ee46f3ca50817327cb8c8c78011c980e16c268e55752401e68511418c50dbb585d134a8e33289e2aeb8d88dae026988f730cd93c6554ef993f8872578be7cc36ad7d23582d726d69b83df6f5e0ce8badbc3e3dfc27a92aafb254719e470e56d9c6e5abe0649a38b55da87a7518953e34ce8ab896bdb85f89db271e9b2917cb4f7673af83e69f9c8544f4c2c9d34c04bd6cc2a9b0355ef1dff7b4c85e1a7a7bb8f0ca9aa5b27afdc009d2caa9bba070893bd224bc1ce724e7a4ba17244bcaf2776432ac4f2f0856442686ee185662731906c8569e9b065745e3427a36c4526462f4bcf8a330c2c1da6296c8aa498168a409d7204989b3ba0afe3cb0eba80a9c62426abe02eed4a24a445272bb7dbc0cbd7fe972bf618e401e04e2dbe37e992e4e32a9084e72de7a32028bab15471f9f276d06aee8aa82914012311ca2eefc66f254bbc8298a05d0aa74a175b81d2edbb72e4dd1724a59328d8ac829b4c70505eaa5a6cdfd0fed50a765248c29fcfa73893add1d8a4b3006db22aeaadfcc5c491bf641030b15e2a49a9b517716068e3a4b6c25f8aca1398dd35baab625a33f5c34e6162cb5a0c3ac2f2e4a3ebe06a930ec42680265e3afaca2f7823e78c6992003783db7e659c3447b9bd5606802d3835bd987da6d92ce653638c27a2a132321dcd89e77e739027fe7dbbcef6b2be46d9f38b5a7cbd16292e6fee410f8a0d3cb43a949df1497ab1424ba3b4adc363c514cc434d73b99d7658219ba079c3dce90a6346901db70682ceed4ced237c555c8de15164dbe8461a7cc983d66d4a35c6493cd9c00acee0f1512bb711f243e5cc667b16cfd11f671e2678509c20d49ae00a021c56c203ae05a47f4a627520bf172a01f652de978ed1241e43685719a22d8262a0b52f5965fc58f178c891c5c593f88cd867a0c0283d4e60e9423bed671d7fd0ff18643fdb69a9a66236729e6dbdb54c154e53ca8238d42547e2a6ed57e68b3a35a0a1780986c000028a19f45871a36909fc0a2fcd596015cd1d67d40df30f3c868f6541518cb8675942b4bf8c8339497a73d348878ccf93967e5fe65bf61a3135980301d0145c233845f327ce754faf2270e2b0f03dce66c0a6a85c046d9ba21ca17616f8d69f075dc3e0661612faf645edd3043827a9e765f2fd0a766907da7900558a8bf09756971c85fa7c0ad3f4504473602d1c23fa60c837ea0d62145c2a89e575f1b660c6b73c98689bb8a9e214c5a860a33c1d49f1ac942cc1f7a9e4c1639a0e65a8f447efc2c85d4b976e767f3e66177903842d95c0ae28d176b69d0df26d816208af0a2cc6a1bdbfc8f23f63f3bf2a6643387c8115d90ee08b28702eae90f118e0249b6b4a4666d7ea23ed736d1342deefd7a51f193fbf524019af59d4b6fc5f6125a7a2fdb2cb60e1ae4c984c34e390c0e8cea0099aa36002214b686e0853e31be299f6f8dd8261bcd79bb79ef68449480ecc6fd73f2dad42420379d171eedb6bbd05e63982f47b92643f090b1d5adc9620611119254fe1b5f0ea96ae318949327cfaa1c79887ff94debec5f1dcd1888229e4672a50adb9d9818fca4ffa8030568cc3737e8415466919c0f6e27ba4994e77b6e764b0cac38e802df6831429db812f194110184d4ca66b65f6a5692a6e83d4de82cd1bfab630858807e8e988d24299ff35431135327e760469bbe08513a2558e826ed53dd5bafd3e64bcd24cc8de0d55f8752d19fbfcc519bc32196066e1afd8b4d1bc55e3fa4c03795696be2fc4da374884ab8aeed86a1b1dba40afa299100e58e4c966d6599b1404cc86886870d62d34c2660bff4bea36678a16a462c24f926d0467cd21aed5a79e5e11c36bf6efa77d220f5899c9ccf62b34b972cb689d415cfea6a6b4f4882bf200dbe3011dcab0ad24f7df81964d5198c2ff824840ebb2528854f7e2b7942d78aca4dfb9a99e53b00c327ecbe6164262aa2ccac94f22a5c70db5da528a7ca94e7e6a12c267141e3579e705e52d041eb5dfd5c787cde384d93155e63ec0acb778018aceccd37b95316a62f807d9a0baa55229b15f360adac0d43b5d98d70407d90e49eceb1ddd2efc505940cfb544226b9dba0a22e4c7fe395d73b6f64ab4292868a1c43057d6c336e030a464b02d8b5a4e0b252f8d3ae8c009c68baa3d1a5c508797f75e841f21706dffdc397a97c07f50b194c84b95baada0eba053dc711684f7c8304dc97edb8f8edd80d466c6d3ec82f63af3e906f01fabf5306e71b24903fcc1974a08758addc77602d787e1c43a8782d8808f6a62ad97e3d6fbeceb5fd0d91cfef92cc7c613bfc5f1ccef5827b8c7070240788ec16b3e24a376c2350ac899e9567ae9860f47166f086655b7062ffa5cf6939bc76c6a663b81167fe14a1c605d9f744d95edd25997c27237c5563be14701e9097b681cafb128791b66271f9163807282565585176e77c856f554523c627c7ba37417ad8cd1f17186b714a6dd4d6b5e9205d69e97a17254fa306308590a94dc447c928d1068c132cc7abdc1ba0980fc4072d3318d7dc6464503d04c81631f6d500316746eb57e70975e2e2bd37fedbadb4b49cceeb1ede4260e5920acb24cc18016ba18926f06a934e6bb756902cde241e04edbde382da57964461e1bb549cc8184ddde86e00ed6d678cae86f1c3f59f1e03dd2b4b3fbd89cc52c899a0bb7c464b5ca9820be027b6106906e1d6cf97099a8d7b043529ade1eb00c824052257805207a65806908d40810c701d2d04c66dc71ceb27a03a2d346038240ae34f00c46f3d26167daabe7e0ac6f1d892b6737c849058aba4459f31a8a2f8f6f47ee13eab466aa17c6f52bfc778e45b88307acfd881dd96d6d9cfc42f17e5d846f5cb35607f608ea07235c9a7b15f760f4036acb3825bd89ad22e5ff07b130db686834122e67ed5569d895ca4cf7928bac9e290cc70267b0bb7ee4f6ea546c8347d2b7564c012981c2ec0940f2577d8ffe3e84cfa04c29920b764514cb4a9910b71efce3c164b7c22d4f95ca99c4f2fc37d1e5927589a9a11d9dcd17b9e045582c4a84d1818e7c867c59d8a319f7c0de5cd998c6928a7748c81b1eb4d09df8269f3d0f2df84cb500728dbdbfd26425acc5c538b6921cf3e270b03408750404a25d8f2d626ea35e6f1e78c97f656797e6c23cad1cfcd4e7c08cfed57a01a0840fd37017c02267feee910a7cbdb6042dca427969ebd397fca6e86d1d6499e773279cf39d5dad20f6ecaf7bfaf80495f1fc71b5d5d1f464afa91863b1c691179bb6995ecfbd208f84e44aad5e79a9f5f3371fe7389e6d4f5672f322361691a71b5f9d6ea77ea7fd68085092b2ca2e29ab259c4e2d791dac6f37ed085efc4ba626a6b5fa5d52954944d7eee5f22e9f3a1b5917545046c46091ca1f0efe87b45187628a446078a7c2be7d3a572419c1de932be43db951d2b8a1b6eedb830df9d6fbc944fca7833a67d9787726fea1914eb1d8676de6897e3e172d171d333f22135aa6817bd8324555522b34a13ce5a73bc963827ff2b60b909d52987d3a35c2e80babf7b64629cdfa65a99ee9a78780b461132180ad6d65ddb170c6ea752e091466c3a72834aeca7dcb50080f8bc33a0fbb3509f19ad060bf0596d7f63943c2f4453d2e27752fab946fc8a68951fdca9a0a2887116a5f89bc0f444f6fa6f614026e01810026282c06d258d392c1fb0921f371b9b211c7bc0427bb408513d83eb1b5486adf777453e11703af8dacc4030bd43885a4c649617bbf0c7a962db81848ece740b60d4b00314d82c2d3773e2119420f3182471c98f796cfe8792764148241106041080b085cb80054e035f9a4620844424b8c23d63ec12b6aae95101f7f16e33e3eb14385895d445ba50338ce24d805ec419f1b973b9ee816658a90e4d6897945712a960367f8aaa479e8dac59e552b1f24b54c8eeda46359cdea09751ebbbbf7d2b3d9ebbdfeef955c264c1afde2fe211b4bdaf8cf9871a1b86472d79e86ff207f8fbf06e9601e5cc4e0829915b3f8829d98ede77aea14ca5d11309a73cc032b7acf1688e2414f3c5637d02c12d0cd2e121e8f3fe88f9005ddb643a71ef0fd7b3566ceeccb4e3e7398809bb4b3110c1d349a2e233f4b5a6b9747d0cc54176a293f4c124797198a79d5836efc9c94eaa602dc39a2f6c7280924df73374185156496f9b47f5d4c33339b14cf3ab562bb74e62418eea3384bc4bf2c2712c02529c4752345b4497f425f1dc4f9932d146664be597ec594be2ee1abdbcb056b559dd9d042042eb01e82f24fe2535b2d650c3e87b02dbe06060365d89149037d94577b49cdfa56d2a35697aa68935c5c09d5052aaa3443b396e4b5625908a788e27b5a2e144cecba7cfe874c5155a0994648ad76515e1d72f6d59bf2cbd2f5e9d4a7dcb3ad4c9eef0d8484603a8ede3c38317bbf4ffbc54ced19438005d031cbc7323825d6b2cdba5203a54fd6d1aa8cb477144d592def26affbefdc3b646dca54ba021ddf786a0599d1fb6f5d857bbf3e63353004efab6557647ace758732b7d07bd787ed9c44da71cc8fe961dd2a1af96b69795b4527dc31152b181f527043d2ea916ef2d71cc0169d338c8af5523274d61d272d79fd9aa79f1730688abd905144938fb6011ff064ee717353bd3d6c3155d68219d40be1a41fb30f7c0dbf62a7ab5a8735e28ec838780d8e2d5b62f0d20b24a6ace3c8fd1dbcb362d48a808c910be70bc029d2e390446fe1b982ae8d1c67511bf734be52fe06edb283702e1adf9936c5eed7427c23a8feeb9d6b220ac9444bec3433a3af86726b69564f10488834368106bd11c916b77a77d79707b95351dd2547c84f250e8af707a5ddce446e77bcc13977078da2bdf0cd0a6f46cd1b02b12f3d75c02b94572061ab581eba53189a98c80752b246326b3a2a30a5c9c7650a7ef014702eee576c80724c7c92c4bdbf6c777b63e063ea6c4ad09be282ef2d22ef3711adf7a0b41ef70253f119773f82abc50fd4cdd96c5fa8f3f7223cb1d0a9599561f5ef84618b3a6e51f9e84fc5addb3629cf87e2baf6ae38503fa34121c6c347ddfae725ee0da97c16860414f966b374c226c4f790d34af81b30f1691848e45f47168955c8ea70385d8ca5e08a0bd64907c39b59df40efc824093bd9571b2eb9f010ff7307e7974a559e06e9f3efeaad5be95b9869d2162732b1e99e1cc79d895f8d0bb44d7f2dcacb9fd9a983c110bc05c8fc5de43eed10eba31b9abe36c44c83d69a6ae73dced1d6a75e560c5c7f291fc3e117243d599b7a76b3e1ff7d9e229fa235bce049a59d9664a78dbabef776ec91f11be6a0ebea6da0827c65872845ec9a004b3654119bb9365ec0bef8cdbfde62df6bb89a1c2fde2d548e65a41e0a163509d636bc60b0783012caf4dbc83e744329eb82bb552d2b4cac28ccf8cbcb5aa8ec77e36302ae6fc945e44963ffc132e9d8d670a81afbfea45145c415ee0ca77f0593944c9b63b8f54b6d576e55d8df6da25e6f9596f661c885ad2d09c19cddc3008cbbbd34c4e86ee3f2cf3eeaf455225509d83f321319bc3e499257f714a07b17d7e96f57bae46e3fd28b3d1a2d94993f9355db6ac8837e13f5977232818f569d9fbba13c3b0801ece711776e6c02c2a4ae7e09c5de669cc5c5228a6224b51331395acf22e0fee81d0e71ab6bf0c74f85c2bc25b8f0db8d52fcef1969703db7aa09d1e5c59c7f108bb41273a6ebac000000052f15a41d92bf63eecbed74142b87dd174349da0c8481cc28175e852769697818bbf002dbe3b8dfe160214b7400000000000000000000000, 0);

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
(1, 'come1', 'Mesa nordica escandinava', 'Madera', 'Blanco', 'Alto: 77cm,ancho: 60cm', 'Stockhoy', 3, '6999', 1, 5, 0),
(2, 'come2', 'Mesa comedor escandinava nordica', 'Madera', 'Blanco', 'Alto: 90cm,ancho: 85cm', 'Nordico muebles', 30, '9698', 1, 5, 3),
(3, 'come3', 'Mesa comedor eco laqueada extensible', 'Madera', 'Blanco', 'Alto: 80cm,ancho: 85cm', 'Living style', 20, '12169', 1, 5, 0),
(5, 'come5', 'Mesa nordica escandinava comedor', 'Madera', 'Negro', 'Alto: 77cm,ancho: 70cm', 'Stockhoy', 4, '8999', 1, 5, 0),
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
(74, 'dome7', 'Mesa De Luz En Dos Tonos Con Estantes Y Cajón Deca', 'Pino', 'Blanco', 'Alto: 45cm,ancho: 50cm,profundidad: 55cm', 'Básquet shop', 22, '5555', 2, 7, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategoria`
--

CREATE TABLE `subcategoria` (
  `id_subcategoria` int(100) NOT NULL,
  `nombre_subcategoria` varchar(100) NOT NULL,
  `id_categoria` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `subcategoria`
--

INSERT INTO `subcategoria` (`id_subcategoria`, `nombre_subcategoria`, `id_categoria`) VALUES
(1, 'Bibliotecas', 4),
(2, 'Camas', 2),
(3, 'Colchones', 2),
(4, 'Futones', 3),
(5, 'Mesas', 1),
(6, 'Mesas de escritorio', 4),
(7, 'Mesas de luz', 2),
(8, 'Modulares', 1),
(9, 'Placares', 2),
(10, 'Sillas', 1),
(11, 'Sillas de oficina', 4),
(12, 'Sillones', 3);

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
  `direccion` varchar(30) NOT NULL,
  `suscripcion` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombreUsuario`, `contrasena`, `perfil`, `nroDni`, `nombre`, `apellido`, `email`, `provincia`, `ciudad`, `direccion`, `suscripcion`) VALUES
(1, 'caelenaShar', '0e5cd0a77778f353ca0863d3ca43f35e4f71d74c33e6524383e75349c6f42ac1ac0e7de58a0438a42891d9a497f62454b7bdaf8a93286f64314a433b7e4b7f3f', 'U', '41689734', 'caelena', 'shar', 'caeShar@hotmail.com', 'buenos aires', 'bahia blanca', 'avenida alem', 0),
(2, 'AnaLopez', 'e686859d8a43300614ee7767fc287d6d227cb16cd1204f11150f8207302edeb7e15883561621a13a9c54e63a913528a8ec759eb00fb8cfd445e8cbc66b32edf4', 'E', '12345678', 'Ana', 'Lopez', 'analopez@hotmail.com', 'Buenos Aires', 'Bahia Blanca', 'Calle 1', 0),
(3, 'RomanRiquelme', '3bd0ec7e54237c798afb6ede6ebc0feaadce5ab191d7d2f6310ad92072f332251aa7e66af79ee9e8f77e62ef2df0dde0e8872ca92e2d4a57adc334c6f8f830b9', 'U', '12345678', 'Roman', 'Riquelme', 'romanriquelme@hotmail.com', 'Neuquén', 'Aguada San Roque', 'Av. Independencia 6 , 5H', 0),
(4, 'ChinaSuarez', 'ab4a301aa40357605ddce7b47ed7bcba32206defa7e8a6638528cecf7c4f2a8991fc51fa459e2d328c54af0051161557f280d9e8175606ee7b53da9a53de6866', 'E', '12345678', 'China', 'Suarez', 'chinasuarez@hotmail.com', 'Buenos Aires', 'Olavarria', 'Calle 3', 0),
(5, 'DavidBen', 'e686859d8a43300614ee7767fc287d6d227cb16cd1204f11150f8207302edeb7e15883561621a13a9c54e63a913528a8ec759eb00fb8cfd445e8cbc66b32edf4', 'U', '40978231', 'David', 'Benedette', 'davidbenedette@hotmail.com', 'Misiones', 'Colonia Polana', 'Av. Libertador 760 , 14A', 0),
(6, 'VickyArenzo', 'e686859d8a43300614ee7767fc287d6d227cb16cd1204f11150f8207302edeb7e15883561621a13a9c54e63a913528a8ec759eb00fb8cfd445e8cbc66b32edf4', 'U', '42391952', 'victoria', 'arenzo', 'vicky.16@hotmail.com.ar', 'Buenos Aires', 'Bahía Blanca', 'Berutti 47 , 14', 0),
(7, 'DavidBenedette', '', 'U', '41412412', 'David', 'Benedette', 'davidbenedette@gmail.com', 'San Luis', 'Fraga', '', 0),
(8, 'Davi', '', 'U', '40978231', 'Ladislao', 'Benedette', '', 'Mendoza', 'Capital', '9 de Julio 33 , 4H', 0);

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
(5, 7, '100332424155947279275', 'Google'),
(6, 8, '318788939', 'Twitter');

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
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imagen_ibkf_1` (`id_producto`);

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
  MODIFY `id_categoria` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `favorito`
--
ALTER TABLE `favorito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  MODIFY `id_subcategoria` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario_rs`
--
ALTER TABLE `usuario_rs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Filtros para la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD CONSTRAINT `imagen_ibkf_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
