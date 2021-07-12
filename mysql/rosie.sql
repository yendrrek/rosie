-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2021 at 11:11 AM
-- Server version: 5.6.37
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rosie`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addToBasket`(IN `userId` CHAR(32), IN `addedProductId` MEDIUMINT, IN `addedQty` TINYINT)
BEGIN
DECLARE productAlreadyInBasket INT;
DECLARE currentStockAmount SMALLINT;
DECLARE currentQty SMALLINT;
SELECT id INTO productAlreadyInBasket FROM basket WHERE userId=userId AND productId=addedProductId;
SELECT stock INTO currentStockAmount FROM cards WHERE id=addedProductId;
SELECT quantity INTO currentQty FROM basket WHERE userId=userId AND productId=addedProductId;
IF productAlreadyInBasket > 0 THEN
    IF currentQty + addedQty > currentStockAmount THEN
        UPDATE basket SET quantity=currentStockAmount, dateModified=NOW() WHERE id=productAlreadyInBasket;
    ELSE
        UPDATE basket SET quantity=quantity+addedQty, dateModified=NOW() WHERE id=productAlreadyInBasket;
    END IF;
ELSE
	INSERT INTO basket (userId, productId, quantity)
	VALUES (userId, addedProductId, addedQty);
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCards`()
SELECT * FROM cards ORDER BY id ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getSlideshowImgs`(IN `artworkSection` TEXT)
SELECT * FROM slideshow
WHERE CASE artworkSection WHEN 'allWorks'     THEN id BETWEEN 1  AND 29
 					      WHEN 'geometry'     THEN id BETWEEN 12 AND 15
					      WHEN 'stainedGlass' THEN id BETWEEN 16 AND 27
					      WHEN 'ceramicTiles' THEN id BETWEEN 28 AND 29
                          WHEN 'paintings'	  THEN id BETWEEN 1  AND 11
                          END
ORDER BY id ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getThumbnailImgs`(IN `artworkSection` TEXT)
SELECT * FROM thumbnailImgs 
WHERE CASE artworkSection WHEN 'allWorks' 	  THEN id BETWEEN 1  AND 29
                          WHEN 'geometry' 	  THEN id BETWEEN 12 AND 15
                          WHEN 'stainedGlass' THEN id BETWEEN 16 AND 27
                          WHEN 'ceramicTiles' THEN id BETWEEN 28 AND 29
                          WHEN 'paintings'	  THEN id BETWEEN 1  AND 11
                          END
ORDER BY id ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `removeFromBasket`(IN `userId` CHAR(32), IN `productRemovedFromBasket` INT)
    NO SQL
BEGIN
IF productRemovedFromBasket > 0 THEN
   DELETE FROM basket WHERE userId=userId AND productId=productRemovedFromBasket;
ELSE
   DELETE FROM basket WHERE userId=userId;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateBasket`(IN `userId` CHAR(32), IN `productRemovedFromBasket` MEDIUMINT, IN `newQty` TINYINT)
BEGIN
IF newQty > 0 THEN
UPDATE basket SET quantity=newQty, dateModified=NOW() WHERE userId=userId AND productId=productRemovedFromBasket;
END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `aboutContent`
--

