<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php'; $data = new database();
if (!isset($_SESSION['user_id'])) {
    die("Vui lòng đăng nhập để thực hiện hành động này.");
}

if (!isset($_POST['id']) || !isset($_POST['quantity'])) {
    die("Dữ liệu không hợp lệ.");
}

$user_id = $_SESSION['user_id'];
$product_id = intval($_POST['id']);
$quantity = intval($_POST['quantity']);

// Kiểm tra số lượng hợp lệ
if ($quantity < 1) {
    die("Số lượng không hợp lệ.");
}
// Cập nhật số lượng sản phẩm trong giỏ hàng
$sql = "UPDATE cart SET quantity = ? WHERE product_id = ? AND user_id = ?";
$data->command_prepare($sql, 'iii', $quantity, $product_id, $user_id);
$update_cart = $data;
if ($update_cart->execute()) {
    echo "Cập nhật thành công!";
} else {
    echo "Lỗi khi cập nhật giỏ hàng!";
}
$update_cart->close();
$data->close();
?>
