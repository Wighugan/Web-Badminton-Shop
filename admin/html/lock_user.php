<?php
// Kết nối đến MySQL
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php'; $data = new database();
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // B1: Khóa người dùng bằng cách đặt trạng thái thành 0
    $sql_lock_user = "UPDATE users SET status = 0 WHERE id = ?";
    $data->command_prepare($sql_lock_user, $user_id);
    if ($data->execute()) {
        echo "<script>alert('Đã khóa người dùng.'); window.location.href = 'quanlykhachhang.php';</script>";
        exit();
    } else {
        echo "Lỗi khi khóa người dùng: ";
    }

    $data->close();
}
