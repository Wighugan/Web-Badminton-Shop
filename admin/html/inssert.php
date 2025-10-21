<?php

// Kết nối MySQL (XAMPP)
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php'; $data = new database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xử lý ảnh đại diện
    $target_dir = __DIR__ . "/uploads/";
$avatar_path = "../uploads/" . basename($_FILES["avatar"]["name"]);

    if (!empty($_FILES["avatar"]["name"])) {
        $target_dir = "uploads/"; // Thư mục lưu ảnh
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Tạo thư mục nếu chưa có
        }

        $target_file = $target_dir . basename($_FILES["avatar"]["name"]);

        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            $avatar = $target_file; // Gán đường dẫn ảnh
        } else {
            $_SESSION["error"] = "Lỗi tải ảnh lên!";
            header("Location: register.php");
            exit();
        }
    }

    // Nhận dữ liệu từ form
    $username = trim($_POST['username']);
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $birthday = trim($_POST['birthday']);
    $password = trim($_POST['password']); // ❌ Lưu mật khẩu dạng text (không bảo mật)

    // Kiểm tra username/email đã tồn tại chưa
    $sql = "SELECT id FROM users WHERE username = ? OR email = ?";
    $data->select_prepare($sql, $username, $email);
    $checkUser = $data->fetch();

    if ($checkUser->num_rows > 0) {
        $_SESSION["error"] = "Tên đăng nhập hoặc email đã tồn tại!";
        header("Location: register.php");
        exit();
    }
    $checkUser->close();

    // Thêm tài khoản vào database
    $sql1 = "INSERT INTO users (avatar, username, fullname, email, address, birthday, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $data->command_prepare($sql1, $avatar, $username, $fullname, $email, $address, $birthday, $password);

    if ($data->execute()) {
        $_SESSION["success"] = "Đăng ký thành công!";
        header("Location: login.php"); // Chuyển hướng đến trang đăng nhập
        exit();
    } else {
        $_SESSION["error"] = "Lỗi khi đăng ký: ";
        header("Location: Signup.php");
        exit();
    }
    // Đóng kết nối
    $data->close();
}
?>
