<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';

class NhapHang {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function themPhieuNhap($tenNCC, $tongTien) {
        $sql = "INSERT INTO phieu_nhap (TenNCC, NgayNhap, TongTien) VALUES (?, NOW(), ?)";
        $this->db->command_prepare($sql, "sd", $tenNCC, $tongTien);
        $this->db->execute();
        return $this->db->getConnection()->insert_id; // Lấy ID của phiếu nhập vừa tạo
    }

    public function themChiTietPhieuNhap($maPN, $maSP, $soLuong, $giaNhap) {
        $thanhTien = $soLuong * $giaNhap;
        $sql = "INSERT INTO ctpn (MaPN, MaSP, SoLuong, GiaNhap, ThanhTien) VALUES (?, ?, ?, ?, ?)";
        $this->db->command_prepare($sql, "iiidd", $maPN, $maSP, $soLuong, $giaNhap, $thanhTien);
        $this->db->execute();
    }

    public function capNhatKho($maSP, $soLuong, $giaNhap) {
        // Kiểm tra sản phẩm có tồn tại không
        $sqlCheck = "SELECT SOLUONG, GIANHAP FROM san_pham WHERE MASP = ?";
        $this->db->select_prepare($sqlCheck, "i", $maSP);
        $row = $this->db->fetch();

        if ($row) {
            $newSoLuong = $row['SOLUONG'] + $soLuong;
            // cập nhật lại cả số lượng và giá nhập (nếu muốn cập nhật giá nhập mới)
            $sqlUpdate = "UPDATE san_pham SET SOLUONG = ?, GIANHAP = ? WHERE MASP = ?";
            $this->db->command_prepare($sqlUpdate, "idi", $newSoLuong, $giaNhap, $maSP);
            $this->db->execute();
            return true;
        } else {
            return false;
        }
    }
}

// ============================

// ============================
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new database();
    $nhapHang = new NhapHang($db);

    // Lấy dữ liệu từ form
    $tenNCC   = $_POST['TenNCC'] ?? '';
    $maSP     = intval($_POST['MaSP'] ?? 0);
    $soLuong  = intval($_POST['SoLuong'] ?? 0);
    $giaNhap  = floatval($_POST['GiaNhap'] ?? 0);
    $tongTien = $soLuong * $giaNhap;

    $maPN = $nhapHang->themPhieuNhap($tenNCC, $tongTien);

    $nhapHang->themChiTietPhieuNhap($maPN, $maSP, $soLuong, $giaNhap);

    $capNhat = $nhapHang->capNhatKho($maSP, $soLuong, $giaNhap);

    if ($capNhat) {
        echo "<script>
            alert('✅ Nhập hàng thành công! Sản phẩm đã được cập nhật vào kho.');
            window.location.href = 'quanlykho.php';
        </script>";
    } else {
        echo "<script>
            alert('⚠️ Sản phẩm chưa tồn tại trong kho! Vui lòng thêm sản phẩm trước.');
            window.history.back();
        </script>";
    }

    $db->close();
} else {
    echo "<script>
        alert('❌ Không có dữ liệu gửi đến!');
        window.history.back();
    </script>";
}
?>
