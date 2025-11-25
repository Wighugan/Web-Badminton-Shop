<?php
require_once __DIR__ . '/systemManage.php';

class Ncc extends QuanLyHeThong {
    protected $data;
    private $limit = 10;
    private $MANCC;
    private $TENNCC;
    private $DIACHI;
    private $SDT;
    private $EMAIL;
    private $AVATAR;
    private $TRANGTHAI;
    private $NGAYHT;
    private $NGUOIDD;

    public function __construct() {
        $this->data = new Database();
    }

    public function getNccById($MANCC) {
        $sql = "SELECT * FROM ncc WHERE MANCC = ?";
        $this->data->select_prepare($sql, "i", $MANCC);
        return $this->data->fetch();
    }

   public function updateNcc($MANCC, $TENNCC, $DIACHI, $SDT, $EMAIL, $AVATAR_FILE, $NGUOIDD) 
{
    try {
        // ✅ Kiểm tra nhà cung cấp tồn tại
        $check_sql = "SELECT * FROM ncc WHERE MANCC = ?";
        $this->data->select_prepare($check_sql, "i", $MANCC);
        $oldNcc = $this->data->fetch(); // ✅ Sửa: dùng fetch() thay vì execute()
        
        if (!$oldNcc) {
            return ['success' => false, 'message' => '❌ Nhà cung cấp không tồn tại!'];
        }
        
        $AVATAR = $oldNcc['AVATAR'];
        
        // ✅ Xử lý upload file nếu có file mới
        if (isset($AVATAR_FILE) && is_array($AVATAR_FILE) && 
            !empty($AVATAR_FILE['name']) && $AVATAR_FILE['error'] === UPLOAD_ERR_OK) {
            // Validate file
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 5 * 1024 * 1024; // 5MB
            if (!in_array($AVATAR_FILE['type'], $allowedTypes)) {
                return ['success' => false, 'message' => '❌ File không phải hình ảnh!'];
            }
            if ($AVATAR_FILE['size'] > $maxSize) {
                return ['success' => false, 'message' => '❌ File quá lớn (max 5MB)!'];
            }
            
            // ✅ Sửa: thêm folder ncc vào đường dẫn
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/Web-Badminton-Shop/uploads/";
            $public_path = "uploads/";
            
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $newName = time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/', '', basename($AVATAR_FILE['name']));
            $target_file = $upload_dir . $newName;
            
            if (move_uploaded_file($AVATAR_FILE['tmp_name'], $target_file)) {
                // ✅ Xoá file cũ nếu tồn tại
                if (!empty($oldNcc['AVATAR'])) {
                    $oldFilePath = $_SERVER['DOCUMENT_ROOT'] . "/Web-Badminton-Shop/" . $oldNcc['AVATAR'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $AVATAR = $public_path . $newName;
            } else {
                return ['success' => false, 'message' => '❌ Upload file thất bại!'];
            }
        }
        
        // ✅ Xây dựng câu UPDATE động
        $set = [];
        $params = [];
        $types = "";
        
        if (!empty($TENNCC)) {
            $set[] = "TENNCC = ?";
            $params[] = $TENNCC;
            $types .= "s";
        }
        
        if (!empty($DIACHI)) {
            $set[] = "DIACHI = ?";
            $params[] = $DIACHI;
            $types .= "s";
        }
        
        if (!empty($SDT)) {
            $set[] = "SDT = ?";
            $params[] = $SDT;
            $types .= "s";
        }
        
        if (!empty($EMAIL)) {
            $set[] = "EMAIL = ?";
            $params[] = $EMAIL;
            $types .= "s";
        }
        
        if (!empty($NGUOIDD)) {
            $set[] = "NGUOIDD = ?";
            $params[] = $NGUOIDD;
            $types .= "s";
        }
        
        // ✅ Luôn cập nhật AVATAR
        $set[] = "AVATAR = ?";
        $params[] = $AVATAR;
        $types .= "s";
        
        // ✅ Luôn cập nhật NGAYHT
        $set[] = "NGAYHT = NOW()";
        
        if (empty($set)) {
            return ['success' => false, 'message' => '❌ Không có trường nào để cập nhật!'];
        }
        
        // ✅ Thêm MANCC vào params cuối cùng
        $params[] = $MANCC;
        $types .= "i";
        
        $sql = "UPDATE ncc SET " . implode(", ", $set) . " WHERE MANCC = ?";
        
        // ✅ Thực thi query
        $this->data->command_prepare($sql, $types, ...$params);
        $ok = $this->data->execute();

        if ($ok) {
            return ['success' => true, 'message' => '✅ Cập nhật thành công!'];
        } else {
            return ['success' => false, 'message' => '❌ Cập nhật thất bại!', 'db_error' => $this->data->getLastError()];
        }
        
    } catch (Exception $e) {
        return ['success' => false, 'message' => '❌ Lỗi: ' . $e->getMessage()];
    }
}

    public function addNcc($TENNCC, $DIACHI, $SDT, $EMAIL, $AVATAR, $TRANGTHAI, $NGUOIDD) {
        // ✅ Validate dữ liệu bắt buộc
        if (empty($TENNCC) || empty($DIACHI) || empty($SDT) || empty($EMAIL) || empty($NGUOIDD)) {
            return ['success' => false, 'message' => '❌ Vui lòng nhập đầy đủ thông tin!'];
        }
        $avatarPath = $AVATAR;
        // ✅ Xử lý upload avatar nếu có file mới
        if (isset($_FILES['AVATAR']) && $_FILES['AVATAR']['error'] === 0) {
            // Validate file         
            $fileName = time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/', '', basename($_FILES['AVATAR']['name']));
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/Web-Badminton-Shop/uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fullPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['AVATAR']['tmp_name'], $fullPath)) {
                $avatarPath = "uploads/" . $fileName; // ✅ Đường dẫn đúng
            } else {
                return ['success' => false, 'message' => '❌ Upload file thất bại!'];
            }
        }
        $sql = "INSERT INTO ncc (TENNCC, DIACHI, SDT, EMAIL, AVATAR, TRANGTHAI, NGAYHT, NGUOIDD) 
                VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";
                $this->data->command_prepare($sql, "sssssss", $TENNCC, $DIACHI, $SDT, $EMAIL, $avatarPath, $TRANGTHAI, $NGUOIDD);
                $ok = $this->data->execute();
                if ($ok) {
                    return ['success' => true, 'message' => '✅ Thêm nhà cung cấp thành công!'];
                } else {
                    return ['success' => false, 'message' => '❌ Thêm nhà cung cấp thất bại!', 'db_error' => $this->data->getLastError()];
                }
}
    public function deleteNcc($MANCC) {
        try {
            $checkSql = "SELECT MANCC FROM ncc WHERE MANCC = ?";
            $this->data->select_prepare($checkSql, "i", $MANCC);
            $exists = $this->data->fetch();
            if (!$exists) {
                return ['success' => false, 'message' => '❌ Nhà cung cấp không tồn tại!'];
            }
            $sql = "DELETE FROM ncc WHERE MANCC = ?";
            $this->data->command_prepare($sql, "i", $MANCC);
            $ok = $this->data->execute();
            if ($ok) {
                return ['success' => true, 'message' => '✅ Đã xóa nhà cung cấp thành công!'];
            } else {
                return ['success' => false, 'message' => '❌ Lỗi khi xóa nhà cung cấp!', 'db_error' => $this->data->getLastError()];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
        }
    }
    // ===== Lấy danh sách NCC với tìm kiếm và phân trang =====
    public function getNccList($page, $search = '', $district = '') {
        try {
            $page = (int)$page;
            if ($page < 1) { $page = 1; }

            $limit = $this->limit ?? 10;
            if ($limit < 1) { $limit = 10; }
            $offset = ($page - 1) * $limit;

            // Cột cần lấy
            $cols = implode(', ', [
                'MANCC', 'TENNCC', 'DIACHI', 'SDT', 'EMAIL', 'AVATAR', 'TRANGTHAI', 'NGAYHT', 'NGUOIDD'
            ]);

            // Câu lệnh cơ bản
            $sql = "SELECT {$cols} FROM ncc WHERE 1=1";
            $params = [];
            $types = "";

            // Tìm kiếm theo text (TENNCC, DIACHI, SDT, EMAIL)
            if (!empty($search)) {
                $searchCols = ['TENNCC', 'DIACHI', 'SDT', 'EMAIL'];
                $whereParts = array_map(fn($c) => "$c LIKE ?", $searchCols);
                $sql .= " AND (" . implode(' OR ', $whereParts) . ")";
                
                foreach ($searchCols as $_) {
                    $params[] = "%{$search}%";
                    $types .= "s";
                }
            }

            // Tìm kiếm theo quận/huyện
            if (!empty($district)) {
                $sql .= " AND DIACHI LIKE ?";
                $params[] = "%{$district}%";
                $types .= "s";
            }

            // Sắp xếp và phân trang
            $sql .= " ORDER BY MANCC DESC LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;
            $types .= "ii";

            $this->data->select_prepare($sql, $types, ...$params);
            return $this->data->fetchAll() ?? [];

        } catch (Exception $e) {
            error_log("Lỗi getNccList: " . $e->getMessage());
            return [];
        }
    }

    // ===== Đếm tổng số NCC (cho phân trang) =====
    public function countNcc($search = '', $district = '') {
        try {
            $sql = "SELECT COUNT(*) AS total FROM ncc WHERE 1=1";
            $params = [];
            $types = "";

            // Tìm kiếm theo text
            if (!empty($search)) {
                $searchCols = ['TENNCC', 'DIACHI', 'SDT', 'EMAIL'];
                $whereParts = array_map(fn($c) => "$c LIKE ?", $searchCols);
                $sql .= " AND (" . implode(' OR ', $whereParts) . ")";
                
                foreach ($searchCols as $_) {
                    $params[] = "%{$search}%";
                    $types .= "s";
                }
            }

            // Tìm kiếm theo quận/huyện
            if (!empty($district)) {
                $sql .= " AND DIACHI LIKE ?";
                $params[] = "%{$district}%";
                $types .= "s";
            }

            $this->data->select_prepare($sql, $types, ...$params);
            $result = $this->data->fetch();
            return $result ? (int)$result['total'] : 0;

        } catch (Exception $e) {
            error_log("Lỗi countNcc: " . $e->getMessage());
            return 0;
        }
    }

    // ===== Khóa nhà cung cấp =====
    public function khoaNcc($MANCC) {
        try {
            $sql = "UPDATE ncc SET TRANGTHAI = 0 WHERE MANCC = ?";
            $this->data->command_prepare($sql, 'i', $MANCC);
            return $this->data->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    // ===== Mở khóa nhà cung cấp =====
    public function moKhoaNcc($MANCC) {
        try {
            $sql = "UPDATE ncc SET TRANGTHAI = 1 WHERE MANCC = ?";
            $this->data->command_prepare($sql, 'i', $MANCC);
            return $this->data->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getLimit() {
        return $this->limit;
    }

    public function __destruct() {
        $this->data->close();
    }
}
?>