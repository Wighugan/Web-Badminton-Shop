<?php
class User {
    protected $db;
    private $limit = 5;
    protected $table;
    protected $columns;

    public function __construct($database, $table = 'khach_hang') {
        $this->db = $database;
        $this->table = $table;

        // ✅ Cấu hình các cột tương ứng từng bảng
        switch ($table) {
            case 'nhan_vien':
                $this->columns = [
                    'id' => 'MANV',
                    'avatar' => 'AVATAR',
                    'name' => 'TENNV',
                    'fullname' => 'HOTEN',
                    'email' => 'EMAIL',
                    'dob' => 'NS',
                    'date' => 'NGAYLAM',
                    'phone' => 'SDT',
                    'status' => 'TRANGTHAI'
                ];
                break;

            case 'ncc':
            case 'ncc':
                $this->columns = [
                    'id' => 'MANCC',
                    'avatar' => 'AVATAR',
                    'fullname' => 'TENNCC',
                    'email' => 'EMAIL',
                    'address' => 'DIACHI',
                    'phone' => 'SDT',
                    'date' => 'NGAYHT',
                    'status' => 'TRANGTHAI',
                    'nguoi_dd' => 'NGUOIDD'
                ];
                break;

            default: // khách hàng
                $this->columns = [
                    'id' => 'MAKH',
                    'avatar' => 'AVATAR',
                    'name' => 'TENKH',
                    'fullname' => 'HOTEN',
                    'email' => 'EMAIL',
                    'address' => 'DIACHI',
                    'dob' => 'NS',
                    'password' => 'MATKHAU',
                    'phone' => 'SDT',
                    'address2' => 'DIACHI1',
                    'status' => 'TRANGTHAI'
                ];
                break;
        }
    }

    // ============================
    // 1️⃣ LẤY DANH SÁCH
    // ============================
     public function getUsers($page = 1, $search = '', $district = '') {
        $offset = ($page - 1) * $this->limit;

        $cols = implode(', ', $this->columns);
        $sql = "SELECT {$cols} FROM {$this->table} WHERE 1";
        $params = [];
        $types = "";

        if (!empty($search)) {
            $sql .= " AND ({$this->columns['fullname']} LIKE ? OR {$this->columns['email']} LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $types .= "ss";
        }

        if (!empty($district)) {
            $sql .= " AND {$this->columns['address']} LIKE ?";
            $params[] = "%$district%";
            $types .= "s";
        }

        $sql .= " ORDER BY {$this->columns['id']} ASC LIMIT ? OFFSET ?";
        $params[] = $this->limit;
        $params[] = $offset;
        $types .= "ii";

        $this->db->select_prepare($sql, $types, ...$params);
        return $this->db->fetchAll() ?? [];
    }

    // ============================
    // 2️⃣ ĐẾM TỔNG SỐ
    // ============================
    public function countUsers($search = '') {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table}";
        $params = [];
        $types = "";

        if (!empty($search)) {
            $searchCols = array_filter($this->columns, fn($c) => $c !== $this->columns['id']);
            $whereParts = array_map(fn($c) => "$c LIKE ?", $searchCols);
            $sql .= " WHERE " . implode(' OR ', $whereParts);

            foreach ($searchCols as $_) {
                $params[] = "%$search%";
                $types .= "s";
            }
        }

        if (!empty($params)) {
            $this->db->select_prepare($sql, $types, ...$params);
        } else {
            $this->db->select($sql);
        }

        $row = $this->db->fetch();
        return $row['total'] ?? 0;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function close() {
        $this->db->close();
    }
}
?>
