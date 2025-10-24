-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2025 at 04:43 AM
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
-- Table structure for table `chitietphieunhap`
--

CREATE TABLE `chitietphieunhap` (
  `MaCTPN` int(11) NOT NULL,
  `MaPN` int(11) DEFAULT NULL,
  `TenSP` varchar(100) DEFAULT NULL,
  `LoaiSP` varchar(50) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT NULL,
  `DonGia` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chitietphieunhap`
--

INSERT INTO `chitietphieunhap` (`MaCTPN`, `MaPN`, `TenSP`, `LoaiSP`, `SoLuong`, `DonGia`) VALUES
(1, 1, 'Vợt Cầu Lông Yonex Astrox 77 Pro Xanh Limited', 'Yonex', NULL, 13500000.00),
(2, 2, 'Vợt Cầu Lông Yonex Astrox 77 Pro Xanh Limited', 'Yonex', NULL, 13500000.00),
(3, 3, 'Vợt Cầu Lông Lining Axforce 90 Xanh Dragon', 'Lining', NULL, 1349000.00),
(4, 4, 'Vợt Cầu Lông Yonex Astrox 77 Pro Xanh Limited', 'Yonex', 1, 1350000000.00),
(5, 5, 'Vợt cầu lông Mizuno XYST 07', 'Mizuno', 1, 324000000.00),
(6, 6, 'Vợt cầu lông Mizuno XYST 07', 'Mizuno', 1, 320000900.00);

-- --------------------------------------------------------

--
-- Table structure for table `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `numberphone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `diaChi` varchar(255) DEFAULT NULL,
  `NgayHopTac` date DEFAULT NULL,
  `TrangThai` tinyint(4) DEFAULT 1,
  `NguoiDaiDien` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhacungcap`
--

INSERT INTO `nhacungcap` (`id`, `fullname`, `avatar`, `numberphone`, `email`, `diaChi`, `NgayHopTac`, `TrangThai`, `NguoiDaiDien`) VALUES
(1, 'Yonex Việt Nam', 'uploads/ncc5.png', '0905123456', 'contact@yonexvn.com', '123 Lý Thường Kiệt, Hà Nội', '2023-05-10', 1, 'Ronaldo'),
(2, 'Lining Sport', 'uploads/ncc2.png', '0987123456', 'support@lining.vn', '88 Nguyễn Huệ, Hồ Chí Minh', '2022-03-15', 1, 'Elon Musk'),
(3, 'Victor Corporation', 'uploads/ncc3.png', '0932456789', 'sales@victor.com.vn', '56 Nguyễn Văn Cừ, Đà Nẵng', '2021-11-20', 1, 'Bill Gates'),
(4, 'Fleet Badminton', 'uploads/ncc4.png', '0912345678', 'info@fleet.vn', '25 Trần Phú, Hải Phòng', '2024-01-05', 1, 'Lionel Messi'),
(5, 'Mizuno ', 'uploads/ncc1.png', '0978123987', 'mizuno.imports@gmail.com', '9 Pasteur, Hồ Chí Minh', '2023-09-01', 1, 'Lưu Đức Long');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `id` int(11) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `daywork` date DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `numberphone` varchar(15) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`id`, `avatar`, `username`, `fullname`, `email`, `daywork`, `birthday`, `password`, `numberphone`, `status`) VALUES
(1, 'uploads/user9.jpg', 'nv01', 'Nguyễn Văn An', 'an.nguyen@example.com', '2022-05-10', '1998-03-12', '123', '0905123456', '1'),
(2, 'uploads/user6.jpg', 'nv02', 'Trần Thị Bình', 'binh.tran@example.com', '2023-02-20', '1997-09-25', '123', '0912345678', '1'),
(3, 'uploads/user10.jpg', 'nv04', 'Lê Quốc Dũng', 'dung.le@example.com', '2024-01-15', '1995-06-09', '123', '0987123456', '1');

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
(19, 'DH17601089945312', 8, 23980000.00, 'Thành công', '2025-10-10 22:09:54'),
(20, 'DH17610188909624', 2, 5280000.00, 'Thành công', '2025-10-21 10:54:50');

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
(4, 19, 'Vợt Cầu Lông Yonex Astrox 77 Pro Xanh Limited', 13500000.00, 1, NULL),
(5, 20, 'Vợt Yonex 100zz Kurenai', 2600000.00, 2, 9);

