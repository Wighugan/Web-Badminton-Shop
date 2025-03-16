<?php
// Kết nối MySQL
$conn = new mysqli("localhost", "root", "", "mydp");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối database
    $conn = new mysqli("localhost", "root", "", "mydp");

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Xử lý upload ảnh
    $avatar = "uploads/default.jpg"; // Ảnh mặc định
    if (!empty($_FILES["avatar"]["name"])) {
        $target_dir = "uploads/"; // Thư mục lưu ảnh
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Tạo thư mục nếu chưa có
        }

        $target_file = $target_dir . basename($_FILES["avatar"]["name"]);

        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            $avatar = $target_file; // Gán đúng đường dẫn ảnh
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

    // Chuẩn bị câu lệnh SQL (Prepared Statement)
    $sql = "INSERT INTO users (avatar, username, fullname, email, address, birthday) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $avatar, $username, $fullname, $email, $address, $birthday);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        // Chuyển hướng về trang quản lý khách hàng sau khi thêm thành công
        header("Location: quanlykhachhang.php");
        exit(); // Dừng script sau khi chuyển hướng
    } else {
        echo "Lỗi SQL: " . $stmt->error;
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
}

