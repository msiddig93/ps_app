-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2020 at 10:59 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ps_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  `cat_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `cat_name`, `cat_desc`) VALUES
(1, 'New Cat', 'testCategory'),
(4, 'الات زراعية', 'الات زراعية ');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `cust_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `AVATAR` varchar(11) NOT NULL DEFAULT '0.png',
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `cust_name`, `address`, `email`, `phone`, `AVATAR`, `password`) VALUES
(4, 'Ebrahim Abdallah', 'From Khartum - Sudan', 'mohamedali@gmail.com', '0926055492', '1.jpg', '90ce7884170358c7df12d3ab7907d9cb674e6aa5');

-- --------------------------------------------------------

--
-- Table structure for table `emp`
--

CREATE TABLE `emp` (
  `ID` int(11) NOT NULL,
  `FULLNAME` varchar(255) NOT NULL,
  `PHONE` varchar(100) NOT NULL,
  `ADDRSS` varchar(255) NOT NULL,
  `AVATAR` varchar(100) NOT NULL DEFAULT '0.png',
  `TYPE` varchar(50) NOT NULL,
  `LOGIN` varchar(100) NOT NULL,
  `PASS` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emp`
--

INSERT INTO `emp` (`ID`, `FULLNAME`, `PHONE`, `ADDRSS`, `AVATAR`, `TYPE`, `LOGIN`, `PASS`) VALUES
(1, 'Mohamed Siddig', '0993629978', 'أمدرمان - أمبدة الحارة ال16', '1.jpg', 'ADMIN', 'memo22', '601f1889667efaebb33b8c12572835da3f027f78'),
(2, 'أبوبكر  عبدالرحمن أرباب', '0916663777', 'شرق النيل - الحاج يوسف - الردمية', '0.png', 'USER', 'beko11', '601f1889667efaebb33b8c12572835da3f027f78'),
(3, 'Adam Ali', '0993629978', 'أمدرمان - أمبدة الحارة ال16', '0.png', 'ADMIN', 'adam22', '601f1889667efaebb33b8c12572835da3f027f78');

-- --------------------------------------------------------

--
-- Table structure for table `invoics`
--

CREATE TABLE `invoics` (
  `ID` int(11) NOT NULL,
  `BRANSH_ID` int(11) NOT NULL,
  `EMP_ID` int(11) NOT NULL,
  `TOTAL_AMOUNT` double NOT NULL,
  `CREATED_AT` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoics`
--

INSERT INTO `invoics` (`ID`, `BRANSH_ID`, `EMP_ID`, `TOTAL_AMOUNT`, `CREATED_AT`) VALUES
(1, 1, 1, 112.5, '2019-12-04'),
(2, 1, 1, 225, '2019-12-13'),
(3, 1, 1, 75, '2020-04-14'),
(4, 1, 1, 3150, '2020-04-22'),
(5, 1, 1, 75, '2020-04-29'),
(6, 1, 1, 27000, '2020-05-01');

-- --------------------------------------------------------

--
-- Table structure for table `invoic_detials`
--

CREATE TABLE `invoic_detials` (
  `INVO_ID` int(11) NOT NULL,
  `ITEM_ID` int(11) NOT NULL,
  `LAST_PRICE` double NOT NULL,
  `QTE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoic_detials`
--

INSERT INTO `invoic_detials` (`INVO_ID`, `ITEM_ID`, `LAST_PRICE`, `QTE`) VALUES
(1, 1, 112.5, 1),
(2, 1, 112.5, 2),
(3, 1, 75, 1),
(4, 2, 150, 21),
(5, 1, 75, 1),
(6, 2, 150, 180),
(1, 3, 150, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_dec` text NOT NULL,
  `mini_stock` int(11) NOT NULL,
  `product_img` varchar(100) NOT NULL DEFAULT '0.png',
  `category_id` int(11) NOT NULL,
  `purchase_price` double NOT NULL DEFAULT '0',
  `sale_price` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `product_dec`, `mini_stock`, `product_img`, `category_id`, `purchase_price`, `sale_price`) VALUES
(3, 'Product 1', 'بيب', 1, '0.png', 1, 50, 100),
(4, 'Product 2', ';gkjfh fjhf', 100, '4.png', 1, 13, 20);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `id` int(11) NOT NULL,
  `total_price` double DEFAULT NULL,
  `vendor_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`id`, `total_price`, `vendor_id`, `order_date`, `created_by`) VALUES
(1, 8500, 2, '2020-06-13 17:51:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_details`
--

CREATE TABLE `purchase_order_details` (
  `id` int(11) NOT NULL,
  `purchase_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase_order_details`
--

INSERT INTO `purchase_order_details` (`id`, `purchase_order_id`, `product_id`, `price`, `quantity`, `discount`) VALUES
(1, 1, 3, 1000, 4, 0),
(2, 1, 4, 1000, 5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `ID` int(11) NOT NULL,
  `ITEM_ID` int(11) NOT NULL,
  `BRANSH_ID` int(11) NOT NULL,
  `PURECHES_PRICE` float NOT NULL,
  `SALE_PRICE` float NOT NULL,
  `QTE` int(11) NOT NULL,
  `EX_DATE` date NOT NULL,
  `CREATED_AT` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`ID`, `ITEM_ID`, `BRANSH_ID`, `PURECHES_PRICE`, `SALE_PRICE`, `QTE`, `EX_DATE`, `CREATED_AT`) VALUES
(1, 1, 1, 100, 150, 195, '2019-12-26', '2019-12-02'),
(5, 1, 1, 1000, 10, 100, '2020-01-25', '2020-01-22'),
(6, 2, 1, 100, 150, -1, '2021-01-06', '2020-04-14');

-- --------------------------------------------------------

--
-- Table structure for table `stockroom`
--

CREATE TABLE `stockroom` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sale_price` double NOT NULL,
  `purchase_price` double NOT NULL,
  `qte` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(11) NOT NULL,
  `vend_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `AVATAR` varchar(11) NOT NULL DEFAULT '0.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `vend_name`, `address`, `email`, `phone`, `AVATAR`) VALUES
(2, 'Test Vendor', 'test address', 'mohamedsiddig915@gmail.com', '0926055492', '2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp`
--
ALTER TABLE `emp`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `invoics`
--
ALTER TABLE `invoics`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order_details`
--
ALTER TABLE `purchase_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `stockroom`
--
ALTER TABLE `stockroom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `emp`
--
ALTER TABLE `emp`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_order_details`
--
ALTER TABLE `purchase_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stockroom`
--
ALTER TABLE `stockroom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
