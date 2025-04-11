<?php
// Kết nối MySQL
$servername = "localhost";
$username = "root";
$password = "";
$database = "mydp";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Kiểm tra nếu có ID user hợp lệ
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy đường dẫn avatar
    $sql = "SELECT avatar FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Xóa ảnh nếu tồn tại và không phải ảnh mặc định
    if ($row && $row['avatar'] != "uploads/default.jpg" && file_exists($row['avatar'])) {
        unlink($row['avatar']);
    }

    // Xóa orders của user trước
    $sql = "DELETE FROM orders WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    // Xóa user
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Người dùng đã bị khóa thành công!'); window.location.href = 'quanlykhachhang.php';</script>";

        header("refresh:1;url=quanlykhachhang.php");
        exit();
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

// Đóng kết nối
mysqli_close($conn);
?>
