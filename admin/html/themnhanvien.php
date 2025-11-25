<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/nhanvien.php'; 
$data = new database();
$nv = new nhanvien();
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $TENNV = $_POST['TENNV'];
    $HOTEN = $_POST['HOTEN'];
    $EMAIL = $_POST['EMAIL'];
    $SDT = $_POST['SDT'];
    $NGAYLAM = $_POST['NGAYLAM'];
    $NS = $_POST['NS'];
    $AVATAR = $_FILES['AVATAR'];
    $MATKHAU = $_POST['MATKHAU'] ?? '';

    $result = $nv->addNhanvien($TENNV, $HOTEN, $SDT, $EMAIL, $AVATAR, $NGAYLAM, $NS, $MATKHAU);
    
    if (is_array($result)) {
        if ($result['success']) {
            echo "<script>alert('" . addslashes($result['message']) . "'); window.location.href='quanlynhanvien.php';</script>";
        } else {
            $dbErr = isset($result['db_error']) ? addslashes($result['db_error']) : '';
            $msg = addslashes($result['message']);
            $full = $msg . ($dbErr ? "\nDB Error: " . $dbErr : "");
            echo "<script>alert('" . $full . "'); window.history.back();</script>";
        }
    } else {
        // Fallback for older return types
        if ($result) {
            echo "<script>alert('Cập nhật thành công!'); window.location.href='quanlynhanvien.php';</script>";
        } else {
            echo "<script>alert('Cập nhật thất bại!'); history.back();</script>";
        }
    if (is_array($result)) {
        if ($result['success']) {
            echo "<script>alert('" . addslashes($result['message']) . "'); window.location.href='quanlynhanvien.php';</script>";
        } else {
            $dbErr = isset($result['db_error']) ? addslashes($result['db_error']) : '';
            $msg = addslashes($result['message']);
            $full = $msg . ($dbErr ? "\nDB Error: " . $dbErr : "");
            echo "<script>alert('" . $full . "'); window.history.back();</script>";
        }
    } else {
        // Fallback for older return types
        if ($result) {
            echo "<script>alert('Cập nhật thành công!'); window.location.href='quanlynhanvien.php';</script>";
        } else {
            echo "<script>alert('Cập nhật thất bại!'); history.back();</script>";
        }
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
                <h1>------------------------ Thêm Thông Tin nhân viên ----------------</h1>
                
                <form method="POST" enctype="multipart/form-data" id="suaUserForm">
                   
                   
                    <div class="form-group">
                        <label for="name">Tên đăng nhập:</label>
                        <input type="text" id="username" name="TENNV" >
                    </div>
                    <div class="form-group">
    <label for="name">Ảnh đại diện:</label>
    <div>
        <span class="input-group-text">
            <i class="fa fa-user"></i>
        </span>
        <input type="file" class="form-control" name="AVATAR" id="AVATAR" accept="image/*" onchange="previewImage(event)">
    </div>      
    <img id="preview" src="https://www.w3schools.com/w3images/avatar2.png" class="preview" height="80" padding="20">
</div>
                    <div class="form-group">
                        <label for="name">Họ và tên:</label>
                        <input type="text" id="fullname" name="HOTEN">
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
                        <label for="email">Mật khẩu:</label>
                        <input type="password" id="birthday" name="MATKHAU" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Ngày vào làm:</label>
                        <input type="date" id="birthday" name="NGAYLAM" onfocus="(this.type='date')" onblur="(this.type= this.value ? 'date' : 'text')" >
                    </div>
 

                    <div class="form-group">
                        <label for="email">Ngày Sinh:</label>
                        <input type="date" id="birthday" name="NS" onfocus="(this.type='date')" onblur="(this.type= this.value ? 'date' : 'text')" >
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Lưu vào Database">
                        <button class="return"><a href="quanlynhanvien.php">Quay lại</a></button>
                    </div>
                </form>
                <script>
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
