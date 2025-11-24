<?php
require_once __DIR__ . '/systemManage.php';
class Order extends QuanLyHeThong{
    private $MADH;
    private $MAKH;
    private $TRANGTHAI;
    private $NGAYLAP;
    private $TONGTIEN;
    protected $data;
    protected $limit = 10;
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
// tiềm kiếm dơn hàng ngày lập
    public function countOrders($search = '', $start_date = '', $end_date = '', $address = '', $status = '') {
        $where = [];
        $params = [];
        $types = "";

        if (!empty($search)) {
            $where[] = "(don_hang.MADH LIKE ? OR don_hang.MAKH LIKE ? OR khach_hang.HOTEN LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $types .= "sss";
        }

        if (!empty($start_date) && !empty($end_date)) {
            $where[] = "DATE(don_hang.NGAYLAP) BETWEEN ? AND ?";
            $params[] = $start_date;
            $params[] = $end_date;
            $types .= "ss";
        }

        if (!empty($address)) {
            $where[] = "khach_hang.DIACHI1 LIKE ?";
            $params[] = "%$address%";
            $types .= "s";
        }

        if (!empty($status)) {
            $where[] = "don_hang.TRANGTHAI = ?";
            $params[] = $status;
            $types .= "s";
        }

        $sql = "SELECT COUNT(*) AS total
                FROM don_hang
                JOIN khach_hang ON don_hang.MAKH = khach_hang.MAKH";

        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }
        $this->data->select_prepare($sql, $types, ...$params);
        $row = $this->data->fetch();
        return $row['total'] ?? 0;
    }

    public function getLimit() {
        return $this->limit;
    }
