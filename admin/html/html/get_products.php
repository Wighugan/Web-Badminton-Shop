<?php
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';
$data = new database();
$conn = $data->getConnection();

if (isset($_GET['category'])) { // 🟢 giữ nguyên tên biến truyền từ JS
    $category = $_GET['category'];

    // ⚠️ Cột trong bảng là 'category'
    $stmt = $conn->prepare("SELECT id, name, cost_price FROM product WHERE category = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();

    $result = $stmt->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($products);
}
?>
