<?php
session_start();
include 'db.php'; // Kết nối CSDL

if (!isset($_SESSION['user_id'])) {
    die("Vui lòng đăng nhập để thực hiện hành động này.");
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
$check_cart = $conn->prepare("SELECT quantity FROM cart WHERE product_id = ? AND user_id = ?");
$check_cart->bind_param("ii", $product_id, $user_id);
$check_cart->execute();
$result = $check_cart->get_result();

if ($result->num_rows > 0) {
    // Nếu sản phẩm đã có trong giỏ -> Cập nhật số lượng
    $update_cart = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE product_id = ? AND user_id = ?");
    $update_cart->bind_param("iii", $quantity, $product_id, $user_id);
    $update_cart->execute();
    $update_cart->close();
} else {
    // Nếu sản phẩm chưa có -> Thêm mới vào giỏ hàng
    $insert_cart = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $insert_cart->bind_param("iii", $user_id, $product_id, $quantity);
    $insert_cart->execute();
    $insert_cart->close();
}

$check_cart->close();

// Quay lại giỏ hàng
$_SESSION['success_message'] = "Sản phẩm đã được thêm vào giỏ hàng.";
header("Location: cart.php");
exit;
?>
