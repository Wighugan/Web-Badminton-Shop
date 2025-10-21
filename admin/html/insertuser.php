<?php
// Kết nối MySQL
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php'; $data = new database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $avatar = "uploads/default.jpg"; // Ảnh mặc định

if (!empty($_FILES["avatar"]["name"])) {
    $relative_upload_path = "../../uploads/"; // Thư mục uploads nằm ngoài thư mục admin
    $public_upload_path = "uploads/";      // Đường dẫn hiển thị ảnh trên web
    if (!is_dir($relative_upload_path)) {
        mkdir($relative_upload_path, 0777, true); // Tạo thư mục nếu chưa có
    }
    $filename = basename($_FILES["avatar"]["name"]);
    $target_file = $relative_upload_path . $filename;
    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
        $avatar = $public_upload_path . $filename; // Gán đúng đường dẫn ảnh để lưu vào DB / hiển thị
    } else {
        echo "Lỗi tải ảnh lên!";
        exit();
    }
}
    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $birthday = $_POST['birthday'];
    $numberphone = $_POST['numberphone'];

    // Chuẩn bị câu lệnh SQL (Prepared Statement)
    $sql = "INSERT INTO users (avatar, username, fullname, email, address, birthday, numberphone) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $data->command_prepare($sql, 'sssssss', $avatar, $username, $fullname, $email, $address, $birthday, $numberphone);
    // Thực thi câu lệnh
    if ($data->execute()) {
        // Chuyển hướng về trang quản lý khách hàng sau khi thêm thành công
        header("Location: quanlykhachhang.php");
        exit(); // Dừng script sau khi chuyển hướng
    } else {
        echo "Lỗi SQL: ";
    }
    // Đóng kết nối
    $data->close();
}

