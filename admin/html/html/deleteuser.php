<?php
// Kết nối MySQL
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';
$data = new database();

// Kiểm tra tham số
if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = intval($_GET['id']);
    $type = $_GET['type'];

    // Xác định bảng cần xóa
    switch ($type) {
        case 'nhanvien':
            $table = 'nhanvien';
            $redirect = 'quanlynhanvien.php';
            break;
        case 'user': // hoặc khách hàng
            $table = 'user';
            $redirect = 'quanlykhachhang.php';
            break;
        case 'nhacungcap':
            $table = 'nhacungcap';
            $redirect = 'quanlyncc.php';
            break;
        default:
            echo "<script>alert('Loại dữ liệu không hợp lệ!'); window.history.back();</script>";
            exit();
    }

    // Xóa bản ghi trong bảng tương ứng
    $sql_delete = "DELETE FROM $table WHERE id = ?";
    $data->command_prepare($sql_delete, 'i', $id);

    if ($data->execute()) {
        echo "<script>alert('Đã xóa thành công!'); window.location.href = '$redirect';</script>";
        exit();
    } else {
        echo "<script>alert('Lỗi khi xóa dữ liệu!'); window.location.href = '$redirect';</script>";
    }

    $data->close();
} else {
    echo "<script>alert('Thiếu ID hoặc loại dữ liệu!'); window.history.back();</script>";
}
?>
