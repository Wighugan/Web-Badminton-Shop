-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2025 at 07:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25
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
-- Table structure for table `ctdh`
--

CREATE TABLE `ctdh` (
  `MACTDH` int(11) NOT NULL,
  `MADH` int(11) NOT NULL,
  `TENSP` varchar(255) NOT NULL,
  `DONGIA` decimal(15,2) NOT NULL,
  `SOLUONG` int(11) NOT NULL,
  `MASP` int(11) DEFAULT NULL,
  `THANHTIEN` decimal(15,2) GENERATED ALWAYS AS (`DONGIA` * `SOLUONG`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ctdh`
--

INSERT INTO `ctdh` (`MACTDH`, `MADH`, `TENSP`, `DONGIA`, `SOLUONG`, `MASP`) VALUES
(7, 3, 'Vợt Yonex 100zz Kurenai', 2600000.00, 4, 19),
(8, 3, 'Vợt Cầu Lông Yonex Astrox 77 Pro Xanh Limited', 13500000.00, 1, 11),
(9, 4, 'Vợt Yonex 100zz Kurenai', 2600000.00, 2, 19);

-- --------------------------------------------------------

--
-- Table structure for table `ctpn`
--

CREATE TABLE `ctpn` (
  `MaCTPN` int(11) NOT NULL,
  `MaPN` int(11) DEFAULT NULL,
  `MaSP` int(11) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT NULL,
  `GiaNhap` decimal(12,2) DEFAULT NULL,
  `ThanhTien` decimal(14,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ctpn`
--

INSERT INTO `ctpn` (`MaCTPN`, `MaPN`, `MaSP`, `SoLuong`, `GiaNhap`, `ThanhTien`) VALUES
(1, 1, 11, 1, 10800000.00, 10800000.00),
(2, 2, 16, 5, 1840000.00, 9200000.00);

-- --------------------------------------------------------

--
-- Table structure for table `don_hang`
--

CREATE TABLE `don_hang` (
  `MADH` int(11) NOT NULL,
  `CODE` varchar(50) NOT NULL,
  `MAKH` int(11) NOT NULL,
  `TONGTIEN` decimal(15,2) NOT NULL,
  `TRANGTHAI` varchar(50) DEFAULT 'Chờ xác nhận',
  `NGAYLAP` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `don_hang`
--

INSERT INTO `don_hang` (`MADH`, `CODE`, `MAKH`, `TONGTIEN`, `TRANGTHAI`, `NGAYLAP`) VALUES
(3, 'DH17601089945312', 7, 23980000.00, 'Thành công', '2025-10-10 22:09:54'),
(4, 'DH17610188909624', 2, 5280000.00, 'Đang giao', '2025-10-21 10:54:50');

-- --------------------------------------------------------

--
-- Table structure for table `gio_hang`
--

CREATE TABLE `gio_hang` (
  `MAGH` int(11) NOT NULL,
  `MAKH` int(11) NOT NULL,
  `MASP` int(11) NOT NULL,
  `SOLUONG` int(11) DEFAULT 1,
  `NGAYLAP` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `khach_hang`
--

CREATE TABLE `khach_hang` (
  `MAKH` int(11) NOT NULL,
  `AVATAR` varchar(255) DEFAULT 'default.jpg',
  `TENKH` varchar(50) NOT NULL,
  `HOTEN` varchar(100) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `DIACHI` varchar(255) NOT NULL,
  `NS` date NOT NULL,
  `MATKHAU` varchar(255) NOT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `TP` varchar(50) NOT NULL,
  `DIACHI1` varchar(50) DEFAULT NULL,
  `TRANGTHAI` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `khach_hang`
--

INSERT INTO `khach_hang` (`MAKH`, `AVATAR`, `TENKH`, `HOTEN`, `EMAIL`, `DIACHI`, `NS`, `MATKHAU`, `SDT`, `TP`, `DIACHI1`, `TRANGTHAI`) VALUES
(1, 'uploads/user2.jpg', 'user01', 'Lê võ gia hưng', 'user01@gmail.com', 'Quận 12', '2000-05-20', '123', '0901234567', 'Hà Nội', '105 Bà Huyện Thanh Quan, Phường Võ Thị Sáu, Quận 3', 1),
(2, 'uploads/user9.jpg', 'user02', 'Phùng Thanh Độ', 'user02@gmail.com', 'Quận 1', '2001-05-20', '123', '0901234567', 'Thanh Hoá', '273 Đ. An Dương Vương, Phường 2, Quận 5', 1),
(3, 'uploads/user6.jpg', 'user03', 'Nguyễn Thanh Tèo', 'user03@gmail.com', 'Quận 5', '2002-05-20', '123', '0901234567', 'Cà Mau', '273 Đ. An Dương Vương, Phường 2, Quận 5', 1),
(4, 'uploads/user7.jpg', 'user04', 'Đỗ Nam Trung', 'user04@gmail.com', 'Quận 9', '2005-05-20', '123', '0901234567', 'Huế', '105 Bà Huyện Thanh Quan, Phường 6, Quận 3', 1),
(5, 'uploads/user10.jpg', 'docellphoneS', 'Trần Thái Bình', 'a@gmail.com', 'Quận Tân Bình', '2000-11-11', '123', '0901234567', 'Vũng Tàu', '105 Bà Huyện Thanh Quan, Phường 6, Quận 3', 1),
(6, 'uploads/user10.jpg', 'user05', 'Lê Văn A', 'ab@gmail.com', 'Quận 10', '2000-11-22', '123', '0901234567', 'Đà Lạt', '105 Bà Huyện Thanh Quan, Phường 6, Quận 3', 1),
(7, 'uploads/user11.jpg', 'nhan', 'lu nhan', 'luhocnhan@gmail.com', 'tp', '2004-12-09', 'nhan15092004', '0775177636', 'tphcm', 'm', 1),
(8, 'uploads/1761741213_user8jpg.jpg', 'user12', 'Ma văn nây', 'a@gmail.com', 'Saudi', '1996-01-01', '', '0912345678', 'Palestine', 'Ả rập', 1),
(9, 'uploads/1761726658_0_n.jpg', '', '', '', '', '0000-00-00', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `loai_sp`
--

CREATE TABLE `loai_sp` (
  `MALOAI` varchar(10) NOT NULL,
  `TENLOAI` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `loai_sp`
--

INSERT INTO `loai_sp` (`MALOAI`, `TENLOAI`) VALUES
('lg', 'Lining'),
('mo', 'Mizuno'),
('vr', 'Victor'),
('yx', 'Yonex');

-- --------------------------------------------------------

--
-- Table structure for table `ncc`
--

CREATE TABLE `ncc` (
  `MANCC` int(11) NOT NULL,
  `TENNCC` varchar(100) NOT NULL,
  `AVATAR` varchar(255) DEFAULT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `DIACHI` varchar(255) DEFAULT NULL,
  `NGAYHT` date DEFAULT NULL,
  `TRANGTHAI` tinyint(4) DEFAULT 1,
  `NGUOIDD` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ncc`
--

INSERT INTO `ncc` (`MANCC`, `TENNCC`, `AVATAR`, `SDT`, `EMAIL`, `DIACHI`, `NGAYHT`, `TRANGTHAI`, `NGUOIDD`) VALUES
(1, 'Yonex Việt Nam', 'uploads/ncc5.png', '0905123456', 'contact@yonexvn.com', '123 Lý Thường Kiệt, Hà Nội', '2023-05-10', 1, 'Nguyễn Văn Hà'),
(2, 'Lining Sport', 'uploads/ncc2.png', '0987123456', 'support@lining.vn', '88 Nguyễn Huệ, Hồ Chí Minh', '2022-03-15', 1, 'Elon Musk'),
(3, 'Victor Corporation', 'uploads/ncc3.png', '0932456789', 'sales@victor.com.vn', '56 Nguyễn Văn Cừ, Đà Nẵng', '2021-11-20', 1, 'Bill Gates'),
(4, 'Fleet Badminton', 'uploads/ncc4.png', '0912345678', 'info@fleet.vn', '25 Trần Phú, Hải Phòng', '2024-01-05', 1, 'Lionel Messi'),
(5, 'Mizuno ', 'uploads/ncc1.png', '0978123987', 'mizuno.imports@gmail.com', '9 Pasteur, Hồ Chí Minh', '2023-09-01', 1, 'Lưu Đức Long');

-- --------------------------------------------------------

--
-- Table structure for table `nhan_vien`
--

CREATE TABLE `nhan_vien` (
  `MANV` int(11) NOT NULL,
  `AVATAR` varchar(255) DEFAULT NULL,
  `TENNV` varchar(50) NOT NULL,
  `HOTEN` varchar(100) NOT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `NGAYLAM` date DEFAULT NULL,
  `NS` date DEFAULT NULL,
  `MATKHAU` varchar(255) NOT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `TRANGTHAI` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nhan_vien`
--

INSERT INTO `nhan_vien` (`MANV`, `AVATAR`, `TENNV`, `HOTEN`, `EMAIL`, `NGAYLAM`, `NS`, `MATKHAU`, `SDT`, `TRANGTHAI`) VALUES
(1, 'uploads/user9.jpg', 'nv01', 'Nguyễn Văn Rô', 'an.nguyen@example.com', '2022-05-10', '1998-03-12', '123', '0905123456', '1'),
(2, 'uploads/user6.jpg', 'nv02', 'Trần Thị Bình', 'binh.tran@example.com', '2023-02-20', '1997-09-25', '123', '0912345678', '1'),
(3, 'uploads/user10.jpg', 'nv03', 'Lê Quốc Dũng', 'dung.le@example.com', '2024-01-15', '1995-06-09', '123', '0987123456', '1');

-- --------------------------------------------------------

--
-- Table structure for table `phieu_nhap`
--

CREATE TABLE `phieu_nhap` (
  `MaPN` int(11) NOT NULL,
  `TenNCC` varchar(100) DEFAULT NULL,
  `NgayNhap` date DEFAULT NULL,
  `TongTien` decimal(14,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieu_nhap`
--

INSERT INTO `phieu_nhap` (`MaPN`, `TenNCC`, `NgayNhap`, `TongTien`) VALUES
(1, 'Yonex Việt Nam', '2025-10-30', 10800000.00),
(2, 'Victor Corporation', '2025-10-30', 9200000.00);

-- --------------------------------------------------------

--
-- Table structure for table `san_pham`
--

CREATE TABLE `san_pham` (
  `MASP` int(11) NOT NULL,
  `MALOAI` varchar(10) DEFAULT NULL,
  `TENSP` varchar(255) NOT NULL,
  `DONGIA` decimal(10,2) NOT NULL,
  `SOLUONG` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `IMAGE` varchar(255) NOT NULL,
  `BARCODE` varchar(50) DEFAULT NULL,
  `WEIGHT` varchar(20) NOT NULL,
  `MOTA` text DEFAULT NULL,
  `LENGTH` varchar(50) DEFAULT NULL,
  `FLEX` varchar(50) NOT NULL,
  `GIANHAP` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `san_pham`
--

INSERT INTO `san_pham` (`MASP`, `MALOAI`, `TENSP`, `DONGIA`, `SOLUONG`, `updated_at`, `IMAGE`, `BARCODE`, `WEIGHT`, `MOTA`, `LENGTH`, `FLEX`, `GIANHAP`) VALUES
(11, 'yx', 'Vợt Cầu Lông Yonex Astrox 77 Pro Xanh Limited', 13500000.00, 51, '2025-10-29 15:10:17', 'img/product-1.jpg', 'MMB022972', '5U', '- Vợt Cầu Lông Yonex Astrox 77 Pro Xanh China Limited là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '665 mm', 'Siêu cứng', 10800000.00),
(12, 'yx', 'Vợt cầu lông Yonex Nanoflare 1000Z', 4888000.00, 50, '0000-00-00 00:00:00', 'img/product-2.jpg', 'MMB020719', '3U', 'Vợt Cầu Lông Yonex Nanoflare 1000Z với thiết kế nhẹ đầu, mang lại sự nhẹ nhàng và linh hoạt trong mỗi cú đánh. Trọng lượng nhẹ giúp bạn xoay chuyển vợt một cách nhanh chóng và dễ dàng. Đồng thời, điểm cân bằng ở phía đầu vợt giúp những pha đập cầu nhanh và uy lực. Với cây vợt này, bạn có thể đánh bại đối thủ với những pha cầu nhanh như chớp. ', '700 mm', 'Cứng', 3910400.00),
(13, 'mo', 'Vợt cầu lông Mizuno XYST 07', 4050000.00, 50, '0000-00-00 00:00:00', 'img/product-3.jpg', 'MMB022972', '6U', '- Vợt Cầu Lông Vợt cầu lông Mizuno XYST 07 là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '5U', 'Siêu cứng', 3240000.00),
(14, 'lg', 'Vợt cầu lông Lining Halbertec 8000', 3500000.00, 50, '0000-00-00 00:00:00', 'img/product-4.jpg', 'MMB022972', '600 mm', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '6U', 'Cứng', 2800000.00),
(15, 'lg', 'Vợt cầu lông Lining Aeronaut 7000B', 3390000.00, 50, '0000-00-00 00:00:00', 'img/product-5.jpg', 'MMB022972', '7U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '500 mm', 'Siêu cứng', 2712000.00),
(16, 'vr', 'Vợt cầu lông Victor Auraspeed 100X TUC/AC', 2300000.00, 55, '0000-00-00 00:00:00', 'img/product-6.jpg', 'MMB022972', '8U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '687 mm', 'Cứng', 1840000.00),
(17, 'lg', 'Vợt Cầu Lông Lining Axforce 90 Xanh Dragon', 1349000.00, 50, '0000-00-00 00:00:00', 'img/product-7.jpg', 'MMB022972', '7U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '690 mm', 'Cứng', 1079200.00),
(18, 'vr', 'Vợt cầu lông Victor Ryuga Metallic 2024', 2650000.00, 50, '0000-00-00 00:00:00', 'img/product-8.jpg', 'MMB022972', '5U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '650 mm', 'Siêu cứng', 2120000.00),
(19, 'yx', 'Vợt Yonex 100zz Kurenai', 2600000.00, 50, '0000-00-00 00:00:00', 'img/product-9.jpg', 'MMB022972', '7U', 'là một phiên bản đặc biệt được tạo ra để tôn vinh VĐV xuất sắc Huang Ya Qiong, ngôi sao hàng đầu trong làng cầu lông đôi nam nữ thế giới', '700 mm', 'Cứng', 2080000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ctdh`
--
ALTER TABLE `ctdh`
  ADD PRIMARY KEY (`MACTDH`),
  ADD KEY `MADH` (`MADH`),
  ADD KEY `MASP` (`MASP`);

--
-- Indexes for table `ctpn`
--
ALTER TABLE `ctpn`
  ADD PRIMARY KEY (`MaCTPN`);

--
-- Indexes for table `don_hang`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`MADH`),
  ADD KEY `MAKH` (`MAKH`);

--
-- Indexes for table `gio_hang`
--
ALTER TABLE `gio_hang`
  ADD PRIMARY KEY (`MAGH`),
  ADD KEY `MAKH` (`MAKH`),
  ADD KEY `MASP` (`MASP`);

--
-- Indexes for table `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`MAKH`);

--
-- Indexes for table `loai_sp`
--
ALTER TABLE `loai_sp`
  ADD PRIMARY KEY (`MALOAI`);

--
-- Indexes for table `ncc`
--
ALTER TABLE `ncc`
  ADD PRIMARY KEY (`MANCC`);

--
-- Indexes for table `nhan_vien`
--
ALTER TABLE `nhan_vien`
  ADD PRIMARY KEY (`MANV`);

--
-- Indexes for table `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  ADD PRIMARY KEY (`MaPN`);

--
-- Indexes for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`MASP`),
  ADD KEY `MALOAI` (`MALOAI`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ctdh`
--
ALTER TABLE `ctdh`
  MODIFY `MACTDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ctpn`
--
ALTER TABLE `ctpn`
  MODIFY `MaCTPN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `MADH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gio_hang`
--
ALTER TABLE `gio_hang`
  MODIFY `MAGH` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `MAKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ncc`
--
ALTER TABLE `ncc`
  MODIFY `MANCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nhan_vien`
--
ALTER TABLE `nhan_vien`
  MODIFY `MANV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  MODIFY `MaPN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `MASP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ctdh`
--
ALTER TABLE `ctdh`
  ADD CONSTRAINT `ctdh_ibfk_1` FOREIGN KEY (`MADH`) REFERENCES `don_hang` (`MADH`),
  ADD CONSTRAINT `ctdh_ibfk_2` FOREIGN KEY (`MASP`) REFERENCES `san_pham` (`MASP`);

--
-- Constraints for table `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `don_hang_ibfk_1` FOREIGN KEY (`MAKH`) REFERENCES `khach_hang` (`MAKH`);

--
-- Constraints for table `gio_hang`
--
ALTER TABLE `gio_hang`
  ADD CONSTRAINT `gio_hang_ibfk_1` FOREIGN KEY (`MAKH`) REFERENCES `khach_hang` (`MAKH`),
  ADD CONSTRAINT `gio_hang_ibfk_2` FOREIGN KEY (`MASP`) REFERENCES `san_pham` (`MASP`);

--
-- Constraints for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `san_pham_ibfk_1` FOREIGN KEY (`MALOAI`) REFERENCES `loai_sp` (`MALOAI`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
