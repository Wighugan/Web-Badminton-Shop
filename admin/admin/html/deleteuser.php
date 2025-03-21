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

    // Lấy đường dẫn ảnh trước khi xóa
    $sql = "SELECT avatar FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Nếu có ảnh và ảnh không phải mặc định, thì xóa file ảnh
    if ($row && $row['avatar'] != "uploads/default.jpg" && file_exists($row['avatar'])) {
        unlink($row['avatar']);
    }

    // Xóa user từ database
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        // Reset lại ID
        mysqli_query($conn, "SET @num := 0;");
        mysqli_query($conn, "UPDATE users SET id = @num := (@num+1);");
        mysqli_query($conn, "ALTER TABLE users AUTO_INCREMENT = 1;");

        echo "User đã bị xóa. Đang chuyển hướng...";
        header("Location: quanlykhachhang.php");
        exit();
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

// Đóng kết nối
mysqli_close($conn);
?>
