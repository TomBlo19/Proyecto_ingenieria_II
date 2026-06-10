-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2026 a las 19:55:24
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
-- Base de datos: `cocineritos`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizar_contador_votos_receta` (IN `p_id_receta` INT)   BEGIN

    DECLARE v_likes INT;
    DECLARE v_dislikes INT;

    SELECT COUNT(*)
    INTO v_likes
    FROM voto_receta
    WHERE id_receta = p_id_receta
    AND tipo_voto = 1;

    SELECT COUNT(*)
    INTO v_dislikes
    FROM voto_receta
    WHERE id_receta = p_id_receta
    AND tipo_voto = 0;

    UPDATE receta
    SET
        cant_likes = v_likes,
        cant_dislikes = v_dislikes
    WHERE id_receta = p_id_receta;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizar_contador_votos_resena` (IN `p_id_resena` INT)   BEGIN

    DECLARE v_likes INT;
    DECLARE v_dislikes INT;

    SELECT COUNT(*)
    INTO v_likes
    FROM voto_resena
    WHERE id_resena = p_id_resena
    AND tipo_voto = 1;

    SELECT COUNT(*)
    INTO v_dislikes
    FROM voto_resena
    WHERE id_resena = p_id_resena
    AND tipo_voto = 0;

    UPDATE resena
    SET
        cant_likes = v_likes,
        cant_dislikes = v_dislikes
    WHERE id_resena = p_id_resena;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_obtener_ranking_recetas` (IN `p_limite` INT)   BEGIN

    SELECT *
    FROM receta
    ORDER BY cant_likes DESC
    LIMIT p_limite;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_obtener_ranking_resenas` (IN `p_limite` INT)   BEGIN

    SELECT
        resena.*,
        receta.titulo_receta,
        receta.id_receta
    FROM resena
    INNER JOIN receta
        ON receta.id_receta = resena.id_receta
    ORDER BY resena.cant_likes DESC
    LIMIT p_limite;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'Rápidas'),
