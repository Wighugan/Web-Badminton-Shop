<?php
// Kết nối MySQL
include "database/connect.php";
$data = new Database();

// Nhận dữ liệu từ form
$id = $_POST['id'];
$username = $_POST['username'];
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$address = $_POST['address'];
$city = $_POST['city'];

$birthday = $_POST['birthday'];
$numberphone = $_POST['numberphone'];

// Xử lý ảnh đại diện
$avatar = "";
if (!empty($_FILES["avatar"]["name"])) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
        $avatar = $target_file;
    }
}

// Cập nhật dữ liệu
if ($avatar) {
    $sql = "UPDATE users SET username=?, fullname=?, email=?, address=?,city=?, birthday=?, avatar=?, numberphone=? WHERE id=?";
    $data->select_prepare($sql, "ssssssssi", [$username, $fullname, $email, $address,$city, $birthday, $avatar, $numberphone, $id]);
} else {
    $sql = "UPDATE users SET username=?, fullname=?, email=?, address=?,city=?, birthday=?, numberphone=? WHERE id=?";
    $data->select_prepare($sql, "sssssssi", [$username, $fullname, $email, $address,$city, $birthday, $numberphone, $id]);
}

if ($data->execute()) {
    header("Location: suathongtinuser.php");
    exit();
} else {
    echo "Lỗi: ";
}
$data->close();
?>
