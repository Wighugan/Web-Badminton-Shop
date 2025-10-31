<?php
include 'src/header-login.php';
// Kiểm tra nếu chưa đăng nhập thì chuyển về login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: Signin.php");
    exit();
}
$isLoggedIn = true; // User đã đăng nhập
// Lấy 8 sản phẩm nổi bật
$sp = new SanPham();
$featured_products = $sp->lietketspnb();
// Lấy 8 sản phẩm mới nhất
$new_products = $sp->lietketspmoi();
// Link chi tiết sản phẩm cho user đã đăng nhập
$detailLink = 'detaillogin.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>MMB - Shop Bán Đồ Cầu Lông</title>
    <link href='img/logo.png' rel='icon' type='image/x-icon' />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

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
    <!-- Header -->
    <?php  ?>

    <!-- Carousel Start -->
    <div id="header-carousel" class="carousel slide" data-ride="carousel" style="width: 100vw; overflow: hidden;">
        <div class="carousel-inner">
            <div class="carousel-item active" style="height: 410px;">
                <img class="w-100" style="object-fit: cover; height: 100%;" src="img/carousel-1.jpg" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 700px;">
                        <h4 class="text-light text-uppercase font-weight-medium mb-3">Giảm giá 10%</h4>
                        <h3 class="display-4 text-white font-weight-semi-bold mb-4">Áo và Quần cầu lông</h3>
                        <a href="shoplogin.php" class="btn btn-light py-2 px-3">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item" style="height: 410px;">
                <img class="w-100" style="object-fit: cover; height: 100%;" src="img/carousel-2.jpg" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 700px;">
                        <h4 class="text-light text-uppercase font-weight-medium mb-3">Giảm 20%</h4>
                        <h3 class="display-4 text-white font-weight-semi-bold mb-4">Cho đơn hàng đầu tiên</h3>
                        <a href="shoplogin.php" class="btn btn-light py-2 px-3">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item" style="height: 410px;">
                <img class="w-100" style="object-fit: cover; height: 100%;" src="img/carousel-3.jpg" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 700px;">
                        <h4 class="text-light text-uppercase font-weight-medium mb-3">Ưu đãi</h4>
                        <h3 class="display-4 text-white font-weight-semi-bold mb-4">Bảo hành trong 12 tháng</h3>
                        <a href="shoplogin.php" class="btn btn-light py-2 px-3">Shop Now</a>
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
    <!-- Carousel End -->

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

    <!-- Offer Start -->
    <div class="container-fluid offer pt-5">
        <div class="row px-xl-5">
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                    <img src="img/offer-1.png" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">Giảm 20% Bộ Sưu Tập</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Yonex Astrox</h1>
                        <a href="shoplogin.php" class="btn btn-outline-primary py-md-2 px-md-3">Xem Ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-left text-white mb-2 py-5 px-5">
                    <img src="img/offer-2.png" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">Giảm 20% Bộ Sưu Tập</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Lining Tectonic</h1>
                        <a href="shoplogin.php" class="btn btn-outline-primary py-md-2 px-md-3">Xem Ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->

    <!-- Sản Phẩm Nổi Bật Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sản Phẩm Nổi Bật</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <?php if (!empty($featured_products)): ?>
                <?php foreach ($featured_products as $product): ?>
                    <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <a href="<?php echo $detailLink; ?>?id=<?php echo (int)$product['MASP']; ?>">
                                    <img class="img-fluid w-100" 
                                         src="<?php echo htmlspecialchars($product['IMAGE']); ?>" 
                                         alt="<?php echo htmlspecialchars($product['TENSP']); ?>"
                                         style="height: 300px; object-fit: cover;">
                                </a>
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3">
                                    <?php echo htmlspecialchars($product['TENSP']); ?>
                                </h6>
                                <div class="d-flex justify-content-center">
                                    <h6><?php echo number_format($product['DONGIA'], 0, ',', '.'); ?>đ</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Hiện chưa có sản phẩm nào
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Sản Phẩm Nổi Bật End -->

    <!-- Sản Phẩm Mới Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sản Phẩm Mới</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <?php if (!empty($new_products)): ?>
                <?php foreach ($new_products as $product): ?>
                    <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <a href="<?php echo $detailLink; ?>?id=<?php echo (int)$product['MASP']; ?>">
                                    <img class="img-fluid w-100" 
                                         src="<?php echo htmlspecialchars($product['IMAGE']); ?>" 
                                         alt="<?php echo htmlspecialchars($product['TENSP']); ?>">
                                </a>
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3">
                                    <?php echo htmlspecialchars($product['TENSP']); ?>
                                </h6>
                                <div class="d-flex justify-content-center">
                                    <h6><?php echo number_format($product['DONGIA'], 0, ',', '.'); ?>đ</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Hiện chưa có sản phẩm mới nào
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Sản Phẩm Mới End -->

    <!-- Footer -->
    <?php include "src/footer.php"; ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>
    <script src="js/main.js"></script>
</body>
</html>