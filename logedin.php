<!DOCTYPE html>
<html lang="en">

<head><?php
session_start(); // 🔹 Đặt ở dòng đầu tiên của file!

// Kiểm tra nếu chưa đăng nhập thì chuyển về login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
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
                <a href="logedin.html" class="text-decoration-none">
                    <div style="display: flex; align-items: center; position: relative;">
                        <img src="img/logo.png" alt="a logo" width="85px" height="85px">
                        <span class="custom-font" style="margin-left: 10px; position: relative; top: 20px;">Shop</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="shoptimkiem_login.html">
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
                <a href="" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge">0</span>
                </a>
                <a href="cart.html" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge">0</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
    

    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Phân Loại Sản Phẩm</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                    <div class="navbar-nav w-100 overflow-hidden" style="height: 245px">
                        <a href="vot_login.html" class="nav-item nav-link">Vợt Cầu Lông</a>
                        <a href="giay_login.html" class="nav-item nav-link">Giày Cầu Lông</a>
                        <a href="tui_login.html" class="nav-item nav-link">Túi Cầu Lông</a>
                        <a href="quan_login.html" class="nav-item nav-link">Quần Cầu Lông</a>
                        <a href="ao_login.html" class="nav-item nav-link">Áo Cầu Lông</a>
                        <a href="vay_login.html" class="nav-item nav-link">Váy Cầu Lông</a>
                        
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="logedin.html" class="text-decoration-none d-block d-lg-none">
                        <div style="display: flex; align-items: center; position: relative;">
                            <img src="img/logo.png" alt="a logo" width="85px" height="85px">
                            <span class="custom-font" style="margin-left: 10px; position: relative; top: 20px;">Shop</span>
                        </div> 
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="" class="nav-item nav-link active">Trang Chủ</a>
                            <a href="shoplogin.php" class="nav-item nav-link">Sản Phẩm
                            </a>
                            <a href="contactlogin.html" class="nav-item nav-link">Liên Hệ</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link" data-toggle="dropdown">
                                <?php 
                    echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Khách"; 
                ?>
                                </a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="logout.php" class="dropdown-item">Đăng Xuất</a>
                                    <a href="suathongtinuser.html" class="dropdown-item">Đổi Thông Tin</a>
                                    <a href="history.html" class="dropdown-item">Lịch sử mua hàng</a>
                        </div>
                    </div>
                </nav>
                <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" style="height: 410px;">
                            <img class="img-fluid" src="img/carousel-1.jpg" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h4 class="text-light text-uppercase font-weight-medium mb-3">Giảm giá 10%</h4>
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Áo và Quần cầu lông</h3>
                                    <a href="shoplogin.html" class="btn btn-light py-2 px-3">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" style="height: 410px;">
                            <img class="img-fluid" src="img/carousel-2.jpg" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h4 class="text-light text-uppercase font-weight-medium mb-3">Giảm 20%</h4>
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Cho đơn hàng đầu tiên</h3>
                                    <a href="shoplogin.html" class="btn btn-light py-2 px-3">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" style="height: 410px;">
                            <img class="img-fluid" src="img/carousel-3.jpg" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h4 class="text-light text-uppercase font-weight-medium mb-3">Ưu đãi</h4>
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Bảo hành trong 12 tháng</h3>
                                    <a href="shoplogin.html" class="btn btn-light py-2 px-3">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>
                    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Cam Kết Chất Lượng</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Ship</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Hoàn Trả Trong 14 Ngày</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Hỗ Trợ 24/7</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->


     <!-- Categories Start -->
     <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 70px;">
                    <p class="text-right">15 Products</p>
                    <a href="vot_login.html" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="img/cat-1.jpg" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">Vợt</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 70px;">
                    <p class="text-right">15 Products</p>
                    <a href="ao_login.html" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="img/cat-2.jpg" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">Áo Cầu Lông</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 70px;">
                    <p class="text-right">15 Products</p>
                    <a href="vay_login.html" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="img/cat-3.jpg" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">Váy Cầu Lông</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 70px;">
                    <p class="text-right">15 Products</p>
                    <a href="quan_login.html" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="img/cat-4.jpg" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">Quần Cầu Lông</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 70px;">
                    <p class="text-right">15 Products</p>
                    <a href="tui_login.html" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="img/cat-5.jpg" alt="">
                    </a> 
                    <h5 class="font-weight-semi-bold m-0">Túi Cầu Lông</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 70px;">
                    <p class="text-right">15 Products</p>
                    <a href="giay_login.html" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="img/cat-6.jpg" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">Giày Cầu Lông</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Categories End -->


    <!-- Offer Start -->
    <div class="container-fluid offer pt-5">
        <div class="row px-xl-5">
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                    <img src="img/offer-1.png" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">Giảm 20% Bộ Sưu Tập</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Yonex Astrox</h1>
                        <a href="shoplogin.html" class="btn btn-outline-primary py-md-2 px-md-3">Xem Ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-left text-white mb-2 py-5 px-5">
                    <img src="img/offer-2.png" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">Giảm 20% Bộ Sưu Tập</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Lining Tectonic</h1>
                        <a href="shoplogin.html" class="btn btn-outline-primary py-md-2 px-md-3">Xem Ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sản Phẩm Nổi Bật</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="detaillogin.html">
                            <img class="img-fluid w-100" src="img/product-1.jpg" alt="">
                        </a>
                        </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Vợt Cầu Lông Yonex Astrox 77 Pro Xanh Limited</h6>
                        <div class="d-flex justify-content-center">
                            <h6>7.300.000đ</h6><h6 class="text-muted ml-2"><del>10.530.000đ</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detaillogin.html" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem Chi Tiết</a>
                        <a href="logedin.html" class="btn btn-sm text-dark p-0"            onclick="done()"
                        ><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="detaillogin.html">
                            <img class="img-fluid w-100" src="img/product-2.jpg" alt="">
                        </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Vợt cầu lông Yonex Nanoflare 1000Z</h6>
                        <div class="d-flex justify-content-center">
                            <h6>5.050.000đ</h6><h6 class="text-muted ml-2"><del>6.050.000đ</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detaillogin.html" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem Chi Tiết</a>
                        <a href="logedin.html" class="btn btn-sm text-dark p-0"            onclick="done()"
                        ><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="detaillogin.html">
                            <img class="img-fluid w-100" src="img/product-3.jpg" alt="">
                        </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Vợt cầu lông Mizuno XYST 07</h6>
                        <div class="d-flex justify-content-center">
                            <h6>3.800.000đ</h6><h6 class="text-muted ml-2"><del>5.300.000đ</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detaillogin.html" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem Chi Tiết</a>
                        <a href="logedin.html" class="btn btn-sm text-dark p-0"            onclick="done()"
                        ><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="detaillogin.html">
                            <img class="img-fluid w-100" src="img/product-4.jpg" alt="">
                        </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Vợt cầu lông Lining Halbertec 8000</h6>
                        <div class="d-flex justify-content-center">
                            <h6>3.729.000đ</h6><h6 class="text-muted ml-2"><del>4.600.000đ</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detaillogin.html" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem Chi Tiết</a>
                        <a href="logedin.html" class="btn btn-sm text-dark p-0"            onclick="done()"
                        ><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="detaillogin.html">
                            <img class="img-fluid w-100" src="img/product-5.jpg" alt="">
                        </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Vợt cầu lông Lining Aeronaut 7000B</h6>
                        <div class="d-flex justify-content-center">
                            <h6>4.050.000đ</h6><h6 class="text-muted ml-2"><del>5.000.000đ</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detaillogin.html" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem Chi Tiết</a>
                        <a href="logedin.html" class="btn btn-sm text-dark p-0"            onclick="done()"
                        ><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="detaillogin.html">
                            <img class="img-fluid w-100" src="img/product-7.jpg" alt="">
                        </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Vợt Cầu Lông Lining Axforce 90 Xanh Dragon </h6>
                        <div class="d-flex justify-content-center">
                            <h6>4.500.000đ</h6><h6 class="text-muted ml-2"><del>5.000.000đ</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detaillogin.html" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem Chi Tiết</a>
                        <a href="logedin.html" class="btn btn-sm text-dark p-0"            onclick="done()"
                        ><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="detaillogin.html">
                            <img class="img-fluid w-100" src="img/product-6.jpg" alt="">
                        </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Vợt cầu lông Victor Auraspeed 100X TUC/AC</h6>
                        <div class="d-flex justify-content-center">
                            <h6>4.900.000 đ</h6><h6 class="text-muted ml-2"><del>5.000.000đ</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detaillogin.html" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem Chi Tiết</a>
                        <a href="logedin.html" class="btn btn-sm text-dark p-0"             onclick="done()"
                        ><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="detaillogin.html">
                            <img class="img-fluid w-100" src="img/product-8.jpg" alt="">
                        </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Vợt cầu lông Victor Ryuga Metallic 2024</h6>
                        <div class="d-flex justify-content-center">
                            <h6>4.400.000đ</h6><h6 class="text-muted ml-2"><del>4.700.000đ</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detaillogin.html" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem Chi Tiết</a>
                        <a href="logedin.html" class="btn btn-sm text-dark p-0"             onclick="done()"
                        ><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->

    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sản Phẩm Mới</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="detaillogin.html">
                            <img class="img-fluid w-100" src="img/product-1.jpg" alt="">
                        </a>
                        </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Vợt Cầu Lông Yonex Astrox 77 Pro Xanh Limited</h6>
                        <div class="d-flex justify-content-center">
                            <h6>7.300.000đ</h6><h6 class="text-muted ml-2"><del>10.530.000đ</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detaillogin.html" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem Chi Tiết</a>
                        <a href="logedin.html" class="btn btn-sm text-dark p-0"             onclick="done()"
                        ><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="detaillogin.html">
                            <img class="img-fluid w-100" src="img/product-2.jpg" alt="">
                        </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Vợt cầu lông Yonex Nanoflare 1000Z</h6>
                        <div class="d-flex justify-content-center">
                            <h6>5.050.000đ</h6><h6 class="text-muted ml-2"><del>6.050.000đ</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detaillogin.html" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem Chi Tiết</a>
                        <a href="logedin.html" class="btn btn-sm text-dark p-0"             onclick="done()"
                        ><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="detaillogin.html">
                            <img class="img-fluid w-100" src="img/product-3.jpg" alt="">
                        </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Vợt cầu lông Mizuno XYST 07</h6>
                        <div class="d-flex justify-content-center">
                            <h6>3.800.000đ</h6><h6 class="text-muted ml-2"><del>5.300.000đ</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detaillogin.html" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem Chi Tiết</a>
                        <a href="logedin.html" class="btn btn-sm text-dark p-0"             onclick="done()"
                        ><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="detaillogin.html">
                            <img class="img-fluid w-100" src="img/product-4.jpg" alt="">
                        </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Vợt cầu lông Lining Halbertec 8000</h6>
                        <div class="d-flex justify-content-center">
                            <h6>3.729.000đ</h6><h6 class="text-muted ml-2"><del>4.600.000đ</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detaillogin.html" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem Chi Tiết</a>
                        <a href="logedin.html" class="btn btn-sm text-dark p-0"             onclick="done()"
                        ><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="detaillogin.html">
                            <img class="img-fluid w-100" src="img/product-5.jpg" alt="">
                        </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Vợt cầu lông Lining Aeronaut 7000B</h6>
                        <div class="d-flex justify-content-center">
                            <h6>4.050.000đ</h6><h6 class="text-muted ml-2"><del>5.000.000đ</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detaillogin.html" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem Chi Tiết</a>
                        <a href="logedin.html" class="btn btn-sm text-dark p-0"             onclick="done()"
                        ><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="detaillogin.html">
                            <img class="img-fluid w-100" src="img/product-7.jpg" alt="">
                        </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Vợt Cầu Lông Lining Axforce 90 Xanh Dragon </h6>
                        <div class="d-flex justify-content-center">
                            <h6>4.500.000đ</h6><h6 class="text-muted ml-2"><del>5.000.000đ</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detaillogin.html" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem Chi Tiết</a>
                        <a href="logedin.html" class="btn btn-sm text-dark p-0"             onclick="done()"
                        ><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="detaillogin.html">
                            <img class="img-fluid w-100" src="img/product-6.jpg" alt="">
                        </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Vợt cầu lông Victor Auraspeed 100X TUC/AC</h6>
                        <div class="d-flex justify-content-center">
                            <h6>4.900.000 đ</h6><h6 class="text-muted ml-2"><del>5.000.000đ</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detaillogin.html" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem Chi Tiết</a>
                        <a href="logedin.html" class="btn btn-sm text-dark p-0"             onclick="done()"
                        ><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="detaillogin.html">
                            <img class="img-fluid w-100" src="img/product-8.jpg" alt="">
                        </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">Vợt cầu lông Victor Ryuga Metallic 2024</h6>
                        <div class="d-flex justify-content-center">
                            <h6>4.400.000đ</h6><h6 class="text-muted ml-2"><del>4.700.000đ</del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="detaillogin.html" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem Chi Tiết</a>
                        <a href="logedin.html" class="btn btn-sm text-dark p-0"            onclick="done()"
                        ><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm Vào Giỏ Hàng</a>
                    </div>
                </div>
            </div>
            <script>
                function done() {
                  alert("Đã thêm vào giỏ hàng!");
                }
              </script>

        </div>
    </div>
    <!-- Products End -->


    

    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="logedin.html" class="text-decoration-none">
                    <div style="display: flex; align-items: center; position: relative; top: -10px;">
                        <img src="img/logo.png" alt="a logo" width="85px" height="85px">
                        <span class="custom-font" style="margin-left: 10px; position: top; top: 10px;">Shop</span>
                    </div>
                </a>
                <p>Mọi thắc mắc xin liên hệ về.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>273 An Dương Vương, Phường 3, Quận 5, Thành Phố Hồ Chí Minh</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>MMBShopper102@gmail.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>012345678</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Liên Hệ Nhanh</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="logedin.html"><i class="fa fa-angle-right mr-2"></i>Trang Chủ</a>
                            <a class="text-dark mb-2" href="shoplogin.html"><i class="fa fa-angle-right mr-2"></i>Cửa Hàng</a>
                            <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Giỏ Hàng</a>
                            <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Kiểm Tra Thanh Toán</a>
                            <a class="text-dark" href="contactlogin.html"><i class="fa fa-angle-right mr-2"></i>Liên Hệ</a>
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