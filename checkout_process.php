<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'mydb');
if ($conn->connect_error) {
    die('Kết nối thất bại: ' . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['place_order'])) {
    // Lấy cart
    $sql = "SELECT p.id AS product_id, p.name, p.price, c.quantity 
    FROM cart c 
    JOIN product p ON c.product_id = p.id 
    WHERE c.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $cart_result = $stmt->get_result();

    $cart_items = [];
    $total = 0;
    while ($row = $cart_result->fetch_assoc()) {
        $cart_items[] = $row;
        $total += $row['price'] * $row['quantity'];
    }

    if (empty($cart_items)) {
        die('Giỏ hàng trống!');
    }
    $shipping_fee = 50000;
    $insurance_fee = 30000;
    $total += $shipping_fee + $insurance_fee;

    $order_code = 'DH' . time() . rand(1000, 9999);

    // Insert orders
    $sql = "INSERT INTO orders (code, user_id, total, status, created_at)
     VALUES (?, ?, ?, 'Thành công', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $order_code, $user_id, $total);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Insert order_details
    foreach ($cart_items as $item) {
        var_dump($item); // kiểm tra giá trị thật sự

        $sql = "INSERT INTO order_details (order_id,id, product_name, product_price, quantity) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisii", $order_id, $item['id'], $item['name'], $item['price'], $item['quantity']);
$stmt->execute();
    }
   

    // Xóa giỏ hàng
    $sql = "DELETE FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();

    

    header('Location: shoplogin.php');
    exit();
}
?>
