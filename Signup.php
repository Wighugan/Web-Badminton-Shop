<?php
include "class/systemManage.php";
$sm = new QuanLyHeThong();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $TENKH    = trim($_POST['username'] ?? '');
    $HOTEN    = trim($_POST['fullname'] ?? '');
    $EMAIL    = trim($_POST['email'] ?? '');
    $DIACHI   = trim($_POST['address'] ?? '');     // Quận
    $DIACHI1  = trim($_POST['address1'] ?? '');    // Địa chỉ liên hệ
    $DIACHI2  = trim($_POST['city'] ?? '');        // Thành phố
    $MAKHAU   = $_POST['password'] ?? '';
    $XACNHAN  = $_POST['confirm_password'] ?? '';
    $SDT      = trim($_POST['phone'] ?? '');
    $birthday = $_POST['birthday'] ?? '';
    $AVATAR   = $_FILES['avatar'] ?? null;

    // Danh sách lỗi
    $errors = [];

    // ✅ Kiểm tra dữ liệu hợp lệ
    if (empty($TENKH)) {
        $errors[] = "Tên đăng nhập không được để trống.";
    }
    if (empty($MAKHAU) || strlen($MAKHAU) < 6) {
        $errors[] = "Mật khẩu phải có ít nhất 6 ký tự.";
    }
    if ($MAKHAU !== $XACNHAN) {
        $errors[] = "Mật khẩu nhập lại không khớp.";
    }
    if (empty($SDT)) {
        $errors[] = "Số điện thoại không được để trống.";
    }

    // ✅ Nếu có lỗi → quay lại form
    if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
        header("Location: Signup.php");
        exit();
    }

    // ✅ Gọi hàm xử lý đăng ký trong class
    $sm->dangky($TENKH, $HOTEN, $EMAIL, $DIACHI, $DIACHI1, $DIACHI2, $MAKHAU, $SDT, $birthday, $AVATAR);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MMB- Shop Bán Đồ Cầu Lông</title>
    <link href='img/logo.png' rel='icon' type='image/x-icon' />
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <!DOCTYPE html>

<html>

<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        nav {
            display:flex;
            background-color: #444444;
            padding: 10px;
            justify-content: center;
            align-items: center;
            gap:20px;
        }
        nav a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
        }
    

.login-container {
    background-color: white;
    padding: 15px; /* Giảm padding để form gọn lại */
    border-radius: 8px; /* Giữ độ bo viền nhẹ */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 400px; /* Giảm chiều rộng của form */
    margin: 150px auto; /* Canh giữa trang */
}

h2 {
    text-align: center;
    margin-bottom: 15px; /* Giảm khoảng cách giữa tiêu đề và form */
    font-size: 1.2rem; /* Giảm kích thước tiêu đề */
    color: #333;
}

.form-group {
    margin-bottom: 15px; /* Giảm khoảng cách giữa các nhóm input */
}

label {
    display: block;
    margin-bottom: 5px;
    color: #333;
    font-size: 0.9rem; /* Giảm kích thước chữ của label */
}

input[type="text"], input[type="password"] {
    width: 100%;
    padding: 8px; /* Giảm padding trong các input */
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

button {
    width: 100%;
    padding: 8px; /* Giảm padding của nút */
    background-color: #000000;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 0.9rem; /* Giảm kích thước chữ trên nút */
}

button:hover {
    background-color: #6F6F6F ;
}

.footer {
    text-align: center;
    margin-top: 12px; /* Giảm khoảng cách giữa nút và footer */
    font-size: 0.85rem; /* Giảm kích thước chữ trong footer */
    color: #777;
}
.no-border-button {
        border: none;      /* Loại bỏ viền */
        outline: none;     /* Loại bỏ viền đen khi nhấn vào */
        background: #000000;  /* Loại bỏ nền, nếu muốn */
        cursor: pointer;   /* Hiển thị con trỏ tay khi di chuột */
}

.no-border-button:focus {
        outline: none;     /* Đảm bảo không có viền khi lấy focus */
}
.no-border-button-rec{
        border: 0px;      /* Loại bỏ viền */
        border-radius: 0;
        outline: none;     /* Loại bỏ viền đen khi nhấn vào */
        background: #000000;  /* Loại bỏ nền, nếu muốn */
        cursor: pointer;   /* Hiển thị con trỏ tay khi di chuột */
}

.no-border-button-rec:focus {
        outline: none;     /* Đảm bảo không có viền khi lấy focus */
}
#birthday {
    width: 100%;
    padding: 8px;
    
    border-radius: 4px;
    box-sizing: border-box;
    margin-right:150px;
}
        
#preview {
    margin-right:150px;
}

    </style>
</head>
<body>
 <!-- Topbar Start -->
 <div class="container-fluid">
    <div class="row bg-secondary py-2 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center">
                <a class="text-dark" href="">Câu Hỏi Thường Gặp</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="">Trợ Giúp</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="">Hỗ Trợ</a>
            </div>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <a class="text-dark px-2" href="">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="text-dark px-2" href="">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="text-dark px-2" href="">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a class="text-dark px-2" href="">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="text-dark pl-2" href="">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row align-items-center py-3 px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a href="index.html" class="text-decoration-none">
                <div style="display: flex; align-items: center; position: relative;">
                    <img src="img/logo.png" alt="a logo" width="85px" height="85px">
                    <span class="custom-font" style="margin-left: 10px; position: relative; top: 20px;">Shop</span>
                </div> 
            </a>
        </div>
    </div>
</div>
<!-- Topbar End -->



 
    <div class="login-container">
      
            <h2>ĐĂNG KÝ TÀI KHOẢN</h2>
            <form action="Signup.php" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <input type="text" id="username" name="username" placeholder="Tên đăng nhập" required>
    </div>

    <div class="form-group">
        <input type="text" id="fullname" name="fullname" placeholder="Họ và tên" required>
    </div>

    <div class="form-group">
        <input type="text" id="phone" name="phone" placeholder="Số di động" required>
    </div>

    <div class="form-group">
        <input type="email" id="email" name="email" placeholder="Email" required>
    </div>

    <div class="form-group">
        <label>Ảnh đại diện</label><br>
        <input type="file" class="form-control" name="avatar" id="avatar" accept="image/*" onchange="previewImage(event)">
        <img id="preview" src="https://www.w3schools.com/w3images/avatar2.png" class="rounded-circle" height="70" style="margin-top:10px;">
    </div>

    <script>
    function previewImage(event) {
        var preview = document.getElementById('preview');
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }
    </script>

    <div class="form-group">
        <input type="text" id="birthday" name="birthday" placeholder="Ngày sinh"
               onfocus="(this.type='date')" onblur="(this.type=this.value ? 'date' : 'text')" required>
    </div>

    <div class="form-group">
        <input type="text" id="address1" name="address1" placeholder="Địa chỉ liên hệ" required>
    </div>

    <div class="form-group">
        <input type="text" id="city" name="city" placeholder="Thành phố" required>
    </div>

    <div class="form-group">
        <input type="text" id="address" name="address" placeholder="Quận" required>
    </div>

    <div class="form-group">
        <input type="password" id="password" name="password" placeholder="Mật khẩu" required>
    </div>

    <div class="form-group">
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
    </div>

    <button class="no-border-button" type="submit">Đăng ký</button>
</form>
        </div>
        <?php 
        include 'src/footer.php';
        ?>


        </html>
        <!-- Footer Start -->
       
    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

</body>
</html> 