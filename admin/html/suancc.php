<?php
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
$nhacungcap = null;
$error = null;
$MANCC = isset($_GET['id']) ? intval($_GET['id']) : 0;
$nhacungcap = $ncc->getNccById($MANCC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $TENNCC = $_POST['TENNCC'] ?? '';
    $SDT = $_POST['SDT'] ?? '';
    $EMAIL = $_POST['EMAIL'] ?? '';
    $DIACHI = $_POST['DIACHI'] ?? '';
    $NGUOIDD = $_POST['NGUOIDD'] ?? '';
    $AVATAR = $_FILES['AVATAR'];
    $result = $ncc->updateNcc($MANCC, $TENNCC, $DIACHI, $SDT, $EMAIL, $AVATAR, $NGUOIDD);        
    if($result){
            header('location: quanlyncc.php');
            exit;
        } else {
            $error = is_array($result) ? $result['message'] : "❌ Cập nhật thất bại!";
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
                <h1>------------------------- Sửa Thông Tin nhà cung cấp -----------------------</h1>
                <form method="POST" enctype="multipart/form-data">                   
                <input type="hidden" name="MANCC" value="<?= $nhacungcap['MANCC'] ?>">




                   
                        
                <div class="form-group">
                    
                    <label for="name">Logo:</label>
                    <div>
                    <input class="form-group" type="file" id="avatar" name="AVATAR" accept="image/*"  onchange="previewImage(event)">
</div>
                    <img src="<?='../../'.$nhacungcap['AVATAR'] ?>" width="30" id="preview"  height="50" padding="20">
                    
                 </div>
                  <div class="form-group">
                        <label for="name">Tên nhà cung cấp:</label>
                        <input type="text" name="TENNCC" value="<?= $nhacungcap['TENNCC'] ?>" required>
                        </div>


                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="EMAIL" value="<?= $nhacungcap['EMAIL'] ?>" required>
                        
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Số điện thoại:</label>
                        <input type="text" id="numberphone" name="SDT" value="<?= $nhacungcap['SDT'] ?>" required>
                        
                    </div>

                  
                    <div class="form-group">
                        <label for="email">Địa chỉ:</label>
                        <input type="TEXT" id="birthday" name="DIACHI" value="<?= $nhacungcap['DIACHI'] ?>" required>
                        </div>
                    

                    <div class="form-group">
                        <label for="email">Người đại diện:</label>
                        <input type="text" id="NguoiDaiDien" name="NGUOIDD" value="<?= $nhacungcap['NGUOIDD'] ?>" required>
                        </div>

                    <div class="form-group">
                        <input type="submit" value="Lưu vào Database" onclick="myFunction()">
                        <button class="return"><a href="quanlynhacungcap.php">Quay lại</a></button>
                    </div>
                </form>
                <script>
                    function myFunction() {
                        alert("Đã lưu thành công thông tin khách hàng mới vào Database!");
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