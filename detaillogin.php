<?php
require_once 'src/systemManage.php';
include_once 'src/products.php';
include 'src/cart.php';
$quanly = new QuanLyHeThong();
$sp = new SanPham();
$gh = new Cart($data);
// Nếu chưa đăng nhập thì quay lại Signin
if (!isset($_SESSION['user_id'])) {
    header("Location: Signin.php");
    exit();
}
// Lấy sản phẩm theo ID
if (!isset($_GET['id'])) {
    echo "Không tìm thấy sản phẩm!";
    exit;
}
$id = intval($_GET['id']);
$product = $sp->XemCTSP($id);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra đăng nhập
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    // Lấy dữ liệu từ form
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    if ($quantity < 1) {
        $quantity = 1;
    }
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['id']; // ✅ Lấy từ form hidden input
    // Gọi class giỏ hàng
    $result = $gh->themVaoGio($user_id, $product_id, $quantity);
    if ($result['success']) {
        $_SESSION['success_message'] = "Sản phẩm đã được thêm vào giỏ hàng.";
    } else {
        $_SESSION['error_message'] = "Không thể thêm sản phẩm vào giỏ hàng.";
    }
    header("Location: cart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($product['TENSP']) ?> - MMB Shop</title>
    <link href="img/logo.png" rel="icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font & CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        /* 🩶 Tông màu xám – đen hiện đại */
        body {
            background-color: #f8f9fa;
            color: #333;
        }
        .text-primary, .fa-star, .fa-star-half-alt {
            color: #333 !important;
        }
        .btn-primary {
            background-color: #333;
            border: none;
        }
        .btn-primary:hover {
            background-color: #555;
        }
        .price {
            color: #000;
            font-size: 22px;
            font-weight: 600;
        }
        .section-title span {
            background-color: #f1f1f1;
            color: #000;
        }
        .product-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 6px;
        }
        .nav-tabs .nav-link.active {
            border-color: #000 !important;
            color: #000 !important;
        }
        .nav-tabs .nav-link:hover {
            color: #000 !important;
        }
        .tab-content p {
            color: #444;
            line-height: 1.6;
        }
        .product-info {
            font-size: 14px;
            color: #333;
        }
        .product-code, .brand, .status {
            color: #000;
            font-weight: bold;
        }
        .bg-secondary {
            background-color: #e9ecef !important;
        }
        a, a:hover {
            color: #000;
        }
    </style>
</head>

<body>
    <!-- Header đăng nhập -->
    <?php include "src/header-login.php"; ?>
    <!-- Tiêu đề trang -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px;">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Chi Tiết Sản Phẩm</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="login.php">Trang Chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Chi Tiết</p>
            </div>
        </div>
    </div>

    <!-- Chi tiết sản phẩm -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <!-- Ảnh -->
            <div class="col-lg-5 pb-5">
                <img class="product-image" src="<?= htmlspecialchars($product['IMAGE']); ?>" alt="<?= htmlspecialchars($product['TENSP']); ?>">
            </div>

            <!-- Thông tin -->
            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold mb-3"><?= htmlspecialchars($product['TENSP']); ?></h3>
                <p class="product-info">
                    Mã: <span class="product-code"><?= htmlspecialchars($product['BARCODE'] ?? 'N/A') ?></span><br>
                    Thương hiệu: <span class="brand"><?= htmlspecialchars($product['TENLOAI'] ?? 'Không rõ') ?></span> |
                    Tình trạng: <span class="status">Còn hàng</span>
                </p>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star-half-alt"></small>
                        <small class="far fa-star"></small>
                    </div>
                    <small>(50 đánh giá)</small>
                </div>
                <h3 class="price mb-4"><?= number_format($product['DONGIA'], 0, ',', '.'); ?>đ</h3>
                <p class="mb-4"><?= nl2br(htmlspecialchars($product['MOTA'])); ?></p>

                <form id="addToCartForm" action="" method="POST">
    <input type="hidden" name="id" value="<?= $product['MASP']; ?>">

    <div class="d-flex align-items-center mb-4 pt-2">
        <div class="input-group quantity mr-3" style="width: 130px;">
            <div class="input-group-prepend">
                <button type="button" class="btn btn-dark btn-minus">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <input 
                type="text" 
                id="quantity" 
                name="quantity" 
                class="form-control text-center bg-light" 
                value="1" 
                readonly>
            <div class="input-group-append">
                <button type="button" class="btn btn-dark btn-plus">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-dark px-3">
            <i class="fa fa-shopping-cart mr-1"></i> Thêm vào giỏ hàng
        </button>
    </div>
</form>

            </div>
        </div>

        <!-- Tabs -->
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Mô Tả</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Thông Tin Chi Tiết</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Đánh Giá</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Mô Tả Sản Phẩm</h4>
                        <p><?= nl2br(htmlspecialchars($product['MOTA'])); ?></p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <h4 class="mb-3">Thông Tin Chi Tiết</h4>
                        <table class="table table-bordered">
                            <tr><th>Mã SP</th><td><?= htmlspecialchars($product['BARCODE']); ?></td></tr>
                            <tr><th>Thương hiệu</th><td><?= htmlspecialchars($product['TENLOAI'] ?? 'Không rõ'); ?></td></tr>
                            <tr><th>Độ cứng</th><td><?= htmlspecialchars($product['FLEX']); ?></td></tr>
                            <tr><th>Trọng lượng</th><td><?= htmlspecialchars($product['WEIGHT']); ?></td></tr>
                            <tr><th>Số lượng</th><td><?= htmlspecialchars($product['SOLUONG']); ?></td></tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <h4>Chưa có đánh giá nào</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include "src/footer.php"; ?>

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    const btnMinus = document.querySelector(".btn-minus");
    const btnPlus = document.querySelector(".btn-plus");
    const quantityInput = document.getElementById("quantity");

    if (btnMinus && btnPlus && quantityInput) {
        btnMinus.addEventListener("click", function () {
            let value = parseInt(quantityInput.value) || 1;
            if (value > 1) quantityInput.value = value - 1;
        });

        btnPlus.addEventListener("click", function () {
            let value = parseInt(quantityInput.value) || 1;
            quantityInput.value = value + 1;
        });
    }
});
</script>
</body>
</html>
