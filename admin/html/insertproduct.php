<?php
$conn = new mysqli("localhost", "root", "", "mydp");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $color = $_POST['color'];
    $productcode = $_POST['productcode'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $flex = $_POST['flex'];
    $length = $_POST['length'];
    $weight = $_POST['weight'];
    $description = $_POST['description'];

    // Xử lý upload ảnh
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // Thêm sản phẩm vào database
    $sql = "INSERT INTO product (category, color, productcode, name, price, flex, length, weight, image, description) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $category, $color, $productcode, $name, $price, $flex, $length, $weight, $target_file, $description);
    
    if ($stmt->execute()) {
        echo "<script>alert('Sản phẩm đã được thêm thành công!'); window.location.href='quanlysanpham.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại!');</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>