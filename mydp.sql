-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2025 at 02:57 PM
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
-- Database: `mydp`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(1, 1, 1, 2, '2025-03-27 08:21:14'),
(8, 2, 2, 2, '2025-03-27 13:21:41'),
(9, 2, 1, 3, '2025-03-27 13:22:46');

-- --------------------------------------------------------

--
-- Table structure for table `myguests`
--

CREATE TABLE `myguests` (
  `id` int(6) UNSIGNED NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `myguests`
--

INSERT INTO `myguests` (`id`, `firstname`, `lastname`, `email`, `reg_date`) VALUES
(1, 'do', 'mexico', 'john@example.com', '2025-03-11 01:38:44'),
(2, 'do', 'mixue', 'john@example.com', '2025-03-11 01:38:33'),
(3, 'do', 'mixue', 'john@example.com', '2025-03-07 13:11:08'),
(4, 'do', 'mixue', 'john@example.com', '2025-03-07 13:11:08'),
(5, 'do', 'mixue', 'john@example.com', '2025-03-08 07:28:46'),
(6, 'do', 'mixue', 'john@example.com', '2025-03-08 07:28:46'),
(7, 'do', 'mixue', 'john@example.com', '2025-03-08 07:28:46'),
(8, 'do', 'mixue', 'john@example.com', '2025-03-08 07:33:48'),
(9, 'John', 'Doe', 'john@example.com', '2025-03-08 07:34:09'),
(10, 'Mary', 'Moe', 'mary@example.com', '2025-03-08 07:34:09'),
(11, 'Julie', 'Dooley', 'julie@example.com', '2025-03-08 07:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `image` varchar(255) NOT NULL,
  `productcode` varchar(50) DEFAULT NULL,
  `weight` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `length` varchar(50) DEFAULT NULL,
  `flex` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `category`, `price`, `stock`, `updated_at`, `image`, `productcode`, `weight`, `description`, `length`, `flex`) VALUES
(1, 'Vợt Cầu Lông Yonex Astrox 77 Pro Xanh Limited', 'Yonex', 13500000.00, 50, '2024-05-11 06:50:00', '../img/product-1.jpg', 'MMB022972', '5U', '- Vợt Cầu Lông Yonex Astrox 77 Pro Xanh China Limited là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '665 mm', 'Siêu cứng'),
(2, 'Vợt cầu lông Yonex Nanoflare 1000Z', 'Yonex', 4888000.00, 50, '2024-05-11 06:50:00', '../img/product-2.jpg', 'MMB020719', '3U', 'Vợt Cầu Lông Yonex Nanoflare 1000Z với thiết kế nhẹ đầu, mang lại sự nhẹ nhàng và linh hoạt trong mỗi cú đánh. Trọng lượng nhẹ giúp bạn xoay chuyển vợt một cách nhanh chóng và dễ dàng. Đồng thời, điểm cân bằng ở phía đầu vợt giúp những pha đập cầu nhanh và uy lực. Với cây vợt này, bạn có thể đánh bại đối thủ với những pha cầu nhanh như chớp. ', '700 mm', 'Cứng'),
(3, 'Vợt cầu lông Mizuno XYST 07', 'Mizuno', 4050000.00, 50, '2024-05-11 06:50:00', '../img/product-3.jpg', 'MMB022972', '6U', '- Vợt Cầu Lông Vợt cầu lông Mizuno XYST 07 là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '5U', 'Siêu cứng'),
(4, 'Vợt cầu lông Lining Halbertec 8000', 'Lining', 3500000.00, 50, '2024-05-11 06:50:00', '../img/product-4.jpg', 'MMB022972', '600 mm', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '6U', 'Cứng'),
(5, 'Vợt cầu lông Lining Aeronaut 7000B', 'Lining', 3390000.00, 50, '2024-05-11 06:50:00', '../img/product-5.jpg', 'MMB022972', '7U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '500 mm', 'Siêu cứng'),
(6, 'Vợt cầu lông Victor Auraspeed 100X TUC/AC', 'Victor', 2300000.00, 50, '2024-05-11 06:50:00', '../img/product-6.jpg', 'MMB022972', '8U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '687 mm', 'Cứng'),
(7, 'Vợt Cầu Lông Lining Axforce 90 Xanh Dragon', 'Lining', 1349000.00, 50, '2024-05-11 06:50:00', '../img/product-7.jpg', 'MMB022972', '7U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '690 mm', 'Cứng'),
(8, 'Vợt cầu lông Victor Ryuga Metallic 2024', 'Victor', 2650000.00, 50, '2024-05-11 06:50:00', '../img/product-8.jpg', 'MMB022972', '5U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '650 mm', 'Siêu cứng'),
(9, 'Vợt Yonex 100zz Kurenai', 'Yonex', 2600000.00, 50, '2024-05-11 06:50:00', '../img/product-9.jpg', 'MMB022972', '7U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '700 mm', 'Cứng');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `flex` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `flex`) VALUES
(1, 'Vợt Cầu Lông Yonex Astrox 77 Pro Xanh Limited', 13500000.00, '../img/product-1.jpg', NULL),
(2, 'Vợt cầu lông Yonex Nanoflare 1000Z', 4888000.00, '../img/product-2.jpg', NULL),
(3, 'Vợt cầu lông Mizuno XYST 07', 4050000.00, '../img/product-3.jpg', NULL),
(4, 'Vợt cầu lông Lining Halbertec 8000', 3500000.00, '../img/product-4.jpg', NULL),
(5, 'Vợt cầu lông Lining Aeronaut 7000B', 3390000.00, '../img/product-5.jpg', NULL),
(6, 'Vợt cầu lông Victor Auraspeed 100X TUC/AC', 2300000.00, '../img/product-6.jpg', NULL),
(7, 'Vợt Cầu Lông Lining Axforce 90 Xanh Dragon', 1349000.00, '../img/product-7.jpg', NULL),
(8, 'Vợt cầu lông Victor Ryuga Metallic 2024', 2650000.00, '../img/product-8.jpg', NULL),
(9, 'Vợt Yonex 100zz Kurenai', 2600000.00, '../img/product-9.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `avatar` varchar(255) DEFAULT 'default.jpg',
  `username` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `numberphone` varchar(15) DEFAULT NULL,
  `city` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `avatar`, `username`, `fullname`, `email`, `address`, `birthday`, `password`, `numberphone`, `city`) VALUES
(1, 'uploads/IMG_6247.jpg', 'adminn', 'Nguyễn Văn A', 'admin@example.com', 'Thanh Hóa', '3636-03-31', '123', '0901234568', 'TPHCM'),
(2, '../img/user.jpg', 'domixue', 'Trần Thị B', 'user01@gmail.com', 'TP.HCM', '2000-05-20', '123', '0901234567', 'Ha Noi'),
(3, '../img/user2.jpg', 'dokatinat', 'do mi c', 'user02@gmail.com', 'TP.HCM', '2001-05-20', '123', '0901234567', 'Thanh Hoa'),
(4, 'uploads/FB_IMG_1729079301405.jpg', 'dohighlands', 'Trần Thị D', 'user03@gmail.com', 'TP.HCM', '2002-05-20', '123', '0901234567', 'Ca Mau'),
(5, '../img/user4.jpg', 'dostarbucks', 'Trần Thị E', 'user04@gmail.com', 'TP.HCM', '2005-05-20', '123', '0901234567', 'Hue'),
(6, 'uploads/Ảnh chụp màn hình 2025-02-19 201653.png', 'docellphoneS', 'le van a', 'a@gmail.com', 'tphcm', '2000-11-11', '123', '0901234567', 'Vung Tau'),
(7, 'uploads/img.webp', 'doCircleK', 'nguyen van a', 'ab@gmail.com', 'ha noi', '2000-11-22', '123', '0901234567', 'Da Lat'),
(8, 'uploads/IMG_6247.jpg', 'doGS25', 'nguyen van d', 'aan2@gmail.com', 'ha noi', '2000-11-22', '123', '0901234567', 'Nam Dinh'),
(9, 'uploads/IMG_6247.jpg', 'daumini', 'phung thanh tu', 'aa@gmail.com', 'tp hcm', '2000-11-22', '123', '0901234567', 'Cao Bang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `myguests`
--
ALTER TABLE `myguests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `myguests`
--
ALTER TABLE `myguests`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
