<?php
class ThongKe {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    // =======================================================
    // 1️⃣ Thống kê danh sách khách hàng (tìm kiếm + lọc ngày + phân trang)
    // =======================================================
    public function getCustomers($search = '', $start = '', $end = '', $page = 1, $limit = 5) {
        $offset = ($page - 1) * $limit;
        $where = "1";
        $params = [];
        $types = "";

        // Tìm kiếm theo tên khách hàng
        if (!empty($search)) {
            $where .= " AND khach_hang.HOTEN LIKE ?";
            $params[] = "%$search%";
            $types .= "s";
        }

        // Lọc theo ngày lập đơn hàng
        if (!empty($start) && !empty($end)) {
            $where .= " AND don_hang.NGAYLAP BETWEEN ? AND ?";
            $params[] = $start . " 00:00:00";
            $params[] = $end . " 23:59:59";
            $types .= "ss";
        }

        // Đếm tổng khách hàng
        $sql_count = "SELECT COUNT(DISTINCT khach_hang.MAKH) AS total
                      FROM khach_hang
                      LEFT JOIN don_hang ON khach_hang.MAKH = don_hang.MAKH
                      WHERE $where";
        $this->db->select_prepare($sql_count, $types, ...$params);
        $row = $this->db->fetch();
        $total_users = $row['total'] ?? 0;
        $total_pages = ceil($total_users / $limit);

        // Lấy danh sách khách hàng kèm số đơn hàng và tổng tiền
        $sql_data = "SELECT 
                        khach_hang.MAKH AS makh,
                        khach_hang.HOTEN AS tenkh,
                        COUNT(don_hang.MADH) AS sohoadon,
                        SUM(don_hang.TONGTIEN) AS tongtien
                     FROM khach_hang
                     LEFT JOIN don_hang ON khach_hang.MAKH = don_hang.MAKH
                     WHERE $where
                     GROUP BY khach_hang.MAKH, khach_hang.HOTEN
                     ORDER BY tongtien DESC
                     LIMIT ? OFFSET ?";
        $params_with_limit = array_merge($params, [$limit, $offset]);
        $this->db->select_prepare($sql_data, $types . "ii", ...$params_with_limit);

        $data = [];
        while ($row = $this->db->fetch()) {
            $data[] = $row;
        }

        return [
            'data' => $data,
            'total_users' => $total_users,
            'total_pages' => $total_pages,
            'page' => $page,
            'limit' => $limit
        ];
    }

    // =======================================================
    // 2️⃣ Thống kê TOP khách hàng theo tổng tiền
    // =======================================================
    public function getTopCustomers($limit = 5) {
        $sql = "SELECT 
                    khach_hang.MAKH AS makh,
                    khach_hang.HOTEN AS tenkh,
                    COUNT(don_hang.MADH) AS sohoadon,
                    SUM(don_hang.TONGTIEN) AS tongtien
                FROM khach_hang
                LEFT JOIN don_hang ON khach_hang.MAKH = don_hang.MAKH
                GROUP BY khach_hang.MAKH, khach_hang.HOTEN
                ORDER BY tongtien DESC
                LIMIT ?";
        $this->db->select_prepare($sql, "i", $limit);

        $result = [];
        while ($row = $this->db->fetch()) {
            $result[] = $row;
        }

        return $result;
    }

    // =======================================================
    // 3️⃣ Thống kê sản phẩm bán chạy từ bảng chi tiết đơn hàng (ctdh)
    // =======================================================
    public function getTopProducts($limit = 5) {
        $sql = "SELECT 
                    TENSP,
                    SUM(SOLUONG) AS tongban,
                    SUM(THANHTIEN) AS doanhthu
                FROM ctdh
                GROUP BY TENSP
                ORDER BY tongban DESC
                LIMIT ?";
        $this->db->select_prepare($sql, "i", $limit);

        $result = [];
        while ($row = $this->db->fetch()) {
            $result[] = $row;
        }

        return $result;
    }

    // =======================================================
    // 4️⃣ Thống kê doanh thu theo tháng
    // =======================================================
    public function getRevenueByMonth() {
        $sql = "SELECT 
                    DATE_FORMAT(NGAYLAP, '%Y-%m') AS thang,
                    SUM(TONGTIEN) AS doanhthu
                FROM don_hang
                GROUP BY thang
                ORDER BY thang ASC";
        $this->db->select($sql);

        $data = [];
        while ($row = $this->db->fetch()) {
            $data[] = $row;
        }

        return $data;
    }
}
?>
