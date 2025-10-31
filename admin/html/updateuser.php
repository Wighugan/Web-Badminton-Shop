<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';

class UserUpdater {
    private $db;
    private $uploadDir = "../../uploads/";
    private $publicPath = "uploads/";

    public function __construct() {
        $this->db = new database();
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    private function uploadAvatar($file) {
        if (!empty($file["name"])) {
            $filename = time() . "_" . basename($file["name"]);
            $target = $this->uploadDir . $filename;
            if (move_uploaded_file($file["tmp_name"], $target)) {
                return $this->publicPath . $filename;
            } else {
                throw new Exception("❌ Lỗi tải ảnh lên!");
            }
        }
        return null;
    }

    public function updateKhachHang($data, $avatar) {
        $sql = $avatar ?
            "UPDATE khach_hang SET TENKH=?, HOTEN=?, EMAIL=?, DIACHI=?, NS=?, SDT=?, DIACHI1=?, TP=?, AVATAR=? WHERE MAKH=?" :
            "UPDATE khach_hang SET TENKH=?, HOTEN=?, EMAIL=?, DIACHI=?, NS=?, SDT=?, DIACHI1=?, TP=? WHERE MAKH=?";
        $types = $avatar ? 'sssssssssi' : 'ssssssssi'; 
        $params = $avatar ?
            [$data['TENKH'], $data['HOTEN'], $data['EMAIL'], $data['DIACHI'], $data['NS'], $data['SDT'], $data['DIACHI1'], $data['TP'], $avatar, $data['MAKH']] :
            [$data['TENKH'], $data['HOTEN'], $data['EMAIL'], $data['DIACHI'], $data['NS'], $data['SDT'], $data['DIACHI1'], $data['TP'], $data['MAKH']];

        $this->db->command_prepare($sql, $types, ...$params);
        return $this->db->execute();
    }

    // 🔹 Cập nhật NHÂN VIÊN
    public function updateNhanVien($data, $avatar) {
        $sql = $avatar ?
            "UPDATE nhan_vien SET TENNV=?, HOTEN=?, EMAIL=?, NGAYLAM=?, NS=?, SDT=?, AVATAR=? WHERE MANV=?" :
            "UPDATE nhan_vien SET TENNV=?, HOTEN=?, EMAIL=?, NGAYLAM=?, NS=?, SDT=? WHERE MANV=?";
        $types = $avatar ? 'sssssssi' : 'ssssssi';
        $params = $avatar ?
            [$data['TENNV'], $data['HOTEN'], $data['EMAIL'], $data['NGAYLAM'], $data['NS'], $data['SDT'], $avatar, $data['MANV']] :
            [$data['TENNV'], $data['HOTEN'], $data['EMAIL'], $data['NGAYLAM'], $data['NS'], $data['SDT'], $data['MANV']];

        $this->db->command_prepare($sql, $types, ...$params);
        return $this->db->execute();
    }

    public function updateNCC($data, $avatar) {
        $sql = $avatar ?
            "UPDATE ncc SET TENNCC=?, SDT=?, EMAIL=?, DIACHI=?, NGUOIDD=?, AVATAR=? WHERE MANCC=?" :
            "UPDATE ncc SET TENNCC=?, SDT=?, EMAIL=?, DIACHI=?, NGUOIDD=? WHERE MANCC=?";
        $types = $avatar ? 'ssssssi' : 'sssssi';
        $params = $avatar ?
            [$data['TENNCC'], $data['SDT'], $data['EMAIL'], $data['DIACHI'], $data['NGUOIDD'], $avatar, $data['MANCC']] :
            [$data['TENNCC'], $data['SDT'], $data['EMAIL'], $data['DIACHI'], $data['NGUOIDD'], $data['MANCC']];

        $this->db->command_prepare($sql, $types, ...$params);
        return $this->db->execute();
    }

    public function processRequest($type, $post, $files) {
        $avatarPath = $this->uploadAvatar($files['AVATAR']);
        $success = false;

        switch ($type) {
            case "khach_hang":
                $success = $this->updateKhachHang($post, $avatarPath);
                $redirect = "quanlykhachhang.php";
                break;

            case "nhan_vien":
                $success = $this->updateNhanVien($post, $avatarPath);
                $redirect = "quanlynhanvien.php";
                break;

            case "ncc":
                $success = $this->updateNCC($post, $avatarPath);
                $redirect = "quanlyncc.php";
                break;

            default:
                throw new Exception("❌ Không xác định loại đối tượng cần cập nhật!");
        }

        if ($success) {
            echo "<script>alert('✅ Cập nhật thành công!'); window.location.href='$redirect';</script>";
        } else {
            throw new Exception("❌ Lỗi cập nhật dữ liệu!");
        }
    }

    public function close() {
        $this->db->close();
    }
}


try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $type = $_GET['type'] ?? '';
        $updater = new UserUpdater();
        $updater->processRequest($type, $_POST, $_FILES);
        $updater->close();
    } else {
        echo "❌ Không có dữ liệu POST gửi đến!";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
