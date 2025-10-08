<?php
session_start();
include 'database/connect.php';
$data = new database();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_POST['id']) || !isset($_POST['quantity'])) {
    die("Lỗi: Không có sản phẩm nào được chọn để thêm vào giỏ hàng.");
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['id'];
$quantity = intval($_POST['quantity']); // Ép kiểu số nguyên để tránh lỗi

if ($quantity < 1) {
    $quantity = 1; // Đảm bảo số lượng hợp lệ
}

// Kiểm tra xem sản phẩm đã có trong giỏ chưa
$check_cart = $data->select_prepare("SELECT quantity FROM cart WHERE product_id = ? AND user_id = ?", "ii", $product_id, $user_id);
$result = $data->fetch();

if ($result) {
    // Nếu sản phẩm đã có trong giỏ -> Cập nhật số lượng
    $data->select_prepare("UPDATE cart SET quantity = quantity + ? WHERE product_id = ? AND user_id = ?", "iii", $quantity, $product_id, $user_id);
} else {
    // Nếu sản phẩm chưa có -> Thêm mới vào giỏ hàng
    $data->select_prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)", "iii", $user_id, $product_id, $quantity);
}

$data->close();

// Quay lại giỏ hàng
$_SESSION['success_message'] = "Sản phẩm đã được thêm vào giỏ hàng.";
header("Location: cart.php");
exit;
?>
