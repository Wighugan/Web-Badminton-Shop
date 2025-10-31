<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';
$data = new database();

$type = $_GET['type'] ?? ''; // user | nhanvien | nhacungcap

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ====== UPLOAD ẢNH ======
    $avatar = "uploads/default.jpg";
    $relative_upload_path = "../../uploads/";
    $public_upload_path = "uploads/";

    if (!is_dir($relative_upload_path)) {
        mkdir($relative_upload_path, 0777, true);
    }

    if (!empty($_FILES["avatar"]["name"])) {
        $filename = time() . "_" . basename($_FILES["avatar"]["name"]);
        $target_file = $relative_upload_path . $filename;

        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            $avatar = $public_upload_path . $filename;
        }
    }

    // ====== PHÂN LOẠI THEO TYPE ======

    // 🧍‍♂️ KHÁCH HÀNG
    if ($type === "user") {
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $birthday = $_POST['birthday'];
        $numberphone = $_POST['numberphone'];

        $sql = "INSERT INTO users (avatar, username, fullname, email, address, birthday, numberphone)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $data->command_prepare($sql, 'sssssss', $avatar, $username, $fullname, $email, $address, $birthday, $numberphone);
        $redirect = "quanlykhachhang.php";
    }

    // 👩‍💼 NHÂN VIÊN
    elseif ($type === "nhanvien") {
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $numberphone = $_POST['numberphone'];
        $daywork = $_POST['daywork'];
        $birthday = $_POST['birthday'];

        $sql = "INSERT INTO nhanvien (avatar, username, fullname, email, numberphone, daywork, birthday)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $data->command_prepare($sql, 'sssssss', $avatar, $username, $fullname, $email, $numberphone, $daywork, $birthday);
        $redirect = "quanlynhanvien.php";
    }

    // 🏭 NHÀ CUNG CẤP
    elseif ($type === "nhacungcap") {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $numberphone = $_POST['numberphone'];
        $diaChi = $_POST['diaChi'];
        $NgayHopTac = $_POST['NgayHopTac'];
        $NguoiDaiDien = $_POST['NguoiDaiDien'];

        $sql = "INSERT INTO nhacungcap (avatar, fullname, email, numberphone, diaChi, NgayHopTac, NguoiDaiDien)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $data->command_prepare($sql, 'sssssss', $avatar, $fullname, $email, $numberphone, $diaChi, $NgayHopTac, $NguoiDaiDien);
        $redirect = "quanlyncc.php";
    }

    // 🚫 Nếu không có type hợp lệ
    else {
        die("❌ Loại thêm không hợp lệ!");
    }

    // ====== THỰC THI ======
    if ($data->execute()) {
        header("Location: $redirect");
        exit;
    } else {
        echo "❌ Lỗi thêm dữ liệu!";
    }

    $data->close();
} else {
    echo "❌ Không có dữ liệu POST!";
}
?>

