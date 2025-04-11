<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydp";

// Kết nối MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra có id user truyền vào không
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userId = intval($_GET['id']);

    // Update status = 'locked' (khóa user)
    $sql = "UPDATE users SET status = 'locked' WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo "<script>alert('Người dùng đã bị khóa thành công!'); window.location.href = 'users.php';</script>";
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
