<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';

class SanPham extends database {

    // Hàm thêm sản phẩm mới
    public function addProduct($data, $file) {
        $maloai = $data['category'];          // Mã loại sản phẩm
        $tensp = $data['name'];               // Tên sản phẩm
        $dongia = $data['price'];             // Giá
        $barcode = $data['productcode'];      // Mã sản phẩm (Barcode)
        $flex = $data['flex'];                // Độ cứng
        $length = $data['length'];            // Chiều dài
        $weight = $data['weight'];            // Trọng lượng
        $mota = $data['description'];         // Mô tả

        // ===== XỬ LÝ ẢNH UPLOAD =====
        $image = "uploads/default.jpg"; // Ảnh mặc định
        $relative_path = "../../uploads/";
        $public_path = "uploads/";

        if (!is_dir($relative_path)) {
            mkdir($relative_path, 0777, true);
        }

        if (!empty($file["image"]["name"])) {
            $filename = time() . "_" . basename($file["image"]["name"]);
            $target_file = $relative_path . $filename;

            if (move_uploaded_file($file["image"]["tmp_name"], $target_file)) {
                $image = $public_path . $filename;
            } else {
                throw new Exception("❌ Lỗi khi tải ảnh lên máy chủ!");
            }
        }

        // ===== CÂU LỆNH THÊM DỮ LIỆU =====
        $sql = "INSERT INTO san_pham (MALOAI, TENSP, DONGIA,  updated_at, IMAGE, BARCODE, WEIGHT, MOTA, LENGTH, FLEX)
                VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?)";

        $this->command_prepare($sql, 'ssdisssss',
            $maloai, $tensp, $dongia, $image, $barcode, $weight, $mota, $length, $flex
        );

        return $this->execute();
    }
}

// ===== XỬ LÝ GỬI FORM =====
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sp = new SanPham();

        if ($sp->addProduct($_POST, $_FILES)) {
            echo "<script>alert('✅ Thêm sản phẩm thành công!'); window.location.href='quanlysanpham.php';</script>";
        } else {
            echo "<script>alert('❌ Có lỗi khi thêm sản phẩm!');</script>";
        }

        $sp->close();
    } else {
        echo "❌ Không có dữ liệu POST!";
    }
} catch (Exception $e) {
    echo "<script>alert('".$e->getMessage()."');</script>";
}
?>
