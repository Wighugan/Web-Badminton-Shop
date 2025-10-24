<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';
$data = new database();

$type = $_GET['type'] ?? ''; // Loại bảng (user, nhanvien, nhacungcap)

// Chỉ xử lý khi form gửi bằng POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';

    // --- Thư mục upload ---
    $relative_upload_path = "../../uploads/"; // Thư mục thật
    $public_upload_path   = "uploads/";      // Đường dẫn lưu trong DB

    if (!is_dir($relative_upload_path)) {
        mkdir($relative_upload_path, 0777, true);
    }

    // --- Xử lý ảnh (nếu có upload mới) ---
    $avatar = "";
    if (!empty($_FILES["avatar"]["name"])) {
        $filename = time() . "_" . basename($_FILES["avatar"]["name"]);
        $target_file = $relative_upload_path . $filename;

        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            $avatar = $public_upload_path . $filename;
        } else {
            die("❌ Lỗi tải ảnh lên!");
        }
    }

    // ------------------------------------------------------------------
    // 1️⃣ CẬP NHẬT KHÁCH HÀNG
    // ------------------------------------------------------------------
    if ($type === "user") {
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $birthday = $_POST['birthday'];
        $numberphone = $_POST['numberphone'];

        if ($avatar) {
            $sql = "UPDATE users 
                    SET username=?, fullname=?, email=?, address=?, birthday=?, avatar=?, numberphone=? 
                    WHERE id=?";
            $data->command_prepare($sql, 'sssssssi', 
                $username, $fullname, $email, $address, $birthday, $avatar, $numberphone, $id
            );
        } else {
            $sql = "UPDATE users 
                    SET username=?, fullname=?, email=?, address=?, birthday=?, numberphone=? 
                    WHERE id=?";
            $data->command_prepare($sql, 'ssssssi', 
                $username, $fullname, $email, $address, $birthday, $numberphone, $id
            );
        }

        if ($data->execute()) {
            header("Location: quanlykhachhang.php");
            exit;
        } else {
            echo "❌ Lỗi cập nhật khách hàng!";
        }
    }

    // ------------------------------------------------------------------
    // 2️⃣ CẬP NHẬT NHÂN VIÊN
    // ------------------------------------------------------------------
    elseif ($type === "nhanvien") {
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $numberphone = $_POST['numberphone'];
        $daywork = $_POST['daywork'];
        $birthday = $_POST['birthday'];

        if ($avatar) {
            $sql = "UPDATE nhanvien 
                    SET username=?, fullname=?, email=?, numberphone=?, daywork=?, birthday=?, avatar=? 
                    WHERE id=?";
            $data->command_prepare($sql, 'sssssssi',
                $username, $fullname, $email, $numberphone, $daywork, $birthday, $avatar, $id
            );
        } else {
            $sql = "UPDATE nhanvien 
                    SET username=?, fullname=?, email=?, numberphone=?, daywork=?, birthday=? 
                    WHERE id=?";
            $data->command_prepare($sql, 'ssssssi',
                $username, $fullname, $email, $numberphone, $daywork, $birthday, $id
            );
        }

        if ($data->execute()) {
            header("Location: quanlynhanvien.php");
            exit;
        } else {
            echo "❌ Lỗi cập nhật nhân viên!";
        }
    }

    // ------------------------------------------------------------------
    // 3️⃣ CẬP NHẬT NHÀ CUNG CẤP
    // ------------------------------------------------------------------
    elseif ($type === "nhacungcap") {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $numberphone = $_POST['numberphone'];
        $NgayHopTac = $_POST['NgayHopTac'];
        $NguoiDaiDien = $_POST['NguoiDaiDien'];

        if ($avatar) {
            $sql = "UPDATE nhacungcap 
                    SET fullname=?, email=?, numberphone=?, NgayHopTac=?, NguoiDaiDien=?, avatar=? 
                    WHERE id=?";
            $data->command_prepare($sql, 'ssssssi',
                $fullname, $email, $numberphone, $NgayHopTac, $NguoiDaiDien, $avatar, $id
            );
        } else {
            $sql = "UPDATE nhacungcap 
                    SET fullname=?, email=?, numberphone=?, NgayHopTac=?, NguoiDaiDien=? 
                    WHERE id=?";
            $data->command_prepare($sql, 'sssssi',
                $fullname, $email, $numberphone, $NgayHopTac, $NguoiDaiDien, $id
            );
        }

        if ($data->execute()) {
            header("Location: quanlyncc.php");
            exit;
        } else {
            echo "❌ Lỗi cập nhật nhà cung cấp!";
        }
    }

    // ------------------------------------------------------------------
    else {
        echo "❌ Không xác định loại đối tượng cần cập nhật!";
    }

    $data->close();
} else {
    echo "❌ Không có dữ liệu POST gửi đến!";
}
?>
