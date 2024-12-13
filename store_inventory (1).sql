-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2024 at 09:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `status`, `total_amount`) VALUES
(1, 1, '2024-12-10 14:30:00', 'Pending', 150.00),
(2, 1, '2024-12-11 10:20:00', 'Shipped', 300.00),
(3, 2, '2024-12-12 09:15:00', 'Delivered', 200.00),
(4, 1, '0000-00-00 00:00:00', 'Pending', 0.00),
(5, 1, '0000-00-00 00:00:00', 'Pending', 0.00),
(6, 1, '0000-00-00 00:00:00', 'Pending', 168.50),
(7, 1, '0000-00-00 00:00:00', 'Pending', 8724.00),
(8, 1, '0000-00-00 00:00:00', 'Pending', 4972.00),
(9, 1, '0000-00-00 00:00:00', 'Pending', 789.00),
(10, 1, '0000-00-00 00:00:00', 'Pending', 7101.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 6, 2, 3, 20.00),
(2, 6, 3, 7, 15.50),
(3, 7, 1, 5, 999.00),
(4, 7, 4, 3, 458.00),
(5, 7, 7, 3, 785.00),
(6, 8, 1, 2, 999.00),
(7, 8, 2, 1, 754.00),
(8, 8, 8, 2, 1110.00),
(9, 9, 12, 1, 789.00),
(10, 10, 12, 9, 789.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image_url`) VALUES
(1, 'Cloud Walkers', 999.00, 'images/r1.jpg'),
(2, 'City Slickers', 754.00, 'images/r2.jpg'),
(3, 'Trail Blazers', 689.00, 'images/r3.jpg'),
(4, 'Zen Masters', 458.00, 'images/r4.jpg'),
(5, 'Pixel Perfect', 577.00, 'images/r5.jpg'),
(6, 'Sound Seekers', 689.00, 'images/r6.jpg'),
(7, 'Blush Cascade', 785.00, 'images/w1.jpg'),
(8, 'Velvet Sprint', 1110.00, 'images/w2.jpg'),
(9, 'Pastel Horizon', 989.00, 'images/w3.jpg'),
(10, 'Lunar Drift', 1352.00, 'images/w4.jpg'),
(11, 'Ivory Crest', 1902.00, 'images/w5.jpg'),
(12, 'Dawn Pulse', 789.00, 'images/w6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `phone`, `address`, `role`, `created_at`) VALUES
(2, 'Jane', 'Smith', 'jane.smith@example.com', 'hashed_password_here', '0987654321', '456 Elm St, City, Country', 'admin', '2024-12-12 15:06:10'),
(6, 'John', 'Doe', 'john.doe@example.com', '$2y$10$5Im.7F5qJl5SHz18.KjvduSGlVklNmgfdLl9Ia1hEjL9A5zVUtj66', '1234567890', '123 Main St', 'customer', '2024-12-12 15:38:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
