<?php
class Order {
    private $db;
    private $limit = 10;

    public function __construct($database) {
        $this->db = $database;
    }

    /* ============================
       1️⃣ DANH SÁCH ĐƠN HÀNG
    ============================ */
    public function getOrders($page = 1, $search = '', $start_date = '', $end_date = '', $address = '', $status = '') {
        $offset = ($page - 1) * $this->limit;
        $where = [];
        $params = [];
        $types = "";

        // 🔍 Tìm kiếm theo mã đơn, mã KH hoặc tên KH
        if (!empty($search)) {
            $where[] = "(don_hang.MADH LIKE ? OR don_hang.MAKH LIKE ? OR khach_hang.HOTEN LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $types .= "sss";
        }

        // 📅 Lọc theo ngày lập
        if (!empty($start_date) && !empty($end_date)) {
            $where[] = "DATE(don_hang.NGAYLAP) BETWEEN ? AND ?";
            $params[] = $start_date;
            $params[] = $end_date;
            $types .= "ss";
        }

        // 🏠 Lọc theo địa chỉ giao hàng
        if (!empty($address)) {
            $where[] = "khach_hang.DIACHI1 LIKE ?";
            $params[] = "%$address%";
            $types .= "s";
        }

        // 🚚 Lọc theo trạng thái đơn hàng
        if (!empty($status)) {
            $where[] = "don_hang.TRANGTHAI = ?";
            $params[] = $status;
            $types .= "s";
        }

        // ✅ Câu truy vấn danh sách đơn
        $sql = "SELECT don_hang.MADH, don_hang.CODE, don_hang.MAKH, don_hang.TONGTIEN,
                       don_hang.TRANGTHAI, don_hang.NGAYLAP,
                       khach_hang.HOTEN, khach_hang.SDT, khach_hang.DIACHI1
                FROM don_hang
                JOIN khach_hang ON don_hang.MAKH = khach_hang.MAKH";

        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY don_hang.NGAYLAP DESC LIMIT ? OFFSET ?";
        $params[] = $this->limit;
        $params[] = $offset;
        $types .= "ii";

        $this->db->select_prepare($sql, $types, ...$params);
        return $this->db->fetchAll() ?? [];
    }

    /* ============================
       2️⃣ ĐẾM TỔNG SỐ ĐƠN HÀNG
    ============================ */
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

        $this->db->select_prepare($sql, $types, ...$params);
        $row = $this->db->fetch();
        return $row['total'] ?? 0;
    }

    public function getLimit() {
        return $this->limit;
    }

    /* ============================
       3️⃣ CHI TIẾT ĐƠN HÀNG
    ============================ */
    public function getOrderInfo($order_id) {
        $sql = "SELECT don_hang.*, khach_hang.HOTEN, khach_hang.SDT, khach_hang.DIACHI1
                FROM don_hang
                JOIN khach_hang ON don_hang.MAKH = khach_hang.MAKH
                WHERE don_hang.MADH = ?";
        $this->db->select_prepare($sql, "i", $order_id);
        $result = $this->db->fetchAll();
        return $result ? $result[0] : null;
    }

   public function getOrderDetails($order_id) {
    $sql = "SELECT 
                ctdh.MASP,
                san_pham.TENSP,
                san_pham.IMAGE,
                ctdh.SOLUONG,
                ctdh.DONGIA,
                (ctdh.SOLUONG * ctdh.DONGIA) AS THANHTIEN
            FROM ctdh
            JOIN san_pham ON ctdh.MASP = san_pham.MASP
            WHERE ctdh.MADH = ?";
    $this->db->select_prepare($sql, "i", $order_id);
    return $this->db->fetchAll() ?? [];
}


    /* ============================
       4️⃣ CẬP NHẬT TRẠNG THÁI
    ============================ */
    public function updateStatus($order_id, $new_status) {
        $sql = "UPDATE don_hang SET TRANGTHAI = ? WHERE MADH = ?";
        $this->db->select_prepare($sql, "si", $new_status, $order_id);
        return $this->db->execute();
    }

    /* ============================
       5️⃣ THỐNG KÊ KHÁCH HÀNG
    ============================ */
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

        $this->db->select_prepare($sql, $types, ...$params);
        return $this->db->fetchAll();
    }

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

        $this->db->select_prepare($sql, $types, ...$params);
        $row = $this->db->fetch();
        return $row['total'] ?? 0;
    }
}
?>
