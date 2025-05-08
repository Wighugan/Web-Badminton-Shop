<?php
// Kết nối CSDL
$servername = "localhost";
$username = "root";
$password = "";
$database = "mydp";

$conn = mysqli_connect($servername, $username, $password, $database);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Kiểm tra nếu có id truyền vào
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Đảm bảo an toàn

    // Thực hiện truy vấn xóa
    $sql = "DELETE FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Xóa thành công, chuyển hướng về trang danh sách sản phẩm
        echo "<script>alert('Sản phẩm đã xóa thành công!'); window.location.href = 'quanlysanpham.php';</script>";
        exit();
    } else {
        echo "Lỗi khi xóa sản phẩm: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