(2, 'Saludables'),
(3, 'Postres'),
(4, 'Pastas'),
(5, 'Carnes'),
(6, 'Bebidas'),
(7, 'Vegetarianas'),
(8, 'Desayunos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente`
--

CREATE TABLE `ingrediente` (
  `id_ingrediente` int(11) NOT NULL,
  `nombre_ingrediente` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ingrediente`
--

INSERT INTO `ingrediente` (`id_ingrediente`, `nombre_ingrediente`) VALUES
(1, '1/2 kilo de harina 000\r\n25 gramos de pan de levadura fresco\r\n1/2 cucharada de sal\r\n4 cucharadas de a'),
(2, '2 pechugas de pollo enteras'),
(3, 'Unas gotas de aceite de oliva virgen extra'),
(4, '10 Sal'),
(5, '12 pimientos del piquillo'),
(6, 'Perejil fresco'),
(7, 'Espaguetis'),
(8, 'Queso Pecorino Romano'),
(9, 'Pimienta negra sin moler'),
(10, 'Sal'),
(11, '1 taza de agua'),
(12, '1 harina'),
(13, '½ taza de avellanas tostadas'),
(14, '¾ taza de azúcar granulada'),
(15, '½ taza de aceite vegetal'),
(16, '4 hurvos'),
(17, 'Asado banderita: 500g'),
(18, 'Sal parrillera o entrefina'),
(19, 'Pimienta (opcional)\r\nAceite'),
(20, 'Chimichurri (opcional)'),
(21, 'Salsa Criolla'),
(22, 'Filetes de ternera fino y grande 1'),
(23, 'Huevo para el empanado 2'),
(24, 'Harina de trigo para el empanado'),
(25, 'Pan rallado para el empanado'),
(26, 'Mozzarella fresca 1'),
(27, 'Albahaca hojitas 4'),
(28, 'Pimienta negra molida'),
(29, 'Orégano seco al gusto'),
(30, 'Aceite de oliva para freír'),
(31, 'Salsa de tomate 30 ml'),
(32, 'Tapa de tarta con semillas 1'),
(33, 'Choclos 2 un. (o 2 latas de choclo entero)'),
(34, 'Cebolla 2 un'),
(35, 'Queso fresco 150 g'),
(36, 'Maicena 1 cda'),
(37, 'Leche c/n'),
(38, 'Simplot Harvest Fresh: Avocados: Pulpa de aguacate troceada a mano y congelada descongelado 1 taza'),
(39, 'Simplot RoastWorks :Combinación de maíz rostizado a la llama y jalapeños 1 taza'),
(40, 'Carne de res en adobo'),
(41, 'preparada 1 libra'),
(42, 'Hojas de cilantro frescas 1/2 taza'),
(43, 'Pimiento rojo 1 cada uno'),
(44, 'Arroz con cilantro 2 tazas'),
(45, 'Cebollas rojas en conserva'),
(46, 'preparadas\r\n\r\n1/4 taza\r\n\r\nCrema mexicana o crema agria\r\n\r\n1/4 taza\r\n\r\nSriracha o mayonesa picante (o'),
(47, '4 filetes de carne (de aproximadamente 1 cm de grosor)'),
(48, '1 taza de harina para empanar'),
(49, '2 o 3 huevos batidos'),
(50, 'Sal y pimienta a gusto'),
(51, '1 diente de ajo finamente picado (opcional)\r\n1 cucharada de perejil fresco picado (opcional)'),
(52, '1/2 cucharadita de pimentón dulce (opcional)'),
(53, 'Aceite para freír (suficiente para llenar la sartén hasta 2 cm de profundidad)'),
(54, 'Rodajas de limón para acompañar'),
(55, 'Tomate'),
(56, 'Oregano'),
(57, 'PAN'),
(58, 'CANE'),
(59, 'HUEVO'),
(60, '3.4.5.3'),
(61, 'harina'),
(62, 'azucar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta`
--

CREATE TABLE `receta` (
  `id_receta` int(11) NOT NULL,
  `titulo_receta` varchar(200) NOT NULL,
  `descripcion_receta` text NOT NULL,
  `imagen_receta` varchar(255) DEFAULT NULL,
  `fecha_receta` datetime DEFAULT current_timestamp(),
  `cant_likes` int(11) DEFAULT 0,
  `cant_dislikes` int(11) DEFAULT 0,
  `id_usuario` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `receta`
--

INSERT INTO `receta` (`id_receta`, `titulo_receta`, `descripcion_receta`, `imagen_receta`, `fecha_receta`, `cant_likes`, `cant_dislikes`, `id_usuario`, `id_categoria`) VALUES
(5, 'Hamburguesas', '1) ¡Es muy fácil!: lo primero es mezclar bien la carne picada con el chorizo, quitar el interior del chorizo y descartar la piel.\r\n2) Una vez hecho esto, agregar las cebollas y el ajo bien picados, la sal, la pimienta, el pimentón y el perejil, también picado. Ya verás el sabor que le da esta combinación de ajo y condimentos.\r\n3) Una vez integrado esto, agregar los dos huevos y unir bien con las manos. Se le puede agregar pan rallado (media taza, no más). Pero a mí estas proporciones me dan muy bien y la carne queda justo como quiero. El huevo es opcional. Comunmente las hamburguesas no llevan huevo. A mí me gusta como queda.\r\n4) Hacer las hamburguesas caseras. Pueden hacerse con molde. A mí me gustan hechas con la mano, que se vea que son caseras. Esta vez hice mini hamburguesas pero pueden hacerlas del tamaño que quieran.', '1776587932_a4c9eb92a9877dfd8685.jpg', '2026-04-19 05:38:52', 2, 0, 1, 1),
(6, 'pizza', 'Sin lugar a dudas, es una de las comidas más elegidas por los argentinos. Tanto como almuerzo, como para cena. Y hasta algunos, se animan a acompañarlo con un mate por la mañana. Una pizza suele ser uno de los alimentos más elegidos para un viernes o sábado por la noche y, en contextos más normales, para reuniones con amigos y familiares.\r\n\r\nPero, ante los altos precios, ¿cómo se hace pizza casera? Aquí en El Destape vas a encontrar una receta simple, económica y exitosa para no tener que gastar en delivery y poder disfrutar unas ricas pizzas. Incluso, fuera de la pandemia, también puede servirte para quedar bien frente a tus invitados.', '1776589410_a97a7ccaac45aea90f42.jpg', '2026-04-19 06:03:30', 0, 2, 1, 1),
(7, 'Pechugas de pollo', 'El pollo se puede cocinar de muchas maneras. Gracias a su versatilidad, es la base de multitud de recetas de todo tipo. Uno de los mejores recursos para cuando uno tiene prisa y quiere comer sano es la pechuga de pollo a la plancha. Lo único que tendremos que hacer es cortar la pechuga de pollo en filetes, aunque este paso nos lo podemos saltar si optamos por comprar una pechuga de pollo ya fileteada.\r\n\r\nRespecto al acompañamiento, podemos elegir el que más nos guste o tengamos en la despensa. Para esta receta, hemos optado por acompañar las pechugas de pollo con pimientos del piquillo a la plancha, que combinan estupendamente. Solo necesitaremos un par de minutos para prepararlos y conseguiremos un plato de lo más resultón.', '1776838476_547e6868ebfc0a9ff4eb.jpg', '2026-04-22 03:14:36', 0, 2, 1, 2),
(8, 'Espaguetis picantes', 'Cocemos la pasta siguiendo las instrucciones del fabricante. \r\nMientras la pasta se hace, rallamos el queso en una fuente grande. Añadimos un cazo del agua de la cocción. Removemos hasta tener una crema ligera. \r\nEchamos la pimienta y damos unas vueltas. Escurrimos los espaguetis y rápidamente los echamos en la fuente de la salsa. \r\n', '1776841899_cd1bd2612a113248f5ca.jpg', '2026-04-22 04:11:39', 0, 0, 1, 4),
(9, ' Torta maravilla de chocolate', 'Calienta el horno a 175°C / 350°F. Engrasa dos moldes redondos de 22 cm/ 9 inch. Coloca papel encerado en el fondo y vuélvelo a engrasar. Rocía con harina ambos moldes.\r\nEn un tazón grande, bate la harina del torta, agua, aceite y yemas de huevo, con batidora eléctrica a baja velocidad hasta que todo esté humedecido. Limpia los bordes del molde y sigue batiendo por dos minutos más a velocidad media. Vierte equitativamente la pasta en los dos moldes.\r\nEn otro tazón grande, bate las claras de huevo con batidora eléctrica, a velocidad media, hasta que estén esponjosas. Gradualmente, agrega la azúcar granulada, sin dejar de batir, a velocidad alta, hasta que se formen picos. Agrega las avellanas de manera envolvente. Coloca cucharadas de merengue sobre la pasta de cada molde y espárcelo con cuidado cubriendo el centro y dejando medio centímetro en las orillas', '1777062796_3da541a9c34448d70c23.jpg', '2026-04-24 17:33:16', 0, 0, 1, 3),
(10, 'Asado de ternera', '¡Hola, hola! Si hay algo que nos encanta, además de comer rico, es hablar de carne. Y hoy, mis amigos, nos vamos a meter con un corte que es un verdadero campeón: el asado banderita. \r\n\r\nPrepárense, porque les vamos a contar TODO lo que tienen que saber para que les salga espectacular, sea en la parrilla, al horno o hasta a la plancha. \r\n\r\nEste post es una guía definitiva para convertirse en expertos del asado banderita sin morir en el intento. ¿Listos? Arrancamos.', '1777335372_dc500a0a7e545be016b1.jpg', '2026-04-27 21:16:12', 2, 0, 1, 5),
(11, 'Milanesa', 'Receta fácil donde las haya, parte del encanto de esta milanesa está en que sea jugosa y crujiente a partes iguales, además de permitirnos hacer una cena fácil y rápida en cuestión de minutos y que gusta a toda la familia, con algunos ingredientes que podemos también modificar al gusto, como puede ser la salsa de tomate frito.', '1777627325_cc995a74fea1777a5b07.jpg', '2026-05-01 06:22:05', 0, 1, 1, 1),
(12, 'Tarta de choclo para hacer en poco tiempo', 'Paso a paso:\r\n\r\nPrecalentá el horno a 180/200 grados.\r\n\r\nDorá la cebolla cortada en cubitos con un toque de oliva.\r\n\r\nMezclá con el choclo ya cocido.\r\n\r\nAparte, disolvé la maicena en leche, condimentá y agregala a la sartén con las verduras.\r\n\r\nRevolvé sin parar hasta que tome consistencia.\r\n\r\nAgregá 1 huevo batido y el queso en trocitos.\r\n\r\nEstirá la tapa de tarta en el molde y rellená. Cociná en el horno por 30 minutos o hasta que los bordes estén dorados y el relleno firme\r\n\r\n', '1778050003_fe5b624098c5627ea789.jpg', '2026-05-06 03:46:43', 1, 0, 1, 7),
(13, 'Sushi', 'Instrucción de preparación:\r\nPaso 1\r\n\r\nDescongela el aguacate según las instrucciones del empaque.\r\n\r\nPaso 2\r\n\r\nPrepara el arroz y la mezcla de maíz y jalapeño de acuerdo con las instrucciones del empaque. Enfría y reserva por separado.\r\n\r\nPaso 3\r\n\r\nEsparce una esterilla de sushi sobre una superficie limpia. Coloca una hoja de nori brillante con el lado hacia abajo sobre la esterilla. Esparce una capa delgada y uniforme de arroz sobre el alga nori, dejando un borde de 1 pulgada en el extremo superior. Esparce una línea delgada de pulpa de aguacate horizontalmente a través del centro del arroz. Agrega una capa de mezcla de maíz y jalapeño, carne de res en adobo, pimiento rojo en juliana y hojas de cilantro fresco.\r\n\r\nPaso 4\r\n\r\nUsando la esterilla para sushi, enrolla cuidadosamente el nori sobre los rellenos, presionando suavemente pero con firmeza para crear un rollo apretado. Sella el rollo humedeciendo el borde expuesto de nori con un poco de agua. Usa un cuchillo afilado sumergido en agua para cortar el rollo en 6 a 8 trozos iguales.\r\n\r\nPaso 5\r\n\r\nRocía crema agria o crema sobre los trozos de sushi. Decora con cebollas rojas encurtidas. Agrega una lluvia de sriracha o mayonesa picante según lo desees.', '1780130567_f3af9f4ba2962e2f5bb0.jpg', '2026-05-30 05:42:47', 1, 0, 1, 5),
(16, 'Marineras Perfectas', 'Simples pasos para hacer las marineras de carne\r\nLimpiar y secar los filetes de carne. Salpimentar a gusto. En un plato hondo, colocar harina suficiente para empanizar. \r\nEn otro plato batir los huevos y agregar el ajo picado, el perejil y el pimentón dulce si se desea, mezclando bien.\r\nPasar cada filete primero por la harina cubriéndolo completamente, y luego sumergirlo en el huevo batido.\r\nCalentar suficiente aceite en una sartén a fuego medio (para sumergirlas hasta 2 cm de profundidad). Colocar los filetes empanizados con cuidado en la sartén y freírlos hasta que estén dorados, aproximadamente 3-4 minutos por lado, dependiendo del grosor.\r\nColocar las marineras sobre papel absorbente para eliminar el exceso de aceite. Servirlas calientes acompañadas de rodajas de limón.', '1780534726_244d097bf96b6b44395d.jpg', '2026-06-03 21:58:46', 0, 1, 1, 5),
(17, 'Pizza Casera', 'Pizza con queso', '1780568027_951d1dfc14c65320962d.jpg', '2026-06-04 07:13:47', 1, 0, 1, 1),
(32, 'torta de cumpleaños', 'la mejor tota casera para tu cumpleaños', '1781106882_e9c70f6b0da6a3252431.jpg', '2026-06-10 12:54:42', 0, 0, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta_ingrediente`
--

CREATE TABLE `receta_ingrediente` (
  `id_receta_ingrediente` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `id_ingrediente` int(11) NOT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `unidad` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `receta_ingrediente`
--

INSERT INTO `receta_ingrediente` (`id_receta_ingrediente`, `id_receta`, `id_ingrediente`, `cantidad`, `unidad`) VALUES
(1, 6, 1, NULL, NULL),
(2, 7, 2, NULL, NULL),
(3, 7, 3, NULL, NULL),
(4, 7, 4, NULL, NULL),
(5, 7, 5, NULL, NULL),
(6, 7, 6, NULL, NULL),
(7, 8, 7, NULL, NULL),
(8, 8, 8, NULL, NULL),
(9, 8, 9, NULL, NULL),
(10, 8, 10, NULL, NULL),
(11, 9, 11, NULL, NULL),
(12, 9, 12, NULL, NULL),
(13, 9, 13, NULL, NULL),
(14, 9, 14, NULL, NULL),
(15, 9, 15, NULL, NULL),
(16, 9, 16, NULL, NULL),
(17, 10, 17, NULL, NULL),
(18, 10, 18, NULL, NULL),
(19, 10, 19, NULL, NULL),
(20, 10, 20, NULL, NULL),
(21, 10, 21, NULL, NULL),
(22, 11, 22, NULL, NULL),
(23, 11, 23, NULL, NULL),
(24, 11, 24, NULL, NULL),
(25, 11, 25, NULL, NULL),
(26, 11, 26, NULL, NULL),
(27, 11, 27, NULL, NULL),
(28, 11, 10, NULL, NULL),
(29, 11, 28, NULL, NULL),
(30, 11, 29, NULL, NULL),
(31, 11, 30, NULL, NULL),
(32, 11, 31, NULL, NULL),
(33, 12, 32, NULL, NULL),
(34, 12, 33, NULL, NULL),
(35, 12, 34, NULL, NULL),
(36, 12, 35, NULL, NULL),
(37, 12, 36, NULL, NULL),
(38, 12, 37, NULL, NULL),
(39, 13, 38, NULL, NULL),
(40, 13, 39, NULL, NULL),
(41, 13, 40, NULL, NULL),
(42, 13, 41, NULL, NULL),
(43, 13, 42, NULL, NULL),
(44, 13, 43, NULL, NULL),
(45, 13, 44, NULL, NULL),
(48, 16, 47, NULL, NULL),
(49, 16, 48, NULL, NULL),
(50, 16, 49, NULL, NULL),
(51, 16, 50, NULL, NULL),
(52, 16, 51, NULL, NULL),
(53, 16, 52, NULL, NULL),
(54, 16, 53, NULL, NULL),
(55, 16, 54, NULL, NULL),
(56, 17, 55, NULL, NULL),
(57, 17, 56, NULL, NULL),
(62, 32, 61, NULL, NULL),
(63, 32, 62, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resena`
--

CREATE TABLE `resena` (
  `id_resena` int(11) NOT NULL,
  `titulo_resena` varchar(100) DEFAULT NULL,
  `comentario_resena` text NOT NULL,
  `fecha_resena` datetime DEFAULT current_timestamp(),
  `cant_likes` int(11) DEFAULT 0,
  `cant_dislikes` int(11) DEFAULT 0,
  `id_receta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resena`
--

INSERT INTO `resena` (`id_resena`, `titulo_resena`, `comentario_resena`, `fecha_resena`, `cant_likes`, `cant_dislikes`, `id_receta`, `id_usuario`) VALUES
(1, 'Opinión', 'primer comentario', '2026-05-25 04:05:49', 0, 1, 9, 1),
(2, 'Opinión', 'Muy buena receta!!!!!!!!!!', '2026-05-25 04:43:12', 1, 0, 5, 1),
(3, 'Opinión', 'me salio muy bien la receta !!', '2026-05-28 06:06:25', 2, 0, 10, 1),
(4, 'Opinión', 'la mejor receta de pechugass', '2026-05-28 06:33:40', 1, 0, 7, 2),
(5, 'Opinión', 'las mejor pizzaaaa', '2026-06-01 04:41:24', 1, 0, 6, 1),
(7, 'Opinión', 'los mejores Espaguetis  que eh probadoooo', '2026-06-05 02:05:51', 0, 0, 8, 1),
(8, 'Opinión', 'muy simple', '2026-06-05 02:10:59', 1, 0, 17, 1),
(9, 'Opinión', 'primera vez que hice y me salieron riquisimo', '2026-06-07 03:55:55', 0, 1, 13, 1),
(10, 'Opinión', 'a mi no me gusto\r\n', '2026-06-07 07:47:13', 1, 0, 7, 1),
(11, 'Opinión', 'hola', '2026-06-08 04:01:43', 0, 0, 11, 1),
(12, 'Opinión', '.', '2026-06-09 08:18:31', 0, 0, 16, 1),
(14, 'Opinión', 'Reseña creada desde PHPUnit', '2026-06-09 12:19:23', 0, 0, 5, 1),
(16, 'Opinión', 'Reseña válida', '2026-06-10 02:16:24', 0, 0, 5, 1),
(18, 'Opinión', 'Reseña válida', '2026-06-10 02:22:25', 0, 0, 5, 1),
(21, 'Opinión', 'Reseña válida', '2026-06-10 02:23:42', 0, 0, 5, 1),
(22, 'Opinión', 'me gusto', '2026-06-10 02:23:42', 0, 0, 6, 2),
(24, 'Opinión', 'Reseña válida', '2026-06-10 02:25:33', 0, 0, 5, 1),
(27, 'Opinión', 'Reseña válida', '2026-06-10 02:36:01', 0, 0, 5, 1),
(28, 'Opinión', 'Otra reseña válida', '2026-06-10 02:36:01', 0, 0, 5, 1),
(29, 'Opinión', 'Reseña válida', '2026-06-10 02:46:18', 0, 0, 5, 1),
(30, 'Opinión', 'Otra reseña válida', '2026-06-10 02:46:18', 0, 0, 5, 1),
(31, 'Opinión', 'Reseña válida', '2026-06-10 02:52:21', 0, 0, 5, 1),
(32, 'Opinión', 'Otra reseña válida', '2026-06-10 02:52:21', 0, 0, 5, 1),
(33, 'Opinión', 'Reseña válida', '2026-06-10 02:55:51', 0, 0, 5, 1),
(34, 'Opinión', 'Esta reseña sí es válida', '2026-06-10 02:55:51', 0, 0, 5, 1),
(35, 'Opinión', 'Reseña válida', '2026-06-10 03:03:31', 0, 0, 5, 1),
(36, 'Opinión', 'Otra reseña válida', '2026-06-10 03:03:31', 0, 0, 5, 1),
(37, 'Opinión', 'Reseña válida', '2026-06-10 03:05:10', 0, 0, 5, 1),
(38, 'Opinión', 'Otra reseña válida', '2026-06-10 03:05:10', 0, 0, 5, 1),
(39, 'Opinión', 'Reseña válida', '2026-06-10 03:10:18', 0, 0, 5, 1),
(40, 'Opinión', 'Esta reseña sí es válida', '2026-06-10 03:10:18', 0, 0, 5, 1),
(41, 'Opinión', 'Otra reseña válida', '2026-06-10 03:10:18', 0, 0, 5, 1),
(42, 'Opinión', 'Reseña válida', '2026-06-10 03:18:27', 0, 0, 5, 1),
(43, 'Opinión', 'Otra reseña válida', '2026-06-10 03:18:27', 0, 0, 7, 1),
(44, 'Opinión', 'Reseña válida', '2026-06-10 03:21:33', 0, 0, 5, 1),
(45, 'Opinión', 'Otra reseña válida', '2026-06-10 03:21:33', 0, 0, 5, 1),
(46, 'Opinión', 'Reseña válida', '2026-06-10 03:26:40', 0, 0, 5, 1),
(47, 'Opinión', 'Reseña válida', '2026-06-10 11:09:44', 0, 0, 5, 1),
(48, 'Opinión', 'Otra reseña válida', '2026-06-10 11:09:44', 0, 0, 7, 1),
(49, 'Opinión', 'Reseña válida', '2026-06-10 11:15:03', 0, 0, 5, 1),
(50, 'Opinión', 'Otra reseña válida', '2026-06-10 11:15:03', 0, 0, 7, 1),
(51, 'Opinión', 'Reseña válida', '2026-06-10 11:16:39', 0, 0, 5, 1),
(52, 'Opinión', 'Reseña válida', '2026-06-10 11:18:30', 0, 0, 5, 1),
(56, 'Opinión', 'Reseña válida', '2026-06-10 11:30:06', 0, 0, 6, 1),
(57, 'Opinión', 'Muy buena receta', '2026-06-10 11:30:06', 0, 0, 7, 2),
(58, 'Opinión', 'La recomiendo', '2026-06-10 11:30:06', 0, 0, 8, 1),
(59, 'Opinión', 'Reseña válida', '2026-06-10 11:31:15', 0, 0, 6, 1),
(60, 'Opinión', 'Reseña válida', '2026-06-10 12:09:05', 0, 0, 6, 1),
(61, 'Opinión', 'Muy buena receta', '2026-06-10 12:09:05', 0, 0, 7, 2),
(62, 'Opinión', 'La recomiendo', '2026-06-10 12:09:05', 0, 0, 8, 1),
(66, 'Opinión', 'hola no me gusto nada', '2026-06-10 13:10:19', 0, 0, 32, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `correo_usuario` varchar(150) NOT NULL,
  `password_usuario` varchar(255) NOT NULL,
  `rol_usuario` tinyint(1) DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `correo_usuario`, `password_usuario`, `rol_usuario`) VALUES
(1, 'tomas', 'bolotomas3@gmail.com', '$2y$10$kjjB5rZIlqba.BzmqztBVenWrFQ9NJH7aMl3/QPBlFTPb972qQsjS', 2),
(2, 'tomi', 'tomybolo16@gmail.com', '$2y$10$iHWB3xi8HHtRRqMQjW38nuOtluHbiwzlCy1YuppqFH.D0g7RMRxcC', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voto_receta`
--

CREATE TABLE `voto_receta` (
  `id_usuario` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `tipo_voto` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `voto_receta`
--

INSERT INTO `voto_receta` (`id_usuario`, `id_receta`, `tipo_voto`) VALUES
(1, 5, 1),
(1, 6, 1),
(1, 7, 0),
(1, 10, 1),
(1, 11, 0),
(1, 12, 1),
(1, 13, 1),
(1, 16, 0),
(1, 17, 1),
(2, 5, 1),
(2, 6, 0),
(2, 7, 0),
(2, 10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voto_resena`
--

CREATE TABLE `voto_resena` (
  `id_usuario` int(11) NOT NULL,
  `id_resena` int(11) NOT NULL,
  `tipo_voto` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `voto_resena`
--

INSERT INTO `voto_resena` (`id_usuario`, `id_resena`, `tipo_voto`) VALUES
(1, 1, 0),
(1, 2, 1),
(1, 3, 1),
(1, 4, 1),
(1, 5, 1),
(1, 8, 1),
(1, 9, 0),
(1, 10, 1),
(2, 3, 1),
(2, 14, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD PRIMARY KEY (`id_ingrediente`);

--
-- Indices de la tabla `receta`
--
ALTER TABLE `receta`
  ADD PRIMARY KEY (`id_receta`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `receta_ingrediente`
--
ALTER TABLE `receta_ingrediente`
  ADD PRIMARY KEY (`id_receta_ingrediente`),
  ADD KEY `id_receta` (`id_receta`),
  ADD KEY `id_ingrediente` (`id_ingrediente`);

--
-- Indices de la tabla `resena`
--
ALTER TABLE `resena`
  ADD PRIMARY KEY (`id_resena`),
  ADD KEY `id_receta` (`id_receta`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo_usuario` (`correo_usuario`);

--
-- Indices de la tabla `voto_receta`
--
ALTER TABLE `voto_receta`
  ADD PRIMARY KEY (`id_usuario`,`id_receta`),
  ADD KEY `id_receta` (`id_receta`);

--
-- Indices de la tabla `voto_resena`
--
ALTER TABLE `voto_resena`
  ADD PRIMARY KEY (`id_usuario`,`id_resena`),
  ADD KEY `id_resena` (`id_resena`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  MODIFY `id_ingrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `receta`
--
ALTER TABLE `receta`
  MODIFY `id_receta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `receta_ingrediente`
--
ALTER TABLE `receta_ingrediente`
  MODIFY `id_receta_ingrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `resena`
--
ALTER TABLE `resena`
  MODIFY `id_resena` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `receta`
--
ALTER TABLE `receta`
  ADD CONSTRAINT `receta_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `receta_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`);

--
-- Filtros para la tabla `receta_ingrediente`
--
ALTER TABLE `receta_ingrediente`
  ADD CONSTRAINT `receta_ingrediente_ibfk_1` FOREIGN KEY (`id_receta`) REFERENCES `receta` (`id_receta`) ON DELETE CASCADE,
  ADD CONSTRAINT `receta_ingrediente_ibfk_2` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id_ingrediente`) ON DELETE CASCADE;

--
-- Filtros para la tabla `resena`
--
ALTER TABLE `resena`
  ADD CONSTRAINT `resena_ibfk_1` FOREIGN KEY (`id_receta`) REFERENCES `receta` (`id_receta`) ON DELETE CASCADE,
  ADD CONSTRAINT `resena_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `voto_receta`
--
ALTER TABLE `voto_receta`
  ADD CONSTRAINT `voto_receta_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `voto_receta_ibfk_2` FOREIGN KEY (`id_receta`) REFERENCES `receta` (`id_receta`) ON DELETE CASCADE;

--
-- Filtros para la tabla `voto_resena`
--
ALTER TABLE `voto_resena`
  ADD CONSTRAINT `voto_resena_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `voto_resena_ibfk_2` FOREIGN KEY (`id_resena`) REFERENCES `resena` (`id_resena`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
