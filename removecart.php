<?php
session_start();
include 'database/connect.php';
$data = new database();
if (!isset($_SESSION['user_id'])) {
    die("Vui lòng đăng nhập để thực hiện hành động này.");
}

$user_id = $_SESSION['user_id'];
$cart_id = $_GET['id'];

// Xóa sản phẩm khỏi giỏ hàng
$data->select_prepare("DELETE FROM cart WHERE id = ? AND user_id = ?", "ii", $cart_id, $user_id);

// Quay lại giỏ hàng
header("Location: cart.php");
exit;
?>