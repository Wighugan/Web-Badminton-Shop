<?php
require_once __DIR__ . '/systemManage.php';

class QuanLyKhachHang extends QuanLyHeThong {
    protected $data;
    private $MAKH;
    private $AVATAR;
    private $HOTEN;
    private $EMAIL;
    private $DIACHI;
    private $NS;
    private $MATKHAU;
    private $SDT;
    private $DIACHI1;
    private $TRANGTHAI;
    private $limit = 3;
    public function __construct() {
        $this->data = new Database();
    }
// lấy danh sách người dùng
   public function getUsers($page, $search, $district)
{
    $page = (int)$page;
    if ($page < 1) { $page = 1; }

    $limit  = $this->limit ?? 10;
    if ($limit < 1) { $limit = 10; }
    $offset = ($page - 1) * $limit;

    $cols = implode(', ', [
        'MAKH', 'AVATAR', 'TENKH', 'HOTEN', 'EMAIL', 'DIACHI', 'NS', 'SDT', 'DIACHI1', 'TRANGTHAI', 'TP'
    ]);

    $sql    = "SELECT {$cols} FROM khach_hang WHERE 1";
    $params = [];
    $types  = "";
    
    // Tìm kiếm theo text
    if (!empty($search)) {
        $searchCols = ['TENKH', 'HOTEN', 'EMAIL', 'DIACHI', 'SDT'];
        $whereParts = array_map(fn($c) => "$c LIKE ?", $searchCols);
        $sql       .= " AND (" . implode(' OR ', $whereParts) . ")";
        foreach ($searchCols as $_) {
            $params[] = "%{$search}%";
            $types   .= "s";
        }
    }
    
    // Tìm kiếm theo quận/huyện
    if (!empty($district)) {
        $sql     .= " AND DIACHI = ?";
        $params[] = $district;
        $types   .= "s";
    }
    
    $sql .= " ORDER BY MAKH DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    $types   .= "ii";
    
    $this->data->select_prepare($sql, $types, ...$params);
    return $this->data->fetchAll() ?? [];
}
// đếm số người dùng 
    public function countUsers(string $search = '', string $district = ''): int
{
    $sql    = "SELECT COUNT(*) AS total FROM khach_hang WHERE 1";
    $params = [];
    $types  = "";

    if ($search !== '') {
        $searchCols = ['TENKH', 'HOTEN', 'EMAIL', 'DIACHI', 'SDT'];
        $whereParts = array_map(fn($c) => "$c LIKE ?", $searchCols);
        $sql       .= " AND (" . implode(' OR ', $whereParts) . ")";
        foreach ($searchCols as $_) {
            $params[] = "%{$search}%";
            $types   .= "s";
        }
    }

    if ($district !== '') {
        $sql     .= " AND TP = ?";
        $params[] = $district;
        $types   .= "s";
    }

    $this->data->select_prepare($sql, $types, ...$params);
    $result = $this->data->fetch();
    return $result ? (int)$result['total'] : 0;
}
    public function getLimit() {
        return $this->limit;
    }
//câp nhật thông tin khách hàng
      public function CapNhatThongTin($MAKH, $TENKH, $HOTEN, $EMAIL, $DIACHI, $DIACHI1, $TP, $MATKHAU, $SDT, $NS, $AVATAR)
{
    try {
        $check_sql = "SELECT MAKH FROM khach_hang WHERE MAKH = ?";
        $this->data->select_prepare($check_sql, "i", $MAKH);
        $exists = $this->data->fetch();
        if (!$exists) {
            return ['success' => false, 'message' => '❌ Khách hàng không tồn tại!'];
        }    
        $avatarPath = $AVATAR;
            if (isset($_FILES['AVATAR']) && $_FILES['AVATAR']['error'] === 0) {
            $fileName = time() . "_" . basename($_FILES['AVATAR']['name']);
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/Web-Badminton-Shop/uploads/avatar/";
            
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fullPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['AVATAR']['tmp_name'], $fullPath)) {
                $avatarPath = "uploads/avatar/" . $fileName;
            } else {
                return ['success' => false, 'message' => '❌ Upload file thất bại!'];
            }
        }        
        $set_clauses = [];
        $params = [];
        $types = "";
        if ($TENKH !== null && $TENKH !== '') {
            $set_clauses[] = "TENKH = ?";
            $params[] = $TENKH;
            $types .= "s";
        }
        if ($HOTEN !== null && $HOTEN !== '') {
            $set_clauses[] = "HOTEN = ?";
            $params[] = $HOTEN;
            $types .= "s";
        }
        
        if ($EMAIL !== null && $EMAIL !== '') {
            $set_clauses[] = "EMAIL = ?";
            $params[] = $EMAIL;
            $types .= "s";
        }
        
        if ($DIACHI !== null && $DIACHI !== '') {
            $set_clauses[] = "DIACHI = ?";
            $params[] = $DIACHI;
            $types .= "s";
        }
        
