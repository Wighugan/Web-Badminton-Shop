<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/nhanvien.php';
$data = new database();
$nv  = new nhanvien();
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
$nhanvien = null;
// Lấy ID nhân viên
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM nhan_vien WHERE MANV = ?";
    $data->select_prepare($sql, 'i', $id);
    $nhanvien = $data->fetch();
    if (!$nhanvien) die("Không tìm thấy nhân viên!");
} else {
    die("ID không hợp lệ!");
}
// Xử lý form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $TENNV = $_POST['TENNV'];
    $HOTEN = $_POST['HOTEN'];
    $NGAYLAM = $_POST['NGAYLAM'];
    $NS = $_POST['NS'];
    $EMAIL = $_POST['EMAIL'];
    $SDT = $_POST['SDT'];
    $AVATAR = $_FILES['AVATAR'];
    $MATKHAU = $_POST['MATKHAU'];
    $result = $nv->updateNhanvien($id, $TENNV, $HOTEN,$SDT, $EMAIL, $AVATAR, $NGAYLAM, $NS,$MATKHAU);
    
    // Debug: xem $result trả về gì
    error_log("Debug updateNhanvien: " . print_r($result, true));
    
    // Nếu không có lỗi database, coi như thành công
    if ($result !== false) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href='quanlynhanvien.php';</script>";
        exit();
    } else {
        echo "<script>alert('Cập nhật thất bại! Vui lòng thử lại.'); window.history.back();</script>";
        exit();
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
                    <p>CHÀO MỪNG ADMIN CỦA MMB</p>
                </div>
                
            </div>


            <!-- ================ LÀM QUẢN LÝ SẢN PHẨM Ở ĐÂY ================= -->
            <div class="details">
            <div class="recentOrders">
            <div class="addproduct">
                <h1>------------------------------ Sửa Thông Tin nhân viên ---------------------------</h1>
                <form action="" method="POST" enctype="multipart/form-data">                   
                <input type="hidden" name="MANV" value="<?= $nhanvien['MANV'] ?>">




                    <div class="form-group">
                        <label for="name">Tên đăng nhập:</label>
                        <input type="text" name="TENNV" value="<?= $nhanvien['TENNV'] ?>" required>
                        </div>

                        
                <div class="form-group">
                    
                    <label for="name">Ảnh đại diện:</label>
                    <div>
                    <input class="form-group" type="file" id="avatar" name="AVATAR" accept="image/*"  onchange="previewImage(event)">
</div>
                    <img src="<?= '../../' .$nhanvien['AVATAR'] ?>" width="30" id="preview"  height="50" padding="20">

                    
                 </div>
                    <div class="form-group">
                        <label for="name">Họ và tên:</label>
                        <input type="text" name="HOTEN" value="<?= $nhanvien['HOTEN'] ?>" required>
                       
                    </div>
                    <div class="form-group">
                        <label for="name">Mật khẩu:</label>
                        <input type="text" name="MATKHAU" value="<?= $nhanvien['MATKHAU'] ?>" required>
                       
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="EMAIL" value="<?= $nhanvien['EMAIL'] ?>" required>
                        
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Số điện thoại:</label>
                        <input type="text" id="numberphone" name="SDT" value="<?= $nhanvien['SDT'] ?>" required>
                        
                    </div>

                    <div class="form-group">
                        <label for="email">Ngày vào làm:</label>
                        <input type="text" id="daywork" name="NGAYLAM" value="<?= $nhanvien['NGAYLAM'] ?>" required>
                        </div>


                    <div class="form-group">
                        <label for="email">Ngày Sinh:</label>
                        <input type="date" id="birthday" name="NS" value="<?= $nhanvien['NS'] ?>" required>
                        </div>

                    <div class="form-group">
                        <input type="submit" value="Lưu vào Database">
                        <button class="return"><a href="quanlynhanvien.php">Quay lại</a></button>
                    </div>
                </form>
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