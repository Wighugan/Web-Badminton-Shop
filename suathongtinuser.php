<?php
ob_start(); // bật bộ đệm để tránh lỗi header
require_once "src/header-login.php";
require_once "src/user.php";
if (!isset($_SESSION['user_id'])) {
    die("Bạn chưa đăng nhập!");
}
$data = new Database();
$qlkh = new QuanLyKhachHang($data);
$user_id = (int)$_SESSION['user_id'];
$sql = "SELECT * FROM khach_hang WHERE MAKH = ?";
$data->select_prepare($sql, "i", $user_id);
$user = $data->fetch();

// Xử lý khi cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update') {
    $username = trim($_POST['username'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');
    $birthday = $_POST['birthday'] ?? null;
    $numberphone = trim($_POST['numberphone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address1 = trim($_POST['address1'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $newPassword = trim($_POST['password'] ?? '');
    $errors = [];
    if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
        header('Location: suathongtinuser.php');
        exit;
    }
    // Gọi hàm cập nhật
    $result = $qlkh->CapNhatThongTin(
        $user_id, $username, $fullname, $email, 
        $address, $address1, $city, 
        $newPassword, $numberphone, $birthday, 
        $_FILES['avatar'] ?? null
    );

    if ($result) {
        $_SESSION['success'] = "Cập nhật thông tin thành công!";
        $_SESSION['username'] = $username; // cập nhật lại username cho dropdown

        // load lại thông tin mới
        $data->select_prepare("SELECT * FROM khach_hang WHERE MAKH = ?", "i", $user_id);
        $user = $data->fetch();
    } else {
        $_SESSION['error'] = "Cập nhật thông tin thất bại!";
    }
    header('Location: suathongtinuser.php');
    exit;
}
ob_end_flush();
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>MMB - Cập nhật thông tin</title>
    <link href='img/logo.png' rel='icon' type='image/x-icon' />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        button {
            width: 25%;
            padding: 8px;
            background-color: #000000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
        }
        button:hover {
            background-color: #333;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        #previewImage {
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Page Header -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Thông Tin Cá Nhân</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="login.php">Trang Chủ</a></p>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Đổi Thông Tin Của Bạn</span></h2>
        </div>
        
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5 mx-auto">
                
                <!-- Thông báo -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?php 
                        echo $_SESSION['success']; 
                        unset($_SESSION['success']);
                        ?>
                    </div>
                <?php endif; ?>
                
                <div class="contact-form">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?= (int)$user['MAKH'] ?>">
                        <div class="control-group mb-3">
                            <label>Ảnh đại diện hiện tại:</label><br>
                               <img id="previewImage" 
                                   src="<?= htmlspecialchars($user['AVATAR'] ?: 'uploads/user.jpg') ?>" 
                                 width="100" 
                                 height="100"
                                 alt="Ảnh đại diện">
                        </div>

                        <div class="control-group mb-3">
                            <label for="imageInput">Chọn ảnh mới (nếu muốn đổi):</label>
                            <input class="form-control" type="file" name="avatar" id="imageInput" accept="image/*">
                        </div>

                        <div class="control-group mb-3">
                            <label for="username">Tên đăng nhập</label>
                            <input class="form-control" id="username" type="text" name="username" 
                                   value="<?= htmlspecialchars($user['TENKH']) ?>" required>
                        </div>

                        <div class="control-group mb-3">
                            <label for="fullname">Họ và Tên</label>
                            <input class="form-control" id="fullname" type="text" name="fullname" 
                                   value="<?= htmlspecialchars($user['HOTEN']) ?>" required>
                        </div>

                        <div class="control-group mb-3">
                            <label for="birthday">Ngày Sinh</label>
                            <input class="form-control" id="birthday" type="date" name="birthday" 
                                   value="<?= htmlspecialchars($user['NS']) ?>">
                        </div>

                        <div class="control-group mb-3">
                            <label for="numberphone">Số điện thoại</label>
                            <input class="form-control" id="numberphone" type="text" name="numberphone" 
                                   value="<?= htmlspecialchars($user['SDT']) ?>">
                        </div>

                        <div class="control-group mb-3">
                            <label for="email">Email</label>
                            <input class="form-control" id="email" type="email" name="email" 
                                   value="<?= htmlspecialchars($user['EMAIL']) ?>" required>
                        </div>

                        <div class="control-group mb-3">
                            <label for="address1">Địa chỉ</label>
                            <input class="form-control" id="address1" type="text" name="address1" 
                                   value="<?= htmlspecialchars($user['DIACHI1']) ?>">
                        </div>

                        <div class="control-group mb-3">
                            <label for="address">Quận</label>
                            <input class="form-control" id="address" type="text" name="address" 
                                   value="<?= htmlspecialchars($user['DIACHI']) ?>">
                        </div>

                        <div class="control-group mb-3">
                            <label for="city">Thành Phố</label>
                            <input class="form-control" id="city" type="text" name="city" 
                                   value="<?= htmlspecialchars($user['TP']) ?>">
                        </div>

                        <div class="control-group mb-3">
                            <label for="password">Đổi Mật khẩu (để trống nếu không đổi)</label>
                            <input class="form-control" id="password" type="password" name="password" placeholder="Nhập mật khẩu mới">
                        </div>

                        <div>
                            <button type="submit">Lưu Thông Tin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Preview ảnh khi chọn
    (function(){
        const input = document.getElementById('imageInput');
        const preview = document.getElementById('previewImage');
        if (!input || !preview) return;
        
        input.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (!file) return;
            if (!file.type.startsWith('image/')) {
                alert('Vui lòng chọn file ảnh!');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) { 
                preview.src = e.target.result; 
            };
            reader.readAsDataURL(file);
        });
    })();
    </script>

    <?php include 'src/footer.php'; ?>
</body>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>
    <script src="js/main.js"></script>
</html>
