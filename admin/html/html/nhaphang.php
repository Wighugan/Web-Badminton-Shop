<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';
$data = new database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $tenNCC = $_POST['TenNCC']; // tên đúng trong form
    $loai = $_POST['category'];
    $tenSP = $_POST['name'];
    $donGia = $_POST['cost_price'];
    $tongTien = $_POST['TongTien'];
    $soLuong = $_POST['stock']; // sửa đúng tên input

    // Chuyển giá tiền thành số
    $donGia = floatval(str_replace('.', '', $donGia));
    $tongTien = floatval(str_replace('.', '', $tongTien));

    // ====== 1️⃣ Thêm phiếu nhập ======
    $sqlPhieuNhap = "INSERT INTO phieunhap (TenNCC, NgayNhap, TongTien) VALUES (?, NOW(), ?)";
    $stmt = $data->getConnection()->prepare($sqlPhieuNhap);
    $stmt->bind_param("sd", $tenNCC, $tongTien);
    $stmt->execute();
    $maPN = $stmt->insert_id;
    $stmt->close();

    // ====== 2️⃣ Thêm chi tiết phiếu nhập ======
    $sqlCT = "INSERT INTO chitietphieunhap (MaPN, TenSP, LoaiSP, SoLuong, DonGia) VALUES (?, ?, ?, ?, ?)";
    $stmt2 = $data->getConnection()->prepare($sqlCT);
    $stmt2->bind_param("issid", $maPN, $tenSP, $loai, $soLuong, $donGia);
    $stmt2->execute();
    $stmt2->close();

    // ====== 3️⃣ Cập nhật kho ======
    $sqlCheck = "SELECT id, stock FROM product WHERE name = ? AND category = ?";
    $stmt3 = $data->getConnection()->prepare($sqlCheck);
    $stmt3->bind_param("ss", $tenSP, $loai);
    $stmt3->execute();
    $result = $stmt3->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $newQty = $row['stock'] + $soLuong;
$sqlUpdate = "UPDATE product SET stock = ? WHERE id = ?";
$stmt4 = $data->getConnection()->prepare($sqlUpdate);
$stmt4->bind_param("ii", $newQty, $row['id']);

$stmt4->execute();

        $stmt4->close();
    } else {
        echo "<script>
            alert('⚠️ Sản phẩm chưa có trong kho! Vui lòng thêm mới sản phẩm trước.');
            window.history.back();
        </script>";
        exit;
    }

    $stmt3->close();
    $data->close();

    echo "<script>
        alert('✅ Nhập hàng thành công! Số lượng sản phẩm đã được cập nhật.');
        window.location.href = 'quanlykho.php';
    </script>";
} else {
    echo "<script>
        alert('Lỗi: Không có dữ liệu được gửi!');
        window.history.back();
    </script>";
}
?>
