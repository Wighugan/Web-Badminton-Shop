<?php
// Kết nối MySQL
$conn = new mysqli("localhost", "root", "", "mydp");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Nhận dữ liệu từ form
$id = $_POST['id'];
$username = $_POST['username'];
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$address = $_POST['address'];
$birthday = $_POST['birthday'];

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
    $sql = "UPDATE users SET username=?, fullname=?, email=?, address=?, birthday=?, avatar=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $username, $fullname, $email, $address, $birthday, $avatar, $id);
} else {
    $sql = "UPDATE users SET username=?, fullname=?, email=?, address=?, birthday=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $username, $fullname, $email, $address, $birthday, $id);
}

if ($stmt->execute()) {
    header("Location: quanlykhachhang.php");
    exit();
} else {
    echo "Lỗi: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
