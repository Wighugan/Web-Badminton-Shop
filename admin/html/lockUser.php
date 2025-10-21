<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php'; $data = new database();
// Kiểm tra có id user truyền vào không
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userId = intval($_GET['id']);
    // Update status = 'locked' (khóa user)
    $sql = "UPDATE users SET status = 'locked' WHERE id = ?";
    $data->command_prepare($sql, $userId);
    if ($data->execute()) {
        echo "<script>alert('Người dùng đã bị khóa thành công!'); window.location.href = 'users.php';</script>";
    } else {
        echo "Lỗi: ";
    }
    $data->close();
}
?>
