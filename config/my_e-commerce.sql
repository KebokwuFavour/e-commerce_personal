-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2023 at 06:07 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_e-commerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_users`
--

CREATE TABLE `active_users` (
  `track_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `session_id` varchar(500) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `active_users`
--

INSERT INTO `active_users` (`track_id`, `user_id`, `username`, `email`, `session_id`, `datetime`) VALUES
(67, 9, 'ssss', 'Kebokwufavour@gmail.com', 'aocgrqqqon3p87cjf03eb6883a', '2023-10-01 19:11:25'),
(68, 9, 'ssss', 'Kebokwufavour@gmail.com', 'aocgrqqqon3p87cjf03eb6883a', '2023-10-01 19:25:33'),
(69, 11, 'user1', 'Kebokwufavour2@gmail.com', 'aocgrqqqon3p87cjf03eb6883a', '2023-10-06 10:05:04'),
(70, 11, 'user1', 'Kebokwufavour2@gmail.com', 'aocgrqqqon3p87cjf03eb6883a', '2023-10-06 10:08:13');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(300) NOT NULL,
  `alt_name` varchar(200) NOT NULL,
  `prod_price` varchar(300) NOT NULL,
  `prod_discount_price` varchar(300) NOT NULL,
  `prod_quantity` int(250) DEFAULT NULL,
  `prod_image` varchar(300) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_sold_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_id`, `prod_name`, `alt_name`, `prod_price`, `prod_discount_price`, `prod_quantity`, `prod_image`, `date_added`, `date_sold_out`) VALUES
(1, 'Fancy Product', 'discount', '80.00', '40.00', 7, 'product-1.jpg', '2023-09-20 08:02:57', NULL),
(2, 'Special Item', 'foreign', '20.00', '18.00', NULL, 'product-2.jpg', '2023-09-20 08:02:54', NULL),
(3, 'Sale Item', 'local', '50.00', '25.00', 12, 'product-3.jpg', '2023-09-20 08:02:50', NULL),
(4, 'Popular Item', '', '40.00', '', 5, 'product-4.jpg', '2023-09-20 08:02:26', NULL),
(5, 'Sale Item', '', '50.00', '', 10, 'product-5.jpg', '2023-09-20 08:02:29', NULL),
(6, 'Fancy Product', '', '120.00', '', 4, 'product-6.jpg', '2023-09-20 08:02:35', NULL),
(7, 'Special Item', '', '20.00', '', 0, 'product-7.jpg', '2023-09-20 08:02:39', NULL),
(8, 'Popular Item', 'promo', '40.00', '30.00', 3, 'product-8.jpg', '2023-09-20 08:02:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(800) NOT NULL,
  `signup_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `username`, `password`, `signup_date`) VALUES
(9, 'Favour', 'Kebokwufavour@gmail.com', 'ssss', '$2y$10$AX.XbE6P5Q18FF//IQ0nBux9a174kHut92wYPMe/cS4Jw5ZU/JbrG', '2023-09-16 12:46:11'),
(11, 'Kebokwu Favour', 'Kebokwufavour2@gmail.com', 'user1', '$2y$10$RPSh9tlJLgycGIhIcD9Ha.mLysrtW.q4uMRoMDcVeb2LMoJRKDsLK', '2023-10-06 10:04:49');

-- --------------------------------------------------------

--
-- Table structure for table `user_carts`
--