CREATE TABLE IF NOT EXISTS `aboutContent` (
  `id` int(11) NOT NULL,
  `paragraph` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aboutContent`
--

INSERT INTO `aboutContent` (`id`, `paragraph`) VALUES
(1, 'I have always been delighted by beauty of materials; by craft, colour and storytelling in painting. The golden era of Medieval manuscript illumination, Gothic painting and the roots of Western art in Christian Iconography are my greatest inspirations.'),
(2, 'This led me to study at The Prince’s School of Traditional Arts in London, as one of the few places in the UK that offers courses in these ancient techniques. On their Masters program I was able, not only to learn the techniques that most interested me in European art, but also to study under artistic masters from various cultures including Persian and Indian miniature, Islamic geometry and ceramics. After a feast of various artistic traditions in the first year, I went on to explore egg tempera painting and gilding on gesso board, as practised in Iconography, and Medieval stained glass.'),
(3, 'Although these studies were largely technical in focus, I am a great believer in the empowerment that technical mastery gives to artistic expression. The techniques and materials themselves are inspiring. The use of gold and natural pigments derived from minerals, plants and animals - often coupled with the process of making them myself - is a continuous source of reconnection with nature.'),
(4, 'At the same time, since childhood, I have had a love for the history and folklore of the British Isles and a deep sense of identity with the landscapes. My current home is in the Orkney Isles, where the peace, paired-down natural beauty and historic sites are a catalyst to reconnecting all these varied inspirations and letting the creative process bring forth its fruit unhurriedly.'),
(5, 'I want to make art that is beautiful and uplifting for the viewer, whether it be transcendentally, as in Iconography, or simply through the joy of the subject and beauty of the materials.');

-- --------------------------------------------------------

--
-- Table structure for table `basket`
--

CREATE TABLE IF NOT EXISTS `basket` (
  `id` int(20) unsigned NOT NULL,
  `userId` char(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `productId` mediumint(9) unsigned NOT NULL,
  `quantity` tinyint(4) unsigned NOT NULL,
  `dateModified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `basketMainNavItems`
--

CREATE TABLE IF NOT EXISTS `basketMainNavItems` (
  `id` tinyint(4) NOT NULL,
  `basketMainNavElements` char(30) NOT NULL,
  `basketMainNavLinks` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `basketMainNavItems`
--

INSERT INTO `basketMainNavItems` (`id`, `basketMainNavElements`, `basketMainNavLinks`) VALUES
(1, 'Continue shopping', 'shop.php'),
(2, 'Back to home page', 'index.php');

-- --------------------------------------------------------

--
-- Table structure for table `basketSmallMainNavItems`
--

CREATE TABLE IF NOT EXISTS `basketSmallMainNavItems` (
  `id` int(11) NOT NULL,
  `basketSmallMainNavElements` char(30) NOT NULL,
  `basketSmallMainNavLinks` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `basketSmallMainNavItems`
--

INSERT INTO `basketSmallMainNavItems` (`id`, `basketSmallMainNavElements`, `basketSmallMainNavLinks`) VALUES
(1, 'Continue shopping', 'shop.php'),
(2, 'Back to home page', 'index.php');

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE IF NOT EXISTS `cards` (
  `id` tinyint(1) unsigned NOT NULL,
  `product` varchar(50) NOT NULL,
  `imgBackUrl` varchar(255) DEFAULT NULL,
  `imgFrontUrl` varchar(255) DEFAULT NULL,
  `imgMoreUrl` varchar(255) NOT NULL,
  `imgFrontAlt` varchar(255) DEFAULT NULL,
  `imgBackAlt` varchar(255) DEFAULT NULL,
  `imgMoreAlt` varchar(255) NOT NULL,
  `shopExtraImgUrl` varchar(255) NOT NULL,
  `shopExtraImgAlt` varchar(255) NOT NULL,
  `imgBasket` varchar(255) NOT NULL,
  `retailPrice` decimal(20,2) unsigned NOT NULL,
  `stock` tinyint(2) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `product`, `imgBackUrl`, `imgFrontUrl`, `imgMoreUrl`, `imgFrontAlt`, `imgBackAlt`, `imgMoreAlt`, `shopExtraImgUrl`, `shopExtraImgAlt`, `imgBasket`, `retailPrice`, `stock`) VALUES
(1, 'Virgin of Compassion', 'img/img-shop/virgin-comp/virgin-comp-back.jpg', 'img/img-shop/virgin-comp/virgin-comp-front.jpg', 'img/img-shop/photos-with-plants/photos-with-plants-cropped/our-lady.jpg', 'Front of the Virgin of Compassion card', 'Back of the Virgin of Compassion card', 'The Virgin of Compassion card with an envelope', 'img/img-shop/photos-with-plants/our-lady.jpg', 'Virgin of Compassion card with background', 'img/img-shop/virgin-comp/basket/virgin-comp-basket.jpg', 3.10, 3),
(2, 'Sacred Heart of Jesus', 'img/img-shop/sacred-heart/sacred-heart-back.jpg', 'img/img-shop/sacred-heart/sacred-heart-front.jpg', 'img/img-shop/photos-with-plants/photos-with-plants-cropped/sacred-heart.jpg', 'Front of the Sacred Heart of Jesus card', 'Back of the Sacred Heart of Jesus card', 'The Sacred Heart of Jesus card with an envelope', 'img/img-shop/photos-with-plants/sacred-heart.jpg', 'Sacred Heart of Jesus card with background', 'img/img-shop/sacred-heart/basket/sacred-heart-basket.jpg', 3.20, 17),
(3, 'Sinai Christ', 'img/img-shop/sinai-christ/sinai-christ-back.jpg', 'img/img-shop/sinai-christ/sinai-christ-front.jpg', 'img/img-shop/photos-with-plants/photos-with-plants-cropped/sinai-christ.jpg', 'Front of the Sinai Christ card', 'Back of the Sinai Christ card', 'The Sinai Christ card with an envelope', 'img/img-shop/photos-with-plants/sinai-christ.jpg', 'Sinai Christ card with background', 'img/img-shop/sinai-christ/basket/sinai-christ-basket.jpg', 2.90, 0),
(4, 'St Joseph & the Christ Child', 'img/img-shop/st-joseph/st-joseph-back.jpg', 'img/img-shop/st-joseph/st-joseph-front.jpg', 'img/img-shop/photos-with-plants/photos-with-plants-cropped/st-joseph.jpg', 'Front of the St Joseph and the Christ Child card', 'Back of the St Joseph and the Christ Child card', 'The St Joseph and the Christ Child card with an envelope', 'img/img-shop/photos-with-plants/st-joseph.jpg', 'St Joseph and Christ Child card with background', 'img/img-shop/st-joseph/basket/st-joseph-basket.jpg', 3.00, 32);

-- --------------------------------------------------------

--
-- Table structure for table `contactForm`
--

CREATE TABLE IF NOT EXISTS `contactForm` (
  `id` int(11) NOT NULL,
  `userId` char(32) NOT NULL,
  `senderName` varchar(60) NOT NULL,
  `senderEmail` varchar(100) NOT NULL,
  `msg` text NOT NULL,
  `datePosted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) unsigned NOT NULL,
  `userId` char(32) NOT NULL,
  `orderId` char(32) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(20) NOT NULL,
  `address` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mainNavItems`
--

CREATE TABLE IF NOT EXISTS `mainNavItems` (
  `id` tinyint(4) NOT NULL,
  `mainNavElements` char(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mainNavLinks` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mainNavItems`
--

INSERT INTO `mainNavItems` (`id`, `mainNavElements`, `mainNavLinks`) VALUES
(1, 'All works', 'all-works.php'),
(2, 'About', 'about.php'),
(3, 'Contact', 'contact.php'),
(4, 'Shop', 'shop.php');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) unsigned NOT NULL,
  `userId` char(32) NOT NULL,
  `orderId` char(32) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `priceGBP` decimal(20,2) NOT NULL,
  `whenPosted` char(8) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `slideshow`
--

CREATE TABLE IF NOT EXISTS `slideshow` (
  `id` tinyint(2) unsigned NOT NULL,
  `slideshowImgAlt` varchar(500) NOT NULL,
  `slideshowImgTitle` varchar(500) NOT NULL,
  `slideshowImgDesc` varchar(500) NOT NULL,
  `slideshowImgDimm` varchar(500) NOT NULL,
  `slideshowSoldInfo` varchar(500) NOT NULL,
  `1366px` varchar(255) NOT NULL,
  `768px` varchar(255) NOT NULL,
  `414px` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slideshow`
--

INSERT INTO `slideshow` (`id`, `slideshowImgAlt`, `slideshowImgTitle`, `slideshowImgDesc`, `slideshowImgDimm`, `slideshowSoldInfo`, `1366px`, `768px`, `414px`) VALUES
(1, 'The Nightingale and the Rose', 'The Nightingale and the Rose, 2015', '23ct gold leaf, egg tempera,<br> natural pigments on gesso board', '27 x 19.5 cm (10&frac58; x 8 in)', '*Sold', 'img/img-slideshow/1366/1-paintings/the-nightingale-and-the-rose.jpg', 'img/img-slideshow/768/1-paintings/the-nightingale-and-the-rose.jpg', 'img/img-slideshow/414/1-paintings/the-nightingale-and-the-rose.jpg'),
(2, 'Orange Tree in a Moorish Arch', 'Orange Tree in a Moorish Arch, 2017', '23ct gold leaf, egg tempera,<br> natural pigments on gesso board', '27 x 19.5 cm (10&frac58; x 8 in)', '*Sold', 'img/img-slideshow/1366/1-paintings/orange-tree-in-a-moorish-arch.jpg', 'img/img-slideshow/768/1-paintings/orange-tree-in-a-moorish-arch.jpg', 'img/img-slideshow/414/1-paintings/orange-tree-in-a-moorish-arch.jpg'),
(3, 'St Francis and the Wolf', 'St Francis and the Wolf, 2017', '23ct gold leaf, egg tempera,<br> natural pigments on gesso board', '27 x 19.5 cm (10&frac58; x 8 in)', '*Sold', 'img/img-slideshow/1366/1-paintings/st-francis-and-the-wolf.jpg', 'img/img-slideshow/768/1-paintings/st-francis-and-the-wolf.jpg', 'img/img-slideshow/414/1-paintings/st-francis-and-the-wolf.jpg'),
(4, 'Sacred Heart of Jesus', 'Sacred Heart of Jesus, 2017', '23ct gold leaf, egg tempera,<br> natural pigments on gesso board', '57.5 x 41 cm (23 x 16 in)', '*Private collection', 'img/img-slideshow/1366/1-paintings/sacred-heart-of-jesus.jpg', 'img/img-slideshow/768/1-paintings/sacred-heart-of-jesus.jpg', 'img/img-slideshow/414/1-paintings/sacred-heart-of-jesus.jpg'),
(5, 'Icon of Christ Pantocrator', 'Icon of Christ Pantocrator, 2017', '23ct gold leaf, egg tempera,<br> natural pigments on gesso board', '25 x 20 cm (10 x 7&frac78; in)', '', 'img/img-slideshow/1366/1-paintings/icon-of-christ-pantocrator.jpg', 'img/img-slideshow/768/1-paintings/icon-of-christ-pantocrator.jpg', 'img/img-slideshow/414/1-paintings/icon-of-christ-pantocrator.jpg'),
(6, 'Icon of St Michael the Archangel', 'Icon of St Michael the Archangel, 2016', '23ct gold leaf, egg tempera,<br> natural pigments on gesso board', '20 x 15 cm (7&frac78; x 6 in)', '*Private collection', 'img/img-slideshow/1366/1-paintings/icon-of-st-michael-the-archangel.jpg', 'img/img-slideshow/768/1-paintings/icon-of-st-michael-the-archangel.jpg', 'img/img-slideshow/414/1-paintings/icon-of-st-michael-the-archangel.jpg'),
(7, 'Icon of St Joseph and the Christ Child', 'Icon of St Joseph and the Christ Child, 2017', '23ct gold leaf, egg tempera,<br> natural pigments on gesso board', '40 x 30 cm (15&frac34; x 12 in)', '', 'img/img-slideshow/1366/1-paintings/icon-of-st-joseph-and-the-christ-child.jpg', 'img/img-slideshow/768/1-paintings/icon-of-st-joseph-and-the-christ-child.jpg', 'img/img-slideshow/414/1-paintings/icon-of-st-joseph-and-the-christ-child.jpg'),
(8, 'Icon of the Virgin of Compassion', 'Icon of the Virgin of Compassion, 2016', 'Egg tempera, metallic acrylic,<br> natural and synthetic pigments on gesso board', '34 x 26 cm (13 x 10 in)', '', 'img/img-slideshow/1366/1-paintings/icon-of-the-virgin-of-compassion.jpg', 'img/img-slideshow/768/1-paintings/icon-of-the-virgin-of-compassion.jpg', 'img/img-slideshow/414/1-paintings/icon-of-the-virgin-of-compassion.jpg'),
(9, 'Damayanti and the Swan', 'Damayanti and the Swan, 2016', 'Gum arabic, natural pigments on paper', '23 x 16 cm (9 x 6 in)', '*Private collection', 'img/img-slideshow/1366/1-paintings/damayanti-and-the-swan.jpg', 'img/img-slideshow/768/1-paintings/damayanti-and-the-swan.jpg', 'img/img-slideshow/414/1-paintings/damayanti-and-the-swan.jpg'),
(10, 'Riding the Carpet of the Rolling Waves Monks in Coracles', 'Riding the Carpet of the Rolling Waves: Monks in Coracles, 2019', 'Egg tempera, natural pigments on paper', '42 x 24 cm (17 x 9 in)', '', 'img/img-slideshow/1366/1-paintings/riding-the-carpet-of-the-rolling-waves-monks-in-coracles.jpg', 'img/img-slideshow/768/1-paintings/riding-the-carpet-of-the-rolling-waves-monks-in-coracles.jpg', 'img/img-slideshow/414/1-paintings/riding-the-carpet-of-the-rolling-waves-monks-in-coracles.jpg'),
(11, 'Pangur Bán', 'Pangur Bán, 2018', '23ct gold leaf, egg tempera,<br> natural pigments on fabriano paper', '23 x 18 cm (9 x 7 in)', '*Sold', 'img/img-slideshow/1366/1-paintings/pangur-bán.jpg', 'img/img-slideshow/768/1-paintings/pangur-bán.jpg', 'img/img-slideshow/414/1-paintings/pangur-bán.jpg'),
(12, 'Ten-Fold Geometry', 'Ten-Fold Geometry, 2016', 'Watercolour on paper', '29.5 x 29.5 cm (12 x 12 in)', '*Sold', 'img/img-slideshow/1366/2-geometry/ten-fold-geometry.jpg', 'img/img-slideshow/768/2-geometry/ten-fold-geometry.jpg', 'img/img-slideshow/414/2-geometry/ten-fold-geometry.jpg'),
(13, 'Pink Flower', 'Pink Flower, 2016', 'Watercolour on paper', '29.5 x 29.5 cm (12 x 12 in)', '', 'img/img-slideshow/1366/2-geometry/pink-flower.jpg', 'img/img-slideshow/768/2-geometry/pink-flower.jpg', 'img/img-slideshow/414/2-geometry/pink-flower.jpg'),
(14, 'Red Flower', 'Red Flower, 2018', 'Watercolour on paper', '29.5 x 29.5 cm (12 x 12 in)', '', 'img/img-slideshow/1366/2-geometry/red-flower.jpg', 'img/img-slideshow/768/2-geometry/red-flower.jpg', 'img/img-slideshow/414/2-geometry/red-flower.jpg'),
(15, 'Daffodils', 'Daffodils, 2018', 'Watercolour on paper', '29.5 x 29.5 cm (12 x 12 in)', '', 'img/img-slideshow/1366/2-geometry/daffodils.jpg', 'img/img-slideshow/768/2-geometry/daffodils.jpg', 'img/img-slideshow/414/2-geometry/daffodils.jpg'),
(16, 'Hanging Glass Quarry – Phoenix', 'Hanging Glass Quarry – Phoenix, 2017', 'Lead, solder, stained and coloured glass', '23 x 15.5 cm (9 x 6 in)', '*Sold', 'img/img-slideshow/1366/3-stained-glass/hanging-glass-quarry-phoenix-quarry.jpg', 'img/img-slideshow/768/3-stained-glass/hanging-glass-quarry-phoenix-quarry.jpg', 'img/img-slideshow/414/3-stained-glass/hanging-glass-quarry-phoenix-quarry.jpg'),
(17, 'Hanging Glass Quarry – Seraphin', 'Hanging Glass Quarry – Seraphin, 2017', 'Lead, solder, stained and coloured glass', '23 x 15.5 cm (9 x 6 in)', '*Private collection', 'img/img-slideshow/1366/3-stained-glass/hanging-glass-quarry-seraphin.jpg', 'img/img-slideshow/768/3-stained-glass/hanging-glass-quarry-seraphin.jpg', 'img/img-slideshow/414/3-stained-glass/hanging-glass-quarry-seraphin.jpg'),
(18, 'Hanging Glass Quarry – Green Foliage Motif', 'Hanging Glass Quarry – Green Foliage Motif, 2017', 'Lead, solder, stained and coloured glass', '23 x 15.5 cm (9 x 6 in)', '', 'img/img-slideshow/1366/3-stained-glass/hanging-glass-quarry-green-foliage-motif.jpg', 'img/img-slideshow/768/3-stained-glass/hanging-glass-quarry-green-foliage-motif.jpg', 'img/img-slideshow/414/3-stained-glass/hanging-glass-quarry-green-foliage-motif.jpg'),
(19, 'Hanging Glass Quarry – Blue Foliage Motif', 'Hanging Glass Quarry – Blue Foliage Motif, 2017', 'Lead, solder, stained and coloured glass', '23 x 15.5 cm (9 x 6 in)', '*Private collection', 'img/img-slideshow/1366/3-stained-glass/hanging-glass-quarry-blue-foliage-motif.jpg', 'img/img-slideshow/768/3-stained-glass/hanging-glass-quarry-blue-foliage-motif.jpg', 'img/img-slideshow/414/3-stained-glass/hanging-glass-quarry-blue-foliage-motif.jpg'),
(20, 'Foliage Border', 'Foliage Border, 2016', 'Lead, solder, stained and coloured glass', '19 x 33 cm (7 x 13 in)', '', 'img/img-slideshow/1366/3-stained-glass/foliage-border.jpg', 'img/img-slideshow/768/3-stained-glass/foliage-border.jpg', 'img/img-slideshow/414/3-stained-glass/foliage-border.jpg'),
(21, 'Hanging Tree (Weeping Willow)', 'Hanging Tree (Weeping Willow), 2017', 'Lead, solder, stained and coloured glass', '25.5 x 17 cm (10 x 7 in)', '', 'img/img-slideshow/1366/3-stained-glass/hanging-tree-weeping-willow.jpg', 'img/img-slideshow/768/3-stained-glass/hanging-tree-weeping-willow.jpg', 'img/img-slideshow/414/3-stained-glass/hanging-tree-weeping-willow.jpg'),
(22, 'Nativity Scene', 'Nativity Scene, 2017', 'Lead, solder, stained and coloured glass', '25.5 x 25.5cm (10 x 10 in)', '', 'img/img-slideshow/1366/3-stained-glass/nativity-scene.jpg', 'img/img-slideshow/768/3-stained-glass/nativity-scene.jpg', 'img/img-slideshow/414/3-stained-glass/nativity-scene.jpg'),
(23, 'Annunciation to the Shepherds', 'Annunciation to the Shepherds, 2017', 'Lead, solder, stained and coloured glass', '25.5 x 25.5cm (10 x 10 in)', '', 'img/img-slideshow/1366/3-stained-glass/annunciation-to-the-shepherds.jpg', 'img/img-slideshow/768/3-stained-glass/annunciation-to-the-shepherds.jpg', 'img/img-slideshow/414/3-stained-glass/annunciation-to-the-shepherds.jpg'),
(24, 'Three Kings', 'Three Kings, 2017', 'Lead, solder, stained and coloured glass', '25.5 x 25.5cm (10 x 10 in)', '*Sold', 'img/img-slideshow/1366/3-stained-glass/three-kings.jpg', 'img/img-slideshow/768/3-stained-glass/three-kings.jpg', 'img/img-slideshow/414/3-stained-glass/three-kings.jpg'),
(25, 'Angel 1', 'Angel 1, 2016', 'Lead, solder, stained and coloured glass', '58.5 x 23.5 cm (23 x 9&frac14; in)', '', 'img/img-slideshow/1366/3-stained-glass/angel-1.jpg', 'img/img-slideshow/768/3-stained-glass/angel-1.jpg', 'img/img-slideshow/414/3-stained-glass/angel-1.jpg'),
(26, 'Angel 2', 'Angel 2, 2016', 'Lead, solder, stained and coloured glass', '58.5 x 23.5 cm (23 x 9&frac14; in)', '', 'img/img-slideshow/1366/3-stained-glass/angel-2.jpg', 'img/img-slideshow/768/3-stained-glass/angel-2.jpg', 'img/img-slideshow/414/3-stained-glass/angel-2.jpg'),
(27, 'Virgin and Child', 'Virgin and Child, 2017', 'Lead, solder, stained and coloured glass', '65 x 35.5 cm (26 x 14 in)', '', 'img/img-slideshow/1366/3-stained-glass/virgin-and-child.jpg', 'img/img-slideshow/768/3-stained-glass/virgin-and-child.jpg', 'img/img-slideshow/414/3-stained-glass/virgin-and-child.jpg'),
(28, 'Jerusalem Cross Tiles', 'Jerusalem Cross Tiles, 2016', 'Fired, glazed red and white clay', '27 x 27 cm (11 x 11 in)', '', 'img/img-slideshow/1366/4-ceramic-tiles/jerusalem-cross-tiles.jpg', 'img/img-slideshow/768/4-ceramic-tiles/jerusalem-cross-tiles.jpg', 'img/img-slideshow/414/4-ceramic-tiles/jerusalem-cross-tiles.jpg'),
(29, 'Celtic Key Pattern Cross Tiles', 'Celtic Key Pattern Cross Tiles, 2016', 'Fired, glazed red and white clay', '52 x 40 cm (20 x 16 in)', '', 'img/img-slideshow/1366/4-ceramic-tiles/celtic-key-pattern-cross-tiles.jpg', 'img/img-slideshow/768/4-ceramic-tiles/celtic-key-pattern-cross-tiles.jpg', 'img/img-slideshow/414/4-ceramic-tiles/celtic-key-pattern-cross-tiles.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `smallMainNavItems`
--

CREATE TABLE IF NOT EXISTS `smallMainNavItems` (
  `id` tinyint(4) NOT NULL,
  `smallMainNavElements` char(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `smallMainNavLinks` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `smallMainNavItems`
--

INSERT INTO `smallMainNavItems` (`id`, `smallMainNavElements`, `smallMainNavLinks`) VALUES
(1, 'Works', ''),
(2, 'About', 'about.php'),
(3, 'Contact', 'contact.php'),
(4, 'Shop', 'shop.php');

-- --------------------------------------------------------

--
-- Table structure for table `smallSubNavItems`
--

CREATE TABLE IF NOT EXISTS `smallSubNavItems` (
  `id` tinyint(4) NOT NULL,
  `smallSubNavElements` char(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `smallSubNavLinks` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `smallSubNavItems`
--

INSERT INTO `smallSubNavItems` (`id`, `smallSubNavElements`, `smallSubNavLinks`) VALUES
(1, 'All Works', 'all-works.php'),
(2, 'Geometry', 'geometry.php'),
(3, 'Stained Glass', 'stained-glass.php'),
(4, 'Ceramic Tiles', 'ceramic-tiles.php'),
(5, 'Paintings', 'paintings.php');

-- --------------------------------------------------------

--
-- Table structure for table `subNavItems`
--

CREATE TABLE IF NOT EXISTS `subNavItems` (
  `id` tinyint(4) NOT NULL,
  `subNavElements` char(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `subNavLinks` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subNavItems`
--

INSERT INTO `subNavItems` (`id`, `subNavElements`, `subNavLinks`) VALUES
(1, 'Geometry', 'geometry.php'),
(2, 'Stained Glass', 'stained-glass.php'),
(3, 'Ceramic Tiles', 'ceramic-tiles.php'),
(4, 'Paintings', 'paintings.php');

-- --------------------------------------------------------

--
-- Table structure for table `thumbnailImgs`
--

CREATE TABLE IF NOT EXISTS `thumbnailImgs` (
  `id` tinyint(2) unsigned NOT NULL,
  `thumbSrc` varchar(255) NOT NULL,
  `thumbAlt` varchar(255) NOT NULL,
  `thumbTitle` varchar(255) NOT NULL,
  `thumbDesc` varchar(255) NOT NULL,
  `thumbDim` varchar(255) NOT NULL,
  `thumbAdditional` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thumbnailImgs`
--

INSERT INTO `thumbnailImgs` (`id`, `thumbSrc`, `thumbAlt`, `thumbTitle`, `thumbDesc`, `thumbDim`, `thumbAdditional`) VALUES
(1, 'img/img-thumb/1-paintings/the-nightingale-and-the-rose.jpg', 'The Nightingale and the Rose', 'The Nightingale and the Rose, 2015', '23ct gold leaf, egg tempera,<br> natural pigments on gesso board', '27 x 19.5 cm (10&frac58; x 8 in)', '*Sold'),
(2, 'img/img-thumb/1-paintings/orange-tree-in-a-moorish-arch.jpg', 'Orange Tree in a Moorish Arch', 'Orange Tree in a Moorish Arch, 2017', '23ct gold leaf, egg tempera,<br> natural pigments on gesso board', '27 x 19.5 cm (10&frac58; x 8 in)', '*Sold'),
(3, 'img/img-thumb/1-paintings/st-francis-and-the-wolf.jpg', 'St Francis and the Wolf', 'St Francis and the Wolf, 2017', '23ct gold leaf, egg tempera,<br> natural pigments on gesso board', '27 x 19.5 cm (10&frac58; x 8 in)', '*Sold'),
(4, 'img/img-thumb/1-paintings/sacred-heart-of-jesus.jpg', 'Sacred Heart of Jesus', 'Sacred Heart of Jesus, 2017', '23ct gold leaf, egg tempera,<br> natural pigments on gesso board', '57.5 x 41 cm (23 x 16 in)', '*Private collection'),
(5, 'img/img-thumb/1-paintings/icon-of-christ-pantocrator.jpg', 'Icon of Christ Pantocrator', 'Icon of Christ Pantocrator, 2017', '23ct gold leaf, egg tempera,<br> natural pigments on gesso board', '25 x 20 cm (10 x 7&frac78; in)', ''),
(6, 'img/img-thumb/1-paintings/icon-of-st-michael-the-archangel.jpg', 'Icon of St Michael the Archangel', 'Icon of St Michael the Archangel, 2016', '23ct gold leaf, egg tempera,<br> natural pigments on gesso board', '20 x 15 cm (7&frac78; x 6 in)', '*Private collection'),
(7, 'img/img-thumb/1-paintings/icon-of-st-joseph-and-the-christ-child.jpg', 'Icon of St Joseph and the Christ Child', 'Icon of St Joseph and the Christ Child, 2017', '23ct gold leaf, egg tempera,<br> natural pigments on gesso board', '40 x 30 cm (15&frac34; x 12 in)', ''),
(8, 'img/img-thumb/1-paintings/icon-of-the-virgin-of-compassion.jpg', 'Icon of the Virgin of Compassion', 'Icon of the Virgin of Compassion, 2016', 'Egg tempera, metallic acrylic,<br> natural and synthetic pigments on gesso board', '34 x 26 cm (13 x 10 in)', ''),
(9, 'img/img-thumb/1-paintings/damayanti-and-the-swan.jpg', 'Damayanti and the Swan', 'Damayanti and the Swan, 2016', 'Gum arabic, natural pigments on paper', '23 x 16 cm (9 x 6 in)', '*Private collection'),
(10, 'img/img-thumb/1-paintings/riding-the-carpet-of-the-rolling-waves-monks-in-coracles.jpg', 'Riding the Carpet of the Rolling Waves Monks in Coracles', 'Riding the Carpet of the Rolling Waves:<br> Monks in Coracles, 2019', 'Egg tempera, natural pigments on paper', '42 x 24 cm (17 x 9 in)', ''),
(11, 'img/img-thumb/1-paintings/pangur-bán.jpg', 'Pangur Bán', 'Pangur Bán, 2018', '23ct gold leaf, egg tempera,<br> natural pigments on fabriano paper', '23 x 18 cm (9 x 7 in)', '*Sold'),
(12, 'img/img-thumb/2-geometry/ten-fold-geometry.jpg', 'Ten-Fold Geometry', 'Ten-Fold Geometry, 2016', 'Watercolour on paper', '29.5 x 29.5 cm (12 x 12 in)', '*Sold'),
(13, 'img/img-thumb/2-geometry/pink-flower.jpg', 'Pink Flower', 'Pink Flower, 2016', 'Watercolour on paper', '29.5 x 29.5 cm (12 x 12 in)', ''),
(14, 'img/img-thumb/2-geometry/red-flower.jpg', 'Red Flower', 'Red Flower, 2018', 'Watercolour on paper', '29.5 x 29.5 cm (12 x 12 in)', ''),
(15, 'img/img-thumb/2-geometry/daffodils.jpg', 'Daffodils', 'Daffodils, 2018', 'Watercolour on paper', '29.5 x 29.5 cm (12 x 12 in)', ''),
(16, 'img/img-thumb/3-stained-glass/hanging-glass-quarry-phoenix-quarry.jpg', 'Hanging Glass Quarry – Phoenix', 'Hanging Glass Quarry – Phoenix, 2017', 'Lead, solder, stained and coloured glass', '23 x 15.5 cm (9 x 6 in)', '*Sold'),
(17, 'img/img-thumb/3-stained-glass/hanging-glass-quarry-seraphin.jpg', 'Hanging Glass Quarry – Seraphin', 'Hanging Glass Quarry – Seraphin, 2017', 'Lead, solder, stained and coloured glass', '23 x 15.5 cm (9 x 6 in)', '*Private collection'),
(18, 'img/img-thumb/3-stained-glass/hanging-glass-quarry-green-foliage-motif.jpg', 'Hanging Glass Quarry – Green Foliage Motif', 'Hanging Glass Quarry – Green Foliage Motif, 2017', 'Lead, solder, stained and coloured glass', '23 x 15.5 cm (9 x 6 in)', ''),
(19, 'img/img-thumb/3-stained-glass/hanging-glass-quarry-blue-foliage-motif.jpg', 'Hanging Glass Quarry – Blue Foliage Motif', 'Hanging Glass Quarry – Blue Foliage Motif, 2017', 'Lead, solder, stained and coloured glass', '23 x 15.5 cm (9 x 6 in)', '*Private collection'),
(20, 'img/img-thumb/3-stained-glass/foliage-border.jpg', 'Foliage Border', 'Foliage Border, 2016', 'Lead, solder, stained and coloured glass', '19 x 33 cm (7 x 13 in)', ''),
(21, 'img/img-thumb/3-stained-glass/hanging-tree-weeping-willow.jpg', 'Hanging Tree (Weeping Willow)', 'Hanging Tree (Weeping Willow), 2017', 'Lead, solder, stained and coloured glass', '25.5 x 17 cm (10 x 7 in)', ''),
(22, 'img/img-thumb/3-stained-glass/nativity-scene.jpg', 'Nativity Scene', 'Nativity Scene, 2017', 'Lead, solder, stained and coloured glass', '25.5 x 25.5cm (10 x 10 in)', ''),
(23, 'img/img-thumb/3-stained-glass/annunciation-to-the-shepherds.jpg', 'Annunciation to the Shepherds', 'Annunciation to the Shepherds, 2017', 'Lead, solder, stained and coloured glass', '25.5 x 25.5 cm (10 x 10 in)', ''),
(24, 'img/img-thumb/3-stained-glass/three-kings.jpg', 'Three Kings', 'Three Kings, 2017', 'Lead, solder, stained and coloured glass', '25.5 x 25.5 cm (10 x 10 in)', '*Sold'),
(25, 'img/img-thumb/3-stained-glass/angel-1.jpg', 'Angel 1', 'Angel 1, 2016', 'Lead, solder, stained and coloured glass', '58.5 x 23.5 cm (23 x 9&frac14; in)', ''),
(26, 'img/img-thumb/3-stained-glass/angel-2.jpg', 'Angel 2', 'Angel 2, 2017', 'Lead, solder, stained and coloured glass', '58.5 x 23.5 cm (23 x 9&frac14; in)', ''),
(27, 'img/img-thumb/3-stained-glass/virgin-and-child.jpg', 'Virgin and Child', 'Virgin and Child, 2017', 'Lead, solder, stained and coloured glass', '65 x 35.5 cm (26 x 14 in)', ''),
(28, 'img/img-thumb/4-ceramic-tiles/jerusalem-cross-tiles.jpg', 'Jerusalem Cross Tiles', 'Jerusalem Cross Tiles, 2016', 'Fired, glazed red and white clay', '27 x 27 cm (11 x 11 in)', ''),
(29, 'img/img-thumb/4-ceramic-tiles/celtic-key-pattern-cross-tiles.jpg', 'Celtic Key Pattern Cross Tiles', 'Celtic Key Pattern Cross Tiles, 2016', 'Fired, glazed clay', '52 x 40 cm (20 x 16 in)', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aboutContent`
--
ALTER TABLE `aboutContent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product` (`productId`),
  ADD KEY `user_session_id` (`userId`);

--
-- Indexes for table `basketMainNavItems`
--
ALTER TABLE `basketMainNavItems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basketSmallMainNavItems`
--
ALTER TABLE `basketSmallMainNavItems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactForm`
--
ALTER TABLE `contactForm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mainNavItems`
--
ALTER TABLE `mainNavItems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slideshow`
--
ALTER TABLE `slideshow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smallMainNavItems`
--
ALTER TABLE `smallMainNavItems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smallSubNavItems`
--
ALTER TABLE `smallSubNavItems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subNavItems`
--
ALTER TABLE `subNavItems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thumbnailImgs`
--
ALTER TABLE `thumbnailImgs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aboutContent`
--
ALTER TABLE `aboutContent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `basket`
--
ALTER TABLE `basket`
  MODIFY `id` int(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `basketMainNavItems`
--
ALTER TABLE `basketMainNavItems`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `basketSmallMainNavItems`
--
ALTER TABLE `basketSmallMainNavItems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `contactForm`
--
ALTER TABLE `contactForm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `mainNavItems`
--
ALTER TABLE `mainNavItems`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `slideshow`
--
ALTER TABLE `slideshow`
  MODIFY `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `smallMainNavItems`
--
ALTER TABLE `smallMainNavItems`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `smallSubNavItems`
--
ALTER TABLE `smallSubNavItems`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `subNavItems`
--
ALTER TABLE `subNavItems`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `thumbnailImgs`
--
ALTER TABLE `thumbnailImgs`
  MODIFY `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
