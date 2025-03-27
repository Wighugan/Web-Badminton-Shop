<?php
session_start();
include 'db.php'; // Kết nối CSDL

if (!isset($_SESSION['user_id'])) {
    die("Vui lòng đăng nhập để thực hiện hành động này.");
}

$user_id = $_SESSION['user_id'];
$cart_id = $_GET['id'];

// Xóa sản phẩm khỏi giỏ hàng
$delete_cart = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
$delete_cart->execute([$cart_id, $user_id]);

// Quay lại giỏ hàng
header("Location: cart.php");
exit;
?>