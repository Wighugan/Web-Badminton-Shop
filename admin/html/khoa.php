<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';

class AccountManager extends database {

    public function lockKhachHang($id) {
        $sql = "UPDATE khach_hang SET TRANGTHAI = 0 WHERE MAKH = ?";
        $this->command_prepare($sql, 'i', $id);

        if ($this->execute()) {
            echo "<script>
                    alert('✅ Đã khóa tài khoản khách hàng thành công!');
                    window.location.href = 'quanlykhachhang.php';
                  </script>";
        } else {
            echo "<script>
                    alert('❌ Lỗi khi khóa tài khoản hoặc khách hàng không tồn tại!');
                    window.history.back();
                  </script>";
        }
    }
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $manager = new AccountManager();
        $manager->lockKhachHang($id);
        $manager->close();
    } catch (Exception $e) {
        echo "<script>alert('Lỗi: {$e->getMessage()}'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('❌ Thiếu ID khách hàng cần khóa!'); window.history.back();</script>";
}
?>
