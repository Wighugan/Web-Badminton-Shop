<!DOCTYPE html>
<html lang="en">

<?php

session_start();

// Kiểm tra nếu user chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    die("Bạn chưa đăng nhập! Vui lòng đăng nhập lại.");
}

$user_id = $_SESSION['user_id']; // Lấy ID user từ session

// Kết nối MySQL
$conn = new mysqli("localhost", "root", "", "mydp");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn thông tin user dựa vào session
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("Không tìm thấy người dùng!");
}

$stmt->close();
$conn->close();
?>


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
                <a href="index.php" class="text-decoration-none">
                    <div style="display: flex; align-items: center; position: relative;">
                        <img src="img/logo.png" alt="a logo" width="85px" height="85px">
                        <span class="custom-font" style="margin-left: 10px; position: relative; top: 20px;">Shop</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="shoplogin.php">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Nhập nội dung bạn muốn tìm kiếm">
                        <div class="input-group-append">
                            <button class="input-group-text bg-transparent text-primary" class="fa fa-search">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                
                <a href="cart.php" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge"></span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid bg-white mb-2"> <!-- giảm khoảng cách -->
    <div class="row border-top px-xl-5">
        <div class="col-lg-12">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold">
                        <span class="text-primary font-weight-bold border px-3 mr-1">VNB</span>Shop
                    </h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse d-flex justify-content-between w-100" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="logedin.php" class="nav-item nav-link">Trang chủ</a>
                            <a href="shoplogin.php" class="nav-item nav-link">Sản Phẩm</a>
                            <a href="contactlogin.php" class="nav-item nav-link">Liên Hệ</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link" data-toggle="dropdown">
                                    
                                <?php 
                    echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Khách"; 
                ?>
                                </a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="index.php" class="dropdown-item">Đăng Xuất</a>
                                    <a href="suathongtinuser.php" class="dropdown-item">Sửa thông tin</a>
                                    <a href="history.php" class="dropdown-item">Lịch sử mua hàng</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Thông Tin Cá Nhân </h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Trang Chủ</a></p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
<style>
button {
    width: 25%;
    padding: 8px; /* Giảm padding của nút */
    background-color: #000000;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 0.9rem; /* Giảm kích thước chữ trên nút */
}

button:hover {
    background-color:rgb(8, 8, 8);
}
.no-border-button-rec-contact{
        border: 0px;      /* Loại bỏ viền */
        border-radius: 0;
        outline: none;     /* Loại bỏ viền đen khi nhấn vào */
        background: #000000;  /* Loại bỏ nền, nếu muốn */
        cursor: pointer;   /* Hiển thị con trỏ tay khi di chuột */
}

.no-border-button-rec-contact:focus {
        outline: none;     /* Đảm bảo không có viền khi lấy focus */
}
</style>

    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Đổi Thông Tin Của Bạn</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form">
                    <div id="success"></div>

                    <form action="update.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">



                    <div class="control-group">
    <label>Ảnh đại diện hiện tại:</label><br>
    <img id="previewImage" src="<?= htmlspecialchars($user['avatar']) ?>" width="100" alt="Ảnh đại diện" style="margin-bottom: 10px;">
</div>

<div class="control-group">
    <label for="image">Chọn ảnh mới (nếu muốn đổi):</label>
    <input class="form-control" type="file" name="avatar" id="imageInput" accept="image/*">
    <p class="help-block text-danger"></p>
</div>


<script>
document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('previewImage');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>

                    <div class="control-group">
                            <label for="name">Tên đăng nhập:</label>

                            <input class="form-control" type="text" name="username"  value="<?= $user['username'] ?>" required>

                            <p class="help-block text-danger"></p>
                        </div>

                        <div class="control-group">
                            <label for="name">Họ và Tên</label>

                            <input class="form-control" type="text" name="fullname"  value="<?= $user['fullname'] ?>" required>

                            <p class="help-block text-danger"></p>
                        </div>

                        <div class="control-group">
                            <label>Ngày Sinh</label>

                            <input class="form-control" type="date" id="birthday" name="birthday" value="<?= $user['birthday'] ?>" required>

                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <label>Số điện thoại</label>
                            <input class="form-control" type="text" id="numberphone" name="numberphone" value="<?= $user['numberphone'] ?>" required>
                            
                            <p class="help-block text-danger"></p>
                        </div>
                        
                        <div class="control-group">
                            <label>Email:</label>
                            
                                <input class="form-control" type="text" id="email" name="email" value="<?= $user['email'] ?>" required>

                            <p class="help-block text-danger"></p>
                        </div>


                        <div class="control-group">
                            <label>Địa chỉ</label>

                           
                                <input  class="form-control"  type="text" id="address1" name="address1" value="<?= $user['address1'] ?>" required>

                            <p class="help-block text-danger"></p>
                        </div>

                         <div class="control-group">
                            <label>Quận</label>

                           
                                <input  class="form-control"  type="text" id="address" name="address" value="<?= $user['address'] ?>" required>

                            <p class="help-block text-danger"></p>
                        </div>

                        <div class="control-group">
                            <label>Thành Phố</label>

                           
                                <input  class="form-control"  type="text" id="city" name="city" value="<?= $user['city'] ?>" required>

                            <p class="help-block text-danger"></p>
                        </div>

                        <div class="control-group">
                            <label>Đổi Mật khẩu:</label>
        
                            <input type="password" class="form-control" id="password" name="password" value="<?= $user['password'] ?>" required>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div>
                            <button onclick="myFunction()" class="no-border-button-rec-contact"  id="sendMessageButton">Lưu Thông Tin</button>
                            
                        </div>
                        
                        <script>
                            function myFunction() {
                                alert ("Lưu thông tin người dùng thành công");
                               
                            }
                        </script>

                    </form>
                </div>
            </div>
            
        </div>
    </div>
    <!-- Contact End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="logedin.php" class="text-decoration-none">
                    <div style="display: flex; align-items: center; position: relative; top: -10px;">
                        <img src="img/logo.png" alt="a logo" width="85px" height="85px">
                        <span class="custom-font" style="margin-left: 10px; position: top; top: 10px;">Shop</span>
                    </div>
                </a>
                <p>Mọi thắc mắt xin liên hệ về.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>273 An Dương Vương, Phường 3, Quận 5, Thành Phố Hồ Chí Minh</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>MMBShopper102@gmail.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>012345678</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Liên Hệ Nhanh</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="logedin.php"><i class="fa fa-angle-right mr-2"></i>Trang Chủ</a>
                            <a class="text-dark mb-2" href="shoplogin.php"><i class="fa fa-angle-right mr-2"></i>Cửa Hàng</a>
                            <a class="text-dark mb-2" href="cart.php"><i class="fa fa-angle-right mr-2"></i>Giỏ Hàng</a>
                            <a class="text-dark mb-2" href="checkout.php"><i class="fa fa-angle-right mr-2"></i>Kiểm Tra Thanh Toán</a>
                            <a class="text-dark" href="contactlogin.php"><i class="fa fa-angle-right mr-2"></i>Liên Hệ</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Nhận Thông Báo Mới Nhất</h5>
                        <form action="">
                            <div class="form-group">
                                <input type="text" class="form-control border-0 py-4" placeholder="Tên Của Bạn" required="required" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control border-0 py-4" placeholder="Email Của Bạn"
                                    required="required" />
                            </div>
                            <div>
                                <button class="no-border-button-rec-c" type="submit">Đăng Kí Ngay</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold" href="#">Trường Đại Học Sài Gòn</a>
                    <a class="text-dark font-weight-semi-bold" href="https://htmlcodex.com"></a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>