-- --------------------------------------------------------

--
-- Table structure for table `phieunhap`
--

CREATE TABLE `phieunhap` (
  `MaPN` int(11) NOT NULL,
  `TenNCC` varchar(100) DEFAULT NULL,
  `NgayNhap` datetime DEFAULT current_timestamp(),
  `TongTien` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieunhap`
--

INSERT INTO `phieunhap` (`MaPN`, `TenNCC`, `NgayNhap`, `TongTien`) VALUES
(1, NULL, '2025-10-23 14:41:36', 13.50),
(2, NULL, '2025-10-23 14:42:17', 13.50),
(3, NULL, '2025-10-23 14:43:39', 1.35),
(4, 'Yonex Việt Nam', '2025-10-23 14:46:31', 13500000.00),
(5, 'Mizuno', '2025-10-23 15:01:37', 3240000.00),
(6, 'Lining Sport', '2025-10-23 15:09:54', 3200009.00);

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
  `color` varchar(50) NOT NULL,
  `cost_price` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `category`, `price`, `stock`, `updated_at`, `image`, `productcode`, `weight`, `description`, `length`, `flex`, `color`, `cost_price`) VALUES
(1, 'Vợt Cầu Lông Yonex Astrox 77 Pro Xanh Limited', 'Yonex', 5900000.00, 51, '2024-05-11 06:50:00', 'img/product-1.jpg', 'MMB022972', '5U', '- Vợt Cầu Lông Yonex Astrox 77 Pro Xanh China Limited là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '665 mm', 'Siêu cứng', 'Đỏ đen', 4720000.00),
(2, 'Vợt cầu lông Yonex Nanoflare 1000Z', 'Yonex', 4888000.00, 50, '2024-05-11 06:50:00', 'img/product-2.jpg', 'MMB020719', '3U', 'Vợt Cầu Lông Yonex Nanoflare 1000Z với thiết kế nhẹ đầu, mang lại sự nhẹ nhàng và linh hoạt trong mỗi cú đánh. Trọng lượng nhẹ giúp bạn xoay chuyển vợt một cách nhanh chóng và dễ dàng. Đồng thời, điểm cân bằng ở phía đầu vợt giúp những pha đập cầu nhanh và uy lực. Với cây vợt này, bạn có thể đánh bại đối thủ với những pha cầu nhanh như chớp. ', '700 mm', 'Cứng', 'Xanh đen', 3910400.00),
(3, 'Vợt cầu lông Mizuno XYST 07', 'Mizuno', 4050000.00, 52, '2024-05-11 06:50:00', 'img/product-3.jpg', 'MMB022972', '6U', '- Vợt Cầu Lông Vợt cầu lông Mizuno XYST 07 là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '5U', 'Siêu cứng', 'Đỏ đen', 3200009.00),
(4, 'Vợt cầu lông Lining Halbertec 8000', 'Lining', 3500000.00, 50, '2024-05-11 06:50:00', 'img/product-4.jpg', 'MMB022972', '600 mm', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '6U', 'Cứng', 'Đỏ đen', 2800000.00),
(5, 'Vợt cầu lông Lining Aeronaut 7000B', 'Lining', 3390000.00, 50, '2024-05-11 06:50:00', 'img/product-5.jpg', 'MMB022972', '7U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '500 mm', 'Siêu cứng', 'Xanh đen', 2712000.00),
(6, 'Vợt cầu lông Victor Auraspeed 100X TUC/AC', 'Victor', 2300000.00, 50, '2024-05-11 06:50:00', 'img/product-6.jpg', 'MMB022972', '8U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '687 mm', 'Cứng', 'Xanh đen', 1840000.00),
(7, 'Vợt Cầu Lông Lining Axforce 90 Xanh Dragon', 'Lining', 1349000.00, 50, '2024-05-11 06:50:00', 'img/product-7.jpg', 'MMB022972', '7U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '690 mm', 'Cứng', 'Trắng', 1079200.00),
(8, 'Vợt cầu lông Victor Ryuga Metallic 2024', 'Victor', 2650000.00, 50, '2024-05-11 06:50:00', 'img/product-8.jpg', 'MMB022972', '5U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '650 mm', 'Siêu cứng', 'Đỏ đen', 2120000.00),
(9, 'Vợt Yonex 100zz Kurenai', 'Yonex', 2600000.00, 50, '2024-05-11 06:50:00', 'img/product-9.jpg', 'MMB022972', '7U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '700 mm', 'Cứng', 'Đỏ đen', 2080000.00);

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
  `address1` varchar(50) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `avatar`, `username`, `fullname`, `email`, `address`, `birthday`, `password`, `numberphone`, `city`, `address1`, `status`) VALUES
(2, 'uploads/user2.jpg', 'user01', 'Lê võ gia hưng', 'user01@gmail.com', 'Quận 12', '2000-05-20', '123', '0901234567', 'Hà Nội', '105 Bà Huyện Thanh Quan, Phường Võ Thị Sáu, Quận 3', 1),
(3, 'uploads/user9.jpg', 'user02', 'Phùng Thanh Độ', 'user02@gmail.com', 'Quận 1', '2001-05-20', '123', '0901234567', 'Thanh Hoá', '273 Đ. An Dương Vương, Phường 2, Quận 5', 1),
(4, 'uploads/user6.jpg', 'user03', 'Nguyễn Thanh Tèo', 'user03@gmail.com', 'Quận 5', '2002-05-20', '123', '0901234567', 'Cà Mau', '273 Đ. An Dương Vương, Phường 2, Quận 5', 1),
(5, 'uploads/user7.jpg', 'user04', 'Đỗ Nam Trung', 'user04@gmail.com', 'Quận 9', '2005-05-20', '123', '0901234567', 'Huế', '105 Bà Huyện Thanh Quan, Phường 6, Quận 3', 1),
(6, 'uploads/user10.jpg', 'docellphoneS', 'Trần Thái Bình', 'a@gmail.com', 'Quận Tân Bình', '2000-11-11', '123', '0901234567', 'Vũng Tàu', '105 Bà Huyện Thanh Quan, Phường 6, Quận 3', 1),
(7, 'uploads/user10.jpg', 'user05', 'Lê Văn A', 'ab@gmail.com', 'Quận 10', '2000-11-22', '123', '0901234567', 'Đà Lạt', '105 Bà Huyện Thanh Quan, Phường 6, Quận 3', 1),
(8, 'uploads/user11.jpg', 'nhan', 'lu nhan', 'luhocnhan@gmail.com', 'tp', '2004-12-09', 'nhan15092004', '0775177636', 'tphcm', 'm', 0),
(9, 'uploads/default.jpg', 'a', 'a', 'a', 'a', '0011-11-11', '', 'a', '', NULL, 1);

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
-- Indexes for table `chitietphieunhap`
--
ALTER TABLE `chitietphieunhap`
  ADD PRIMARY KEY (`MaCTPN`),
  ADD KEY `MaPN` (`MaPN`);

--
-- Indexes for table `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

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
-- Indexes for table `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD PRIMARY KEY (`MaPN`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `chitietphieunhap`
--
ALTER TABLE `chitietphieunhap`
  MODIFY `MaCTPN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nhacungcap`
--
ALTER TABLE `nhacungcap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `phieunhap`
--
ALTER TABLE `phieunhap`
  MODIFY `MaPN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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

--
-- Constraints for table `chitietphieunhap`
--
ALTER TABLE `chitietphieunhap`
  ADD CONSTRAINT `chitietphieunhap_ibfk_1` FOREIGN KEY (`MaPN`) REFERENCES `phieunhap` (`MaPN`);

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
