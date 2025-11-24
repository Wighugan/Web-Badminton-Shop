<?php
require_once __DIR__ . '/systemManage.php';
class nhanvien extends QuanLyHeThong {
    protected $data;
    private $limit = 10;
    private $MANV;
    private $TENNV;  
    private $HOTEN; 
    private $SDT;
    private $EMAIL;
    private $AVATAR;
    private $NGAYLAM;
    private $NS;
    private $search;
    private $page;
    private $district;
    public function __construct() {
        $this->MANV;
        $this->TENNV;
        $this->HOTEN;
        $this->EMAIL;
        $this->limit;
        $this->AVATAR;
        $this->NGAYLAM;
        $this->SDT;
        $this->NS;
        $this->page;
        $this->search;
        $this->district;
        $this->data =  new Database();

    }
    public function getNhanvienById($MANV) {
        $sql = "SELECT * FROM nhan_vien WHERE MANV = ?";
        $this->data->select_prepare($sql, "i", $MANV);
        return $this->data->fetch();
    }
public function updateNhanvien($MANV, $TENNV,$HOTEN, $SDT, $EMAIL, $AVATAR, $NGAYLAM, $NS)
{
    try {
        // ✅ Kiểm tra nhân viên tồn tại ĐẦU TIÊN
        $check_sql = "SELECT MANV FROM nhan_vien WHERE MANV = ?";
        $this->data->select_prepare($check_sql, "i", $MANV);
        $exists = $this->data->fetch();
        if (!$exists) {
            return ['success' => false, 'message' => '❌ Nhân viên không tồn tại!'];
        }
        $avatarPath = $AVATAR;
if (isset($_FILES['AVATAR']) && $_FILES['AVATAR']['error'] === 0) {
    $fileName = time() . "_" . basename($_FILES['AVATAR']['name']);
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/Web-Badminton-Shop/uploads/avatar/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $fullPath = $uploadDir . $fileName;
    // ✅ Thêm dòng này - di chuyển file từ temp lên server
    if (move_uploaded_file($_FILES['AVATAR']['tmp_name'], $fullPath)) {
        $avatarPath = "uploads/avatar/" . $fileName;
    } else {
        return ['success' => false, 'message' => '❌ Upload file thất bại!'];
    }
}
        $set_clauses = [];
        $params = [];
        $types = "";       
        if ($TENNV !== null && $TENNV !== '') {
            $set_clauses[] = "TENNV = ?";
            $params[] = $TENNV;
            $types .= "s";
        }
        if ($HOTEN!== null && $HOTEN !== '') {
            $set_clauses[] = "HOTEN = ?";
            $params[] = $HOTEN;
            $types .= "s";
        }
        if ($SDT !== null && $SDT !== '') {
            $set_clauses[] = "SDT = ?";
            $params[] = $SDT;
            $types .= "s";
        }   
        if ($EMAIL !== null && $EMAIL !== '') {
            $set_clauses[] = "EMAIL = ?";
            $params[] = $EMAIL;
            $types .= "s";
        } 
        // ✅ Kiểm tra upload file, không kiểm tra tham số $AVATAR
        if (isset($_FILES['AVATAR']) && $_FILES['AVATAR']['error'] === 0) {
            $set_clauses[] = "AVATAR = ?";
            $params[] = $avatarPath;
            $types .= "s";
        }
        if ($NGAYLAM !== null && $NGAYLAM !== '') {
            $set_clauses[] = "NGAYLAM = ?";
            $params[] = $NGAYLAM;
            $types .= "s";
        }
        if ($NS !== null && $NS !== '') {
            $set_clauses[] = "NS = ?";
            $params[] = $NS;
            $types .= "s";
        }       
        $params[] = $MANV;
        $types .= "i";       
        $sql = "UPDATE nhan_vien SET " . implode(", ", $set_clauses) . " WHERE MANV = ?";        
        $this->data->command_prepare($sql, $types, ...$params);
        $result = $this->data->execute();
        
        if ($result) {
            return ['success' => true, 'message' => '✅ Cập nhật thành công!'];
        } else {
            return ['success' => false, 'message' => '❌ Cập nhật thất bại!'];
        }
        
    } catch (Exception $e) {
        return ['success' => false, 'message' => '❌ Lỗi: ' . $e->getMessage()];
    }
}
    public function addNhanvien($TENNV,$HOTEN ,$SDT, $EMAIL, $AVATAR, $NGAYLAM,$NS) {
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
            return false;
        }
    }
        $sql = "INSERT INTO nhan_vien(TENNV,HOTEN,SDT,EMAIL,AVATAR,NGAYLAM,NS) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $this->data->command_prepare($sql, "sssssss", $TENNV,$HOTEN ,$SDT, $EMAIL, $avatarPath,$NGAYLAM,$NS);
        return $this->data->execute();
    }
    public function xoaNhanVien($MANV) {
    try {
        $sql = "DELETE FROM nhan_vien WHERE MANV = ?";
        $this->data->command_prepare($sql, 'i', $MANV);

        if ($this->data->execute()) {
            return ['success' => true, 'message' => '✅ Đã xóa nhân viên thành công!'];
        } else {
            return ['success' => false, 'message' => '❌ Lỗi khi xóa nhân viên hoặc nhân viên không tồn tại!'];
        }
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
    }
}

    public function getnhanvienList($page, $search) {
        // Implement logic to get the list of employees
        $sql = "SELECT * FROM nhan_vien WHERE 1=1";
        $params = [];
        if ($search) {
            $sql .= " AND (TENNV LIKE ? OR SDT LIKE ? OR EMAIL LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";   
        }
        $sql .= " LIMIT ?, ?";
        $params[] = ($page - 1) * 10;
        $params[] = 10;
        $this->data->select_prepare($sql, str_repeat("s", count($params) - 2) . "ii", ...$params);
        return $this->data->fetchAll();
}
    public function countnhanvien($search, $district) {
        $sql = "SELECT COUNT(*) as total FROM nhan_vien WHERE 1=1";
        $params = [];
        if ($search) {
            $sql .= " AND (TENNV LIKE ? OR SDT LIKE ? OR EMAIL LIKE ?)";   
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        $this->data->select_prepare($sql, str_repeat("s", count($params)), ...$params);
        $row = $this->data->fetch();    
        return $row['total'] ?? 0;
    }
    public function getLimit() {
        return $this->limit;
    }   
    public function __destruct() {
        $this->MANV;
        $this->TENNV;
        $this->HOTEN;
        $this->EMAIL;
        $this->limit;
        $this->AVATAR;
        $this->NGAYLAM;
        $this->SDT;
        $this->NS;
        $this->page;
        $this->search;
        $this->data;
    }
}
?>