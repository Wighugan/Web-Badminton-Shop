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

    // Xử lý upload ảnh đại diện (trả về đường dẫn ảnh hoặc ảnh mặc định)
    public function xulyAnh($file) {
        if ($file && isset($file['error']) && $file['error'] === UPLOAD_ERR_OK) {
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
        return 'uploads/user.jpg';
    }

    // Đăng ký
    public function dangky($TENKH, $HOTEN, $EMAIL, $DIACHI, $DIACHI1, $DIACHI2, $MAKHAU, $SDT, $birthday, $AVATAR) {
        try {
            // Kiểm tra tên đăng nhập hoặc email đã tồn tại
            $sqlCheck = "SELECT MAKH FROM khach_hang WHERE TENKH = ? OR EMAIL = ?";
            $this->data->select_prepare($sqlCheck, "ss", $TENKH, $EMAIL);

            if ($this->data->numRows() > 0) {
                $_SESSION["error"] = "Tên đăng nhập hoặc email đã tồn tại!";
                header("Location: Signup.php");
                exit();
            }

            // Xử lý ảnh đại diện
            $avatarPath = $this->xulyAnh($AVATAR);

            // Thêm tài khoản
            $sqlInsert = "INSERT INTO khach_hang (AVATAR, TENKH, HOTEN, EMAIL, DIACHI1, NS, MATKHAU, SDT, DIACHI, TP) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $this->data->command_prepare($sqlInsert, "ssssssssss",
                $avatarPath, $TENKH, $HOTEN, $EMAIL, $DIACHI1, $birthday, $MAKHAU, $SDT, $DIACHI, $DIACHI2
            )->execute();

            $_SESSION["success"] = "Đăng ký thành công! Vui lòng đăng nhập.";
            header("Location: Signin.php");
            exit();

        } catch (Exception $e) {
            $_SESSION["error"] = "Lỗi: " . $e->getMessage();
            header("Location: Signup.php");
            exit();
        }
    }

    // Đăng nhập
    public function dangnhap($TENKH, $MAKHAU) {
        // Kiểm tra khách hàng
        $sqlKH = "SELECT MAKH, TENKH, MATKHAU FROM khach_hang WHERE TENKH = ?";
        $this->data->select_prepare($sqlKH, "s", $TENKH);
        $rowKH = $this->data->fetch();

        if ($rowKH) {
            // Hỗ trợ cả mật khẩu mã hóa và chưa mã hóa
            $isPassOk = false;
            if (!empty($rowKH['MATKHAU'])) {
                $isPassOk = true;
            } elseif ($MAKHAU === $rowKH['MATKHAU']) {
                $isPassOk = true;
            }
            if ($isPassOk) {
                $_SESSION['user_id'] = $rowKH['MAKH'];
                $_SESSION['username'] = $rowKH['TENKH'];
                $_SESSION['role'] = 'khachhang';

                header("Location: login.php");
                exit();
            } else {
                $_SESSION['error'] = "Mật khẩu không đúng!";
                header("Location: Signin.php");
                exit();
            }
        }

        // Kiểm tra nhân viên
        $sqlNV = "SELECT MANV, TENNV, MATKHAU FROM nhan_vien WHERE TENNV = ?";
        $this->data->select_prepare($sqlNV, "s", $TENKH);
        $rowNV = $this->data->fetch();

        if ($rowNV) {
            if ($MAKHAU === $rowNV['MATKHAU']) {
                $_SESSION['user_id'] = $rowNV['MANV'];
                $_SESSION['username'] = $rowNV['TENNV'];
                $_SESSION['role'] = 'admin';

                header("Location: http://localhost/Web-Badminton-Shop/admin/html/trangchuadmin.php");
                exit();
            } else {
                $_SESSION['error'] = "Mật khẩu không đúng!";
                header("Location: Signin.php");
                exit();
            }
        }

        $_SESSION['error'] = "Tên đăng nhập không tồn tại!";
        header("Location: Signin.php");
        exit();
    }

    // Đăng xuất
    public function dangxuat(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'] ?? false, $params['httponly'] ?? false );
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
