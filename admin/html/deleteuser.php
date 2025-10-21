<?php
// Kết nối đến MySQL
// Kiểm tra kết nối
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php'; $data = new database();
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    // B1: Lấy tất cả đơn hàng của người dùng
    $sql_get_orders = "SELECT id FROM orders WHERE user_id = ?";
    $data->select_prepare($sql_get_orders, 'i', $user_id);
    $result = $data->fetch();
    while ($order = $result->fetch()) {
        $order_id = $order['id'];

        // B2: Xóa chi tiết đơn hàng liên quan
        $sql_delete_order_details = "DELETE FROM order_details WHERE order_id = ?";
        $data->command_prepare($sql_delete_order_details, 'i', $order_id);
    }
    // B3: Xóa đơn hàng
    $sql_delete_orders = "DELETE FROM orders WHERE user_id = ?";
    $data->command_prepare($sql_delete_orders, 'i', $user_id);
    // B4: Xóa người dùng
    $sql_delete_user = "DELETE FROM users WHERE id = ?";
    $data->command_prepare($sql_delete_user, 'i', $user_id);

    if ($data->execute()) {
        echo "<script>alert('Đã xóa người dùng và các dữ liệu liên quan.'); window.location.href = 'quanlykhachhang.php';</script>";
        exit();
    } else {
        echo "Lỗi khi xóa người dùng: ";
    }

    $data->close();
}
