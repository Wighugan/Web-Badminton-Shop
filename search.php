<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydp";

// Kết nối database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy từ khóa tìm kiếm
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM products WHERE name LIKE '%$search%' LIMIT 10";
$result = $conn->query($sql);

// Hiển thị kết quả
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='product'>
                <img src='".$row["image"]."' width='100'>
                <p>".$row["name"]."</p>
                <p>Giá: ".number_format($row["price"], 0, ',', '.')."đ</p>
              </div>";
    }
} else {
    echo "<p>Không tìm thấy sản phẩm nào!</p>";
}

$conn->close();
?>