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
$avatar = ""; // Nếu không có ảnh mới thì giữ nguyên ảnh cũ

if (!empty($_FILES["avatar"]["name"])) {
    $relative_upload_path = "../../uploads/"; // Thư mục lưu thật (ra ngoài admin)
    $public_upload_path = "uploads/";      // Đường dẫn ảnh để lưu vào DB/hiển thị web

    if (!is_dir($relative_upload_path)) {
        mkdir($relative_upload_path, 0777, true);
    }

    $filename = basename($_FILES["avatar"]["name"]);
    $target_file = $relative_upload_path . $filename;

    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
        $avatar = $public_upload_path . $filename;
    } else {
        echo "Lỗi tải ảnh lên!";
        exit();
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
