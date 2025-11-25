<?php 
 include 'order.php';
    $data = new Database();
    $dh = new Order($data);
    class Cart {
        private $data;
        public function __construct($data) {
            $this->data = $data;
        }
        public function layGioHang($MAKH) {
        $sql = "SELECT sp.MASP, sp.TENSP, sp.DONGIA, sp.IMAGE, g.SOLUONG
                FROM gio_hang g
                JOIN san_pham sp ON g.MASP = sp.MASP
                WHERE g.MAKH = ?";

        $this->data->select_prepare($sql, "i", $MAKH);
        $items = [];

        while ($row = $this->data->fetch()) {
            $items[] = $row;
        }

        return $items; // trả về danh sách giỏ hàng
    }

    // 💰 Tính tổng tiền giỏ hàng
    public function tinhTongTien($MAKH) {
        $items = $this->layGioHang($MAKH);
        $total = 0;

        foreach ($items as $item) {
            $total += $item['DONGIA'] * $item['SOLUONG'];
        }

        return $total;
    }
    public function themVaoGio($MAKH, $MASP, $SOLUONG = 1) {
        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ chưa
        $sql_check = "SELECT SOLUONG FROM gio_hang WHERE MAKH = ? AND MASP = ?";
        $this->data->select_prepare($sql_check, "ii", $MAKH, $MASP);
        $item = $this->data->fetch();

        if ($item) {
            // Nếu có rồi => Cập nhật số lượng
            $new_quantity = $item['SOLUONG'] + $SOLUONG;
            $sql_update = "UPDATE gio_hang SET SOLUONG = ? WHERE MAKH = ? AND MASP = ?";
            $this->data->command_prepare($sql_update, "iii", $new_quantity, $MAKH, $MASP)->execute();
        } else {
            // Nếu chưa có => Thêm mới
            $sql_insert = "INSERT INTO gio_hang (MAKH, MASP, SOLUONG) VALUES (?, ?, ?)";
            $this->data->command_prepare($sql_insert, "iii", $MAKH, $MASP, $SOLUONG)->execute();
        }

        return ['success' => true, 'message' => 'Đã thêm sản phẩm vào giỏ hàng!'];
    }

    // 🔁 Cập nhật số lượng sản phẩm trong giỏ hàng
    public function capNhatSoLuong($MAKH, $MASP, $SOLUONG) {
        if ($SOLUONG <= 0) {
            // Nếu số lượng <= 0 thì xoá sản phẩm
            $this->xoaSanPham($MAKH, $MASP);
            return ['success' => true, 'message' => 'Đã xoá sản phẩm khỏi giỏ hàng!'];
        } else {
            // Ngược lại thì cập nhật
            $sql = "UPDATE gio_hang SET SOLUONG = ? WHERE MAKH = ? AND MASP = ?";
            $this->data->command_prepare($sql, "iii", $SOLUONG, $MAKH, $MASP)->execute();
            return ['success' => true, 'message' => 'Cập nhật số lượng thành công!'];
        }
    }
     public function xoaSanPham($MAKH, $MASP) {
        $sql = "DELETE FROM gio_hang WHERE MAKH = ? AND MASP = ?";
        $this->data->command_prepare($sql, "ii", $MAKH, $MASP)->execute();
        return ['success' => true, 'message' => 'Xoá sản phẩm thành công!'];
    }

    }

?>
