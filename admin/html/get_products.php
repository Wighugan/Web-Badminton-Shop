<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';
$db = new database();

$category = $_GET['category'] ?? '';

if ($category) {
    // Truy vấn tất cả sản phẩm thuộc loại đã chọn
    $sql = "SELECT MASP, TENSP, GIANHAP FROM san_pham WHERE MALOAI = ?";
    $db->select_prepare($sql, "s", $category);
    $result = $db->fetchAll();

    // Trả kết quả về dạng JSON
    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    echo json_encode([]);
}
?>