CREATE TABLE `user_carts` (
  `cart_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(300) NOT NULL,
  `price` varchar(300) NOT NULL,
  `prod_quantity` int(250) NOT NULL,
  `total_price` varchar(300) NOT NULL,
  `prod_alt_name` varchar(300) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_carts`
--

INSERT INTO `user_carts` (`cart_id`, `prod_id`, `prod_name`, `price`, `prod_quantity`, `total_price`, `prod_alt_name`, `user_id`) VALUES
(42, 8, 'Popular Item', '30.00', 2, '60', 'promo', 9),
(47, 5, 'Sale Item', '50.00', 1, '50', '', 9),
(51, 3, 'Sale Item', '25.00', 1, '25', 'local', 11),
(52, 5, 'Sale Item', '50.00', 1, '50', '', 11);

-- --------------------------------------------------------

--
-- Table structure for table `user_transaction_details`
--

CREATE TABLE `user_transaction_details` (
  `track_id` int(11) NOT NULL,
  `u_user_id` int(11) NOT NULL,
  `u_name` varchar(250) NOT NULL,
  `u_user_email` varchar(250) NOT NULL,
  `total_amt` varchar(250) NOT NULL,
  `reference_id` varchar(250) NOT NULL,
  `invoice_id` varchar(250) NOT NULL,
  `u_ip_address` varchar(250) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_transaction_details`
--

INSERT INTO `user_transaction_details` (`track_id`, `u_user_id`, `u_name`, `u_user_email`, `total_amt`, `reference_id`, `invoice_id`, `u_ip_address`, `datetime`) VALUES
(1, 9, 'Favour', 'Kebokwufavour@gmail.com', '50000', '1696415956nBAvV4', '1696416205686202', '::1', '2023-10-04 10:43:25'),
(2, 9, 'Favour', 'Kebokwufavour@gmail.com', '500.00', '1696440737KyLmva', '1696440762432642', '::1', '2023-10-04 17:32:42'),
(3, 9, 'Favour', 'Kebokwufavour@gmail.com', '500.00', '1696452571sk8V69', '1696452674104106', '::1', '2023-10-04 20:51:14'),
(4, 9, 'Favour', 'Kebokwufavour@gmail.com', '500.00', '1696452816npUYgr', '1696452845265340', '::1', '2023-10-04 20:54:05'),
(5, 9, 'Favour', 'Kebokwufavour@gmail.com', '500.00', '1696452903CcAkV6', '1696453072113115', '::1', '2023-10-04 20:57:52'),
(6, 9, 'Favour', 'Kebokwufavour@gmail.com', '500.00', '169645317015ICG2', '1696453217518371', '::1', '2023-10-04 21:00:17'),
(7, 9, 'Favour', 'Kebokwufavour@gmail.com', '500.00', '1696453679Nz3dEh', '1696453767380347', '::1', '2023-10-04 21:09:27'),
(8, 9, 'Favour', 'Kebokwufavour@gmail.com', '450.00', '1696454142AVqYkt', '1696454190539746', '::1', '2023-10-04 21:16:30'),
(9, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '1696454309QXm36c', '1696454369620053', '::1', '2023-10-04 21:19:29'),
(10, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '1696455214qLDllo', '1696455306519184', '::1', '2023-10-04 21:35:06'),
(11, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '1696456015bmi8mw', '1696456060200545', '::1', '2023-10-04 21:47:40'),
(12, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '1696456534mcHekb', '1696456637581620', '::1', '2023-10-04 21:57:17'),
(13, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '1696456736vTCJRx', '1696456785546136', '::1', '2023-10-04 21:59:45'),
(14, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '16964569408lR4wm', '1696457029196452', '::1', '2023-10-04 22:03:49'),
(15, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '1696457072g2BOT9', '1696457105663294', '::1', '2023-10-04 22:05:05'),
(16, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '1696481070HWYygG', '1696481107055726', '::1', '2023-10-05 04:45:07'),
(17, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '16964812175qZlun', '1696481254635404', '::1', '2023-10-05 04:47:34'),
(18, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '1696481314p8HVW9', '1696481335354101', '::1', '2023-10-05 04:48:55'),
(19, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '1696482855BqmWsi', '1696482881759805', '::1', '2023-10-05 05:14:41'),
(20, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '1696483063CStmWz', '1696483088878392', '::1', '2023-10-05 05:18:08'),
(21, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '1696483342G1JtNv', '1696483378814362', '::1', '2023-10-05 05:22:58'),
(22, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '1696484890UEBhQm', '1696484918453344', '::1', '2023-10-05 05:48:38'),
(23, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '16964850405UxlhK', '1696485066254203', '::1', '2023-10-05 05:51:06'),
(24, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '1696485196zzPJSl', '1696485220742778', '::1', '2023-10-05 05:53:40'),
(25, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '169648528899Bxjw', '1696485306063636', '::1', '2023-10-05 05:55:06'),
(26, 9, 'Favour', 'Kebokwufavour@gmail.com', '480.00', '1696509471sAUMgj', '1696509507503202', '::1', '2023-10-05 12:38:27'),
(27, 9, 'Favour', 'Kebokwufavour@gmail.com', '80.00', '1696515194Csp1Qv', '1696530429982482', '::1', '2023-10-05 18:27:09'),
(28, 9, 'Favour', 'Kebokwufavour@gmail.com', '98.00', '1696531582F0aJba', '1696531614097526', '::1', '2023-10-05 18:46:54'),
(29, 9, 'Favour', 'Kebokwufavour@gmail.com', '146.00', '1696571852aDRT4s', '1696571886488689', '::1', '2023-10-06 05:58:06'),
(30, 9, 'Favour', 'Kebokwufavour@gmail.com', '146.00', '1696574385mQnOmd', '1696574412497101', '::1', '2023-10-06 06:40:12'),
(31, 9, 'Favour', 'Kebokwufavour@gmail.com', '110.00', '16965747915MbxGE', '1696574827683198', '::1', '2023-10-06 06:47:07');

-- --------------------------------------------------------

--
-- Table structure for table `user_transaction_details_products`
--

CREATE TABLE `user_transaction_details_products` (
  `track_id` int(11) NOT NULL,
  `u_user_id` int(11) NOT NULL,
  `u_user_email` varchar(250) NOT NULL,
  `u_name` varchar(250) NOT NULL,
  `u_purchased_prods` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `u_p_prods_quantity` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `u_p_prods_id` int(11) NOT NULL,
  `invoice_id` varchar(250) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_transaction_details_products`
--

INSERT INTO `user_transaction_details_products` (`track_id`, `u_user_id`, `u_user_email`, `u_name`, `u_purchased_prods`, `price`, `u_p_prods_quantity`, `total_price`, `u_p_prods_id`, `invoice_id`, `datetime`) VALUES
(1, 9, 'Kebokwufavour@gmail.com', 'Favour', 'Popular Item', 30, 6, 180, 8, '1696509507503202', '2023-10-05 12:38:27'),
(2, 9, 'Kebokwufavour@gmail.com', 'Favour', 'Sale Item', 50, 6, 300, 5, '1696509507503202', '2023-10-05 12:38:27'),
(3, 9, 'Kebokwufavour@gmail.com', 'Favour', 'Popular Item', 30, 1, 30, 8, '1696530429982482', '2023-10-05 18:27:09'),
(4, 9, 'Kebokwufavour@gmail.com', 'Favour', 'Sale Item', 50, 1, 50, 5, '1696530429982482', '2023-10-05 18:27:09'),
(5, 9, 'Kebokwufavour@gmail.com', 'Favour', 'Popular Item', 30, 1, 30, 8, '1696531614097526', '2023-10-05 18:46:54'),
(6, 9, 'Kebokwufavour@gmail.com', 'Favour', 'Sale Item', 50, 1, 50, 5, '1696531614097526', '2023-10-05 18:46:54'),
(7, 9, 'Kebokwufavour@gmail.com', 'Favour', 'Special Item', 18, 1, 18, 2, '1696531614097526', '2023-10-05 18:46:54'),
(8, 9, 'Kebokwufavour@gmail.com', 'Favour', 'Popular Item', 30, 2, 60, 8, '1696571886488689', '2023-10-06 05:58:06'),
(9, 9, 'Kebokwufavour@gmail.com', 'Favour', 'Sale Item', 50, 1, 50, 5, '1696571886488689', '2023-10-06 05:58:06'),
(10, 9, 'Kebokwufavour@gmail.com', 'Favour', 'Special Item', 18, 2, 36, 2, '1696571886488689', '2023-10-06 05:58:06'),
(11, 9, 'Kebokwufavour@gmail.com', 'Favour', 'Popular Item', 30, 2, 60, 8, '1696574412497101', '2023-10-06 06:40:12'),
(12, 9, 'Kebokwufavour@gmail.com', 'Favour', 'Sale Item', 50, 1, 50, 5, '1696574412497101', '2023-10-06 06:40:12'),
(13, 9, 'Kebokwufavour@gmail.com', 'Favour', 'Special Item', 18, 2, 36, 2, '1696574412497101', '2023-10-06 06:40:12'),
(14, 9, 'Kebokwufavour@gmail.com', 'Favour', 'Popular Item', 30, 2, 60, 8, '1696574827683198', '2023-10-06 06:47:07'),
(15, 9, 'Kebokwufavour@gmail.com', 'Favour', 'Sale Item', 50, 1, 50, 5, '1696574827683198', '2023-10-06 06:47:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_users`
--
ALTER TABLE `active_users`
  ADD PRIMARY KEY (`track_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_carts`
--
ALTER TABLE `user_carts`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `user_transaction_details`
--
ALTER TABLE `user_transaction_details`
  ADD PRIMARY KEY (`track_id`);

--
-- Indexes for table `user_transaction_details_products`
--
ALTER TABLE `user_transaction_details_products`
  ADD PRIMARY KEY (`track_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_users`
--
ALTER TABLE `active_users`
  MODIFY `track_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_carts`
--
ALTER TABLE `user_carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user_transaction_details`
--
ALTER TABLE `user_transaction_details`
  MODIFY `track_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_transaction_details_products`
--
ALTER TABLE `user_transaction_details_products`
  MODIFY `track_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
