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
    $productId = intval($_GET['id']); // Đảm bảo id là số nguyên

    // Xóa sản phẩm khỏi MySQL
    $sql = "DELETE FROM product WHERE id = $productId";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Sản phẩm đã được xóa thành công!'); window.location.href = 'quanlysanpham.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>
