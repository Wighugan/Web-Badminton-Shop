<?php

// Kết nối MySQL (XAMPP)
$servername = "localhost";
$username = "root"; // Thay bằng username của MySQL
$password = ""; // Thay bằng password của MySQL
$database = "mydp";

$conn = mysqli_connect($servername, $username, $password, $database);

// 2. Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xử lý ảnh đại diện
    $avatar = "uploads/default.jpg"; // Ảnh mặc định
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
    $address1 = trim($_POST['address1']);
    $birthday = trim($_POST['birthday']);
    $password = trim($_POST['password']); // ❌ Lưu mật khẩu dạng text (không bảo mật)
    $numberphone = trim($_POST['numberphone']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);


    // Kiểm tra username/email đã tồn tại chưa
    $checkUser = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $checkUser->bind_param("ss", $username, $email);
    $checkUser->execute();
    $checkUser->store_result();

    if ($checkUser->num_rows > 0) {
        $_SESSION["error"] = "Tên đăng nhập hoặc email đã tồn tại!";
        header("Location: register.php");
        exit();
    }
    $checkUser->close();

    // Thêm tài khoản vào database
    $sql = "INSERT INTO users (avatar, username, fullname, email, address1, birthday, password, numberphone, address,city) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $avatar, $username, $fullname, $email, $address1, $birthday, $password, $numberphone, $address,$city);

    if ($stmt->execute()) {
        $_SESSION["success"] = "Đăng ký thành công!";
        header("Location: login.php"); // Chuyển hướng đến trang đăng nhập
        exit();
    } else {
        $_SESSION["error"] = "Lỗi khi đăng ký: " . $stmt->error;
        header("Location: Signup.php");
        exit();
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
}
?>
