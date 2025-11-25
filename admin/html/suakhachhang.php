
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/user.php';
$data = new database();
$kh   = new QuanLyKhachHang($data); 
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
$user = null;                    
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM khach_hang WHERE MAKH = ?";
    $data->select_prepare($sql, 'i', $id);
    $user = $data->fetch();
    if (!$user) {
        die("Không tìm thấy người dùng!");
    }
} else {
    die("ID không hợp lệ!");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $MAKH    = $_POST['MAKH'];
    $TENKH   = $_POST['TENKH'];
    $HOTEN   = $_POST['HOTEN'];
    $MATKHAU = $_POST['MATKHAU'];
    $EMAIL   = $_POST['EMAIL'];
    $SDT     = $_POST['SDT'];
    $DIACHI1 = $_POST['DIACHI1'];
    $DIACHI  = $_POST['DIACHI'];
    $TP      = $_POST['TP'];
    $NS      = $_POST['NS'];
    $AVATAR = $_FILES['AVATAR'];
    // Ensure $user is defined (loaded above) and keep existing avatar by default
    $avatarPath = isset($user['AVATAR']) && !empty($user['AVATAR']) ? $user['AVATAR'] : 'uploads/user.jpg';

    // Handle uploaded file (if any)
    if (isset($_FILES['AVATAR']) && isset($_FILES['AVATAR']['error']) && $_FILES['AVATAR']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['AVATAR'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (in_array($file['type'], $allowedTypes)) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newName = uniqid('av_') . '.' . $ext;
            $relativeDir = 'uploads/avatars';
            $relativePath = $relativeDir . '/' . $newName;
            $destination = $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/' . $relativePath;
            if (!is_dir(dirname($destination))) {
                mkdir(dirname($destination), 0755, true);
            }
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $avatarPath = $relativePath;
            }
        }
    }

    $kh = new QuanLyKhachHang($data);
    $kh->CapNhatThongTin(
        $MAKH, $TENKH, $HOTEN, $EMAIL,
        $DIACHI, $DIACHI1, $TP, $MATKHAU,
        $SDT, $NS, $avatarPath
    );
    // Reload lại chính trang
    header("Location: quanlykhachhang.php");
    exit;
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
            <class class="addproduct">
                <h1>------------------------------ Sửa Thông Tin Khách Hàng ---------------------------</h1>
                <form method="POST" enctype="multipart/form-data">                   
                <input type="hidden" name="MAKH" value="<?= $user['MAKH'] ?>">
                    <div class="form-group">
                        <label for="name">Tên đăng nhập:</label>
                        <input type="text" name="TENKH" value="<?= $user['TENKH'] ?>" required>
                        </div>                    
                <div class="form-group">
                    
                    <label for="name">Ảnh đại diện:</label>
                    <div>
                    <input class="form-group" type="file" id="AVATAR" name="AVATAR" accept="image/*"  onchange="previewImage(event)">
</div>
                    <img src="<?= '../../' .$user['AVATAR'] ?>" width="30" id="preview"  height="50" padding="20">
                    
                 </div>
                    <div class="form-group">
                        <label for="name">Họ và tên:</label>
                        <input type="text" name="HOTEN" value="<?= $user['HOTEN'] ?>" required>
                       
                    </div>
                    <div class="form-group">
                        <label for="email">Mật khẩu:</label>
                        <input type="text" id="email" name="MATKHAU" value="<?= $user['MATKHAU'] ?>" required>
                        
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="EMAIL" value="<?= $user['EMAIL'] ?>" required>
                        
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Số điện thoại:</label>
                        <input type="text" id="numberphone" name="SDT" value="<?= $user['SDT'] ?>" required>
                        
                    </div>

                    <div class="form-group">
                    <label for="email">Địa chỉ:</label>
                    <input type="text" id="address1" name="DIACHI1" value="<?= $user['DIACHI1'] ?>" required>
                    </div>

                    <div class="form-group">
                    <label for="email">Quận:</label>
                    <input type="text" id="address" name="DIACHI" value="<?= $user['DIACHI'] ?>" required>
                    </div>

                    <div class="form-group">
                    <label for="email">Thành phố:</label>
                    <input type="text" id="city" name="TP" value="<?= $user['TP'] ?>" required>
                    </div>
                    <div class="form-group">
                    <label for="email">Ngày Sinh:</label>
                    <input type="date" id="birthday" name="NS" value="<?= $user['NS'] ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Lưu vào Database" onclick="myFunction()">
                        <button class="return"><a href="quanlykhachhang.php">Quay lại</a></button>
                    </div>
                </form>
                <script>
                    function myFunction() {
                        alert("Đã lưu thành công thông tin khách hàng mới vào Database!");
                    }
                </script>
<?php  $data->close(); ?>
</class>
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