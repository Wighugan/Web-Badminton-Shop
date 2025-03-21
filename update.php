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
    $sql = "UPDATE users SET username=?, fullname=?, email=?, address=?, birthday=?, avatar=?, numberphone=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $username, $fullname, $email, $address, $birthday, $avatar, $numberphone, $id);
} else {
    $sql = "UPDATE users SET username=?, fullname=?, email=?, address=?, birthday=?, numberphone=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $username, $fullname, $email, $address, $birthday, $numberphone, $id);
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
