<?php
// Kết nối đến MySQL
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';$data = new database();
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    // B1: Mở khóa người dùng bằng cách đặt trạng thái thành 1
    $sql_unlock_user = "UPDATE users SET status = 1 WHERE id = ?";
   $data->command_prepare($sql_unlock_user, 'i', $user_id);
    if ($data->execute()) {
        echo "<script>alert('Đã mở khóa người dùng.'); window.location.href = 'quanlykhachhang.php';</script>";
        exit();
    } else {
        echo "Lỗi khi mở khóa người dùng: " ;
    }
    $data->close();
    exit();
}
