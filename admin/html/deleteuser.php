<?php
// Kết nối đến MySQL
$servername = "localhost";
$username = "root";
$password = "";
$database = "mydp";

$conn = mysqli_connect($servername, $username, $password, $database);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // B1: Lấy tất cả đơn hàng của người dùng
    $sql_get_orders = "SELECT id FROM orders WHERE user_id = ?";
    $stmt_get_orders = $conn->prepare($sql_get_orders);
    $stmt_get_orders->bind_param("i", $user_id);
    $stmt_get_orders->execute();
    $result = $stmt_get_orders->get_result();

    while ($order = $result->fetch_assoc()) {
        $order_id = $order['id'];

        // B2: Xóa chi tiết đơn hàng liên quan
        $sql_delete_order_details = "DELETE FROM order_details WHERE order_id = ?";
        $stmt_delete_details = $conn->prepare($sql_delete_order_details);
        $stmt_delete_details->bind_param("i", $order_id);
        $stmt_delete_details->execute();
        $stmt_delete_details->close();
    }

    $stmt_get_orders->close();

    // B3: Xóa đơn hàng
    $sql_delete_orders = "DELETE FROM orders WHERE user_id = ?";
    $stmt_delete_orders = $conn->prepare($sql_delete_orders);
    $stmt_delete_orders->bind_param("i", $user_id);
    $stmt_delete_orders->execute();
    $stmt_delete_orders->close();

    // B4: Xóa người dùng
    $sql_delete_user = "DELETE FROM users WHERE id = ?";
    $stmt_delete_user = $conn->prepare($sql_delete_user);
    $stmt_delete_user->bind_param("i", $user_id);

    if ($stmt_delete_user->execute()) {
        echo "<script>alert('Đã xóa người dùng và các dữ liệu liên quan.'); window.location.href = 'quanlykhachhang.php';</script>";
        exit();
    } else {
        echo "Lỗi khi xóa người dùng: " . $stmt_delete_user->error;
    }

    $stmt_delete_user->close();
}

$conn->close();
?>
