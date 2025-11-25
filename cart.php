<!DOCTYPE html>
<html lang="en">
<?php include "src/header-login.php"; ?>
    <?php
    $data = new database();
    $isLoggedIn = isset($_SESSION['user_id']);
    $total = 0;

    if (!isset($_SESSION['username'])) {
        header("Location: Signin.php");
        exit();
    }
    $user_id = $_SESSION['user_id'];

    // Lấy danh sách sản phẩm trong giỏ hàng0
    $data->select_prepare("
        SELECT sp.MASP,g.MAGH,sp.TENSP,sp.IMAGE,sp.DONGIA,g.SOLUONG 
        FROM gio_hang g 
        JOIN san_pham sp ON g.MASP = sp.MASP
        WHERE g.MAKH = ?
    ", "i", $user_id);

    $cart_items = [];
    while ($row = $data->fetch()) {
        $cart_items[] = $row;
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
</head>

<body>
    <!-- Topbar Start -->
    <!-- Navbar End -->


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
                            $subtotal = $item['DONGIA'] * $item['SOLUONG'];
                            $total += $subtotal;
                    ?>
                        <tr>
                            <td class="align-middle"><img src="<?= str_replace('../', '', htmlspecialchars($item['IMAGE'])) ?>" width="50"> <?= $item['TENSP'] ?></td>
                            <td class="align-middle"><?= number_format($item['DONGIA'], 0, ',', '.') ?> VND</td>
                            <td class="align-middle"><?= $item['SOLUONG'] ?></td>
                            <td class="align-middle"><?= number_format($subtotal, 0, ',', '.') ?> VND</td>
                            <td class="align-middle"><a href="removecart.php?id=<?= $item['MAGH'] ?>" class="btn btn-sm btn-danger">Xóa</a></td>
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
    <?php include "src/footer.php"; ?>
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