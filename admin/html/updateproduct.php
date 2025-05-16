<?php
// Kết nối MySQL
$conn = new mysqli("localhost", "root", "", "mydp");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Nhận dữ liệu từ form
$id = $_POST['id'];
$category = $_POST['category'];
$productcode = $_POST['productcode'];
$name = $_POST['name'];
$price = $_POST['price'];
$flex = $_POST['flex'];
$length = $_POST['length'];
$weight = $_POST['weight'];
$description = $_POST['description'];

// Xử lý ảnh


$image = ""; // Nếu không có ảnh mới thì giữ nguyên ảnh cũ

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

// Cập nhật dữ liệu
if ($image) {
    $sql = "UPDATE product SET category=?,  productcode=?, name=?, price=?, flex=?, length=?, weight=?,  description=?, image=?, updated_at=NOW() WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", $category,  $productcode, $name, $price, $flex, $length, $weight,  $description, $image, $id);
} else {
    $sql = "UPDATE product SET category=?,  productcode=?, name=?, price=?, flex=?, length=?, weight=?,  description=?,updated_at=NOW() WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $category,  $productcode, $name, $price, $flex, $length, $weight, $description, $id);
}

if ($stmt->execute()) {
    header("Location: quanlysanpham.php");
    exit();
} else {
    echo "Lỗi: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
