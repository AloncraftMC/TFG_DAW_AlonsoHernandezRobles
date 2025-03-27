-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-03-2025 a las 16:56:15
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Peligro'),
(2, 'Prioridad'),
(3, 'Prohibición de entrada'),
(4, 'Restricción de paso'),
(5, 'Otras prohibiciones o restricciones'),
(6, 'Obligación'),
(7, 'Fin de prohibición o restricción'),
(8, 'Indicaciones generales'),
(9, 'Carriles'),
(10, 'Servicio'),
(11, 'Preseñalización'),
(12, 'Dirección'),
(13, 'Identificación de carreteras'),
(14, 'Localización'),
(15, 'Confirmación'),
(16, 'Uso específico en poblado'),
(17, 'Paneles complementarios'),
(18, 'Otras indicaciones'),
(19, 'Vehículos'),
(20, 'Obras'),
(21, 'Balizamiento reflectante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas_pedidos`
--

CREATE TABLE `lineas_pedidos` (
  `id` int(255) NOT NULL,
  `pedido_id` int(255) NOT NULL,
  `producto_id` int(255) NOT NULL,
  `unidades` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(255) NOT NULL,
  `usuario_id` int(255) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `coste` float(200,2) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(255) NOT NULL,
  `categoria_id` int(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` float(100,2) NOT NULL,
  `stock` int(255) NOT NULL,
  `oferta` varchar(2) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `precio`, `stock`, `oferta`, `fecha`, `imagen`) VALUES
(1, 1, 'P-1 Intersección con prioridad', 'Peligro por la proximidad de una intersección con una vía, cuyos usuarios deben ceder el paso.', 30.00, 85, '0', '2025-02-27 19:55:55', '1.svg'),
(2, 1, 'P-1a Intersección con prioridad sobre vía a la derecha', 'Peligro por la proximidad de una intersección con una vía a la derecha, cuyos usuarios deben ceder el paso.', 30.00, 36, '0', '2025-02-27 19:57:19', '2.svg'),
(3, 1, 'P-1b Intersección con prioridad sobre vía a la izquierda', 'Peligro por la proximidad de una intersección con una vía a la izquierda, cuyos usuarios deben ceder el paso.', 30.00, 28, '74', '2025-02-27 19:57:51', '3.svg'),
(4, 1, 'P-1c Intersección con prioridad sobre la incorporación por la derecha', 'Peligro por la proximidad de una incorporación por la derecha de una vía, cuyos usuarios deben ceder el paso.', 30.00, 33, '0', '2025-02-27 19:58:30', '4.svg'),
(5, 1, 'P-1d Intersección con prioridad sobre la incorporación por la izquierda', 'Peligro por la proximidad de una incorporación por la izquierda de una vía, cuyos usuarios deben ceder el paso.', 30.00, 81, '0', '2025-02-27 20:46:28', '5.svg'),
(6, 1, 'P-1e Tramo con accesos directos', 'Peligro por la proximidad de un tramo en el que existen varios accesos directos a la vía, debiendo ceder el paso los usuarios de dichos accesos directos.', 30.00, 5, '92', '2025-02-27 20:47:07', '6.svg'),
(7, 1, 'P-2 Intersección con prioridad de la derecha', 'Peligro por la proximidad de una intersección en la que rige la regla general de prioridad de paso.', 30.00, 86, '54', '2025-02-27 20:47:35', '7.svg'),
(8, 1, 'P-3 Semáforos', 'Peligro por la proximidad de una intersección aislada o tramo con la circulación regulada por semáforos.', 30.00, 12, '0', '2025-02-27 22:40:23', '8.svg'),
(9, 1, 'P-4 Intersección con circulación glorieta', 'Peligro por la proximidad de una intersección donde la circulación se efectúa de forma giratoria en el sentido de las flechas.', 30.00, 5, '63', '2025-02-27 23:02:59', '9.svg'),
(10, 1, 'P-5 Puente móvil', 'Peligro ante la proximidad de un puente que puede ser levantado o girado, interrumpiéndose así temporalmente la circulación.', 30.00, 91, '0', '2025-02-27 23:05:57', '10.svg'),
(11, 1, 'P-6 Cruce de tranvía', 'Peligro por la proximidad de cruce con una línea de tranvía, que tiene prioridad de paso.', 30.00, 37, '46', '2025-02-27 23:06:24', '11.svg'),
(12, 1, 'P-7 Paso a nivel con barreras', 'Peligro por la proximidad de un paso a nivel provisto de barreras o semibarreras.', 30.00, 0, '73', '2025-02-27 23:10:33', '12.svg'),
(13, 1, 'P-8 Paso a nivel sin barreras', 'Peligro por la proximidad de un paso a nivel no provisto de barreras o semibarreras.', 30.00, 44, '0', '2025-02-27 23:11:48', '13.svg'),
(14, 1, 'P-9a Proximidad de un paso a nivel o de un puente móvil (lado derecho)', 'Indica, en el lado derecho, la proximidad de peligro señalizado de un paso a nivel, de un puente móvil o de un muelle. Esta baliza va siempre acompañada de la señal P-5, P-7, P-8 o P-27.', 60.00, 87, '0', '2025-02-27 23:13:21', '14.svg'),
(15, 1, 'P-9b Aproximación de un paso a nivel o de un puente móvil (lado derecho)', 'Indica, en el lado derecho, la aproximación a un paso a nivel, puente móvil o muelle, que dista de éste al menos dos tercios de la distancia entre él y la correspondiente señal de advertencia del peligro.', 60.00, 0, '91', '2025-02-27 23:14:00', '15.svg'),
(16, 1, 'P-9c Cercanía de un paso a nivel o de un puente móvil (lado derecho)', 'Indica, en el lado derecho, cercanía de un paso a nivel, puente móvil o muelle, que dista de éste al menos un tercio de la distancia entre él y la correspondiente señal de advertencia del peligro.', 60.00, 51, '0', '2025-02-27 23:14:51', '16.svg'),
(17, 1, 'P-10a Proximidad de un paso a nivel o de un puente móvil (lado izquierdo)', 'Indica, en el lado izquierdo, la proximidad de peligro señalizado de un paso a nivel, de un puente móvil o de un muelle. Esta baliza va siempre acompañada de la señal P-5, P-7, P-8 o P-27.', 60.00, 47, '0', '2025-02-27 23:15:25', '17.svg'),
(18, 1, 'P-10b Aproximación de un paso a nivel o de un puente móvil (lado izquierdo)', 'Indica, en el lado izquierdo, la aproximación a un paso a nivel, puente móvil o muelle, que dista de éste al menos dos tercios de la distancia entre él y la correspondiente señal de advertencia del peligro.', 60.00, 85, '0', '2025-02-27 23:17:21', '18.svg'),
(19, 1, 'P-10c Cercanía de un paso a nivel o de un puente móvil (lado izquierdo)', 'Indica, en el lado izquierdo, cercanía de un paso a nivel, puente móvil o muelle, que dista de éste al menos un tercio de la distancia entre él y la correspondiente señal de advertencia del peligro.', 60.00, 0, '0', '2025-02-27 23:17:44', '19.svg'),
(20, 1, 'P-11 Situación de un paso a nivel sin barreras', 'Peligro por la presencia inmediata de un paso a nivel sin barreras.', 70.00, 45, '0', '2025-02-27 23:18:13', '20.svg'),
(21, 1, 'P-11a Situación de un paso a nivel sin barreras de más de una vía férrea', 'Peligro por la presencia inmediata de un paso a nivel sin barreras con más de una vía férrea.', 80.00, 0, '0', '2025-02-27 23:18:55', '21.svg'),
(22, 1, 'P-12 Aeropuerto', 'Peligro por la proximidad de un lugar donde frecuentemente vuelan aeronaves a baja altura sobre la vía y que pueden originar ruidos imprevistos.', 30.00, 89, '0', '2025-02-27 23:22:02', '22.svg'),
(23, 1, 'P-13a Curva peligrosa hacia la derecha', 'Peligro por la proximidad de una curva peligrosa hacia la derecha.', 30.00, 89, '0', '2025-02-27 23:22:41', '23.svg'),
(24, 1, 'P-13b Curva peligrosa hacia la izquierda', 'Peligro por la proximidad de una curva peligrosa hacia la izquierda.', 30.00, 76, '0', '2025-02-27 23:23:27', '24.svg'),
(25, 1, 'P-14a Curvas peligrosas hacia la derecha', 'Peligro por la proximidad de una sucesión de curvas próximas entre sí; la primera, hacia la derecha.', 30.00, 16, '0', '2025-02-27 23:23:52', '25.svg'),
(26, 1, 'P-14b Curvas peligrosas hacia la izquierda', 'Peligro por la proximidad de una sucesión de curvas próximas entre sí; la primera, hacia la izquierda.', 30.00, 52, '0', '2025-02-27 23:24:20', '26.svg'),
(27, 1, 'P-15 Perfil irregular', 'Peligro por la proximidad de un resalto o badén en la vía o pavimento en mal estado.', 30.00, 13, '0', '2025-02-27 23:25:29', '27.svg'),
(28, 1, 'P-15a Resalto', 'Peligro por la proximidad de un resalto en la vía.', 30.00, 10, '0', '2025-02-27 23:25:52', '28.svg'),
(29, 1, 'P-15b Badén', 'Peligro por la proximidad de un badén en la vía.', 30.00, 11, '24', '2025-02-27 23:26:08', '29.svg'),
(30, 1, 'P-16a Bajada con fuerte pendiente', 'Peligro por la existencia de un tramo de vía con fuerte pendiente descendente. La cifra indica la pendiente en porcentaje.', 30.00, 26, '32', '2025-02-27 23:26:33', '30.svg'),
(31, 1, 'P-16b Subida con fuerte pendiente', 'Peligro por la existencia de un tramo de vía con fuerte pendiente ascendente. La cifra indica la pendiente en porcentaje.', 30.00, 99, '0', '2025-02-27 23:27:14', '31.svg'),
(32, 1, 'P-17 Estrechamiento de calzada', 'Peligro por la proximidad de una zona de la vía en la que se estrecha la calzada. También puede ser utilizada cuando se reduzca la anchura de los arcenes de la calzada. No se utilizará cuando, tras una reducción del número de carriles de la calzada, la anchura de los carriles restantes y de los arcenes no haya variado.', 30.00, 10, '0', '2025-02-27 23:28:54', '32.svg'),
(33, 1, 'P-17a Estrechamiento de calzada por la derecha', 'Peligro por la proximidad de una zona de la vía en la que la calzada se estrecha por el lado de la derecha. También puede ser utilizada cuando se reduzca la anchura del arcén derecho de la calzada. No se utilizará cuando, tras una reducción del número de carriles de la calzada por la derecha, la anchura de los carriles restantes y de los arcenes no haya variado.', 30.00, 59, '0', '2025-02-27 23:29:42', '33.svg'),
(34, 1, 'P-17b Estrechamiento de calzada por la izquierda', 'Peligro por la proximidad de una zona de la vía en la que la calzada se estrecha por el lado de la izquierda. También puede ser utilizada cuando se reduzca la anchura del arcén izquierdo de la calzada cuando esta sea de un solo sentido de circulación. No se utilizará cuando, tras una reducción del número de carriles de la calzada por la izquierda, la anchura de los carriles restantes y de los arcenes no haya variado.', 30.00, 61, '0', '2025-02-27 23:37:26', '34.svg'),
(35, 1, 'P-18 Obras', 'Peligro por la proximidad de un tramo de vía en obras.', 35.00, 30, '0', '2025-02-28 21:59:16', '35.svg'),
(36, 1, 'P-19 Pavimento deslizante', 'Peligro por la proximidad de una zona de la calzada cuyo pavimento puede resultar deslizante.', 30.00, 69, '0', '2025-02-27 23:44:30', '36.svg'),
(37, 1, 'P-20 Peatones', 'Peligro por la proximidad de un lugar o tramo con elevado tránsito de peatones.', 30.00, 52, '1', '2025-02-27 23:52:40', '37.svg'),
(38, 1, 'P-21 Niños', 'Peligro por la proximidad de un lugar frecuentado por niños, como una escuela, una zona de juegos, etc.', 30.00, 54, '0', '2025-02-27 23:53:09', '38.svg'),
(39, 1, 'P-22 Ciclistas', 'Peligro por la proximidad de un tramo con circulación frecuente de ciclistas.', 30.00, 0, '91', '2025-02-27 23:53:49', '39.svg'),
(40, 1, 'P-23 Paso de animales domésticos', 'Peligro por la proximidad de un lugar donde frecuentemente la vía puede ser atravesada por animales domésticos o ganado.', 30.00, 15, '58', '2025-02-27 23:54:12', '40.svg'),
(41, 1, 'P-24 Paso de animales en libertad', 'Peligro por la proximidad de un lugar donde frecuentemente la vía puede ser atravesada por animales en libertad.', 30.00, 0, '0', '2025-02-27 23:54:41', '41.svg'),
(42, 1, 'P-25 Circulación en los dos sentidos', 'Peligro por la proximidad de un tramo con circulación en ambos sentidos.', 30.00, 0, '0', '2025-02-27 23:55:29', '42.svg'),
(43, 1, 'P-26 Desprendimiento', 'Peligro por la proximidad a una zona con desprendimientos frecuentes y la consiguiente posible presencia de obstáculos en la calzada.', 30.00, 6, '0', '2025-02-28 00:00:15', '43.svg'),
(44, 1, 'P-27 Muelle', 'Peligro debido a que la vía desemboca en un muelle o en una corriente de agua.', 30.00, 37, '48', '2025-02-28 00:00:37', '44.svg'),
(45, 1, 'P-28 Proyección de gravilla', 'Peligro por la proximidad de un tramo de vía donde existe el riesgo de que se proyecte gravilla al pasar los vehículos.', 30.00, 64, '76', '2025-02-28 00:01:02', '45.svg'),
(46, 1, 'P-29 Viento transversal', 'Peligro por la proximidad de una zona donde sopla frecuentemente viento fuerte en dirección transversal.', 30.00, 8, '0', '2025-02-28 00:01:34', '46.svg'),
(47, 1, 'P-30 Escalón lateral', 'Peligro por la existencia de un desnivel a lo largo de la vía en el lado que indique el símbolo.', 30.00, 53, '55', '2025-02-28 00:01:58', '47.svg'),
(48, 1, 'P-31 Congestión', 'Peligro por la proximidad de un tramo en el que frecuentemente la circulación se encuentra detenida o dificultada por congestión del tráfico.', 30.00, 39, '0', '2025-02-28 00:02:27', '48.svg'),
(49, 1, 'P-32 Obstrucción en la calzada', 'Peligro por la proximidad de un lugar en que hay vehículos que obstruyen la calzada debido a avería, accidente u otras causas.', 30.00, 35, '0', '2025-02-28 00:02:58', '49.svg'),
(50, 1, 'P-33 Visibilidad reducida', 'Peligro por la proximidad de un tramo en el que frecuentemente la circulación se ve dificultada por una pérdida notable de visibilidad debida a niebla, lluvia, nieve, humos, etc.', 30.00, 57, '0', '2025-02-28 00:08:28', '50.svg'),
(51, 1, 'P-34 Pavimento deslizante por hielo o nieve', 'Peligro por la proximidad de un tramo en el que frecuentemente, durante la  época invernal, hay presencia de hielo o nieve y los consiguientes peligros asociados.', 30.00, 82, '0', '2025-02-28 00:11:31', '51.svg'),
(52, 1, 'P-50 Otros peligros', 'Indica la proximidad de un peligro distinto de los advertidos por otras señales.', 30.00, 36, '30', '2025-02-28 00:12:40', '52.svg'),
(53, 2, 'R-1 Ceda el paso', 'Obligación para todo conductor de ceder el paso en la próxima intersección a los vehículos que circulen por la vía a la que se aproxime o al carril al que pretende incorporarse.', 30.00, 34, '14', '2025-02-28 00:17:43', '53.svg'),
(54, 2, 'R-2 STOP', 'Obligación para todo conductor de detener su vehículo ante la próxima línea de detención o, si no existe, inmediatamente antes de la intersección, y ceder el paso en ella a los vehículos que circulen por la vía a la que se aproxime.\r\nSi, por circunstancias excepcionales, desde el lugar donde se ha efectuado la detención no existe visibilidad suficiente, el conductor deberá detenerse de nuevo en el lugar desde donde tenga visibilidad, sin poner en peligro a ningún usuario de la vía.', 50.00, 66, '0', '2025-02-28 00:19:00', '54.svg'),
(55, 2, 'R-3 Calzada con prioridad', 'Indica a los conductores de los vehículos que circulen por una calzada su prioridad en las intersecciones sobre los vehículos que circulen por otra calzada o procedan de ella.', 40.00, 0, '0', '2025-02-28 00:29:15', '55.svg'),
(56, 2, 'R-4 Fin de prioridad', 'Indica la proximidad del lugar en que la calzada por la que se circula pierde su prioridad respecto a otra calzada.', 40.00, 30, '0', '2025-02-28 00:29:24', '56.svg'),
(57, 2, 'R-5 Prioridad en sentido contrario', 'Prohibición de entrada en un paso estrecho mientras no sea posible atravesarlo sin obligar a los vehículos que circulen en sentido contrario a detenerse.', 20.00, 74, '0', '2025-02-28 00:30:39', '57.svg'),
(58, 2, 'R-6 Prioridad respecto al sentido contrario', 'Indica a los conductores que, en un próximo paso estrecho, tienen prioridad con relación a los vehículos que circulen en sentido contrario.', 40.00, 0, '78', '2025-02-28 00:30:49', '58.svg'),
(59, 3, 'R-100 Circulación prohibida', 'Prohibición de circulación de toda clase de vehículos en ambos sentidos.', 20.00, 75, '0', '2025-02-28 01:32:04', '59.svg'),
(60, 3, 'R-101 Entrada prohibida', 'Prohibición de acceso a toda clase de vehículos.', 20.00, 34, '0', '2025-02-28 01:34:35', '60.svg'),
(61, 3, 'R-102 Entrada prohibida a vehículos de motor', 'Prohibición de acceso a vehículos de motor', 20.00, 0, '0', '2025-02-28 01:36:30', '61.svg'),
(62, 3, 'R-103 Entrada prohibida a vehículos de motor, excepto motocicletas de dos ruedas', 'Prohibición de acceso a vehículos de motor. No prohíbe el acceso a motocicletas de dos ruedas.', 20.00, 32, '0', '2025-02-28 01:37:31', '62.svg'),
(63, 3, 'R-104 Entrada prohibida a motocicletas', 'Prohibición de acceso a motocicletas.', 20.00, 19, '0', '2025-02-28 01:37:19', '63.svg'),
(64, 3, 'R‐105 Entrada prohibida a ciclomotores', 'Prohibición de acceso a ciclomotores. Igualmente prohíbe la entrada a vehículos para personas de movilidad reducida.', 20.00, 100, '0', '2025-02-28 01:39:05', '64.svg'),
(65, 3, 'R-106 Entrada prohibida a vehículos destinados al transporte de mercancías', 'Prohibición  de  acceso  a  vehículos  destinados  al  transporte  de mercancías, entendiéndose como tales camiones, tractocamiones y furgones o furgonetas, independientemente de su masa.', 20.00, 39, '0', '2025-02-28 01:38:55', '65.svg'),
(66, 3, 'R-107 Entrada prohibida a vehículos destinados al transporte de mercancías con mayor masa autorizada', 'Prohibición  de  acceso  a  toda  clase  de  vehículos  destinados  al transporte  de  mercancías  si  su  masa  máxima  autorizada  es superior a la indicada en la señal, entendiéndose como tales los camiones,  tractocamiones  y  furgones  o  furgonetas  con  mayor masa  autorizada  que  la  indicada en  la  señal.  Prohíbe el  acceso aunque circulen vacíos.', 20.00, 99, '44', '2025-02-28 01:39:33', '66.svg'),
(67, 3, 'R-108 Entrada prohibida a vehículos que transporten mercancías peligrosas', 'Prohibición de acceso a toda clase de vehículos que transporten mercancías peligrosas y requieran estar señalizados de acuerdo con su normativa específica.', 20.00, 75, '0', '2025-02-28 01:40:26', '67.svg'),
(68, 3, 'R-109 Entrada prohibida a vehículos que transporten mercancías explosivas o inflamables', 'Prohibición de acceso a toda clase de vehículos que transporten mercancías explosivas o fácilmente inflamables y requieran estar señalizados de acuerdo con su normativa específica.', 20.00, 79, '12', '2025-02-28 01:41:12', '68.svg'),
(69, 3, 'R‐110 Entrada prohibida a vehículos que transporten  productos contaminantes del agua', 'Prohibición de acceso a toda clase de vehículos que transporten más de 1.000 litros de productos capaces de contaminar el agua.', 20.00, 70, '18', '2025-02-28 01:45:21', '69.svg'),
(70, 3, 'R-111 Entrada prohibida a vehículos agrícolas de motor', 'Prohibición de acceso a tractores y otras máquinas agrícolas autopropulsadas.', 20.00, 13, '0', '2025-02-28 01:52:25', '70.svg'),
(71, 3, 'Entrada prohibida a vehículos de motor con remolque exceptuando los de un solo eje', 'Prohibición de acceso a vehículos de motor con remolque exceptuando los de un solo eje. La inscripción de una cifra de tonelaje, sobre la silueta del remolque o en una placa suplementaria, significa que la prohibición de paso solo se aplica cuando la masa máxima autorizada del remolque supere dicha cifra.', 20.00, 58, '0', '2025-02-28 01:53:05', '71.svg'),
(72, 3, 'R-113 Entrada prohibida a vehículos de tracción animal', 'Prohibición de acceso a vehículos de tracción animal.', 20.00, 50, '0', '2025-02-28 01:53:59', '72.svg'),
(73, 3, 'R-114 Entrada prohibida a ciclos', 'Prohibición de acceso a ciclos.', 20.00, 74, '5', '2025-02-28 01:59:42', '73.svg'),
(74, 3, 'R-115 Entrada prohibida a carros de mano', 'Prohibición de acceso a carros de mano.', 20.00, 18, '0', '2025-02-28 02:00:11', '74.svg'),
(75, 3, 'R-116 Entrada prohibida a peatones', 'Prohibición de acceso a peatones.', 20.00, 71, '0', '2025-02-28 02:00:43', '75.svg'),
(76, 3, 'R-117 Entrada prohibida a animales de montura', 'Prohibición de acceso a animales de montura.', 20.00, 0, '0', '2025-02-28 02:01:52', '76.svg'),
(77, 4, 'R-200 Prohibición de pasar sin detenerse', 'Indica el lugar donde es obligatoria la detención por la proximidad, según la inscripción que contenga, de un puesto de aduana, de policía, de peaje u otro, tras los cuales pueden estar instalados medios mecánicos de detención. En todo caso, el conductor así detenido no podrá reanudar su marcha hasta haber cumplido la prescripción que la señal establece.', 20.00, 90, '0', '2025-02-28 02:03:26', '77.svg'),
(78, 4, 'R-200a Peaje', '', 20.00, 45, '0', '2025-02-28 02:04:05', '78.svg'),
(79, 4, 'R-201 Limitación de masa', 'Prohibición de paso a los vehículos cuya masa en carga \r\nsupere la indicada en toneladas.', 20.00, 56, '0', '2025-02-28 02:04:48', '79.svg'),
(80, 4, 'R-202 Limitación de masa por eje', 'Prohibición de paso a los vehículos cuya masa por eje transmitida por la totalidad de las ruedas acopladas a algún eje supere a la indicada en la señal.', 20.00, 0, '0', '2025-02-28 02:06:20', '80.svg'),
(81, 4, 'R-203 Limitación de longitud', 'Prohibición de paso a los vehículos o conjunto de vehículos cuya longitud máxima, incluida la carga, supere la indicada.', 20.00, 58, '83', '2025-02-28 02:09:18', '81.svg'),
(82, 4, 'R-204 Limitación de anchura', 'Prohibición de paso a los vehículos cuya anchura máxima, incluida la carga, supere la indicada.', 20.00, 53, '7', '2025-02-28 02:10:30', '82.svg'),
(83, 4, 'R-205 Limitación de altura', 'Prohibición de paso a los vehículos cuya altura máxima, incluida la carga, supere la indicada.', 20.00, 92, '82', '2025-02-28 02:11:39', '83.svg'),
(84, 5, 'R-300 Separación mínima', 'Prohibición de circular sin mantener con el vehículo precedente una separación igual o mayor a la indicada en la señal, excepto cuando se vaya a efectuar la maniobra de adelantamiento. Si no aparece  ninguna  cifra  recuerda  de  forma  genérica  que  debe guardare  la  distancia  de  seguridad  entre  vehículos  establecida reglamentariamente.', 20.00, 98, '98', '2025-02-28 02:12:33', '84.svg'),
(85, 5, 'R-301 Velocidad máxima 10', 'Prohibición de circular a velocidad superior, expresada en kilómetros por hora, a la indicada en la señal. Obliga desde el lugar en que esté situada hasta la próxima señal «Fin de limitación de velocidad», de «Fin de prohibiciones» u otra de «Velocidad máxima», salvo que esté colocada en el mismo poste que una señal de advertencia de peligro o en el mismo panel que esta, en cuyo caso la prohibición finaliza cuando termine el peligro señalado. Situada en una vía sin prioridad, deja de tener vigencia al salir de una intersección con una vía con prioridad. Si el límite indicado por la señal coincide con la velocidad máxima permitida para el tipo de vía, recuerda de forma genérica la prohibición de superarla.', 20.00, 14, '0', '2025-02-28 02:28:20', '85.svg'),
(86, 5, 'R-301 Velocidad máxima 20', 'Prohibición de circular a velocidad superior, expresada en kilómetros por hora, a la indicada en la señal. Obliga desde el lugar en que esté situada hasta la próxima señal «Fin de limitación de velocidad», de «Fin de prohibiciones» u otra de «Velocidad máxima», salvo que esté colocada en el mismo poste que una señal de advertencia de peligro o en el mismo panel que esta, en cuyo caso la prohibición finaliza cuando termine el peligro señalado. Situada en una vía sin prioridad, deja de tener vigencia al salir de una intersección con una vía con prioridad. Si el límite indicado por la señal coincide con la velocidad máxima permitida para el tipo de vía, recuerda de forma genérica la prohibición de superarla.', 20.00, 79, '0', '2025-02-28 02:30:00', '86.svg'),
(87, 5, 'R-301 Velocidad máxima 30', 'Prohibición de circular a velocidad superior, expresada en kilómetros por hora, a la indicada en la señal. Obliga desde el lugar en que esté situada hasta la próxima señal «Fin de limitación de velocidad», de «Fin de prohibiciones» u otra de «Velocidad máxima», salvo que esté colocada en el mismo poste que una señal de advertencia de peligro o en el mismo panel que esta, en cuyo caso la prohibición finaliza cuando termine el peligro señalado. Situada en una vía sin prioridad, deja de tener vigencia al salir de una intersección con una vía con prioridad. Si el límite indicado por la señal coincide con la velocidad máxima permitida para el tipo de vía, recuerda de forma genérica la prohibición de superarla.', 20.00, 52, '0', '2025-02-28 02:30:36', '87.svg'),
(88, 5, 'R-301 Velocidad máxima 40', 'Prohibición de circular a velocidad superior, expresada en kilómetros por hora, a la indicada en la señal. Obliga desde el lugar en que esté situada hasta la próxima señal «Fin de limitación de velocidad», de «Fin de prohibiciones» u otra de «Velocidad máxima», salvo que esté colocada en el mismo poste que una señal de advertencia de peligro o en el mismo panel que esta, en cuyo caso la prohibición finaliza cuando termine el peligro señalado. Situada en una vía sin prioridad, deja de tener vigencia al salir de una intersección con una vía con prioridad. Si el límite indicado por la señal coincide con la velocidad máxima permitida para el tipo de vía, recuerda de forma genérica la prohibición de superarla.', 20.00, 0, '0', '2025-02-28 02:31:13', '88.svg'),
(89, 5, 'R-301 Velocidad máxima 50', 'Prohibición de circular a velocidad superior, expresada en kilómetros por hora, a la indicada en la señal. Obliga desde el lugar en que esté situada hasta la próxima señal «Fin de limitación de velocidad», de «Fin de prohibiciones» u otra de «Velocidad máxima», salvo que esté colocada en el mismo poste que una señal de advertencia de peligro o en el mismo panel que esta, en cuyo caso la prohibición finaliza cuando termine el peligro señalado. Situada en una vía sin prioridad, deja de tener vigencia al salir de una intersección con una vía con prioridad. Si el límite indicado por la señal coincide con la velocidad máxima permitida para el tipo de vía, recuerda de forma genérica la prohibición de superarla.', 20.00, 65, '0', '2025-02-28 02:31:41', '89.svg'),
(90, 5, 'R-301 Velocidad máxima 60', 'Prohibición de circular a velocidad superior, expresada en kilómetros por hora, a la indicada en la señal. Obliga desde el lugar en que esté situada hasta la próxima señal «Fin de limitación de velocidad», de «Fin de prohibiciones» u otra de «Velocidad máxima», salvo que esté colocada en el mismo poste que una señal de advertencia de peligro o en el mismo panel que esta, en cuyo caso la prohibición finaliza cuando termine el peligro señalado. Situada en una vía sin prioridad, deja de tener vigencia al salir de una intersección con una vía con prioridad. Si el límite indicado por la señal coincide con la velocidad máxima permitida para el tipo de vía, recuerda de forma genérica la prohibición de superarla.', 20.00, 51, '0', '2025-02-28 02:32:28', '90.svg'),
(91, 5, 'R-301 Velocidad máxima 70', 'Prohibición de circular a velocidad superior, expresada en kilómetros por hora, a la indicada en la señal. Obliga desde el lugar en que esté situada hasta la próxima señal «Fin de limitación de velocidad», de «Fin de prohibiciones» u otra de «Velocidad máxima», salvo que esté colocada en el mismo poste que una señal de advertencia de peligro o en el mismo panel que esta, en cuyo caso la prohibición finaliza cuando termine el peligro señalado. Situada en una vía sin prioridad, deja de tener vigencia al salir de una intersección con una vía con prioridad. Si el límite indicado por la señal coincide con la velocidad máxima permitida para el tipo de vía, recuerda de forma genérica la prohibición de superarla.', 20.00, 62, '0', '2025-02-28 02:33:04', '91.svg'),
(92, 5, 'R-301 Velocidad máxima 80', 'Prohibición de circular a velocidad superior, expresada en kilómetros por hora, a la indicada en la señal. Obliga desde el lugar en que esté situada hasta la próxima señal «Fin de limitación de velocidad», de «Fin de prohibiciones» u otra de «Velocidad máxima», salvo que esté colocada en el mismo poste que una señal de advertencia de peligro o en el mismo panel que esta, en cuyo caso la prohibición finaliza cuando termine el peligro señalado. Situada en una vía sin prioridad, deja de tener vigencia al salir de una intersección con una vía con prioridad. Si el límite indicado por la señal coincide con la velocidad máxima permitida para el tipo de vía, recuerda de forma genérica la prohibición de superarla.', 20.00, 0, '0', '2025-02-28 02:33:27', '92.svg'),
(93, 5, 'R-301 Velocidad máxima 90', 'Prohibición de circular a velocidad superior, expresada en kilómetros por hora, a la indicada en la señal. Obliga desde el lugar en que esté situada hasta la próxima señal «Fin de limitación de velocidad», de «Fin de prohibiciones» u otra de «Velocidad máxima», salvo que esté colocada en el mismo poste que una señal de advertencia de peligro o en el mismo panel que esta, en cuyo caso la prohibición finaliza cuando termine el peligro señalado. Situada en una vía sin prioridad, deja de tener vigencia al salir de una intersección con una vía con prioridad. Si el límite indicado por la señal coincide con la velocidad máxima permitida para el tipo de vía, recuerda de forma genérica la prohibición de superarla.', 20.00, 97, '0', '2025-02-28 02:33:54', '93.svg'),
(94, 5, 'R-301 Velocidad máxima 100', 'Prohibición de circular a velocidad superior, expresada en kilómetros por hora, a la indicada en la señal. Obliga desde el lugar en que esté situada hasta la próxima señal «Fin de limitación de velocidad», de «Fin de prohibiciones» u otra de «Velocidad máxima», salvo que esté colocada en el mismo poste que una señal de advertencia de peligro o en el mismo panel que esta, en cuyo caso la prohibición finaliza cuando termine el peligro señalado. Situada en una vía sin prioridad, deja de tener vigencia al salir de una intersección con una vía con prioridad. Si el límite indicado por la señal coincide con la velocidad máxima permitida para el tipo de vía, recuerda de forma genérica la prohibición de superarla.', 20.00, 13, '0', '2025-02-28 02:34:16', '94.svg'),
(95, 5, 'R-301 Velocidad máxima 110', 'Prohibición de circular a velocidad superior, expresada en kilómetros por hora, a la indicada en la señal. Obliga desde el lugar en que esté situada hasta la próxima señal «Fin de limitación de velocidad», de «Fin de prohibiciones» u otra de «Velocidad máxima», salvo que esté colocada en el mismo poste que una señal de advertencia de peligro o en el mismo panel que esta, en cuyo caso la prohibición finaliza cuando termine el peligro señalado. Situada en una vía sin prioridad, deja de tener vigencia al salir de una intersección con una vía con prioridad. Si el límite indicado por la señal coincide con la velocidad máxima permitida para el tipo de vía, recuerda de forma genérica la prohibición de superarla.', 20.00, 77, '93', '2025-02-28 02:34:37', '95.svg'),
(96, 5, 'R-301 Velocidad máxima 120', 'Prohibición de circular a velocidad superior, expresada en kilómetros por hora, a la indicada en la señal. Obliga desde el lugar en que esté situada hasta la próxima señal «Fin de limitación de velocidad», de «Fin de prohibiciones» u otra de «Velocidad máxima», salvo que esté colocada en el mismo poste que una señal de advertencia de peligro o en el mismo panel que esta, en cuyo caso la prohibición finaliza cuando termine el peligro señalado. Situada en una vía sin prioridad, deja de tener vigencia al salir de una intersección con una vía con prioridad. Si el límite indicado por la señal coincide con la velocidad máxima permitida para el tipo de vía, recuerda de forma genérica la prohibición de superarla.', 20.00, 44, '0', '2025-02-28 02:35:06', '96.svg'),
(97, 5, 'R-301 Velocidad máxima 130', 'Prohibición de circular a velocidad superior, expresada en kilómetros por hora, a la indicada en la señal. Obliga desde el lugar en que esté situada hasta la próxima señal «Fin de limitación de velocidad», de «Fin de prohibiciones» u otra de «Velocidad máxima», salvo que esté colocada en el mismo poste que una señal de advertencia de peligro o en el mismo panel que esta, en cuyo caso la prohibición finaliza cuando termine el peligro señalado. Situada en una vía sin prioridad, deja de tener vigencia al salir de una intersección con una vía con prioridad. Si el límite indicado por la señal coincide con la velocidad máxima permitida para el tipo de vía, recuerda de forma genérica la prohibición de superarla.', 20.00, 92, '0', '2025-02-28 02:35:53', '97.svg'),
(98, 5, 'R-301 Velocidad máxima 140', 'Prohibición de circular a velocidad superior, expresada en kilómetros por hora, a la indicada en la señal. Obliga desde el lugar en que esté situada hasta la próxima señal «Fin de limitación de velocidad», de «Fin de prohibiciones» u otra de «Velocidad máxima», salvo que esté colocada en el mismo poste que una señal de advertencia de peligro o en el mismo panel que esta, en cuyo caso la prohibición finaliza cuando termine el peligro señalado. Situada en una vía sin prioridad, deja de tener vigencia al salir de una intersección con una vía con prioridad. Si el límite indicado por la señal coincide con la velocidad máxima permitida para el tipo de vía, recuerda de forma genérica la prohibición de superarla.', 20.00, 22, '39', '2025-02-28 02:36:19', '98.svg'),
(99, 5, 'R-302 Giro a la derecha prohibido', 'Prohibición de girar a la derecha.', 20.00, 40, '0', '2025-02-28 02:37:09', '99.svg'),
(100, 5, 'R-303 Giro a la izquierda prohibido', 'Prohibición de girar a la izquierda. Incluye, también, la prohibición del cambio de sentido de marcha.', 20.00, 33, '30', '2025-02-28 02:38:15', '100.svg'),
(101, 5, 'R‐304 Cambio de sentido prohibido', 'Prohibición de efectuar la maniobra de cambio de sentido de la marcha.', 20.00, 0, '0', '2025-02-28 02:38:44', '101.svg'),
(102, 5, 'R‐305 Adelantamiento prohibido', 'Por  añadidura  a  los  principios  generales  sobre  adelantamiento, \r\nindica  la  prohibición  a  todos  los  vehículos  de  adelantar  a  los \r\nvehículos a motor que circulen por la calzada cuando dicha maniobra \r\nimplique  invadir  la  zona  reservada  al  sentido  contrario  de \r\ncirculación.  La  prohibición  se  aplica  desde  el  lugar  en  que  esté \r\nsituada la  señal hasta la  siguiente  señal de “Fin de prohibición de \r\nadelantamiento”  o  “Fin  de  prohibiciones”.  Colocada  en  aquellos \r\nlugares  donde  por  norma  esté  prohibido  el  adelantamiento, \r\nrecuerda  de  forma  genérica  la  prohibición  de  efectuar  esta \r\nmaniobra.', 20.00, 26, '0', '2025-02-28 02:39:38', '102.svg'),
(103, 5, 'R‐306 Adelantamiento prohibido para camiones', 'Prohibición a los camiones cuya masa máxima autorizada exceda \r\nde 3.500 kilogramos de adelantar a los vehículos a motor que \r\ncirculen por la calzada, incluso cuando dicha maniobra no implique \r\ninvadir la zona reservada al sentido contrario de circulación. La \r\nprohibición se aplica desde el lugar en que esté situada la señal \r\nhasta la siguiente señal de “Fin de prohibición de adelantamiento” \r\no “Fin de prohibiciones”.', 20.00, 96, '0', '2025-02-28 02:40:09', '103.svg'),
(104, 5, 'R-307 Parada y estacionamiento prohibido', 'Prohibición de parada y estacionamiento en el lado de la calzada en que esté situada la señal. Salvo indicación en contrario, la prohibición comienza en la vertical de la señal y termina en la intersección más próxima en el sentido de la marcha.', 22.00, 99, '0', '2025-02-28 02:42:30', '104.svg'),
(105, 5, 'R-308 Estacionamiento prohibido', 'Prohibición de estacionamiento en el lado de la calzada en que esté situada la señal. Salvo indicación en contrario, la prohibición comienza en la vertical de la señal y termina en la intersección más próxima en el sentido de la marcha. No prohíbe la parada.', 22.00, 7, '79', '2025-02-28 02:43:24', '105.svg'),
(106, 5, 'R-308a Estacionamiento prohibido los días impares', 'Prohibición de estacionamiento en el lado de la calzada en que esté situada la señal, los días impares. Salvo indicación en contrario, la prohibición comienza en la vertical de la señal y termina en la intersección más próxima. No prohíbe la parada.', 22.00, 40, '0', '2025-02-28 02:44:03', '106.svg'),
(107, 5, 'R-308b Estacionamiento prohibido los días pares', 'Prohibición de estacionamiento en el lado de la calzada en que esté situada la señal, los días pares. Salvo indicación en contrario, la prohibición comienza en la vertical de la señal y termina en la intersección más próxima. No prohíbe la parada.', 22.00, 77, '0', '2025-02-28 02:44:26', '107.svg'),
(108, 5, 'R-308c Estacionamiento prohibido la primera quincena', 'Prohibición de estacionamiento en el lado de la calzada en que esté situada la señal, desde las 9 horas del día 1 hasta las 9 horas del día 16. Salvo indicación en contrario, la prohibición comienza en la vertical de la señal y termina en la intersección más próxima en sentido de la marcha. No prohíbe la parada.', 22.00, 65, '0', '2025-02-28 02:45:03', '108.svg'),
(109, 5, 'R-308d Estacionamiento prohibido la segunda quincena', 'Prohibición de estacionamiento en el lado de la calzada en que esté situada la señal, desde las 9 horas del día 16 hasta las 9 horas del día 1. Salvo indicación en contrario, la prohibición comienza en la vertical de la señal y termina en la intersección más próxima en sentido de la marcha. No prohíbe la parada.', 22.00, 95, '0', '2025-02-28 02:45:57', '109.svg'),
(110, 5, 'R-308e Estacionamiento prohibido en vado', 'Prohíbe el estacionamiento delante de un vado.', 5.00, 0, '84', '2025-02-28 02:46:39', '110.svg'),
(111, 5, 'R-309 Zona de estacionamiento limitado', 'Zona de estacionamiento de duración limitada y obligación para el conductor de indicar, de forma reglamentaria, la hora del comienzo del estacionamiento. Se podrá incluir el tiempo máximo autorizado de estacionamiento y el horario de vigencia de la limitación. También se podrá incluir si el estacionamiento está sujeto a pago.', 15.00, 9, '0', '2025-02-28 02:47:33', '111.svg'),
(112, 5, 'R-310 Advertencias acústicas prohibidas', 'Recuerda la prohibición general de efectuar señales acústicas, salvo para evitar un accidente.', 20.00, 12, '0', '2025-02-28 02:48:05', '112.svg'),
(113, 6, 'R-400a Sentido obligatorio', 'La flecha señala la dirección y sentido que los vehículos tienen la obligación de seguir.', 20.00, 33, '0', '2025-02-28 02:49:24', '113.svg'),
(114, 6, 'R-400b Sentido obligatorio', 'La flecha señala la dirección y sentido que los vehículos tienen la obligación de seguir.', 20.00, 30, '0', '2025-02-28 02:49:46', '114.svg'),
(115, 6, 'R-400c Sentido obligatorio', 'La flecha señala la dirección y sentido que los vehículos tienen la obligación de seguir.', 20.00, 0, '0', '2025-02-28 02:50:08', '115.svg'),
(116, 6, 'R-400d Sentido obligatorio', 'La flecha señala la dirección y sentido que los vehículos tienen la obligación de seguir.', 20.00, 59, '0', '2025-02-28 02:50:27', '116.svg'),
(117, 6, 'R-400e Sentido obligatorio', 'La flecha señala la dirección y sentido que los vehículos tienen la obligación de seguir.', 20.00, 44, '0', '2025-02-28 02:51:01', '117.svg'),
(118, 6, 'R-401a Paso obligatorio', 'La flecha señala el lado del refugio, de la isleta o del obstáculo por el que los vehículos han de pasar obligatoriamente.', 20.00, 43, '0', '2025-02-28 02:51:56', '118.svg'),
(119, 6, 'R-401b Paso obligatorio', 'La flecha señala el lado del refugio, de la isleta o del obstáculo por el que los vehículos han de pasar obligatoriamente.', 20.00, 84, '0', '2025-02-28 02:52:16', '119.svg'),
(120, 6, 'R-401c Paso obligatorio', 'La flecha señala el lado del refugio, de la isleta o del obstáculo por el que los vehículos han de pasar obligatoriamente.', 20.00, 88, '0', '2025-02-28 02:52:50', '120.svg'),
(121, 6, 'R-402 Sentido obligatorio en glorieta', 'Las flechas señalan la dirección y sentido del movimiento giratorio que los vehículos deben seguir.', 20.00, 88, '0', '2025-02-28 02:55:10', '121.svg'),
(122, 6, 'R-403a Únicas direcciones y sentidos permitidos', 'Las flechas señalan las únicas direcciones y sentidos que los vehículos pueden tomar.', 20.00, 0, '0', '2025-02-28 02:55:52', '122.svg'),
(123, 6, 'R-403b Únicas direcciones y sentidos permitidos', 'Las flechas señalan las únicas direcciones y sentidos que los vehículos pueden tomar.', 20.00, 11, '0', '2025-02-28 02:56:25', '123.svg'),
(124, 6, 'R-403c Únicas direcciones y sentidos permitidos', 'Las flechas señalan la única dirección y sentidos que los vehículos pueden tomar.', 20.00, 33, '13', '2025-02-28 02:57:26', '124.svg'),
(125, 6, 'R-404 Calzada obligatoria para automóviles, excepto motocicletas de dos ruedas', 'Obligación para los conductores de automóviles, excepto motocicletas de dos ruedas, de circular por la calzada a cuya entrada esté situada.', 20.00, 29, '0', '2025-02-28 03:05:10', '125.svg'),
(126, 6, 'R-405 Calzada obligatoria para motocicletas de dos ruedas', 'Obligación para los conductores de motocicletas de dos ruedas de circular por la calzada a cuya entrada esté situada.', 20.00, 49, '0', '2025-02-28 03:05:45', '126.svg'),
(127, 6, 'R-406 Calzada obligatoria para camiones, tractocamiones y furgones o furgonetas', 'Obligación para los conductores de toda clase de camiones, tractocamiones y furgones o furgonetas, independientemente de su masa, de circular por la calzada a cuya entrada esté situada. La inscripción de una cifra de tonelaje sobre la silueta del vehículo o en una placa suplementaria, significa que la obligación solo se aplica cuando la masa máxima autorizada del vehículo o del conjunto de vehículos supere la citada cifra.', 20.00, 59, '0', '2025-02-28 03:08:06', '127.svg'),
(128, 6, 'R-407 Vía reservada para ciclos o vía ciclista', 'Obligación para los conductores de ciclos de circular por la vía a cuya entrada esté situada y prohibición a los demás usuarios de la vía de utilizarla.', 20.00, 44, '0', '2025-02-28 03:09:12', '128.svg'),
(129, 6, 'R-408 Camino para vehículos de tracción animal', 'Obligación para los conductores de vehículos de tracción animal de utilizar el camino a cuya entrada esté situada.', 20.00, 45, '0', '2025-02-28 03:09:48', '129.svg'),
(130, 6, 'R-409 Camino para animales de montura', 'Obligación para los jinetes de utilizar con sus animales de montura el camino a cuya entrada esté situada y prohibición a los demás usuarios de la vía de utilizarlo.', 20.00, 95, '0', '2025-02-28 03:11:05', '130.svg'),
(131, 6, 'R-410 Camino reservado para peatones', 'Obligación para los peatones de transitar por el camino a cuya entrada esté situada y prohibición a los demás usuarios de la vía de utilizarlo.', 20.00, 35, '0', '2025-02-28 03:11:41', '131.svg'),
(132, 6, 'R-411 Velocidad mínima 30', 'Obligación para los conductores de vehículos de circular, por lo menos, a la velocidad indicada por la cifra, en kilómetros por hora, que figure en la señal, desde el lugar en que esté situada hasta otra de velocidad mínima diferente, o de fin de velocidad mínima o de velocidad máxima de valor igual o inferior.', 20.00, 94, '0', '2025-02-28 03:12:30', '132.svg'),
(133, 6, 'R-412 Cadenas para nieve', 'Obligación de no proseguir la marcha sin cadenas para nieve u otros dispositivos antideslizantes autorizados que actúen al menos en una rueda a cada lado del mismo eje motor, o neumáticos especiales de nieve.', 20.00, 61, '0', '2025-02-28 03:12:58', '133.svg'),
(134, 6, 'R-413 Alumbrado de corto alcance', 'Obligación para los conductores de circular con el alumbrado al menos de corto alcance, con independencia de las condiciones de visibilidad e iluminación de la vía, desde el lugar en que esté situada la señal hasta otra de fin de esta obligación.', 20.00, 24, '0', '2025-02-28 03:13:27', '134.svg'),
(135, 6, 'R-414 Calzada para vehículos que transporten mercancías peligrosas', 'Obligación para los conductores de toda clase de vehículos que transporten mercancías peligrosas y requieran estar señalizados de acuerdo con su normativa específica de circular por la calzada a cuya entrada esté situada.', 20.00, 38, '72', '2025-02-28 03:13:56', '135.svg'),
(136, 6, 'R-415 Calzada para vehículos que transporten productos contaminantes del agua', 'Obligación para los conductores de toda clase de vehículos que transporten más de 1.000 litros de productos capaces de contaminar el agua de circular por la calzada a cuya entrada esté situada.', 20.00, 18, '0', '2025-02-28 03:14:30', '136.svg'),
(137, 6, 'R-416 Calzada para vehículos que transporten materias explosivas o inflamables', 'Obligación para los conductores de toda clase de vehículos que \r\ntransporten mercancías explosivas o fácilmente inflamables y \r\nrequieran estar señalizados de acuerdo con su normativa específica \r\nde circular por la calzada a cuya entrada esté situada.', 20.00, 77, '0', '2025-02-28 03:15:04', '137.svg'),
(138, 6, 'R-417 Uso obligatorio del cinturón de seguridad', 'Recuerda la obligación de utilizar el cinturón de seguridad.', 20.00, 31, '41', '2025-02-28 03:15:55', '138.svg'),
(139, 6, 'R-418 Vía exclusiva para vehículos dotados de equipo de telepeaje operativo. Telepeaje obligatorio.', 'Obligación de efectuar el pago del peaje mediante el sistema de peaje dinámico o telepeaje; el vehículo que circule por el carril o carriles así señalizados deberá estar provisto del medio técnico que posibilite su uso en condiciones operativas de acuerdo con las disposiciones legales en la materia.', 20.00, 23, '0', '2025-02-28 03:16:31', '139.svg'),
(140, 7, 'R-500 Fin de prohibiciones', 'Señala el lugar desde el que todas las prohibiciones específicas indicadas por señales anteriores de prohibición para vehículos en movimiento dejan de tener aplicación.', 20.00, 25, '0', '2025-02-28 03:24:15', '140.svg'),
(141, 7, 'R-501 Fin de la limitación de velocidad 60', 'Señala el lugar desde donde deja de ser aplicable una señal anterior de velocidad máxima.', 20.00, 56, '0', '2025-02-28 03:24:55', '141.svg'),
(142, 7, 'R-502 Fin de la prohibición de adelantamiento', 'Señala el lugar desde donde deja de ser aplicable una señal anterior de adelantamiento prohibido.', 20.00, 5, '0', '2025-02-28 03:27:02', '142.svg'),
(143, 7, 'R-503 Fin de la prohibición de adelantamiento para camiones', 'Señala el lugar desde donde deja de ser aplicable una señal anterior de adelantamiento prohibido para camiones.', 20.00, 58, '0', '2025-02-28 03:27:38', '143.svg'),
(144, 7, 'R-504 Fin de zona de estacionamiento limitado', 'Señala el lugar desde donde deja de ser aplicable una anterior señal de zona de estacionamiento limitado.', 15.00, 75, '0', '2025-02-28 03:28:33', '144.svg'),
(145, 7, 'R-505 Fin de vía reservada para ciclos', 'Señala el lugar desde donde deja de ser aplicable una señal anterior de vía reservada y obligatoria para ciclos.', 20.00, 99, '0', '2025-02-28 03:30:55', '145.svg'),
(146, 7, 'R-505a Fin de prohibición de señales acústicas', '', 20.00, 67, '0', '2025-02-28 03:32:55', '146.svg'),
(147, 7, 'R-506 Fin de tramo de velocidad mínima exigida 30', 'Señala el lugar desde donde deja de ser aplicable una señal anterior de velocidad mínima.', 20.00, 39, '0', '2025-02-28 03:33:35', '147.svg'),
(148, 8, 'S-1 Autopista', 'Indica el principio de una autopista y, por tanto, el lugar a partir del cual se aplican las reglas especiales de circulación en este tipo de vía. El símbolo de esta señal puede anunciar la proximidad de una autopista o indicar el ramal de una intersección que conduce a una autopista.', 60.00, 94, '26', '2025-02-28 03:34:59', '148.svg'),
(149, 8, 'S-1a Autovía', 'Indica el principio de una autovía y, por tanto, el lugar a partir del cual se aplican las reglas especiales de circulación en este tipo de vía. El símbolo de esta señal puede anunciar la proximidad de una autovía o indicar el ramal de una intersección que conduce a una autovía.', 60.00, 53, '0', '2025-02-28 03:35:52', '149.svg'),
(150, 8, 'S-2 Fin de autopista', 'Indica el final de una autopista.', 60.00, 84, '0', '2025-02-28 03:36:21', '150.svg'),
(151, 8, 'S-2a Fin de autovía', 'Indica el final de una autovía.', 60.00, 58, '0', '2025-02-28 03:36:55', '151.svg'),
(152, 8, 'S-3 Vía reservada para automóviles', 'Indica el principio de una vía reservada a la circulación de automóviles.', 60.00, 42, '0', '2025-02-28 04:41:19', '152.svg'),
(153, 8, 'S-4 Fin de vía reservada para automóviles', 'Indica el final de una vía reservada a la circulación de automóviles.', 60.00, 33, '62', '2025-02-28 04:41:25', '153.svg'),
(154, 8, 'S-5 Túnel', 'Indica el principio y en algún momento el nombre de un túnel, de un paso inferior o de un tramo de vía equiparado a túnel. Podrá llevar en su parte inferior la indicación de la longitud del túnel en metros.', 60.00, 39, '0', '2025-02-28 04:42:23', '154.svg'),
(155, 8, 'S-6 Fin de túnel', 'Indica el final de un túnel, de un paso inferior o de un tramo de vía equiparado a túnel.', 60.00, 97, '0', '2025-02-28 04:43:23', '155.svg'),
(156, 8, 'S-7 Velocidad máxima aconsejada 10', 'Recomienda una velocidad aproximada de circulación, en kilómetros por hora, que se aconseja no sobrepasar, aunque las condiciones meteorológicas y ambientales de la vía y de la circulación sean favorables. Cuando está colocada bajo una señal de advertencia de peligro, la recomendación se refiere al tramo en que dicho peligro subsista.', 40.00, 66, '0', '2025-02-28 04:44:13', '156.svg'),
(157, 8, 'S-7 Velocidad máxima aconsejada 20', 'Recomienda una velocidad aproximada de circulación, en kilómetros por hora, que se aconseja no sobrepasar, aunque las condiciones meteorológicas y ambientales de la vía y de la circulación sean favorables. Cuando está colocada bajo una señal de advertencia de peligro, la recomendación se refiere al tramo en que dicho peligro subsista.', 40.00, 38, '0', '2025-02-28 04:44:34', '157.svg'),
(158, 8, 'S-7 Velocidad máxima aconsejada 30', 'Recomienda una velocidad aproximada de circulación, en kilómetros por hora, que se aconseja no sobrepasar, aunque las condiciones meteorológicas y ambientales de la vía y de la circulación sean favorables. Cuando está colocada bajo una señal de advertencia de peligro, la recomendación se refiere al tramo en que dicho peligro subsista.', 40.00, 93, '62', '2025-02-28 05:21:03', '158.svg'),
(159, 8, 'S-7 Velocidad máxima aconsejada 40', 'Recomienda una velocidad aproximada de circulación, en kilómetros por hora, que se aconseja no sobrepasar, aunque las condiciones meteorológicas y ambientales de la vía y de la circulación sean favorables. Cuando está colocada bajo una señal de advertencia de peligro, la recomendación se refiere al tramo en que dicho peligro subsista.', 40.00, 0, '0', '2025-02-28 05:21:15', '159.svg'),
(160, 8, 'S-7 Velocidad máxima aconsejada 50', 'Recomienda una velocidad aproximada de circulación, en kilómetros por hora, que se aconseja no sobrepasar, aunque las condiciones meteorológicas y ambientales de la vía y de la circulación sean favorables. Cuando está colocada bajo una señal de advertencia de peligro, la recomendación se refiere al tramo en que dicho peligro subsista.', 40.00, 73, '0', '2025-02-28 04:46:35', '160.svg'),
(161, 8, 'S-7 Velocidad máxima aconsejada 60', 'Recomienda una velocidad aproximada de circulación, en kilómetros por hora, que se aconseja no sobrepasar, aunque las condiciones meteorológicas y ambientales de la vía y de la circulación sean favorables. Cuando está colocada bajo una señal de advertencia de peligro, la recomendación se refiere al tramo en que dicho peligro subsista.', 40.00, 15, '0', '2025-02-28 04:46:55', '161.svg'),
(162, 8, 'S-7 Velocidad máxima aconsejada 70', 'Recomienda una velocidad aproximada de circulación, en kilómetros por hora, que se aconseja no sobrepasar, aunque las condiciones meteorológicas y ambientales de la vía y de la circulación sean favorables. Cuando está colocada bajo una señal de advertencia de peligro, la recomendación se refiere al tramo en que dicho peligro subsista.', 40.00, 56, '0', '2025-02-28 04:47:11', '162.svg');
INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `precio`, `stock`, `oferta`, `fecha`, `imagen`) VALUES
(163, 8, 'S-7 Velocidad máxima aconsejada 80', 'Recomienda una velocidad aproximada de circulación, en kilómetros por hora, que se aconseja no sobrepasar, aunque las condiciones meteorológicas y ambientales de la vía y de la circulación sean favorables. Cuando está colocada bajo una señal de advertencia de peligro, la recomendación se refiere al tramo en que dicho peligro subsista.', 40.00, 33, '0', '2025-02-28 04:47:28', '163.svg'),
(164, 8, 'S-7 Velocidad máxima aconsejada 90', 'Recomienda una velocidad aproximada de circulación, en kilómetros por hora, que se aconseja no sobrepasar, aunque las condiciones meteorológicas y ambientales de la vía y de la circulación sean favorables. Cuando está colocada bajo una señal de advertencia de peligro, la recomendación se refiere al tramo en que dicho peligro subsista.', 40.00, 98, '0', '2025-02-28 04:47:57', '164.svg'),
(165, 8, 'S-7 Velocidad máxima aconsejada 100', 'Recomienda una velocidad aproximada de circulación, en kilómetros por hora, que se aconseja no sobrepasar, aunque las condiciones meteorológicas y ambientales de la vía y de la circulación sean favorables. Cuando está colocada bajo una señal de advertencia de peligro, la recomendación se refiere al tramo en que dicho peligro subsista.', 40.00, 91, '0', '2025-02-28 04:49:10', '165.svg'),
(166, 8, 'S-7 Velocidad máxima aconsejada 110', 'Recomienda una velocidad aproximada de circulación, en kilómetros por hora, que se aconseja no sobrepasar, aunque las condiciones meteorológicas y ambientales de la vía y de la circulación sean favorables. Cuando está colocada bajo una señal de advertencia de peligro, la recomendación se refiere al tramo en que dicho peligro subsista.', 40.00, 61, '0', '2025-02-28 04:49:36', '166.svg'),
(167, 8, 'S-7 Velocidad máxima aconsejada 120', 'Recomienda una velocidad aproximada de circulación, en kilómetros por hora, que se aconseja no sobrepasar, aunque las condiciones meteorológicas y ambientales de la vía y de la circulación sean favorables. Cuando está colocada bajo una señal de advertencia de peligro, la recomendación se refiere al tramo en que dicho peligro subsista.', 40.00, 33, '0', '2025-02-28 04:48:59', '167.svg'),
(168, 8, 'S-8 Fin de velocidad máxima aconsejada', 'Indica el final de un tramo en el que se recomienda circular a la velocidad en kilómetros por hora indicada en la señal.', 40.00, 80, '0', '2025-02-28 04:50:40', '168.svg'),
(169, 8, 'S-9 Intervalo aconsejado de velocidades', 'Recomienda mantener la velocidad entre los valores indicados, siempre que las condiciones meteorológicas y ambientales de la vía y de la circulación sean favorables. Cuando está colocada debajo de una señal de advertencia de peligro, la recomendación se refiere al tramo en que dicho peligro subsista.', 70.00, 2, '44', '2025-02-28 04:52:05', '169.png'),
(170, 8, 'S-10 Fin de intervalo aconsejado de velocidades', 'Indica el lugar desde donde deja de ser aplicable una anterior señal de intervalo aconsejado de velocidades.', 70.00, 71, '0', '2025-02-28 04:52:59', '170.png'),
(171, 8, 'S-11 Calzada de sentido único', 'Indica que, en la calzada que se prolonga en la dirección de la flecha, los vehículos deben circular en el sentido indicado por esta, y que está prohibida la circulación en sentido contrario.', 40.00, 46, '0', '2025-02-28 04:53:35', '171.svg'),
(172, 8, 'S-11a Calzada de sentido único', 'Indica que, en la calzada que se prolonga en la dirección de las flechas (dos carriles), los vehículos deben circular en el sentido indicado por esta, y que está prohibida la circulación en sentido contrario.', 40.00, 18, '96', '2025-02-28 04:54:35', '172.svg'),
(173, 8, 'S-11b Calzada de sentido único', 'Indica que, en la calzada que se prolonga en la dirección de las flechas (tres carriles), los vehículos deben circular en el sentido indicado por esta, y que está prohibida la circulación en sentido contrario.', 60.00, 56, '47', '2025-02-28 04:55:18', '173.svg'),
(174, 8, 'S-12 Tramo de calzada de sentido único', 'Indica que, en el tramo de calzada que se prolonga en la dirección de la flecha, los vehículos deben circular en el sentido indicado por esta, y que está prohibida la circulación en sentido contrario.', 35.00, 23, '32', '2025-02-28 04:55:54', '174.svg'),
(175, 8, 'S-13 Situación de un paso de peatones', 'Indica la situación de un paso para peatones.', 40.00, 46, '81', '2025-02-28 04:57:47', '175.svg'),
(176, 8, 'S-14a Paso superior para peatones', 'Indica la situación de un paso superior para peatones.', 60.00, 64, '0', '2025-02-28 04:57:37', '176.svg'),
(177, 8, 'S-14b Paso inferior para peatones', 'Indica la situación de un paso inferior para peatones.', 60.00, 79, '0', '2025-02-28 04:58:20', '177.svg'),
(178, 8, 'S-15a Calle Cortada', 'Indican que, de la calzada que figura en la señal con un recuadro rojo, los vehículos solo pueden salir por el lugar de entrada.', 40.00, 4, '0', '2025-02-28 04:59:16', '178.svg'),
(179, 8, 'S-15b Calle Cortada', 'Indican que, de la calzada que figura en la señal con un recuadro rojo, los vehículos solo pueden salir por el lugar de entrada.', 50.00, 86, '0', '2025-02-28 04:59:23', '179.svg'),
(180, 8, 'S-15c Calle Cortada', 'Indican que, de la calzada que figura en la señal con un recuadro rojo, los vehículos solo pueden salir por el lugar de entrada.', 50.00, 12, '27', '2025-02-28 05:15:45', '180.svg'),
(181, 8, 'S-15d Calle cortada', 'Indican que, de la calzada que figura en la señal con un recuadro rojo, los vehículos solo pueden salir por el lugar de entrada.', 50.00, 6, '0', '2025-02-28 05:00:34', '181.svg'),
(182, 8, 'S-16 Zona de frenado de emergencia', 'Indica la situación de una zona de escape de la calzada, acondicionada para que un vehículo pueda ser detenido en caso de fallo de su sistema de frenado.', 60.00, 94, '0', '2025-02-28 05:01:09', '182.svg'),
(183, 8, 'S-17 Estacionamiento', 'Indica un emplazamiento donde está autorizado el estacionamiento de vehículos.\r\nUna inscripción o un símbolo, que representa ciertas clases de vehículos, indica que el estacionamiento está reservado a esas clases. Una inscripción con indicaciones de tiempo limita la duración del estacionamiento señalado.', 40.00, 0, '1', '2025-02-28 05:01:38', '183.svg'),
(184, 8, 'S-18 Lugar reservado para taxis', 'Indica el lugar reservado a la parada y al estacionamiento de taxis libres y en servicio. La inscripción de un número indica el número total de espacios reservados a este fin.', 40.00, 71, '0', '2025-02-28 05:02:35', '184.svg'),
(185, 8, 'S-19 Parada de autobuses', 'Indica el lugar reservado para parada de autobuses.', 50.00, 3, '0', '2025-02-28 05:02:59', '185.svg'),
(186, 8, 'S-20 Parada de tranvías', 'Indica el lugar reservado para parada de tranvías.', 50.00, 4, '0', '2025-02-28 05:03:21', '186.svg'),
(187, 8, 'S-21 Puerto de montaña', 'Indica la situación de transitabilidad del puerto o tramo definido en la parte superior de la señal. El panel 1 de la señal S-21 llevará una de estas dos indicaciones: «abierto» (1.a), «cerrado» (1.b). El panel 2 de la señal S-21. podrá ir en blanco, en cuyo caso no indica prescripción alguna; o bien indicar que el uso de cadenas para nieve es obligatorio o está recomendado. Cuando el panel 1 de la señal S-21. indica «cerrado», el panel 3 podrá llevar la indicación del lugar hasta el que la carretera esté transitable, en las condiciones que se indiquen en el panel 2.', 60.00, 14, '0', '2025-02-28 05:03:51', '187.png'),
(188, 8, 'S-22 Cambio de sentido al mismo nivel', 'Indica la proximidad de una salida a través de la cual se puede efectuar un cambio de sentido a un mismo nivel.', 40.00, 55, '82', '2025-02-28 05:04:29', '188.svg'),
(189, 8, 'S-23 Hospital', 'Indica, además, a los conductores de vehículos la conveniencia de tomar las precauciones que requiere la proximidad de establecimientos médicos, especialmente la de evitar la producción de ruido.', 40.00, 31, '0', '2025-02-28 05:05:15', '189.svg'),
(190, 8, 'S-24 Fin de obligación de alumbrado de corto alcance', 'Indica el final de un tramo en que es obligatorio el alumbrado de cruce o corto alcance y recuerda la posibilidad de prescindir de este, siempre que no venga impuesto por circunstancias de visibilidad, horario o iluminación de la vía.', 60.00, 94, '33', '2025-02-28 05:05:50', '190.svg'),
(191, 8, 'S-25 Cambio de sentido a distinto nivel', 'Indica la proximidad de una salida a través de la cual se puede efectuar un cambio de sentido a distinto nivel.', 50.00, 72, '0', '2025-02-28 05:06:22', '191.svg'),
(192, 8, 'S-26a Panel de aproximación a salida (300 m)', 'Indica en una autopista, en una autovía o en una vía para automóviles que la próxima salida está situada, aproximadamente, a 300 metros.', 40.00, 82, '0', '2025-02-28 05:08:34', '192.svg'),
(193, 8, 'S-26b Panel de aproximación a salida (200 m)', 'Indica en una autopista, en una autovía o en una vía para automóviles que la próxima salida está situada, aproximadamente, a 200 metros.', 40.00, 91, '0', '2025-02-28 05:09:26', '193.svg'),
(194, 8, 'S-26c Panel de aproximación a salida (100 m)', 'Indica en una autopista, en una autovía o en una vía para automóviles que la próxima salida está situada, aproximadamente, a 100 metros.', 40.00, 7, '76', '2025-02-28 05:10:02', '194.svg'),
(195, 8, 'S-27 Auxilio en carretera', 'Indica la situación del poste o puesto de socorro más próximo desde el que se puede solicitar auxilio en caso de accidente o avería. La señal puede indicar la distancia a la que este se halla.', 20.00, 67, '0', '2025-02-28 05:10:52', '195.svg'),
(196, 8, 'S-28 Zona residencial', 'Indica las zonas de circulación especialmente acondicionadas que están destinadas en primer lugar a los peatones y en las que se aplican las normas especiales de circulación siguientes: la velocidad máxima de los vehículos está fijada en 20 kilómetros por hora y los conductores deben conceder prioridad a los peatones. Los vehículos no pueden estacionarse más que en los lugares designados por señales o por marcas.\r\nLos peatones pueden utilizar toda la zona de circulación. Los juegos y los deportes están autorizados en ella. Los peatones no deben estorbar inútilmente a los conductores de vehículos.', 50.00, 9, '0', '2025-02-28 05:11:26', '196.svg'),
(197, 8, 'S-29 Fin de zona residencial', 'Indica que se aplican de nuevo las normas generales de circulación.', 50.00, 50, '80', '2025-02-28 05:12:03', '197.svg'),
(198, 8, 'S-30 Zona a 30', 'Indica la zona de circulación especialmente acondicionada que está destinada en primer lugar a los peatones. La velocidad máxima de los vehículos está fijada en 30 kilómetros por hora. Los peatones tienen prioridad.', 30.00, 19, '61', '2025-02-28 05:12:35', '198.svg'),
(199, 8, 'S-31 Fin de zona a 30', 'Indica que se aplican de nuevo las normas generales de circulación.', 31.00, 47, '38', '2025-02-28 05:13:06', '199.svg'),
(200, 8, 'S-32 Telepeaje', 'Indica que el vehículo que circule por el carril o carriles así señalizados puede efectuar el pago del peaje mediante el sistema de peaje dinámico o telepeaje, siempre que esté provisto del medio técnico que posibilite su uso.', 40.00, 78, '0', '2025-02-28 05:13:36', '200.svg'),
(201, 8, 'S-33 Senda ciclable', 'Indica la existencia de una vía para peatones y ciclos, segregada del tráfico motorizado, y que discurre por espacios abiertos, parques, jardines o bosques.', 31.40, 45, '0', '2025-02-28 05:14:15', '201.svg'),
(202, 8, 'S-34 Apartadero en túneles', 'Indica la situación de un lugar donde se puede apartar el vehículo en un túnel, a fin de dejar libre el paso.', 25.00, 96, '28', '2025-02-28 05:14:52', '202.svg'),
(203, 8, 'S-34a Apartadero en túneles', 'Indica la situación de un lugar donde se puede apartar el vehículo en un túnel, a fin de dejar libre el paso, y que dispone de teléfono de emergencia.', 50.00, 39, '21', '2025-02-28 05:15:23', '203.svg'),
(204, 8, 'Inicio de tramo de concentración de accidentes (punto negro)', 'Indica el inicio de un punto negro en la carretera.', 100.00, 11, '0', '2025-02-28 05:17:38', '204.jpg'),
(205, 8, 'Fin de tramo de concentración de accidentes (punto negro)', 'Indica el fin de un punto negro en la carretera.', 85.00, 39, '0', '2025-02-28 05:19:26', '205.jpg'),
(206, 9, 'S-50a Carriles reservados para el tráfico en función de la velocidad señalizada', 'Indica que el carril sobre el que está situada la señal de velocidad mínima solo puede ser utilizado por los vehículos que circulen a velocidad igual o superior a la indicada, aunque si las circunstancias lo permiten deben circular por el carril de la derecha. El final de la obligatoriedad de velocidad mínima vendrá establecido por la señal S-52 o R-506.', 60.00, 61, '0', '2025-02-28 15:58:04', '206.svg'),
(207, 9, 'S-50b Carriles reservados para tráfico en función de la velocidad señalizada', 'Indica que el carril sobre el que está situada la señal de velocidad mínima solo puede ser utilizado por los vehículos que circulen a velocidad igual o superior a la indicada, aunque si las circunstancias lo permiten deben circular por el carril de la derecha. El final de la obligatoriedad de velocidad mínima vendrá establecido por la señal S-52 o R-506.', 60.00, 90, '0', '2025-02-28 16:04:23', '207.svg'),
(208, 9, 'S-50c Carriles reservados para tráfico en función de la velocidad señalizada', 'Indica que el carril sobre el que está situada la señal de velocidad mínima solo puede ser utilizado por los vehículos que circulen a velocidad igual o superior a la indicada, aunque si las circunstancias lo permiten deben circular por el carril de la derecha. El final de la obligatoriedad de velocidad mínima vendrá establecido por la señal S-52 o R-506.', 60.00, 64, '0', '2025-02-28 16:10:55', '208.svg'),
(209, 9, 'S-50d Carriles reservados para tráfico en función de la velocidad señalizada', 'Indica que el carril sobre el que está situada la señal de velocidad mínima solo puede ser utilizado por los vehículos que circulen a velocidad igual o superior a la indicada, aunque si las circunstancias lo permiten deben circular por el carril de la derecha. El final de la obligatoriedad de velocidad mínima vendrá establecido por la señal S-52 o R-506.', 55.00, 48, '0', '2025-02-28 16:13:57', '209.svg'),
(210, 9, 'S-50e Carriles reservados para tráfico en función de la velocidad señalizada', 'Indica que el carril sobre el que está situada la señal de velocidad mínima solo puede ser utilizado por los vehículos que circulen a velocidad igual o superior a la indicada, aunque si las circunstancias lo permiten deben circular por el carril de la derecha. El final de la obligatoriedad de velocidad mínima vendrá establecido por la señal S-52 o R-506.', 55.00, 52, '0', '2025-02-28 16:14:53', '210.svg'),
(211, 9, 'S-51 Carril reservado para autobuses', 'Indica la prohibición a los conductores de los vehículos que no sean de transporte colectivo de circular por el carril indicado. La mención taxi autoriza también a los taxis la utilización de este carril. En los tramos en que la marca blanca longitudinal esté constituida, en el lado exterior de este carril, por una línea discontinua, se permite su utilización general exclusivamente para realizar alguna maniobra que no sea la de parar, estacionar, cambiar el sentido de la marcha o adelantar, dejando siempre preferencia a los autobuses y, en su caso, a los taxis.', 40.00, 13, '0', '2025-02-28 16:15:22', '211.svg'),
(212, 9, 'S-52 Final de carril destinado a la circulación', 'Preseñaliza, en una calzada de doble sentido de circulación, el carril que va a cesar de ser utilizable, e indica el cambio de carril preciso.', 60.00, 11, '96', '2025-02-28 16:15:40', '212.svg'),
(213, 9, 'S-52b Final de carril destinado a la circulación', 'Preseñaliza, en una calzada de doble sentido de circulación, el carril que va a cesar de ser utilizable, e indica el cambio de carril preciso.', 60.00, 17, '0', '2025-02-28 16:16:03', '213.svg'),
(214, 9, 'S-53 Paso de uno a dos carriles de circulación', 'Indica, en un tramo con un solo carril en un sentido de circulación, que en el próximo tramo se va a pasar a disponer de dos carriles en el mismo sentido de la circulación.', 60.00, 0, '0', '2025-02-28 16:16:38', '214.svg'),
(215, 9, 'S-53b Paso de dos a tres carriles de circulación', 'Indica, en un tramo con dos carriles en un sentido de circulación, que en el próximo tramo se va a pasar a disponer de tres carriles en el mismo sentido de circulación.', 60.00, 11, '0', '2025-02-28 16:17:07', '215.svg'),
(216, 9, 'S-60a Bifurcación hacia la izquierda en calzada de dos carriles', 'Indica, en una calzada de dos carriles de circulación en el mismo sentido, que en el próximo tramo el carril de la izquierda se bifurcará hacia ese mismo lado.', 60.00, 99, '0', '2025-02-28 16:17:54', '216.svg'),
(217, 9, 'S-60b Bifurcación hacia la derecha en calzada de dos carriles', 'Indica, en una calzada de dos carriles de circulación en el mismo sentido, que en el próximo tramo el carril de la derecha se bifurcará hacia ese mismo lado.', 60.00, 57, '0', '2025-02-28 16:19:47', '217.svg'),
(218, 9, 'S-61a Bifurcación hacia la izquierda en calzada de tres carriles', 'Indica, en una calzada de tres carriles de circulación en el mismo sentido, que en el próximo tramo el carril de la izquierda se bifurcará hacia ese mismo lado.', 75.00, 91, '0', '2025-02-28 16:20:45', '218.svg'),
(219, 9, 'S-61b Bifurcación hacia la derecha en calzada de tres carriles', 'Indica, en una calzada de tres carriles de circulación en el mismo sentido, que en el próximo tramo el carril de la derecha se bifurcará hacia ese mismo lado.', 75.00, 80, '0', '2025-02-28 16:21:40', '219.svg'),
(220, 9, 'S-61c Doble bifurcación hacia la derecha en calzada de tres carriles', 'Indica, en una calzada de tres carriles de circulación en el mismo sentido, que en el próximo tramo los carriles derecho y central se bifurcarán hacia la derecha.', 75.00, 29, '0', '2025-02-28 16:22:17', '220.svg'),
(221, 9, 'S-62a Bifurcación hacia la izquierda en calzada de cuatro carriles', 'Indica, en una calzada de cuatro carriles de circulación en el mismo sentido, que en el próximo tramo el carril de la izquierda se bifurcará hacia ese mismo lado.', 80.00, 6, '8', '2025-02-28 16:25:49', '221.svg'),
(222, 9, 'S-62b Bifurcación hacia la derecha en calzada de cuatro carriles', 'Indica, en una calzada de cuatro carriles de circulación en el mismo sentido, que en el próximo tramo el carril de la derecha se bifurcará hacia ese mismo lado.', 80.00, 46, '0', '2025-02-28 16:27:16', '222.svg'),
(223, 9, 'S-62c Doble bifurcación en calzada de cuatro carriles', 'Indica, en una calzada con cuatro carriles de circulación en el mismo sentido, que en el próximo tramo los dos carriles de la derecha se bifurcarán hacia ese mismo lado.', 80.00, 10, '0', '2025-02-28 16:27:49', '223.svg'),
(224, 9, 'S-63 Bifurcación en calzada de cuatro carriles', 'Indica, en una calzada con cuatro carriles de circulación en el mismo sentido, que en el próximo tramo los dos carriles de la izquierda se bifurcarán hacia la izquierda y los dos de la derecha hacia la derecha.', 80.00, 14, '0', '2025-02-28 16:28:15', '224.svg'),
(225, 9, 'S-64 Carril bici o vía ciclista adosada a la calzada', 'Indica que el carril sobre el que está situada la señal de vía ciclista solo puede ser utilizado por ciclos. Las flechas indicarán el número de carriles de la calzada, así como su sentido de la circulación.', 75.00, 38, '75', '2025-02-28 16:29:48', '225.svg'),
(226, 9, 'S-64a Carril bici o vía ciclista adosada a la calzada', 'Indica que el carril sobre el que está situada la señal de vía ciclista solo puede ser utilizado por ciclos. Las flechas indicarán el número de carriles de la calzada, así como su sentido de la circulación.\r\nEsta señal no aparece reflejada en el BOE.', 75.00, 0, '28', '2025-02-28 16:30:32', '226.svg'),
(227, 10, 'S-100 Puesto de socorro', 'Indica la situación de un centro, oficialmente reconocido, donde puede realizarse una cura de urgencia.', 50.00, 0, '56', '2025-02-28 16:31:30', '227.svg'),
(228, 10, 'S-101 Base de ambulancia', 'Indica la situación de una ambulancia en servicio permanente para cura y traslado de heridos en accidentes de circulación.', 55.00, 27, '0', '2025-02-28 16:32:28', '228.svg'),
(229, 10, 'S-102 Servicio de inspección técnica de vehículos', 'Indica la situación de una estación de inspección técnica de vehículos.', 50.00, 31, '36', '2025-02-28 16:33:08', '229.svg'),
(230, 10, 'S-103 Taller de reparación', 'Indica la situación de un taller de reparación de automóviles.', 50.00, 74, '54', '2025-02-28 16:33:50', '230.svg'),
(231, 10, 'S-104 Teléfono', 'Indica la situación de un aparato telefónico.', 50.00, 74, '0', '2025-02-28 16:34:17', '231.svg'),
(232, 10, 'S-105 Surtidor de carburante', 'Indica la situación de un surtidor o estación de servicio de carburante.', 50.00, 47, '32', '2025-02-28 16:34:39', '232.svg'),
(233, 10, 'S-106 Taller de reparación y surtidor de carburante', 'Indica la situación de una instalación que dispone de taller de reparación y surtidor de carburante.', 50.00, 0, '0', '2025-02-28 16:35:01', '233.svg'),
(234, 10, 'S-107 Campamento', 'Indica la situación de un lugar (campamento) donde puede acamparse.', 50.00, 33, '99', '2025-02-28 16:35:42', '234.svg'),
(235, 10, 'S-108 Agua', 'Indica la situación de una fuente con agua.', 50.00, 22, '0', '2025-02-28 16:36:38', '235.svg'),
(236, 10, 'S-109 Lugar pintoresco', 'Indica un sitio pintoresco o el lugar desde el que se divisa.', 50.00, 9, '0', '2025-02-28 16:37:00', '236.svg'),
(237, 10, 'S-110 Hotel o motel', 'Indica la situación de un hotel o motel.', 50.00, 80, '51', '2025-02-28 16:37:26', '237.svg'),
(238, 10, 'S-111 Restauración', 'Indica la situación de un restaurante.', 50.00, 74, '65', '2025-02-28 16:37:55', '238.svg'),
(239, 10, 'S-112 Cafetería', 'Indica la situación de un bar o cafetería.', 50.00, 26, '0', '2025-02-28 16:39:22', '239.svg'),
(240, 10, 'S-113 Terreno para remolques-vivienda', 'Indica la situación de un terreno en el que puede acamparse con remolque-vivienda (caravana).', 50.00, 11, '0', '2025-02-28 16:39:49', '240.svg'),
(241, 10, 'S-114 Merendero', 'Indica el lugar que puede utilizarse para el consumo de comidas o bebidas.', 50.00, 80, '5', '2025-02-28 16:40:16', '241.svg'),
(242, 10, 'S-115 Punto de partida para excursiones a pie', 'Indica un lugar apropiado para iniciar excursiones a pie.', 50.00, 65, '21', '2025-02-28 16:40:38', '242.svg'),
(243, 10, 'S-116 Campamento y terreno para remolques-vivienda', 'Indica la situación de un lugar donde puede acamparse con tienda de campaña o con remolque-vivienda.', 50.00, 86, '0', '2025-02-28 16:41:43', '243.svg'),
(244, 10, 'S-117 Albergue de juventud', 'Indica la situación de un albergue cuya utilización está reservada a organizaciones juveniles.', 50.00, 33, '0', '2025-02-28 16:42:04', '244.svg'),
(245, 10, 'S-118 Información turística', 'Indica la situación de una oficina de información turística.', 50.00, 6, '72', '2025-02-28 16:42:58', '245.svg'),
(246, 10, 'S-119 Coto de pesca', 'Indica un tramo del río o lago en el que la pesca está sujeta a autorización especial.', 50.00, 34, '0', '2025-02-28 16:43:45', '246.svg'),
(247, 10, 'S-120 Parque nacional', 'Indica la situación de un parque nacional cuyo nombre figura inscrito.', 50.00, 51, '56', '2025-02-28 16:44:09', '247.svg'),
(248, 10, 'S-121 Monumento', 'Indica la situación de una obra histórica o artística declarada monumento.', 50.00, 52, '32', '2025-02-28 16:47:10', '248.svg'),
(249, 10, 'S-122 Otros servicios', 'Señal genérica para cualquier otro servicio, que se inscribirá en el recuadro blanco.', 50.00, 0, '0', '2025-02-28 16:47:38', '249.svg'),
(250, 10, 'S-123 Área de descanso', 'Indica la situación de un área de descanso.', 50.00, 82, '19', '2025-02-28 16:48:07', '250.svg'),
(251, 10, 'S-124 Estacionamiento para usuarios del ferrocarril', 'Indica la situación de una zona de estacionamiento conectada con una estación de ferrocarril y destinada principalmente para los vehículos de los usuarios que realizan una parte de su viaje en vehículo privado y la otra en ferrocarril.', 50.00, 87, '0', '2025-02-28 16:48:45', '251.svg'),
(252, 10, 'S-125 Estacionamiento para usuarios del ferrocarril inferior', 'Indica la situación de una zona de estacionamiento conectada con una estación de ferrocarril inferior y destinada principalmente para los vehículos de los usuarios que realizan una parte de su viaje en vehículo privado y la otra en ferrocarril inferior.', 50.00, 87, '0', '2025-02-28 16:49:06', '252.svg'),
(253, 10, 'S-126 Estacionamiento para usuarios del autobús', 'Indica la situación de una zona de estacionamiento conectada con una estación o una terminal de autobuses y destinada principalmente para los vehículos privados de los usuarios que realizan una parte de su viaje en vehículo privado y la otra en autobús.', 50.00, 75, '60', '2025-02-28 16:49:29', '253.svg'),
(254, 10, 'S-127 Área de servicio', 'Indica en autopista o autovía la situación de un área de servicio.', 110.00, 14, '0', '2025-02-28 16:50:14', '254.svg'),
(255, 11, 'S-200 Preseñalización de glorieta', 'Indica las direcciones de las distintas salidas de la próxima glorieta. Si alguna inscripción figura sobre fondo azul, indica que la salida conduce hacia una autopista o autovía.', 90.00, 48, '0', '2025-02-28 16:51:29', '255.svg'),
(256, 11, 'S-220 Preseñalización de direcciones hacia una carretera convencional', 'Indica, en una carretera convencional, las direcciones de los distintos ramales de la próxima intersección cuando uno de ellos conduce a una carretera convencional.', 90.00, 96, '0', '2025-02-28 16:52:40', '256.svg'),
(257, 11, 'S-222 Preseñalización de direcciones hacia una autopista o autovía', 'Indica, en una carretera convencional, las direcciones de los distintos ramales de la próxima intersección cuando uno de ellos conduce a una autopista o una autovía.', 85.00, 34, '0', '2025-02-28 16:54:02', '257.svg'),
(258, 11, 'S-222a Preseñalización de direcciones hacia una autopista o autovía y dirección propia', 'Indica, en una carretera convencional, las direcciones de los distintos ramales de la próxima intersección cuando uno de ellos conduce a una autopista o una autovía. También indica la dirección propia de la carretera convencional.', 100.00, 85, '0', '2025-02-28 16:54:44', '258.svg'),
(259, 11, 'S-225 Preseñalización de direcciones en una autopista o una autovía hacia cualquier carretera', 'Indica en una autopista o en una autovía las direcciones de los distintos ramales en la próxima intersección. También indica la distancia, el número y, en su caso, la letra del enlace y ramal.', 100.00, 19, '0', '2025-02-28 16:55:44', '259.svg'),
(260, 11, 'S-230 Preseñalización con señales sobre la calzada en carretera convencional hacia carretera convencional', 'Indica las direcciones del ramal de la próxima salida y la distancia a la que se encuentra.', 80.00, 45, '0', '2025-02-28 22:05:09', '260.svg'),
(261, 11, 'S-230a Preseñalización con señales sobre la calzada en carretera convencional hacia carretera convencional y dirección propia', 'Indica las direcciones del ramal de la próxima salida y la distancia a la que se encuentra. También indica la dirección propia de la carretera convencional.', 175.00, 67, '95', '2025-02-28 22:06:04', '261.svg'),
(262, 11, 'S-232 Preseñalización con señales sobre la calzada en carretera convencional hacia autopista o autovía', 'Indica las direcciones del ramal de la próxima salida y la distancia a la que se encuentra.', 90.00, 0, '0', '2025-02-28 22:05:51', '262.svg'),
(263, 11, 'S-232a Preseñalización con señales sobre la calzada en carretera convencional hacia autopista o autovía y dirección propia', 'Indica las direcciones del ramal de la próxima salida y la distancia a la que se encuentra. También indica la dirección propia de la carretera convencional.', 195.00, 100, '0', '2025-02-28 22:06:28', '263.svg'),
(264, 11, 'S-235 Preseñalización con señales sobre la calzada en autopista o autovía hacia cualquier carretera', 'Indica las direcciones del ramal de la próxima salida, la distancia a la que se encuentra y el número del enlace.', 105.00, 98, '0', '2025-02-28 17:00:59', '264.svg'),
(265, 11, 'S-235a Preseñalización con señales sobre la calzada en autopista o autovía hacia cualquier carretera', 'Indica las direcciones del ramal de la próxima salida, la distancia a la que se encuentra y el número del enlace. También indica la dirección propia de la autopista o autovía.', 200.00, 91, '0', '2025-02-28 17:01:49', '265.svg'),
(266, 11, 'S-242 Preseñalización en autopista o autovía de dos salidas muy próximas hacia cualquier carretera', 'Indica las direcciones de los ramales de las dos salidas consecutivas de la autopista o autovía, la distancia, el número del enlace y la letra de cada salida.', 100.00, 0, '0', '2025-02-28 17:02:21', '266.svg'),
(267, 11, 'S-242a Preseñalización en autopista o autovía de dos salidas muy próximas hacia cualquier carretera ', 'Preseñalización en autopista o autovía de dos salidas muy próximas hacia cualquier carretera y dirección propia', 210.00, 15, '55', '2025-02-28 17:56:46', '267.svg'),
(268, 11, 'S-250 Preseñalización de itinerario', 'Indica el itinerario que es preciso seguir para tomar la dirección que señala la flecha.', 55.00, 5, '0', '2025-02-28 17:57:32', '268.svg'),
(269, 11, 'S-260 Preseñalización de carriles', 'Indica las únicas direcciones permitidas, en la próxima intersección, a los usuarios que circulan por los carriles señalados.', 50.00, 81, '0', '2025-02-28 17:59:02', '269.svg'),
(270, 11, 'S-261 Preseñalización en carretera convencional de zona o área de servicio', 'Indica, en una carretera convencional, la proximidad de una salida hacia una zona o área de servicio.', 85.00, 89, '0', '2025-02-28 18:00:05', '270.svg'),
(271, 11, 'S-261 Preseñalización en carretera convencional de zona o área de servicio', 'Según la norma 8.1-IC de Instrucción de Carreteras de 2014, se añade un panel inferior, con indicaciones para la próxima estación de servicio, en carretera convencional con IMD ≥10.000 y porcentaje de vehículos pesados ≥20% y carreteras convencionales desdobladas.', 95.00, 0, '0', '2025-02-28 18:01:17', '271.svg'),
(272, 11, 'S-263 Preseñalización en autopista o autovía de una zona o área de servicios con salida compartida', 'Indica, en autopista o autovía, la proximidad de una salida hacia una zona o área de servicio, y que esta coincide con una salida hacia una o varias poblaciones.', 110.00, 32, '0', '2025-02-28 22:06:58', '272.svg'),
(273, 11, 'S-263a Preseñalización en autopista o autovía de una zona o área de servicios con salida exclusiva', 'Indica, en autopista o autovía, la proximidad de una salida hacia una zona o área de servicio.', 110.00, 62, '0', '2025-02-28 18:08:03', '273.svg'),
(274, 11, 'S-264 Preseñalización en carretera convencional de una vía de servicio', 'Indica, en carretera convencional, la proximidad de una salida hacia una vía de servicio desde la que puede accederse a los servicios indicados.', 90.00, 13, '55', '2025-02-28 18:08:38', '274.svg'),
(275, 11, 'S-264 Preseñalización en carretera convencional de una vía de servicio', 'Según la norma 8.1-IC de Instrucción de Carreteras de 2014, se añade un panel inferior, con indicaciones para la próxima estación de servicio, en carretera convencional con IMD ≥10.000 y porcentaje de vehículos pesados ≥20% y carreteras convencionales desdobladas.', 95.00, 80, '0', '2025-02-28 18:09:36', '275.svg'),
(276, 11, 'S-266 Preseñalización en autopista o autovía de una vía de servicio, con salida compartida', 'Indica, en autopista o autovía, la proximidad de una salida hacia una vía de servicio desde la que puede accederse a los servicios indicados, y que esta coincide con una salida hacia una o varias poblaciones.', 100.00, 61, '0', '2025-02-28 18:10:26', '276.svg'),
(277, 11, 'S-266 Preseñalización en autopista o autovía de una vía de servicio, con salida compartida', 'Según la norma 8.1-IC de Instrucción de Carreteras de 2014, se señalizarán independientemente las poblaciones y los servicios, de forma que en ambos carteles se incluya la inscripción “vía de servicio”.', 90.00, 64, '46', '2025-02-28 18:11:14', '277.svg'),
(278, 11, 'S-266a Preseñalización en autopista o autovía de una vía de servicio, con salida exclusiva', 'Indica, en autopista o autovía, la proximidad de una salida hacia una vía de servicio desde la que puede accederse a los servicios indicados.', 100.00, 0, '0', '2025-02-28 18:11:40', '278.svg'),
(279, 11, 'S-270 Preseñalización de dos salidas muy próximas', 'Indica la proximidad de dos salidas consecutivas entre las que, por carecer de distancia suficiente entre sí, no es posible instalar otras señales de orientación individualizadas para cada salida. Las letras o, en su caso, los números corresponden a los de las señales de preseñalización inmediatamente anteriores.', 60.00, 1, '0', '2025-02-28 18:12:05', '279.svg'),
(280, 11, 'S-271 Preseñalización de área de servicio', 'Indica, en autopista o autovía, la salida hacia un área de servicio.', 95.00, 91, '0', '2025-02-28 18:12:50', '280.svg'),
(281, 12, 'S-300 Poblaciones de un itinerario por carretera convencional', 'Indica nombres de poblaciones situadas en un itinerario constituido por una carretera convencional y el sentido por el que aquellas se alcanzan. El cajetín situado dentro de la señal define la categoría y número de la carretera. Las cifras inscritas dentro de la señal indican la distancia en kilómetros.', 47.50, 48, '97', '2025-02-28 18:19:38', '281.png'),
(282, 12, 'S-301 Poblaciones en un itinerario por autopista o autovía', 'Indica nombres de poblaciones situadas en un itinerario constituido por una autopista o autovía y el sentido por el que aquellas se alcanzan. El cajetín situado dentro de la señal define la categoría y número de la carretera. Las cifras inscritas dentro de la señal indican la distancia en kilómetros.', 55.55, 70, '0', '2025-02-28 18:20:03', '282.png'),
(283, 12, 'S-310 Poblaciones de varios itinerarios', 'Indica carreteras y poblaciones que se alcanzan en el sentido que indica la flecha.', 52.50, 4, '0', '2025-02-28 18:20:44', '283.png'),
(284, 12, 'S-320 Lugares de interés por carretera convencional', 'Indica lugares de interés general que no son poblaciones situados en un itinerario constituido por una carretera convencional. Las cifras inscritas dentro de la señal indican la distancia en kilómetros.', 37.50, 12, '0', '2025-02-28 18:21:15', '284.png'),
(285, 12, 'S-321 Lugares de interés por autopista o autovía', 'Indica lugares de interés que no son poblaciones situados en un itinerario constituido por una autopista o autovía. Las cifras inscritas dentro de la señal indican la distancia en kilómetros.', 42.40, 49, '69', '2025-02-28 18:36:33', '285.png'),
(286, 12, 'S-322 Señal de destino hacia una vía ciclista o senda ciclable', 'Indica la existencia en la dirección apuntada por la flecha de una vía ciclista o senda ciclable. Las cifras escritas dentro de la señal indican la distancia en kilómetros.', 38.00, 7, '0', '2025-02-28 18:22:21', '286.png'),
(287, 12, 'S-341 Señales de destino de salida inmediata hacia carretera convencional', 'Indica el lugar de salida de una autopista o autovía hacia una carretera convencional. La cifra indica el número del enlace.', 50.00, 92, '0', '2025-02-28 18:23:01', '287.png'),
(288, 12, 'S-342 Señales de destino de salida inmediata hacia autopista o autovía', 'Indica el lugar de salida de una autopista o autovía hacia una autopista o autovía. La cifra indica el número del enlace.', 57.00, 34, '0', '2025-02-28 18:29:02', '288.png'),
(289, 12, 'S-344 Señales de destino de salida inmediata hacia una zona, área o vía de servicios', 'Indica el lugar de salida de cualquier carretera hacia una zona, área o vía de servicios.', 45.00, 99, '0', '2025-02-28 18:30:47', '289.png'),
(290, 12, 'S-347 Señales de destino de salida inmediata hacia una zona, área o vía de servicios, con salida compartida hacia una autopista o autovía', 'Indica el lugar de salida de cualquier carretera hacia una zona, área o vía de servicios, siendo esta coincidente con una salida hacia una autopista o autovía.', 55.00, 87, '0', '2025-02-28 22:07:31', '290.png'),
(291, 12, 'S-348 Señal de destino en desvío', 'Indica que por el itinerario provisional de desvío y en el sentido indicado por la flecha se alcanza un determinado destino.', 44.00, 0, '0', '2025-02-28 18:32:40', '291.png'),
(292, 12, 'S-348b Señal variable de destino', 'Indica que en el sentido apuntado por la flecha se alcanza el destino que aparece en la señal.', 15.00, 36, '32', '2025-02-28 18:33:23', '292.png'),
(293, 12, 'S-350 Señal sobre la calzada, en carretera convencional. Salida inmediata hacia carretera convencional', 'Indica, en la carretera convencional, en el lugar en que se inicia el ramal de salida, las direcciones que se alcanzan por la salida inmediata por una carretera convencional y, en su caso, el número de esta.', 65.00, 62, '12', '2025-02-28 22:07:45', '293.png'),
(294, 12, 'S-351 Señal sobre la calzada en autopista y autovía. Salida inmediata hacia carretera convencional', 'Indica, en autopista y autovía, en el lugar en que se inicia el ramal de salida de cualquier carretera, las direcciones que se alcanzan por la salida inmediata por una carretera convencional y, en su caso, el número de esta. También indica el número y, en su caso, la letra del enlace y ramal.', 75.00, 2, '0', '2025-02-28 18:36:25', '294.svg'),
(295, 12, 'S-354 Señal sobre la calzada, en carretera convencional. Salida inmediata hacia autopista o autovía', 'Indica, en el lugar en que se inicia el ramal de salida, las direcciones que se alcanzan por la salida inmediata por una autopista o una autovía y, en su caso el número de estas.', 85.00, 28, '0', '2025-02-28 18:36:17', '295.svg'),
(296, 12, 'S-355 Señal sobre la calzada, en autopista, autovía y vía rápida. Salida inmediata hacia autopista o autovía', 'Indica, en el lugar en que se inicia el ramal de salida, las direcciones que se alcanzan por la salida inmediata por una autopista o una autovía y, en su caso, el número de estas. También indica el número y, en su caso, letra, del enlace y ramal.', 95.00, 32, '0', '2025-02-28 22:08:04', '296.svg'),
(297, 12, 'S-360 Señales sobre la calzada en carretera convencional. Salida inmediata hacia carretera convencional y dirección propia', 'Indica, en una carretera convencional, las direcciones que se alcanzan por la salida inmediata hacia otra carretera convencional. También indica la dirección propia de la carretera convencional y su número.', 160.00, 76, '0', '2025-02-28 22:09:07', '297.svg'),
(298, 12, 'S-362 Señales sobre la calzada en carretera convencional. Salida inmediata hacia autopista o autovía y dirección propia', 'Indica, en una carretera convencional, las direcciones que se alcanzan por la salida inmediata hacia una autopista o una autovía. También indica la dirección propia de la carretera convencional.', 175.00, 81, '0', '2025-02-28 22:09:24', '298.svg'),
(299, 12, 'S-366 Señales sobre la calzada en autopista o autovía. Salida inmediata hacia carretera convencional y dirección propia', 'Indica, en una autopista o una autovía, las direcciones que se alcanzan por la salida inmediata hacia una carretera convencional, así como el número del enlace y, en su caso, la letra del ramal. También indica la dirección propia de la autopista o la autovía.', 185.00, 77, '0', '2025-02-28 22:10:11', '299.svg'),
(300, 12, 'S-368 Señales sobre la calzada en autopista o autovía. Salida hacia autopista o autovía y dirección propia', 'Indica, en una autopista o una autovía, las direcciones que se alcanzan por la salida inmediata hacia una autopista o una autovía, así como el número del enlace y, en su caso, la letra del ramal. También indica la dirección propia de la autopista o de la autovía.', 205.00, 44, '0', '2025-02-28 22:10:26', '300.svg'),
(301, 12, 'S-373 Señales sobre la calzada en autopista o autovía. Dos salidas inmediatas muy próximas hacia carretera convencional y dirección propia', 'Indica las direcciones de los ramales de las dos salidas consecutivas de la autopista o autovía. La distancia de la segunda, el número del enlace y la letra de cada salida. También indica la dirección propia de la autopista o autovía.', 280.00, 88, '6', '2025-02-28 22:10:48', '301.svg'),
(302, 12, 'S-375 Señales sobre la calzada en autopista o autovía. Dos salidas inmediatas muy próximas hacia autopista o autovía y dirección propia', 'Indica las direcciones de los ramales de las dos salidas consecutivas de la autopista o autovía, la distancia de la segunda, el número del enlace y la letra de cada salida. También indica la dirección propia de la autopista o autovía.', 305.00, 8, '36', '2025-02-28 22:10:59', '302.svg'),
(303, 13, 'S-400 Itinerario Europeo', 'Identifica un itinerario de la Red Europea.', 10.00, 77, '0', '2025-02-28 18:43:57', '303.svg'),
(304, 13, 'S-410 Autopista o autovía', 'Identifica una autopista o autovía. Cuando esta es de ámbito autonómico, además de la letra A y a continuación del número correspondiente o bien encima de la señal con un panel complementario, pueden incluirse las siglas de identificación de la comunidad autónoma.\r\nNinguna carretera que no tenga características de autopista o autovía podrá ser identificada con la letra A.\r\n\r\nCuando la autopista o autovía es una ronda o circunvalación la letra A podrá sustituirse por las letras indicativas de la ciudad, de acuerdo con el código establecido al efecto por los Ministerios de Fomento e Interior.', 10.00, 59, '0', '2025-02-28 18:45:06', '304.svg'),
(305, 13, 'S-410 Autopista o autovía', 'Identifica una autopista o autovía. Cuando esta es de ámbito autonómico, además de la letra A y a continuación del número correspondiente o bien encima de la señal con un panel complementario, pueden incluirse las siglas de identificación de la comunidad autónoma.\r\nNinguna carretera que no tenga características de autopista o autovía podrá ser identificada con la letra A.\r\n\r\nCuando la autopista o autovía es una ronda o circunvalación la letra A podrá sustituirse por las letras indicativas de la ciudad, de acuerdo con el código establecido al efecto por los Ministerios de Fomento e Interior.', 10.00, 67, '0', '2025-02-28 18:45:31', '305.svg'),
(306, 13, 'S-410 Autopista o autovía', 'Identifica una autopista o autovía. Cuando esta es de ámbito autonómico, además de la letra A y a continuación del número correspondiente o bien encima de la señal con un panel complementario, pueden incluirse las siglas de identificación de la comunidad autónoma.\r\nNinguna carretera que no tenga características de autopista o autovía podrá ser identificada con la letra A.\r\n\r\nCuando la autopista o autovía es una ronda o circunvalación la letra A podrá sustituirse por las letras indicativas de la ciudad, de acuerdo con el código establecido al efecto por los Ministerios de Fomento e Interior.', 10.00, 55, '0', '2025-02-28 18:46:12', '306.svg'),
(307, 13, 'S-410a Autopista de peaje', 'Identifica una autopista de peaje.', 10.00, 77, '0', '2025-02-28 18:46:57', '307.svg'),
(308, 13, 'S-420 Carretera de la red general del Estado', 'Identifica una carretera de la red general del Estado, que no sea autopista o autovía.', 10.00, 16, '40', '2025-02-28 18:47:37', '308.svg'),
(309, 13, 'S-430 Carretera autonómica de primer nivel', 'Identifica una carretera del primer nivel, que no sea autopista o autovía, de la red autonómica de la Comunidad Autónoma a la que corresponden las siglas de identificación.', 10.00, 52, '0', '2025-02-28 18:48:59', '309.svg'),
(310, 13, 'S-440 Carretera autonómica de segundo nivel', 'Identifica una carretera del segundo nivel, que no sea autopista o autovía, de la red autonómica de la Comunidad Autónoma a la que corresponden las siglas de identificación.', 10.00, 12, '0', '2025-02-28 18:49:22', '310.svg'),
(311, 13, 'S-450 Carretera autonómica de tercer nivel', 'Identifica una carretera del tercer nivel, que no sea autopista o autovía, de la red autonómica de la Comunidad Autónoma a la que corresponden las siglas de identificación.', 10.00, 0, '0', '2025-02-28 18:49:47', '311.svg'),
(312, 14, 'S-500 Entrada a población', 'Indica que se ha entrado en un poblado y que a partir de ese punto se aplican las normas de circulación en poblado.', 35.00, 88, '0', '2025-02-28 18:50:27', '312.svg'),
(313, 14, 'S-510 Salida de población', 'Indica que se ha salido de un poblado y que a partir de ese punto se dejan de aplicar las normas de circulación en poblado.', 35.00, 22, '17', '2025-02-28 18:50:54', '313.svg'),
(314, 14, 'S-520 Situación de punto característico de la vía', 'Indica un lugar de interés general en la vía.', 50.00, 48, '0', '2025-02-28 18:51:26', '314.png'),
(315, 14, 'S-540 Entrada a provincia', 'Indica que se ha entrado en otra provincia.', 70.00, 74, '0', '2025-02-28 18:52:01', '315.png'),
(316, 14, 'S-550 Entrada a comunidad autónoma', 'Indica que se ha entrado en otra comunidad autónoma, mostrando solo el nombre de la comunidad autónoma.', 80.00, 25, '0', '2025-02-28 18:52:37', '316.png'),
(317, 14, 'S-560 Entrada a comunidad autónoma', 'Indica que se ha entrado en otra comunidad autónoma, mostrando el nombre de la comunidad autónoma y el de la provincia.', 100.00, 2, '0', '2025-02-28 21:45:55', '317.svg'),
(318, 14, 'S-570 Hito kilométrico en autopista y autovía', 'Indica el punto kilométrico de la autopista o autovía cuya identificación aparece en la parte superior.', 50.00, 39, '85', '2025-02-28 18:57:32', '318.png'),
(319, 14, 'S-570a Hito kilométrico en autopista de peaje', 'Indica el punto kilométrico de la autopista de peaje cuya identificación aparece en la parte superior.', 50.00, 89, '0', '2025-02-28 18:58:12', '319.png'),
(320, 14, 'S-571 Hito kilométrico en autopista y autovía que, además, forma parte de un itinerario europeo', 'Indica el punto kilométrico de la autopista o autovía que, además, forma parte de un itinerario europeo, cuya identificación aparece en la parte superior de la señal.', 55.00, 27, '0', '2025-02-28 19:24:25', '320.png'),
(321, 14, 'S-572 Hito kilométrico en carretera convencional', 'Indica el punto kilométrico de una carretera convencional cuya identificación aparece en la parte superior sobre el fondo del color que corresponda a la red de carreteras a la que pertenezca:\r\n\r\nROJO: carretera de la red general del Estado (ver señal S-420).\r\n\r\nNARANJA: carretera autonómica de primer nivel (ver señal S-430).\r\n\r\nVERDE: carretera autonómica de segundo nivel (ver señal S-440).\r\n\r\nAMARILLO: carretera autonómica de tercer nivel (ver señal S-450).', 50.00, 68, '0', '2025-02-28 19:24:40', '321.png'),
(322, 14, 'S-573 Hito kilométrico en Itinerario Europeo', 'Indica el punto kilométrico de una carretera convencional y que forma parte de un itinerario europeo, cuyas letras y números aparecen en la parte superior de la señal.\r\n\r\nROJO: carretera de la Red de Carreteras del Estado (ver señal S-420).\r\n\r\nNARANJA: carretera autonómica de primer nivel (ver señal S-430).', 55.00, 59, '0', '2025-02-28 19:26:56', '322.png'),
(323, 14, 'S-574 Hito miriamétrico en autopista o autovía', 'Indica el punto kilométrico de una autopista o autovía cuando aquel es múltiplo de 10.', 100.00, 92, '53', '2025-02-28 19:28:13', '323.png'),
(324, 14, 'S-574a Hito miriamétrico en carretera convencional', 'Indica el punto kilométrico de una carretera convencional cuando aquel es múltiplo de 10.', 100.00, 81, '0', '2025-02-28 19:28:45', '324.png'),
(325, 14, 'S-574b Hito miriamétrico en autopista de peaje', 'Indica el punto kilométrico de una autopista de peaje cuando aquel es múltiplo de 10.', 100.00, 29, '25', '2025-02-28 19:29:10', '325.png'),
(326, 14, 'S-575 Hito miriamétrico', 'Indica el punto kilométrico de una carretera, que no es autopista ni autovía, cuando aquel es múltiplo de 10.\r\nSu color se corresponderá con el de la red de la que forma parte dicha carretera:\r\n\r\nNARANJA: carretera autonómica de primer nivel (ver señal S-430).\r\n\r\nVERDE: carretera autonómica de segundo nivel (ver señal S-440).\r\n\r\nAMARILLO: carretera autonómica de tercer nivel (ver señal S-450).', 100.00, 4, '0', '2025-02-28 19:31:27', '326.png'),
(327, 15, 'S-600 Confirmación de poblaciones en un itinerario por carretera convencional', 'Indica, en carretera convencional, los nombres y distancias en kilómetros a las poblaciones expresadas.', 70.00, 0, '73', '2025-02-28 19:30:58', '327.svg'),
(328, 15, 'S-602 Confirmación de poblaciones en un itinerario por autovía o autopista', 'Indica, en autopista o autovía, los nombres y distancias en kilómetros a las poblaciones expresadas.', 75.00, 53, '0', '2025-02-28 19:31:20', '328.svg'),
(329, 16, 'S-700 Lugares de la red viaria urbana', 'Indica los nombres de calles, avenidas, plazas, glorietas o de cualquier otro punto de la red viaria.', 33.00, 64, '0', '2025-02-28 19:32:54', '329.jpg'),
(330, 16, 'S-710 Lugares de interés para viajeros', 'Indica los lugares de interés para los viajeros, tales como estaciones, aeropuertos, zonas de embarque de los puertos, hoteles, campamentos, oficinas de turismo y automóvil club.', 33.00, 63, '15', '2025-02-28 19:33:27', '330.jpg'),
(331, 16, 'S-720 Lugares de interés deportivo o recreativo', 'Indica los lugares en que predomina un interés deportivo o recreativo.', 33.00, 21, '80', '2025-02-28 19:34:05', '331.jpg'),
(332, 16, 'S-730 Lugares de carácter geográfico o ecológico', 'Indica los lugares de tipo geográfico o de interés ecológico.', 33.00, 17, '0', '2025-02-28 19:34:36', '332.jpg'),
(333, 16, 'S-740 Lugares de interés monumental o cultural', 'Indica los lugares de interés monumental, histórico, artístico o, en general, cultural.', 33.00, 21, '21', '2025-02-28 19:35:09', '333.jpg'),
(334, 16, 'S-750 Zonas de uso industrial', 'Indica las zonas de importante atracción de camiones, mercancías y, en general, tráfico industrial pesado.', 33.00, 0, '43', '2025-02-28 19:37:05', '334.jpg');
INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `precio`, `stock`, `oferta`, `fecha`, `imagen`) VALUES
(335, 16, 'S-760 Autopistas y autovías', 'Indica las autopistas y autovías y los lugares a los que por ellas puede accederse.', 33.00, 14, '19', '2025-02-28 19:37:24', '335.jpg'),
(336, 16, 'S-770 Otros lugares y vías', 'Indica las carreteras que no sean autopistas o autovías, los poblados a los que por ellas pueda accederse, así como otros lugares de interés público no comprendidos en las señales S-700 a S-760.', 33.00, 7, '0', '2025-02-28 19:53:35', '336.jpg'),
(337, 17, 'S-800 Distancia al comienzo del peligro o prescripción', 'Indica la distancia desde el lugar donde está la señal a aquel en que comienza el peligro o comienza a regir la prescripción de aquella. En el caso de que esté colocada bajo la señal de advertencia de peligro estrechamiento de calzada, puede indicar la anchura libre del citado estrechamiento.', 10.00, 91, '0', '2025-02-28 19:42:46', '337.png'),
(338, 17, 'S-810 Longitud del tramo peligroso o sujeto a prescripción', 'Indica la longitud en que existe el peligro o en que se aplica la prescripción.', 10.00, 33, '0', '2025-02-28 19:43:19', '338.png'),
(339, 17, 'S-821 Extensión de la prohibición, a un lado', 'Colocada bajo una señal de prohibición, indica la distancia en que se aplica esta prohibición en el sentido de la flecha.', 10.00, 0, '0', '2025-02-28 19:44:03', '339.png'),
(340, 17, 'S-830 Extensión de la prohibición, a ambos lados', 'Colocada bajo una señal de prohibición, indica las distancias en que se aplica esta prohibición en cada sentido indicado por las flechas.', 20.00, 61, '0', '2025-02-28 19:44:51', '340.png'),
(341, 17, 'S-840 Preseñalización STOP', 'Colocada bajo la señal de ceda el paso, indica la distancia a que se encuentra la señal detención obligatoria o stop de la próxima intersección.', 10.00, 28, '0', '2025-02-28 19:46:54', '341.png'),
(342, 17, 'S-850 Itinerario con prioridad', 'Panel adicional de la señal R-3, que indica el itinerario con prioridad.', 15.00, 58, '0', '2025-02-28 19:47:29', '342.png'),
(343, 17, 'S-851 Itinerario con prioridad', 'Panel adicional de la señal R-3, que indica el itinerario con prioridad.', 15.00, 3, '0', '2025-02-28 19:48:25', '343.png'),
(344, 17, 'S-852 Itinerario con prioridad', 'Panel adicional de la señal R-3, que indica el itinerario con prioridad.', 15.00, 46, '73', '2025-02-28 19:48:47', '344.png'),
(345, 17, 'S-853 Itinerario con prioridad', 'Panel adicional de la señal R-3, que indica el itinerario con prioridad.', 15.00, 17, '16', '2025-02-28 19:49:20', '345.png'),
(346, 17, 'S-860 Genérico', 'Panel para cualquier otra aclaración o delimitación de la señal o semáforo bajo el que esté colocado.', 10.00, 51, '0', '2025-02-28 19:50:01', '346.png'),
(347, 17, 'S-870 Aplicación de la señalización', 'Indica, bajo la señal de prohibición o prescripción, que la misma se refiere exclusivamente al ramal de salida cuya dirección coincide aproximadamente con la de la flecha.', 10.00, 4, '0', '2025-02-28 19:53:25', '347.png'),
(348, 17, 'S-880 Aplicación de señalización a determinados vehículos', 'Indica, bajo la señal, vertical correspondiente, que la señal se refiere exclusivamente a los vehículos que figuran en el panel, y que pueden ser camiones, vehículos con remolque, autobuses o ciclos.', 10.00, 67, '0', '2025-02-28 19:51:34', '348.png'),
(349, 17, 'S-890 Panel complementario de una señal vertical', 'Indica, bajo otra señal vertical, que esta se refiere a las circunstancias que se señalan en el panel como nieve, lluvia o niebla.', 10.00, 19, '77', '2025-02-28 19:53:03', '349.png'),
(350, 18, 'S-900 Peligro de incendio', 'Advierte del peligro que representa encender un fuego.', 45.00, 98, '0', '2025-02-28 19:54:13', '350.png'),
(351, 18, 'S-910 Extintor', 'Indica la situación de un extintor de incendios.', 20.00, 30, '0', '2025-02-28 19:54:51', '351.png'),
(352, 18, 'S-920 Entrada a España', 'Indica que se ha entrado en territorio español por una carretera procedente de otro país.', 100.00, 0, '0', '2025-02-28 19:55:26', '352.svg'),
(353, 18, 'S-930 Confirmación del país', 'Indica el nombre del país hacia el que se dirige la carretera. La cifra en la parte inferior indica la distancia a la que se encuentra la frontera.', 110.00, 94, '0', '2025-02-28 19:55:59', '353.svg'),
(354, 18, 'S-940 Limitaciones de velocidad en España', 'Señal de información de velocidad máxima en cada tipo de carretera. Esta señal se coloca en la entrada a territorio español por una carretera procedente de otro país o junto una aduana.', 130.00, 100, '76', '2025-02-28 20:07:49', '354.svg'),
(355, 18, 'S-950 Radiofrecuencia de emisoras específicas de información sobre carreteras', 'Indica la frecuencia a la que hay que conectar el receptor de radiofrecuencia para recibir información.', 55.00, 17, '18', '2025-02-28 20:08:29', '355.png'),
(356, 18, 'S-960 Teléfono de emergencia', 'Indica la situación de un teléfono de emergencia.', 25.00, 85, '0', '2025-02-28 20:08:50', '356.png'),
(357, 18, 'S-970 Apartadero', 'Indica la situación de un apartadero de un extintor de incendios y teléfono de emergencia.', 23.00, 75, '0', '2025-02-28 20:11:47', '357.png'),
(358, 18, 'S-980 Salida de emergencia', 'Indica la situación de una salida de emergencia.', 77.00, 0, '0', '2025-02-28 20:12:25', '358.png'),
(359, 18, 'S-990 Cartel flecha indicativa señal de emergencia en túneles', 'Indica la dirección y distancia a una salida de emergencia.', 88.00, 0, '0', '2025-02-28 20:12:50', '359.png'),
(360, 19, 'V-1 Vehículo prioritario', 'Indica que se trata de un vehículo de los servicios de policía, extinción de incendios, protección civil y salvamento, o de asistencia sanitaria, en servicio urgente, si se utiliza de forma simultánea con el aparato emisor de señales acústicas especiales, el cual se ajustará en cuanto a sus condiciones técnicas.', 42.00, 58, '62', '2025-02-28 20:38:54', '360.jpg'),
(361, 19, 'V-2 Vehículos para obras o servicios, tractores agrícolas, maquinaria agrícola automotriz, demás vehículos especiales, transportes especiales y columnas militares', 'Indica que se trata de un vehículo de esta clase, en servicio, o de un transporte especial o columna militar. Utilizarán una señal luminosa, denominada rotariva, cuando interrumpan u obstaculicen la circulación.', 60.00, 5, '71', '2025-02-28 22:12:22', '361.jpg'),
(362, 19, 'V-3 Vehículo policial', 'Señaliza un vehículo de esta clase en servicio no urgente. Estará constituida por una rotulación, reflectante o no, en los costados del vehículo, que incorpora la denominación del cuerpo policial y su imagen corporativa.', 1000.00, 51, '96', '2025-02-28 20:42:17', '362.jpg'),
(363, 19, 'V-4 Limitación de velocidad', 'Indica que el vehículo no debe circular a velocidad superior, en kilómetros por hora, a la cifra que figura en la señal. En la imagen la placa se encuentra arriba a la derecha.', 15.00, 39, '91', '2025-02-28 20:42:41', '363.jpg'),
(364, 19, 'V-5 Vehículo lento', 'Indica que se trata de un vehículo de motor o conjunto de vehículos, que, por construcción, no puede sobrepasar la velocidad de 40 kilómetros por hora.', 25.00, 43, '60', '2025-02-28 20:43:59', '364.jpg'),
(365, 19, 'V-6 Vehículo largo', 'Indica que el vehículo o conjunto de vehículos, tiene una longitud superior a 12 metros. Señal junto placa de matrícula.', 35.00, 100, '0', '2025-02-28 20:45:54', '365.jpg'),
(366, 19, 'V-7 Distintivo de nacionalidad española', 'Indica que el vehículo está matriculado en España. El distintivo &quot;E&quot;, es en relación con vehículos, el acrónimo que identifica a España.', 3.00, 69, '58', '2025-02-28 20:47:53', '366.svg'),
(367, 20, 'TP-1 Intersección con prioridad', '', 30.00, 42, '0', '2025-02-28 20:48:25', '367.svg'),
(368, 20, 'TP-1a Con prioridad sobre vía a la derecha', '', 30.00, 7, '0', '2025-02-28 20:48:47', '368.svg'),
(369, 20, 'TP-1b Con prioridad sobre vía a la izquierda', '', 30.00, 8, '51', '2025-02-28 20:49:14', '369.svg'),
(370, 20, 'TP-1c Con prioridad sobre incorporación por la derecha', '', 30.00, 22, '0', '2025-02-28 20:49:47', '370.svg'),
(371, 20, 'TP-1d Con prioridad sobre incorporación por la izquierda', '', 30.00, 86, '0', '2025-02-28 20:50:10', '371.svg'),
(372, 20, 'TP-2 Intersección con prioridad de la derecha', '', 30.00, 61, '0', '2025-02-28 20:50:40', '372.svg'),
(373, 20, 'TP-3 Semáforos', '', 30.00, 45, '0', '2025-02-28 20:50:55', '373.svg'),
(374, 20, 'TP-4 Intersección con circulación giratoria', '', 30.00, 46, '0', '2025-02-28 20:51:08', '374.svg'),
(375, 20, 'TP-13a Curva peligrosa hacia la derecha', '', 30.00, 95, '0', '2025-02-28 20:51:43', '375.svg'),
(376, 20, 'TP-13b Curva peligrosa hacia la izquierda', '', 30.00, 36, '0', '2025-02-28 20:52:02', '376.svg'),
(377, 20, 'TP-14a Curvas peligrosas hacia la derecha', '', 30.00, 94, '0', '2025-02-28 20:52:28', '377.svg'),
(378, 20, 'TP-14b Curvas peligrosas hacia la izquierda', '', 30.00, 63, '0', '2025-02-28 20:52:41', '378.svg'),
(379, 20, 'TP-15 Perfil irregular', '', 30.00, 32, '0', '2025-02-28 20:52:54', '379.svg'),
(380, 20, 'TP-15a Resalto', '', 30.00, 74, '0', '2025-02-28 20:53:08', '380.svg'),
(381, 20, 'TP-15b Badén', '', 30.00, 72, '8', '2025-02-28 20:53:26', '381.svg'),
(382, 20, 'TP-17 Estrechamiento de calzada', '', 30.00, 39, '28', '2025-02-28 20:54:24', '382.svg'),
(383, 20, 'TP-17a Estrechamiento de calzada por la derecha', '', 30.00, 78, '65', '2025-02-28 20:55:55', '383.svg'),
(384, 20, 'TP-17b Estrechamiento de calzada por la izquierda', '', 30.00, 74, '0', '2025-02-28 20:56:10', '384.svg'),
(385, 20, 'TP-18 Obras', '', 30.00, 36, '0', '2025-02-28 20:56:47', '385.svg'),
(386, 20, 'TP-19 Pavimento deslizante', '', 30.00, 58, '0', '2025-02-28 20:57:04', '386.svg'),
(387, 20, 'TP-25 Circulación en los dos sentidos', '', 30.00, 83, '43', '2025-02-28 20:57:25', '387.svg'),
(388, 20, 'TP-26 Desprendimiento', '', 30.00, 39, '0', '2025-02-28 20:57:38', '388.svg'),
(389, 20, 'TP-28 Proyección de gravilla', '', 30.00, 47, '0', '2025-02-28 20:57:51', '389.svg'),
(390, 20, 'TP-30 Escalón lateral', '', 30.00, 0, '0', '2025-02-28 20:58:17', '390.svg'),
(391, 20, 'TP-31 Congestión', '', 30.00, 0, '0', '2025-02-28 20:59:01', '391.svg'),
(392, 20, 'TP-50 Otros peligros', '', 30.00, 53, '0', '2025-02-28 20:59:24', '392.svg'),
(393, 20, 'TR-1 Ceda el paso', '', 30.00, 45, '0', '2025-02-28 21:00:21', '393.svg'),
(394, 20, 'TR-5 Prioridad al sentido contrario', '', 20.00, 68, '0', '2025-02-28 21:00:53', '394.svg'),
(395, 20, 'TR-106 Entrada prohibida a vehículos de transporte de mercancías', '', 20.00, 2, '0', '2025-02-28 21:01:13', '395.svg'),
(396, 20, 'TR-201 Limitación de peso', '', 20.00, 9, '12', '2025-02-28 21:11:35', '396.svg'),
(397, 20, 'TR-204 Limitación de ancho', '', 20.00, 40, '0', '2025-02-28 21:11:48', '397.svg'),
(398, 20, 'TR-205 Limitación de altura', '', 20.00, 70, '28', '2025-02-28 21:12:01', '398.svg'),
(399, 20, 'TR-302 Giro a la derecha prohibido', '', 20.00, 31, '0', '2025-02-28 21:12:14', '399.svg'),
(400, 20, 'TR-303 Giro a la izquierda prohibido', '', 20.00, 46, '0', '2025-02-28 21:12:35', '400.svg'),
(401, 20, 'TR-305 Adelantamiento prohibido', '', 20.00, 35, '67', '2025-02-28 21:12:57', '401.svg'),
(402, 20, 'TR-306 Adelantamiento prohibido a camiones', '', 20.00, 39, '0', '2025-02-28 21:13:08', '402.svg'),
(403, 20, 'TR-301-20 Prohibición velocidad máxima a 20 km/h', '', 20.00, 92, '33', '2025-02-28 21:13:50', '403.svg'),
(404, 20, 'TR-301-30 Prohibición velocidad máxima a 30 km/h', '', 20.00, 39, '0', '2025-02-28 21:14:06', '404.svg'),
(405, 20, 'TR-301-40 Prohibición velocidad máxima a 40 km/h', '', 20.00, 22, '0', '2025-02-28 21:14:19', '405.svg'),
(406, 20, 'TR-301-50 Prohibición velocidad máxima a 50 km/h', '', 20.00, 93, '66', '2025-02-28 21:14:34', '406.svg'),
(407, 20, 'TR-301-60 Prohibición velocidad máxima a 60 km/h', '', 20.00, 96, '0', '2025-02-28 21:14:48', '407.svg'),
(408, 20, 'TR-301-70 Prohibición velocidad máxima a 70 km/h', '', 20.00, 100, '0', '2025-02-28 21:15:07', '408.svg'),
(409, 20, 'TR-301-80 Prohibición velocidad máxima a 80 km/h', '', 20.00, 9, '17', '2025-02-28 21:15:22', '409.svg'),
(410, 20, 'TR-301-90 Prohibición velocidad máxima a 90 km/h', '', 20.00, 51, '0', '2025-02-28 21:15:37', '410.svg'),
(411, 20, 'TR-301-100 Prohibición velocidad máxima a 100 km/h', '', 20.00, 25, '0', '2025-02-28 21:15:53', '411.svg'),
(412, 20, 'TR-500 Fin de prohibiciones', '', 20.00, 75, '0', '2025-02-28 21:16:21', '412.svg'),
(413, 20, 'TS-52 Convergencia de un carril por la derecha (de 3 a 2)', '', 50.00, 97, '0', '2025-02-28 21:16:42', '413.svg'),
(414, 20, 'TS-53 Convergencia de un carril por la izquierda (de 3 a 2)', '', 50.00, 60, '0', '2025-02-28 21:16:55', '414.svg'),
(415, 20, 'TS-54 Convergencia de un carril por la derecha (de 2 a 1)', '', 50.00, 8, '0', '2025-02-28 21:17:16', '415.svg'),
(416, 20, 'TS-55 Convergencia de un carril por la izquierda (de 2 a 1)', '', 50.00, 65, '44', '2025-02-28 21:17:35', '416.svg'),
(417, 20, 'TS-60 Desvío de un carril por la calzada opuesta', '', 55.00, 96, '0', '2025-02-28 21:17:54', '417.svg'),
(418, 20, 'TS-61 Desvío de un carril por la calzada opuesta, manteniendo otro por la de obras', '', 55.00, 86, '0', '2025-02-28 21:18:14', '418.svg'),
(419, 20, 'TS-62 Desvío de dos carriles por la calzada opuesta', '', 55.00, 41, '0', '2025-02-28 21:18:44', '419.svg'),
(420, 20, 'TS-210 Croquis de desvío en obra', '', 65.00, 50, '0', '2025-02-28 21:19:07', '420.svg'),
(421, 20, 'TS-210b Croquis de desvío en obra', '', 66.00, 25, '48', '2025-02-28 21:19:27', '421.svg'),
(422, 20, 'TS-220 Preseñalización de direcciones', '', 70.00, 78, '0', '2025-02-28 21:19:51', '422.svg'),
(423, 20, 'TS-800', '', 15.00, 12, '0', '2025-02-28 21:20:55', '423.svg'),
(424, 20, 'TS-810', '', 17.89, 27, '0', '2025-02-28 21:21:47', '424.svg'),
(425, 21, 'TB-1 Panel direccional ancho', '', 65.00, 0, '0', '2025-02-28 21:24:29', '425.svg'),
(426, 21, 'TB-2 Panel direccional estrecho', '', 45.00, 10, '97', '2025-02-28 21:25:01', '426.svg'),
(427, 21, 'TB-3 Panel doble direccional ancho', '', 65.00, 0, '0', '2025-02-28 21:25:18', '427.svg'),
(428, 21, 'TB-4 Panel doble direccional estrecho', '', 45.00, 49, '0', '2025-02-28 21:25:43', '428.svg'),
(429, 21, 'TB-5 Panel de zona excluida al tráfico', '', 40.00, 76, '0', '2025-02-28 21:26:13', '429.svg'),
(430, 21, 'TB-6 Cono de tráfico', '', 25.00, 32, '93', '2025-02-28 21:30:15', '430.svg'),
(431, 21, 'TB-7 Piquete', '', 22.00, 34, '0', '2025-02-28 21:31:00', '431.svg'),
(432, 21, 'TB-8 Baliza de borde derecho', '', 40.00, 73, '0', '2025-02-28 21:31:38', '432.svg'),
(433, 21, 'TB-9 Baliza de borde izquierdo', '', 40.00, 63, '0', '2025-02-28 21:31:53', '433.svg'),
(434, 21, 'TB-10 Captafaro', '', 12.00, 98, '0', '2025-02-28 21:32:15', '434.svg'),
(435, 21, 'TB-11 Baliza luminosa y reflectante', '', 50.00, 97, '0', '2025-02-28 21:33:17', '435.svg'),
(436, 21, 'TB-12 Marca vial provisional', '', 1.00, 92, '0', '2025-02-28 21:33:34', '436.svg'),
(437, 21, 'Señal TB-13 Guirnalda', '', 7.00, 67, '0', '2025-02-28 21:34:08', '437.svg'),
(438, 21, 'Señal TB-14 Bastidor móvil', '', 150.00, 59, '80', '2025-02-28 21:34:50', '438.svg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(20) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `rol`, `imagen`) VALUES
(1, 'Admin', 'Admin', 'admin@admin.com', '$2y$04$vEcnurG9V5x9fPJIYw2zfeTBFdEnueZi2UcYyBOK1ghjl9EE2hkFW', 'admin', '1.png'),
(2, 'Alonso', 'Hernández Robles', 'alonso.ensibemol@gmail.com', '$2y$04$J/Q5vwYYc0FrlfDf1haToOUJZ/bzw.zYOY64gCri.k9Jhbqj.ofdG', 'user', '2.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_linea_pedido` (`pedido_id`),
  ADD KEY `fk_linea_producto` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedido_usuario` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_categoria` (`categoria_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=439;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD CONSTRAINT `fk_linea_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `fk_linea_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
