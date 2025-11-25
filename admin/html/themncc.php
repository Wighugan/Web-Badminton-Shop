<?php
// Thông tin kết nối database
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/ncc.php'; 
$data = new database();
$ncc = new Ncc();
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
$error = null;
if($_SERVER['REQUEST_METHOD']=== 'POST'){
 $TENNCC = $_POST['TENNCC'] ?? '';
 $SDT = $_POST['SDT'] ?? '';
 $EMAIL = $_POST['EMAIL'] ?? '';
 $DIACHI = $_POST['DIACHI'] ?? '';
 $NGUOIDD = $_POST['NGUOIDD'] ?? '';
 $AVATAR = $_FILES['AVATAR'];
 $result = $ncc->addNcc($TENNCC,$DIACHI,$SDT,$EMAIL,$AVATAR,1,$NGUOIDD);
 
 // Debug
 error_log("Debug addNcc: " . print_r($result, true));
 
 // Kiểm tra kết quả
 if (is_array($result) && isset($result['success']) && $result['success']) {
     echo "<script>alert('Thêm nhà cung cấp thành công!'); window.location.href='quanlyncc.php';</script>";
     exit();
 } elseif ($result === true) {
     echo "<script>alert('Thêm nhà cung cấp thành công!'); window.location.href='quanlyncc.php';</script>";
     exit();
 } else {
     $error = is_array($result) && isset($result['message']) ? $result['message'] : '❌ Thêm nhà cung cấp thất bại!';
 }
}
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

    <link rel="stylesheet" href="../css/themnguoidung.css">
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
                    <p>CHÀO MỪNG ADMIN CỦA MMB</p>
                </div>
               
            </div>


            <!-- ================ LÀM QUẢN LÝ SẢN PHẨM Ở ĐÂY ================= -->
            <div class="details">
            <div class="recentOrders">
            <div class="addproduct">
                <h1>------------------------ Thêm Thông Tin nhà cung cấp ----------------</h1>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
    <label for="name">Logo:</label>
    <div>
        <span class="input-group-text">
            <i class="fa fa-user"></i>
        </span>
        <input type="file" class="form-control" name="AVATAR" id="avatar" accept="image/*" onchange="previewImage(event)">

    </div>      
    
    <img id="preview" src="https://www.w3schools.com/w3images/avatar2.png" class="preview" height="80" padding="20">

</div>
                    <div class="form-group">
                        <label for="name">Tên nhà cung cấp:</label>
                        <input type="text" id="fullname" name="TENNCC">
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="EMAIL">
                    </div>

                    <div class="form-group">
                        <label for="email">Số điện thoại:</label>
                        <input type="text" id="numberphone" name="SDT">
                    </div>

                    <div class="form-group">
                        <label for="email">Địa chỉ:</label>
                        <input type="text" id="Diachi" name="DIACHI" >
                    </div>
 

                    <div class="form-group">
                        <label for="email">Người đại diện:</label>
                        <input type="text" id="NguoiDaiDien" name="NGUOIDD"  >
                    </div>
                   

                    <div class="form-group">
                        <input type="submit" value="Lưu vào Database" onclick="myFunction()">
                        <button class="return"><a href="quanlyncc.php">Quay lại</a></button>
                    </div>
                </form>
                <script>
                    function myFunction() {
                        alert("Đã lưu thành công thông tin  mới vào Database!");
                    }
                    function previewImage(event) {
    var preview = document.getElementById('preview'); // Lấy thẻ <img>
    var file = event.target.files[0]; // Lấy file ảnh

    if (file) {
        var reader = new FileReader(); // Đọc file ảnh
        reader.onload = function(e) {
            preview.src = e.target.result; // Gán đường dẫn ảnh
            preview.style.display = "block"; // Hiển thị ảnh
        };
        reader.readAsDataURL(file); // Đọc file dưới dạng URL
    }
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