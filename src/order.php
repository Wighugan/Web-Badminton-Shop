<?php
include_once 'database/connect.php';
class Order {
    private $data;
    public function __construct($data) {
        $this->data = $data;
    }
    public function getLastInsertId() {
        $sql    = "SELECT MADH FROM don_hang ORDER BY MADH DESC LIMIT 1";
        $this->data->select_prepare($sql);
        return $this->data->fetch();
    }
   public function TaoDonHang($MAKH) {
    // 1️⃣ Lấy sản phẩm trong giỏ hàng
    $sql = "SELECT sp.MASP, sp.TENSP, sp.DONGIA, sp.SOLUONG AS TONKHO, g.SOLUONG AS SOLUONG_MUA
            FROM gio_hang g
            JOIN san_pham sp ON g.MASP = sp.MASP
            WHERE g.MAKH = ?";
    $this->data->select_prepare($sql, "i", $MAKH);
    $cart_items = $this->data->fetchAll();

    if (empty($cart_items)) {
        return ['success' => false, 'message' => 'Giỏ hàng trống!'];
    }

    // 2️⃣ Kiểm tra tồn kho
    foreach ($cart_items as $item) {
        if ($item['SOLUONG_MUA'] > $item['TONKHO']) {
            return [
                'success' => false,
                'message' => "Sản phẩm {$item['TENSP']} chỉ còn {$item['TONKHO']} trong kho!"
            ];
        }
    }

    // 3️⃣ Tính tổng tiền
    $total = 0;
    foreach ($cart_items as $row) {
        $total += $row['DONGIA'] * $row['SOLUONG_MUA'];
    }
    $shipping_fee = 50000;
    $insurance_fee = 30000;
    $total += $shipping_fee + $insurance_fee;

    // 4️⃣ Tạo mã đơn hàng và lưu vào don_hang
    $order_code = 'DH' . time() . rand(1000, 9999);
    $sql1 = "INSERT INTO don_hang (CODE, MAKH, TONGTIEN, TRANGTHAI, NGAYLAP)
             VALUES (?, ?, ?, 'Thành công', NOW())";
    // order_code: string, MAKH: int, total: decimal -> use types "sid"
    $this->data->command_prepare($sql1, "sid", $order_code, $MAKH, $total)->execute();

    // Lấy mã đơn hàng vừa thêm
    $sql_get_id = "SELECT MAX(MADH) AS MADH FROM don_hang WHERE MAKH = ?";
    $this->data->select_prepare($sql_get_id, "i", $MAKH);
    $order_row = $this->data->fetch();
    $order_id = $order_row ? $order_row['MADH'] : null;

    // 5️⃣ Thêm chi tiết đơn hàng và trừ tồn kho
    foreach ($cart_items as $item) {
        // Thêm chi tiết đơn hàng
        $sql2 = "INSERT INTO CTDH (MADH, MASP, TENSP, DONGIA, SOLUONG)
                 VALUES (?, ?, ?, ?, ?)";
        $this->data->command_prepare($sql2, "iisii",
            $order_id,
            $item['MASP'],
            $item['TENSP'],
            $item['DONGIA'],
            $item['SOLUONG_MUA']
        )->execute();

        // Trừ tồn kho
        $sql_update_stock = "UPDATE san_pham 
                             SET SOLUONG = SOLUONG - ? 
                             WHERE MASP = ?";
        $this->data->command_prepare($sql_update_stock, "ii",
            $item['SOLUONG_MUA'],
            $item['MASP']
        )->execute();
    }

    // 6️⃣ Xóa giỏ hàng
    $sql3 = "DELETE FROM gio_hang WHERE MAKH = ?";
    $this->data->command_prepare($sql3, "i", $MAKH)->execute();

    // 7️⃣ Trả kết quả
    return [
        'success' => true,
        'order_code' => $order_code,
        'total' => $total,
        'shipping_fee' => $shipping_fee,
        'insurance_fee' => $insurance_fee,
        'message' => 'Đặt hàng thành công!'
    ];
}

     public function DemSoDonHang($MAKH, $limit = 10) {
        // Xác định trang hiện tại
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;
        // Đếm tổng số đơn hàng
        $sql = "SELECT COUNT(*) AS total FROM don_hang WHERE MAKH = ?";
        $this->data->select_prepare($sql, "i", $MAKH);
        $row = $this->data->fetch();

        $total_orders = $row ? $row['total'] : 0;
        $total_pages = ceil($total_orders / $limit);

        return [
            'limit' => $limit,
            'page' => $page,
            'offset' => $offset,
            'total_orders' => $total_orders,
            'total_pages' => $total_pages
        ];
    }
    public function getOrderDetails($order_id) {
        $sql = "SELECT ct.*, sp.IMAGE FROM ctdh ct JOIN san_pham sp ON ct.MASP = sp.MASP WHERE ct.MADH = ?";
        $this->data->select_prepare($sql, "i", $order_id);
        return $this->data->fetchAll();
    }
    public function __destruct() {
        $this->data->close();
    }
    
}
?>