<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/products.php';
$data = new database();
$sp = new SanPham();
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

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $TENSP = $_POST['name'];
    $BARCODE = $_POST['productcode'];
    $WEIGHT = $_POST['weight'];
    $GIANHAP = $_POST['preprice'];
    $DONGIA = $_POST['price'];
    $LENGTH = $_POST['length'];
    $MOTA = $_POST['description'];
    $IMAGE = $_FILES['IMAGE'];
    $MALOAI = $_POST['category'];
    $FLEX = $_POST['flex'];
    $result = $sp->addProduct(
        $TENSP, $MALOAI, $DONGIA, $IMAGE, 
        $WEIGHT, $MOTA, $LENGTH, $FLEX, 
        $BARCODE, $GIANHAP
    );
}
// Lấy danh sách loại sản phẩm
$data->select("SELECT MALOAI, TENLOAI FROM loai_sp");
$loaiList = $data->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - MMB - Shop Bán Đồ Cầu Lông</title>
    <link href='../img/logo.png' rel='icon' type='image/x-icon' />
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="../css/indexadmin.css">

    <link rel="stylesheet" href="../css/themsanpham.css">
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
                    <p>CHÀO MỪNG QUẢN TRỊ CỦA MMB</p>
                </div>
                
            </div>

            <!-- ================ LÀM QUẢN LÝ SẢN PHẨM Ở ĐÂY ================= -->
            <div class="details">
            <div class="recentOrders">
            <div class="addproduct">
                <h1>------------------------------ Thêm sản phẩm mới ------------------------------</h1>
            <form method="POST" enctype="multipart/form-data">
              <div class="form-group">
        <label for="category">Loại sản phẩm:</label>
        <select id="category" name="category" required>
            <option value="yx">Yonex</option>
            <option value="mo">Mizuno</option>
            <option value="lg">Lining</option>
            <option value="vr">Victor</option>
        </select>
    </div>

     <div class="form-group">
        <label for="image">Ảnh sản phẩm:</label>
        <input type="file" id="image" name="IMAGE" accept="image/*" required onchange="previewImage(event)">
        <br>
        <img id="preview" src="https://bizweb.dktcdn.net/100/485/982/collections/248f25eb211faf87af29dfe6be4b3b0b.jpg?v=1695029604207"
             alt="Xem trước ảnh" width="150" height="150" style="display: block; margin-top: 10px;">
    </div>

    <div class="form-group">
        <label for="productcode">Mã sản phẩm:</label>
        <input type="text" id="productcode" name="productcode" required>
    </div>

    <div class="form-group">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="price">Đơn giá:</label>
        <input type="text" id="price" name="price" required>
    </div>
    <div class="form-group">
        <label for="price">Giá nhập:</label>
        <input type="text" id="preprice" name="preprice" required>
    </div>
    

    <div class="form-group">
        <label for="flex">Độ cứng:</label>
        <input type="text" id="flex" name="flex" required>
    </div>

    <div class="form-group">
        <label for="length">Chiều dài:</label>
        <input type="text" id="length" name="length" required>
    </div>

    <div class="form-group">
        <label for="weight">Trọng lượng:</label>
        <input type="text" id="weight" name="weight" required>
    </div>

    <div class="form-group">
        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" required></textarea>
    </div>

        <div class="form-group">
                        <input type="submit" value="Lưu vào Database" onclick="myFunction()">
                        <button class="return"><a href="quanlysanpham.php">Quay lại</a></button>
                    </div>
    </form>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(event.target.files[0]);
            preview.style.display = 'block';
        }
    </script>


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