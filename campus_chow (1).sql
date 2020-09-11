-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 25, 2019 at 12:56 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `campus_chow`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `delivered` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `items`, `expire_date`, `paid`, `delivered`) VALUES
(1, '[{\"id\":\"27\",\"quantity\":\"3\"},{\"id\":\"21\",\"quantity\":\"1\"},{\"id\":\"20\",\"quantity\":\"2\"}]', '2019-12-25 10:45:39', 1, 1),
(2, '[{\"id\":\"27\",\"quantity\":\"1\"},{\"id\":\"24\",\"quantity\":\"5\"},{\"id\":\"21\",\"quantity\":\"2\"},{\"id\":\"20\",\"quantity\":\"3\"}]', '2019-12-25 12:53:09', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mails`
--

CREATE TABLE `mails` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `dated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mails`
--

INSERT INTO `mails` (`id`, `email`, `phone`, `full_name`, `message`, `dated`) VALUES
(2, 'humar6078@gmail.com', '0557566646', 'Gadget Ghana', 'Qui autem consequatur. Illo doloribus et sed quia corrupti amet non. Asperiores inventore est nisi omnis illum voluptas porro minus.', '2019-11-24 19:37:26');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `items` longtext,
  `expire_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rest_admins`
--

CREATE TABLE `rest_admins` (
  `id` int(11) NOT NULL,
  `full_name` varchar(400) DEFAULT NULL,
  `email` varchar(400) DEFAULT NULL,
  `phone_number` varchar(400) DEFAULT NULL,
  `restaurant_name` varchar(400) DEFAULT NULL,
  `restaurant_address` varchar(400) DEFAULT NULL,
  `password` varchar(400) NOT NULL,
  `permission` tinyint(4) NOT NULL DEFAULT '0',
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rest_admins`
--

INSERT INTO `rest_admins` (`id`, `full_name`, `email`, `phone_number`, `restaurant_name`, `restaurant_address`, `password`, `permission`, `image`) VALUES
(1, 'Alagskomah', 'alagskomahdennis@gmail.com', '0242099012', 'Kapochino', 'Ayensu road Apt 40', '9fb98e0c9e75fede26a9e8d2b6882dd0cf87bc77', 0, 'managers/assets/img/managers/center.png'),
(3, 'hamza Umar', 'humar6078@gmail.com', 'hamza', 'hamza', 'safvhausd', '9fb98e0c9e75fede26a9e8d2b6882dd0cf87bc77', 1, 'managers/assets/img/managers/68b54879038ded56578334006c8cca37.png'),
(9, 'Gadget Ghana', 'weedseed@gmail.com', '0557566646', 'Vanis catries', 'Koforidua', '9fb98e0c9e75fede26a9e8d2b6882dd0cf87bc77', 0, 'managers/assets/img/managers/6f7ddcaa153946826de91e1d207f39a4.png'),
(10, 'gambo', 'hamza@gmail.com', '0557555646', 'Vanis catries pastris', 'kasoa kakraba market', '9fb98e0c9e75fede26a9e8d2b6882dd0cf87bc77', 0, 'managers/assets/img/managers/11a15b22a8cab65e6069daf61f64ba46.png');

-- --------------------------------------------------------

--
-- Table structure for table `rest_foods`
--

CREATE TABLE `rest_foods` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `pictures` text,
  `restaurant_id` int(11) DEFAULT NULL,
  `restaurant_name` varchar(400) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rest_foods`
--

INSERT INTO `rest_foods` (`id`, `name`, `pictures`, `restaurant_id`, `restaurant_name`, `price`) VALUES
(20, 'fried yam chibs', 'assets/img/foods/8a0ac5d7d29f9aae396ea36592eaeb44.png', 1, 'Kapochino', '15.00'),
(21, 'fried Rice and Chicken', 'assets/img/foods/e27aeeb6ba4c5dfd90f478b8bae54e40.png,assets/img/foods/d6f79db9e54fb3648716606a1d850520.png', 1, 'Kapochino', '555.00'),
(22, 'Beans and friend plantain', 'assets/img/foods/8ee3b3e1e81076aade8ee25f8f35a7a1.jpg', 1, 'Kapochino', '5.00'),
(23, 'Ga kenkey with fried tilapia', 'assets/img/foods/2f7f7427301a4cdf50b52dd0f6651b94.png', 1, 'Kapochino', '15.00'),
(24, 'fried yam chibs and chicken', 'assets/img/foods/0f3be9033ff350a586008d575ffe50b5.png,assets/img/foods/051ee49de755b6ea5d84f45a04025f3d.png', 5, 'weedseed', '30.00'),
(25, 'Ice Kenkay with ground nut', 'assets/img/foods/17403d1a4aa548b0f4a319811899b93b.png', 5, 'weedseed', '15.00'),
(26, 'Tou zafi With cow towel', 'assets/img/foods/e1f6f19db5bbfa90c516182feda89fff.png,assets/img/foods/cd706300840dd9b5046f5e581d773ca0.png', 9, 'Vanis catries', '6.00'),
(27, 'fried yam chibs and Plantain', 'assets/img/foods/8c8d4f0b225ed8f673daa64e96170d5b.png,assets/img/foods/016821fb50af331dbbcde00c40f9e551.png,assets/img/foods/74c5f126dd4010da1b55617fe56d321a.png', 10, 'Vanis catries pastris', '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `send`
--

CREATE TABLE `send` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rest_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `seen` tinyint(4) NOT NULL DEFAULT '0',
  `done` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `send`
--

INSERT INTO `send` (`id`, `product_id`, `rest_id`, `cart_id`, `seen`, `done`) VALUES
(1, 27, 10, 1, 1, 1),
(2, 21, 1, 1, 1, 1),
(3, 20, 1, 1, 1, 1),
(4, 27, 10, 2, 1, 0),
(5, 24, 5, 2, 1, 0),
(6, 21, 1, 2, 1, 0),
(7, 20, 1, 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `full_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `phone` int(10) NOT NULL,
  `hostel` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `txn_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `delivered_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `cart_id`, `full_name`, `email`, `phone`, `hostel`, `description`, `grand_total`, `txn_date`, `delivered_date`, `status`) VALUES
(1, 1, 'gambo', 'shopgambo@gmail.com', 557555646, 'Khent - Ayensu', '6 items', '615.00', '2019-11-25 11:37:04', '2019-11-25 12:37:04', 1),
(2, 2, 'Gadget Ghana', 'humar6078@gmail.com', 557566646, 'hamza - hamzaa', '11 items', '1315.00', '2019-11-25 11:54:03', '0000-00-00 00:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rest_admins`
--
ALTER TABLE `rest_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rest_foods`
--
ALTER TABLE `rest_foods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `send`
--
ALTER TABLE `send`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mails`
--
ALTER TABLE `mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rest_admins`
--
ALTER TABLE `rest_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rest_foods`
--
ALTER TABLE `rest_foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `send`
--
ALTER TABLE `send`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
