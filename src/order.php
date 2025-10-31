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
    $sql = "SELECT sp.MASP, sp.TENSP, sp.DONGIA, g.SOLUONG 
            FROM gio_hang g 
            JOIN san_pham sp ON g.MASP = sp.MASP 
            WHERE g.MAKH = ?";
    $this->data->select_prepare($sql, "i", $MAKH);
    $cart_items = $this->data->fetchAll();

    if (empty($cart_items)) {
        return ['success' => false, 'message' => 'Giỏ hàng trống!'];
    }
    // 2️⃣ Tính tổng tiền
    $total = 0;
    foreach ($cart_items as $row) {
        $total += $row['DONGIA'] * $row['SOLUONG'];
    }
    // Thêm phí vận chuyển + bảo hiểm
    $shipping_fee = 50000;
    $insurance_fee = 30000;
    $total += $shipping_fee + $insurance_fee;
    // Tạo mã đơn hàng
    $order_code = 'DH' . time() . rand(1000, 9999);
    //Thêm vào bảng `don_hang`
    $sql1 = "INSERT INTO don_hang (CODE, MAKH, TONGTIEN, TRANGTHAI, NGAYLAP)
             VALUES (?, ?, ?, 'Thành công', NOW())";
    $this->data->command_prepare($sql1, "ssi", $order_code, $MAKH, $total);
    //Lấy mã đơn hàng vừa thêm
    $sql_get_id = "SELECT MAX(MADH) AS MADH FROM don_hang WHERE MAKH = ?";
    $this->data->select_prepare($sql_get_id, "i", $MAKH);
    $order_row = $this->data->fetch();
    $order_id = $order_row ? $order_row['MADH'] : null;
    //Thêm chi tiết đơn hàng
    foreach ($cart_items as $item) {
        $sql2 = "INSERT INTO CTDH (MADH, MASP, TENSP, DONGIA, SOLUONG)
                 VALUES (?, ?, ?, ?, ?)";
        $this->data->command_prepare($sql2, "iisii",
            $order_id,
            $item['MASP'],
            $item['TENSP'],
            $item['DONGIA'],
            $item['SOLUONG']
        );
    }

    // Xóa giỏ hàng sau khi tạo đơn
    $sql3 = "DELETE FROM gio_hang WHERE MAKH = ?";
    $this->data->command_prepare($sql3, "i", $MAKH);
    //Trả kết quả
    return [
        'success' => true,
        'order_code' => $order_code,
        'total' => $total,
        'shipping_fee' => $shipping_fee,
        'insurance_fee' => $insurance_fee
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