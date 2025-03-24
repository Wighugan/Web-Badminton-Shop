
<!DOCTYPE html>
<html lang="en">
<?php
session_start(); // 🔹 Đặt ở dòng đầu tiên của file!


include "db.php"; // Kết nối database


// Lấy ID sản phẩm từ URL
if (!isset($_GET['id'])) {
    echo "Không tìm thấy sản phẩm!";
    exit;
}
$id = intval($_GET['id']);

$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "Sản phẩm không tồn tại!";
    exit;
}


?>

<?php include 'header.php'; ?>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="logedin.php" class="text-decoration-none d-block d-lg-none">
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
                            <a href="index.php" class="nav-item nav-link active">Trang Chủ</a>
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
                                    <a href="suathongtinuser.php" class="dropdown-item">Đổi Thông Tin</a>
                                    <a href="history.php" class="dropdown-item">Lịch sử mua hàng</a>
                        </div>
                    </div>
                </nav>
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Thông Tin Chi Tiết</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="logedin.html">Trang Chủ</a></p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Detail Start -->
    <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <!-- Hình ảnh sản phẩm -->
        <div class="col-lg-5 pb-5">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner border">
                    <div class="carousel-item active">
                    <img class="w-100 h-100" 
                        src="<?= isset($product['image1']) ? '../img/' . htmlspecialchars($product['image1']) : '../img/default.jpg'; ?>" 
                        alt="Product Image">

                    </div>
                    <!-- <div class="carousel-item">
                        <img class="w-100 h-100" src="img/<?= htmlspecialchars($product['image2']) ?>" alt="Image">
                    </div>
                    <div class="carousel-item">
                        <img class="w-100 h-100" src="img/<?= htmlspecialchars($product['image3']) ?>" alt="Image">
                    </div>
                    <div class="carousel-item">
                        <img class="w-100 h-100" src="img/<?= htmlspecialchars($product['image4']) ?>" alt="Image">
                    </div> -->
                </div>
                <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>
            </div>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold"><?= htmlspecialchars($product['name']) ?></h3>
            <div class="d-flex mb-3">
                <div class="text-primary mr-2">
                    <?php
                    // $fullStars = floor($product['rating']);
                    // $halfStar = ($product['rating'] - $fullStars) >= 0.5 ? 1 : 0;
                    // $emptyStars = 5 - ($fullStars + $halfStar);

                    // for ($i = 0; $i < $fullStars; $i++) echo '<small class="fas fa-star"></small>';
                    // if ($halfStar) echo '<small class="fas fa-star-half-alt"></small>';
                    // for ($i = 0; $i < $emptyStars; $i++) echo '<small class="far fa-star"></small>';
                    // ?>
                </div>
                <!-- <small class="pt-1">(<?= $product['reviews'] ?> Đánh Giá)</small> -->
            </div>
            <h3 class="font-weight-semi-bold mb-4"><?= number_format($product['price'], 0, ',', '.') ?> VND</h3>

            <!-- Màu sắc -->
            <div class="d-flex mb-4">
                <!-- <p class="text-dark font-weight-medium mb-0 mr-3">Màu Sắc:</p> -->
                <form>
                    <?php 
                    $colors = isset($product['color_options']) ? $product['color_options'] : [];
                    foreach ($colors as $index => $color) : ?>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-<?= $index ?>" name="color">
                            <label class="custom-control-label" for="color-<?= $index ?>"><?= htmlspecialchars($color) ?></label>
                        </div>
                    <?php endforeach; ?>
                </form>
            </div>

            <!-- Số lượng & Nút thêm vào giỏ hàng -->
            <div class="d-flex align-items-center mb-4 pt-2">
                <div class="input-group quantity mr-3" style="width: 130px;">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-minus">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control bg-secondary text-center" value="1">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-plus">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="product_name" value="<?= $product['name'] ?>">
                    <input type="hidden" name="product_price" value="<?= $product['price'] ?>">
                    <button type="submit" name="add_to_cart" class="btn btn-primary px-3">
                        <i class="fa fa-shopping-cart mr-1"></i> Thêm Vào Giỏ Hàng
                    </button>
                </form>
            </div>

            <script>
                function done() {
                    alert("Đã thêm vào giỏ hàng!");
                }
            </script>
        </div>
    </div>
</div>

</body>
</html>

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
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Mô Tả</a>
                    
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Đánh Giá</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Mô Tả Sản Phẩm</h4>
                        <p>Vợt cầu lông Yonex Astrox 100ZZ kurenai đỏ tấn công cực kỳ mạnh mẽ, vung vợt nhanh, mượt và ít biến dạng thân vợt. Vợt nặng đầu, thân cứng cho ra các cú smash, tạt cầu uy lực, cầu bay nhanh, mạnh, cắm sân. Công nghệ vợt chống rung chống xoắn, giúp người chơi có những pha cầu chắc chắn, ổn định và chính xác nhất.</p>
                        <div class="center-content">
                            <div class="basel-tab-wrapper">
                                <a href="#tab-additional-information" class="basel-accordion-title tab-title-addtional-information"></a>
                                <h4 class="mb-3">Thông Tin Chi Tiết</h4>
                                <table class="woocommerce-product-attributes shop_attributes">
                                    <tbody>
                                        <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_brand">
                                            <th class="woocommerce-product-attributes-item__label">Thương Hiệu</th>
                                            <td class="woocommerce-product-attributes-item__value"><p>Yonex</p></td>
                                        </tr>
                                        <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_diem-can-bang">
                                            <th class="woocommerce-product-attributes-item__label">Mã Sản Phẩm</th>
                                            <td class="woocommerce-product-attributes-item__value"><p>KNS49</p></td>
                                        </tr>
                                        <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_do-cung">
                                            <th class="woocommerce-product-attributes-item__label">Xuất Xứ</th>
                                            <td class="woocommerce-product-attributes-item__value"><p>Nhật Bản</p></td>
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