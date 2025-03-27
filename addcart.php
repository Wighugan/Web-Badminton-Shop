<?php
session_start();
include 'db.php'; // Kết nối MySQL

if (!isset($_SESSION['user_id'])) {
    die("Vui lòng đăng nhập trước khi thêm sản phẩm vào giỏ hàng.");
}

if (isset($_GET['id']) && isset($_GET['quantity'])) {
    $product_id = intval($_GET['id']);
    $quantity = intval($_GET['quantity']);

    if ($quantity < 1) {
        $quantity = 1;
    }
}


$user_id = $_SESSION['user_id'];
$product_id = intval($_GET['id']); // Chuyển ID thành số nguyên để tránh lỗi SQL Injection

// Kiểm tra sản phẩm có tồn tại không
$query = $conn->prepare("SELECT id, price FROM products WHERE id = ?");
$query->bind_param("i", $product_id);
$query->execute();
$result = $query->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Lỗi: Sản phẩm không tồn tại.");
}

// Kiểm tra sản phẩm đã có trong giỏ hàng chưa
$check_cart = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
$check_cart->bind_param("ii", $user_id, $product_id);
$check_cart->execute();
$cart_result = $check_cart->get_result();
$cart_item = $cart_result->fetch_assoc();

if ($cart_item) {
    // Nếu sản phẩm đã có, tăng số lượng
    $update_cart = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
    $update_cart->bind_param("ii", $user_id, $product_id);
    $update_cart->execute();
} else {
    // Nếu chưa có, thêm vào giỏ hàng
    $insert_cart = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $quantity = 1;
    $insert_cart->bind_param("iii", $user_id, $product_id, $quantity);
    $insert_cart->execute();
}

// Quay lại trang giỏ hàng
header("Location: cart.php");
exit;
?>
