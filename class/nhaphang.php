<?php
require_once __DIR__ . '/systemManage.php';
class NhapHang extends QuanLyHeThong{
    protected $data;

    public function __construct() {
        $this->data = new Database();
    }
    public function getLastMaPN() {
     $sql = "SELECT MAX(MaPN) as MaPN FROM phieu_nhap";
    $this->data->select_prepare($sql, "");
    $result = $this->data->fetch();
    return $result ? $result['MaPN'] : 0;
    }
    public function themPhieuNhap($tenNCC, $tongTien) {
    $sql = "INSERT INTO phieu_nhap (TenNCC, NgayNhap, TongTien) VALUES (?, NOW(), ?)";
    $this->data->command_prepare($sql, "sd", $tenNCC, $tongTien);
    $ok = $this->data->execute();
    // ✅ Return mã phiếu nhập vừa tạo (0 nếu thất bại)
    return $ok ? $this->getLastMaPN() : 0;
}    public function themChiTietPhieuNhap($maPN, $maSP, $soLuong, $giaNhap) {
        $thanhTien = $soLuong * $giaNhap;
        $sql = "INSERT INTO ctpn (MaPN, MaSP, SoLuong, GiaNhap, ThanhTien) VALUES (?, ?, ?, ?, ?)";
        $this->data->command_prepare($sql, "iiidd", $maPN, $maSP, $soLuong, $giaNhap, $thanhTien);
        return $this->data->execute();
    }

    public function capNhatKho($maSP, $soLuong, $giaNhap) {
        // Kiểm tra sản phẩm có tồn tại không
        $sqlCheck = "SELECT SOLUONG, GIANHAP FROM san_pham WHERE MASP = ?";
        $this->data->select_prepare($sqlCheck, "i", $maSP);
        $row = $this->data->fetch();

        if ($row) {
            $newSoLuong = $row['SOLUONG'] + $soLuong;
            // cập nhật lại cả số lượng và giá nhập (nếu muốn cập nhật giá nhập mới)
            $sqlUpdate = "UPDATE san_pham SET SOLUONG = ?, GIANHAP = ? WHERE MASP = ?";
            $this->data->command_prepare($sqlUpdate, "idi", $newSoLuong, $giaNhap, $maSP);
            return (bool)$this->data->execute();
        } else {
            return false;
        }
    }
    public function xoaKhoiKho($maSP, $soLuong) {
        // Kiểm tra sản phẩm có tồn tại không
        $sqlCheck = "SELECT SOLUONG FROM san_pham WHERE MASP = ?";
        $this->data->select_prepare($sqlCheck, "i", $maSP);
        $row = $this->data->fetch();

        if ($row) {
            $newSoLuong = $row['SOLUONG'] - $soLuong;
            if ($newSoLuong < 0) {
                $newSoLuong = 0; // Không để số lượng âm
            }
            // cập nhật lại số lượng
            $sqlUpdate = "UPDATE san_pham SET SOLUONG = ? WHERE MASP = ?";
            $this->data->command_prepare($sqlUpdate, "ii", $newSoLuong, $maSP);
            return (bool)$this->data->execute();
        } else {
            return false;
        }
    }
    public function getProductQuantity($maSP) {
        $sql = "SELECT SOLUONG FROM san_pham WHERE MASP = ?";
        $this->data->select_prepare($sql, "i", $maSP);
        $row = $this->data->fetch();
        return $row ? $row['SOLUONG'] : null;
    }
    public function getProductPrice($maSP) {
        $sql = "SELECT GIANHAP FROM san_pham WHERE MASP = ?";
        $this->data->select_prepare($sql, "i", $maSP);
        $row = $this->data->fetch();
        return $row ? $row['GIANHAP'] : null;
    }
    public function capNhatGiaNhap($maSP, $giaNhap) {
        $sqlUpdate = "UPDATE san_pham SET GIANHAP = ? WHERE MASP = ?";
        $this->data->command_prepare($sqlUpdate, "di", $giaNhap, $maSP);
        return $this->data->execute();
}
   public function getLastMaPNByNCC($tenNCC) {
    $sql = "SELECT MaPN FROM phieu_nhap WHERE TenNCC = ? ORDER BY MaPN DESC LIMIT 1";
    $this->data->select_prepare($sql, "s", $tenNCC);
    $result = $this->data->fetch();
    return $result ? (int)$result['MaPN'] : 0;
}   
   public function getProductByCategory($MALOAI) {
        $sql = 'SELECT MASP, TENSP, GIANHAP FROM san_pham WHERE MALOAI = ? ORDER BY TENSP';
        $this->data->select_prepare($sql, 's', $MALOAI);
        $products = [];
        while ($row = $this->data->fetch()) {
            $products[] = [
                'MASP' => $row['MASP'],
                'TENSP' => $row['TENSP'],
                'GIANHAP' => (float)$row['GIANHAP']
            ];
        }
        return $products; 
}
   public function __destruct()
       {
           
       }
}
?>
