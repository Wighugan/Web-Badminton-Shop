<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';

class AccountAdder extends database {

    private function uploadAvatar($fileInputName = "AVATAR") {
        $defaultAvatar = "uploads/default.jpg";
        $relativePath = "../../uploads/";
        $publicPath = "uploads/";

        if (!is_dir($relativePath)) {
            mkdir($relativePath, 0777, true);
        }

        if (!empty($_FILES[$fileInputName]["name"])) {
            $filename = time() . "_" . basename($_FILES[$fileInputName]["name"]);
            $targetFile = $relativePath . $filename;

            if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
                return $publicPath . $filename;
            }
        }
        return $defaultAvatar;
    }

    public function add($type, $postData) {
        $avatar = $this->uploadAvatar(); // upload ảnh

        switch ($type) {

            // ---------------- KHÁCH HÀNG ----------------
            case 'khachhang':
                $sql = "INSERT INTO khach_hang (AVATAR, TENKH, HOTEN, EMAIL, DIACHI, NS,  SDT, DIACHI1, TP)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $this->command_prepare($sql, 'sssssssss',
                    $avatar,
                    $postData['TENKH'],
                    $postData['HOTEN'],
                    $postData['EMAIL'],
                    $postData['DIACHI'], //quan
                    $postData['NS'],
                    $postData['SDT'],
                    $postData['DIACHI1'],  //dia chi
                    $postData['TP']   // TP
                );
                $redirect = "quanlykhachhang.php";
                break;

            // ---------------- NHÂN VIÊN ----------------
            case 'nhanvien':
                $sql = "INSERT INTO nhan_vien (AVATAR, TENNV, HOTEN, EMAIL, NGAYLAM, NS,  SDT)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $this->command_prepare($sql, 'sssssss',
                    $avatar,
                    $postData['TENNV'],
                    $postData['HOTEN'],
                    $postData['EMAIL'],
                    $postData['NGAYLAM'],
                    $postData['NS'],
                    $postData['SDT']
                );
                $redirect = "quanlynhanvien.php";
                break;

            // ---------------- NHÀ CUNG CẤP ----------------
            case 'nhacungcap':
                $sql = "INSERT INTO ncc (AVATAR, TENNCC, SDT, EMAIL, DIACHI, NGUOIDD)
                        VALUES (?, ?, ?, ?, ?, ?)";
                $this->command_prepare($sql, 'ssssss',
                    $avatar,
                    $postData['TENNCC'],
                    $postData['SDT'],
                    $postData['EMAIL'],
                    $postData['DIACHI'],
                  
                    $postData['NGUOIDD']
                );
                $redirect = "quanlyncc.php";
                break;

            default:
                echo "<script>alert('❌ Loại dữ liệu không hợp lệ!'); window.history.back();</script>";
                return;
        }

        // 🔹 Thực thi
        if ($this->execute()) {
            echo "<script>
                    alert('✅ Thêm dữ liệu thành công!');
                    window.location.href='$redirect';
                  </script>";
        } else {
            echo "<script>alert('❌ Lỗi khi thêm dữ liệu!'); window.history.back();</script>";
        }
    }
}


// ===============================
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $type = $_GET['type'] ?? '';

    try {
        $adder = new AccountAdder();
        $adder->add($type, $_POST);
        $adder->close();
    } catch (Exception $e) {
        echo "<script>alert('Lỗi: {$e->getMessage()}'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('❌ Không có dữ liệu POST!'); window.history.back();</script>";
}
?>
