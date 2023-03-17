-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-03-2023 a las 01:39:22
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbpolaris`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones`
--

CREATE TABLE `acciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `acciones`
--

INSERT INTO `acciones` (`id`, `nombre`) VALUES
(1, 'Iniciar sesiòn'),
(2, 'Cerrar sesiòn'),
(3, 'Registrar Nuevo Usuario'),
(4, 'Editar perfil Usuario'),
(5, 'Eliminar Usuario'),
(6, 'Modificar Usuario'),
(7, 'Gestionar Configuracion Sistema'),
(8, 'Backup Completo BD Full'),
(9, 'Anular ventas'),
(11, 'Actualizar Catalogo'),
(12, 'Limpiar Truncate BaseDatos'),
(13, 'Registrar Compras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agenda_cobranzas_clientes`
--

CREATE TABLE `agenda_cobranzas_clientes` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `direccion_cobranza` varchar(150) NOT NULL,
  `telefono_cobranza` varchar(45) NOT NULL,
  `zona` varchar(25) NOT NULL,
  `hora_estimada` varchar(25) NOT NULL,
  `garante_1` varchar(150) NOT NULL,
  `ci_1` varchar(50) NOT NULL,
  `direccion_1` varchar(200) NOT NULL,
  `telefono_1` varchar(50) NOT NULL,
  `garante_2` varchar(150) NOT NULL,
  `ci_2` varchar(50) NOT NULL,
  `direccion_2` varchar(200) NOT NULL,
  `telefono_2` varchar(50) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `titulo` varchar(250) NOT NULL,
  `subtitulo` varchar(50) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `banners`
--

