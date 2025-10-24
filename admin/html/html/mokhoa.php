<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';
$data = new database();

if (isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['type'])) {
    $id = intval($_GET['id']);
    $type = $_GET['type'];

    switch ($type) {
        case 'users':
            $table = 'users';
            $column = 'status';
            $redirect = 'quanlykhachhang.php';
            break;

        case 'nhanvien':
            $table = 'nhanvien';
            $column = 'status';
            $redirect = 'quanlynhanvien.php';
            break;

        case 'nhacungcap':
            $table = 'nhacungcap';
            $column = 'TrangThai';
            $redirect = 'quanlyncc.php';
            break;

        default:
            die("Loại dữ liệu không hợp lệ!");
    }

    $sql = "UPDATE $table SET $column = 1 WHERE id = ?";
    $conn = $data->getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Đã mở khóa thành công!'); window.location.href='$redirect';</script>";
    } else {
        echo "<script>alert('Lỗi khi mở khóa dữ liệu!'); window.history.back();</script>";
    }

    $stmt->close();
    $data->close();
} else {
    echo "<script>alert('Thiếu thông tin!'); window.history.back();</script>";
}
?>