        if ($DIACHI1 !== null && $DIACHI1 !== '') {
            $set_clauses[] = "DIACHI1 = ?";
            $params[] = $DIACHI1;
            $types .= "s";
        }       
        if ($TP !== null && $TP !== '') {
            $set_clauses[] = "TP = ?";
            $params[] = $TP;
            $types .= "s";
        }       
        if ($SDT !== null && $SDT !== '') {
            // Validate số điện thoại
            $set_clauses[] = "SDT = ?";
            $params[] = $SDT;
            $types .= "s";
        }       
        if ($NS !== null && $NS !== '') {
            $set_clauses[] = "NS = ?";
            $params[] = $NS;
            $types .= "s";
        }      
        if ($MATKHAU !== null && $MATKHAU !== '') {
            // ✅ Hash password trước khi lưu
            $set_clauses[] = "MATKHAU = ?";
            $params[] = $MATKHAU;
            $types .= "s";
        }       
        // ✅ Xử lý upload avatar
        if (isset($_FILES['AVATAR']) && $_FILES['AVATAR']['error'] === 0) {
            $set_clauses[] = "AVATAR = ?";
            $params[] = $avatarPath;
            $types .= "s";
        }     
        if (empty($set_clauses)) {
            return ['success' => false, 'message' => '❌ Không có trường nào để cập nhật!'];
        }  
        $params[] = $MAKH;
        $types .= "i";  
        $sql = "UPDATE khach_hang SET " . implode(", ", $set_clauses) . " WHERE MAKH = ?";     
        $this->data->command_prepare($sql, $types, ...$params);
        $result = $this->data->execute();      
    } catch (Exception $e) {
        return ['success' => false, 'message' => '❌ Lỗi: ' . $e->getMessage()];
    }
}
// xem lịch sử mua hàng
    public function XemLichSuMuaHang($MAKH, $limit, $offset) {
        $sql = "SELECT dh.*, kh.HOTEN, kh.SDT 
                FROM don_hang dh
                JOIN khach_hang kh ON dh.MAKH = kh.MAKH 
                WHERE dh.MAKH = ? 
                ORDER BY dh.NGAYLAP DESC 
                LIMIT ? OFFSET ?";
        $this->data->select_prepare($sql, "iii", $MAKH, $limit, $offset);
        return $this->data->fetchAll();
    }

    public function layThongTinUser($MAKH) {
        $sql = "SELECT * FROM khach_hang WHERE MAKH = ?";
        $this->data->select_prepare($sql, "i", $MAKH);
        return $this->data->fetch();
    }
// Thêm người dùng
    public function addAccount($HOTEN, $EMAIL, $DIACHI, $NS, $MATKHAU, $SDT, $DIACHI1, $TENKH,$AVATAR) {
    try {
        // ✅ Validate dữ liệu
        if (empty($HOTEN) || empty($EMAIL) || empty($MATKHAU) || empty($SDT) || empty($TENKH)) {
            return ['success' => false, 'message' => '❌ Vui lòng nhập đầy đủ thông tin!'];
        }
        // ✅ Kiểm tra tên đăng nhập đã tồn tại
        $check_sql = "SELECT MAKH FROM khach_hang WHERE TENKH = ?";
        $this->data->select_prepare($check_sql, "s", $TENKH);
        if ($this->data->fetch()) {
            return ['success' => false, 'message' => '❌ Tên đăng nhập này đã tồn tại!'];
        }
        $avatarPath = $AVATAR;
        // ✅ Xử lý upload avatar nếu có file
        if (isset($_FILES['AVATAR']) && $_FILES['AVATAR']['error'] === 0) {     
            $fileName = time() . "_" . basename($_FILES['AVATAR']['name']);
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/Web-Badminton-Shop/uploads/avatar/";          
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fullPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['AVATAR']['tmp_name'], $fullPath)) {
                $avatarPath = "uploads/avatar/" . $fileName;
            } else {
                return ['success' => false, 'message' => '❌ Upload file thất bại!'];
            }
        }
        // ✅ Insert vào database - 9 cột, 9 dấu ?
        $sql = "INSERT INTO khach_hang (HOTEN, EMAIL, DIACHI, NS, MATKHAU, SDT, DIACHI1, TENKH, AVATAR) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->data->command_prepare($sql, 'sssssssss', $HOTEN, $EMAIL, $DIACHI, $NS, $MATKHAU, $SDT, $DIACHI1, $TENKH, $avatarPath);
        $this->data->execute();
    } catch (Exception $e) {
        return ['success' => false, 'message' => '❌ Lỗi: ' . $e->getMessage()];
    }
}
// xóa người dùng
      public function xoaNguoiDung($MAKH) {
        try {
            $sql = "DELETE FROM khach_hang WHERE MAKH = ?";
            $this->data->command_prepare($sql, 'i', $MAKH);

            if ($this->data->execute()) {
                echo "<script>alert('✅ Đã xóa khách hàng thành công!'); window.location.href='quanlykhachhang.php';</script>";
            } else {
                echo "<script>alert('❌ Lỗi khi xóa khách hàng hoặc khách hàng không tồn tại!'); window.history.back();</script>";
            }
        } catch (Exception $e) {
            echo "<script>alert('Lỗi: {$e->getMessage()}'); window.history.back();</script>";
        }
    }
// khóa tài khoản người dùng
   public function khoaTaiKhoan($MAKH) {
    try {
        $sql = "UPDATE khach_hang SET TRANGTHAI = 0 WHERE MAKH = ?";
        $this->data->command_prepare($sql, 'i', $MAKH);
        return $this->data->execute();
    } catch (Exception $e) {
        return false;
    }
}

public function moKhoaTaiKhoan($MAKH) {
    try {
        $sql = "UPDATE khach_hang SET TRANGTHAI = 1 WHERE MAKH = ?";
        $this->data->command_prepare($sql, 'i', $MAKH);
        return $this->data->execute();
    } catch (Exception $e) {
        return false;
    }
}

    public function __destruct() {
        $this->data->close();
    }
}
?>
