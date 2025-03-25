-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 02:05 PM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
