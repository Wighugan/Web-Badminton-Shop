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

    // B1: Khóa người dùng bằng cách đặt trạng thái thành 0
    $sql_lock_user = "UPDATE users SET status = 0 WHERE id = ?";
    $stmt_lock_user = $conn->prepare($sql_lock_user);
    $stmt_lock_user->bind_param("i", $user_id);

    if ($stmt_lock_user->execute()) {
        echo "<script>alert('Đã khóa người dùng.'); window.location.href = 'quanlykhachhang.php';</script>";
        exit();
    } else {
        echo "Lỗi khi khóa người dùng: " . $stmt_lock_user->error;
    }

    $stmt_lock_user->close();
}

$conn->close();
?>
