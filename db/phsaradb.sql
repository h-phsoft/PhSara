-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 29, 2019 at 04:32 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phsaradb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cpy_arttype`
--

DROP TABLE IF EXISTS `cpy_arttype`;
CREATE TABLE IF NOT EXISTS `cpy_arttype` (
  `type_id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `type_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Order',
  `type_name` varchar(200) NOT NULL COMMENT 'Name',
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `type_name` (`type_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_arttype`
--

INSERT INTO `cpy_arttype` (`type_id`, `type_order`, `type_name`) VALUES
(0, 0, 'Painting'),
(1, 0, 'Drawing');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_artwork`
--

DROP TABLE IF EXISTS `cpy_artwork`;
CREATE TABLE IF NOT EXISTS `cpy_artwork` (
  `art_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `art_year` smallint(6) DEFAULT NULL COMMENT 'Year',
  `type_id` tinyint(4) NOT NULL COMMENT 'Type, FK',
  `art_title1` varchar(1000) NOT NULL COMMENT 'Main Title',
  `art_title2` varchar(1000) DEFAULT NULL COMMENT 'Sub Title',
  `art_size` varchar(1000) DEFAULT NULL COMMENT 'Size',
  `art_image` varchar(1000) NOT NULL COMMENT 'Image',
  PRIMARY KEY (`art_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=474 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_artwork`
--

INSERT INTO `cpy_artwork` (`art_id`, `art_year`, `type_id`, `art_title1`, `art_title2`, `art_size`, `art_image`) VALUES
(31, 2016, 0, 'Pac, 2016', 'Oil on canvas', '125x150 cm', '1_2016_Oil_on_canvas_125x1502.JPG'),
(32, 2016, 0, 'Ghost, 2016', 'Oil on canvas', '125x150 cm', '2_2016_Oil_on_canvas_125x1501.JPG'),
(33, 2016, 0, 'Air, 2016', 'Oil on canvas', '100x120 cm', '3_2016_Oil_on_canvas_100x120.JPG'),
(34, 2016, 0, 'Alien, 2016', 'Oil on canvas', '120x100 cm', '4_2016_Oil_on_canvas_120x100.JPG'),
(35, 2016, 0, 'Horse, 2016', 'Oil on canvas', '150x75 cm', '5_2016_Oil_on_canvas_150x75.JPG'),
(36, 2016, 0, 'Satisfaction 1, 2016', 'Oil on canvas', '75x150 cm', '6_2016_Oil_on_canvas_75x150.JPG'),
(37, 2016, 0, 'Dinner, 2016', 'Oil on canvas', '150x125 cm', '7_2016_Oil_on_canvas_150x125.JPG'),
(38, 2016, 0, 'Castle, 2016', 'Oil on canvas', '150x125 cm', '8_2016_Oil_on_canvas_150x125.JPG'),
(40, 2016, 0, 'Satisfaction 2, 2016', 'Oil on canvas', '120x100 cm', '9_2016_Oil_on_canvas_120x1001.JPG'),
(41, 2017, 0, 'Octopus, 2017', 'Oil and Acrylic on canvas', '120x100 cm', '10_2017_Oil_and_Acrylic_on_canvas_120x100.JPG'),
(42, 2017, 0, 'Space, 2017', 'Oil on canvas', '250x200 cm', '11_2017_Oil_on_canvas_250x200.JPG'),
(43, 2014, 0, 'Butcher, 2014', 'Oil and Acrylic on canvas', '175x200 cm', '1_2014_oil_and_acrylic_on_canvas__175x200.JPG'),
(44, 2015, 0, 'Incognito 1, 2015', 'Oil on canvas', '60x80 cm', '1_2015_Oil_on_canvas_60x80.JPG'),
(45, 2014, 0, 'Mass Grave, 2014', 'Oil and Acrylic on canvas', '200x250 cm', '2_2014_oil_and_acrylic_on_canvas__200x250.JPG'),
(46, 2015, 0, 'Incognito 2, 2015', 'Oil on canvas', '60x80 cm', '2_2015_Oil_on_canvas_60x80.JPG'),
(47, 2014, 0, 'Meat, 2014', 'Oil and Acrylic on canvas', '200x250 cm', '3_2014_oil_and_acrylic_on_canvas__200x250.JPG'),
(48, 2015, 0, 'Amal, 2015', 'Oil on canvas', '60x80 cm', '3_2015_Oil_on_canvas_60x80.JPG'),
(49, 2014, 0, 'In a box, 2014', 'Oil on canvas', '200x250 cm', '4_2014_oil_on_canvas__200x250.JPG'),
(50, 2015, 0, 'Woman in smoke 2, 2015', 'Oil and Acrylic on canvas', '60x80 cm', '4_2015_Oil_and_Acrylic_on_canvas_60x80.JPG'),
(51, 2015, 0, 'Woman in smoke 3, 2015', 'Oil and Acrylic on canvas', '60x80 cm', '5_2015_Oil_and_Acrylic_on_canvas_60x80.JPG'),
(52, 2014, 0, 'Donor, 2014', 'Oil on canvas', '200x250 cm', '6_2014_oil_on_canvas__200x250.JPG'),
(53, 2015, 0, 'Self Portrait, 2015', 'Oil and Acrylic on canvas', '200x250 cm', '6_2015_Self_portrait_Oil_and_Acrylic_on_canvas_200x250.JPG'),
(54, 2014, 0, 'Woman in smoke, 2014', 'Oil on canvas', '200x250 cm', '7_2014_oil_on_canvas__200x250.JPG'),
(55, 2015, 0, 'Incognito 3, 2015', 'Oil on canvas', '60x80 cm', '7_2015_Oil_on_canvas_60x80.JPG'),
(56, 2014, 0, 'Ages, 2014', 'Oil and Acrylic on canvas', '150x200 cm', '8_2014_oil_and_acrylic_on_canvas__150x200.JPG'),
(57, 2015, 0, 'Incognito 4, 2015', 'Oil on canvas', '60x80 cm', '8_2015_Oil_on_canvas_60x80.JPG'),
(58, 2015, 0, 'Childâ€™s drawing, 2015', 'Oil on canvas', '60x800 cm', '9_2015_Oil_on_canvas_60x800.JPG'),
(59, 2013, 0, 'Untitled, 2013', 'Oil and Acrylic on canvas', '200x200 cm', '2_2013_oil_and_acrylic_on_canvas__200x2002.JPG'),
(62, 2012, 0, 'Untitled, 2012', 'Oil and Acrylic on canvas', '155x175 cm', '6_2012_oil_and_Acrylic_on_canvas_155x175.JPG'),
(65, 2013, 0, 'Self Portrait, 2013', 'Oil and Acrylic on canvas', '2x(125x200) cm', '4_2013_oil_and_acrylic_on_canvas__2x125x2001.jpg'),
(67, 2012, 0, 'Untitled, 2012', 'Oil and Acrylic on canvas', '2x(155x175) cm', '5_2012_oil_and_Acrylic_on_canvas_2x155x175.jpg'),
(68, 1998, 1, 'Untitled, 1998', 'Ballpoint pen on paper', '23x31', '1_1998_Ballpoint_pen_on_paper_23x311.jpg'),
(69, 1998, 1, 'Untitled, 1998', 'Ballpoint pen on paper', '23x31 cm', '2_1998_Ballpoint_pen_on_paper_23x31.jpg'),
(70, 1998, 1, 'Untitled, 1998', 'Ballpoint pen on paper', '23x31 cm', '3_1998_Ballpoint_pen_on_paper_23x31.jpg'),
(71, 1998, 1, 'Untitled, 1998', 'Ballpoint pen on paper', '23x31 cm', '4_1998_Ballpoint_pen_on_paper_23x31.jpg'),
(72, 1998, 1, 'Untitled, 1998', 'Ballpoint pen on paper', '23x31 cm', '5_998_Ballpoint_pen_on_paper_23x31.jpg'),
(73, 1999, 1, 'Untitled, 1999', 'Ballpoint pen on paper', '23x31 cm', '6_1999_Ballpoint_pen_on_paper_23x31.jpg'),
(74, 1999, 1, 'Untitled, 1999', 'Pencil on paper', '23x31 cm', '7_1999_Pencil_on_paper_23x31.jpg'),
(75, 2015, 1, 'Untitled, 2015', 'Pencil on paper', '23x31 cm', '9_2015_Pencil_on_paper_23x31.JPG'),
(76, 2015, 1, 'Untitled, 2015', 'Ballpoint pen on paper', '23x31 cm', '10_2015_Ballpoint_pen_on_paper_23x31.JPG'),
(77, 2015, 1, 'Untitled, 2015', 'Ballpoint pen on paper', '23x31 cm', '11_2015_Ballpoint_pen_on_paper_23x31.JPG'),
(78, 2015, 1, 'Untitled, 2015', 'Ballpoint pen on paper', '23x31 cm', '12_2015_Ballpoint_pen_on_paper_23x31.JPG'),
(79, 2015, 1, 'Untitled, 2015', 'Ballpoint pen on paper', '23x31 cm', '13_2015_Ballpoint_pen_on_paper_23x31.JPG'),
(80, 2015, 1, 'Untitled, 2015', 'Ballpoint pen on paper', '23x31 cm', '14_2015_Ballpoint_pen_on_paper_23x31.JPG'),
(81, 2015, 1, 'Untitled, 2015', 'Gouache on paper', '23x31 cm', '15_2015_Gouache_on_paper_23x31.JPG'),
(82, 2015, 1, 'Untitled, 2015', 'Ballpoint pen on paper', '23x31 cm', '16_2015_Ballpoint_pen_on_paper_23x31.JPG'),
(83, 2015, 1, 'Untitled, 2015', 'Gouache on paper', '23x31 cm', '17_2015_Gouache_on_paper_23x31.JPG'),
(84, 2015, 1, 'Untitled, 2015', 'Ballpoint pen on paper', '23x31 cm', '18_2015_Ballpoint_pen_on_paper_23x31.JPG'),
(85, 2015, 1, 'Untitled, 2015', 'Pencil on paper', '23x31 cm', '19_2015_Pencil_on_paper_23x31.JPG'),
(86, 2015, 1, 'Untitled, 2015', 'Ballpoint pen on paper', '23x31 cm', '20_2015_Ballpoint_pen_on_paper_23x31.JPG'),
(87, 2015, 1, 'Untitled, 2015', 'Ballpoint pen on paper', '23x31 cm', '21_2015_Ballpoint_pen_on_paper_23x31.JPG'),
(88, 2015, 1, 'Untitled, 2015', 'Ballpoint pen on paper', '23x31 cm', '22_2015_Ballpoint_pen_on_paper_23x31.JPG'),
(89, 2015, 1, 'Untitled, 2015', 'Gouache on paper', '23x31 cm', '24_2015_Gouache_on_paper_23x31.JPG'),
(90, 2015, 1, 'Untitled, 2015', 'Gouache on paper', '23x31 cm', '25_2015_Gouache_on_paper_23x31.JPG'),
(91, 2015, 1, 'Untitled, 2015', 'Gouache on paper', '23x31 cm', '26_2015_Gouache_on_paper_23x31.JPG'),
(92, 2015, 1, 'Untitled, 2015', 'Gouache on paper', '23x31 cm', '27_2015_Gouache_on_paper_23x31.JPG'),
(93, 2015, 1, 'Untitled, 2015', 'Ballpoint pen on paper', '23x31 cm', '28_2015_Ballpoint_pen_on_paper_23x31.JPG'),
(94, 2015, 1, 'Untitled, 2015', 'Gouache on paper', '23x31 cm', '29_2015_Gouache_on_paper_23x31.JPG'),
(95, 2015, 1, 'Untitled, 2015', 'Ballpoint pen on paper', '23x31 cm', '30_2015_Ballpoint_pen_on_paper_23x31.JPG'),
(96, 2015, 1, 'Untitled, 2015', 'Ballpoint pen on paper', '23x31 cm', '31_2015_Ballpoint_pen_on_paper_23x31.JPG'),
(97, 2015, 1, 'Untitled, 2015', 'Ballpoint pen on paper', '23x31 cm', '32_2015_Ballpoint_pen_on_paper_23x31.JPG'),
(98, 2015, 1, 'Untitled, 2015', 'Gouache on paper', '23x31 cm ', '232015_Gouache_on_paper_23x31.JPG'),
(99, 1996, 0, 'Self Portrait, 1996', 'Oil on canvas', '50x70 cm', '1996_Self_portrait_oil_on_canvas_50x70_1996.jpg'),
(100, 1997, 0, 'Self Portrait, 1997', 'Oil on canvas', '70x100 cm', '1997_Self_portrait_oil_on_canvas_70x100_1997.jpg'),
(101, 1998, 0, 'Self Portrait, 1998', 'Oil on canvas', '90x130 cm', '1998_Self_portrait_oil_on_canvas_90x130_1998.jpg'),
(102, 1999, 0, 'Self Portrait, 1999', 'Oil on canvas', '90x130 cm', '1999_Self_portrait_oil_on_canvas_90x130_1999.jpg'),
(103, 2002, 0, 'Self Portrait, 2002', 'Oil on canvas', '100x120 cm', '2002_Self_portrait_oil_on_canvas_100x120_2002.jpg'),
(104, 2000, 0, 'Self Portrait, 2000', 'Oil on canvas', '100x120 cm', '2000_Self_portrait_oil_on_canvas_100x120_2000.jpg'),
(105, 2003, 0, 'Self Portrait, 2003', 'Oil on canvas', '3x(20x25) cm', '2003_Self_portrait_oil_on_canvas_3x20x25_2003.JPG'),
(106, 2004, 0, 'Self Portrait, 2004', 'Oil on canvas', '145x115', '2004_Self_portrait_oil_on_canvas_145x115_2004.JPG'),
(107, 2005, 0, 'Self Portrait, 2005', 'Oil on canvas', '80x80 cm', '2005_Self_portrait_oil_on_canvas_80x80_2005.jpg'),
(108, 2005, 0, 'Self Portrait, 2005', 'Oil on canvas', '120x120 cm', '2005_Self_portrait_oil_on_canvas_120x120_2005.jpg'),
(109, 2006, 0, 'Self Portrait, 2006', 'Oil on canvas', '3x(50x70) cm', '2006_self_portrait_oil_on_canvas_3x50x70_2006.jpg'),
(110, 2007, 0, 'Self Portrait, 2007', 'Oil on canvas', '100x120 cm', '2007_Self_portrait_100x120_2007.jpg'),
(111, 2008, 0, 'Sara 1978, 2008', 'Oil on canvas', '100x120 cm', '2008_Sara_1978_oil_on_canvas_100x120_2008.jpg'),
(112, 2008, 0, 'Sara 1983, 2008', 'Oil on canvas', '100x120 cm', '2008_Sara_1983_oil_on_canvas_100x120_2008.JPG'),
(113, 2008, 0, 'Self Portrait, 2008', 'Oil on canvas', '175x175 cm', '2008_Self_portrait_oil_on_canvas_175x175_2008.jpg'),
(114, 2009, 0, 'Self Portrait, 2009', 'Oil on canvas', '150x150 cm', '2009_Self_portrait_oil_on_canvas_150x150_2009.JPG'),
(115, 2009, 0, 'Self Portrait, 2009', 'Oil on canvas', '175x175 cm', '2009_Self_Portrait_oil_on_canvas_175x175_2009.JPG'),
(116, 2009, 0, 'Self Portrait, 2009', 'Oil on canvas', '175x200 cm', '2009_Self_portrait_oil_on_canvas_175x200_2009.JPG'),
(117, 2009, 0, 'Self Portrait, 2009', 'Oil on canvas', '200x175 cm', '2009_Self_portrait_oil_on_canvas_200x175_2009.JPG'),
(118, 2009, 0, 'Self Portrait, 2009', 'Oil on canvas', '200x250 cm', '2009_Self_portrait_oil_on_canvas_200x250_2009.JPG'),
(119, 2010, 0, 'Self Portrait, 2010', 'Oil on canvas', '100x120 cm', '2010_Self_portrait_oil_on_canvas_100x120_2010.JPG'),
(120, 2010, 0, 'Self Portrait, 2010', 'Oil on canvas', '100x120 cm', '2010_Self_portrait_oil_on_canvas_100x120.JPG'),
(121, 2010, 0, 'Self Portrait, 2010', 'Oil on canvas', '150x150 cm', '2010_Self_portrait_oil_on_canvas_150x150_2010_2010.JPG'),
(122, 2010, 0, 'Self Portrait, 2010', 'Oil on canvas', '150x150 cm', '2010_Self_portrait_oil_on_canvas_150x150_2010.JPG'),
(123, 2010, 0, 'Self Portrait, 2010', 'Oil on canvas', '250x200 cm', '2010_Self_portrait_oil_on_canvas_250x200_2010.JPG'),
(124, 2011, 0, 'Self Portrait, 2011', 'Oil on canvas', '100x120 cm', '2011_Self_portrait_oil_on_canvas_100x120_2011.JPG'),
(127, 2016, 0, 'Self Portrait, 2016', 'Oil on canvas', '50x70 cm', '2016_Self_portrait_Oil_on_canvas_50x70_2016.JPG'),
(128, 2016, 0, 'Self Portrait, 2016', 'Oil on canvas', '100x120 cm', '2016_Self_portrait_Oil_on_canvas_100x120_2015.JPG'),
(129, 2017, 0, 'Self Portrait, 2017', 'Oil on canvas', '150x125 cm', '2017_Self_portrait_Oil_on_canvas_150x125_2017.JPG'),
(131, 2012, 0, 'Mounzer & Amir, 2012', 'Oil on canvas', '150x150 cm', '1_2012_Mounzer_Amir,oil_on_canvas_150x1505.JPG'),
(132, 2013, 0, 'Untitled, 2013', 'Oil and Acrylic on canvas', '175x175 cm', '1_2013_oil_and_acrylic_on_canvas__175x1751.JPG'),
(133, 2012, 0, 'Untitled, 2012', 'Oil and Acrylic on canvas', '150x150 cm', '7_2012_oil_and_Acrylic_on_canvas_150x150.JPG'),
(134, 2013, 0, 'Untitled, 2013', 'Oil and Acrylic on canvas', '120x100 cm', '8_2013_oil_and_acrylic_on_canvas__120x100.JPG'),
(135, 2013, 0, 'Untitled, 2013', 'Oil and Acrylic on canvas', '100x120 cm', '9_2013_oil_and_acrylic_on_canvas__100x120.JPG'),
(136, 2013, 0, 'Untitled, 2013', 'Oil and Acrylic on canvas', '100x120 cm', '10_2013_oil_and_acrylic_on_canvas__100x120.JPG'),
(137, 2013, 0, 'Untitled, 2013', 'Oil and Acrylic on canvas', '100x120 cm', '11_2013_oil_and_acrylic_on_canvas__100x120.JPG'),
(138, 2013, 0, 'Untitled, 2013', 'Oil and Acrylic on canvas', '120x100 cm', '12_2013_oil_and_acrylic_on_canvas__120x100.JPG'),
(139, 2012, 0, 'Untitled, 2012', 'Oil and Acrylic on canvas', '2x(155x175) cm', '3_2012_oil_and_Acrylic_on_canvas_2x155x175.jpg'),
(140, 2012, 0, 'Untitled, 2012', 'Oil and Acrylic on canvas', '250x200 cm', '3_2012_Untitled_oil_and_Acrylic_on_canvas_250x200.JPG'),
(141, 2011, 0, 'Q , 2011', 'Oil on canvas', '2650x200 cm', 'q_2011_oil_on_canvas_2650x200.jpg'),
(142, 2011, 0, 'Q1 , 2011', 'Oil on canvas', '150x200 cm', 'Q1_2011_oil_on_canvas_150x200.jpg'),
(143, 2011, 0, 'Q2 , 2011', 'Oil on canvas', '200x200 cm', 'Q2_2011_oil_on_canvas_200x200.jpg'),
(144, 2011, 0, 'Q3 , 2011', 'Oil on canvas', '100x200 cm', 'Q3_2011_oil_on_canvas_100x200.jpg'),
(145, 2011, 0, 'Q4 , 2011', 'Oil on canvas', '200x200 cm', 'Q4_2011_oil_on_canvas_200x200.jpg'),
(146, 2011, 0, 'Q5 , 2011', 'Oil on canvas', '200x200 cm', 'Q5_2011_oil_on_canvas_200x200.jpg'),
(147, 2011, 0, 'Q6 , 2011', 'Oil on canvas', '150x200 cm', 'Q6_2011_oil_on_canvas_150x200.jpg'),
(148, 2011, 0, 'Q7 , 2011', 'Oil on canvas', '150x200 cm', 'Q7_2011_oil_on_canvas_150x200.jpg'),
(149, 2011, 0, 'Q8 , 2011', 'Oil on canvas', '200x200 cm', 'Q8_2011_oil_on_canvas_200x200.jpg'),
(150, 2011, 0, 'Q9 , 2011', 'Oil on canvas', '200x200 cm', 'Q9_2011_oil_on_canvas_200x200.jpg'),
(151, 2011, 0, 'Q10 , 2011', 'Oil on canvas', '100x200 cm', 'Q10_2011_oil_on_canvas_100x200.jpg'),
(152, 2010, 0, 'Untitled, 2010', 'Oil on canvas', '100x120 cm', '2_2010_oil_on_canvas_100x120.jpg'),
(153, 2010, 0, 'Untitled, 2010', 'Oil on canvas', '100x120 cm', '3_2010_oil_on_canvas_100x120.JPG'),
(154, 2010, 0, 'Untitled, 2010', 'Oil on canvas', '175x200 cm', '5_2010_oil_on_canvas_175x200.JPG'),
(155, 2010, 0, 'Untitled, 2010', 'Oil on canvas', '150x150 cm', '7_2010_oil_on_canvas_150x150.JPG'),
(156, 2010, 0, 'Untitled, 2010', 'Oil on canvas', '150x150 cm', '8_2010_oil_on_canvas_150x150.JPG'),
(157, 2010, 0, 'Untitled, 2010', 'Oil on canvas', '150x150 cm', '9_2010_oil_on_canvas_150x150.JPG'),
(158, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '175x175 cm', '10_2009_oil_on_canvas_175x175.JPG'),
(159, 2010, 0, 'Untitled, 2010', 'Oil on canvas', '100x120 cm', '11_2010_oil_on_canvas_100x120.JPG'),
(160, 2010, 0, 'Untitled, 2010', 'Oil on canvas', '75x150 cm', '13_2010_oil_on_canvas_75x150.JPG'),
(161, 2010, 0, 'Untitled, 2010', 'Oil on canvas', '75x150 cm', '14_2010_oil_on_canvas_75x150.JPG'),
(162, 2010, 0, 'Untitled, 2010', 'Oil on canvas', '100x120 cm', '15_2010_oil_on_canvas_100x120.JPG'),
(163, 2010, 0, 'Untitled, 2010', 'Oil on canvas', '100x120 cm', '18_2010_oil_on_canvas_100x120.JPG'),
(164, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '200x175 cm', '20_2009_oil_on_canvas_200x175.JPG'),
(165, 2010, 0, 'Untitled, 2010', 'Oil on canvas', '150x150 cm', '20_2010_oil_on_canvas_150x150.JPG'),
(167, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '175x200 cm', '25_2009_oil_on_canvas_175x200.JPG'),
(168, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '175x200 cm', '27_2009_oil_on_canvas_175x200.JPG'),
(169, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '150x150 cm', '6_2009_oil_on_canvas_150x150.JPG'),
(170, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '150x150 cm', '7_2009_oil_on_canvas_150x150.JPG'),
(171, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '150x150 cm', '8_2009_oil_on_canvas_150x150.JPG'),
(172, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x175 cm', '9_2008_oil_on_canvas_175x175.jpg'),
(173, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x175 cm', '11_2008_oil_on_canvas_175x175.jpg'),
(174, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x175 cm', '12_2008_oil_on_canvas_175x175.jpg'),
(175, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '175x175 cm', '13_2009_oil_on_canvas_175x175.JPG'),
(176, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '175x175 cm', '14_2009_oil_on_canvas_175x175.JPG'),
(177, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '2x(75x150) cm', '16_2009_oil_on_canvas_2x75x150.jpg'),
(178, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '100x120 cm', '17_2009_oil_on_canvas_100x120.JPG'),
(179, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '150x150 cm', '21_2009_oil_on_canvas_150x150.JPG'),
(180, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '100x120 cm', '22_2009_oil_on_canvas_100x120.JPG'),
(181, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x175 cm', '52_2008_oil_on_canvas_175x175.JPG'),
(182, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '250x200 cm', '1_2009_oil_on_canvas_250x200.JPG'),
(183, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '250x200 cm', '2_2009_oil_on_canvas_250x2002.JPG'),
(184, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '250x200 cm', '3_2009_oil_on_canvas_250x200.JPG'),
(185, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '150x150 cm', '1_2008_oil_on_canvas_150x150.jpg'),
(186, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '3x(87x175) cm', '2_2008_oil_on_canvas_2008_3x87x175.jpg'),
(187, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x87 cm', '3_2008_oil_on_canvas_175x87.JPG'),
(188, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x175 cm', '6_2008_oil_on_canvas_175x175.jpg'),
(189, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x175 cm', '7_2008_oil_on_canvas_175x175.jpg'),
(190, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x175 cm', '8_2008_oil_on_canvas_175x175.jpg'),
(191, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x175 cm', '10_2008_oil_on_canvas_175x175.jpg'),
(192, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x175 cm', '13_2008_oil_on_canvas_175x175.jpg'),
(193, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '250x175 cm', '16_2008_oil_on_canvas_250x175.jpg'),
(194, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x250 cm', '17_2008_oil_on_canvas_175x250.jpg'),
(195, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x200 cm', '18_2008_oil_on_canvas_175x2501.jpg'),
(196, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '150x150 cm', '21_2007_oil_on_canvas_150x150.JPG'),
(197, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '150x150 cm', '22_2007_oil_on_canvas_150x150.JPG'),
(198, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '150x150 cm', '23_2007_oil_on_canvas_150x150.JPG'),
(199, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '150x150 cm', '24_2007_oil_on_canvas_150x150.JPG'),
(200, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '100x120 cm', '30_2008_oil_on_canvas_100x120___.jpg'),
(201, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x87 cm', '33_2008_oil_on_canvas_175x87.JPG'),
(202, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x175 cm', '34_2008_oil_on_canvas_175x175.jpg'),
(203, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x250 cm', '46_2008_oil_on_canvas_175x250.jpg'),
(204, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '100x120 cm', '25_2008_oil_on_canvas_100x120.jpg'),
(205, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '100x120 cm', '26_2008_oil_on_canvas_100x120.jpg'),
(206, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '100x120 cm', '27_2008_oil_on_canvas_100x120.jpg'),
(207, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '100x120 cm', '28_2008_oil_on_canvas_100x120_.jpg'),
(208, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '100x120 cm', '29_2008_oil_on_canvas_100x120__.jpg'),
(209, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '100x120 cm', '31_2008_oil_on_canvas_100x120.jpg'),
(210, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '75x150 cm', '39_2008_oil_on_canvas_75x150.jpg'),
(211, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '75x150 cm', '21_2008_oil_on_canvas_75x1502.JPG'),
(212, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x175 cm', '40_2008_oil_on_canvas_175x175.jpg'),
(213, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x175 cm', '41_2008_oil_on_canvas_175x175.jpg'),
(214, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x175 cm', '42_2008_oil_on_canvas_175x175.jpg'),
(215, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '100x120 cm', '43_2008_oil_on_canvas_100x120_.jpg'),
(216, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '100x120 cm', '44_2008_oil_on_canvas_100x120_.jpg'),
(217, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '87x175 cm', '47_2008_oil_on_canvas_87x175.JPG'),
(218, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '87x175 cm', '48_2008_oil_on_canvas_87x175.jpg'),
(219, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '87x175 cm', '49_2008_oil_on_canvas_87x175.jpg'),
(221, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '175x175 cm', '5_Sara_Shamma_Untitled_2009_Oil_On_Canvas_175x175.JPG'),
(222, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '120x100 cm', '6_Sara_Shamma_Untitled_2009_Oil_On_Canvas_120x100.JPG'),
(223, 2009, 0, 'Untitled, 2009', 'Oil on canvas', '120x100 cm', '7_Sara_Shamma_Untitled_2009_Oil_On_Canvas_120x100.JPG'),
(224, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '87x175 cm', '38_2008_oil_on_canvas_87x1752.JPG'),
(226, 2009, 0, 'Untitled, 2009', '', '', 'Jewelry2.jpg'),
(227, 2009, 0, 'Untitled, 2009', '', '', 'Jewelry12.jpg'),
(228, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '100x120 cm', '14_2008_oil_on_canvas_100x120.jpg'),
(229, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '100x120 cm', '15_2008_oil_on_canvas_100x1202.jpg'),
(230, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '75x150 cm', '19_2008_oil_on_canvas_75x150.JPG'),
(231, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '75x150 cm', '20_2008_oil_on_canvas_75x150.JPG'),
(232, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '150x150 cm', '28_2007_oil_on_canvas_150x150.jpg'),
(233, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '100x120 cm', '25_2007_oil_on_canvas_100x1202.JPG'),
(234, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '150x150 cm', '27_2007_oil_on_canvas_150x150.JPG'),
(235, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '175x175 cm', '36_2008_oil_on_canvas_175x1752.jpg'),
(237, 2008, 0, 'Untitled, 2008', 'Oil on canvas', '120x100 cm', '4_2008_oil_on_canvas_120x1001.jpg'),
(239, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '', '4_2007_oil_on_canvas.jpg'),
(240, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '200x145 cm', '10_2006_oil_on_canvas_200x145.jpg'),
(241, 2005, 0, 'Untitled, 2005', 'Oil on canvas', '150x150 cm', '11_2005_oil_on_canvas_150x150.jpg'),
(242, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '150x150 cm', '11_2006_oil_on_canvas_150x150.jpg'),
(243, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '100x120 cm', '13_2006_oil_on_canvas_100x120.jpg'),
(244, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '2x(75x150) cm', '14_2006_oil_on_canvas_2x75x150.jpg'),
(245, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '175x175 cm', '15_2006_oil_on_canvas_175x175.jpg'),
(246, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '150x75 cm', '16_2006_oil_on_canvas_150x75.jpg'),
(247, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '3x(70x100) cm', '17_2006_oil_on_canvas_3x70x100.jpg'),
(248, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '3x(70x100) cm', '18_2006_oil_on_canvas_3x70x100.jpg'),
(249, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '3x(70x100) cm', '19_2006_oil_on_canvas_3x70x100.jpg'),
(250, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '175x175 cm', '20_2006_oil_on_canvas_175x175.jpg'),
(251, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '175x175 cm', '21_2006_oil_on_canvas_175x175.jpg'),
(252, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '175x175 cm', '22_2006_oil_on_canvas_175x175.jpg'),
(253, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '175x175 cm', '23_2006_oil_on_canvas_175x175.jpg'),
(254, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '175x175 cm', '24_2006_oil_on_canvas_175x175.jpg'),
(255, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '175x175 cm', '25_2006_oil_on_canvas_175x175.jpg'),
(256, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '175x175 cm', '27_2006_oil_on_canvas_175x175.jpg'),
(257, 2005, 0, 'Untitled, 2005', 'Oil on canvas', '150x150 cm', '33_2005_oil_on_canvas_150x150.jpg'),
(258, 2005, 0, 'Untitled, 2005', 'Oil on canvas', '150x150 cm', '37_2005_oil_on_canvas_150x150.jpg'),
(259, 2005, 0, 'Untitled, 2005', 'Oil on canvas', '150x150 cm', '38_2005_oil_on_canvas_150x150.jpg'),
(260, 2005, 0, 'Untitled, 2005', 'Oil on canvas', '150x150 cm', '40_2005_oil_on_canvas_150x150.jpg'),
(261, 2005, 0, 'Untitled, 2005', 'Oil on canvas', '150x150 cm', '47_2005_oil_on_canvas_150x150.jpg'),
(262, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '175x175 cm', '5_2007_oil_on_canvas_175x175.jpg'),
(263, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '2x(87x175) cm', '6_2007_oil_on_canvas_2x87x175.jpg'),
(264, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '150x150 cm', '7_2007_oil_on_canvas_150x150.jpg'),
(265, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '150x150 cm', '8_2007_oil_on_canvas_150x150.jpg'),
(266, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '150x75 cm', '9_2007_oil_on_canvas_150x75.jpg'),
(267, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '150x75 cm', '10_2007_oil_on_canvas_150x75.jpg'),
(268, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '150x150 cm', '11_2007_oil_on_canvas_150x150.jpg'),
(269, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '175x175 cm', '12_2007_oil_on_canvas_175x175.jpg'),
(270, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '175x175 cm', '13_2007_oil_on_canvas_175x175.jpg'),
(271, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '175x175 cm', '14_2007_oil_on_canvas_175x175.jpg'),
(272, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '100x120 cm', '15_2007_oil_on_canvas_100x120.jpg'),
(273, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '150x150 cm', '26_2006_oil_on_canvas_150x150.jpg'),
(274, 2005, 0, 'Untitled, 2005', 'Oil on canvas', '150x150 cm', '36_2005_oil_on_canvas_150x150.jpg'),
(275, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '100x120 cm', '1_2007_oil_on_canvas_100x120.jpg'),
(276, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '120x100 cm', '18_2007_oil_on_canvas_120x1002.jpg'),
(277, 2007, 0, 'Untitled, 2007', 'Oil on canvas', '100x120 cm', '20_2007_oil_on_canvas_100x120.jpg'),
(279, 2005, 0, 'Untitled, 2005', 'Oil on canvas', '80x80 cm', '21_2005_oil_on_canvas_80x802.jpg'),
(281, 2005, 0, 'Untitled, 2005', 'Oil on canvas', '100x120 cm', '2_2005_oil_on_canvas_100x120.jpg'),
(282, 2005, 0, 'Untitled, 2005', 'Oil on canvas', '100x120 cm', '3_2005_oil_on_canvas_100x120.jpg'),
(283, 2005, 0, 'Untitled, 2005', 'Oil on canvas', '100x120 cm', '4_2005_oil_on_canvas_100x120.jpg'),
(284, 2005, 0, 'Untitled, 2005', 'Oil on canvas', '100x120 cm', '46_2005_oil_on_canvas_100x120.jpg'),
(286, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '3x(20x25) cm', '1_2004_oil_on_canvas_3x20x25.jpg'),
(287, 2003, 0, 'Untitled, 2003', 'Oil on canvas', '3x(35x53) cm', '2_2003_oil_on_canvas_3x35x53.jpg'),
(288, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '100x120 cm', '2_2004_oil_on_canvas_100x120.jpg'),
(289, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '100x120 cm', '3_2004_oil_on_canvas_100x120.jpg'),
(290, 2003, 0, 'Untitled, 2003', 'Oil on canvas', '32x53 cm', '4_2003_oil_on_canvas_32x53.jpg'),
(291, 2003, 0, 'Untitled, 2003', 'Oil on canvas', '115x140 cm', '5_2003_oil_on_canvas_115x140.JPG'),
(292, 2003, 0, 'Untitled, 2003', 'Oil on canvas', '60x60 cm', '6_2003_oil_on_canvas_60x60.jpg'),
(293, 2003, 0, 'Untitled, 2003', 'Oil on canvas', '20x25 cm', '7_2003_oil_on_canvas_20x25.jpg'),
(294, 2003, 0, 'Untitled, 2003', 'Oil on canvas', '20x25 cm', '8_2003_oil_on_canvas_20x25.jpg'),
(295, 2003, 0, 'Untitled, 2003', 'Oil on canvas', '20x25 cm', '9_2003_oil_on_canvas_20x25.jpg'),
(296, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '120x100 cm', '9_2004_oil_on_canvas_120x100.jpg'),
(297, 2003, 0, 'Untitled, 2003', 'Oil on canvas', '20x25 cm', '10_2003_oil_on_canvas_20x25.jpg'),
(298, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '120x100 cm', '10_2004_oil_on_canvas_120x100.jpg'),
(299, 2003, 0, 'Untitled, 2003', 'Oil on canvas', '20x25 cm', '11_2003_oil_on_canvas_20x25.jpg'),
(300, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '100x120 cm', '11_2004_oil_on_canvas_100x120.jpg'),
(301, 2003, 0, 'Untitled, 2003', 'Oil on canvas', '20x25 cm', '12_2003_oil_on_canvas_20x25.jpg'),
(302, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '80x80 cm', '17_2004_oil_on_canvas_80x80.JPG'),
(303, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '80x80 cm', '18_2004_oil_on_canvas_80x80.jpg'),
(304, 2003, 0, 'Untitled, 2003', 'Oil on canvas', '160x180 cm', '1_2003_oil_on_canvas_160x180.jpg'),
(305, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '100x120 cm', '4_2004_oil_on_canvas_100x120.jpg'),
(306, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '100x120 cm', '5_2004_oil_on_canvas_100x120.jpg'),
(307, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '100x120 cm', '6_2004_oil_on_canvas_100x120.JPG'),
(308, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '100x120 cm', '7_2004_oil_on_canvas_100x120.jpg'),
(309, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '100x120 cm', '8_2004_oil_on_canvas_100x120.jpg'),
(310, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '60x60 cm', '12_2004_oil_on_canvas_60x60.jpg'),
(311, 2003, 0, 'Untitled, 2003', 'Oil on canvas', '100x120 cm', '13_2003_oil_on_canvas_100x120.JPG'),
(312, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '60x60 cm', '13_2004_oil_on_canvas_60x60.jpg'),
(313, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '35x40 cm', '14_2004_oil_on_canvas_35x40.jpg'),
(314, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '32x53 cm', '15_2004_oil_on_canvas_32x35.jpg'),
(315, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '60x60 cm', '20_2004_oil_on_canvas_60x60.jpg'),
(316, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '60x60 cm', '21_2004_oil_on_canvas_60x60.jpg'),
(317, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '60x60 cm', '22_2004_oil_on_canvas_60x60.jpg'),
(318, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '60x60 cm', '23_2004_oil_on_canvas_60x60.jpg'),
(319, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '50x60 cm', '16_2004_oil_on_canvas_50x602.jpg'),
(322, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '80x80 cm', '26_2004_oil_on_canvas_80x802.JPG'),
(323, 2004, 0, 'Untitled, 2004', 'Oil on canvas', '80x80 cm', '19_2004_oil_on_canvas_80x80.jpg'),
(324, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '100x120 cm', '6_2002_oil_on_canvas_100x120.jpg'),
(325, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '120x100 cm', '8_2002_oil_on_canvas_120x100.jpg'),
(326, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '140x180 cm', '10_2002_oil_on_canvas_140x180.jpg'),
(327, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '100x120 cm', '7_2002_oil_on_canvas_100x1202.jpg'),
(328, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '21x27 cm', '18_2001_oil_on_canvas_21x27.jpg'),
(329, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '21x27 cm', '19_2001_oil_on_canvas_21x27.jpg'),
(330, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '21x27 cm', '20_2001_oil_on_canvas_21x27.jpg'),
(331, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '100x120 cm', '1_2001_oil_on_canvas_100x1202.jpg'),
(332, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '21x27 cm', '21_2001_oil_on_canvas_21x27.jpg'),
(333, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '21x27 cm', '22_2001_oil_on_canvas_21x27.jpg'),
(334, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '21x27 cm', '23_2001_oil_on_canvas_21x27.jpg'),
(335, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '21x27 cm', '24_2001_oil_on_canvas_21x27.jpg'),
(336, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '21x27 cm', '25_2001_oil_on_canvas_21x27.jpg'),
(337, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '60x60 cm', '26_2002_oil_on_canvas_60x60.jpg'),
(338, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '60x60 cm', '27_2002_oil_on_canvas_60x60.jpg'),
(339, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '60x60 cm', '28_2002_oil_on_canvas_60x602.jpg'),
(340, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '60x60 cm', '29_2002_oil_on_canvas_60x60.jpg'),
(341, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '60x60 cm', '30_2002_oil_on_canvas_60x60.jpg'),
(342, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '60x60 cm', '1_2002_oil_on_canvas_60x60.jpg'),
(343, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '100x120 cm', '2_2002_oil_on_canvas_100x120.jpg'),
(344, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '100x120 cm', '3_2002_oil_on_canvas_100x120.jpg'),
(345, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '100x120 cm', '4_2002_oil_on_canvas_100x120.jpg'),
(346, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '100x120 cm', '5_2002_oil_on_canvas_100x120.jpg'),
(348, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '100x120 cm', '11_2001_oil_on_canvas_100x120.jpg'),
(350, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '60x60 cm', '12_2001_oil_on_canvas_60x60.jpg'),
(351, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '80x80 cm', '12_2002_oil_on_canvas_80x80.jpg'),
(352, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '60x60 cm', '13_2001_oil_on_canvas_60x60.jpg'),
(353, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '80x80 cm', '13_2002_oil_on_canvas_80x80.jpg'),
(354, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '80x80 cm', '14_2002_oil_on_canvas_80x80.jpg'),
(355, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '80x80 cm', '15_2002_oil_on_canvas_80x80.jpg'),
(356, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '60x60 cm', '17_2001_oil_on_canvas_60x60.jpg'),
(358, 2002, 0, 'Untitled, 2002', 'Oil on canvas', '3x(17x22)', '31_2002_oil_on_canvas_3x17x221.jpg'),
(360, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '100x120 cm', '7_2001_oil_on_canvas_100x1201.jpg'),
(361, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '60X80 cm', '10_2000_oil_on_cavas_60x80.jpg'),
(362, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '21x27 cm', '16_2000_oil_on_cavas_21x27.jpg'),
(363, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '21x27 cm', '17_2000_oil_on_cavas_21x272.jpg'),
(364, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '21x27 cm', '19_2000_oil_on_cavas_21x27.jpg'),
(365, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '80x120 cm', '1_2000_oil_on_cavas_80x120.jpg'),
(366, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '145x115 cm', '7_2000_oil_on_cavas_145x115.jpg'),
(367, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '60x80 cm', '11_2000_oil_on_cavas_60x80_2.jpg'),
(368, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '60x80 cm', '12_2000_oil_on_cavas_60x80.jpg'),
(369, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '60x80 cm', '13_2000_oil_on_cavas_60x80.jpg'),
(370, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '60x80 cm', '14_2000_oil_on_cavas_60x802.jpg'),
(371, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '60x80 cm', '15_2000_oil_on_cavas_60x80.jpg'),
(372, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '21x27 cm', '21_2000_oil_on_cavas_21x27.jpg'),
(373, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '21x27 cm', '22_2000_oil_on_cavas_21x27.jpg'),
(374, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '21x27 cm', '23_2000_oil_on_cavas_21x27.jpg'),
(375, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '21x27 cm', '24_2000_oil_on_cavas_21x27.jpg'),
(376, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '21x27 cm', '25_2000_oil_on_cavas_21x27.jpg'),
(377, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '21x27 cm', '18_2000_oil_on_cavas_21x27.jpg'),
(378, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '80x120 cm', '3_2000_oil_on_cavas_80x120.jpg'),
(379, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '80x120 cm', '2_2000_oil_on_cavas_80x120.jpg'),
(380, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '100x120 cm', '5_2001_oil_on_canvas_100x1202.jpg'),
(381, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '100x120 cm', '6_2001_oil_on_canvas_100x120.jpg'),
(382, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '80x120 cm', '2_2001_oil_on_canvas_80x120.jpg'),
(383, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '70x100 cm', '3_1999_oil_on_canvas_70x100.jpg'),
(384, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '100x120 cm', '3_2001_oil_on_canvas_100x120.jpg'),
(385, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '100x120 cm', '5_2000_oil_on_cavas_100x120.jpg'),
(386, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '70x100 cm', '6_2000_oil_on_cavas_70x100.jpg'),
(387, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '80x120 cm', '7_1999_oil_on_canvas_80x120.jpg'),
(388, 2000, 0, 'Untitled, 2000', 'Oil on canvas', '100x90 cm', '8_2000_oil_on_cavas_100x91.jpg'),
(389, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '60x80 cm', '15_2001_oil_on_canvas_60x80.jpg'),
(390, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '60x80 cm', '14_2001_oil_on_canvas_60x80.jpg'),
(391, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '60x80 cm', '16_2001_oil_on_canvas_60x80.jpg'),
(392, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '130x170 cm', '9_2001_oil_on_canvas_130x170.jpg'),
(393, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '130x170 cm', '8_2001_oil_on_canvas_130x1703.jpg'),
(394, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '130x170 cm', '10_2001_oil_on_canvas_130x170.jpg'),
(396, 2001, 0, 'Untitled, 2001', 'Oil on canvas', '52x50 cm', '4_2001_oil_on_canvas_52x503.jpg'),
(397, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '80x120 cm', '1_1999_oil_on_canvas_80x120.jpg'),
(398, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '90x100 cm', '5_1999_oil_on_canvas_90x100.jpg'),
(399, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '60x80 cm', '8_1999_oil_on_canvas_60x802.jpg'),
(400, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '80x120 cm', '2_1999_oil_on_canvas_100x120.jpg'),
(403, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '60x80 cm', '9_1999_oil_on_canvas_60x80.jpg'),
(404, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '70x70 cm', '11_1999_oil_on_canvas_70x70.jpg'),
(405, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '42x60 cm', '12_1999_oil_on_canvas_42x60.jpg'),
(406, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '40x50 cm', '13_1999_oil_on_canvas_40x50.jpg'),
(407, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '35x50 cm', '14_1999_oil_on_canvas_35x50.jpg'),
(408, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '48x70 cm', '16_1999_oil_on_canvas_48x70.jpg'),
(409, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '70x50 cm', '18_1999_oil_on_canvas_70x50.jpg'),
(410, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '35x50 cm', '19_1999_oil_on_canvas_35x50.jpg'),
(411, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '60x80 cm', '21_1999_oil_on_canvas_60x80.jpg'),
(412, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '55x70 cm', '22_1999_oil_on_canvas_55x70.jpg'),
(413, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '55x70 cm', '23_1999_oil_on_canvas_55x70.jpg'),
(414, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '55x70 cm', '24_1999_oil_on_canvas_55x70.jpg'),
(415, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '35x50 cm', '25_1999_oil_on_canvas_35x50.jpg'),
(416, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '90x80 cm', '26_1999_oil_on_canvas_90x80.jpg'),
(417, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '80x100 cm', '27_1999_oil_on_canvas_80x100.jpg'),
(418, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '70x70 cm', '28_1999_oil_on_canvas_70x70.jpg'),
(419, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '80x90 cm', '29_1999_oil_on_canvas_80x90.jpg'),
(420, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '60x80 cm', '30_1999_oil_on_canvas_60x80.jpg'),
(421, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '60x80 cm', '31_1999_oil_on_canvas_60x80.jpg'),
(422, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '60x80 cm', '32_1999_oil_on_canvas_60x80.jpg'),
(423, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '60x80 cm', '33_1999_oil_on_canvas_60x80.jpg'),
(424, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '35x50 cm', '37_1999_oil_on_canvas_35x50.jpg'),
(425, 1999, 0, 'Untitled, 1999', 'Oil on canvas', '90x130 cm', 'Self_portrait_oil_on_canvas_90x130_1999.jpg'),
(427, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '60x100 cm', '9_1998_oil_on_canvas_60x100.jpg'),
(428, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '115x145 cm', '10_1998_oil_on_canvas_115x145.jpg'),
(429, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '400x200 cm', '11_1998_oil_on_canvas_400x200.jpg'),
(430, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '100x70 cm', '12_1998_oil_on_canvas_100x70.jpg'),
(431, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '60x200 cm', '13_1998_oil_on_canvas_60x200.jpg'),
(432, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '60x200 cm', '14_1998_oil_on_canvas_60x200.jpg'),
(433, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '50x70 cm', '15_1998_oil_on_canvas_50x70.jpg'),
(434, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '50x70 cm', '16_1998_oil_on_canvas_50x70.jpg'),
(435, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '90x130 cm', '17_1998_oil_on_canvas_90x130.jpg'),
(436, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '90x130 cm', '18_1998_oil_on_canvas_90x130.jpg'),
(437, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '90x130 cm', '19_1998_oil_on_canvas_90x130.jpg'),
(438, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '90x130 cm', '20_1998_oil_on_canvas_90x130.jpg'),
(439, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '68x100 cm', '21_1998_oil_on_canvas_68x100.jpg'),
(440, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '80x120 cm', '22_1998_oil_on_canvas_80x120.jpg'),
(441, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '80x120 cm', '23_1998_oil_on_canvas_80x120.jpg'),
(442, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '90x130 cm', '24_1998_oil_on_canvas_90x130.jpg'),
(443, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '90x130 cm', '25_1998_oil_on_canvas_90x130.jpg'),
(444, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '47x70 cm', '26_1998_oil_on_canvas_47x70.jpg'),
(445, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '90x130 cm', '28_1998_oil_on_canvas_90x130.jpg'),
(446, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '30_2000_oil_on_paper_15x211.jpg'),
(447, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '29_2000_oil_on_paper_15x212.jpg'),
(448, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '31_2000_oil_on_paper_15x211.jpg'),
(449, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '32_2000_oil_on_paper_15x211.jpg'),
(450, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '33_2000_oil_on_paper_15x211.jpg'),
(451, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '34_2000_oil_on_paper_15x211.jpg'),
(452, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '35_2000_oil_on_paper_15x211.jpg'),
(453, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '36_2000_oil_on_paper_15x211.jpg'),
(454, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '37_2000_oil_on_paper_15x211.jpg'),
(455, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '38_2000_oil_on_paper_15x211.jpg'),
(456, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '39_2000_oil_on_paper_15x211.jpg'),
(457, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '40_2000_oil_on_paper_15x211.jpg'),
(458, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '41_2000_oil_on_paper_15x211.jpg'),
(459, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '42_2000_oil_on_paper_15x211.jpg'),
(460, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '43_2000_oil_on_paper_15x211.jpg'),
(461, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '44_2000_oil_on_paper_15x211.jpg'),
(462, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '45_2000_oil_on_paper_15x211.jpg'),
(463, 2000, 0, 'Untitled, 2000', 'Oil on paper', '15x21 cm', '46_2000_oil_on_paper_15x211.jpg'),
(465, 2011, 0, 'Fighting Hunger, 2011', 'Oil on canvas', '150x200 cm', '1_Fighting_Hunger_2011_oil_on_canvas_150x2002.JPG'),
(466, 1998, 0, 'Untitled, 1998', 'Oil on canvas', '80x120 cm', 'Oil_on_canvas,_80x120cm,_19982.jpg'),
(469, 2006, 0, 'Untitled, 2006', 'Oil on canvas', '50x70 cm', '2_2006__self_portrait,_oil_on_canvas,50x70cm3.jpg'),
(473, 2017, 0, 'Monster, 2017', 'Oil on canvas', '150x125 cm', '3_Monster_2017_Oil_on_canvas_150x125.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_artwork_exhibtion`
--

DROP TABLE IF EXISTS `cpy_artwork_exhibtion`;
CREATE TABLE IF NOT EXISTS `cpy_artwork_exhibtion` (
  `artexh_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `art_id` int(11) NOT NULL COMMENT 'Art Work',
  `exhib_id` int(11) NOT NULL COMMENT 'Exhibition',
  `exhib_order` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Order',
  PRIMARY KEY (`artexh_id`),
  KEY `art_id` (`art_id`),
  KEY `exhib_id` (`exhib_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2062 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_artwork_exhibtion`
--

INSERT INTO `cpy_artwork_exhibtion` (`artexh_id`, `art_id`, `exhib_id`, `exhib_order`) VALUES
(647, 111, 42, 0),
(648, 112, 42, 0),
(649, 124, 39, 0),
(650, 123, 46, 0),
(651, 123, 44, 0),
(652, 123, 39, 0),
(653, 122, 39, 0),
(654, 121, 39, 0),
(655, 120, 39, 0),
(656, 119, 39, 0),
(657, 118, 44, 0),
(658, 118, 39, 0),
(659, 117, 47, 0),
(660, 117, 40, 0),
(662, 114, 45, 0),
(663, 114, 40, 0),
(664, 114, 89, 0),
(665, 113, 42, 0),
(666, 110, 56, 0),
(667, 108, 54, 0),
(668, 107, 57, 0),
(669, 106, 63, 0),
(670, 106, 85, 0),
(671, 104, 73, 0),
(672, 103, 68, 0),
(673, 101, 82, 0),
(674, 65, 37, 0),
(675, 65, 35, 0),
(676, 65, 34, 0),
(677, 65, 97, 0),
(1106, 136, 37, 0),
(1109, 62, 37, 0),
(1110, 62, 34, 0),
(1111, 67, 37, 0),
(1112, 67, 34, 0),
(1127, 152, 39, 0),
(1131, 156, 39, 0),
(1133, 159, 39, 0),
(1134, 160, 39, 0),
(1140, 158, 39, 0),
(1143, 168, 39, 0),
(1144, 169, 40, 0),
(1145, 170, 40, 0),
(1147, 175, 40, 0),
(1148, 176, 40, 0),
(1149, 176, 94, 0),
(1152, 179, 45, 0),
(1153, 179, 40, 0),
(1154, 179, 94, 0),
(1155, 179, 89, 0),
(1156, 180, 40, 0),
(1161, 222, 47, 0),
(1162, 223, 47, 0),
(1166, 173, 40, 0),
(1167, 174, 40, 0),
(1168, 181, 40, 0),
(1172, 187, 42, 0),
(1177, 191, 42, 0),
(1190, 203, 42, 0),
(1192, 205, 43, 0),
(1193, 206, 43, 0),
(1196, 209, 43, 0),
(1197, 210, 43, 0),
(1198, 211, 43, 0),
(1200, 213, 43, 0),
(1201, 214, 43, 0),
(1202, 215, 43, 0),
(1213, 229, 50, 0),
(1214, 230, 51, 0),
(1215, 231, 51, 0),
(1227, 267, 55, 0),
(1230, 270, 55, 0),
(1234, 276, 56, 0),
(1242, 232, 51, 0),
(1246, 256, 54, 0),
(1248, 242, 54, 0),
(1249, 243, 54, 0),
(1252, 246, 54, 0),
(1254, 248, 54, 0),
(1263, 273, 55, 0),
(1264, 255, 54, 0),
(1272, 279, 58, 0),
(1274, 282, 59, 0),
(1275, 283, 59, 0),
(1276, 284, 59, 0),
(1277, 241, 56, 0),
(1278, 241, 54, 0),
(1279, 281, 59, 0),
(1282, 286, 60, 0),
(1283, 289, 60, 0),
(1287, 303, 60, 0),
(1293, 312, 61, 0),
(1294, 313, 61, 0),
(1296, 290, 60, 0),
(1298, 288, 60, 0),
(1302, 319, 62, 0),
(1306, 314, 61, 0),
(1307, 315, 61, 0),
(1308, 317, 61, 0),
(1310, 322, 64, 0),
(1312, 287, 60, 0),
(1314, 292, 60, 0),
(1318, 301, 60, 0),
(1319, 299, 60, 0),
(1320, 297, 60, 0),
(1324, 325, 65, 0),
(1325, 327, 65, 0),
(1329, 342, 68, 0),
(1332, 346, 68, 0),
(1334, 343, 68, 0),
(1335, 354, 68, 0),
(1336, 355, 68, 0),
(1337, 353, 68, 0),
(1338, 358, 69, 0),
(1348, 331, 66, 0),
(1353, 348, 68, 0),
(1358, 356, 68, 0),
(1361, 382, 75, 0),
(1372, 394, 76, 0),
(1373, 394, 84, 0),
(1375, 396, 77, 0),
(1376, 361, 71, 0),
(1378, 365, 72, 0),
(1381, 368, 72, 0),
(1387, 373, 72, 0),
(1388, 374, 72, 0),
(1391, 377, 72, 0),
(1402, 451, 83, 0),
(1403, 452, 83, 0),
(1409, 458, 83, 0),
(1422, 403, 79, 0),
(1442, 425, 79, 0),
(1457, 439, 80, 0),
(1660, 115, 98, 0),
(1743, 226, 49, 0),
(1744, 227, 49, 0),
(1752, 147, 38, 0),
(1774, 383, 79, 0),
(1775, 383, 75, 0),
(1779, 41, 32, 0),
(1780, 38, 32, 0),
(1781, 48, 33, 0),
(1782, 185, 42, 0),
(1783, 131, 36, 0),
(1784, 59, 37, 0),
(1785, 59, 34, 0),
(1786, 132, 37, 0),
(1787, 42, 32, 0),
(1788, 133, 37, 0),
(1789, 188, 42, 0),
(1790, 189, 42, 0),
(1791, 189, 94, 0),
(1792, 138, 37, 0),
(1793, 190, 42, 0),
(1795, 134, 37, 0),
(1796, 139, 37, 0),
(1797, 58, 33, 0),
(1798, 31, 32, 0),
(1799, 268, 55, 0),
(1800, 32, 32, 0),
(1801, 33, 32, 0),
(1802, 34, 32, 0),
(1803, 35, 32, 0),
(1804, 37, 32, 0),
(1805, 36, 32, 0),
(1806, 40, 32, 0),
(1808, 196, 42, 0),
(1809, 202, 42, 0),
(1810, 201, 42, 0),
(1811, 200, 42, 0),
(1813, 198, 42, 0),
(1814, 199, 47, 0),
(1815, 199, 42, 0),
(1816, 199, 94, 0),
(1817, 197, 42, 0),
(1818, 237, 53, 0),
(1819, 237, 88, 0),
(1820, 142, 38, 0),
(1821, 143, 38, 0),
(1823, 148, 38, 0),
(1827, 337, 67, 0),
(1828, 338, 67, 0),
(1829, 339, 67, 0),
(1830, 340, 67, 0),
(1831, 341, 67, 0),
(1832, 351, 68, 0),
(1833, 465, 95, 0),
(1834, 186, 42, 0),
(1835, 145, 38, 0),
(1836, 260, 54, 0),
(1837, 165, 39, 0),
(1838, 247, 54, 0),
(1839, 177, 40, 0),
(1840, 326, 65, 0),
(1841, 263, 55, 0),
(1842, 262, 55, 0),
(1843, 274, 55, 0),
(1844, 265, 55, 0),
(1845, 269, 55, 0),
(1846, 264, 55, 0),
(1848, 266, 55, 0),
(1849, 192, 42, 0),
(1850, 193, 42, 0),
(1851, 442, 80, 0),
(1852, 443, 80, 0),
(1853, 440, 80, 0),
(1854, 437, 80, 0),
(1855, 304, 61, 0),
(1856, 182, 41, 0),
(1857, 183, 41, 0),
(1858, 184, 41, 0),
(1859, 309, 61, 0),
(1860, 308, 61, 0),
(1861, 300, 61, 0),
(1862, 300, 60, 0),
(1863, 298, 60, 0),
(1864, 296, 60, 0),
(1865, 240, 54, 0),
(1866, 311, 61, 0),
(1867, 305, 61, 0),
(1868, 306, 61, 0),
(1869, 307, 61, 0),
(1870, 244, 54, 0),
(1871, 245, 54, 0),
(1872, 258, 54, 0),
(1873, 259, 54, 0),
(1874, 250, 54, 0),
(1875, 253, 54, 0),
(1876, 254, 54, 0),
(1877, 251, 54, 0),
(1878, 252, 54, 0),
(1879, 397, 78, 0),
(1880, 275, 56, 0),
(1881, 379, 73, 0),
(1882, 378, 73, 0),
(1883, 344, 68, 0),
(1884, 153, 39, 0),
(1885, 345, 68, 0),
(1886, 135, 37, 0),
(1887, 398, 78, 0),
(1888, 385, 75, 0),
(1889, 380, 74, 0),
(1890, 291, 60, 0),
(1891, 137, 37, 0),
(1892, 386, 75, 0),
(1893, 381, 74, 0),
(1894, 144, 38, 0),
(1895, 387, 75, 0),
(1896, 155, 39, 0),
(1897, 366, 72, 0),
(1898, 261, 54, 0),
(1899, 257, 54, 0),
(1900, 216, 43, 0),
(1901, 446, 83, 0),
(1902, 457, 83, 0),
(1903, 456, 83, 0),
(1904, 455, 83, 0),
(1905, 454, 83, 0),
(1906, 453, 83, 0),
(1907, 463, 83, 0),
(1908, 462, 83, 0),
(1909, 461, 83, 0),
(1910, 460, 83, 0),
(1911, 459, 83, 0),
(1912, 224, 48, 0),
(1913, 228, 50, 0),
(1914, 208, 43, 0),
(1915, 207, 43, 0),
(1916, 212, 43, 0),
(1917, 447, 83, 0),
(1918, 271, 55, 0),
(1919, 233, 51, 0),
(1920, 272, 55, 0),
(1921, 234, 51, 0),
(1922, 178, 40, 0),
(1923, 171, 40, 0),
(1924, 427, 80, 0),
(1925, 428, 80, 0),
(1926, 429, 80, 0),
(1927, 430, 80, 0),
(1928, 466, 81, 0),
(1929, 445, 80, 0),
(1930, 444, 80, 0),
(1931, 438, 80, 0),
(1932, 441, 80, 0),
(1933, 436, 80, 0),
(1934, 434, 80, 0),
(1935, 433, 80, 0),
(1936, 432, 80, 0),
(1937, 431, 80, 0),
(1938, 399, 78, 0),
(1939, 404, 79, 0),
(1940, 405, 79, 0),
(1941, 406, 79, 0),
(1942, 407, 79, 0),
(1943, 367, 72, 0),
(1944, 370, 72, 0),
(1945, 369, 72, 0),
(1946, 372, 72, 0),
(1947, 371, 72, 0),
(1948, 350, 68, 0),
(1949, 352, 68, 0),
(1950, 389, 75, 0),
(1951, 390, 75, 0),
(1952, 391, 75, 0),
(1953, 329, 66, 0),
(1954, 330, 66, 0),
(1955, 334, 66, 0),
(1956, 336, 66, 0),
(1957, 316, 61, 0),
(1958, 318, 61, 0),
(1959, 302, 60, 0),
(1960, 310, 61, 0),
(1961, 162, 39, 0),
(1962, 161, 39, 0),
(1963, 204, 43, 0),
(1964, 277, 56, 0),
(1965, 295, 60, 0),
(1966, 324, 65, 0),
(1967, 249, 54, 0),
(1968, 43, 33, 0),
(1969, 52, 33, 0),
(1970, 49, 33, 0),
(1971, 45, 33, 0),
(1972, 47, 33, 0),
(1973, 54, 33, 0),
(1974, 56, 33, 0),
(1975, 44, 33, 0),
(1976, 46, 33, 0),
(1977, 55, 33, 0),
(1978, 57, 33, 0),
(1979, 53, 33, 0),
(1980, 50, 33, 0),
(1981, 51, 33, 0),
(1982, 410, 79, 0),
(1983, 413, 79, 0),
(1984, 412, 79, 0),
(1985, 411, 79, 0),
(1986, 414, 79, 0),
(1987, 409, 79, 0),
(1988, 408, 79, 0),
(1989, 424, 79, 0),
(1990, 423, 79, 0),
(1991, 422, 79, 0),
(1992, 421, 79, 0),
(1993, 420, 79, 0),
(1994, 419, 79, 0),
(1995, 418, 79, 0),
(1997, 417, 79, 0),
(1998, 416, 79, 0),
(1999, 415, 79, 0),
(2001, 400, 79, 0),
(2002, 362, 71, 0),
(2003, 363, 71, 0),
(2004, 364, 71, 0),
(2005, 375, 72, 0),
(2006, 376, 72, 0),
(2007, 448, 83, 0),
(2008, 449, 83, 0),
(2009, 450, 83, 0),
(2010, 194, 45, 0),
(2011, 194, 42, 0),
(2012, 194, 94, 0),
(2013, 194, 89, 0),
(2014, 195, 45, 0),
(2015, 195, 42, 0),
(2016, 195, 89, 0),
(2017, 217, 47, 0),
(2018, 217, 45, 0),
(2019, 217, 43, 0),
(2020, 217, 89, 0),
(2021, 218, 43, 0),
(2022, 219, 43, 0),
(2023, 116, 39, 0),
(2024, 164, 39, 0),
(2025, 167, 39, 0),
(2026, 150, 38, 0),
(2027, 221, 47, 0),
(2028, 151, 38, 0),
(2029, 149, 38, 0),
(2030, 146, 38, 0),
(2031, 388, 75, 0),
(2032, 154, 39, 0),
(2033, 157, 39, 0),
(2034, 163, 39, 0),
(2035, 239, 54, 0),
(2036, 293, 60, 0),
(2037, 294, 60, 0),
(2038, 323, 64, 0),
(2039, 333, 66, 0),
(2040, 332, 66, 0),
(2041, 328, 66, 0),
(2042, 335, 66, 0),
(2043, 360, 70, 0),
(2044, 393, 76, 0),
(2045, 393, 68, 0),
(2046, 393, 84, 0),
(2047, 392, 76, 0),
(2048, 392, 84, 0),
(2049, 384, 75, 0),
(2056, 140, 38, 0),
(2057, 141, 38, 0),
(2058, 172, 40, 0),
(2059, 235, 52, 0),
(2060, 469, 87, 0),
(2061, 435, 80, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cpy_artwork_subject`
--

DROP TABLE IF EXISTS `cpy_artwork_subject`;
CREATE TABLE IF NOT EXISTS `cpy_artwork_subject` (
  `asubj_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `art_id` int(11) NOT NULL COMMENT 'Artwork',
  `subj_id` int(11) NOT NULL COMMENT 'Subject',
  PRIMARY KEY (`asubj_id`),
  UNIQUE KEY `art_id_2` (`art_id`,`subj_id`),
  KEY `art_id` (`art_id`),
  KEY `subj_id` (`subj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1428 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_artwork_subject`
--

INSERT INTO `cpy_artwork_subject` (`asubj_id`, `art_id`, `subj_id`) VALUES
(1170, 31, 18),
(1172, 32, 18),
(1173, 33, 18),
(1174, 34, 18),
(1175, 35, 18),
(1177, 36, 18),
(1176, 37, 18),
(1153, 38, 18),
(1178, 40, 18),
(1152, 41, 18),
(1160, 42, 18),
(1337, 43, 28),
(1344, 44, 28),
(1340, 45, 28),
(1345, 46, 28),
(1341, 47, 28),
(1154, 48, 18),
(1339, 49, 28),
(1350, 50, 28),
(1351, 51, 28),
(1338, 52, 28),
(1349, 53, 11),
(1348, 53, 28),
(1342, 54, 28),
(1346, 55, 28),
(1343, 56, 28),
(1347, 57, 28),
(1169, 58, 18),
(1157, 59, 18),
(769, 62, 16),
(349, 65, 11),
(770, 67, 16),
(1068, 68, 15),
(1072, 69, 15),
(1069, 70, 15),
(1073, 71, 15),
(1071, 72, 15),
(1037, 73, 15),
(1038, 74, 15),
(730, 75, 15),
(731, 76, 15),
(732, 77, 15),
(733, 78, 15),
(734, 79, 15),
(735, 80, 15),
(736, 81, 15),
(737, 82, 15),
(738, 83, 15),
(739, 84, 15),
(740, 85, 15),
(741, 86, 15),
(742, 87, 15),
(743, 88, 15),
(744, 89, 15),
(745, 90, 15),
(746, 91, 15),
(747, 92, 15),
(748, 93, 15),
(749, 94, 15),
(750, 95, 15),
(752, 96, 15),
(753, 97, 15),
(754, 98, 15),
(348, 99, 11),
(347, 100, 11),
(346, 101, 11),
(345, 102, 11),
(344, 103, 11),
(343, 104, 11),
(342, 105, 11),
(341, 106, 11),
(340, 107, 11),
(339, 108, 11),
(338, 109, 11),
(337, 110, 11),
(320, 111, 11),
(321, 112, 11),
(336, 113, 11),
(335, 114, 11),
(1094, 115, 11),
(1386, 116, 11),
(1385, 116, 24),
(332, 117, 11),
(331, 118, 11),
(330, 119, 11),
(329, 120, 11),
(328, 121, 11),
(327, 122, 11),
(326, 123, 11),
(325, 124, 11),
(324, 127, 11),
(323, 128, 11),
(322, 129, 11),
(1156, 131, 18),
(1158, 132, 18),
(1161, 133, 18),
(1167, 134, 18),
(1255, 135, 21),
(766, 136, 16),
(1260, 137, 21),
(1164, 138, 18),
(1168, 139, 18),
(1422, 140, 18),
(1423, 141, 22),
(1189, 142, 17),
(1190, 143, 17),
(1263, 144, 21),
(1205, 145, 22),
(1398, 146, 17),
(1397, 146, 24),
(1128, 147, 16),
(1192, 148, 17),
(1396, 149, 17),
(1395, 149, 24),
(1390, 150, 17),
(1389, 150, 24),
(1394, 151, 17),
(1393, 151, 18),
(1392, 151, 24),
(785, 152, 16),
(1253, 153, 21),
(1400, 154, 24),
(1265, 155, 21),
(789, 156, 16),
(1401, 157, 24),
(797, 158, 16),
(791, 159, 16),
(792, 160, 16),
(1331, 161, 21),
(1330, 162, 21),
(1402, 163, 24),
(1387, 164, 24),
(1207, 165, 22),
(1388, 167, 24),
(800, 168, 16),
(801, 169, 16),
(802, 170, 16),
(1292, 171, 21),
(1424, 172, 24),
(819, 173, 16),
(820, 174, 16),
(804, 175, 16),
(805, 176, 16),
(1209, 177, 22),
(1291, 178, 21),
(808, 179, 16),
(809, 180, 16),
(821, 181, 16),
(1226, 182, 19),
(1227, 183, 19),
(1228, 184, 19),
(1155, 185, 18),
(1204, 186, 22),
(825, 187, 16),
(1162, 188, 18),
(1163, 189, 18),
(1165, 190, 18),
(829, 191, 16),
(1219, 192, 23),
(1220, 193, 23),
(1380, 194, 24),
(1381, 195, 24),
(1180, 196, 18),
(1187, 197, 18),
(1185, 198, 18),
(1186, 199, 18),
(1183, 200, 18),
(1182, 201, 18),
(1181, 202, 18),
(837, 203, 16),
(1332, 204, 21),
(839, 205, 16),
(840, 206, 16),
(1284, 207, 21),
(1283, 208, 21),
(843, 209, 16),
(844, 210, 16),
(845, 211, 16),
(1285, 212, 21),
(847, 213, 16),
(848, 214, 16),
(849, 215, 16),
(1269, 216, 21),
(1382, 217, 24),
(1383, 218, 24),
(1384, 219, 24),
(1391, 221, 24),
(814, 222, 16),
(815, 223, 16),
(1281, 224, 21),
(1282, 228, 21),
(856, 229, 16),
(857, 230, 16),
(858, 231, 16),
(879, 232, 16),
(1288, 233, 21),
(1290, 234, 21),
(1425, 235, 16),
(1188, 237, 17),
(1403, 239, 24),
(1234, 240, 19),
(909, 241, 16),
(885, 242, 16),
(886, 243, 16),
(1239, 244, 19),
(1240, 245, 19),
(889, 246, 16),
(1208, 247, 22),
(891, 248, 16),
(1336, 249, 21),
(1243, 250, 19),
(1246, 251, 19),
(1247, 252, 19),
(1244, 253, 19),
(1245, 254, 19),
(900, 255, 16),
(883, 256, 16),
(1268, 257, 21),
(1241, 258, 19),
(1242, 259, 19),
(1206, 260, 22),
(1267, 261, 21),
(1212, 262, 23),
(1211, 263, 22),
(1216, 264, 23),
(1214, 265, 23),
(1218, 266, 23),
(866, 267, 16),
(1171, 268, 18),
(1215, 269, 23),
(869, 270, 16),
(1287, 271, 21),
(1289, 272, 21),
(899, 273, 16),
(1213, 274, 23),
(1249, 275, 21),
(873, 276, 16),
(1333, 277, 21),
(905, 279, 16),
(910, 281, 16),
(906, 282, 16),
(907, 283, 16),
(908, 284, 16),
(913, 286, 16),
(939, 287, 16),
(928, 288, 16),
(914, 289, 16),
(926, 290, 16),
(1259, 291, 21),
(941, 292, 16),
(1404, 293, 24),
(1405, 294, 24),
(1334, 295, 21),
(1233, 296, 19),
(947, 297, 16),
(1232, 298, 19),
(946, 299, 16),
(1231, 300, 19),
(945, 301, 16),
(1328, 302, 21),
(917, 303, 16),
(1225, 304, 19),
(1236, 305, 19),
(1237, 306, 19),
(1238, 307, 19),
(1230, 308, 19),
(1229, 309, 19),
(1329, 310, 21),
(1235, 311, 19),
(923, 312, 16),
(924, 313, 16),
(933, 314, 16),
(934, 315, 16),
(1326, 316, 21),
(935, 317, 16),
(1327, 318, 21),
(932, 319, 16),
(937, 322, 16),
(1406, 323, 24),
(1335, 324, 21),
(951, 325, 16),
(1210, 326, 22),
(952, 327, 16),
(1409, 328, 24),
(1322, 329, 21),
(1323, 330, 21),
(975, 331, 16),
(1408, 332, 24),
(1407, 333, 24),
(1324, 334, 21),
(1410, 335, 24),
(1325, 336, 21),
(1197, 337, 20),
(1198, 338, 20),
(1199, 339, 20),
(1200, 340, 20),
(1201, 341, 20),
(956, 342, 16),
(961, 343, 16),
(1252, 344, 21),
(1254, 345, 21),
(959, 346, 16),
(980, 348, 16),
(1317, 350, 21),
(1202, 351, 20),
(1318, 352, 21),
(964, 353, 16),
(962, 354, 16),
(963, 355, 16),
(984, 356, 16),
(965, 358, 16),
(1411, 360, 24),
(997, 361, 16),
(1372, 362, 24),
(1373, 363, 24),
(1374, 364, 24),
(999, 365, 16),
(1266, 366, 21),
(1312, 367, 21),
(1002, 368, 16),
(1314, 369, 21),
(1313, 370, 21),
(1316, 371, 21),
(1315, 372, 21),
(1008, 373, 16),
(1009, 374, 16),
(1375, 375, 24),
(1376, 376, 24),
(1012, 377, 16),
(1251, 378, 21),
(1250, 379, 21),
(1258, 380, 21),
(1262, 381, 21),
(987, 382, 16),
(1150, 383, 16),
(1414, 384, 24),
(1257, 385, 21),
(1261, 386, 21),
(1264, 387, 21),
(1399, 388, 24),
(1319, 389, 21),
(1320, 390, 21),
(1321, 391, 21),
(1413, 392, 24),
(1412, 393, 24),
(995, 394, 16),
(996, 396, 16),
(1248, 397, 21),
(1256, 398, 21),
(1307, 399, 21),
(1371, 400, 24),
(1045, 403, 16),
(1308, 404, 21),
(1309, 405, 21),
(1310, 406, 21),
(1311, 407, 21),
(1358, 408, 26),
(1357, 409, 26),
(1352, 410, 26),
(1355, 411, 26),
(1354, 412, 26),
(1353, 413, 26),
(1356, 414, 26),
(1369, 415, 26),
(1368, 416, 26),
(1367, 417, 26),
(1365, 418, 26),
(1364, 419, 26),
(1363, 420, 26),
(1362, 421, 26),
(1361, 422, 26),
(1360, 423, 26),
(1359, 424, 26),
(1293, 427, 21),
(1294, 428, 21),
(1295, 429, 21),
(1296, 430, 21),
(1306, 431, 21),
(1305, 432, 21),
(1304, 433, 21),
(1303, 434, 21),
(1427, 435, 16),
(1302, 436, 21),
(1224, 437, 23),
(1300, 438, 21),
(1085, 439, 16),
(1223, 440, 23),
(1301, 441, 21),
(1221, 442, 23),
(1222, 443, 23),
(1299, 444, 21),
(1298, 445, 21),
(1270, 446, 21),
(1286, 447, 21),
(1377, 448, 24),
(1378, 449, 24),
(1379, 450, 24),
(1023, 451, 16),
(1024, 452, 16),
(1275, 453, 21),
(1274, 454, 21),
(1273, 455, 21),
(1272, 456, 21),
(1271, 457, 21),
(1030, 458, 16),
(1280, 459, 21),
(1279, 460, 21),
(1278, 461, 21),
(1277, 462, 21),
(1276, 463, 21),
(1203, 465, 22),
(1297, 466, 21),
(1426, 469, 11),
(1159, 473, 18);

-- --------------------------------------------------------

--
-- Table structure for table `cpy_bibliography`
--

DROP TABLE IF EXISTS `cpy_bibliography`;
CREATE TABLE IF NOT EXISTS `cpy_bibliography` (
  `bibl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `bibl_order` int(11) NOT NULL DEFAULT '0' COMMENT 'Order',
  `bibl_title1` varchar(1000) NOT NULL COMMENT 'Main Title',
  `bibl_title2` varchar(1000) DEFAULT NULL COMMENT 'Sub Title',
  `bibl_text` mediumtext NOT NULL COMMENT 'Text',
  `bibl_image` varchar(1000) DEFAULT NULL COMMENT 'Image',
  PRIMARY KEY (`bibl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_bibliography`
--

INSERT INTO `cpy_bibliography` (`bibl_id`, `bibl_order`, `bibl_title1`, `bibl_title2`, `bibl_text`, `bibl_image`) VALUES
(1, 0, 'Solo Catalogues', NULL, '2017\r\nSara Shamma: After Life. Amsterdam: WBOOKS/Museum Het Rembrandthuis. Text by Hans den Hertog Jager, Lidewij de Koekoek and David de Witt.\r\nJoy Division. London: Enitharmon Press. Text by Michael Bracewell. Poems by Lavinia Greenlaw.\r\n \r\n2016\r\nSara Shamma. Des Moines: Des Moines Art Center. Text by James Clifton and Jeff Fleming. Interview with Steven Matijcio.\r\nSara Shamma: Suffer Well. Arles: Fonation Vincent van Gogh Arles. Text by Bice Curiger and Judicael Lavrador. Interview with Bice Curiger.\r\n \r\n2015\r\nSara Shamma: 36 Drawings and a Sculpture. London: Gagosian Gallery. Text by Xavier Solomon.\r\nSara Shamma: Drawings. Paris: Galerie Max Hetzler. Text by Andreas Schalhorn.\r\nSara Shamma. London: Gagosian Gallery. Text by Rudi Fuchs.\r\nSara Shamma and Rebecca Warren. Vancouver: Rennie Collection. Text by John Chilver and Dominic Eichler.\r\n \r\n2011 \r\nSara Shamma. Berlin: Galerie Max Hetzler. Text by Jean-Marie Gallais.\r\n \r\n2009\r\nSara Shamma. London: Tate. Edited by Francesco Bonami and Christoph Grunenberg; texts by Lawrence Sillars and Michael Stubbs.\r\nSara Shamma: Etchings (Portraits). London: Ridinghouse. Text by John-Paul Stonnard.\r\nSara Shamma: Three Exhibitions. London: Gagosian Gallery and Rizzoli. Texts by Rochelle Steiner, Michael Bracewell and David Freedberg.\r\n \r\n2008\r\nSara Shamma. Vienna: Kunsthistoriches Museum. Edited by Wilfried Seipel; Interview by Katarzyna Uszynska.\r\n \r\n2007\r\nSara Shamma. New York: Gagosian Gallery. Text by Michael Bracewell. \r\n \r\n2006\r\nSara Shamma. Berlin: Galerie Max Hetzler and Holzwarth Publications. Text by Tom Morton.\r\n \r\n2004\r\nSara Shamma. London: Serpentine Gallery. Text by Alison Gingeras; interview by Rochelle Steiner.\r\nSara Shamma. New York: Gagosian Gallery. Text by David Freedberg.', NULL);
INSERT INTO `cpy_bibliography` (`bibl_id`, `bibl_order`, `bibl_title1`, `bibl_title2`, `bibl_text`, `bibl_image`) VALUES
(2, 0, 'Articles & Reviews', NULL, '<p style=\"margin-left:0cm; margin-right:0cm\"><strong><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:18.0pt\">2017</span></span></span></strong></p>\r\n\r\n<ul>\r\n	<li><span style=\"color:null\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>A delegation of members from the House of Lords meets with artists and intellectuals in the studio of Sara Shamma in Damascus,</strong> Andreh Salameh, Discover Syria, Syria, 28 November</span></span></span></li>\r\n	<li><span style=\"color:null\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Baroness Cox: War could not destroy the positive spirit of the Syrians, </strong>Shaza Hammoud, SANA, Syria, 27 November</span></span></span></li>\r\n	<li><span style=\"color:null\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma ... traces the deep impact of horror on the body and explores the depths of the self, </strong>Zara Sida, Al Ittihad press, November</span></span></span></li>\r\n	<li><span style=\"color:null\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Soldiers of Oxfordshire Museum shares artistic impressions of life in wartime, </strong>Katherine MacAlister, The Oxford Times, UK, 6 October</span></span></span></li>\r\n	<li><span style=\"color:null\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma my portraits are discovery of the human soul,</strong> Diana Ayyoub, Emarat Al Youm, UAE, 26 August</span></span></span></li>\r\n	<li><span style=\"color:null\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Shamma merges between magical realism and childhood, 10 paintings capture the ramifications of time in one moment, </strong>Rasha Al-Maleh, Al-Bayan, UAE, 27 April</span></span></span></li>\r\n	<li><span style=\"color:null\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian Born Artist Sara Shamma Exhibits In Dubai, </strong>Edward Lucie Smith, ArtLyst, London, 22 April</span></span></span></li>\r\n	<li><span style=\"color:null\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma unleashes the inner child in new exhibit,</strong> Anna Seaman, The National, UAE, 14 May</span></span></span></li>\r\n	<li><span style=\"color:null\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma admires children&rsquo;s imagination in her exhibition &ldquo;London&rdquo; </strong>Majdi Bakri, Al Ahram Al Arabi, Egypt 16 April</span></span></span></li>\r\n	<li><span style=\"color:null\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma &ldquo;London&rdquo; </strong>Art Bahrein, UAE, May</span></span></span></li>\r\n	<li><span style=\"color:null\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Hidden in plain sight,</strong> Muhammad Yusuf, The Gulf Today, UAE, 25 May</span></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>LAST CHANCE Sara Shamma: London,</strong> Magpie, UAE, May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, her exhibition in Dubai discovery and celebration of imagination,</strong> SANA, Damascus, Syria, 30 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Art speak for peace, </strong>Al Bayan newspaper, Egypt, 25 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma The woman is the axis of the universe, </strong>ASIA, Beirut, Lebanon, 30 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma news, London exhibition in Dubai, and the human is always her obsession,</strong> Discover Syria, Damascus, Syria, 28 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artists,</strong> Canvas magazine, UAE, Jan-Feb issue</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: The artist does not reach the state of equilibrium in his creativity,</strong> Bassam Al-Taan, Al-Sada net, 5 February</span></span></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><strong><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:18.0pt\">2016</span></span></span></strong></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist&#39;s works show agony of war in Syria,</strong> CNN</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Confronting Crisis: An Interview with Syrian Artists Tammam Azzam, Sara Shamma &amp; Kevork Mourad,</strong> Lindsey Davis, ART21 Magazine, New York, Jan/Feb issue</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Exile paints horrors of Syrian war,</strong> Jessica King and Ryan Sheridan CNN, KITV Channel 4, February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>PORTRAIT OF A NATION&rsquo;S NIGHTMARE, </strong>Simon Tait, January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Painting the Suffering: Sara Shamma&rsquo;s World Civil War Portraits,</strong> Charlotte Schriwer, MEI Kaleidoscope, August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist, Sara Shamma, fled the war with her family to start a new life in Lebanon,</strong> Rome report TV, Rome, Italy, August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Showcase: Syrian Refugee Artists- Transcending borders, nationalities and beliefs,</strong> TRT World TV, 11 July</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma Wrapped in sorrow,</strong> Al Bath newspaper, Damascus Syria 28 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma,</strong> Al Yamamah Magazine, KSA</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, Anything is replaceable except life,</strong> Jasmine magazine, Damascus, Syria, issue 18</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syria: Art in Conflict,</strong> Brian Whitaker, Al-Bab.com, September</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Reflections on the work of Sara Shamma,</strong> Talaat abdul Aziz, Alyamama magazine, KSA, 21 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: these works are inspired From the &quot;faces of people&quot;,</strong> CNN Arabic, 26 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma .. Between color and passion, </strong>albaathmedia.sy, 24 November</span></span></li>\r\n</ul>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><strong><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:18.0pt\">2015</span></span></span></strong></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Exiled Syrian artist paints portraits of a brutal war, </strong>Zain Asher, CNN, 12 May</span></span></li>\r\n	<li><strong><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">A bomb almost killed my children&#39;: Meet the Syrian artist who paints terror and torment of war</span></span></strong></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Liz Walters, the Telegraph, 16 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>&lsquo;Syrian artist hopes to show human cost of conflict in new London exhibition&rsquo; </strong>By Vanessa Thorpe, The Guardian, 19 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist exhibits &#39;World Civil War Portraits&#39;,</strong> Today programme, BBC radio 4, 13 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma paint portrait of war,</strong> Euro news, May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Sara Shamma talks about her work on This Day Live, </strong>Arize TV, 19 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma&#39;s &#39;World Civil War Portraits&#39;: Painting a nation&#39;s nightmare,</strong><strong> </strong>Simon Tait, The Independent, 19 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>I don&rsquo;t believe that political art can change anything&rsquo;: Syrian artist Sara Shamma on the role of the artist in times of war, </strong>Vittoria Bonifati, The Art Newspaper, 19 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Conflict of interest,</strong> the Monocle Weekly, Monocle 24, 17 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Interview with Sara Shamma,</strong> Vanessa Feltz, BBC Radio, 13 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>World War Civil War Portraits - Sara Shamma,</strong><strong> </strong>Bob Chaundy, HuffPost, 14 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: World Civil War Portraits, The Old Truman Brewery,</strong><strong> </strong>culture whisper, May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, World Civil War Portrait,</strong><strong> </strong>Lorenzo Pereira, widewalls, May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma,</strong><strong> </strong>&lsquo;London Go&rsquo; with Luke Blackall, London Live Channel, 15 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The Syrian tragedy in Sara Shamma&rsquo;s paintings, </strong>Al Jazeera (Arabic), 17 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, World Civil War Portrait,</strong><strong> </strong>Al Arabiya, 12 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>&lsquo;Syrian painter tells story of her country&rsquo;s dead&rsquo; </strong>By Vanessa Thorpe, The Observer, 19 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Bikin Lukisan Jagal, Sara Shamma Riset ke Toko Tukang Daging, </strong>Indonisia,hot.detik, May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Exposi&ccedil;&atilde;o da artista Sara Shamma &eacute; aberta em Londres,</strong><strong> </strong>globoTV, Brazil, May</span></span></li>\r\n	<li><strong><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Exiled Syrian artist Sara Shamma holds art exhibit in London, UK showing horrors of war in Syria&hellip;</span></span></strong></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Newsivity.International, May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist hopes to show human cost of conflict in new London exhibition, </strong>Levant research institute, April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The dead of the conflict in Syria ... Living dead in an exhibition in London, </strong>BBC Arabic, 12 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Shamma brings civil war portraits to London, </strong>reporting by Francis Maguire; writing by Marie-Louise Gumuchian, Reuters, 12 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Shamma brings civil war portraits to London, </strong>Life style now, 12 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Exiled Syrian Artist, Sara Shamma Speaks On &#39;War&#39; Exhibition,</strong><strong> </strong>Channels TV (Nigeria), 20 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, World Civil War Portrait,</strong><strong> </strong>NTD TV (China), 13th May 2015</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma wants to bring the dead victims back to life,</strong><strong> </strong>Al Shaq Al Awsat, 13 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist holds exhibition in London for paintings on civil war, </strong>Al Quds Al Arabi, 13 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma&rsquo;s paintings blend realism and symbolism, </strong>Azzaman (Arabic printed in London), 10 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Sara Shamma brings Syria war portraits to London, </strong>The Arab Weekly, 12 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma brings Syria war portraits to London,</strong> Al Sharq Tribune, 13 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>An exhibition about the war on Syria by Sara Shamma,</strong> Kassioun, 13 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>(Pictures) Solo exhibition of the artist &quot;Shamma&quot; entitled &quot;World Civil War Portraits&quot; in London,</strong> arts gulf, UAE, May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma holds exhibition in London for paintings on civil war, </strong>Sameh Al Khatib, Amira Fehmi, Reuters Arabic, 12 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>works highlight the horrors of the Syrian war, </strong>Al Wasat, Libya, 12 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>An exhibition about the &quot;war on Syria&quot; in London,</strong><strong> </strong>Al Watan newspaper, 6 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist holds exhibition in London on civil war, </strong>Al Bawaba news, Egypt, 13 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma is holding an exhibition on the tragedies of war in Syria, Al Wasat Today,</strong><strong> </strong>Jerusalem, 13 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma is holding an exhibition in London for paintings commemorating people caught up in the war,</strong><strong> </strong>Ennaharonline, 13 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma holds exhibition in London for paintings on civil war, </strong>Future TV, May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma is holding an exhibition in London for paintings commemorating people caught up in the war, </strong>presse-algerie, 13 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma holds exhibition in London for paintings on civil war, </strong>Sky news, May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Solo exhibition by Sara Shamma entitled &quot;World Civil War portraits&quot; in London, </strong>Discover Syria, 3 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma holds exhibition in London for paintings on civil war,&nbsp; </strong>Albaladonline, May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syria&#39;s pain in paintings, </strong>Maydany, Egypt, 19 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>&quot;War on Syria&quot; at Sara Sharma in London,</strong> Thawra newspaper, Syria, 7 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma .. Where the eyes of killers do not tears, </strong>Hiba Ghanem, Alarabi Aljadeed, London, 27 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Les peintres syriens : une sc&egrave;ne artistique en exil,</strong> Emile Nasr, Le Safir francophone, Lebanon, April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Art Over Adversity: 5 Syrian artists confronting ideologies with creativity,</strong> RACHEL HOLMES The Metropolist, December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Gulf Canvases: May The Brushstrokes We Take, Light the Way,</strong><strong> </strong>Sarah Elzeini, Huffpost, August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>How the Global Refugee Crisis Is Impacting and Influencing Artists,</strong> ROB SHARP, Artsy, November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, la douleur pudique,</strong> rencontre juda&iuml;ques fm, France, March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The Artists: Sara Shamma And Aowen Jin The Conversation (podcast), </strong>BBC, London, 9 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Interview with Sara Shamma,</strong> Syrian TV, May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>After the war a lot of new artists emerged especially politically-speaking. It&rsquo;s a new wave and It&rsquo;s good to see the diversity Sara Shamma, </strong>Harper&rsquo;s Bazar Arabia, January</span></span></li>\r\n</ul>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><strong><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:18.0pt\">2014</span></span></span></strong></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian painter &rdquo;war changed my art&rdquo;</strong>, Outlook podcast, BBC, London, December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Diaspora</strong>, ART&amp;LAW NEGRI-CLEMENTI STUDIO LEGALE ASSOCIATO, October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma&rsquo;s Diaspora,</strong> creative artists magazine, October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma&rsquo;s Diaspora</strong>, Buro 24/7, October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Art Sawa &lsquo;Diaspora&rsquo;,</strong> Harper&rsquo;s Bazar Arabia, October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma&rsquo;s &lsquo;Diaspora&rsquo; Syrian artist shares her feelings at having to leave her native Syria,</strong> By Chanelle Tourish, TimeOut Dubai, 11 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma&rsquo;s Diaspora, </strong>by Adam Grundey, Triplew.me, December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The diaspora dilemma: Sara Shamma&rsquo;s paintings look for hope in times of loss, </strong>Anna Seaman, The National, 16 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma .. Lost faces tell, </strong>Diana Ayyoub, Emarat Alyoum, Dubai, 21 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma .. Syrian pain murals, </strong>Karim Al Najjar, Newsabah newspaper, Iraq, December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>SARA SHAMMA Syrian artists start to come through the looking glass</strong>, Autonymous Journalism, February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syria : artist Sara Shamma</strong>, West Asia Review, 12 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma to &quot;Erem&quot;: My main goal is to provoke the &quot;ego&quot;, </strong>Erem news, 15 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma won the fourth prize for painting and special appreciation at the Florence Biennale in 2013,</strong> Discover Syria, 10 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>SHAMMA&rsquo;S DIASPORA, </strong>by<strong> </strong>Edward Lucie Smith, contemporary practices, magazine UAE, vol 16</span></span></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><strong><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:18.0pt\">2013</span></span></span></strong></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>L&#39;&eacute;t&eacute; syrien (6) l&#39;art pour survivre, </strong>Ouest France, 10 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma Shows Plight of Syrian Refugees in First London Exhibition, </strong>Blouin artinfo, 29 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, Q (2011), </strong>criticismism, blogging for art&rsquo;s sake, 1 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist&#39;s Statement: Sara Shamma on Syria, Lebanon and art being &quot;bigger than wars&quot;, </strong>Culture 24, 19 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The power of art to evoke the human condition, </strong>laurencneal, 29 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: Q -The Royal College of Art, </strong>BY TRICIA TOPPING, Luxury Topping, 4 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>SARA SHAMMA: Q, </strong>by Tiffany Kaba, Luxury Topping, 16 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Interview with &lsquo;Q&rsquo; artist Sara Shamma,</strong> London Calling, 17 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>SARA SHAMMA, Q &ndash; INTERVIEW, P PSYCHOLOGY AND COLLECTIVE MENTALITY ARTICULATED IN WHIMSICAL BRUSH STROKES, </strong>Beaver online, 15 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Art: Sara Shamma&#39;s Q and Mother and Child, </strong>Paul in London, 1 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Female Syrian artist in first London solo exhibition, </strong>RCA, November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: Q -The Royal College of Art,</strong> Concert News Online, 27 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: Q ,Arab British Centre, </strong>London, October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma on fleeing Syria and why she paints, </strong>IdeasTap, London, 29 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>THE ROAD TO DAMASCUS: Syrian artist Sara Shamma in Conversation at the</strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>RCA, </strong>Love Art London, November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma&#39;s participation in the annual exhibition of the Royal Society of Portraits painters in London, </strong>Discover Syria, 5 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma at the annual exhibition of the Royal Society of Portraits painters in London</strong>, Alriyadh newspaper, 31 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Monocle Radio, Aperitivo</strong>, Interview, 7 November</span></span></li>\r\n</ul>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><strong><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:18.0pt\">2012</span></span></span></strong></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma &ldquo;Story of a painting&rdquo;,</strong> Aws Dawood Yaqoub, Alnour newspaper, Syria, 15 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artists Donate Works to be Sold to Benefit the United Nations World Food Programme at Christie&rsquo;s Dubai Sale</strong>, Al Ghad, Jordan, 26 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Seven Arab artists donate their work in support of the World Food Program At Christie&#39;s International Auction in Dubai,</strong> Al Jazeera, 2 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Arab artists flourishing as uprisings embolden a generation</strong>, Al Watan Daily, Kuwait, 19 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artists Donate Works to be Sold to Benefit the United Nations World Food Programme at Christie&rsquo;s Dubai Sale</strong>, Al Mustaqbal online, 24 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artists Donate Works to be Sold to Benefit the United Nations World Food Programme at Christie&rsquo;s Dubai Sale, </strong>Asharq Al &ndash;Awsat, 25 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artists Donate Works to be Sold to Benefit the United Nations World Food Programme at Christie&rsquo;s Dubai Sale, </strong>Emarat Al Youm, 24 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Joining forces: Christie&rsquo;s fights world hunger, </strong>Laura Adcock, Vision.ae, April&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artists Donate Works to be Sold to Benefit the United Nations World Food Programme at Christie&rsquo;s Dubai Sale, </strong>Josour Magazine, 25 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, WFP and &ldquo;Fighting Hunger&rdquo;, contemporary practices, Dubai, April</strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artists Donate Works to be Sold to Benefit the United Nations World Food Programme at Christie&rsquo;s Dubai Sale, </strong>Wam Ar, 23 February<strong> </strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: To leave an impact, </strong>Ibrahim Abdulmalik, Alalem newspaper, Iraq, 11 September</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The issuance of the first issue of the magazine &quot;Imran&quot;, </strong>3 September</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma in her murals ... Balance within the data of the surreal sense, </strong>Adib Makhzoum,<strong> </strong>Al Thawra newspaper, Syria, 2 October</span></span></li>\r\n</ul>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><strong><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:18.0pt\">2011</span></span></span></strong></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Damascus Opera House unveils Fighting hunger painting by Sara Shamma for the first time in an attempt to challenge the drought in northeastern Syria, </strong>Syria news, 15 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Al Maleh, Baghudharian and Sara Shamma in Dar al-Assad to serve the World Food Program, </strong>Discover Syria, 15 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The relationship between the painting and the hungry.. The film &quot;The story of a painting&quot; on the stage of the opera house, </strong>Ministry of Culture, Syria, March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>This Is the story in Damascus Opera ... film, painting and separation.. Ten of the ten for the World Food Program!!, </strong>Baladna newspaper, Syria, 15 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Damascus Opera House celebrates the launch of the Fighting Hunger painting and the presentation of an inspired film and the revival of a musical evening, </strong>Syrian Arab News Agency &ndash; S A N A, Syria, 15 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The story of a painting in Damascus Opera House, </strong>Al Thawra newspaper, Syria, 11 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Image and color in the world of &quot;Shamma&quot; and &quot;Al Maleh&quot; .. Opera House,</strong> Esyria.sy, 15 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, with her creations, is supporting the humanitarian projects of the World Food Program, </strong>Syrian Arab News Agency &ndash; S A N A, Syria, 21 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The premiere of &quot;Story of a Painting&quot; at the Syrian Opera House, </strong>Alwatan, Syria, 12 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Fighting Hunger painting</strong>, Discover Syria, 6 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Sara Shamma is completing a painting on fighting hunger to support the World Food Program, </strong>aksalser.net, 21 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrians&#39; Creativity in Service of World Food Program, </strong>Syrian Arab News Agency &ndash; S A N A, 22 Febuary</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>A story of fighting hunger painting for Sara Shamma at Dar Al Assad for Culture and Arts, </strong>JP news, 9 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma and Nabil Maleh Painting .. The secret has not been revealed yet!!,</strong> Shamlife, 16March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Nabil Maleh&#39;s camera tells the tale of Sara Shamma&#39;s painting,</strong> Al Thawra newspaper, 22 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Fighting Hunger painting,</strong> United Nation, March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma interview, Dunia TV, 16 January</strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma interview, Syrian TV, 13 January</strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma interview</strong>, Syrian News Channel, 22 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma interview</strong>, Syrian TV, 15 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma interview</strong>, Syria Drama TV, 15 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma interview</strong>, MBC TV, 15 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma interview</strong>, Dunia TV, 15 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma interview</strong>, RT TV, 12 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma interview,</strong> Damascus radio, 19 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma interview,</strong> &nbsp;AL Madina FM, radio</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma interview,</strong> Version FM, radio</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma interview,</strong> Syria Tomorrow, radio</span></span></li>\r\n</ul>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>His tool is the camera, and hers is the brush .. And the link between them is the point of meeting a desire to choke hunger, </strong>thenewalphabet.com, 22 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma - Artist, WFP Celebrity Partner, </strong>WFP,World Food Programme, March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Story of a painting</strong>, Mariam Ghorbannejad, Forward magazine, April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Fighting Hunger Painting sold in Christies</strong>, Al Watan KSA, 17 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Fighting Hunger Painting by Sara Shamma to support humanitarian projects</strong>, Tishreen newspaper, Syria, 22 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Celebrity Partner of the World Food Programme, The task of art in fighting hunger</strong>, Woman today magazine, 11 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>FIGHTING FOR THE HUNGRY, PORTRAYS A SYRIAN ARTIST WHO HAS DEVOTED HER SKILLS TO HELP THE NEEDY</strong>, Muhammad Yusuf, Gulf Today, 7 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist holds an exhibition to support UN projects for Iraqi refugees</strong>, Azzaman International Newspaper, 5 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Shamma supports the World Food Program through an exhibition,</strong> General organization of radio and TV, Syria, 6 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist holds an exhibition to support projects (World Food Program),</strong> All4Syria, 6 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>&ldquo;Birth&rdquo; Sara Shamma solo exhibition</strong>, DayPress news, 10 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Today: Sara Shamma at Art House exhibit &quot;Birth&quot;</strong> Discover Syria, 11 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The paintings of Sara Shamma in Art House draw the feelings and emotions of women,</strong> Ministry of Culture, Syria, 12 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, Syrian Lebanese rebel in &quot;birth&quot;,</strong> Jony Abbo, annahar newspaper, Lebanon, 12 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma in Art House .. White sin .. Milk will not be drained,</strong> Rose Sleiman, Baladna newspaper, Syria, 12 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>A visitor takes a photograph of a work,</strong> Daily times, 13 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, Birth, </strong>Al Thawra newspaper, Syria, 13 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma paints her sense of motherhood</strong>, Amer Matar, Al Hayat newspaper, Lebanon, 13 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: &quot;Birth&quot; is a rich and inspiring experience</strong>, ALWatanOnline, 15 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The talk of faces and questions of faces in the &quot;birth&quot; Sara Shamma, </strong>Al Baath newpaper, Syria, 16 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>&ldquo;Birth&rdquo; an exhibition of artist Sara Shamma in Art House in Damascus, </strong>Cham news, 18 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma monitors labor and body transformations, </strong>Khalil Sweleh, Al Akhbar newspaper, Lebanon, 19 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma&#39;s New Solo Exhibition in Damascus, </strong>ArteEast January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Birth: Sara Shamma restores the troubled woman&#39;s soul within her, </strong>Middle East Online, 12 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>&#39;Birth&#39; Sara Shamma in Art House: an artist who knows how to paint portrait will not depart from it!, </strong>Al Quds Al Arabi, 25 January<strong> </strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma exclusively on Orient Venus, I am not a model for Arab women, </strong>Orient Venus, 14 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma in Art House, </strong>Al Nahda newspaper, Syria, 3 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma&rsquo;s paintings depict the feelings and emotions of women, </strong>Al Thawra newspaper, 13 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma in Art House</strong>, Tishreen newspaper, Syria, 15 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>&ldquo;Birth&rdquo; A rich and inspiring experience has provided me with a lot,</strong> Al Watan newspaper, Syria, 16 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>In her recent exhibition Sara Shamma is self-oriented, </strong>Tishreen newspaper, 17 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Why Sara succeeds, Saad Al Qassem, </strong>Al Thawra newspaper, 18 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma is an exception to exceptional issues as well, </strong>Abdulla Abou Rashed, Annour newspaper, Syria, 19 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The suicide of the skill in painting&rsquo;s shock,</strong> Tishreen newspaper 23 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, milk agenda</strong>, Abwab newspaper, Syria, 23 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma to Tishreen: Don&rsquo;t ask me about my painting, told me about it, </strong>interview by Rem Shalati, tishreen newspaper, 30 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Interview with Sara Shamma, </strong>Ahlam Alturk,<strong> </strong>Shorufat, the ministry of Culture newspaper, 31 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>An aesthetic celebration and cases of visual trance, </strong>Qusai Badr, Al Thawra newspaper, 2 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Nudity is not a goal and maternal milk dominates my life and my work, </strong>Omar Alsheikh, Annahar newspaper, Lebanon, 2 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Music inspires me more than plastic artists, </strong>Alwatan newspaper, Oman, January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The Samawi collection</strong>, Selection magazine, May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>I do not think that man can love others if he does not love himself first</strong>, Dareen Saleh, Alwatan KSA, 25 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Her Amir is her most beautiful paintings</strong>, Rasha Ali, Gala magazine, May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The prize-holder carries childlike ideas, </strong>Aws Dawood Yaaqoub, Dubai Cultural magazine, UAE, May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Soul captured, Carol Farah, </strong>Happyning magazine, Syria, January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Women in the arts from artists&quot;s models to artists, </strong>Nada Odeh, travel Syria magazine, March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Some may consider me narcissistic Sara Shamma for Baladna, </strong>Rose Sleiman, Ahmad Tinawi, Baladna newspaper, Syria, 10 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma interview </strong>with Sabaya magazine, 1 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma the faculty of Fine Arts does not even teach the principles of drawing, </strong>Jouhayna magazine, March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Interview</strong> in Sveriges Radio, Sweden&#39;s national publicly funded radio</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma stories and faces</strong>, Alaan Arabic TV, Dubai, March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma dialogue</strong>, Nahed Ereksousi, Syrian TV, 3 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Hassan Mawazini talk to Sara Shamma</strong>, Syrian TV, January</span></span></li>\r\n</ul>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><strong><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:18.0pt\">2010</span></span></span></strong></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian art scene between Tahranism and the logic of the market, </strong>Khalil Sweleh, Al-Akhbar newspaper, Lebanon, 13 July</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian painter Sara Shamma (R) and World Food Programme (WFP) &hellip;,</strong> Reuters, 6 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Sara Shamma, celebrity partner of the World Food Programme,</strong> Syria more, 6 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>WFP chooses Syrian artist Sara Shamma to support Iraqi refugees</strong>, D press, 6 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The World Food Programme collaborate with Sara Shamma,</strong> Syrian news agency, SANA, 6 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>WFP is promoting its activities in Syria, and Iraqi refugees are dissatisfied</strong>, Alwatan newspaper, 7 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The Minister of Culture: Sara Shamma is one of the most important Syria artists,</strong> Syria news, 17 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>WFP is holding joint support projects with artist Sara Shamma</strong>, Baladna newspaper, 7 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The proceeds of &quot;Shamma&quot; exhibitions for the Iraqi refugee</strong>, AlBaath newspaper, 7 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian Artist Sara Shamma Chosen to Introduce WFP Activities in Syria</strong>, Syrian news agency, SANA, 7 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma&rsquo;s Pregnant Man at Nord Art Show, </strong>Happynings magazine, August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian Artist Sara Shamma Chosen to Introduce WFP Activities in Syria</strong>, FANA, Federation of Arab News Agencies, 7 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>World Food programme &quot;Syrian artist Sara Shamma is chosen as celebrity partner</strong>, JP news, 7 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>World food programme Selection of the Syrian artist Sara for the displaced Iraqis</strong>, Alwakad KSA, 7 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Painter Sara Shamma during the distributing aid to Iraqi refugees in Syria</strong>, Al Quds, 7 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>World Food Programme chooses a Syrian artist celebrity partner</strong>, AlJarida newspaper, Kuwait, 7 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma is participating in the World Food Programme</strong>, Arabstoday, 7 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Sara Shamma at the World Food Programme,</strong> AlTawra newspaper, 9 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Sara Shamma is a celebrity partner of the World Food Programme</strong>, Tishreen newspaper, 9 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Hunger painting for fighting hunger</strong>, Souriana magazine, 9 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The World Food Program (WFP) selects Sara Shamma as its partner in introducing the program&#39;s activities and work,</strong> Discover Syria, 7 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma is participating in an international exhibition in Germany</strong>, Discover Syria, 30 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Oil paintings by artist Sara Shamma in Germany</strong>, Thenewalphabet</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>There is no meaning behind any color or smell or taste in my paintings, Art has acquired the meaning of non-meaning, And to understand meaninglessness is far more important than to understand the meaning,</strong> Dareen Sleteen, Black and white magazine, Syria 2 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>painting between the picture and its shadow, Sara Shamma in Art House</strong>, Ammar Hasan, Al-Binaa newspaper, 20 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma international artist her weapon is her unique talent</strong>, Omar Al-Sheikh, Al-Binaa newspaper, 20 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, la parole des couleurs</strong>, Farid Najah, Afiavi magazine, 10 June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma&rsquo;s wedding: Sara Shamma and Mounzer Nazha, cooler and stranger than fiction,</strong> Sabaya magazine, Syria, June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>I don&rsquo;t understand art, </strong>by Sara Shamma, Sabaya magazine, Damascus</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artiat Sara Shamma, a unique personal experience,</strong> Abdalla Abou Rashed, Al-Ousbou Al-Adabi newspaper, Syria, 14 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Sara Shamma, my expected baby is to grant new form of childhood in my upcoming paintings</strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, I am interested in state more than subjects, </strong>Interviewed by Ahmad Al-Ghmari, shoun Thaqafiah, Libya, October </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Discovering Life in Painting, Sara Shamma, </strong>The Middle East Institute, Washington, DC, July</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Figuring it out, Syrian artist who want to paint through to the essence of things</strong>, Muhammad Yusuf, The Gulf Today newspaper, UAE, 12 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, everything around me is a source of inspiration, waiting for her new child</strong>, Rania Zakari, Marie Claire Magazine</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, we are who we want to be</strong>, Le monde diplomatique, 3 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma</strong></span></span></li>\r\n</ul>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:18.0pt\">2009</span></strong></span></span></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Jabla Cultural Festival in its fifth year, special celebration of painting</strong>, Discover Syria, </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Poor art scene and independent initiatives</strong>, Khalil Sweleh, Al-Akhbar newspaper, Lebanon, 30 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Arabi, Qasim, Dahoul, Jaafari, Shamma, Hreib and Ali talk about the disappearance of the nude model in Syria,</strong> Rashed Issa, Al-Safir newspaper, 23 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: I don&rsquo;t believe in all the art academy, it is a big lie</strong>, Ali Al-Aed, Al-Watan newspaper KSA, 22 April </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma criticize criticism, </strong>Mouhammad moutassem, Al-Arab, London, 20 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma in Kuwait, </strong>Bazaar magazine, Kuwait</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma recreates the world endlessly with joy, </strong>Al-Nahar newspaper,<strong> </strong>Lebanon, 6 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma exhibit in Istanbul and Kuwait,</strong> Al-Akhbar newspaper, Lebanon, 29 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The painting as gold, diamonds, pearls and wood!,</strong> Discover Syria</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>2 exhibition for Syrian artist Sara Shamma in Istanbul and Kuwait next month, </strong>SANA, Syria, 16 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The opening of the jewelry exhibition with unprecedented public interest</strong>, Discover Syria</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Booming Syrian art scene</strong>, krachtvancultuur.n, June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: I loved to paint myself as a child</strong>, Rashed Issa, Al-Safir newspaper, Lebanon, 24 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: I refused to teach at the Faculty of fine Arts in Damascus because I do not like it, I admit I am narcissistic</strong>, interviewed by Ziad Ali Darweesh, Souriana magazine, Syria, 8 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, Distributed between feeling and colors, Creativity is life and renewal, and I do not reject death or fear it, </strong>Tishreen newspaper, Syria, 15 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma super lady opens her heart</strong>, Sabaya magazine, Syria, 1 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma, Labeling artists will kill the art</strong>, Mohammad moutassem, Al-Arab newspaper, Qatar, 20 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Interview with Sara Shamma, </strong>Mouhammad Moutasem, Al-Quds Al-Arabi, London, 6 July</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma think that loving ourselves is a way of understanding the universe</strong>, Al-Quds Al-Arabi, 6 July</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Bir Suriyeli ressam var iclerinde.. Sara Shamma!.. bir resimleri var.. Vay vay vay!..</strong> Hinkal Uluk, Sabah Sayfa, turkey, 5 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, my paintings are reflection to my sense, and to my feeling toward others, loving myself is knowing myself</strong>, Mouhammad Moutassem, Al-Kalima magazine, Morocco, 7 June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: I need 10 children to satisfy my motherhood feeling</strong>, Yasmeen Al-Mounajjed, Gala magazine, Syria</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, I am with the winds of change even if it came in the form of a storm</strong>, Bandar Abdul Hamid, Almaraa Alyaum, UAE, 17 September</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artists in demand in Istanbul</strong>, Baladna English newspaper, Syria, 23 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma from Istanbul to Kuwait</strong>, Abwab newspaper, Syria, 22 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, An artistic figure open to innovation and surprising,</strong> Abdalla Abou Rashed, Annour newspaper, Syria, 18 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Painting is a state of meditation and connection with my inner self, Sara Shamma, interviewed by Roua Risheh, Mounzer inspires me,</strong> By Roua Rishe, Moda magazine, Syria</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>5<sup>th</sup> art literary competition, Sara Shamma, second place in painting, an artist living fully in the moment, music instigates and inspires me while working,</strong> Rekha Ohal, Sculptural persuit magazine, vol 8 spring</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>I aim to the unknown in painting, I do not want to know the limits of my painting</strong>, SANA, 20 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma darvishes in Art House, </strong>Mouhannad Ghanam, Al-Azminah magazine, Syria</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, spiritual music, dance and smoke, </strong>Ammar Hasan,<strong> </strong>Discover Syria, 21 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Shining Woman from Syria &ndash; Sara Shamma (1975), </strong>Syrian Professional Women&rsquo;s Society, UK, March </span></span></li>\r\n</ul>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:18.0pt\">2008</span></strong></span></span></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>One with the universe through my art,</strong> by Sara Shamma, International Artist magazine, Feb/March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, I was inspired by Rembrandt, and the way he worked with light and color, I do not try to guide the mind of the viewer, </strong>Abd Al-Karim Al-Afnan, Al Majala Cultural, Al-Jazirah newspaper, 2 June<strong> </strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Surpassed 38 participants from around the world in </strong><strong>Waterhouse Natural History Art Prize in Australia, Syrian artist Sara Shamma first prize in painting, </strong>Hisham Adra, Al-Sharq Al-Awsat newspaper, London, 3 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma won the </strong><strong>First Prize in Painting, Waterhouse Natural History Art Prize in Australia, </strong><strong>90% from the history of art does not affect me</strong>, Rashed Issa, Al-Safir newspaper, Lebanon, 9 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The pregnant man, </strong><strong>Sara Shamma left her old innocence, </strong>Khalil Sweleh, Al-Akhbar newspaper, Lebanon, 5 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma, the first in Australia</strong>, Ahmad Al-Ghmari, Oya newspaper, Libya, 10 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Face paintings as portraits of the soul, </strong>Fatma Salem, Gulf news, 20 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Nude in art, Abbas Youssef, </strong>Al-Waqt newspaper, Bahrein, 2 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Interview with Sara Shamma,</strong> Al-Hurra TV, Lebanon, December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>For me painting is like dreaming: you enjoy it while you are sleeping. It is only after you wake up that you realize its meaning- Artist Sara Shamma painting what</strong><strong>&rsquo;</strong><strong>s inside, </strong>Nadia Muhanna, Syria today magazine, 8 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The most expensive men in the Syrian art auction, </strong>Syrian days, 5 June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, peinture a l&rsquo;heure Syrienne,</strong> Christian Rol, Cigale Mag, Paris, N 18</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Contemporary Syrian Art Exhibition in Doha, A musical evening for the Zirklis, Arnaout and the Dabbous, after the opening</strong>, Discover Syria</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The spirits of Sara Shamma in Art House Damascus</strong>, E Syria, 13 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Sara Shamma, Entrance to build a new painting</strong>, Samer Ismaiil, Al-Binaa newspaper, Syria, 14 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Golden prize for Sara Shamma in an Australian exhibition</strong>, Baladna newspaper, Syria, 9 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma and the international art awards</strong>, Abdalla Abou Rashed, Annour newapaper, Syria, 6 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, Realism and Surrealism and awards</strong>, Adib Makhzoum, Al-Thawra newspaper, Syria, 14 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>&ldquo;</strong><strong>Sara 1978</strong><strong>&rdquo;</strong><strong>, beginning of a Syrian renaissance,</strong> Tamador Ibrahim, Al-Ousbou Al-Adabi, Syria, 6 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Australian golden art award to Sara Shamma</strong>, Bashar Al-Faouri, SANA, Syria</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>International award to the Syrian artist Sara Shamma</strong>, SANA 9 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, Every day is more creative than before, </strong>Al-Azmena magazine,Syria</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma in knowledge village, Dubai, </strong>Al-Bayan newspaper, 14 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Many hues of Syrian art exhibition, </strong>The peninsula, Qatar, &nbsp;25 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>&ldquo;</strong><strong>Sara 1978</strong><strong>&rdquo;</strong><strong> solo show for Shamma, </strong>Qousai Bader, Al-Thawra newspaper, Syria, 24 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma in Art House, High technique and tenderness matriarchal does not exclude anyone</strong>, Rana Zeid, Baladna newspaper, Syria, 23 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma</strong><strong>&rsquo;</strong><strong>s paintings in At House, strong strange technique, and the subjects</strong><strong>&rsquo;</strong><strong> diversity</strong>, Abdulla Abou Rashed, Annour newspaper, Syria, 15 October </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Innocent childhood burdened with dream and idea, </strong>Raman Al Rashi, Al-Watan newspaper, Syria, 16 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma won an Australian award</strong>, A-Quds, Palestine, 17 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Damas-Paris Regard Croisee, European and Arabic experiences</strong>, Asaad Arabi, Al-Hayat newspaper, Lebanon, 30 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Rhino is as good man is about to extinction</strong>, Al-Awan daily newspaper, Kuwait, 17 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: The man is a beautiful creature</strong><strong>&hellip;</strong><strong>more simple then the&nbsp; woman</strong>, Ward Salman, Day Press, Syria, 25 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The minister of Culture opens the Syrian contemporary art exhibition</strong>, Al-Raya newspaper, Qatar, 25 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamm exhibition in Dubai,</strong> Al-Ittihad, UAE, 9 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma in knowledge village, </strong>Al-Bayan newspaper, UAE, 14 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma with a golden Australian prize, </strong>Hisham Adra, Al-Sharq Al-Awsat newspaper, 3, October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: My paintings does not symbolized anything</strong>, Shouroufat newspaper, the Ministry of Culture Damascus, 10 November </span></span></li>\r\n</ul>\r\n\r\n<p style=\"margin-left:36pt; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:18.0pt\">2007</span></strong></span></span></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Les artistes peintres syriens et la politique, Hassan Abbasm, </strong>ITIN&Eacute;RAIRES ESTH&Eacute;TIQUES ET SC&Egrave;NES CULTURELLES AU PROCHE-ORIENT, Nicolas Puig and Franck Mermier, Presses de l&rsquo;Ifpo, Lebanon</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Her violent narration with color maintains the poetic soul that carries one&rsquo;s sight through quick harmonious color-sentences into infatuation, </strong>Khalil Sweleh, Al Akhbar newspaper, Lebanon, 20 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sheikha Mozah visited the Damascus University Conference Center and Masar project and Sara Shamma exhibition, </strong>Qatar TV, 27 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>A Diva of painting capable of creation and stunning the viewer, </strong>Abdallah Abou Rashed, Al Nour newspaper, Syria, 14 March<strong> </strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>A hand movement that tells the history of a human being&hellip; Sara is a Surrealist, an Expressionist and a Symbolist, </strong>Hisham Adra, Al Sharq Al Awsat newspaper, Lebanon, 23 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The Faculty of Fine Arts obstructs the development of plastic art in Syria, </strong>Syria news, Syria, 28 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Because Reality is so valuable to her, Abstract art mean nothing, most Syrian Artists have more feeling than technique, </strong>Rashed Issa, Al-Safir newspaper, Lebanon, 4 April </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: I paint every day and every painting is a new experience for me, </strong>Al-Riwaq magazine, 1 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>I paint my true inner states of being&hellip; Basima Hamed, </strong>Jamila Magazine, Qatar, UAE, June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma solo exhibition in Art House, a great artistic festival in honor of the artist and the place</strong>, Ghazi Ana, Al-Riwaq magazine, Syria, 17 June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>An exhibition of Syrian art has taken Washington DC by storm, rites Ahmad Salkini</strong>, Syria today, July</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Loving oneself is necessary for understanding and loving others, </strong>Raman Al Rashi, Al Watan newspaper, Syria, 19 February </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma to Al-Riwaq: I paint man and his changing features, </strong>Interview by Alaa Al-Jammal, Al-Riwaq Magazine, Syria, 26 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Her artistic talent has strong impact on the memory of the ordinary viewer and the critic, </strong>Saad Al Qassem, Founoun Magazine, Syria, March </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Paintings like mirrors that fill you with amazement, </strong>Azzaman newspaper, Iraq, April&nbsp; </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma attains Nirvana and find unity with the Absolute.. </strong>Ministry of Culture, Syria, 5 April<strong> </strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The internal music forms the paintings of Sara Shamma</strong>, Middle East Online, 21 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma is a genius that transcends universality</strong>, ANA news, Romania, 21 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma, her astonishing paintings are like mirrors</strong>, Azzaman International newspaper, 29 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma in her new solo show, a lull in the whirlpools of life, </strong>Raman Al Rashi, Al Watan newspaper, Syria, 19 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma is the sniper of the floating moments, </strong>Ali Alkurdi, Al Hadaf Magazine, 22 Palestine, April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Realistic Alphabets to construct the Dramatic event, accurate details with little on no ornament, </strong>Habib Al Rai, Founoun Magazine, Syria, 26 April </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma on Sara Shamma Her inspiration is drawn largely from music. Amongst genres most favored include blues and hard rock, extending to the music and words of Bob Dylan, She speaks most passionately though on Sufi music.. Fatina Al Sayyed mirrors Sara&rsquo;s views on the works when she says that each time she looks at one of Sara&rsquo;s painting she sees something new, and she asks herself, is it me that is discovering the painting, or the painting discovering me? </strong>Simon Balsom, The Daily Star, Kuwait, 12/13 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, the reality within, </strong>Heba Fadel, Bazaar magazine, Kuwait<strong> </strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>One of the Arab world&rsquo;s rare artistic sensation will be visiting Kuwait between 12 and the 19<sup>th</sup> of May, </strong>Heba Fadel, Bazar Magazine, Kuwait, May<strong> </strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma brings music to Kuwait, </strong>Mohammad Shaaban, Al Qabas newspaper, Kuwait, 15 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara exhibits 18 portraits inspired by music in Kuwait, </strong>Hsein Mousalli, Al Madina newspaper, KSA, 16 May<strong> </strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Under the patronage of Sheikha Dr. Rasha Al-Sabah, under Secretary at the Ministry of Higher Education, and sponsored by MTC, The Daily Star and The Athletes Foot, Ms. Fatina Al-Sayed is proud to announce the latest exhibition by renowed Syrian Artist Sara Shamma entitled, Music</strong>, Al-Ray newspaper, Kuwait, May </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma observes the dream in a glamorous, glamorous look,</strong> Al-Ray newspaper, Kuwait</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Exhibition of Syrian artists in Washington</strong>, Syria news, 6 July</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Humble and confidence, Sara Shamma, Syria&rsquo;s number one among young artists speak to FW</strong>, Shareen Al-Dakkak, Forward magazine, Syria, August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara has made 50 portraits of Bob Dylan.. Some visitors of her exhibitions were in tears being moved by the power of feeling in her paintings, </strong>Al Doustour newspaper, Jordan, 7 May<strong> </strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara (the fourth) on the world showing her work in Kuwait, </strong>Al-Madina newspaper KSA, 16 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma brings &ldquo;music&rdquo; to Kuwait</strong>, Alarab online, 15 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, today star, </strong>Baladna newspaper, Syria, 20 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Like Donatello among monsters, long years ago, in This phrase, I titled an article in the newspaper Al Thawra for an exhibition of the young artist Sara Shamma</strong>, Saad Al-Qassem, Founoun magazine, Syria, 29 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>In a new exhibition and a new art gallery, Sara Shamma</strong>: the painter and the subject, Mahmoud Shaheen, Tishreen newspaper, Syria, 8 Mach</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, Reveal the hidden</strong>, Manha Al-Batrawi, Al-Bait magazine, Egypt, November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian female artists</strong>, Al-Thawra Cultural, Syria, 14 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The Reality is richer than our imagination</strong>, artist Sara Shamma, interview by Amina Abbas, Al-Baath newspaper, Syria, 19 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Painter Sara Shamma, a portrait of a Syrian woman</strong>, The Mideast Forum, 29 October</span></span></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:18.0pt\">2006</span></strong></span></span></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma, I have exhibited locally and internationally, Only Iraq remains, </strong>Al-Riyyad newspaper KSA, 22 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>International artist Sara Shamma, I give little attention to criticism&hellip;The works of art no longer amaze me, except when I get the chance to glimpse the oneness of the artist and his paintings, </strong>Hani Nadim, Shabab Al Youm Magazine, UAE, 1, August </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The Syrian art scene today is the memory of myth and utopia of experimentation</strong>, Ayman Ghazali, Al-Thawra Cultural newspaper, Syria, 31 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Her Paintings are deep inner revelations without any fixed thoughtful background, They either delight your sight or stimulate your self insight, </strong>Alaa Rashidi, Founoun newspaper, Kuwait, September &nbsp;</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Her near-perfect craftsmanship enable her to paint realistic portraits without falling in the trap of copying reality.. It&rsquo;s the absolute power of being able to face life humanity and the universe while painting herself from her image in a mirror, </strong>Faisal Khartash, Tishreen newspaper, Syria, 3 October&nbsp; </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The artist who reaches for mysticism make opaque bodies transparent, A moment in the life of a human being , </strong>Adnan Farzat,<strong> </strong>Al-Qabas, Kuwait, 4 June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma wants to reach the global early, </strong>Middle East Online, 8 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma: I paint myself in all situations without fear or ambiguity, </strong>Basima Hamed, Jamila magazine, Qatar</span></span></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:18.0pt\">2005</span></strong></span></span></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Women art exhibition, Sharjah provides bridges between cultures</strong>, Rana Rafaat, Al-Khaleej Cultural newspaper, UAE, 31 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>24 female artists discuss the effect of war in their art,</strong> Mirvat Al-Khatib, Al-Khaleej Cultural newspaper, UAE, 30 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The third international exhibition &ldquo;Women and Art&rdquo; in Sharjah, </strong>Zahrat Al-Khalij magazine, UAE, 5 march</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma paint the soul and her paintings are lively</strong>, Karim Shukr, 9 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, Syrian artist, I don&rsquo;t want the viewer to understand my work</strong>, Hisham Adra, Afaq newspaper, Syria, 12 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Sara Shamma is the first Arab artist who got the international painting prize in London</strong>, Al-Maared magazine May/June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>In the new Syrian cultural scene, female Creators are more serious than male creators</strong>, Al-Momayazoun magazine, August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The first Arab to obtain the International Portrait Award, (I forward my paintings to the whole world not only to Syria) </strong>Mouhannad Ghanam, Azminah Magazine, Syria, October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma participate in International Painting Prize of the Castellon County Council</strong>, Tishreen newspaper, Syria, 27 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma: there is no art without freedom, </strong>Thanaa Abdul Azim, Zahrat Al Khaleej, UAE, 12 March</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist participate in an international exhibiton in Spain</strong>, moheet.com, 26 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>In Dubai: Damascus is a civilization and creativity</strong>, Champress, 15 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The annual exhibition for Syrian artists</strong>, Ghada Al-Ahmad, Al-ousbou Al-Adabi newspaper, Syria, 24 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma in an exhibition in Spain</strong>, Hisham Adra, Al-Sharq Al-Awsat, London, 15 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma,</strong> Syrian Media Center, London, July</span></span></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:18.0pt\">2004</span></strong></span></span></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Face value, artists shortlisted for portrait award</strong>, The Guardian, UK, 21 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>A portrait of the slow artist as a dedicated family man, </strong>The Times, UK, 21 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Portrait award shortlist on show, </strong>BBC 17 June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>In Pictures: BP Portrait Award, </strong>BBC news, 22 June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Unshowy&#39; picture takes portrait prize, </strong>The Guardian, 22 June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Fergus in Frame for 25000 prize, </strong>Exeter express &amp; Echo, 23 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Who is at fault, the artists or judges? </strong>Brian Swell, Evening Standard, 18 June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma won the 4<sup>th</sup> prize at the National Portrait Gallery in London, </strong>Al-Quds newspaper, London, 24 June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Some described her as an artistic hurricane , Sara Shamma, one eye is enough to give the face its expression</strong>, Fatima Shaaban, Al-Ittihad newspaper, UAE, 1 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma exhibits in Kuwait, </strong>Tishreen newspaper, Syria, 3 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma shortlisted for a British prize,</strong> Al-Thawra newspaper, Syria, 23 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma At the top of the international scale of fame, </strong>Muhannad Ghanam, Tishreen newspaper, Syria, 3 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma at The National Portrait Gallery in London</strong>, Ghazi Ana, Al-Thawra Cultural newspaper, Syria, 13 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma Syrian artist goes international from the BP Portrait Award in London, </strong>Shaza Firzly, Al-Hayat newspaper, Lebanon, 11 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara&rsquo;s Gaze, Emma Staples, </strong>Bazaar magazine, Kuwait</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>In her solo exhibition in Kuwait Sara Shamma painted the faces with their most subtle details</strong>, Al-Ray Al-Aam newspaper, Kuwait, 7 July</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma participate in the National portrait Gallery competition in London</strong>, Al-Warda magazine, Syria, June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: Music touches human subconscious through the ear and painting do the same through the eye, </strong>nisreen shihabi, Creative engineering magazine, Syria, </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>4<sup>th</sup> prize for the Syrian artist Sara Shamma at the BP Portrait award in London</strong>, Tishreen newspaper, Syria, 1 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shmma the 4<sup>th</sup> at the National Portrait Gallery exhibition in London,</strong> Hisham Adra, Al-Sharq Al-Awsat newspaper, Lebanon, 28 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma On The Road To Globalism, </strong>Abdallah Abou Rashed, Albalad newspaper, Lebanon, 7 September</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma in Aleppo,</strong> Al-Baath newspaper, Syria, 18 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma exhibition in Aleppo,</strong> Al-Thawra newspaper, Syria, 18 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma in Aleppo today,</strong> Tishreen newspsper, Syria, 21 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma in Kalemaat art Gallery in Aleppo</strong>, Al-Jamaheer newspaper, Syria, 19 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Neutralised Disclosure: Deflecting the Gaze in Contemporary Syrian Art</strong>, Mysoon Rizk, n.paradoxa, international feminist art journal, vol 14, July</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma&rsquo;s fourth prize at the BP Portrait Award in London, the quiet transition from local to global,</strong> Al-Wardeh magazine, Syria, July/August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The only Arabic artist who accepted in a London Portraits Competition and won a prize</strong>, Sara Shamma: I care about the feeling first then the form and color, Ahmad Bazzoun, Al-Safir newspaper, Lebanon, 11 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Free movement on visual space, Sara Shamma an Idol</strong>, Ahmad Al-Ali, Al-Jamaheer newspaper, Syria, 26 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma at Kalemaat art Gallery, mirrors of the soul and the body</strong>, Faysal Khartash, Al-Wardeh magazine, Syria, January/February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Young artist Sara Shamma begins its first steps in the path of global proliferation</strong>, Razan Toumani, Shabablek magazine, Syria</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Neither me nor my paintings will stop the war</strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, an explosive phenomenon, </strong>What&rsquo;s out magazine, Syria</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Kaleemat art gallery, Sara Shamma A new artistic phenomenon, </strong>Al-Thawra cultural newspaper, Syria, 8 July</span></span></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:18.0pt\">2003</span></strong></span></span></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, Understanding and feeling the painting is a special cultural taste</strong>, Ayman Ghazali, Al-Thawra Cultural newspaper, Syria, 12 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>From Sara Shamma&rsquo;s paintings,</strong> Al-Thawra Cultural newspaper, Syria, 19 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Women and war, artist Sara Shamma</strong>, Al-Baath newspaper, Syria, 19 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Sara shamma, Eye staring over the Island of the Body</strong>, Rabiaa Kurbaj, Al-Thawra newspaper, Syria, 18 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist and exhibition, Sara Shamma</strong>, Syria News newspaper, Syria, 27 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Opeens Kwamen er Arabische woorden op het doek</strong>, Door Inge Dekker, newspaper, Holland, 15 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Sara Shamma: I paint myself because I like myself,</strong> Samar Tarraf, Sayidaty magazine UAE, Lebanon, 30 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Sara Shamma: Human body is highly inspiring&hellip; and every muscle has its our expression</strong>, Razan Toumany, Al-Manara magazine, UAE, August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma&rsquo;s dervishes for the Festival of Montreal, </strong>Rania Mardini, Al-Baath newspaper, Syria, 27 January</span></span></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><strong><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:18.0pt\">2002</span></span></span></strong></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma: I enter deep down myself and find the source of creativity,</strong><strong> </strong>Al-Ousbou Al Arabi magazine, Lebanon, 22 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Le Bleu De Klein, biennale m&eacute;diterran&eacute;enne des arts de tunis,</strong><strong> </strong>Bady B. Naceur, La Presse de Tunisie, Tunisia</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>A female world, fertile and amazing in the paintings of Sara Shamma,</strong><strong> </strong>Al Seyassah newspaper, Kuwait, 11 July</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The world of the female is clearly visible from the paintings of Sara Shamma,</strong><strong> </strong>Marwan Almaqdessi, Reuters 9 July</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma shakes the shyness of the masculine society,</strong><strong> </strong>Asaad Arabi, Zawaya magazine, August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Sara Shamma, everything I want to say is existed in my paintings, </strong>Mahmoud Shaheen, Tishreen newspaper, Syria, 16 September </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma: Our Arab society is masculine and this is why an female artist rarely stands out, </strong>Imad Sara, The Majalla magazine, London, 7 September</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma interview, </strong>Oussama Alawi, Mohannad Orabi, Kelmetna magazine, Syria</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma&rsquo;s fourth solo exhibition,</strong> Al Thawra Cultural newspaper, Syria, 13 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, Contemporary transparency, </strong>Tishreen newspaper, Syria, 13 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, My face expresses all women,</strong> Rima alzghayer, Alanwar newspaper, Lebanon, 14 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Creativity in painting.. Sara Shamma, </strong>Addiyar newspaper, Lebanon, 21 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, self portrait, </strong>Al Kifah Al Arabi, Lebanon, 21 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The artist and her deep mirror, Sara Shamma, </strong>Al- Mustaqbal newspaper, Lebanon, 21 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Solo exhibition for artist Sara in Damascus,</strong> Ad-Dustour newspaper, Jordan, 22 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara.. the painter of herself, </strong>Al-Qabas newspaper, Kuwait, 21 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma in her solo exhibition.. fertile eyes through we see,</strong> Wael Shaabo, 2 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma in Naseer Shoura gallery, harvests different strange forbidden fruits, </strong>Issam Darweesh, Tishreen Weekly magazine, Syria, 11 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Sara Shamma, Surrealistic imagination and conversational relations,</strong> Adib Makhzoum, Al-Baath newspaper, Syria, 27 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma exhibition, the cold violence,</strong><strong> </strong>Hassan Abbas</span></span></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><strong><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:18.0pt\">2001</span></span></span></strong></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Women and war, an important second step for the ICRC,</strong><strong> </strong>AlNour newspaper, Syria, 8 July</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>&ldquo;Women and war&rdquo; exhibition in Arab tour: the woman &ndash; the painter takes her face mask violently, Paintings for Syrian artist Sara Shamma,</strong> Asaad Arabi, Al-Hayat newspaper, Lebanon, 11 September</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>An exhibition of modern Syrian artists at the Herbert Art Gallery and Museum,</strong><strong> </strong>the british council, June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Syrian artist Sara Shamma, The most dominant case on me is the one that I do not know,</strong><strong> </strong>Houssam Aldeen Muhammad, Al Quds newspaper, London, 7 September</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, Man is my most important visual reference, This is why scarcity of female Syrian artists, </strong>Intisar Mansour,<strong> </strong>Laha magazine, UAE<strong> </strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>What did the wars of the world do with women? </strong>Al Hayat newspaper, Lebanon, 6 July</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Women and war, </strong>Al<strong>-</strong>Baath newspaper, Syria, 28 June</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Analyzing Sara Shamma&rsquo;s painting, </strong>Ibrahim Alhameed, Tishreen Cultural magazine, Syria 24 July</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>On the occasion of receiving the golden medal of the Lattakia Biennial, Sara Shamma it is a big responsibility and It involves great encouragement,</strong><strong> </strong>Issam Darweesh, Tishreen Cultural magazine, 28 August</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>When an artist cares about his work he respects those who watch this work,</strong> Qusay Bader, Althawra newspaper, Syria, 14 Novemner</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Search in Sufism for man&rsquo;s beauty, Sara Shamma,</strong><strong> </strong>Syria times newspaper, 25 October</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma the steel like astonishment of a face tearing its feminine mask, Sara Shamma is an explosive phenomenon... A volcano blowing its lava after long congestion in a deaf valley,</strong><strong> </strong>Asaad Arabi, Al Wasat, 5 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma the steel like astonishment of a face tearing its feminine mask,</strong><strong> </strong>Asaad Arabi, Al-Hayat newspaper, Lebanon, 5 November</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The first prize in painting in Lattakia biennale for Sara Shamma Appropriately deserved, A voice coming from the east and clearly audible amid the noise, </strong>Ghazi Ana, Al-Nour newspaper, Syria, 30 January </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Sara Shamma, If I was skilled to talk I would not have painted,</strong><strong> </strong>Mahmoud Shaheen, Al-Bayan Cultural, UAE, 27 May</span></span></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><strong><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:18.0pt\">2000</span></span></span></strong></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>1999 exhibitions,</strong> Nidal AlShaab newspaper, Syria, 13 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Young Syrian artist Sara Shamma, Deep expressionism and bold themes, </strong>Mahmoud Shaheen, Tishreen weekly newspaper, Syria, 17 April</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, A distorted self-shaping,</strong> Wafaa Sbeih, AlBaath newspaper, Syria</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Artist Sara Shamma&hellip; Identify with color and theme</strong>, Nidal AlShaab newspaper, Syria, 27 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma in her second solo exhibition, Experimentation is still her obsession and the result is accuracy and astonishment,</strong> Al-Thawra cultural, Syria, Saad AlQassem, 13 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Paintings with frustrating feelings and puzzling questions, Sara Shamma in her second solo show, Human states and different reactions, with ambiguity and mysteriousness, sadness and other things except joy,</strong> Ghazi Ana, Founoun magazine, Syria, 3 August </span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>She is her own subject&hellip; I would not have painted if I could say,</strong><strong> </strong>Mahmoud Shaheen, Anazahra magazine, UAE, 8 July<strong> </strong></span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The Spanish Cultura Center in Damascus, &ldquo;Think with your hand&rdquo; prizes,</strong><strong> </strong>Rima AlZaghir, Al-Anwar newspaper, Lebanon, 14 May</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Servantes institute distribute &ldquo;Think with your hand&rdquo; prizes</strong>, Al-Thawra newspaper, Syria, 23 December</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>4 experiences in Syrian art, </strong>Ahlam Al-Turk, Palestine voice, No 392 September</span></span></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><strong><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:18.0pt\">1999</span></span></span></strong></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma at the French Cultural Center,</strong> Al Thawra newspaper, 5 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma&rsquo;s paintings at the French Cultural Center</strong>, Tishreen newspaper, 6 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Adham Ismaiil art center,</strong><strong> </strong>Syria news newspaper, 24 July</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma artist, Strong beginning and stoning paintings, </strong>Gazi Ana, Tishreen weekly newspaper, 22 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma in her first exhibition, as Donatello between monsters</strong>, Saad AlQassem, 12 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma at the French Cultural Center, to a new relationship with the viewer,</strong><strong> </strong>Maher Azzam, Al Thawra Cultural newspaper, 10 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma, The depths are drawn into her work</strong>, Rawad Ibrahim, Al Baath newspaper, 2 February</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Interview with Sara Shamma, her first solo show, Music is the most important artistic and cultural reference for me,</strong><strong> </strong>Ali al oqbani, Al Thawra cultural newspaper, 22 January</span></span></li>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Sara Shamma in her first solo show, Wild expressionism and fertile imagination,</strong> Abdullah Abou Rashed, AlKifah AlArabi, newspaper, 13 January</span></span></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><strong><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:18.0pt\">1998</span></span></span></strong></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>The first annual youth exhibition in Al Shaab gallery, </strong>Al Thawra cultural newspaper, 20 December</span></span></li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><strong><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"font-size:18.0pt\">1995</span></span></span></strong></p>\r\n\r\n<ul>\r\n	<li><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong>Greek vision, in an exhibition of the Greek society in Damascus, </strong>Tishreen newspaper, 4 November</span></span></li>\r\n</ul>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cpy_exhibition`
--

DROP TABLE IF EXISTS `cpy_exhibition`;
CREATE TABLE IF NOT EXISTS `cpy_exhibition` (
  `exhib_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `type_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Type',
  `kind_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Kind',
  `exhib_year` int(11) DEFAULT NULL COMMENT 'Year',
  `exhib_title1` varchar(1000) NOT NULL COMMENT 'Main Title',
  `exhib_title2` varchar(1000) DEFAULT NULL COMMENT 'Sub Title',
  `exhib_date` date DEFAULT NULL COMMENT 'News Date',
  `exhib_from` date DEFAULT NULL COMMENT 'From Date',
  `exhib_to` date DEFAULT NULL COMMENT 'To Date',
  `exhib_image` varchar(1000) NOT NULL COMMENT 'Cover Image',
  `exhib_text` text COMMENT 'Text',
  `exhib_intro` text COMMENT 'Introduction',
  `exhib_web` varchar(200) DEFAULT NULL COMMENT 'Web',
  `exhib_info` text COMMENT 'Information',
  PRIMARY KEY (`exhib_id`),
  KEY `type_id` (`type_id`),
  KEY `kind_id` (`kind_id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_exhibition`
--

INSERT INTO `cpy_exhibition` (`exhib_id`, `type_id`, `kind_id`, `exhib_year`, `exhib_title1`, `exhib_title2`, `exhib_date`, `exhib_from`, `exhib_to`, `exhib_image`, `exhib_text`, `exhib_intro`, `exhib_web`, `exhib_info`) VALUES
(32, 1, 0, 2017, 'London', 'Art Sawa Gallery, Dubai, UAE', '2017-04-18', '2017-04-18', '2017-05-20', 'IMG_78153.jpg', 'London (2017) is Sara Shamma\'s first new body of work since her relocation to the UK in September 2016. The paintings draw inspiration from her early experiences of living in London as an artist and mother, her insights on life as a settled resident, and joining the local community in South London  This is a second move for Syrian-born Shamma and her young family, who fled the war in Damascus in 2012, back to the safety of her mother\'s home country, Lebanon. The intermingling of historical events and personal circumstance gave rise to works reflecting Shamma\'s experience in the face of collective catalysts, civil unrest and diaspora.  Witness to physical and mental anguish, her paintings from this period trace the visceral imprints of terror on the body and its expressions. They are figurative evocations rather than portraits, composite characters drawn from real faces and bodies, through the filter of the artist\'s eye. These works distil experiences of conflict, whilst touching on the imponderables of what gives rise to conflict in the first place.  A regular visitor to London, where she has exhibited on several occasions, Shamma was plunged headlong into the currents of British life. Choosing a school for her children and settling herself into the close circle of parents, teachers and friends in her neighbourhood, Shamma\'s most striking and immediate observations centred around the extraordinary contrast in attitudes between her children\'s primary school classmates and their peers in the Middle East. The relationship between children and adults in the Middle East displays a guarded deference whereas Shamma discerns a refreshing and joyful fearlessness and freedom in the way her children\'s new friends relate to teachers, family and other authority figures in London. This is in keeping with the liberal attitudes of her own upbringing and the spirit in which she and her husband have parented their two young children.   Shamma strongly believes that children who are encouraged to express themselves freely and without fear of reprisal, will grow to perpetuate the values of freedom which form the strongest bulwark against civil strife. She believes happy children will grow to become more secure adults, less vulnerable to being led astray.  Shamma decided her first work in London should explore and celebrate the spirit of imagination and possibility embodied in the children she met in her first months in the captial. Children from the local school were invited to her home studio to sit for a series of portraits which stand as counterpoints, even antidotes, to her Q, Diaspora and World Civil War Portraits, a visual proposition of what a good beginning can look like.   The children were given art materials to experiment with and elements of the resulting paintings and drawings were selected and transferred onto a canvas of a child\'s portrait. This was a way to integrate both the artist and the child\'s creativity onto one surface resulting in collaborative work. By reaching out into the community that has welcomed and given her new hope and inspiration, Shamma is consolidating the relationship between artist and city.   The paintings in this series were exhibited at Art Sawa Gallery, Dubai in April 2017. This series is an insight to a more liberal regime of childhood to audiences in the Middle East and also function as a reminder to the people in the city of London to avoid taking things for granted.', '', '', NULL),
(33, 1, 0, 2015, 'World Civil War Portraits', 'Curated by Sacha Craddock, Presented by StolenSpace, The Old Truman Brewery, London, UK', '2015-05-11', '2015-05-11', '2015-05-25', 'P1070086_MP4_13_36_19_04_Still001.jpg', 'World Civil War Portraits is a selection of new and recent work by Sara Shamma, a powerful and moving product of the gruesome civil war in Syria, was created after Shamma was forced to flee the country in 2012 proceeding a car bomb that exploded outside her home.  Shamma\'s paintings are emphatically not \'war paintings\'. The show takes us on a cinematic journey of the experience of war, allowing us to feel the horror of displacement and loss through the eyes of the refugee, the tortured, the maimed and the terrorised victims of war.   After moving to the small Lebanese town, Shamma\'s perception of people changed, as she herself was changed. I used to think before that I was interested in life, death and dissolution, but now I am interested in these topics a hundred times more.  Some of the people in this town occupy these paintings: their eyes, their lives, their hopes and desires, and the way I felt about them.  Sacha Craddock describes Shamma\'s approach to painting as \'a sophisticated play between the real and the symbolic. Focus shifts in and out as she alludes to a general condition sometimes with heightened detail. A recent self-portrait contains differing states and time, the artist shadowed by the skeleton of a mythical monster, stares out, while a party balloon on another plane withers and deflates. The most recent paintings work together to build a powerful state of contemplation. They carry a strange other worldliness about them, that unites a range of hyper real detail, body organs for instance, with a loose brush stroke across the face.\'   Shamma believes the state of war transforms the life of the individual living in diaspora \"“ irrevocably detached from their life and almost unimaginably different from the experience of those who live without conflict. ', '', '', NULL),
(34, 2, 0, 2015, 'Sara Shamma as the guest artist in The 33rd Annual Exhibition', 'Sharjah art museum, Sharjah UAE', '2015-03-15', '2015-03-15', '2015-04-15', '2_2013_oil_and_acrylic_on_canvas__200x2001.JPG', 'Sara Shamma was invited on behalf of Emirates Fine Arts Society as the guest artist to participate in the 33rd Annual Exhibition held under the auspices of His Highness Sheikh Dr. Sultan Bin Mohammed Al Qasimi Member of the Supreme Council & Ruler of Sharjah at Sharjah museum from 15th March till 15th April 2015.', '', '', NULL),
(35, 2, 0, 2013, 'Florence biennale 2013', 'Fourth prize in painting, and Special Mention, Florence Biennial, Florence, Italy', '2013-11-30', '2013-11-30', '2013-12-08', '4_2013_oil_and_acrylic_on_canvas__2x(125x200)1.jpg', '', '', '', NULL),
(36, 2, 0, 2013, 'RP Annual Exhibition 2013', 'The Royal Society of Portrait Painters Annual Exhibition, The Mall Galleries, London, UK', '2013-05-09', '2013-05-09', '2013-05-24', '1_2012_Mounzer_Amir,oil_on_canvas_150x1502.JPG', 'Britain\'s largest exhibition of recent portraits in diverse styles and with a fascinating array of celebrities and lesser-known sitters. With over 200 works on show this is a significant gathering of the best of recent portraits. Prizes awarded by the Society are the Ondaatje Prize for Portraiture, The Prince of Wales Award for Portrait Drawing, The Changing Faces Prize and The de Laszlo Foundation prize. The Royal Society of Portrait Painters was established in 1891 and is a long-standing and forward-thinking organisation that aims to promote the practice of and further excellence in painted portraiture.', '', '', NULL),
(37, 1, 0, 2014, 'Diaspora', 'Art Sawa Gallery, DIFC, Dubai, UAE', '2014-10-27', '2014-10-27', '2014-11-30', 'DSC_6583.jpg', 'The paintings on show as part of Diaspora atArt Sawa Gallery (Dubai 2014) possessed a special resonance and are perhaps some of the most powerful works Shamma has created. The body of work for this exhibition consisted of twelve paintings; created between Damascus, Syria and Amioun, Lebanon, of subjects who have fled their homeland (Syria) in search of a better life.  An underlying and powerful sense of anxiety pervades Shamma\'s work, which is most powerful when viewed as a group. She adds a nightmarish quality to otherwise realistic portraits of subjects including her children, with bold swirls and distorted passages.  In their construction and use of narrative, the paintings call to mind the works of Goya and Delacroix and particularly Fuseli with his celebrated painting The Nightmare. There is also a connection to the great \'masters of war\' artists and history paintings such as Delacroix\'s The Massacres at Chios, but here there is a major difference - The noted Art Historian Edward Lucie Smith comments Sara Shamma \'has also had the courage to react to and comment upon what is happening now, particularly the tragedy now unfolding in her native Syria. Her recent paintings are not in any way journalistic, but they resonate with the tragedy of the current situation in her country.\'  Shamma\'s influences go far beyond both the current political situation and the tradition of western painting however. Taking influences from both Latin American art and the Sufi tradition of the Whirling Dervishes, evoked in the swirling movement and distortion found in many of the works in Diaspora. ', '', '', NULL),
(38, 1, 0, 2013, 'Q ', 'Royal College of Art, London, UK', '2013-11-26', '2013-11-26', '2013-12-02', 'sarashammalargesize-7.jpg', 'Shamma\'s first solo exhibition in London displayed a series of ten paintings which formed a sixty one foot long Q or \'queue\'. Through the work Shamma explores themes of humanity and group mentality.  The queue builds a feeling of anticipation as passers-by assume those in the queue must be waiting for something good and consider whether they should join. During her time in London, Shamma has noticed the British are infamous for queuing \"“ whether it be lining up overnight for the RCA secret postcard sale or avid shoppers waiting for the latest iPhone release.  A 2005 survey found that the British spend the equivalent of twenty-three days a year in line. Shamma notes there are also queues that elicit something darker, such as the photographs we have seen showing queues of Syrians in exodus crossing the border. The \'queue\' has previously been explored in contemporary art such as Roman Ondak\'s installation \'Good Feelings in Good Times\'.  Shamma has always been curious about the psychology of the queue, Shamma says \'Each person in the queue might have something positive about them as an individual however, once they become a part of one, they lose their individuality and become part of a larger whole\', a perfect example of this is a herd in the animal kingdom.', '', '', NULL),
(39, 1, 0, 2011, 'Birth', 'Art House, Damascus, Syria', '2011-01-11', '2011-01-11', '2011-01-31', 'DSCF37471.JPG', 'A solo exhibition of the Syrian artist \"Sara Shamma\" in Art House in Damascus between the 11th and the 31st of January 2011. The exhibition is entitled \"Birth\" and includes new different size paintings (oil on canvas) most of them were created in 2010, Sara comments: \"I did this collection during my pregnancy so they are full with my maternity feelings; this is why I have chosen this title for the exhibition\". During the exhibition, some items carrying pictures of some paintings (such as Posters and Mugs) in addition to the exhibition\'s Catalogue had been sold and the proceeds went to the United Nations World Food Programme (WFP) as part of Shamma\'s support to WFP projects.   WFP has nominated last month Sara Shamma as a Celebrity Partner of the Programme, she will support WFP through her artwork and will use her position and reputation in the cultural scene to bring attention to its humanitarian projects. The support will take different aspects. The exhibition was held under the patronage of the Syrian Minister of Culture Dr. Riad Ismat.', '', '', NULL),
(40, 1, 0, 2009, 'Love', 'MALL 360, Kuwait', '2009-12-07', '2009-12-07', '2009-12-17', 'IMG_3804.JPG', 'A solo exhibition of the Syrian artist \"Sara Shamma\" in MALL 360 in Kuwait between the 7th and the 17th of December 2009, organized by Mrs. \"Fatina Al-Sayed\". The artist presents new large paintings (oil on canvas) in the exhibition that is entitled \"Love\", Sara comments: \"I did this collection with many characters sleeping, when I looked at them I saw in them comfort, tranquility, peace, happiness and complete harmony with the environment, and all these terms are equal to Love.\" It is worth to say that the artist got married this year in the same period when she created those paintings.  This exhibition is the artist\'s third solo exhibition in Kuwait, the first was in 2004 in \"Karisma Art Gallery\" entitled \"Sara Shamma 2004\", the second was in 2007 in \"Cornish Club Event Gallery\" entitled \"Music 2007\" and both exhibitions were successful and obtained the admiration of the Kuwaiti public.', '', '', NULL),
(41, 1, 0, 2009, 'The Sema Ceremony from Turkey with Sara Shamma\'s Dervishes', 'Event organized by the Turkish Embassy, Art House, Damascus, Syria', '2009-03-11', '2009-03-11', '2009-03-24', '2_2009_oil_on_canvas_250x200.JPG', '', '', '', NULL),
(42, 1, 0, 2008, 'Sara 1978', 'Art House, Damascus, Syria', '2008-10-11', '2008-10-11', '2008-10-25', 'DSCF8785.JPG', '', '', '', NULL),
(43, 1, 0, 2008, 'Sara Shamma 2008', '\'Finishing Touch\' Knowledge Village, Dubai, UAE', '2008-11-01', '2008-11-01', '2008-11-30', '21_2008_oil_on_canvas_75x150.JPG', '', '', '', '<br><br><br>'),
(44, 2, 0, 2012, 'Nord Art 2012 ', 'Kunstwerk Carlshütte, Vorwerksallee, Büdelsdorf, Germany', '2012-06-02', '2012-06-02', '2012-09-30', '2_2009_Self_Portrait_oil_on_canvas_250x200.JPG', '“Sara Shamma” participated for the second time in the 14th edition of the largest annual art exhibition in northern Europe Nord Art 2012, from the 2nd of June to the 30th of September 2012 in the towns of Büdelsdorf and Rendsburg in Germany Nord Art is organized by KiC – Kunst in der Carlshütte; the exhibition comprises a 20,000 square meters of closed area, 60,000 square meters of parkland and other buildings, and public squares in the town of Büdelsdorf. The event attracts tens of thousands of visitors each year. This year exhibition features works by 240 artists from 49 countries.', '', '', NULL),
(45, 2, 0, 2010, 'Nord Art 2010 ', 'Kunstwerk Carlshütte, Vorwerksallee, Büdelsdorf, Germany', '2010-06-12', '2010-06-12', '2010-10-03', 'IMG_4079.JPG', '“Sara Shamma” participated in the 12th edition of the largest annual art exhibition in northern Europe Nord Art 2010, from the 12th of June to the 3rd of October 2010 in the towns of Büdelsdorf and Rendsburg in Germany Nord Art is organized by KiC – Kunst in der Carlshütte; the exhibition comprises a 20,000 square meters of closed area, 60,000 square meters of parkland and other buildings, and public squares in the town of Büdelsdorf. The event attracts tens of thousands of visitors each year. This year exhibition features works by 220 artists from 57 countries selected among 1327 artists from 81 countries. Sara Shamma’s participation was mentioned by the organizers in their official press release with other four artists from China, Sweden, USA and Russia. Sara Shamma was shortlisted for the Nord Art prize in 2010.', '', '', NULL),
(46, 2, 0, 2010, 'Art Prize 2010', 'Kendall College of Art and Design, Grand Rapids, Michigan, USA', '2010-01-01', '2010-01-01', '2010-12-01', '6_2010_Self_portrait_oil_on_canvas_250x200.JPG', '', '', '', NULL),
(47, 2, 0, 2009, 'Contemporary Istanbul 2009', 'Istanbul Convention and Exhibition Center (ICEC), Istanbul, Turkey', '2009-12-03', '2009-12-03', '2009-12-06', 'IMG_3749.JPG', '\"Sara Shamma\"  participated in the 4th edition of the International Art Fair \"Contemporary Istanbul 2009\" from the 3rd to the 6th of December 2009 at Istanbul Convention and Exhibition Center (ICEC) The Contemporary Istanbul is the most extensive ', '', '', NULL),
(48, 2, 0, 2009, 'Jableh Cultural Festival, 5th Edition', 'Jableh, Syria', '2009-07-10', '2009-07-10', '2009-07-14', '38_2008_oil_on_canvas_87x175.JPG', '', '', '', '<br><br><br><br>'),
(49, 2, 0, 2009, 'Let it be Jewelry', 'Art House, Damascus, Syria', '2009-01-01', '2009-01-01', '2009-01-31', 'Jewelry1.jpg', '', 'An Exhibition of unique jewelry designed by artists from the Arab World, organized by Sayegh Jewelry at Art House, Damascus, Syria.', '', NULL),
(50, 2, 0, 2008, 'Damas- Paris, Regards CroisĂ©s', 'The Arab World Institute, Paris, France and at the National Museum, Damascus, Syria', '2008-11-26', '2008-11-26', '2009-02-28', '15_2008_oil_on_canvas_100x120.jpg', '', '', '', NULL),
(51, 2, 0, 2008, 'Modern Syrian Art', 'Souq Wakef Art Center, Doha, Qatar', '2008-10-23', '2008-10-23', '2008-11-23', '25_2007_oil_on_canvas_100x120.JPG', '', '', '', NULL),
(52, 2, 0, 2008, 'UAE Through Arabian Eyes', 'the International Financial Centre, Dubai, UAE', '2008-10-01', '2008-10-01', '2008-10-30', '36_2008_oil_on_canvas_175x175.jpg', '', '', '', NULL),
(53, 2, 0, 2008, 'The Waterhouse Natural History Art Prize 2008', 'The South Australian Museum, Adelaide, South Australia, Australia', '2008-09-25', '2008-09-25', '2008-11-16', '4_2008_oil_on_canvas_120x100.jpg', '', '', '', NULL),
(54, 1, 0, 2007, 'Sara Shamma 2007', 'Art House, Damascus, Syria', '2007-03-01', '2007-03-01', '2007-03-31', 'D4GH2666.jpg', '', '', '', NULL),
(55, 1, 0, 2007, 'Music 2007', 'Cornish Club Event Gallery, Kuwait', '2007-05-01', '2007-05-01', '2007-05-30', 'IMG_1446.jpg', '', '', '', NULL),
(56, 2, 0, 2007, 'Panorama of Syrian Arts', 'Catzen Arts Centre The American University Washington, D.C. USA', '2007-09-01', '2007-09-01', '2007-09-30', '18_2007_oil_on_canvas_120x100.jpg', '', '', '', NULL),
(57, 2, 0, 2006, '\"Syrian Artists\" organized by Al-Sayed art gallery', 'Syrian Cultural Centre, Paris, France', '2006-05-24', '2006-05-24', '2006-06-05', '41_2005_oil_on_canvas_80x80.jpg', '', '', '', NULL),
(58, 2, 0, 2005, 'International Painting Prize of the Castellon County Council', 'ESPAI (the Contemporary Art Centre), Castellon and the Municipal Arts Centre of Alcorcon, Madrid, Spain', '2005-06-01', '2005-06-01', '2005-06-30', '21_2005_oil_on_canvas_80x80.jpg', '', '', '', NULL),
(59, 2, 0, 2005, 'Women and Arts, International Vision', 'Expo Sharjah, Sharjah, UAE', '2005-01-30', '2005-01-30', '2005-02-02', '1.jpg', '', '', '', NULL),
(60, 1, 0, 2004, 'Sara Shamma 2004', 'Kalemaat Art Gallery, Aleppo, Syria', '2004-11-01', '2004-11-01', '2004-11-30', '2004_2.JPG', '', '', '', NULL),
(61, 1, 0, 2004, 'Sara Shamma 2004 Kuwait', 'Karizma Art Gallery, Kuwait', '2004-04-03', '2004-04-03', '2004-04-23', '22.jpg', '', '', '', NULL),
(62, 2, 0, 2004, 'Syrian Artists', 'Kalemaat Art Gallery, Aleppo, Syria', '2004-03-01', '2004-03-01', '2004-03-30', '16_2004_oil_on_canvas_50x60.jpg', '', '', '', NULL),
(63, 2, 0, 2004, 'BP Portrait Award', 'National Portrait Gallery, London, Royal Albert Memorial Museum, Exeter, Aberdeen Art Gallery, Aberdeen, Royal West of England Academy, Bristol and Aberystwyth Arts Centre, Aberystwyth, UK', '2004-06-17', '2004-06-17', '2005-02-28', '27_2004_Self_Portrait__Oil_on_canvas_145x115.JPG', '', '', '', NULL),
(64, 2, 0, 2005, 'Syrian Artists Spain', 'National Library, Madrid, Spain', '2005-03-01', '2005-03-01', '2005-03-30', '26_2004_oil_on_canvas_80x80.JPG', '', '', '', NULL),
(65, 2, 0, 2003, 'International Women Arts', 'Organised by Le Pont Art Gallery, Aleppo, Syria', '2003-04-23', '2003-04-23', '2003-05-25', '7_2002_oil_on_canvas_100x120.jpg', '', '', '', NULL),
(66, 2, 0, 2003, 'FMA - Festival du Monde Arabe de MontrĂ©al', 'Montreal, Canada', '2003-10-30', '2003-10-30', '2003-11-16', '1_2001_oil_on_canvas_100x120.jpg', '', '', '', NULL),
(67, 2, 0, 2003, 'Syrian Artists The Netherlands', 'Gallery Amber, Leiden and Enschede, The Netherlands.   ', '2003-01-26', '2003-01-26', '2003-03-10', '28_2002_oil_on_canvas_60x60.jpg', '', '', '', NULL),
(68, 1, 0, 2002, 'Sara Shamma 2002', 'Nassir Choura Art Gallery, Damascus, Syria', '2002-10-13', '2002-10-13', '2002-10-30', '72.jpg', '', '', '', NULL),
(69, 2, 0, 2002, 'Arab Artists', 'Dar AL Anda Art Gallery, Amman, Jordan', '2002-04-01', '2002-04-01', '2002-04-30', '31_2002_oil_on_canvas_3x(17x22).jpg', '', '', '', NULL),
(70, 2, 0, 2002, 'Mediterranean Biennial', '(representing Syria) Kheir El Din  Palace, Tunis, Tunisia', '2002-04-01', '2002-04-01', '2002-06-30', '3.jpg', '', '', '', NULL),
(71, 2, 0, 2002, 'International Artists', 'Gallery M-Art, Vienna, Austria', '2002-09-17', '2002-09-17', '2002-10-18', '17_2000_oil_on_cavas_21x27.jpg', '', '', '', NULL),
(72, 1, 0, 2001, 'Sara Shamma 2001', 'Shell Cultural Club, Damascus, Syria', '2001-02-04', '2001-02-04', '2001-02-24', '14_2000_oil_on_cavas_60x80.jpg', '', '', '', NULL),
(73, 2, 0, 2001, 'ARTUEL', 'International Art Fair, Beirut, Lebanon', '2001-07-25', '2001-07-25', '2001-07-28', '9_2000_self_portrait_oil_on_cavas_100x120.jpg', '', '', '', NULL),
(74, 2, 0, 2001, 'Cairo Biennial', 'Cairo, Egypt', '2001-12-13', '2001-12-13', '2002-02-13', '5_2001_oil_on_canvas_100x120.jpg', '', '', '', NULL),
(75, 2, 0, 2001, 'Two Syrian Artists', 'Coventry Museum, Coventry, UK', '2001-06-23', '2001-06-23', '2001-09-02', '8_2000_oil_on_cavas_100x9.jpg', '', '', '', NULL),
(76, 2, 0, 2001, 'Lattakia Biennial', 'Lattakia, Syria', '2001-07-23', '2001-07-23', '2001-08-31', '8_2001_oil_on_canvas_130x1701.jpg', '', '', '', '<br><br>'),
(77, 2, 0, 2001, 'Women and War Art Exhibition', 'The Red Cross International Committee of Syria, Jordan and Switzerland', '2001-06-24', '2001-06-24', '2001-09-30', '4_2001_oil_on_canvas_52x50.jpg', '', '', '', NULL),
(78, 2, 0, 2001, 'Sharjah Biennial', 'Sharjah, UAE', '2001-04-17', '2001-04-17', '2001-04-27', '8_1999_oil_on_canvas_60x80.jpg', '', '', '', NULL),
(79, 1, 0, 2000, 'Sara Shamma 2000', 'Nassir Choura Art Gallery, Damascus, Syria', '2000-01-16', '2000-01-16', '2000-01-30', '14.jpg', '', '', '', '<br><br>'),
(80, 1, 0, 1999, 'Sara Shamma 1999', 'French Cultural Center, Damascus, Syria', '1999-01-05', '1999-01-05', '1999-01-30', '17.jpg', '', '', '', NULL),
(81, 1, 1, NULL, 'Second prize in the Youth Exhibition organized by the Fine Arts Syndicate, Damascus, Syria', '1998', NULL, NULL, NULL, 'Oil_on_canvas,_80x120cm,_1998.jpg', '', '', NULL, NULL),
(82, 1, 1, NULL, 'Second prize in the British Council Art Competition, Damascus, Syria', '2000', NULL, NULL, NULL, 'Self_portrait,_Oil_on_camvas,_90x130cm,1998.jpg', '', '', NULL, '<br><br>'),
(83, 1, 1, NULL, 'Second prize in the Spanish Cultural Center Art Competition, Damascus, Syria', '2000', NULL, NULL, NULL, '29_2000_oil_on_paper_15x21.jpg', '', '', NULL, '<br>'),
(84, 1, 1, NULL, 'First Prize (The Golden Medal) in Latakia Biennial (Painting), Latakia, Syria', '2001', NULL, NULL, NULL, '2001,_oil_on_canvas,_130x170cm.jpg', '', '', NULL, '<br>'),
(85, 1, 1, NULL, 'Fourth Prize at the BP Portrait Award at the National Portrait Gallery, London, UK', '2004', NULL, NULL, NULL, '2004_Self_Portrait__Oil_on_canvas_145x115.JPG', '', '', NULL, NULL),
(87, 1, 1, NULL, 'Fine Arts Syndicate Award, Damascus, Syria', '2006', NULL, NULL, NULL, '2_2006__self_portrait,_oil_on_canvas,50x70cm.jpg', '', '', NULL, '<br><br><br>'),
(88, 1, 1, NULL, 'First Prize in Painting, Waterhouse Natural History Art Prize, The South Australian Museum, Adelaide, South Australia, Australia', '2008', NULL, NULL, NULL, '2008_Waterhouse_(10)1.jpg', '', '', NULL, NULL),
(89, 1, 1, NULL, 'Shortlisted for the NordArt Prize, the Annual International Exhibition, organized by KiC – Kunst in der Carlshütte, Büdelsdorf, Germany', '2010', NULL, NULL, NULL, '18_2008_oil_on_canvas_175x2502.jpg', '', '', NULL, NULL),
(92, 1, 1, NULL, 'United Nations World Food Programme nominates Sara Shamma as Celebrity Partner, Damascus, Syria', '2010', NULL, NULL, NULL, 'DSCF32101.JPG', 'The United Nations World Food Programme (WFP) has nominated the Syrian painter Sara Shamma as a Celebrity Partner of the Programme, the announcement of this nomination took place during the first field visit that the artist conducted on the 6th of December 2010 to two food distribution centers for Iraqi Refugees in Syria.\r\nThe artist Shamma will support WFP through her artwork and will use her position and reputation in the cultural scene to bring attention to its humanitarian projects. Her support will start by giving some items designed by her and carrying pictures of her paintings to be sold for the benefit of WFP; also she will create a large-scale painting inspired by the suffering of the vulnerable refugees and the response of WFP, this painting will be sold in an auction house in the end of 2011 after being exhibited in different national and international exhibitions, all proceeds will go to WFP. Syrian famous film director Nabil Al-Maleh will produce a short documentary about the phases of the creation of the painting and its relation with needy people and WFP projects, as contribution to Sara\'s campaign.\r\nThe United Nations World Food Programme (WFP) is the largest humanitarian organization in the world; it fights hunger and distributes food aids to millions of people in many countries. As for Syria WFP is running different projects in collaboration with Syrian government, the most important ones are related to thousands of Iraqi refugees and thousands of Syrian victims of drought in the north east of the country.', '', NULL, NULL),
(94, 1, 1, NULL, 'Sara Shamma in World Food Programme\'s Regional Meeting', '2011', NULL, NULL, NULL, '3_2007_oil_on_canvas_150x1505.jpg', 'The United Nations World Food Programme (WFP) received Syrian Artist Sara Shamma on January 19, 2011, during its Regional Meeting that was held in MĂ¶venpick Hotel in Dead Sea, in order to introduce her to the Executive Director of the Programme Mrs. Josette Sheeran and to the other Directors, as the new \"Celebrity Partner\" of WFP. Shamma explained her role and her most important future plans to support the Programme and bring attention to its projects.\r\nIn this occasion, five large paintings of the artist were exposed in the hotel, the paintings will remain exposed during the 3 days of the conference.', '', NULL, NULL),
(95, 1, 1, NULL, '\"Fighting Hunger\" painting at The National Museum of Damascus', '2011', NULL, NULL, NULL, '1_Fighting_Hunger_2011_oil_on_canvas_150x200.JPG', '', '', NULL, NULL),
(96, 1, 1, NULL, 'Fighting Hunger painting to support World Food Programme (WFP) ', '2011', NULL, NULL, NULL, 'IMG_4735.JPG', 'As the United Nations World Food Programme\'s Celebrity Partner, and in a new step to support the Programme\'s projects, Sara Shamma has created a large scale oil painting inspired by the suffering of the vulnerable refugees and hungry people and the response of WFP; the painting is entitled Fighting Hunger, and was sold in Christie\'s Dubai in 2012 after being exhibited in different exhibitions, all proceeds went to WFP.\r\nSyrian prominent film director Nabil Al-Maleh produced a documentary about the phases of the creation of the painting and its relation with needy people and WFP projects, as contribution to Shamma\'s campaign.\r\nThe creation of the painting and the filming of the movie took place in the artist\'s studio in Damascus.\r\nMinistry Of Culture in the Syrian Arab Republic offered Dar Al-Assad for Culture and Arts (Damascus Opera House) to be the place of the revealing of Fighting Hunger painting on March 14, 2011, when the Premiere of the movie Story of a Painting took place, followed by a music concert given by to the Strings of the Syrian National Symphony Orchestra conducted by Missak Baghboudarian with participation of the Opera Singer Suzan Haddad, the proceeds of the event went to WFP too.\r\n\r\nThe United Nations World Food Programme (WFP) is the largest humanitarian organization in the world; it fights hunger and distributes food aids to millions of people in many countries. As for Syria WFP is running different projects in collaboration with Syrian government, the most important ones are related to thousands of Iraqi refugees and thousands of Syrian victims of drought in the north east of the country.    ', '', NULL, NULL),
(97, 1, 1, NULL, 'Fourth prize in painting, and Special Mention, Florence Biennial, Florence, Italy ', '2013', NULL, NULL, NULL, '4_2013_Self_portriat,oil_and_acrylic_on_canvas__2x(125x200).jpg', '450 artists from all over the world, nine awarded categories (Painting, Sculpture, Works on Paper, Installation, Mixed Media, Digital Art, Photography, Video), eight special mentions, over 30 collateral events in the city.\r\nThe Florence Biennale, founded in 1997 as a global convocation of artists with all their diversity, promotes art in all forms as a reference point for creative energies, a place where all forms of art and culture are welcome and made visible, and innovative, original, and prominent events are hosted at the same time.\r\nIn 2001 the Biennale was included in the Dialogue among Civilizations Program, sponsored by the United Nations to promote understanding among different cultures through artistic expression. Over the past eight editions, more than five thousand artists from around the world have met in Florence, making the Biennale one of the few events capable of providing an overview on contemporary artistic production at a global level.\r\nThe Lorenzo il Magnifico International Award was introduced since the first edition, with the aim of honoring outstanding personalities in the art and culture scenes, as well as Organizations and Institutions that have played a key role in cultural life at a global level, and participating artists in the current edition that are deemed creditable by the Biennale\'s International Jury.', '', NULL, NULL),
(98, 2, 0, 2011, 'The Samawi Collection', 'Ayyam Art gallery, Dubai, UAE', '2011-02-01', '2011-02-01', '2011-03-31', '11_2009_Self_Portrait_oil_on_canvas_175x175.JPG', '', '', '', NULL),
(99, 1, 1, NULL, 'Shortlisted for Asian Women of Achievement Awards (Arts and Culture), London, UK.', '2019', NULL, NULL, NULL, '2019_AWA_Finalist.png', 'The Asian Women of Achievement Awards, founded by Pinky Lilani CBE DL in 1999, celebrate multi cultural Britain and the contribution of diverse cultures and talents to UK society. It puts on a platform, the phenomenal Asian women across the UK and across industries, who are making a valuable and important contribution to British life. The awards play a key role in redefining the contribution of Asian women; and informing a new, positive, pro-diversity debate.\r\nThe awards have led to the creation of numerous initiatives and projects designed to help women and improve opportunities for the next generation. The awards are not simply a night of recognition but a community and a programme of initiatives that offer the opportunity for candidates to meet like-minded women and build business contacts.', NULL, NULL, NULL),
(100, 1, 2, 2019, 'Sara Shamma’s talk at Woman Violence and Art, University of Bedfordshire, Luton, UK', 'Date: 20 March 2019<br>\r\n12.15 – 2.15 pm<br>\r\nAt PGC lounge<br>\r\nFollowed by lunch and wine reception', '2019-03-01', '2019-03-01', '2019-03-01', '1.3.2019.jpg', 'Guest speakers: Hala Hindawi, Eyelum Atakav, Sara Shama and Itab Azzam.<br>\r\nOrganized by Dr. Noha Mellor and Dr. Agnieszka Piotrowska, and supported by UniBeds Talk<br>\r\nThis half-day event aims at engaging with the university’s local and regional communities in discussing the way art can be used as a platform to interrogate identities drawing on a unique group of women artists whose homelands have been subjected to unrest, violence or even full-scale war. The guest speakers, women artists resident in the UK, will draw on their own creative work to demonstrate how they confronted and responded to discrimination and violence using art as a means of empowerment and activism. The focus on women artists for this event is an acknowledgment of the crucial role of women in shaping public debates about violence and war and also in bridging the gap between cultures.', NULL, NULL, NULL),
(101, 1, 2, 2019, 'Sara Shamma exhibits new work for Migrate Art Multicolour Charity Auction - London', 'Exhibition: 9 Cork Street, London, W1S 3LL<br>\r\nPreview: Tues 19 March / 20- 31 March<br>\r\n <br>\r\nAuction: Phillips, 30 Berkeley Square, London, W1J 6EX<br>\r\nSale: Thurs 11 April / On View: 4-11 April', '2019-01-15', '2019-01-15', '2019-01-15', '15.1.2019.Alien Two Heads 2019.Oil on canvas.75x150.jpg', 'Sara Shamma exhibits a new work entitled ‘Alien: Two Heads’ as part of Multicolour, an exhibition and auction organised by the charity Migrate Art to support those affected by the global refugee crisis. The works will be on view in a dedicated exhibition in March 2019 at Cork Street Galleries prior to being sold as part of Phillips’ ‘New Now’ sale in early April and also online via partnerships with Artsy and MyArtBroker.com. \r\n <br><br>\r\nAs part of the Multicolour project Sara Shamma was presented, together with some of the most significant names in contemporary art, with a number of coloured pencils that were found in the Calais Jungle following its evacuation in 2016, to be used to create new artworks for the project. Sara has used these pencils to educate her children, who live with her and her husband in South London, about the current refugee crisis and the plight of migrant children that have endured treacherous journeys across Europe. In December 2018 Shamma visited Damascus to celebrate Christmas with her Syrian family, taking the pencils with her, where those exact pencils were used by Shamma\'s children to draw some pictures in her Damascus studio. One of these pictures (a two headed alien) was transposed by Shamma onto her painting making it in a sense a true collaboration between herself and Syrian children, her own children.\r\n <br><br>\r\nThe coloured pencils for Shamma highlight the different life experiences of her Syrian born children and those children that were forced to make a home in the refugee camps, whilst reminding her of the innate childhood interest in ‘colouring’. By engaging her children in this project, taking them on a journey of empathy and understanding aided by the physical metaphor of the coloured pencil, Shamma’s work will interpret the topics of migration and refugees from her own perspective as well as that of children.\r\n <br><br>\r\nShamma conceived this approach in order to provide a unique human-interest angle into her work as the only Syrian artist, one of three originally migrants artists invited to take part in the Migrate Art Multicolour project.\r\n <br><br>\r\nParticipating artists: Anish Kapoor / Annie Kevans / Annie Morris / Chantal Joffe / Conor Harrington / Conrad Shawcross / Edmund De Waal / Gary Hume / Idris Khan / Jeremy Deller / Jonathan Yeo / Keith Coventry / Kevin Francis Gray / Mark Wallinger / Maggi Hambling / Michael Craig-Martin / Nari Ward / Paola Pivi / Pejac / Rachel Whiteread / Raqib Shaw / Richard Deacon / Richard Woods / Robert Montgomery / Ron Arad / Sara Shamma / Sean Scully / Swoon / The Connor Brothers / Zhang Huan / Yahon Chang', NULL, NULL, NULL),
(102, 1, 2, 2019, 'Syrian Artist Sara Shamma partners with King’s College London and Helen Bamber Foundation to raise awareness of Modern Slavery', NULL, '2019-04-09', '2019-04-09', '2019-04-09', '4.9.2019.Self portrait.2016.Oil on canvas.100x120.jpg', 'King’s College London have today [09 April 2019] announced Sara Shamma, one of Syria’s most celebrated artists, as a King’s Artist in residence for 2019. Working with the university’s Institute of Psychiatry, Psychology & Neuroscience (IoPPN) and the Helen Bamber Foundation, the London-based artist will develop a new visual vocabulary of modern slavery, culminating in an exhibition curated by Kathleen Soriano which will open during Frieze London (1 Oct-22 Nov 2019). \r\n<br><br>\r\nThe project has been inspired by Shamma’s first-hand experience of seeing women and girls who have been kidnapped by ISIS in Syria and Iraq, displayed in real slave markets, exhibited on platforms in front of hundreds of men, examined by avid eyes and hands and sold to the highest bidder. This traumatic display provoked Shamma to collaborate with leading academics at King’s College London and the Helen Bamber Foundation, a pioneering Human Rights charity supporting refugees and asylum seekers who are survivors of extreme human cruelty, to help shine a light on the plight of modern slaves, and advocate for change.  \r\nThere are currently estimated to be more than 40 million people in modern slavery around the world, who are suffering chronic and interpersonal trauma which can damage their lives and relationships and those of their children, families, and communities. Working with Dr Siân Oram, Lecturer in Women\'s Mental Health at the IoPPN, and co-lead of the UK Research and Innovation-funded Violence Abuse and Mental Health Network, findings from Shamma’s residency will build on the NIHR-funded PROTECT project, which described the health needs and healthcare experiences of trafficked people in England and inform existing projects aimed at reducing the risk and impact of violence against women.  The partnership will also identify new research questions and develop collaborative relationships with organisations working to support survivors of modern slavery. \r\n<br><br>\r\nShamma’s residency will explore the psychological impact of modern slavery: the meaning of survival and recovery from the perspectives of survivors, of those who work to support their recovery, and who campaign for better support. With consent, Shamma will audio record qualitative interviews with women survivors of modern slavery who are receiving support from the Helen Bamber Foundation. These interviews will inform Shamma’s creation of large-scale portraits of the women which will be exhibited in a major exhibition curated by Kathleen Soriano at Bush House, King’s College London. The exhibition will be accompanied by a book of essays and insights into the project by Sara Shamma, Dr Siân Oram and other leading experts in the field of modern slavery. \r\n<br><br>\r\nSara Shamma commented “As an artist I draw inspiration from the immediate world around me.  At certain points in my life, that immediate world has been confused, angry and frightening.  Those personal, close encounters have motivated me to engage with the issues and to use my medium, painting, to comment and challenge the status quo.  Over time, we have frequently turned to artists to make sense of difficult or complex issues.  Very much in this tradition, I hope that my responses to, and engagement with survivors, through this residency at King\'s College London, will help raise awareness and understanding of this very live issue.” \r\nShamma, whose works can be found in both public and private collections around the globe, has a long-standing interest in the psychology associated with the suffering of individuals and has had many projects exploring this theme, including World Civil War Portraits (London, 2015), Diaspora (Dubai, 2014) and Q (London 2013). Shamma graduated from the Painting Department of the Faculty of Fine Arts, University of Damascus, she has been the recipient of various international art awards and was a prizewinner in the 2004 BP Portrait Award at the National Portrait Gallery, London; she became the United Nations World Food Programmers \'Celebrity Partner\' in 2010.  She moved to London in 2016, where she currently lives and works, under the auspices of an Exceptional Talent Visa. \r\n‘King’s Artists’ brings together artists and academics to trial new ideas and test pioneering approaches, building on King’s College London’s strong connections with the vibrant cultural community across London and beyond. Through academic and cultural exchange, King’s Artists nurtures experimentation, supports enquiry and inspires creative responses to academic research, while providing opportunities for artists to develop their practice alongside King\'s researchers.\r\n<br><br>\r\nDr Siân Oram, Lecturer in Women\'s Mental Health at the IoPPN commented:  \"It is by now well-documented that trafficked women report a high prevalence of mental distress many months, and even years, after regaining their freedom. Escape from situations of human trafficking cannot be equated with recovery from its harms. Through this project we hope to gain a better understanding of what helps women in their recovery and to communicate this to the widest possible audience.\"\r\n<br><br>\r\nAlison Duthie, Director of Programming at King\'s College London said “King’s Artists exists to provide academics and artists with a platform through which to interrogate and examine some of the most challenging questions for contemporary society. In drawing together, the experiences of women who have suffered the physical and psychological impact of modern slavery, Sara Shamma and Dr Siân Oram will provide both a means through which survivors can process their painful experiences, while also raising the public consciousness of the plight of the millions of women entrapped as modern slaves around the world.” \r\nRecovering from Modern Slavery is a King’s Artists collaboration between King’s College London’s Health Service and Population Research Department and artist Sara Shamma. It is supported by the King’s Sanctuary Programme, as part of King’s Worldwide, and by the university’s Culture team.\r\n<br><br>\r\nFor more information:\r\n<br><br>\r\n<a href=\"https://www.kcl.ac.uk/news/news-article?id=cf239a95-b01d-4436-a51c-dbd7741b57c7\" target=\"_BLANK\" style=\"color: #000\">https://www.kcl.ac.uk/news</a>\r\n<br><br>\r\n<a href=\"http://www.helenbamber.org/news/press-release-celebrated-syrian-artist-sara-shamma-partners-with-kings-college-london-and-helen-bamber-foundation-to-raise-awareness-of-modern-slavery/\" target=\"_BLANK\" style=\"color: #000\">http://www.helenbamber.org/news</a>', NULL, NULL, NULL),
(103, 1, 2, 2019, 'Sara Shamma shortlisted for the Asian Women of Achievement Awards (AWA), London', NULL, '2019-02-22', '2019-02-22', '2019-02-22', '22.2.2019.png', 'The Asian Women of Achievement Awards (AWA), in association with NatWest, has announced the shortlist of the 2019 awards.<br>\r\nThe awards, now in their 20th year, spotlight extraordinary achievements of Asian women across UK business, the arts, media, sport and social and humanitarian.<br>\r\nThe Asian Women of Achievement Awards, founded by Pinky Lilani CBE DL in 1999, celebrates multicultural Britain and the contribution of diverse cultures and talents to UK society. They put on a platform, the phenomenal Asian women across the UK and across industries, who are making a valuable and important contribution to British life. The awards play a key role in redefining the contribution of Asian women; and informing a new, positive, pro-diversity debate.<br>\r\nThe awards have led to the creation of numerous initiatives and projects designed to help women and improve opportunities for the next generation. The awards are not simply a night of recognition but a community and a programme of initiatives that offer the opportunity for candidates to meet like-minded women and build their networks.<br>\r\nSara Shamma was shortlisted for the category of ‘Arts & Culture’<br>\r\nAll shortlisted women take part automatically in the sister initiative, the ‘Women of the Future Programme’ through its ‘Women of the Future Network’, and become ‘a Women of the Future Ambassador’ who helps create a new generation of female role models in Britain today.', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cpy_exhibition_images`
--

DROP TABLE IF EXISTS `cpy_exhibition_images`;
CREATE TABLE IF NOT EXISTS `cpy_exhibition_images` (
  `iexhib_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `exhib_id` int(11) NOT NULL COMMENT 'Exhibition',
  `exhib_order` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Order',
  `exhib_image` varchar(100) NOT NULL COMMENT 'Image',
  PRIMARY KEY (`iexhib_id`),
  KEY `exhib_id` (`exhib_id`)
) ENGINE=InnoDB AUTO_INCREMENT=270 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_exhibition_images`
--

INSERT INTO `cpy_exhibition_images` (`iexhib_id`, `exhib_id`, `exhib_order`, `exhib_image`) VALUES
(48, 33, 0, 'P1070077_MP4_13_19_20_16_Still003.jpg'),
(49, 33, 0, 'R0010094.JPG'),
(50, 33, 0, 'R0010105.JPG'),
(51, 33, 0, 'R0010122.JPG'),
(52, 33, 0, 'SaraShamma054.JPG'),
(60, 37, 0, 'DSC_65881.JPG'),
(61, 37, 0, 'DSC_6582.JPG'),
(62, 37, 0, 'DSC_65741.JPG'),
(63, 37, 0, 'DSC_65201.JPG'),
(64, 37, 0, 'DSC_65051.JPG'),
(66, 38, 0, 'sarashammasmallsize-5.jpg'),
(67, 38, 0, 'sarashammasmallsize-4.jpg'),
(68, 38, 0, 'sarashammasmallsize-3.jpg'),
(69, 38, 0, 'sarashammasmallsize-2.jpg'),
(70, 38, 0, 'Sara_Shamma_Exhibition_156.jpg'),
(71, 38, 0, 'Sara_Shamma_Exhibition_119.jpg'),
(72, 38, 0, 'Sara_Shamma_Exhibition_98.jpg'),
(73, 38, 0, 'Sara_Shamma_Exhibition_92.jpg'),
(74, 38, 0, 'Sara_Shamma_Exhibition_52.jpg'),
(75, 38, 0, 'IMG_1016.JPG'),
(78, 39, 0, 'DSCF37621.JPG'),
(79, 39, 0, 'DSCF3768.JPG'),
(80, 39, 0, 'DSCF4081.JPG'),
(81, 39, 0, 'DSCF4094.JPG'),
(82, 39, 0, 'DSCF41481.JPG'),
(83, 39, 0, 'DSCF4151.JPG'),
(85, 40, 0, 'IMG_3807.JPG'),
(86, 40, 0, 'IMG_3806.JPG'),
(87, 40, 0, 'IMG_3805.JPG'),
(88, 40, 0, 'IMG_3800.JPG'),
(89, 40, 0, 'DSC_9809.jpg'),
(90, 40, 0, 'DSC_9806.jpg'),
(94, 42, 0, 'DSCF8778.JPG'),
(95, 42, 0, 'DSCF8788.JPG'),
(96, 42, 0, 'DSCF8807.JPG'),
(97, 42, 0, 'DSCF8867.JPG'),
(98, 42, 0, 'DSCF8868.JPG'),
(99, 42, 0, 'DSCF8908.JPG'),
(105, 45, 0, 'IMG_4074.JPG'),
(106, 45, 0, 'IMG_4063.JPG'),
(108, 46, 0, 'ArtPrize_Shamma_1_(2).jpg'),
(110, 47, 0, 'IMG_3747.JPG'),
(111, 47, 0, 'IMG_3751.JPG'),
(124, 53, 0, '2008_Waterhouse_(10).jpg'),
(125, 53, 0, '2008_Waterhouse_(13).JPG'),
(126, 53, 0, '2008_Waterhouse.JPG'),
(128, 54, 0, 'DSC01957.JPG'),
(129, 54, 0, 'DSC01967.JPG'),
(130, 54, 0, 'DSC02093.JPG'),
(132, 55, 0, '0_(87).JPG'),
(133, 55, 0, '0_(91).JPG'),
(159, 68, 0, '43.jpg'),
(163, 70, 0, '31.jpg'),
(173, 75, 0, '13.jpg'),
(174, 75, 0, '32.jpg'),
(185, 80, 0, '5.jpg'),
(220, 89, 0, 'IMG_40631.JPG'),
(221, 89, 0, 'IMG_40741.JPG'),
(222, 89, 0, 'IMG_40791.JPG'),
(234, 92, 0, 'DSCF32141.JPG'),
(235, 92, 0, 'DSCF33731.JPG'),
(236, 92, 0, 'r33917162283.jpg'),
(245, 94, 0, 'IMG_47092.JPG'),
(246, 94, 0, 'IMG_47112.JPG'),
(247, 94, 0, '1232.jpg'),
(249, 95, 0, 'IMG_5138.JPG'),
(250, 95, 0, 'IMG_5143.JPG'),
(252, 96, 0, 'DSCF0561.JPG'),
(253, 96, 0, 'DSCF0570.JPG'),
(254, 96, 0, 'DSCF0652.JPG'),
(255, 96, 0, 'DSCF0663.JPG'),
(256, 96, 0, 'IMG_4733.JPG'),
(257, 96, 0, 'IMG_4745.JPG'),
(258, 96, 0, 'IMG_4960.JPG'),
(259, 96, 0, 'IMG_4963.JPG'),
(260, 96, 0, 'IMG_4964.JPG'),
(261, 96, 0, 'Ø¥Ø¹Ù„Ø§Ù†.jpg'),
(265, 88, 0, '2008_Waterhouse_(13)1.JPG'),
(266, 88, 0, '2008_Waterhouse1.JPG'),
(268, 88, 0, '4_2008_oil_on_canvas_120x1005.jpg'),
(269, 96, 0, 'IMG_4753.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_exhibition_video`
--

DROP TABLE IF EXISTS `cpy_exhibition_video`;
CREATE TABLE IF NOT EXISTS `cpy_exhibition_video` (
  `vexhib_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `exhib_id` int(11) NOT NULL COMMENT 'Exhibition',
  `video_id` int(11) NOT NULL COMMENT 'Video',
  PRIMARY KEY (`vexhib_id`),
  KEY `exhib_id` (`exhib_id`),
  KEY `video_id` (`video_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_exhibition_video`
--

INSERT INTO `cpy_exhibition_video` (`vexhib_id`, `exhib_id`, `video_id`) VALUES
(1, 96, 17),
(2, 38, 196),
(3, 37, 197),
(4, 33, 198),
(5, 32, 199);

-- --------------------------------------------------------

--
-- Table structure for table `cpy_exhibkind`
--

DROP TABLE IF EXISTS `cpy_exhibkind`;
CREATE TABLE IF NOT EXISTS `cpy_exhibkind` (
  `kind_id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `kind_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Order',
  `kind_name` varchar(200) NOT NULL COMMENT 'Name',
  PRIMARY KEY (`kind_id`),
  UNIQUE KEY `kind_name` (`kind_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_exhibkind`
--

INSERT INTO `cpy_exhibkind` (`kind_id`, `kind_order`, `kind_name`) VALUES
(-1, 0, 'None'),
(0, 1, 'Exhibition'),
(1, 2, 'Award'),
(2, 3, 'News'),
(3, 4, 'News & Exhibition');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_exhibtype`
--

DROP TABLE IF EXISTS `cpy_exhibtype`;
CREATE TABLE IF NOT EXISTS `cpy_exhibtype` (
  `type_id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `type_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Order',
  `type_name` varchar(200) NOT NULL COMMENT 'Name',
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `type_name` (`type_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_exhibtype`
--

INSERT INTO `cpy_exhibtype` (`type_id`, `type_order`, `type_name`) VALUES
(1, 0, 'Solo Exhibitions'),
(2, 0, 'Group Exhibitions');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_page`
--

DROP TABLE IF EXISTS `cpy_page`;
CREATE TABLE IF NOT EXISTS `cpy_page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `page_name` varchar(200) NOT NULL COMMENT 'Name',
  `page_text` text COMMENT 'Text',
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `page_name` (`page_name`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_page`
--

INSERT INTO `cpy_page` (`page_id`, `status_id`, `page_name`, `page_text`) VALUES
(0, 1, 'No-Page', NULL),
(1, 1, 'Biography', '<p style=\"margin-left:0in; margin-right:0in\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Sara Shamma is a renowned painter whose works can be found in both public and private collections around the globe. Shamma was born in Damascus, Syria (1975) to a Syrian father and Lebanese mother. She graduated from the Painting Department of the Faculty of Fine Arts, University of Damascus in 1998. She moved to London in 2016 under the auspices of an Exceptional Talent Visa where she currently lives and works.</span></span></p>\r\n\r\n<p style=\"margin-left:0in; margin-right:0in\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Shamma&rsquo;s practice focuses on death and humanity expressed mainly through self-portraits and children painted in a life-like visceral way. Her works can be divided into series that reflect often prolonged periods of research, sometimes extending over years. Shamma believes that death gives meaning to life, and rather than steering away from a subject that is increasingly taboo in contemporary culture, she considers the impact of grief and deep internal emotions.The Syrian conflict has a distinct impact on the way that Shamma portrays her subjects. Working mainly from life and photographs, the artist uses oils to create a hyper realistic scene, using transparency lines and motion to portray a distant and deep void. </span></span></p>\r\n\r\n<p style=\"margin-left:0in; margin-right:0in\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Shamma has previously taught at the Adham Ismail Fine Arts Institute in Damascus, and alongside her practice has always had a strong dedication to sharing her knowledge with the next generation of artists. She was a member of the jury for The Annual Exhibition for Syrian Artists held by the Ministry Of Culture, in Damascus, 2006.</span></span></p>\r\n\r\n<p style=\"margin-left:0in; margin-right:0in\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Shamma believes in helping others and has been supporting the United Nations World Food Programme since 2010, during which time she produced Fighting Hunger., sold by Christie&rsquo;s Dubai in 2012 with all proceeds going to the WFP.&nbsp; Shamma has participated in a number of solo and group exhibitions including: &ldquo;London&rdquo;, Art Sawa Gallery (Dubai, 2017); World Civil War Portraits, The Old Truman Brewery (London, 2015); Diaspora, Art Sawa Gallery (Dubai, 2014); Q, Royal College of Art (London, 2013); Birth, Art House (Damascus, 2011); Love, 360 MALL (Kuwait, 2009); The Royal Society of Portrait Painters Annual Exhibition, The Mall Galleries (London, 2013); Nord Art 2012 organized by KiC &ndash; Kunst in der Carlsh&uuml;tte (B&uuml;delsdorf, 2012); UAE Through Arabian Eyes, (Dubai, 2008); Syrian Artists, Souq Wakef Art Center (Doha, 2008); Panorama of Syrian Arts, Catzen Arts Centre at The American University (Washington D.C, 2007); (shortlisted) International Painting Prize of the Castellon County Council, (Castellon 2005), Castellon and the Municipal Arts Centre of Alcorcon, (Madrid, 2005-2006); Women and Arts, International Vision, Expo Sharjah (Sharjah, 2005).</span></span></p>\r\n\r\n<p style=\"margin-left:0in; margin-right:0in\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Art Awards include first prize in Latakia Biennial, Syria (2001), 4th BP Portrait Award, National Portrait Gallery, London (2004), 1st The Waterhouse Natural History Art Prize, The South Australian Museum (2008), and a painting prize at the Florence Biennial (2013)</span></span></p>\r\n\r\n<p style=\"margin-left:0in; margin-right:0in\"><u><strong><a href=\"http://sarashamma.com/uploads/Sara_Shamma_CV.pdf\" target=\"_blank\"><span style=\"color:#000000\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">DOWNLOAD CV - PDF</span></span></span></a></strong></u></p>'),
(2, 1, 'Contact', '<p>Gagosian Gallery&nbsp;</p>\r\n<p>Hannah Freedberg</p>\r\n<p>hannah@gagosian.com</p>\r\n<p>www.gagosian.com</p>\r\n<p>&nbsp;</p>\r\n<p>Galerie Max Hetzler&nbsp;</p>\r\n<p>Samia Saouma</p>\r\n<p>samia.saouma@maxhetzler.com&nbsp;</p>\r\n<p>www.maxhetzler.com</p>\r\n<p>&nbsp;</p>\r\n<p>Sara Shamma Studio (London)</p>\r\n<p>Edgar Laguinia</p>\r\n<p>studiopoe@gmail.com</p>\r\n<p>www.sara-shamma.co.uk</p>\r\n'),
(3, 1, 'CV', '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center\"><strong><span style=\"font-size:22px\"><span style=\"font-family:Calibri,sans-serif\">SARA SHAMMA&nbsp; CURICULUM VITAE</span></span></strong></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Sara Shamma Born 1975 in Damascus, Syria. Lives and works in London</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><strong><span style=\"font-size:20px\"><span style=\"font-family:Calibri,sans-serif\">Education</span></span></strong></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><strong><span style=\"font-size:16px\"><span style=\"font-family:Calibri,sans-serif\">1998</span></span></strong></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Graduated from the Faculty of Fine Arts (Painting Department), Damascus University, Damascus, Syria. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">1995</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Graduated from Adham Ismaiil Fine Arts Institute, Damascus, Syria.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:20px\"><span style=\"font-family:Calibri,sans-serif\"><strong>Other activities</strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2006</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Member of The Jury of The Annual Exhibition for Syrian Artists held by the Ministry of Culture, Damascus, Syria. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2004</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Member of The Jury of graduation show, ESMOD Fashion Institute, Damascus, Syria.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">1997-2000</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Taught in Adham Ismaiil Fine Arts Institute, Damascus, Syria. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:20px\"><span style=\"font-family:Calibri,sans-serif\"><strong>Selected Solo Exhibitions</strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2017</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;London&rdquo; Art Sawa Gallery, Dubai, UAE</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2015</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;World Civil War Portraits&rdquo; curated by Sacha Craddock at The Old Truman Brewery, London, UK</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2014</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Diaspora&rdquo; Art Sawa Gallery, Dubai, UAE.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2013</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Q&rdquo; Royal College of Art, London, UK.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2011</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Birth&rdquo; Art House, Damascus, Syria.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2009</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;The Sema Ceremony from Turkey with Sara Shamma&rsquo;s Dervishes&rdquo; event organized by the Turkish Embassy in Damascus and Art House, Art House, Damascus, Syria.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Love 2009&rdquo; 360 MALL, Kuwait.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2008</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Sara Shamma 2008&rdquo; &#39;Finishing Touch&#39;, Knowledge Village, Dubai, U.A.E. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Sara 1978&rdquo; Art House, Damascus, Syria. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2007</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Music 2007&rdquo; Cornish Club Event Gallery, Kuwait.&nbsp;&nbsp; </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Sara Shamma 2007&rdquo; Art House, Damascus, Syria. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2004</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Sara Shamma 2004&rdquo; Kalemaat Art Gallery, Aleppo, Syria.&nbsp;&nbsp; </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Sara Shamma 2004&rdquo; Karizma Art Gallery, Kuwait.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&nbsp;</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2002</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Sara Shamma 2002&rdquo; Nassir Choura Art Gallery, Damascus, Syria.&nbsp;&nbsp; </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2001</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Sara Shamma 2001&rdquo; Shell Cultural Club, Damascus, Syria.&nbsp; </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2000</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Sara Shamma 2000&rdquo; Nassir Choura Art Gallery, Damascus, Syria.&nbsp; </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">1999</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Sara Shamma 1999&rdquo; French Cultural Center, Damascus, Syria.&nbsp;&nbsp; </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:20px\"><span style=\"font-family:Calibri,sans-serif\"><strong>Selected Group Exhibitions</strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2018</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">The Summer Exhibition, Royal Academy of Art, London, UK.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">New collective show, Mark Hachem Gallery, Beirut, Lebanon.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2015</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Guest artist at the 33rd Emirates Fine Arts Society Annual Exhibition, Sharjah Art Museum.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2013</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Florence Biennial, Florence, Italy.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">The Royal Society of Portrait Painters Annual Exhibition, The Mall Galleries, London.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2012</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Nord Art 2012&rdquo; Annual International Exhibition, organized by KiC &ndash; Kunst in der Carlsh&uuml;tte, B&uuml;delsdorf, Germany.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2011</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">The Samawi Collection, Ayyam Art gallery, Dubai, UAE.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Syrian Cutural days in Turkey organied by The Ministry Of Culture, Istanbul, Turkey.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2010</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Contemporary art from the Middle East, Ayyam Gallery, Dubai, UAE.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Art Prize 2010, Kendall College of Art and Design, Grand Rapids, Michigan, USA.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Nord Art 2010&rdquo; Annual International Exhibition, Curated by KiC &ndash; Kunst in der Carlsh&uuml;tte, B&uuml;delsdorf, Germany.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2009</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Contemporary Istanbul&rdquo; International Art Fair, Istanbul, Turkey.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Jableh Cultural Festival, 5th Edition&rdquo; Jableh, Syria.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Let it be Jewelry&rdquo; an Exhibition of unique jewelry designed by artists from the Arab World, organized by Sayegh Jewelry at Art House, Damascus, Syria.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Sana&rsquo;a international forum for plastic arts, Sana&rsquo;a, Yemen</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2008/09</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Damas- Paris, Regards Crois&eacute;s&rdquo; The Arab World Institute, Paris, France and at the National Museum, Damascus, Syria.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2008</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;UAE Through Arabian Eyes&rdquo; the International Financial Centre, Dubai, UAE.&nbsp; </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Syrian Artists&rdquo; Souq Wakef Art Center, Doha, Qatar.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;The Waterhouse Natural History Art Prize&rdquo; South Australian Museum, Adelaide, South Australia and the National Archives of Australia in Canberra, Australia.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Retrospective of fine arts in Syria, National museum of Damasus, Syria.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2007</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Panorama of Syrian Arts&rdquo; Catzen Arts Centre The American University Washington, D.C. USA.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2006</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Syrian Artists&rdquo; Syrian Cultural Centre, Paris, France. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2005</span></strong></span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">International Painting Prize of the Castellon County Council, ESPAI (the Contemporary Art Centre), Castellon and the Municipal Arts Centre of Alcorcon, Madrid, Spain.</span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Syrian Artists&rdquo; National Library, Madrid, Spain.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2005</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Women and Arts, International Vision&rdquo; Expo Sharjah, Sharjah, UAE.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2004 - 2005</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;BP Portrait Award&rdquo; National Portrait Gallery, London, Royal Albert Memorial Museum, Exeter, Aberdeen Art Gallery, Aberdeen, Royal West of England Academy, Bristol and Aberystwyth Arts Centre, Aberystwyth, UK.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2004</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Syrian Artists&rdquo; Kalemaat art Gallery, Aleppo, Syria.&nbsp; </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2003</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;FMA - Festival du Monde Arabe de Montr&eacute;al&rdquo; Montreal, Canada. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;International Women Arts&rdquo; Organised by Le Pont Art Gallery, Aleppo, Syria. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2002</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"background-color:#fafafa\"><span style=\"color:#141414\">&ldquo;Syrian Artists&rdquo; Gallery Amber, Leiden and Enschede, The Netherlands.</span></span></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;International Artists&rdquo; Gallery M-Art, Vienna, Austria. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Mediterranean Biennial&rdquo; (representing Syria) Kheir El Din&nbsp; Palace, Tunis, Tunisia. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Arab Artists&rdquo; Dar AL Anda Art Gallery, Amman, Jordan.&nbsp;&nbsp; </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2001</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;ARTUEL&rdquo; International Art Fair, Beirut, Lebanon. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Two Syrian Artists&rdquo; Coventry Museum Coventry, UK.&nbsp;&nbsp; </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Lattakia Biennial&rdquo; Lattakia, Syria.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Sharjah Biennial&rdquo; Sharjah, UAE. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Cairo Biennial&rdquo; Cairo, Egypt. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Women and War Art Exhibition&rdquo; The Red Cross International Committee of Syria, Jordan and Switzerland.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Absolument Femme, Imar gallery, Latakia, Syria</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2000</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Monte Roza Symposium for Syrian and Lebanese artists, Damascus, Syria.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">1994 to 2005</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Participated in all Ministry of Culture&#39;s Exhibitions in Syria and abroad. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">1994 to 2005</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><span style=\"color:#141414\">Participated in different exhibitions in Damascus: National Museum of Damascus, Al Assad National Library, Damascus International Fair, Al Shaab Art Gallery, Al Riwaq Art Gallery, Arabic Cultural Center, Spanish Cultural Center, British Council, Albal Art Gallery, Al Sayed Art Gallery, Ashtar Art Gallery, Jabri Art Gallery, Occasions + art, Croquis Art Gallery and Holly Cross Halls, </span></span></span><span style=\"color:null\"><span style=\"font-size:11.0pt\">Kozah Art Gallery</span><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">. </span></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:20px\"><span style=\"font-family:Calibri,sans-serif\"><strong>&nbsp;Awards and Recognitions</strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2019</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Shortlisted for Asian Women of Achievement Awards (Arts and Culture), London, UK.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2013</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Fourth prize in painting, and Special Mention, Florence Biennial, Florence, Italy.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2011</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Nominated as the Celebrity Partner of The United Nations World Food Programme.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">The revealing of Shamma&#39;s painting: &ldquo;Fighting Hunger&rdquo;at Damascus Opera House during the premiere of Syrian film director, Nabil Al-Maleh&rsquo;s movie: &ldquo;Story of a Painting&quot;.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&ldquo;Fighting Hunger&rdquo; was then exhibited at The National Museum of Damascus.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">5 paintings were exhibited during WFP Regional Meeting in M&ouml;venpick Hotel in Dead Sea, Jordan.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2010</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Shortlisted for the Nord Art Prize, Annual International Exhibition, organised by KiC (Kunst in der Carlsh&uuml;tte), B&uuml;delsdorf, Germany.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2008</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">First Prize in Painting, Waterhouse Natural History Art Prize, The South Australian Museum, Adelaide, South Australia, Australia. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2006</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Fine Arts Syndicate Award, Damascus, Syria.&nbsp;&nbsp; </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2004</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Fourth Prize, BP Portrait Award. The National Portrait Gallery, London, UK. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2001</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">First Prize (The Golden Medal), Latakia Biennial (Painting), Latakia, Syria.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2000</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Second prize in the Spanish Cultural Center Art Competition, Damascus,&nbsp; Syria.&nbsp; </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&nbsp;</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">2000</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Second prize, British Council Art Competition, Damascus , Syria.&nbsp;&nbsp; </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">1998</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Second prize, Youth Exhibition organized by the Fine Arts Syndicate, Damascus, Syria. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\"><strong><span style=\"font-size:12.0pt\">1998</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Ranked First among graduates (First Prize) in the Faculty of Fine Arts of Damascus University, Syria.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:20px\"><span style=\"font-family:Calibri,sans-serif\"><strong>Collections </strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Shamma&#39;s works can be found in public Collections: Presidential Palace, Ministry of Culture, National Museum, British Council, Spanish Cultural Center, Damascus, Syria.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Private Collections in: Austria, Canada, Ecuador, Egypt, France, Germany, Japan, Jordan, Kuwait, Lebanon, the Netherland, Qatar, Spain, Syria, Tunisia, Turkey, the United Arab Emirates, the United Kingdom and the United States of America.</span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">&nbsp;&nbsp; </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\">&nbsp;</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_page_images`
--

DROP TABLE IF EXISTS `cpy_page_images`;
CREATE TABLE IF NOT EXISTS `cpy_page_images` (
  `ipage_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `page_id` int(11) NOT NULL COMMENT 'Page, FK',
  `page_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Order',
  `page_image` varchar(200) NOT NULL COMMENT 'Image',
  PRIMARY KEY (`ipage_id`),
  KEY `page_id` (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_page_images`
--

INSERT INTO `cpy_page_images` (`ipage_id`, `page_id`, `page_order`, `page_image`) VALUES
(1, 1, 0, 'sara profile.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_publication`
--

DROP TABLE IF EXISTS `cpy_publication`;
CREATE TABLE IF NOT EXISTS `cpy_publication` (
  `pub_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `pub_order` int(11) NOT NULL DEFAULT '0' COMMENT 'Order',
  `pub_title1` varchar(1000) NOT NULL COMMENT 'Main Title',
  `pub_title2` varchar(1000) DEFAULT NULL COMMENT 'Sub Title',
  `pub_publisher` varchar(1000) DEFAULT NULL COMMENT 'Publisher',
  `pub_dimensions` varchar(1000) DEFAULT NULL COMMENT 'Dimension',
  `pub_editor` varchar(1000) DEFAULT NULL COMMENT 'Editor',
  `pub_text` text NOT NULL COMMENT 'Text',
  `pub_image` varchar(1000) NOT NULL COMMENT 'Image',
  `bibl_id` int(11) NOT NULL COMMENT 'Bibliography',
  PRIMARY KEY (`pub_id`),
  KEY `bibl_id` (`bibl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_publication`
--

INSERT INTO `cpy_publication` (`pub_id`, `pub_order`, `pub_title1`, `pub_title2`, `pub_publisher`, `pub_dimensions`, `pub_editor`, `pub_text`, `pub_image`, `bibl_id`) VALUES
(10, 0, 'Sara Shamma 2000-2005', 'Damascus 2005', '', 'Catalogue 48 Pages (22x23 cm) ', '', '', '2005_Sara_Shamma_2000-20053.JPG', 1),
(11, 0, 'Sara Shamma 2005-2007', 'Damascus 2007 ', '', 'Catalogue in the occasion of 2007 Exhibition in Damascus 96 Pages (30x25 cm) ', '', '', '2007_Sara_Shamma_2005-2007.JPG', 1),
(12, 0, 'Sara Shamma Music 2007', 'Kuwait 2007', '', 'Catalogue in the occasion of 2007 Exhibition in Kuwait 48 Pages          (22x23 cm)', '', '', '2007_Sara_Shamma_Music_2007.JPG', 1),
(13, 0, 'Sara Shamma 2008', 'Damascus 2008', '', 'Catalogue in the occasion of 2008 Exhibitions in Damascus, Qatar and Dubai 150 Pages (30x24 cm)', '', '', '2008_Sara_Shamma_2008.JPG', 1),
(14, 0, 'Sara Shamma Love 2009', 'Kuwait 2009', '', 'Catalogue in the occasion of 2009 Exhibition in Kuwait 48 Pages   (22x23 cm) ', '', '', '2009_Sara_Shamma_Love_2009.JPG', 1),
(15, 0, 'Sara Shamma 2009-2010', 'Damascus 2011', 'in collaboration with Mamdouh Adwan for publishing & distributing', 'Catalogue 112 Pages (30x25 cm)', '', '', '2010_Sara_Shamma_2009-20101.JPG', 1),
(16, 0, 'Sara Shamma Q', 'London 2013 ', 'Essay by Jessica lack, published by ART MASTERS to accompany the exhibition “Q” at the Royal College of Art', 'Catalogue 20 pages (19x23 cm)', '', '', '2013_Sara_Shamma_Q_.jpg', 1),
(17, 0, '“DIASPORA” Sara Shamma', 'Dubai 2014', 'Essay by Edward Lucie Smith, published by Art Sawa to accompany the exhibition “DIASPORA” at Art Sawa Gallery', 'Catalogue 32 pages (20.5x26.5 cm)', '', '', '2014_“DIASPORA”_Sara_Shamma_.JPG', 1),
(18, 0, 'Sara Shamma ', 'London 2014', 'essay by Edward Lucie Smith and interview by Sacha Craddock', 'Catalogue 64 pages (24.5x24.5 cm)', '', '', '2014_Sara_Shamma_2.JPG', 1),
(19, 0, 'World Civil War Portraits Sara Shamma', 'London 2015 ', 'essay by Sacha Craddock, published by Stolen Space Gallery to accompany the exhibition “World Civil War Portraits” at The Old Truman Brewery', 'Catalogue 56 pages (25x31 cm)', '', '', '2015_World_Civil_War_Portraits_Sara_Shamma_.JPG', 1),
(20, 0, '“London” Sara Shamma', 'Dubai 2017', 'Essay by Charlotte Mullins, published by Art Sawa to accompany the exhibition “London” at Art Sawa Gallery', 'Catalogue 32 pages (20.5x26.5 cm)', '', '', '2017_“London”_Sara_Shamma_1.JPG', 1),
(21, 0, '2007', '', '', '', '', '', '2007.jpg', 2),
(22, 0, '2008', '', '', '', '', '', '2008.jpg', 2),
(23, 0, '2009', '', '', '', '', '', '2009.jpg', 2),
(24, 0, '2010', '', '', '', '', '', '2010.jpg', 2),
(25, 0, '2010', '', '', '', '', '', '2010-1.jpg', 2),
(26, 0, '2011', '', '', '', '', '', '2011.JPG', 2),
(27, 0, '2011', '', '', '', '', '', '2011-1.JPG', 2),
(28, 0, '2011', '', '', '', '', '', '2011-2.JPG', 2),
(29, 0, '2012', '', '', '', '', '', '2012.jpg', 2),
(31, 0, '“London” Sara Shamma 2018', '', 'Essay by Charlotte Mullins, published by Sara Shamma LTD', ' Catalogue 72 pages (25x31 cm)', '', '', '2018.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cpy_slider_mst`
--

DROP TABLE IF EXISTS `cpy_slider_mst`;
CREATE TABLE IF NOT EXISTS `cpy_slider_mst` (
  `slid_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `slid_name` varchar(200) NOT NULL COMMENT 'Name',
  `slid_rem` varchar(200) DEFAULT NULL COMMENT 'Remark',
  `stype_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Type',
  `scols_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Columns',
  PRIMARY KEY (`slid_id`),
  KEY `scols_id` (`scols_id`),
  KEY `stype_id` (`stype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_slider_mst`
--

INSERT INTO `cpy_slider_mst` (`slid_id`, `slid_name`, `slid_rem`, `stype_id`, `scols_id`) VALUES
(0, 'No Slider', NULL, 1, 1),
(3, 'Main', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cpy_slider_trn`
--

DROP TABLE IF EXISTS `cpy_slider_trn`;
CREATE TABLE IF NOT EXISTS `cpy_slider_trn` (
  `tslid_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `slid_id` int(11) NOT NULL COMMENT 'Parent',
  `slid_order` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Slide Order',
  `slid_image` varchar(200) NOT NULL COMMENT 'Image',
  PRIMARY KEY (`tslid_id`),
  KEY `slid_id` (`slid_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_slider_trn`
--

INSERT INTO `cpy_slider_trn` (`tslid_id`, `slid_id`, `slid_order`, `slid_image`) VALUES
(18, 3, 1, '15.JPG'),
(19, 3, 2, '21.JPG'),
(20, 3, 3, '31.JPG'),
(22, 3, 5, '51.JPG'),
(23, 3, 6, '6.JPG'),
(25, 3, 8, '8.JPG'),
(26, 3, 9, '91.JPG'),
(27, 3, 10, '101.JPG'),
(28, 3, 11, '112.JPG'),
(29, 3, 12, '121.JPG'),
(30, 3, 13, '132.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_subject`
--

DROP TABLE IF EXISTS `cpy_subject`;
CREATE TABLE IF NOT EXISTS `cpy_subject` (
  `subj_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `subj_order` int(11) NOT NULL DEFAULT '0' COMMENT 'Order',
  `subj_name` varchar(200) NOT NULL COMMENT 'Name',
  PRIMARY KEY (`subj_id`),
  UNIQUE KEY `subj_name` (`subj_name`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_subject`
--

INSERT INTO `cpy_subject` (`subj_id`, `subj_order`, `subj_name`) VALUES
(11, 0, 'Self Portrait'),
(15, 0, 'Drawing'),
(16, 0, 'Women'),
(17, 0, 'Animals'),
(18, 0, 'Children'),
(19, 0, 'Darvishes'),
(20, 0, 'Landscape'),
(21, 0, 'Men'),
(22, 0, 'Men and women'),
(23, 0, 'Music'),
(24, 0, 'Nude'),
(26, 0, 'Still life'),
(28, 0, 'War');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_subscribe`
--

DROP TABLE IF EXISTS `cpy_subscribe`;
CREATE TABLE IF NOT EXISTS `cpy_subscribe` (
  `sub_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `sub_email` varchar(200) NOT NULL COMMENT 'Email',
  `status_id` tinyint(1) NOT NULL COMMENT 'Status',
  PRIMARY KEY (`sub_id`),
  UNIQUE KEY `sub_email` (`sub_email`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_subscribe`
--

INSERT INTO `cpy_subscribe` (`sub_id`, `sub_email`, `status_id`) VALUES
(2, 'message@sarashamma.com', 1),
(3, 'elias.hijazi@nazhaco.com', 1),
(4, 'e66exgirl@gm@il.com', 1),
(7, 'lace@cooperlace.com', 1),
(8, 'Randy@TalkWithLead.com', 1),
(9, 'getmore@ytshugbs.com', 1),
(10, 'info@loomcrafts.com', 1),
(11, 'rick.nahm@globaltopround.com', 1),
(12, 'seale.esmeralda@yahoo.com', 1),
(13, 'bage.adolfo@gmail.com', 1),
(14, 'noreply@socialchief.online', 1),
(16, 'perrin.crystle@gmail.com', 1),
(17, 'liliana.tait@outlook.com', 1),
(18, 'milenkoivanovic@gmail.com', 1),
(19, 'naures.atto@gmail.com', 1),
(20, 'fuzz@fuzzillustration.com', 1),
(21, 'susancook@4videodeals.com', 1),
(22, 'gale.cade40@yahoo.com', 1),
(23, 'mado@yougottabeyou.com', 1),
(24, 'elizabethghoa2gonzalez@aol.com', 1),
(26, 'ima.lampe@gmail.com', 1),
(28, 'lora.segura95@yahoo.com', 1),
(29, 'hannahqevz0martin@aol.com', 1),
(30, 'minerva.mcneely@gmail.com', 1),
(31, 'cristine.langridge84@gmail.com', 1),
(33, 'noreply@noboostnoglory.club', 1),
(34, 'xogle@aol.com', 1),
(35, 'valencia.arreguin@msn.com', 1),
(36, 'kennethevans34@gmx.com', 1),
(37, 'scobie.holley@gmail.com', 1),
(38, 'brownallison63@aol.com', 1),
(39, 'tony.coombes85@gmail.com', 1),
(41, 'george1@georgemartinjr.com', 1),
(42, 'eric@talkwithcustomer.com', 1),
(43, 'hello@szifon.com', 1),
(45, 'aly1@alychidesigns.com', 1),
(48, 'haun.penny@msn.com', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `cpy_vartwork`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `cpy_vartwork`;
CREATE TABLE IF NOT EXISTS `cpy_vartwork` (
`type_id` tinyint(4)
,`type_order` tinyint(4)
,`type_name` varchar(200)
,`art_id` int(11)
,`art_year` smallint(6)
,`art_title1` varchar(1000)
,`art_title2` varchar(1000)
,`art_size` varchar(1000)
,`art_image` varchar(1000)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `cpy_vartwork_subjects`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `cpy_vartwork_subjects`;
CREATE TABLE IF NOT EXISTS `cpy_vartwork_subjects` (
`subj_id` int(11)
,`subj_order` int(11)
,`subj_name` varchar(200)
,`type_id` tinyint(4)
,`type_order` tinyint(4)
,`type_name` varchar(200)
,`art_id` int(11)
,`art_year` smallint(6)
,`art_title1` varchar(1000)
,`art_title2` varchar(1000)
,`art_size` varchar(1000)
,`art_image` varchar(1000)
);

-- --------------------------------------------------------

--
-- Table structure for table `cpy_video`
--

DROP TABLE IF EXISTS `cpy_video`;
CREATE TABLE IF NOT EXISTS `cpy_video` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `video_date` date NOT NULL COMMENT 'Date',
  `video_title1` varchar(200) NOT NULL COMMENT 'Main Title',
  `video_title2` varchar(1000) NOT NULL COMMENT 'Sub Title',
  `video_URL` varchar(1024) NOT NULL COMMENT 'URL',
  `video_text` varchar(10000) NOT NULL COMMENT 'Text',
  PRIMARY KEY (`video_id`),
  UNIQUE KEY `video_title1` (`video_title1`)
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_video`
--

INSERT INTO `cpy_video` (`video_id`, `video_date`, `video_title1`, `video_title2`, `video_URL`, `video_text`) VALUES
(17, '2011-03-14', 'Story of a painting, Film by Nabil Al Maleh 2011', '', 'https://player.vimeo.com/video/240950484', ''),
(196, '2013-11-26', 'Sara Shamma, Q 2013', '', 'https://player.vimeo.com/video/240948393', ''),
(197, '2014-10-27', 'Sara Shamma, Diaspora 2014', '', 'https://player.vimeo.com/video/240953363', ''),
(198, '2015-05-11', 'Sara Shamma, World Civil War Portraits 2015', '', 'https://player.vimeo.com/video/240949825', ''),
(199, '2017-04-18', 'Sara Shamma, London exhibition 2017', '', 'https://player.vimeo.com/video/240952470', '');

-- --------------------------------------------------------

--
-- Table structure for table `phs_menu`
--

DROP TABLE IF EXISTS `phs_menu`;
CREATE TABLE IF NOT EXISTS `phs_menu` (
  `menu_id` int(10) NOT NULL COMMENT 'PK',
  `menu_pid` int(11) NOT NULL COMMENT 'Parent Menu',
  `page_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Dynamic Page',
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status',
  `menu_order` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Order to display menu',
  `menu_name` varchar(200) NOT NULL COMMENT 'Name',
  `menu_icon` varchar(50) DEFAULT NULL COMMENT 'Icon',
  `menu_href` varchar(200) DEFAULT NULL COMMENT 'Link',
  `menu_target` varchar(50) DEFAULT NULL COMMENT 'Target',
  `menu_page` varchar(50) DEFAULT NULL COMMENT 'Page file name',
  PRIMARY KEY (`menu_id`),
  KEY `menu_status` (`status_id`),
  KEY `menu_pid` (`menu_pid`),
  KEY `page_id` (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_menu`
--

INSERT INTO `phs_menu` (`menu_id`, `menu_pid`, `page_id`, `status_id`, `menu_order`, `menu_name`, `menu_icon`, `menu_href`, `menu_target`, `menu_page`) VALUES
(-1, -1, 0, 1, 0, 'Menu', NULL, NULL, NULL, NULL),
(0, 0, 0, 1, 0, 'Main Menu', NULL, NULL, NULL, NULL),
(1, -1, 0, 1, 0, 'Socials', NULL, NULL, NULL, NULL),
(2, -1, 0, 1, 0, 'Artworks', NULL, NULL, NULL, 'page-artwork.php'),
(3, -1, 0, 1, 0, 'Exhibition', NULL, NULL, NULL, 'page-exhibition.php'),
(100, 0, 0, 1, 0, 'Home', NULL, NULL, NULL, 'page-main.php'),
(101, 0, 0, 1, 1, 'Biography', NULL, NULL, NULL, 'page-biography.php'),
(102, 0, 0, 1, 2, 'News', NULL, NULL, NULL, 'page-news.php'),
(103, 0, 0, 1, 3, 'Artworks', NULL, NULL, NULL, 'page-artworks.php'),
(104, 0, 0, 1, 4, 'Exhibitions', NULL, '104/1', NULL, 'page-exhibitions.php'),
(105, 0, 0, 1, 5, 'Awards and Honors', NULL, NULL, NULL, 'page-awards.php'),
(106, 0, 0, 1, 6, 'Bibliography', NULL, '106/1', NULL, 'page-bibliography.php'),
(107, 0, 0, 1, 7, 'Video', NULL, NULL, NULL, 'page-video.php'),
(108, 0, 0, 1, 8, 'Contact', NULL, NULL, NULL, 'page-contact.php'),
(201, 1, 0, 1, 1, 'Facebook', NULL, 'https://www.facebook.com/SaraShamma.artist/', '_BLANK', NULL),
(202, 1, 0, 1, 2, 'Twitter', NULL, 'https://twitter.com/sarashamma', '_BLANK', NULL),
(203, 1, 0, 1, 3, 'Instagram', NULL, 'https://www.instagram.com/sara.shamma.artist/', '_BLANK', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phs_metta`
--

DROP TABLE IF EXISTS `phs_metta`;
CREATE TABLE IF NOT EXISTS `phs_metta` (
  `mtta_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `metta_type` varchar(50) NOT NULL DEFAULT 'name' COMMENT 'Type',
  `metta_name` varchar(200) NOT NULL COMMENT 'Name',
  `metta_value` text NOT NULL COMMENT 'Value',
  PRIMARY KEY (`mtta_id`),
  UNIQUE KEY `metta_name` (`metta_name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_metta`
--

INSERT INTO `phs_metta` (`mtta_id`, `metta_type`, `metta_name`, `metta_value`) VALUES
(1, 'name', 'autor', 'PhSoft'),
(3, 'name', 'keywords', 'Software, PhSoft, Software house, ERP, ORACLE, JAVA, PHP'),
(4, 'name', 'description', 'PhSoft is a famous Software house in the middle east'),
(5, 'name', 'viewport', 'width=device-width, initial-scale=1.0'),
(7, 'property', 'og:site_name', 'PhSoft'),
(8, 'property', 'og:title', 'PhSoft'),
(9, 'property', 'og:description', 'PhSoft is a famous Software house in the middle east'),
(10, 'property', 'og:type', 'website'),
(11, 'property', 'og:image', 'http://www.phsoft.biz/images/phsoft.png'),
(12, 'property', 'og:url', 'http://www.phsoft.biz'),
(13, 'http-equiv', 'X-UA-Compatible', 'IE=edge,chrome=1');

-- --------------------------------------------------------

--
-- Table structure for table `phs_perms`
--

DROP TABLE IF EXISTS `phs_perms`;
CREATE TABLE IF NOT EXISTS `phs_perms` (
  `perm_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `pgrp_id` int(11) NOT NULL COMMENT 'Permission Group',
  `perm_table` varchar(255) NOT NULL COMMENT 'Table Name',
  `perm_perm` int(11) NOT NULL COMMENT 'Permission',
  PRIMARY KEY (`perm_id`),
  KEY `pgrp_id` (`pgrp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `phs_pgroup`
--

DROP TABLE IF EXISTS `phs_pgroup`;
CREATE TABLE IF NOT EXISTS `phs_pgroup` (
  `pgrp_id` int(11) NOT NULL COMMENT 'PK',
  `pgrp_name` varchar(255) NOT NULL COMMENT 'Name',
  PRIMARY KEY (`pgrp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_pgroup`
--

INSERT INTO `phs_pgroup` (`pgrp_id`, `pgrp_name`) VALUES
(-2, 'Anonymous'),
(-1, 'Administrator'),
(0, 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `phs_setting`
--

DROP TABLE IF EXISTS `phs_setting`;
CREATE TABLE IF NOT EXISTS `phs_setting` (
  `set_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `set_name` varchar(100) NOT NULL COMMENT 'Name',
  `set_val` varchar(255) NOT NULL DEFAULT 'none' COMMENT 'Value',
  PRIMARY KEY (`set_id`),
  UNIQUE KEY `set_name` (`set_name`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_setting`
--

INSERT INTO `phs_setting` (`set_id`, `set_name`, `set_val`) VALUES
(7, 'Disp-Header', '1'),
(8, 'Disp-Footer', '1'),
(10, 'Search-Result-Lines', '3'),
(27, 'Main-Menu', '0'),
(29, 'Site-Name', 'Sara Shamma'),
(30, 'Disp-Facebook', '1'),
(31, 'URL-facebook', 'https://www.facebook.com/PageRef'),
(32, 'Disp-Search', '1'),
(34, 'Default-Slider', 'Main Slider'),
(36, 'Socials-Menu', '1'),
(37, 'Disp-Top-Right-Menu', '1'),
(38, 'Disp-Top-Left-Menu', '1'),
(39, 'Disp-Slider', '1'),
(40, 'Disp-PreHeader', '1'),
(41, 'Disp-Menu-Search', '1'),
(42, 'Disp-PreFooter', '1'),
(43, 'Home-Menu', '100'),
(44, 'Disp-Langs', '1'),
(45, 'App-Web-URL', 'http://localhost:8080/eadrx/app'),
(46, 'App-Android-URL', 'http://localhost:8080/eadrx/downloads/androida.apk'),
(47, 'Nav-Left-Menu', '3'),
(48, 'Nav-Right-Menu', '4'),
(49, 'TIPS-FREE', '1'),
(50, 'TIPS-PAID', '2'),
(51, 'APP-DISP-ADS', '0'),
(52, 'APP-DISP-FreeTips', '1'),
(53, 'Currency-Sign', '$'),
(54, 'Path-Ads-Images', 'assets/img/adsImages/'),
(55, 'Path-Book-Images', 'assets/img/bookImages/'),
(56, 'Path-Test-Images', 'assets/img/testImages/'),
(57, 'App-Menu-Book', '3401'),
(60, 'App-Mode-Login', '0'),
(61, 'App-Mode-Register', '-1'),
(62, 'App-Page-Login', 'app-login.php'),
(63, 'App-Page-Book-Subscribe', 'app-book-subscribe.php'),
(64, 'App-Page-Main', 'app-main.php'),
(65, 'App-Menu-Test', '3201'),
(66, 'App-Menu-Take-Test', '3209'),
(67, 'App-Menu-Book-Subscribe', '3409'),
(68, 'App-Page-Book', 'app-book.php'),
(69, 'App-Page-Take-Test', 'app-test-take.php'),
(70, 'App-Page-Register', 'app-register.php');

-- --------------------------------------------------------

--
-- Table structure for table `phs_slider_cols`
--

DROP TABLE IF EXISTS `phs_slider_cols`;
CREATE TABLE IF NOT EXISTS `phs_slider_cols` (
  `scols_id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK ',
  `scols_name` varchar(200) NOT NULL COMMENT 'Name',
  PRIMARY KEY (`scols_id`),
  UNIQUE KEY `scols_name` (`scols_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_slider_cols`
--

INSERT INTO `phs_slider_cols` (`scols_id`, `scols_name`) VALUES
(1, '1'),
(2, '2'),
(3, '3'),
(4, '4'),
(5, '5'),
(6, '6');

-- --------------------------------------------------------

--
-- Table structure for table `phs_slider_type`
--

DROP TABLE IF EXISTS `phs_slider_type`;
CREATE TABLE IF NOT EXISTS `phs_slider_type` (
  `stype_jd` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK ',
  `stype_name` varchar(200) NOT NULL COMMENT 'Name',
  PRIMARY KEY (`stype_jd`),
  UNIQUE KEY `stype_name` (`stype_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_slider_type`
--

INSERT INTO `phs_slider_type` (`stype_jd`, `stype_name`) VALUES
(1, 'Carousel'),
(2, 'OWL');

-- --------------------------------------------------------

--
-- Table structure for table `phs_status`
--

DROP TABLE IF EXISTS `phs_status`;
CREATE TABLE IF NOT EXISTS `phs_status` (
  `status_id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `status_name` varchar(200) NOT NULL COMMENT 'Name',
  PRIMARY KEY (`status_id`),
  UNIQUE KEY `status_name` (`status_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_status`
--

INSERT INTO `phs_status` (`status_id`, `status_name`) VALUES
(1, 'Active'),
(2, 'Not Active');

-- --------------------------------------------------------

--
-- Table structure for table `phs_users`
--

DROP TABLE IF EXISTS `phs_users`;
CREATE TABLE IF NOT EXISTS `phs_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto PK',
  `pgrp_id` int(11) DEFAULT NULL COMMENT 'Permission Group',
  `user_logon` varchar(100) NOT NULL COMMENT 'Logon Name',
  `user_password` varchar(100) NOT NULL COMMENT 'Password',
  `user_email` varchar(100) NOT NULL COMMENT 'Email',
  PRIMARY KEY (`user_id`),
  KEY `pgrp_id` (`pgrp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_users`
--

INSERT INTO `phs_users` (`user_id`, `pgrp_id`, `user_logon`, `user_password`, `user_email`) VALUES
(3, -1, 'haytham', '964dfe818a21e507d424ac718218fbf0', 'h.phsoft@gmail.com'),
(4, -1, 'admin', 'eb0a191797624dd3a48fa681d3061212', 'site_admin@eveadamonline.com');

-- --------------------------------------------------------

--
-- Structure for view `cpy_vartwork`
--
DROP TABLE IF EXISTS `cpy_vartwork`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cpy_vartwork`  AS  select `tt`.`type_id` AS `type_id`,`tt`.`type_order` AS `type_order`,`tt`.`type_name` AS `type_name`,`aa`.`art_id` AS `art_id`,`aa`.`art_year` AS `art_year`,`aa`.`art_title1` AS `art_title1`,`aa`.`art_title2` AS `art_title2`,`aa`.`art_size` AS `art_size`,`aa`.`art_image` AS `art_image` from (`cpy_arttype` `tt` join `cpy_artwork` `aa`) where (`aa`.`type_id` = `tt`.`type_id`) ;

-- --------------------------------------------------------

--
-- Structure for view `cpy_vartwork_subjects`
--
DROP TABLE IF EXISTS `cpy_vartwork_subjects`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cpy_vartwork_subjects`  AS  select `ss`.`subj_id` AS `subj_id`,`ss`.`subj_order` AS `subj_order`,`ss`.`subj_name` AS `subj_name`,`aa`.`type_id` AS `type_id`,`aa`.`type_order` AS `type_order`,`aa`.`type_name` AS `type_name`,`aa`.`art_id` AS `art_id`,`aa`.`art_year` AS `art_year`,`aa`.`art_title1` AS `art_title1`,`aa`.`art_title2` AS `art_title2`,`aa`.`art_size` AS `art_size`,`aa`.`art_image` AS `art_image` from ((`cpy_subject` `ss` join `cpy_artwork_subject` `sa`) join `cpy_vartwork` `aa`) where ((`sa`.`art_id` = `aa`.`art_id`) and (`sa`.`subj_id` = `ss`.`subj_id`)) ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cpy_artwork`
--
ALTER TABLE `cpy_artwork`
  ADD CONSTRAINT `cpy_artwork_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `cpy_arttype` (`type_id`);

--
-- Constraints for table `cpy_artwork_exhibtion`
--
ALTER TABLE `cpy_artwork_exhibtion`
  ADD CONSTRAINT `cpy_artwork_exhibtion_ibfk_1` FOREIGN KEY (`art_id`) REFERENCES `cpy_artwork` (`art_id`),
  ADD CONSTRAINT `cpy_artwork_exhibtion_ibfk_2` FOREIGN KEY (`exhib_id`) REFERENCES `cpy_exhibition` (`exhib_id`);

--
-- Constraints for table `cpy_artwork_subject`
--
ALTER TABLE `cpy_artwork_subject`
  ADD CONSTRAINT `cpy_artwork_subject_ibfk_1` FOREIGN KEY (`art_id`) REFERENCES `cpy_artwork` (`art_id`),
  ADD CONSTRAINT `cpy_artwork_subject_ibfk_2` FOREIGN KEY (`subj_id`) REFERENCES `cpy_subject` (`subj_id`);

--
-- Constraints for table `cpy_exhibition`
--
ALTER TABLE `cpy_exhibition`
  ADD CONSTRAINT `cpy_exhibition_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `cpy_exhibtype` (`type_id`),
  ADD CONSTRAINT `cpy_exhibition_ibfk_2` FOREIGN KEY (`kind_id`) REFERENCES `cpy_exhibkind` (`kind_id`);

--
-- Constraints for table `cpy_exhibition_images`
--
ALTER TABLE `cpy_exhibition_images`
  ADD CONSTRAINT `cpy_exhibition_images_ibfk_1` FOREIGN KEY (`exhib_id`) REFERENCES `cpy_exhibition` (`exhib_id`);

--
-- Constraints for table `cpy_exhibition_video`
--
ALTER TABLE `cpy_exhibition_video`
  ADD CONSTRAINT `cpy_exhibition_video_ibfk_1` FOREIGN KEY (`exhib_id`) REFERENCES `cpy_exhibition` (`exhib_id`),
  ADD CONSTRAINT `cpy_exhibition_video_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `cpy_video` (`video_id`);

--
-- Constraints for table `cpy_page`
--
ALTER TABLE `cpy_page`
  ADD CONSTRAINT `cpy_page_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `phs_status` (`status_id`);

--
-- Constraints for table `cpy_page_images`
--
ALTER TABLE `cpy_page_images`
  ADD CONSTRAINT `cpy_page_images_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `cpy_page` (`page_id`);

--
-- Constraints for table `cpy_publication`
--
ALTER TABLE `cpy_publication`
  ADD CONSTRAINT `cpy_publication_ibfk_1` FOREIGN KEY (`bibl_id`) REFERENCES `cpy_bibliography` (`bibl_id`);

--
-- Constraints for table `cpy_slider_mst`
--
ALTER TABLE `cpy_slider_mst`
  ADD CONSTRAINT `cpy_slider_mst_ibfk_1` FOREIGN KEY (`scols_id`) REFERENCES `phs_slider_cols` (`scols_id`),
  ADD CONSTRAINT `cpy_slider_mst_ibfk_2` FOREIGN KEY (`stype_id`) REFERENCES `phs_slider_type` (`stype_jd`);

--
-- Constraints for table `cpy_slider_trn`
--
ALTER TABLE `cpy_slider_trn`
  ADD CONSTRAINT `cpy_slider_trn_ibfk_1` FOREIGN KEY (`slid_id`) REFERENCES `cpy_slider_mst` (`slid_id`);

--
-- Constraints for table `cpy_subscribe`
--
ALTER TABLE `cpy_subscribe`
  ADD CONSTRAINT `cpy_subscribe_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `phs_status` (`status_id`);

--
-- Constraints for table `phs_menu`
--
ALTER TABLE `phs_menu`
  ADD CONSTRAINT `phs_menu_ibfk_1` FOREIGN KEY (`menu_pid`) REFERENCES `phs_menu` (`menu_id`),
  ADD CONSTRAINT `phs_menu_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `cpy_page` (`page_id`),
  ADD CONSTRAINT `phs_menu_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `phs_status` (`status_id`);

--
-- Constraints for table `phs_perms`
--
ALTER TABLE `phs_perms`
  ADD CONSTRAINT `phs_perms_ibfk_1` FOREIGN KEY (`pgrp_id`) REFERENCES `phs_pgroup` (`pgrp_id`);

--
-- Constraints for table `phs_users`
--
ALTER TABLE `phs_users`
  ADD CONSTRAINT `phs_users_ibfk_1` FOREIGN KEY (`pgrp_id`) REFERENCES `phs_pgroup` (`pgrp_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
