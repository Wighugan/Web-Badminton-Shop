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
    public function __construct(Database $data) {
        parent::__construct();
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
     public function CapNhatThongTin($MAKH, $TENKH, $HOTEN, $EMAIL, $DIACHI, $DIACHI1, $TP, $MATKHAU, $SDT, $NS,$AVATAR)
{
    try {
        // 1. Kiểm tra khách hàng có tồn tại
        $this->data->select_prepare("SELECT * FROM khach_hang WHERE MAKH = ?", "i", $MAKH);
        $old = $this->data->fetch();
        if (!$old) {
            return ['success' => false, 'message' => '❌ Khách hàng không tồn tại!'];
        }
        // 2. Chuẩn bị cập nhật
        $set = [];
        $params = [];
        $types = "";
        $fields = [
            "TENKH"  => $TENKH,
            "HOTEN"  => $HOTEN,
            "EMAIL"  => $EMAIL,
            "DIACHI" => $DIACHI,
            "DIACHI1" => $DIACHI1,
            "TP" => $TP,
            "SDT" => $SDT,
            "NS" => $NS
        ];
        foreach ($fields as $column => $value) {
            if ($value !== null && $value !== "") {
                $set[] = "$column = ?";
                $params[] = $value;
                $types .= "s";
            }
        }
        if (!empty($MATKHAU)) {
            $set[] = "MATKHAU = ?";
            $params[] = $MATKHAU;
            $types .= "s";
        }
        // 4. Upload Avatar nếu có
        if ($AVATAR && $AVATAR['error'] == 0) {
    $allowExt = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($AVATAR['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowExt)) {
        return ['success' => false, 'message' => '❌ Chỉ cho phép ảnh JPG, PNG, WEBP'];
    }
    $fileName = time() . "_" . $MAKH . "." . $ext;
    $uploadDir = __DIR__ . "/../uploads/avatar/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $fullPath = $uploadDir . $fileName;

    if (!move_uploaded_file($AVATAR['tmp_name'], $fullPath)) {
        return ['success' => false, 'message' => '❌ Upload avatar thất bại!'];
    }

    // Lưu link avatar vào DB
    $avatarPath = "uploads/avatar/" . $fileName;
    $set[] = "AVATAR = ?";
    $params[] = $avatarPath;
    $types .= "s";
}
        // 5. Không có gì để cập nhật
        if (empty($set)) {
            return ['success' => false, 'message' => '❌ Không có dữ liệu để cập nhật!'];
        }
        // 6. Thực thi UPDATE
        $params[] = $MAKH;
        $types .= "i";
        $sql = "UPDATE khach_hang SET " . implode(", ", $set) . " WHERE MAKH = ?";
        $ok = $this->data->command_prepare($sql, $types, ...$params);
        if ($ok) {
            return ['success' => true, 'message' => '✔ Cập nhật thông tin thành công!'];
        } else {
            return ['success' => false, 'message' => '❌ Không thể cập nhật thông tin!'];
        }
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
            $sql = "DELETE FROM khach_hang WHERE MAKH = ?";
            $this->data->command_prepare($sql, 'i', $MAKH);

            if ($this->data->execute()) {
                echo "<script>window.location.href='quanlykhachhang.php';</script>";
            } else {
                echo "<script>window.history.back();</script>";
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
        
    }
}
?>
