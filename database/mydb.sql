-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2025 at 05:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
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

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Chờ xác nhận',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `code`, `user_id`, `total`, `status`, `created_at`) VALUES
(19, 'DH17601089945312', 8, 23980000.00, 'Thành công', '2025-10-10 22:09:54');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(15,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_name`, `product_price`, `quantity`, `product_id`) VALUES
(3, 19, 'Vợt Yonex 100zz Kurenai', 2600000.00, 4, NULL),
(4, 19, 'Vợt Cầu Lông Yonex Astrox 77 Pro Xanh Limited', 13500000.00, 1, NULL);

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
  `flex` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `category`, `price`, `stock`, `updated_at`, `image`, `productcode`, `weight`, `description`, `length`, `flex`, `color`) VALUES
(1, 'Vợt Cầu Lông Yonex Astrox 77 Pro Xanh Limited', 'Yonex', 13500000.00, 50, '2024-05-11 06:50:00', 'img/product-1.jpg', 'MMB022972', '5U', '- Vợt Cầu Lông Yonex Astrox 77 Pro Xanh China Limited là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '665 mm', 'Siêu cứng', 'Đỏ đen'),
(2, 'Vợt cầu lông Yonex Nanoflare 1000Z', 'Yonex', 4888000.00, 50, '2024-05-11 06:50:00', '../img/product-2.jpg', 'MMB020719', '3U', 'Vợt Cầu Lông Yonex Nanoflare 1000Z với thiết kế nhẹ đầu, mang lại sự nhẹ nhàng và linh hoạt trong mỗi cú đánh. Trọng lượng nhẹ giúp bạn xoay chuyển vợt một cách nhanh chóng và dễ dàng. Đồng thời, điểm cân bằng ở phía đầu vợt giúp những pha đập cầu nhanh và uy lực. Với cây vợt này, bạn có thể đánh bại đối thủ với những pha cầu nhanh như chớp. ', '700 mm', 'Cứng', 'Xanh đen'),
(3, 'Vợt cầu lông Mizuno XYST 07', 'Mizuno', 4050000.00, 50, '2024-05-11 06:50:00', '../img/product-3.jpg', 'MMB022972', '6U', '- Vợt Cầu Lông Vợt cầu lông Mizuno XYST 07 là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '5U', 'Siêu cứng', 'Đỏ đen'),
(4, 'Vợt cầu lông Lining Halbertec 8000', 'Lining', 3500000.00, 50, '2024-05-11 06:50:00', '../img/product-4.jpg', 'MMB022972', '600 mm', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '6U', 'Cứng', 'Đỏ đen'),
(5, 'Vợt cầu lông Lining Aeronaut 7000B', 'Lining', 3390000.00, 50, '2024-05-11 06:50:00', '../img/product-5.jpg', 'MMB022972', '7U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '500 mm', 'Siêu cứng', 'Xanh đen'),
(6, 'Vợt cầu lông Victor Auraspeed 100X TUC/AC', 'Victor', 2300000.00, 50, '2024-05-11 06:50:00', '../img/product-6.jpg', 'MMB022972', '8U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '687 mm', 'Cứng', 'Xanh đen'),
(7, 'Vợt Cầu Lông Lining Axforce 90 Xanh Dragon', 'Lining', 1349000.00, 50, '2024-05-11 06:50:00', '../img/product-7.jpg', 'MMB022972', '7U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '690 mm', 'Cứng', 'Trắng'),
(8, 'Vợt cầu lông Victor Ryuga Metallic 2024', 'Victor', 2650000.00, 50, '2024-05-11 06:50:00', '../img/product-8.jpg', 'MMB022972', '5U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '650 mm', 'Siêu cứng', 'Đỏ đen'),
(9, 'Vợt Yonex 100zz Kurenai', 'Yonex', 2600000.00, 50, '2024-05-11 06:50:00', '../img/product-9.jpg', 'MMB022972', '7U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '700 mm', 'Cứng', 'Đỏ đen');

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
  `city` varchar(50) NOT NULL,
  `address1` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `avatar`, `username`, `fullname`, `email`, `address`, `birthday`, `password`, `numberphone`, `city`, `address1`) VALUES
(2, 'uploads/user2.jpg', 'user01', 'Lê võ gia hưng', 'user01@gmail.com', 'Quận 12', '2000-05-20', '123', '0901234567', 'Hà Nội', '105 Bà Huyện Thanh Quan, Phường Võ Thị Sáu, Quận 3'),
(3, '../img/user2.jpg', 'user02', 'Phùng Thanh Độ', 'user02@gmail.com', 'Quận 1', '2001-05-20', '123', '0901234567', 'Thanh Hoá', '273 Đ. An Dương Vương, Phường 2, Quận 5'),
(4, 'uploads/user2.jpg', 'user03', 'Nguyễn Thanh Tèo', 'user03@gmail.com', 'Quận 5', '2002-05-20', '123', '0901234567', 'Cà Mau', '273 Đ. An Dương Vương, Phường 2, Quận 5'),
(5, 'uploads/user2.jpg', 'user04', 'Đỗ Nam Trung', 'user04@gmail.com', 'Quận 9', '2005-05-20', '123', '0901234567', 'Huế', '105 Bà Huyện Thanh Quan, Phường 6, Quận 3'),
(6, 'uploads/Ảnh chụp màn hình 2025-02-19 201653.png', 'docellphoneS', 'Trần Thái Bình', 'a@gmail.com', 'Quận Tân Bình', '2000-11-11', '123', '0901234567', 'Vũng Tàu', '105 Bà Huyện Thanh Quan, Phường 6, Quận 3'),
(7, 'uploads/user2.jpg', 'user05', 'Lê Văn A', 'ab@gmail.com', 'Quận 10', '2000-11-22', '123', '0901234567', 'Đà Lạt', '105 Bà Huyện Thanh Quan, Phường 6, Quận 3'),
(8, 'uploads/R.jpeg', 'nhan', 'lu nhan', 'luhocnhan@gmail.com', 'tp', '2004-12-09', 'nhan15092004', '0775177636', 'tphcm', 'm');

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
