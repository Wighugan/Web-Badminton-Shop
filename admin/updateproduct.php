<?php
// Kết nối MySQL
$conn = new mysqli("localhost", "root", "", "mydp");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Nhận dữ liệu từ form
$id = $_POST['id'];
$category = $_POST['category'];
$color = $_POST['color'];
$productcode = $_POST['productcode'];
$name = $_POST['name'];
$price = $_POST['price'];
$flex = $_POST['flex'];
$length = $_POST['length'];
$weight = $_POST['weight'];
$description = $_POST['description'];

// Xử lý ảnh
$image = "";
if (!empty($_FILES["image"]["name"])) {
    $target_dir = "img/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image = $target_file;
    }
}

// Cập nhật dữ liệu
if ($image) {
    $sql = "UPDATE product SET category=?, color=?, productcode=?, name=?, price=?, flex=?, length=?, weight=?,  description=?, image=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssi", $category, $color, $productcode, $name, $price, $flex, $length, $weight,  $description, $image, $id);
} else {
    $sql = "UPDATE product SET category=?, color=?, productcode=?, name=?, price=?, flex=?, length=?, weight=?,  description=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", $category, $color, $productcode, $name, $price, $flex, $length, $weight, $description, $id);
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