// chi tiết đơn hàng
    public function getOrderInfo($order_id)
{
    $sql = "SELECT don_hang.*, 
                   khach_hang.HOTEN, 
                   khach_hang.SDT, 
                   khach_hang.DIACHI1
            FROM don_hang
            JOIN khach_hang ON don_hang.MAKH = khach_hang.MAKH
            WHERE don_hang.MADH = ?
            LIMIT 1";

    $this->data->select_prepare($sql, "i", $order_id);
    return $this->data->fetch(); // trả 1 dòng
}
public function updateStatus($MADH, $TRANGTHAI) {
        try {
            // Kiểm tra đơn hàng tồn tại
            $check_sql = "SELECT MADH FROM don_hang WHERE MADH = ?";
            $this->data->select_prepare($check_sql, "i", $MADH);
            $exists = $this->data->fetch();

            if (!$exists) {
                return ['success' => false, 'message' => '❌ Đơn hàng không tồn tại!'];
            }

            // Kiểm tra trạng thái hợp lệ
            $valid_statuses = ['Chờ xác nhận', 'Đang giao', 'Thành công', 'Đã hủy'];
            if (!in_array($TRANGTHAI, $valid_statuses)) {
                return ['success' => false, 'message' => '❌ Trạng thái không hợp lệ!'];
            }

            // Cập nhật trạng thái
            $sql = "UPDATE don_hang SET TRANGTHAI = ? WHERE MADH = ?";
            $this->data->command_prepare($sql, "si", $TRANGTHAI, $MADH);
            
            if ($this->data->execute()) {
                return ['success' => true, 'message' => '✅ Cập nhật trạng thái đơn hàng thành công!'];
            } else {
                return ['success' => false, 'message' => '❌ Lỗi khi cập nhật trạng thái!'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
        }
    }

    // ===== LẤY CÁC TRẠNG THÁI KHẢ DỤNG TIẾP THEO =====
    public function getNextStatuses($current_status) {
        $status_flow = [
            'Chờ xác nhận' => ['Đang giao', 'Đã hủy'],
            'Đang giao' => ['Thành công', 'Đã hủy'],
            'Thành công' => [],
            'Đã hủy' => []
        ];
        
        return $status_flow[$current_status] ?? [];
    }
// Thống kê khách hàng
    public function getCustomerStatistics($page = 1, $search = '', $start = '', $end = '') {
        $offset = ($page - 1) * $this->limit;
        $where = "1";
        $params = [];
        $types = "";

        if (!empty($search)) {
            $where .= " AND khach_hang.HOTEN LIKE ?";
            $params[] = "%$search%";
            $types .= "s";
        }

        if (!empty($start) && !empty($end)) {
            $where .= " AND don_hang.NGAYLAP BETWEEN ? AND ?";
            $params[] = $start . " 00:00:00";
            $params[] = $end . " 23:59:59";
            $types .= "ss";
        }
        $sql = "SELECT khach_hang.MAKH AS makh, khach_hang.HOTEN AS tenkh, 
                       COUNT(don_hang.MADH) AS sohoadon, 
                       COALESCE(SUM(don_hang.TONGTIEN), 0) AS tongtien
                FROM khach_hang
                LEFT JOIN don_hang ON khach_hang.MAKH = don_hang.MAKH
                WHERE $where
                GROUP BY khach_hang.MAKH, khach_hang.HOTEN
                ORDER BY tongtien DESC
                LIMIT ? OFFSET ?";
        $params[] = $this->limit;
        $params[] = $offset;
        $types .= "ii";

        $this->data->select_prepare($sql, $types, ...$params);
        return $this->data->fetchAll();
    }
// Đếm tổng khách hàng trong thống kê
    public function countCustomerStatistics($search = '', $start = '', $end = '') {
        $where = "1";
        $params = [];
        $types = "";

        if (!empty($search)) {
            $where .= " AND khach_hang.HOTEN LIKE ?";
            $params[] = "%$search%";
            $types .= "s";
        }

        if (!empty($start) && !empty($end)) {
            $where .= " AND don_hang.NGAYLAP BETWEEN ? AND ?";
            $params[] = $start . " 00:00:00";
            $params[] = $end . " 23:59:59";
            $types .= "ss";
        }

        $sql = "SELECT COUNT(DISTINCT khach_hang.MAKH) AS total
                FROM khach_hang
                LEFT JOIN don_hang ON khach_hang.MAKH = don_hang.MAKH
                WHERE $where";

        $this->data->select_prepare($sql, $types, ...$params);
        $row = $this->data->fetch();
        return $row['total'] ?? 0;
    }
// tiềm kiếm dơn hàng theo nhiều điều kiện
    public function getOrders($page = 1, $search = '', $start_date = '', $end_date = '', $address = '', $status = '') {
    $offset = ($page - 1) * $this->limit;

    $where = [];
    $params = [];
    $types = "";

    if (!empty($search)) {
        $where[] = "(don_hang.MADH LIKE ? OR don_hang.MAKH LIKE ? OR khach_hang.HOTEN LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
        $params[] = "%$search%";
        $types .= "sss";
    }

    if (!empty($start_date) && !empty($end_date)) {
        $where[] = "DATE(don_hang.NGAYLAP) BETWEEN ? AND ?";
        $params[] = $start_date;
        $params[] = $end_date;
        $types .= "ss";
    }

    if (!empty($address)) {
        $where[] = "khach_hang.DIACHI1 LIKE ?";
        $params[] = "%$address%";
        $types .= "s";
    }

    if (!empty($status)) {
        $where[] = "don_hang.TRANGTHAI = ?";
        $params[] = $status;
        $types .= "s";
    }

    $sql = "SELECT don_hang.*, khach_hang.HOTEN, khach_hang.DIACHI1, khach_hang.SDT 
            FROM don_hang 
            JOIN khach_hang ON don_hang.MAKH = khach_hang.MAKH";

    if (!empty($where)) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    // Nối trực tiếp LIMIT/OFFSET
    $sql .= " ORDER BY don_hang.NGAYLAP DESC LIMIT " . (int)$this->limit . " OFFSET " . (int)$offset;

    $this->data->select_prepare($sql, $types, ...$params);
    return $this->data->fetchAll();
}
    public function setLimit($limit) {
        $this->limit = $limit;
    }
    public function __destruct() {
        $this->data->close();
    }  
}
?>