INSERT INTO `banners` (`id`, `titulo`, `subtitulo`, `imagen`, `descripcion`) VALUES
(1, 'Publicite AQUI, Tus datos', 'Pulicita y promocionate', '8b1b4-admin_inventarios.png', '<p>\r\n	Emplearemos los datos indicados con anterioridad para el env&iacute;o de nuestras newsletters, SMS y para nuestras campa&ntilde;as de redes sociales, podr&aacute;s anular tu suscripci&oacute;n en cualquier momento.</p>\r\n'),
(2, 'Polaris APK , PUBLICIDAD ESPECIAL', 'Unete', '1edbf-admin_estilo.png', '<p>\r\n	Las tiendas Polaris APK somos l&iacute;deres en inform&aacute;tica, electr&oacute;nica, electrodom&eacute;sticos y otros complementos para el entretenimiento, siempre con las mejores marcas al mejor precio.</p>\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id` int(11) NOT NULL,
  `id_accion` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(20) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id`, `id_accion`, `fecha`, `ip`, `id_usuario`, `data`) VALUES
(24, 1, '2023-03-16 23:51:13', '127.0.0.1', 6, ''),
(25, 15, '2023-03-17 00:18:56', '127.0.0.1', 6, '16'),
(26, 15, '2023-03-17 00:18:58', '127.0.0.1', 6, '18'),
(27, 15, '2023-03-17 00:19:02', '127.0.0.1', 6, '14'),
(28, 15, '2023-03-17 00:19:07', '127.0.0.1', 6, '17'),
(29, 15, '2023-03-17 00:19:10', '127.0.0.1', 6, '15'),
(30, 5, '2023-03-17 00:28:24', '127.0.0.1', 6, '20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `captcha`
--

CREATE TABLE `captcha` (
  `captcha_id` bigint(13) UNSIGNED NOT NULL,
  `captcha_time` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `word` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `captcha`
--

INSERT INTO `captcha` (`captcha_id`, `captcha_time`, `ip_address`, `word`) VALUES
(357, 1679010328, '127.0.0.1', 'CAq7p'),
(358, 1679010336, '127.0.0.1', 'nLUqt'),
(359, 1679010337, '127.0.0.1', 'tzL9Y'),
(360, 1679010422, '127.0.0.1', 'yoXBk'),
(361, 1679010423, '127.0.0.1', 'xUjJK'),
(362, 1679010458, '127.0.0.1', 'Sbi4G'),
(363, 1679010478, '127.0.0.1', 'rlDnA'),
(364, 1679010530, '127.0.0.1', 'ds6O9'),
(365, 1679010531, '127.0.0.1', 'ztryG'),
(366, 1679010531, '127.0.0.1', '1JR6J'),
(367, 1679010624, '127.0.0.1', 'mOVt7'),
(368, 1679010628, '127.0.0.1', '0omOM'),
(369, 1679010628, '127.0.0.1', 'yeEg1'),
(370, 1679010628, '127.0.0.1', 'ovjBf'),
(371, 1679010641, '127.0.0.1', '7IU5U'),
(372, 1679010818, '127.0.0.1', 'ECKUr'),
(373, 1679010971, '127.0.0.1', 'OvGnF'),
(374, 1679010986, '127.0.0.1', 'RKbJQ'),
(375, 1679011073, '127.0.0.1', 'IKnlM'),
(376, 1679011352, '127.0.0.1', 'eo4d9'),
(377, 1679011369, '127.0.0.1', 'dZVu1'),
(378, 1679011746, '127.0.0.1', 'JiHt1'),
(379, 1679011847, '127.0.0.1', 'QzwSa'),
(380, 1679011923, '127.0.0.1', 'QLwvn'),
(381, 1679012070, '127.0.0.1', '7lFjo'),
(382, 1679012169, '127.0.0.1', 'sg822'),
(383, 1679012179, '127.0.0.1', 'g2vN1'),
(384, 1679012206, '127.0.0.1', '7AB0g'),
(385, 1679012208, '127.0.0.1', 'nT7A5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `tipo` enum('Activo','Inactivo') DEFAULT NULL,
  `id_parent` int(11) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `tipo`, `id_parent`, `visible`) VALUES
(47, 'ELECTRONICOS', '<p>\r\n	ELECTRONICOSELECTRONICOSELECTRONICOSELECTRONICOS</p>\r\n', 'Activo', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_productos`
--

CREATE TABLE `categoria_productos` (
  `id_producto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria_productos`
--

INSERT INTO `categoria_productos` (`id_producto`, `id_categoria`) VALUES
(178, 47),
(179, 47);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED DEFAULT '0',
  `data` blob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `sexo` enum('Hombre','Mujer') NOT NULL,
  `ci` varchar(11) NOT NULL,
  `nit` varchar(11) DEFAULT NULL,
  `procedencia` varchar(15) DEFAULT NULL,
  `direccion` varchar(500) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fotografia` varchar(125) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `facebook` varchar(50) DEFAULT NULL,
  `dir_trabajo` varchar(50) DEFAULT NULL,
  `oficio` varchar(50) DEFAULT NULL,
  `referencia` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `id_proveedor` varchar(250) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `tipo` enum('CONTADO','CREDITO') NOT NULL,
  `estado` enum('Finalizado','Pendiente') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `monto` double NOT NULL,
  `nota` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(125) NOT NULL,
  `resenia` varchar(150) NOT NULL,
  `lema` varchar(140) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre`, `resenia`, `lema`) VALUES
(1, 'Polaris', 'Sistema catalogo de Ventas WEB', 'Sistema CVOFF');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consignaciones`
--

CREATE TABLE `consignaciones` (
  `id` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` double NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `precio_venta` double NOT NULL,
  `cantidad_vendida` int(11) NOT NULL,
  `anotacion` varchar(250) DEFAULT NULL,
  `fecha_entrega` date NOT NULL,
  `fecha_devolucion` date NOT NULL,
  `total` double NOT NULL,
  `estado` enum('Entregado','Finalizado') DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `empresa` varchar(150) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `mensaje` text NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `respuesta` text,
  `fecha_respuesta` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cotizaciones`
--

INSERT INTO `cotizaciones` (`id`, `nombre`, `empresa`, `direccion`, `email`, `telefono`, `mensaje`, `estado`, `fecha`, `respuesta`, `fecha_respuesta`) VALUES
(1, 'dsd', 'sdssds', 'sdsds', 'ddsd@dsd.cx', 'sds', 'sdsdsdsds', 2, '2019-04-08 02:07:45', 'se envio su solicitud, por favor visite este enlace', '2019-09-01 18:01:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_cliente`
--

CREATE TABLE `cuenta_cliente` (
  `id` int(11) NOT NULL,
  `monto_credito_maximo` double NOT NULL,
  `deuda` double NOT NULL,
  `saldo` double NOT NULL,
  `estado` varchar(1) NOT NULL,
  `tipo` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_cobrador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas`
--

CREATE TABLE `cuotas` (
  `id_plan_pago` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `fecha_pago` date NOT NULL,
  `monto_cuota` double NOT NULL,
  `monto_pagado` double NOT NULL,
  `fecha_pagada` date NOT NULL,
  `estado` varchar(1) NOT NULL,
  `id_cobrador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destacados`
--

CREATE TABLE `destacados` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nota` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `destacados`
--

INSERT INTO `destacados` (`id`, `id_producto`, `nota`) VALUES
(1, 3, 'Hermoso colchon de 2 plaza, ideal para habitaciones grandes'),
(2, 8, 'Este Sofa puede convertirse en una comoda cama'),
(3, 7, 'Somier estilo moderno para ccolchones de 1 plaza y media'),
(4, 1, 'Para una habitacion minimalista una comodo colchon de 1 plaza');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispositivos`
--

CREATE TABLE `dispositivos` (
  `id` int(11) NOT NULL,
  `keyAPK` varchar(25) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario` int(11) NOT NULL,
  `estado` enum('Habilitado','Inactivo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dispositivos`
--

INSERT INTO `dispositivos` (`id`, `keyAPK`, `fecha_registro`, `id_usuario`, `estado`) VALUES
(2, 'e41bb1ad47830d1e', '2018-08-16 14:55:57', 6, 'Habilitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `id` int(11) NOT NULL,
  `detalle` varchar(350) NOT NULL,
  `monto` double NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_persona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `gastos`
--

INSERT INTO `gastos` (`id`, `detalle`, `monto`, `fecha`, `id_persona`) VALUES
(1, 'material de oficina', 45, '0000-00-00 00:00:00', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id` int(11) NOT NULL,
  `imagen` varchar(250) CHARACTER SET utf8 NOT NULL,
  `id_producto` int(11) NOT NULL,
  `orden` int(11) DEFAULT NULL,
  `descripcion` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`id`, `imagen`, `id_producto`, `orden`, `descripcion`) VALUES
(588, '6b1341.png', 178, NULL, NULL),
(589, 'e00d33.jpg', 178, NULL, NULL),
(590, '1597a9.jpg', 179, NULL, NULL),
(591, 'a6b918.JPG', 179, NULL, NULL),
(592, '2b617b.JPG', 179, NULL, NULL),
(593, '8edd03.jpg', 179, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventarios`
--

CREATE TABLE `inventarios` (
  `id_producto` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` enum('Habilitado','Deshabilitado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `inventarios`
--

INSERT INTO `inventarios` (`id_producto`, `id_sucursal`, `cantidad`, `estado`) VALUES
(178, 9, 890, 'Habilitado'),
(179, 9, 1800, 'Habilitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `mensaje` varchar(500) NOT NULL,
  `id_remitente` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `estado` enum('leido','pendiente') NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `mensaje` varchar(500) NOT NULL,
  `tipo` enum('Informativo','Advertencia','Mensaje','Critico') NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('Activo','Inactivo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `title`, `mensaje`, `tipo`, `fecha`, `estado`) VALUES
(31, 'Inventario', 'No Existe stock para el producto Id:170', 'Critico', '2019-04-04 18:34:28', 'Inactivo'),
(32, 'Inventario', 'No Existe stock para el producto Id:170', 'Critico', '2019-04-04 18:39:55', 'Inactivo'),
(33, 'Inventario', 'No Existe stock para el producto Id:170', 'Critico', '2019-04-04 18:40:55', 'Inactivo'),
(34, 'Inventario', 'No Existe stock para el producto Id:170', 'Critico', '2019-04-04 18:41:38', 'Inactivo'),
(35, 'Inventario', 'No Existe stock para el producto Id:170', 'Critico', '2019-04-04 18:42:45', 'Inactivo'),
(36, 'Inventario', 'No Existe stock para el producto Id:168', 'Critico', '2019-04-04 18:43:34', 'Inactivo'),
(37, 'Inventario', 'No Existe stock para el producto Id:168', 'Critico', '2019-04-04 18:44:03', 'Inactivo'),
(38, 'Inventario', 'No Existe stock para el producto Id:170', 'Critico', '2019-04-04 18:45:48', 'Inactivo'),
(39, 'Inventario', 'No Existe stock para el producto Id:170', 'Critico', '2019-04-04 18:47:18', 'Inactivo'),
(40, 'Inventario', 'Stock minimo en el producto Id:170', 'Advertencia', '2019-04-04 18:49:22', 'Inactivo'),
(41, 'Inventario', 'No Existe stock para el producto Id:168', 'Critico', '2019-09-01 20:33:04', 'Inactivo'),
(42, 'Inventario', 'No Existe stock para el producto Id:168', 'Critico', '2019-09-01 20:33:15', 'Inactivo'),
(43, 'Inventario', 'Stock minimo en el producto Id:170', 'Advertencia', '2019-09-01 20:33:31', 'Inactivo'),
(44, 'Inventario', 'Stock minimo en el producto Id:170', 'Advertencia', '2019-09-01 20:46:02', 'Inactivo'),
(45, 'Inventario', 'Stock minimo en el producto Id:170', 'Advertencia', '2019-09-01 20:46:46', 'Inactivo'),
(46, 'Consignacion.- Devolver Productos', 'La consignacion del cliente[51] ha devuelto 5 deberan ser devueltas al origen de la sucursal', 'Informativo', '2019-09-04 13:52:22', 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `monto` double NOT NULL,
  `tipo` int(11) NOT NULL,
  `nota` varchar(125) NOT NULL,
  `id_cobrador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos_cuotas`
--

CREATE TABLE `pagos_cuotas` (
  `id_pago` int(11) NOT NULL,
  `id_plan_pago` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `monto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pagos_cuotas`
--

INSERT INTO `pagos_cuotas` (`id_pago`, `id_plan_pago`, `numero`, `monto`) VALUES
(1, 5, 1, 66);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `anotacion` varchar(250) DEFAULT NULL,
  `fecha_entrega` date NOT NULL,
  `fecha_entregado` date NOT NULL,
  `total` double NOT NULL,
  `estado` enum('Pendiente','Entregado','Cancelado','Finalizado') NOT NULL,
  `descontar_stock` tinyint(4) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_zonas`
--

CREATE TABLE `personal_zonas` (
  `id_persona` int(11) NOT NULL,
  `id_zona` int(11) NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` enum('Hombre','Mujer') DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `telefono` varchar(25) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `facebook` varchar(150) DEFAULT NULL,
  `ocupacion` varchar(150) DEFAULT NULL,
  `fotografia` varchar(125) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `id_sucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `nombre`, `apellidos`, `fecha_nacimiento`, `sexo`, `direccion`, `telefono`, `email`, `facebook`, `ocupacion`, `fotografia`, `estado`, `id_sucursal`) VALUES
(19, 'personal', 'PRUEBA', '1993-07-18', 'Mujer', 'B/Roca y Coronado', NULL, NULL, NULL, 'VENDEDOR', '9855e-5.png', 'Activo', 0),
(20, 'vendedor', 'vendedor', '2023-03-11', 'Hombre', 'vendedor 2', 'vendedor 2', 'vendedor 2@vendedor 2.COM', NULL, 'VENDEDOR', 'c4ed0-c123a-4.png', 'Activo', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_pagos`
--

CREATE TABLE `plan_pagos` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `monto_total` double NOT NULL,
  `deuda_anterior` double NOT NULL,
  `monto_inicial` double NOT NULL,
  `nro_cuotas` int(11) NOT NULL,
  `tipo_periodico` int(11) NOT NULL,
  `monto_cuotas` double NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` varchar(1) NOT NULL,
  `nota` varchar(350) NOT NULL,
  `id_plan_anterior` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios`
--

CREATE TABLE `precios` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `precio` double NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(1) NOT NULL,
  `precio_mayor` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `subtitulo` varchar(150) DEFAULT NULL,
  `descripcion` text NOT NULL,
  `especificaciones` text,
  `precio_base` double NOT NULL,
  `medida` varchar(50) DEFAULT NULL,
  `unidad_mayor` enum('Unidad','Docena','Cuarta') NOT NULL DEFAULT 'Unidad',
  `precio_mayor` double NOT NULL,
  `stock_minimo` int(11) DEFAULT NULL,
  `activo` enum('Habilitado','Deshabilitado') NOT NULL DEFAULT 'Habilitado',
  `tipo` enum('Insumo','Producto','Mercaderia','') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `nombre`, `titulo`, `subtitulo`, `descripcion`, `especificaciones`, `precio_base`, `medida`, `unidad_mayor`, `precio_mayor`, `stock_minimo`, `activo`, `tipo`) VALUES
(178, 'PROD-01', 'PRODUCTO 1', 'PRODUCTO 1', 'PRODUCTO 1', '<p>\r\n	PRODUCTO 1 PRODUCTO 1PRODUCTO 1PRODUCTO 1PRODUCTO 1PRODUCTO 1PRODUCTO 1PRODUCTO 1</p>\r\n', NULL, 50, NULL, 'Docena', 500, 45, 'Habilitado', 'Producto'),
(179, 'PROD02', 'PRODUCTO 2', 'PRODUCTO 2', 'PRODUCTO 2', '<p>\r\n	PRODUCTO 2PRODUCTO 2PRODUCTO 2</p>\r\n', '<p>\r\n	PRODUCTO 2PRODUCTO 2PRODUCTO 2</p>\r\n', 458, 'UNIDAD', 'Cuarta', 1200, 15, 'Habilitado', 'Mercaderia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_cotizados`
--

CREATE TABLE `productos_cotizados` (
  `id_cotizacion` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `precio` double NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos_cotizados`
--

INSERT INTO `productos_cotizados` (`id_cotizacion`, `id_producto`, `precio`, `cantidad`) VALUES
(0, 2, 0, 1),
(0, 4, 0, 1),
(1, 1, 0, 7),
(2, 1, 0, 7),
(3, 1, 70, 7),
(4, 1, 70, 7),
(4, 2, 10, 1),
(4, 4, 10, 1),
(5, 1, 0, 7),
(5, 2, 0, 1),
(5, 4, 0, 1),
(6, 100, 10, 1),
(6, 101, 15, 1),
(6, 102, 20, 1),
(6, 104, 10, 1),
(6, 119, 330, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `empresa` varchar(150) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `fotografia` varchar(100) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `direccion_alternativa` varchar(150) NOT NULL,
  `comentarios` varchar(250) NOT NULL,
  `nit_rfc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `empresa`, `nombre`, `email`, `telefono`, `fotografia`, `direccion`, `direccion_alternativa`, `comentarios`, `nit_rfc`) VALUES
(1, 'AMERICA', 'Sr, vendeor de america', '', '3576845', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prueba`
--

CREATE TABLE `prueba` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `prueba`
--

INSERT INTO `prueba` (`id`, `nombre`) VALUES
(1, 'fdsfsdfd'),
(2, 'fadsfdsfasd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reposiciones`
--

CREATE TABLE `reposiciones` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_sucursal_destino` int(11) NOT NULL,
  `id_sucursal_origen` int(11) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nota` varchar(250) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `reposiciones`
--

INSERT INTO `reposiciones` (`id`, `id_producto`, `cantidad`, `id_sucursal_destino`, `id_sucursal_origen`, `tipo`, `id_usuario`, `nota`, `fecha`) VALUES
(1, 178, 890, 9, 9, 1, 6, '', '2023-03-17 00:25:37'),
(2, 179, 1800, 9, 9, 1, 6, '', '2023-03-17 00:25:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revision_inventario`
--

CREATE TABLE `revision_inventario` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `descripcion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revision_inventario_producto`
--

CREATE TABLE `revision_inventario_producto` (
  `id_inventario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `observacion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `enlace` varchar(250) NOT NULL,
  `modulo` varchar(150) NOT NULL,
  `active` varchar(1) DEFAULT NULL,
  `icono` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `enlace`, `modulo`, `active`, `icono`) VALUES
(1, 'Administrar Mensaje de Bienvenida', 'admin/mensajes', '3', '0', 'admin_mensajes.png'),
(2, 'Seleccionar Productos Destacados', 'admin/destacados', '3', '0', 'admin_destacados.png'),
(3, 'Administrar Diapositivas', 'admin/diapositivas', '3', '0', 'admin_diapositivas.png'),
(4, 'Banner  publicitarios', 'admin/categorias_banners', '3', '0', 'admin_banner.png'),
(5, 'Ver Informacion de la WEB', 'admin/informacion', '3', '1', 'admin_informacion.png'),
(6, 'Administrar Sucursales', 'admin/sucursales', '1', '0', 'admin_sucursales'),
(7, 'Administrar Usuarios', 'admin/usuarios', '2', '0', 'admin_usuarios.png'),
(8, 'Bitacora', 'admin/bitacora', '2', '0', 'admin_bitacora.png'),
(9, 'Crear Backup Base de Datos', 'admin/backup', '2', '1', 'admin_backup.png'),
(10, 'Administrar Productos', 'admin/productos', '1', '0', 'admin_productos.png'),
(12, 'Administrar Categorias de los Productos', 'admin/categorias', '1', '0', 'admin_categorias.png'),
(13, 'Descargar Catalogo  de Productos PDF', 'admin/catalogo_pdf', '3', '0', 'admin_catalogo_pdf.png'),
(15, 'INVENTARIO', 'admin/inventario_productos', '7', '0', 'admin_inventarios.png'),
(16, 'Ventas al contado', 'ventas/ventas_contado', '5', '0', 'admin_ventas.png'),
(17, 'Ventas Suspendidas', 'ventas/ventas_suspendidas', '5', '0', 'admin_ventas_administrador.png'),
(18, 'Ventas Credito', 'ventas/ventas_credito', '5', '0', 'admin_ventas_credito.png'),
(19, 'Ventas Credito Administrador', 'ventas/ventas_credito_admin', '5', '0', 'admin_ventas_credito_administrador.png'),
(20, 'Configuracion sistema', 'admin/settings', '2', '0', 'admin_settings.png'),
(21, 'Administrar Dispositivos', 'admin/dispositivos', '2', '0', 'admin_dispositivos.png'),
(22, 'Administrar Clientes', 'admin/clientes', '5', '0', 'admin_clientes.png'),
(23, 'Administrar Personal', 'admin/personal', '1', '0', 'admin_personas.png'),
(24, 'Reportes Ventas', 'reportes/ventas', '8', '0', 'reportes_ventas.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `validar_stock` tinyint(1) NOT NULL,
  `mostrar_venta_realizada` tinyint(1) NOT NULL,
  `clientes_sn` tinyint(1) NOT NULL,
  `facturable` tinyint(1) NOT NULL,
  `venta_imprimible` tinyint(1) NOT NULL,
  `monto_base_credito_cliente` tinyint(1) NOT NULL,
  `confirmar_recepcion_traslado_producto` tinyint(1) NOT NULL,
  `porcentaje_utilidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings_users`
--

CREATE TABLE `settings_users` (
  `id` int(11) NOT NULL,
  `top_panel` tinyint(1) NOT NULL,
  `left_panel` tinyint(1) NOT NULL,
  `right_panel` tinyint(1) NOT NULL,
  `fullscreen` tinyint(1) NOT NULL,
  `skin` varchar(100) DEFAULT NULL,
  `ventas_statistics` int(1) NOT NULL,
  `productos_top` int(1) NOT NULL,
  `pedidos_vigentes` int(1) NOT NULL,
  `usuarios_statistics` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `settings_users`
--

INSERT INTO `settings_users` (`id`, `top_panel`, `left_panel`, `right_panel`, `fullscreen`, `skin`, `ventas_statistics`, `productos_top`, `pedidos_vigentes`, `usuarios_statistics`) VALUES
(6, 1, 0, 0, 0, 'skin-blue', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `slideshow`
--

CREATE TABLE `slideshow` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `url` varchar(250) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `email` varchar(125) DEFAULT NULL,
  `nota` varchar(500) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `location` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id`, `nombre`, `direccion`, `telefono`, `email`, `nota`, `tipo`, `location`) VALUES
(9, 'Sucursal 1', 'dir Sucursal 1', '11212121', 'sucursal@gmail.com', 'Sucursal 1', 1, '112121');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transferencias_apk`
--

CREATE TABLE `transferencias_apk` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_dispositivo` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_venta_apk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL,
  `logged_in` tinyint(1) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('Activo','Inactivo') NOT NULL,
  `avatar` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `logged_in`, `id_grupo`, `id_persona`, `id_sucursal`, `created_at`, `estado`, `avatar`) VALUES
(6, 'leonmc', '$2y$10$/7URqvWc86Obmw9gy.GcIOKe1BvUnimqosHR4w7xwB8izEDiLal4.', 0, 1, 15, 6, '2018-08-24 11:30:26', 'Activo', 0),
(12, 'klonmc', '$2y$10$cxhxsZltYFbQMsZVrAyaq.nicaGeSSMnB2r70SVDe2eNy11GhtVkq', 0, 1, 14, 0, '2019-03-20 03:36:28', 'Activo', 0),
(19, 'root', '$2y$10$iJuow5SbCLriHYxpE9HH9e8PIpPS.NArIUrWdIdV7li1qIH.qqC0K', 0, 0, 0, 5, '2019-03-24 22:49:56', 'Activo', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacios`
--

CREATE TABLE `vacios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(1500) NOT NULL,
  `llave` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `nota` varchar(150) NOT NULL,
  `total` double NOT NULL,
  `transferida` varchar(20) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `tipo` varchar(1) NOT NULL,
  `estado` varchar(1) DEFAULT NULL,
  `id_venta_anterior` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_productos`
--

CREATE TABLE `venta_productos` (
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` double NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `anotacion` varchar(250) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_entrega` date NOT NULL,
  `fecha_entregado` date NOT NULL,
  `estado` varchar(1) NOT NULL,
  `descontar_stock` tinyint(4) NOT NULL,
  `id_venta_anterior` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonas`
--

CREATE TABLE `zonas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `zonas`
--

INSERT INTO `zonas` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Zona A', '<p>\r\n	Comprende todo el segundo anillo hasta la AV. Paragua</p>\r\n');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acciones`
--
ALTER TABLE `acciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `captcha`
--
ALTER TABLE `captcha`
  ADD PRIMARY KEY (`captcha_id`),
  ADD KEY `word` (`word`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria_productos`
--
ALTER TABLE `categoria_productos`
  ADD PRIMARY KEY (`id_producto`,`id_categoria`);

--
-- Indices de la tabla `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `consignaciones`
--
ALTER TABLE `consignaciones`
  ADD PRIMARY KEY (`id`,`orden`,`fecha`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuenta_cliente`
--
ALTER TABLE `cuenta_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD PRIMARY KEY (`id_plan_pago`,`numero`);

--
-- Indices de la tabla `destacados`
--
ALTER TABLE `destacados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `keyAPK` (`keyAPK`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD PRIMARY KEY (`id_producto`,`id_sucursal`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`,`orden`,`fecha_inicio`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plan_pagos`
--
ALTER TABLE `plan_pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `precios`
--
ALTER TABLE `precios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `productos_cotizados`
--
ALTER TABLE `productos_cotizados`
  ADD PRIMARY KEY (`id_cotizacion`,`id_producto`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reposiciones`
--
ALTER TABLE `reposiciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `revision_inventario`
--
ALTER TABLE `revision_inventario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `revision_inventario_producto`
--
ALTER TABLE `revision_inventario_producto`
  ADD PRIMARY KEY (`id_inventario`,`id_producto`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `settings_users`
--
ALTER TABLE `settings_users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `slideshow`
--
ALTER TABLE `slideshow`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transferencias_apk`
--
ALTER TABLE `transferencias_apk`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `venta_productos`
--
ALTER TABLE `venta_productos`
  ADD PRIMARY KEY (`id_venta`,`id_producto`,`orden`);

--
-- Indices de la tabla `zonas`
--
ALTER TABLE `zonas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `captcha`
--
ALTER TABLE `captcha`
  MODIFY `captcha_id` bigint(13) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=386;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `destacados`
--
ALTER TABLE `destacados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=594;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `plan_pagos`
--
ALTER TABLE `plan_pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `precios`
--
ALTER TABLE `precios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `reposiciones`
--
ALTER TABLE `reposiciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `revision_inventario`
--
ALTER TABLE `revision_inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `settings_users`
--
ALTER TABLE `settings_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `slideshow`
--
ALTER TABLE `slideshow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `zonas`
--
ALTER TABLE `zonas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
