<?php
include 'src/header-login.php';
include 'class/user.php';
include 'class/cart.php';
// ✅ Khởi tạo database và các class
$data = new Database();
$qlkh = new QuanLyKhachHang($data);
$dh = new Order($data);
$gh = new Cart($data);
// ✅ Kiểm tra đăng nhập
if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
// ✅ Nếu người dùng bấm "Đặt hàng"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $result = $dh->TaoDonHang($user_id);

    echo "<script>
        alert('{$result['message']}');
        window.location = 'shoplogin.php';
    </script>";
    exit();
}
// ✅ Lấy thông tin người dùng
$user = $qlkh->layThongTinUser($user_id);
// ✅ Lấy danh sách sản phẩm trong giỏ
$cart_items = $gh->layGioHang($user_id);
if (empty($cart_items)) {
    echo "<script>
        alert('Giỏ hàng trống, không thể đặt hàng!');
        window.location = 'shoplogin.php';
    </script>";
    exit();
}
// ✅ Tính tổng tiền
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['DONGIA'] * $item['SOLUONG'];
}
// ✅ Phí vận chuyển & bảo hiểm
$shipping_fee = 50000;
$insurance_fee = 30000;
$final_total = $total + $shipping_fee + $insurance_fee;
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
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Thanh Toán</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="logedin.php">Trang Chủ</a></p>
                <!--<p class="m-0 px-2">-</p>
                <p class="m-0">Kiểm Tra</p>-->
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
    <form action="" method="POST">
        <div class="row px-xl-5">
            <!-- Cột trái: Thông tin giao hàng -->
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Địa Chỉ Giao Hàng</h4>
                    
                    <div class="row">
                        <input type="hidden" name="id" value="<?= $user['MAKH'] ?>">

                        <div class="col-md-6 form-group">
                            <label>Họ Và Tên</label>
                            <input class="form-control" type="text" name="fullname" value="<?= $user['HOTEN'] ?>" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="email" name="email" value="<?= $user['EMAIL'] ?>" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Số Điện Thoại</label>
                            <input class="form-control" type="text" name="numberphone" value="<?= $user['SDT'] ?>" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Địa Chỉ Liên Hệ</label>
                            <input class="form-control" type="text" name="address1" value="<?= $user['DIACHI1'] ?>" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Quận</label>
                            <input class="form-control" type="text" name="address" value="<?= $user['DIACHI'] ?>" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Thành Phố</label>
                            <input class="form-control" type="text" name="city" value="<?= $user['TP'] ?>" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Ngày Sinh</label>
                            <input class="form-control" type="date" name="birthday" value="<?= $user['NS'] ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột phải: Tổng đơn hàng và thanh toán -->
            <div class="col-lg-4">
                <!-- Card tổng đơn hàng -->
                <div class="card border-secondary mb-4">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Tổng Đơn Hàng</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Sản Phẩm</h5>

                        <?php foreach ($cart_items as $row): ?>
                            <div class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <img src="<?= str_replace('../', '', htmlspecialchars($row['IMAGE'])) ?>" width="50" class="mr-2">
                                    <span><?= $row['TENSP'] ?></span>
                                </div>
                                <span><?= number_format($row['DONGIA'] * $row['SOLUONG'], 0, ',', '.') ?>đ</span>
                            </div>
                            <?php $total += $row['DONGIA'] * $row['SOLUONG']; ?>
                        <?php endforeach; ?>

                        <hr class="mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="font-weight-medium">Tổng</h6>
                            <h6 class="font-weight-medium"><?= number_format($total, 0, ',', '.') ?> đ</h6>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="font-weight-medium">Phí Vận Chuyển</h6>
                            <h6 class="font-weight-medium"><?= number_format($shipping_fee, 0, ',', '.') ?> đ</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Phí Bảo Đảm</h6>
                            <h6 class="font-weight-medium"><?= number_format($insurance_fee, 0, ',', '.') ?> đ</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between">
                            <h5 class="font-weight-bold">Tổng Cộng</h5>
                            <h5 class="font-weight-bold">
                                <?= number_format($total + $shipping_fee + $insurance_fee, 0, ',', '.') ?> đ
                            </h5>
                        </div>
                    </div>
                </div>

                <!-- Card hình thức thanh toán -->
                <div class="card border-secondary mb-4">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Hình Thức Thanh Toán</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="paypal" value="cash" checked>
                                <label class="custom-control-label" for="paypal">Thanh Toán Bằng Tiền Mặt</label>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="directcheck" value="bank" onclick="showBankPopup()">
                                <label class="custom-control-label" for="directcheck">Ngân Hàng</label>
                            </div>
                        </div>
                        
                        <div class="form-group mb-0">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="eWallet" value="ewallet" onclick="showEWalletPopup()">
                                <label class="custom-control-label" for="eWallet">Ví Điện Tử</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <button type="submit" name="place_order" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3" onclick="return confirmOrder()">
                            Đặt Hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function confirmOrder() {
    alert("Đã đặt hàng thành công!");
    return true; // Cho phép form submit
}

function showBankPopup() {
    // Thêm code hiển thị popup ngân hàng ở đây
    console.log("Show bank popup");
}

function showEWalletPopup() {
    // Thêm code hiển thị popup ví điện tử ở đây
    console.log("Show e-wallet popup");
}
</script>
    <!-- Checkout End -->


     <!-- Footer Start -->
     <?php include 'src/footer.php';?>
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