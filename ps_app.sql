-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 11, 2021 at 08:45 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
(4, 'Ebrahim Abdallah', 'From Khartum - Sudan', 'mohamedali@gmail.com', '0926055492', '1.jpg', '90ce7884170358c7df12d3ab7907d9cb674e6aa5'),
(6, 'Ebrahim Abdallah', 'mxmc', 'support@tecmanic.com', '0926055492', '6.jpeg', '5bdcd3c0d4d24ae3e71b3b452a024c6324c7e4bb');

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
(1, 'Mohamed Siddig', '0993629978', 'أمدرمان - أمبدة الحارة ال16', '1.jpg', 'ADMIN', 'memo22', 'c129b324aee662b04eccf68babba85851346dff9'),
(2, 'أبوبكر  عبدالرحمن أرباب', '0916663777', 'شرق النيل - الحاج يوسف - الردمية', '0.png', 'USER', 'beko11', '601f1889667efaebb33b8c12572835da3f027f78'),
(3, 'Adam Ali', '0993629978', 'أمدرمان - أمبدة الحارة ال16', '0.png', 'ADMIN', 'adam22', '601f1889667efaebb33b8c12572835da3f027f78');

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
  `purchase_price` double NOT NULL DEFAULT 0,
  `sale_price` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `product_dec`, `mini_stock`, `product_img`, `category_id`, `purchase_price`, `sale_price`) VALUES
(3, 'Product 1', 'بيب', 1, '0.png', 1, 50, 100),
(4, 'Product 2', ';gkjfh fjhf', 100, '4.png', 1, 13, 20),
(10, 'منتج جديد', 'jks', 100, '10.jpeg', 1, 100, 110);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `id` int(11) NOT NULL,
  `total_price` double DEFAULT NULL,
  `vendor_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`id`, `total_price`, `vendor_id`, `order_date`, `created_by`) VALUES
(1, 8500, 2, '2020-06-13 17:51:13', 1),
(3, 12, 1, '2021-01-10 22:37:45', 1),
(4, 24, 2, '2021-01-10 21:01:45', 1);

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
(2, 1, 4, 1000, 5, 10),
(5, 4, 3, 12, 1, 0),
(6, 4, 4, 12, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sale_order`
--

CREATE TABLE `sale_order` (
  `id` int(11) NOT NULL,
  `total_price` double DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sale_order`
--

INSERT INTO `sale_order` (`id`, `total_price`, `customer_id`, `order_date`, `created_by`) VALUES
(1, 11.4, 4, '2021-01-10 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sale_order_details`
--

CREATE TABLE `sale_order_details` (
  `id` int(11) NOT NULL,
  `sale_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sale_order_details`
--

INSERT INTO `sale_order_details` (`id`, `sale_order_id`, `product_id`, `price`, `quantity`, `discount`) VALUES
(1, 1, 4, 12, 1, 5);

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
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stockroom`
--

INSERT INTO `stockroom` (`id`, `product_id`, `sale_price`, `purchase_price`, `qte`, `created_at`) VALUES
(1, 4, 12, 12, 1, '2021-01-10 21:01:45'),
(2, 4, 12, 12, 1, '2021-01-10 22:01:06');

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
(2, 'Test Vendor', 'test address', 'mohamedsiddig915@gmail.com', '0926055492', '2.jpeg');

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
-- Indexes for table `sale_order`
--
ALTER TABLE `sale_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_order_details`
--
ALTER TABLE `sale_order_details`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `emp`
--
ALTER TABLE `emp`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchase_order_details`
--
ALTER TABLE `purchase_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sale_order`
--
ALTER TABLE `sale_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sale_order_details`
--
ALTER TABLE `sale_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stockroom`
--
ALTER TABLE `stockroom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;