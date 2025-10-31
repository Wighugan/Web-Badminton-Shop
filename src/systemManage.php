<?php
session_start();
require_once 'database/connect.php';
class QuanLyHeThong {
    protected $data;

    public function __construct() {
        $this->data = new Database();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Xử lý upload ảnh đại diện
    public function xulyanh($file) {
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/avatars/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $filename = uniqid() . '_' . basename($file['name']);
            $targetPath = $uploadDir . $filename;
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                return $targetPath;
            }
        }
        return 'uploads/avatars/default.png';
    }

    // Đăng ký
    public function dangky($TENKH, $HOTEN, $EMAIL, $DIACHI, $DIACHI1, $DIACHI2, $MAKHAU, $SDT, $birthday, $AVATAR) {
    try {
        // ✅ Kiểm tra tên đăng nhập hoặc email đã tồn tại chưa
        $sqlCheck = "SELECT MAKH FROM khach_hang WHERE TENKH = ? OR EMAIL = ?";
        $this->data->select_prepare($sqlCheck, "ss", $TENKH, $EMAIL);

        if ($this->data->numRows() > 0) {
            $_SESSION["error"] = "Tên đăng nhập hoặc email đã tồn tại!";
            header("Location: Signup.php");
            exit();
        }

        // ✅ Xử lý ảnh đại diện (trả về đường dẫn ảnh hoặc ảnh mặc định)
        $avatarPath = $this->xulyAnh($AVATAR);

        // ✅ Mã hoá mật khẩu trước khi lưu

        // ✅ Câu lệnh thêm dữ liệu vào bảng khach_hang
        $sqlInsert = "INSERT INTO khach_hang (AVATAR, TENKH, HOTEN, EMAIL, DIACHI1, NS, MATKHAU, SDT, DIACHI, TP) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $result = $this->data->command_prepare($sqlInsert, "ssssssssss",
            $avatarPath, $TENKH, $HOTEN, $EMAIL, $DIACHI1, $birthday, $MAKHAU, $SDT, $DIACHI, $DIACHI2
        );

        if ($result) {
            $_SESSION["success"] = "Đăng ký thành công! Vui lòng đăng nhập.";
            header("Location: Signin.php");
            exit();
        } else {
            throw new Exception("Không thể thêm tài khoản. Vui lòng thử lại!");
        }

    } catch (Exception $e) {
        $_SESSION["error"] = "Lỗi: " . $e->getMessage();
        header("Location: Signup.php");
        exit();
    }
}



    // Đăng nhập
   public function dangnhap($TENKH, $MAKHAU) {
    $sql = "SELECT MAKH, TENKH, MATKHAU FROM khach_hang WHERE TENKH = ?";
    $this->data->select_prepare($sql, "s", $TENKH);
    $row = $this->data->fetch();
    if ($row) {
        if ($MAKHAU === $row['MATKHAU']) { // chưa mã hóa
            $_SESSION['user_id'] = $row['MAKH'];
            $_SESSION['username'] = $row['TENKH'];

            // ✅ chuyển đúng đến trang chính
            header("Location: login.php");
            exit();
        } else {
            return "Mật khẩu không đúng!";
        }
    } else {
        return "Tên đăng nhập không tồn tại!";
    }
}
    // Đăng xuất
    public function dangxuat(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'] ?? false, $params['httponly'] ?? false
            );
        }
        session_destroy();
    }

    // Kiểm tra trạng thái đăng nhập
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function __destruct() {
        $this->data->close();
    }
}
?>
