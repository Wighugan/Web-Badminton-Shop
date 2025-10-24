<?php
// Kết nối CSDL
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php'; $data = new database();
// Kiểm tra nếu có id truyền vào
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Đảm bảo an toàn
    // Thực hiện truy vấn xóa
    $sql = "DELETE FROM product WHERE id = ?";
    $data->command_prepare($sql, 'i', $id);
    if ($data->execute()) {
        // Xóa thành công, chuyển hướng về trang danh sách sản phẩm
        echo "<script>alert('Sản phẩm đã xóa thành công!'); window.location.href = 'quanlysanpham.php';</script>";
        exit();
    } else {
        echo "Lỗi khi xóa sản phẩm: ";
    }
    $data->close();
}
