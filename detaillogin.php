<!DOCTYPE html>
<html lang="en">
<?php
include 'database/connect.php';
session_start(); // 🔹 Đặt ở dòng đầu tiên của file!
$isLoggedIn = isset($_SESSION['user_id']); // Giả sử bạn lưu thông tin đăng nhập trong $_SESSION['user']
$data = new database();
// Lấy ID sản phẩm từ URL
if (!isset($_GET['id'])) {
    echo "Không tìm thấy sản phẩm!";
    exit;
}
$id = intval($_GET['id']);

$sql = "SELECT * FROM product WHERE id = ?";
$data->select_prepare($sql,"i", $id);
$product = $data->fetch();

if (!$product) {
    echo "Sản phẩm không tồn tại!";
    exit;
}


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
    <style>
        .product-info {
  font-size: 14px; /* Cỡ chữ nhỏ hơn tiêu đề */
  color: #333; /* Màu xám đậm để dễ nhìn */
}

.product-code {
  color: #e65100; /* Màu cam đỏ */
  font-weight: bold;
}

.brand {
  color: #e65100; /* Màu cam đỏ */
  font-weight: bold;
}

.status {
  color: #e65100; /* Màu cam đỏ */
  font-weight: bold;
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
                <a href="index.php" class="text-decoration-none">
                    <div style="display: flex; align-items: center; position: relative;">
                        <img src="img/logo.png" alt="a logo" width="85px" height="85px">
                        <span class="custom-font" style="margin-left: 10px; position: relative; top: 20px;">Shop</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="shop.php">
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
    <!-- <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Phân Loại Sản Phẩm</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                    <div class="navbar-nav w-100 overflow-hidden" style="height: 245px">
                        <a href="vot_login.html" class="nav-item nav-link">Vợt Cầu Lông</a>
                        <a href="giay_login.html" class="nav-item nav-link">Giầy Cầu Lông</a>
                        <a href="tui_login.html" class="nav-item nav-link">Túi Cầu Lông</a>
                        <a href="quan_login.html" class="nav-item nav-link">Quần Cầu Lông</a>
                        <a href="ao_login.html" class="nav-item nav-link">Áo Cầu Lông</a>
                        <a href="vay_login.html" class="nav-item nav-link">Váy Cầu Lông</a>
                       
                    </div>
                </nav>
            </div> -->
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
                    <!-- Menu bên trái -->
                    <div class="navbar-nav py-0">
                        <a href="index.php" class="nav-item nav-link active">Trang Chủ</a>
                        <a href="shop.php" class="nav-item nav-link">Sản Phẩm</a>
                        <a href="contact.php" class="nav-item nav-link">Liên Hệ</a>
                    </div>

                    <!-- Tài khoản bên phải nhưng đẩy vào trái 20px -->
                    <div class="navbar-nav ml-auto py-0">
    <?php if ($isLoggedIn): ?>
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                👤 <?php echo $_SESSION['username']; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                  <a href="logout.php" class="dropdown-item">Đăng Xuất</a>
                <a href="suathongtinuser.php" class="dropdown-item">Đổi thông tin</a>
                                  <a href="history.php" class="dropdown-item">Lịch sử mua hàng</a>

              
            </div>
        </div>
    <?php else: ?>
        <a href="Login.php" class="nav-item nav-link">Đăng Nhập</a>
        <a href="Signup.php" class="nav-item nav-link">Đăng Ký</a>
    <?php endif; ?>
</div>

        
    </div>
</div>

    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Thông Tin Chi Tiết</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="login.php">Trang Chủ</a></p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        <div class="carousel-item active">
                        <img class="w-100 h-100" src="<?= isset($product['image']) ? htmlspecialchars(str_replace('../', '', $product['image'])) : 'img/default.jpg'; ?>" 
     alt="<?= htmlspecialchars($product['name']) ?>">


                    </div>
    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 pb-5">

               <h3 class="font-weight-semi-bold"><?= htmlspecialchars($product['name']) ?></h3>

               <p class="product-info">
    Mã: <span class="product-code"><?= htmlspecialchars($product['productcode']) ?></span><br>
    Thương hiệu: <span class="brand"><?= htmlspecialchars($product['category']) ?></span> | Tình trạng: <span class="status">Còn hàng</span>
</p>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star-half-alt"></small>
                        <small class="far fa-star"></small>
                    </div>
                    <small class="pt-1">(50 Đánh Giá)</small>
                </div>
                <p class="mb-4">✔ Sản phẩm cam kết chính hãng<br>

                    ✔ Một số sản phẩm sẽ được tặng bao đơn hoặc bao nhung bảo vệ vợt<br>
                    
                    ✔ Thanh toán sau khi kiểm tra và nhận hàng (Giao khung vợt)<br>
                    
                    ✔ Bảo hành chính hãng theo nhà sản xuất (Trừ hàng nội địa, xách tay).</p>
               
                    <h3 class="font-weight-semi-bold mb-4"><?= number_format($product['price'], 0, ',', '.') ?> VND</h3>

                <div class="d-flex mb-4">
                    <form>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-1" name="color">
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-2" name="color">
                        </div>
                        <!--<div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-3" name="color">
                            <label class="custom-control-label" for="color-3">Red</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-4" name="color">
                            <label class="custom-control-label" for="color-4">Blue</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-5" name="color">
                            <label class="custom-control-label" for="color-5">Green</label>
                        </div>-->
                    </form>
                </div>
                <form action="addcart.php" method="POST">
    <input type="hidden" name="id" value="<?= $product['id']; ?>">

    <div class="d-flex align-items-center mb-4 pt-2">
        <div class="input-group quantity mr-3" style="width: 130px;">
            <div class="input-group-btn">
                <button type="button" class="btn btn-primary btn-minus">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <input type="text" id="quantity" class="form-control bg-secondary text-center" name="quantity" value="1" readonly>
            <div class="input-group-btn">
                <button type="button" class="btn btn-primary btn-plus">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <button onclick="addToCart()" type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
        </div>

       <script>
    const isLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;

    function addToCart() {
        if (!isLoggedIn) {
            alert("⚠ Bạn chưa đăng nhập!");
            window.location.href = "login.php";
        } else {
            alert("✅ Đã thêm vào giỏ hàng!");
        }
    }
</script>


</form>




<script>
document.addEventListener("DOMContentLoaded", function() {
    let quantityInput = document.getElementById("quantity");
    let btnMinus = document.querySelector(".btn-minus");
    let btnPlus = document.querySelector(".btn-plus");

    btnMinus.addEventListener("click", function() {
        let quantity = parseInt(quantityInput.value);
        if (quantity > 1) {
            quantityInput.value = quantity - 1;
        }
    });

    btnPlus.addEventListener("click", function() {
        let quantity = parseInt(quantityInput.value);
        quantityInput.value = quantity + 1;
    });
});
</script>



         




                <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Chia Sẻ:</p>
                    <div class="d-inline-flex">
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
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
                </div>


            </div>
        </div>

        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Mô Tả</a>
                    
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Đánh Giá</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Mô Tả Sản Phẩm</h4>
                        <p><?= htmlspecialchars($product['description']) ?></p>
                        <div class="center-content">
                            <div class="basel-tab-wrapper">
                                <a href="#tab-additional-information" class="basel-accordion-title tab-title-addtional-information"></a>
                                <h4 class="mb-3">Thông Tin Chi Tiết</h4>
                                <table class="woocommerce-product-attributes shop_attributes">
                                    <tbody>
                                        
                                        <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_diem-can-bang">
                                            <th class="woocommerce-product-attributes-item__label">Độ cứng</th>
                                            <td class="woocommerce-product-attributes-item__value"><?= htmlspecialchars($product['flex']) ?></td>
                                        </tr>

                                        <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_do-cung">
                                            <th class="woocommerce-product-attributes-item__label">Chiều dài vợt</th>
                                            <td class="woocommerce-product-attributes-item__value"><p><?= htmlspecialchars($product['length']) ?></td>
                                        </tr>
                                        
                                        <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_brand">
                                            <th class="woocommerce-product-attributes-item__label">Trọng lượng</th>
                                            <td class="woocommerce-product-attributes-item__value"><p><?= htmlspecialchars($product['weight']) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                        
                                
                            </div>
                        </div>
                        <style>
                            /* CSS to center the content */
                            .center-content {
                                display: flex;
                                align-items: left;
                                justify-content: left;
                                height: 50vh;
                                text-align: left;
                            }
                        
                            .basel-tab-wrapper {
                                width: 60%; /* Adjust width as needed */
                            }
                        
                            .woocommerce-product-attributes {
                                width: 100%;
                                margin: 0 auto;
                            }
                        
                            .row {
                                display: flex;
                                justify-content: center;
                            }
                        </style>
                 
                            
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">2 Đánh Giá Gần Đây Về Sản Phẩm</h4>
                                <div class="media mb-4">
                                    <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                    <div class="media-body">
                                        <h6>Kendrick Lmao<small> - <i>01 01 2045</i></small></h6>
                                        <div class="text-primary mb-2">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <p>Vợt nặng tay thiên về lối đánh tấn công, khó thuần , sản phẩm tốt.</p>
                                    </div>
                                </div>
                                <div class="media mb-4">
                                    <img src="img/user2.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                    <div class="media-body">
                                        <h6>Đờ rếch<small> - <i>01 20 2045</i></small></h6>
                                        <div class="text-primary mb-2">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <p>Vợt cho người đánh thiên công, khá khó đánh.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Để Lại Đánh Giá.</h4>
                              
                                <div class="d-flex my-3">
                                    <p class="mb-0 mr-2">Mức Đánh Giá * :</p>
                                    <div class="text-primary">
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </div>
                                <form>
                                    <div class="form-group">
                                        <label for="message">Đánh Giá Của Bạn *</label>
                                        <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Tên Của Bạn *</label>
                                        <input type="text" class="form-control" id="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email Của Bạn*</label>
                                        <input type="email" class="form-control" id="email">
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="submit" value="Gửi đánh giá" class="btn btn-primary px-3">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


 

    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="login.php" class="text-decoration-none">
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
                            <a class="text-dark mb-2" href="login.php"><i class="fa fa-angle-right mr-2"></i>Trang Chủ</a>
                            <a class="text-dark mb-2" href="shoplogin.php"><i class="fa fa-angle-right mr-2"></i>Cửa Hàng</a>
                            <a class="text-dark mb-2" href="cart.php"><i class="fa fa-angle-right mr-2"></i>Giỏ Hàng</a>
                            <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Kiểm Tra Thanh Toán</a>
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