<?php
// Kết nối đến MySQL
$servername = "localhost";
$username = "root";
$password = "";
$database = "mydp";

$conn = mysqli_connect($servername, $username, $password, $database);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // B1: Mở khóa người dùng bằng cách đặt trạng thái thành 1
    $sql_unlock_user = "UPDATE users SET status = 1 WHERE id = ?";
    $stmt_unlock_user = $conn->prepare($sql_unlock_user);
    $stmt_unlock_user->bind_param("i", $user_id);

    if ($stmt_unlock_user->execute()) {
        echo "<script>alert('Đã mở khóa người dùng.'); window.location.href = 'quanlykhachhang.php';</script>";
        exit();
    } else {
        echo "Lỗi khi mở khóa người dùng: " . $stmt_unlock_user->error;
    }

    $stmt_unlock_user->close();
}

$conn->close();
?>
