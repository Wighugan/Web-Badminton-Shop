<!DOCTYPE html>
<html lang="en">
<?php
session_start();
// Thông tin kết nối database
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php'; 
$data = new database();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'nhanvien'])) {
    header("Location: ../../Signin.php");
    exit();
}
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $quanly = new Database();
    $quanly->dangxuat();
    header('Location: ../../signin.php');
    exit();
}
// Lấy thông tin sản phẩm từ database
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM san_pham WHERE MASP = ?";
$data->select_prepare($sql, "i", $id);
$product = $data->fetch();
if (!$product) {
    die("Sản phẩm không tồn tại!");
}
$data->close();
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - MMB - Shop Bán Đồ Cầu Lông</title>
    <link href='../img/logo.png' rel='icon' type='image/x-icon' />
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="../css/indexadmin.css">

    <link rel="stylesheet" href="../css/themsanpham.css">
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</head>

<body>
    <!-- =============== Navigation ================ -->
     <?php 
     include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/header-admin.php';
    ?>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="hello">
                    <p>CHÀO MỪNG ADMIN CỦA MMB !!!</p>
                </div>
                
            </div>


          
            <!-- ================ LÀM QUẢN LÝ SẢN PHẨM Ở ĐÂY ================= -->
            <div class="details">
            <div class="recentOrders">
            <div class="addproduct">
               <form action="updateproduct.php" method="POST" enctype="multipart/form-data" id="suaUserForm">
    <!-- Mã sản phẩm chính -->
    <input type="hidden" name="MASP" value="<?= htmlspecialchars($product['MASP']) ?>">

    <!-- Loại sản phẩm -->
    <div class="form-group">
        <label for="goi">Loại:</label>
        <select id="goi" name="MALOAI" required>
            <?php
            // Nếu bạn chưa có bảng loai_sp thì dùng danh sách tạm này
            $categories = ["Không có", "yx", "mo", "lg", "vr"];
            foreach ($categories as $cat) {
                $selected = (trim($product['MALOAI']) == trim($cat)) ? "selected" : "";
                echo "<option value='$cat' $selected>$cat</option>";
            }
            ?>
        </select>
    </div>

    <!-- Ảnh sản phẩm -->
    <div class="form-group">
        <label for="IMAGE">Thay ảnh:</label>
        <input type="file" id="IMAGE" name="IMAGE" accept="image/*" onchange="previewImage(event)">
        <br>
        <img src="<?= '../../' . htmlspecialchars($product['IMAGE']) ?>" width="80" id="preview" alt="Ảnh sản phẩm">
        <input type="hidden" name="old_image" value="<?= htmlspecialchars($product['IMAGE']) ?>">
    </div>

    <!-- BARCODE -->
    <div class="form-group">
        <label for="BARCODE">Mã sản phẩm:</label>
        <input type="text" id="BARCODE" name="BARCODE" value="<?= htmlspecialchars($product['BARCODE']) ?>" required>
    </div>

    <!-- Tên sản phẩm -->
    <div class="form-group">
        <label for="TENSP">Tên sản phẩm:</label>
        <input type="text" id="TENSP" name="TENSP" value="<?= htmlspecialchars($product['TENSP']) ?>" required>
    </div>

    <!-- Giá -->
    <div class="form-group">
        <label for="DONGIA">Giá:</label>
        <input type="text" id="DONGIA" name="DONGIA" value="<?= htmlspecialchars($product['DONGIA']) ?>" required>
    </div>

    <!-- Độ cứng -->
    <div class="form-group">
        <label for="FLEX">Độ cứng:</label>
        <input type="text" id="FLEX" name="FLEX" value="<?= htmlspecialchars($product['FLEX']) ?>" required>
    </div>

    <!-- Chiều dài -->
    <div class="form-group">
        <label for="LENGTH">Chiều dài vợt:</label>
        <input type="text" id="LENGTH" name="LENGTH" value="<?= htmlspecialchars($product['LENGTH']) ?>" required>
    </div>

    <!-- Trọng lượng -->
    <div class="form-group">
        <label for="WEIGHT">Trọng lượng:</label>
        <input type="text" id="WEIGHT" name="WEIGHT" value="<?= htmlspecialchars($product['WEIGHT']) ?>" required>
    </div>

    <!-- Thương hiệu -->
    <div class="form-group">
        <label for="THUONGHIEU">Thương hiệu:</label>
        <input type="text" id="THUONGHIEU" name="THUONGHIEU" value="<?= htmlspecialchars($product['THUONGHIEU'] ?? '') ?>" placeholder="Yonex" required>
    </div>

    <!-- Mô tả -->
    <div class="form-group">
        <label for="MOTA">Mô tả:</label>
        <textarea id="MOTA" name="MOTA" required><?= htmlspecialchars($product['MOTA']) ?></textarea>
    </div>

    <!-- Nút -->
    <div class="form-group">
        <input type="submit" value="Lưu vào Database" onclick="myFunction()">
        <button type="button" class="return" onclick="window.location.href='quanlysanpham.php'">Quay lại</button>
    </div>
</form>
                <script>
                    function myFunction() {
                        alert("Đã lưu thành công thông tin sản phẩm mới vào Database!");
                    }
                </script>

            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>