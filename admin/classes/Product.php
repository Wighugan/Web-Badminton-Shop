<?php
class Product {
    private $db;
    private $limit = 5;

    public function __construct($database) {
        $this->db = $database;
    }

    // ==================================================
    // 1️⃣ LẤY DANH SÁCH SẢN PHẨM (phân trang, tìm kiếm, lọc theo loại)
    // ==================================================
    public function getProducts($page = 1, $search = '', $category = '') {
        $offset = ($page - 1) * $this->limit;
        $where = [];
        $params = [];
        $types = "";

        // Tìm kiếm theo tên hoặc mã sản phẩm
        if (!empty($search)) {
            $where[] = "(san_pham.TENSP LIKE ? OR san_pham.MASP LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $types .= "ss";
        }

        // Lọc theo loại sản phẩm
        if (!empty($category)) {
            $where[] = "san_pham.MALOAI = ?";
            $params[] = $category;
            $types .= "s";
        }

        // Câu truy vấn chính, có join với bảng loại sản phẩm
        $sql = "SELECT san_pham.*, loai_sp.TENLOAI 
                FROM san_pham
                LEFT JOIN loai_sp ON san_pham.MALOAI = loai_sp.MALOAI";

        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $sql .= " ORDER BY san_pham.updated_at DESC LIMIT ? OFFSET ?";
        $params[] = $this->limit;
        $params[] = $offset;
        $types .= "ii";

        $this->db->select_prepare($sql, $types, ...$params);
        return $this->db->fetchAll() ?? [];
    }

    // ==================================================
    // 2️⃣ ĐẾM TỔNG SỐ SẢN PHẨM
    // ==================================================
    public function countProducts($search = '', $category = '') {
        $where = [];
        $params = [];
        $types = "";

        if (!empty($search)) {
            $where[] = "(TENSP LIKE ? OR MASP LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $types .= "ss";
        }

        if (!empty($category)) {
            $where[] = "MALOAI = ?";
            $params[] = $category;
            $types .= "s";
        }

        $sql = "SELECT COUNT(*) AS total FROM san_pham";
        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        if (!empty($params)) {
            $this->db->select_prepare($sql, $types, ...$params);
        } else {
            $this->db->select($sql);
        }

        $row = $this->db->fetch();
        return $row['total'] ?? 0;
    }

    // ==================================================
    // 3️⃣ LẤY DANH SÁCH LOẠI SẢN PHẨM
    // ==================================================
    public function getCategories() {
        $sql = "SELECT MALOAI, TENLOAI FROM loai_sp ORDER BY TENLOAI ASC";
        $this->db->select($sql);
        return $this->db->fetchAll() ?? [];
    }

    // ==================================================
    // 4️⃣ LẤY SẢN PHẨM THEO MÃ (MASP)
    // ==================================================
    public function getProductById($masp) {
        $sql = "SELECT san_pham.*, loai_sp.TENLOAI 
                FROM san_pham 
                LEFT JOIN loai_sp ON san_pham.MALOAI = loai_sp.MALOAI 
                WHERE san_pham.MASP = ?";
        $this->db->select_prepare($sql, "s", $masp);
        return $this->db->fetch();
    }

    // ==================================================
    // 5️⃣ XÓA SẢN PHẨM
    // ==================================================
    public function deleteProduct($masp) {
        $sql = "DELETE FROM san_pham WHERE MASP = ?";
        return $this->db->execute_prepare($sql, "s", $masp);
    }

    // ==================================================
    // 6️⃣ LẤY GIỚI HẠN MỖI TRANG
    // ==================================================
    public function getLimit() {
        return $this->limit;
    }

    public function close() {
        $this->db->close();
    }
}
?>
