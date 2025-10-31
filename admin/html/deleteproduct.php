<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';

class ProductManager extends database {

    // Hàm xóa sản phẩm theo ID
    public function deleteProduct($id) {
        // Chuẩn bị câu lệnh SQL
        $sql = "DELETE FROM san_pham WHERE MASP = ?";
        $this->command_prepare($sql, 'i', $id);

        // Thực thi lệnh xóa
        if ($this->execute()) {
            echo "<script>
                    alert('✅ Sản phẩm đã được xóa thành công!');
                    window.location.href = 'quanlysanpham.php';
                  </script>";
        } else {
            echo "<script>
                    alert('❌ Lỗi khi xóa sản phẩm!');
                    window.location.href = 'quanlysanpham.php';
                  </script>";
        }
    }
}


if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Đảm bảo an toàn

    try {
        $manager = new ProductManager();
        $manager->deleteProduct($id);
        $manager->close();
    } catch (Exception $e) {
        echo "<script>alert('Lỗi: {$e->getMessage()}'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('❌ Thiếu ID sản phẩm để xóa!'); window.history.back();</script>";
}
?>
