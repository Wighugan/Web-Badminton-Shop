<!DOCTYPE html>
<html lang="en">
`

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
     <?php include "src/header-login.php"; ?>
     <?php
include 'database/connect.php';
$data = new database();
$isLoggedIn = isset($_SESSION['user_id']);
$total = 0;

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

// Lấy danh sách sản phẩm trong giỏ hàng
$data->select_prepare("
    SELECT product.id AS product_id,cart.id AS cart_id,product.name,product.image,product.price,cart.quantity FROM cart 
    JOIN product ON cart.product_id = product.id 
    WHERE cart.user_id = ?
", "i", $user_id);

$cart_items = [];
while ($row = $data->fetch()) {
    $cart_items[] = $row;
}
?>
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Giỏ Hàng</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="logedin.php">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Giỏ Hàng</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
    <div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr>
                        <th>Sản Phẩm</th>
                        <th>Giá Tiền</th>
                        <th>Số Lượng</th>
                        <th>Tổng Tiền</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    if (!empty($cart_items)): 
                        foreach ($cart_items as $item): 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                    ?>
                        <tr>
                            <td class="align-middle"><img src="<?= str_replace('../', '', htmlspecialchars($item['image'])) ?>" width="50"> <?= $item['name'] ?></td>
                            <td class="align-middle"><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                            <td class="align-middle"><?= $item['quantity'] ?></td>
                            <td class="align-middle"><?= number_format($subtotal, 0, ',', '.') ?> VND</td>
                            <td class="align-middle"><a href="removecart.php?id=<?= $item['cart_id'] ?>" class="btn btn-sm btn-danger">Xóa</a></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Tổng tiền:</strong></td>
                        <td colspan="2"><strong><?= number_format($total, 0, ',', '.') ?> VND</strong></td>
                    </tr>
                    <?php else: ?>
                        <tr><td colspan="5">Giỏ hàng trống!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

</div>
<div class="col-lg-4">
    <form class="mb-5" action="">
        <div class="input-group">
            <input type="text" class="form-control p-4" placeholder="Mã Giảm Giá">
            <div class="input-group-append">
                <button class="btn btn-primary">Áp Dụng</button>
            </div>
        </div>
    </form>
    <div class="card border-secondary mb-5">
    <?php
$shipping_fee = 50000;
$insurance_fee = 30000;

// Nếu giỏ hàng trống, không tính phí
if ($total == 0) {
    $shipping_fee = 0;
    $insurance_fee = 0;
}

$final_total = $total + $shipping_fee + $insurance_fee;
?>

<div class="card-header bg-secondary border-0">
    <h4 class="font-weight-semi-bold m-0">Giỏ Hàng</h4>
</div>
<div class="card-body">
    <div class="d-flex justify-content-between mb-3 pt-1">
        <h6 class="font-weight-medium">Tổng</h6>
        <h6 class="font-weight-medium"><?= number_format($total, 0, ',', '.') ?> VND</h6>
    </div>
    <div class="d-flex justify-content-between">
        <h6 class="font-weight-medium">Phí Vận Chuyển</h6>
        <h6 class="font-weight-medium"><?= number_format($shipping_fee, 0, ',', '.') ?> VND</h6>
    </div>
    <div class="d-flex justify-content-between mb-3 pt-1">
        <h6 class="font-weight-medium">Phí Bảo Đảm</h6>
        <h6 class="font-weight-medium"><?= number_format($insurance_fee, 0, ',', '.') ?> VND</h6>
    </div>
</div>
<div class="card-footer border-secondary bg-transparent">
    <div class="d-flex justify-content-between mt-2">
        <h5 class="font-weight-bold">Tổng Cộng</h5>
        <h5 class="font-weight-bold">
            <?= number_format($final_total, 0, ',', '.') ?> VND
        </h5>
    </div>
</div>

            <form action="checkout.php">
                <button class="btn btn-block btn-primary my-3 py-3">Thanh Toán</button>
            </form>
        </div>
    </div>
</div>
    </div>
    <!-- Cart End -->


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