<?php
$conn = new mysqli("localhost", "root", "", "mydp");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];

    $productcode = $_POST['productcode'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $flex = $_POST['flex'];
    $length = $_POST['length'];
    $weight = $_POST['weight'];
    $description = $_POST['description'];

    // Xử lý upload ảnh
    $image = "uploads/default.jpg"; // Nếu không có ảnh mới thì giữ nguyên ảnh cũ

if (!empty($_FILES["image"]["name"])) {
    $relative_upload_path = "../../uploads/"; // Thư mục lưu thật (ra ngoài admin)
    $public_upload_path = "uploads/";      // Đường dẫn ảnh để lưu vào DB/hiển thị web

    if (!is_dir($relative_upload_path)) {
        mkdir($relative_upload_path, 0777, true);
    }

    $filename = basename($_FILES["image"]["name"]);
    $target_file = $relative_upload_path . $filename;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image = $public_upload_path . $filename;
    } else {
        echo "Lỗi tải ảnh lên!";
        exit();
    }
}


    // Thêm sản phẩm vào database
    $sql = "INSERT INTO product (category, color, productcode, name, price, flex, length, weight, image, description,updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,NOW());";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $category, $color, $productcode, $name, $price, $flex, $length, $weight, $image, $description);
    
    if ($stmt->execute()) {
        echo "<script>alert('Sản phẩm đã được thêm thành công!'); window.location.href='quanlysanpham.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại!');</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>