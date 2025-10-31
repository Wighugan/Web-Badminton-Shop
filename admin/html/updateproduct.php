<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';

class Product extends database {

    public function updateProduct($data, $file) {
        // Lấy dữ liệu từ form
        $MASP = $data['MASP'];
        $MALOAI = $data['MALOAI'];
        $TENSP = $data['TENSP'];
        $DONGIA = $data['DONGIA'];
        $BARCODE = $data['BARCODE'];
        $WEIGHT = $data['WEIGHT'];
        $MOTA = $data['MOTA'];
        $LENGTH = $data['LENGTH'];
        $FLEX = $data['FLEX'];

        // ========== XỬ LÝ ẢNH ==========
        $image = "";
        if (!empty($file["IMAGE"]["name"])) {
            // Thư mục lưu ảnh (tương đối)
            $relative_upload_path = "../../admin/img/";
            $public_upload_path = "admin/img/";

            if (!is_dir($relative_upload_path)) {
                mkdir($relative_upload_path, 0777, true);
            }

            $filename = time() . "_" . basename($file["IMAGE"]["name"]);
            $target_file = $relative_upload_path . $filename;

            if (move_uploaded_file($file["IMAGE"]["tmp_name"], $target_file)) {
                $image = $public_upload_path . $filename;
            } else {
                throw new Exception("❌ Lỗi tải ảnh lên!");
            }
        }

        // ========== CẬP NHẬT DỮ LIỆU ==========
        if ($image) {
            $sql = "UPDATE san_pham 
                    SET MALOAI=?, TENSP=?, DONGIA=?, BARCODE=?, WEIGHT=?, MOTA=?, LENGTH=?, FLEX=?, IMAGE=?, updated_at=NOW()
                    WHERE MASP=?";
            $this->command_prepare(
                $sql,
                'ssdsssssii',
                $MALOAI, $TENSP, $DONGIA, $BARCODE, $WEIGHT, $MOTA, $LENGTH, $FLEX, $image, $MASP
            );
        } else {
            $sql = "UPDATE san_pham 
                    SET MALOAI=?, TENSP=?, DONGIA=?, BARCODE=?, WEIGHT=?, MOTA=?, LENGTH=?, FLEX=?, updated_at=NOW()
                    WHERE MASP=?";
            $this->command_prepare(
                $sql,
                'ssdsssssi',
                $MALOAI, $TENSP, $DONGIA, $BARCODE, $WEIGHT, $MOTA, $LENGTH, $FLEX, $MASP
            );
        }

        // Thực thi
        return $this->execute();
    }
}

// ========== XỬ LÝ REQUEST ==========
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $product = new Product();

        if ($product->updateProduct($_POST, $_FILES)) {
            header("Location: quanlysanpham.php");
            exit();
        } else {
            echo "❌ Lỗi cập nhật sản phẩm!";
        }

        $product->close();
    } else {
        echo "❌ Không có dữ liệu POST!";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
