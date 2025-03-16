<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);

    // Cập nhật trạng thái bị khóa
    $sql = "UPDATE users SET status = 'locked' WHERE id = $userId";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Người dùng đã bị khóa thành công!'); window.location.href = 'users.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>
