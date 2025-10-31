<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';

class Deleter extends database {

    public function deleteRecord($type, $id) {
        // Xác định bảng, cột khóa chính và trang redirect
        switch ($type) {
            case 'nhan_vien':
                $table = 'nhan_vien';
                $primaryKey = 'MANV';
                $redirect = 'quanlynhanvien.php';
                break;

            case 'khach_hang':
                $table = 'khach_hang';
                $primaryKey = 'MAKH';
                $redirect = 'quanlykhachhang.php';
                break;

            case 'ncc':
                $table = 'ncc';
                $primaryKey = 'MANCC';
                $redirect = 'quanlyncc.php';
                break;

            default:
                throw new Exception("❌ Loại dữ liệu không hợp lệ!");
        }

        // Câu lệnh xóa (chuẩn hóa an toàn)
        $sql = "DELETE FROM $table WHERE $primaryKey = ?";
        $this->command_prepare($sql, 'i', $id);

        if ($this->execute()) {
            echo "<script>
                    alert('✅ Đã xóa thành công!');
                    window.location.href = '$redirect';
                  </script>";
        } else {
            echo "<script>
                    alert('❌ Lỗi khi xóa dữ liệu!');
                    window.location.href = '$redirect';
                  </script>";
        }
    }
}


try {
    if (isset($_GET['id']) && isset($_GET['type'])) {
        $deleter = new Deleter();
        $id = intval($_GET['id']);
        $type = $_GET['type'];

        $deleter->deleteRecord($type, $id);
        $deleter->close();
    } else {
        throw new Exception("❌ Thiếu ID hoặc loại dữ liệu!");
    }
} catch (Exception $e) {
    echo "<script>alert('{$e->getMessage()}'); window.history.back();</script>";
}
?>
