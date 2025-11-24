<!DOCTYPE html>
<html lang="vi">
<head>
    <?php
    require_once 'class/products.php';
    $data = new Database();
    // Lấy ID sản phẩm từ URL
    if (!isset($_GET['id'])) {
        echo "Không tìm thấy sản phẩm!";
        exit;
    }
    
    $id = intval($_GET['id']);
    $sql = "SELECT sp.*, ls.TENLOAI 
            FROM san_pham sp
            LEFT JOIN loai_sp ls ON sp.MALOAI = ls.MALOAI
            WHERE sp.MASP = ?";
    $data->select_prepare($sql, "i", $id);
    $product = $data->fetch();
    
    if (!$product) {
        echo "Sản phẩm không tồn tại!";
        exit;
    }
    ?>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($product['TENSP']); ?> - MMB Shop</title>
    <link href='img/logo.png' rel='icon' type='image/x-icon' />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

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
            font-size: 14px;
            color: #333;
            margin-bottom: 20px;
        }
        .product-code, .brand, .status {
            color: #e65100;
            font-weight: bold;
        }
        .product-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php include "src/header.php"; ?>
    
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Thông Tin Chi Tiết</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="index.php">Trang Chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Chi Tiết Sản Phẩm</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
    
    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <!-- Ảnh sản phẩm -->
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        <div class="carousel-item active">
                            <img class="product-image" 
                                 src="<?php echo htmlspecialchars($product['IMAGE']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['TENSP']); ?>"
                                 onerror="this.src='img/default-product.jpg'">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold mb-3">
                    <?php echo htmlspecialchars($product['TENSP']); ?>
                </h3>

                <p class="product-info">
                    Mã: <span class="product-code"><?php echo htmlspecialchars($product['BARCODE']); ?></span><br>
                    Thương hiệu: <span class="brand"><?php echo htmlspecialchars($product['TENLOAI'] ?? 'Không rõ'); ?></span> | 
                    Tình trạng: <span class="status">
                        <?php echo $product['SOLUONG'] > 0 ? 'Còn hàng' : 'Hết hàng'; ?>
                    </span>
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
                
                <p class="mb-4">
                    ✔ Sản phẩm cam kết chính hãng<br>
                    ✔ Một số sản phẩm sẽ được tặng bao đơn hoặc bao nhung bảo vệ vợt<br>
                    ✔ Thanh toán sau khi kiểm tra và nhận hàng (Giao khung vợt)<br>
                    ✔ Bảo hành chính hãng theo nhà sản xuất (Trừ hàng nội địa, xách tay)
                </p>
               
                <h3 class="font-weight-semi-bold mb-4 text-danger">
                    <?php echo number_format($product['DONGIA'], 0, ',', '.'); ?> VND
                </h3>

                <!-- Form thêm vào giỏ hàng -->
                <form onsubmit="return showLoginAlert();">
                    <input type="hidden" name="id" value="<?php echo $product['MASP']; ?>">
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-minus" onclick="changeQuantity(-1)">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" id="quantity" class="form-control bg-secondary text-center" 
                                   name="quantity" value="1" readonly>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-plus" onclick="changeQuantity(1)">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary px-3">
                            <i class="fa fa-shopping-cart mr-1"></i> Thêm vào giỏ hàng
                        </button>
                    </div>
                </form>

                <script>
                // Tăng giảm số lượng
                function changeQuantity(delta) {
                    const input = document.getElementById('quantity');
                    let value = parseInt(input.value) || 1;
                    value = Math.max(1, value + delta);
                    input.value = value;
                }

                // Hiển thị cảnh báo khi chưa đăng nhập
                function showLoginAlert() {
                    if (confirm("⚠️ Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!\n\nBạn có muốn đăng nhập ngay không?")) {
                        window.location.href = 'Signin.php';
                    }
                    return false;
                }
                </script>

                <!-- Chia sẻ -->
                <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Chia Sẻ:</p>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="#" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="#" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="#" title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="#" title="Pinterest">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tabs Mô tả và Đánh giá -->
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Mô Tả</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Thông Tin Chi Tiết</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Đánh Giá (2)</a>
                </div>
                
                <div class="tab-content">
                    <!-- Tab Mô tả -->
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Mô Tả Sản Phẩm</h4>
                        <p><?php echo nl2br(htmlspecialchars($product['MOTA'])); ?></p>
                    </div>
                    
                    <!-- Tab Thông tin chi tiết -->
                    <div class="tab-pane fade" id="tab-pane-2">
                        <h4 class="mb-3">Thông Tin Chi Tiết</h4>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="200">Mã sản phẩm</th>
                                    <td><?php echo htmlspecialchars($product['BARCODE']); ?></td>
                                </tr>
                                <tr>
                                    <th>Thương hiệu</th>
                                    <td><?php echo htmlspecialchars($product['TENLOAI'] ?? 'Không rõ'); ?></td>
                                </tr>
                                <tr>
                                    <th>Độ cứng</th>
                                    <td><?php echo htmlspecialchars($product['FLEX']); ?></td>
                                </tr>
                                <tr>
                                    <th>Chiều dài vợt</th>
                                    <td><?php echo htmlspecialchars($product['LENGTH']); ?></td>
                                </tr>
                                <tr>
                                    <th>Trọng lượng</th>
                                    <td><?php echo htmlspecialchars($product['WEIGHT']); ?></td>
                                </tr>
                                <tr>
                                    <th>Số lượng trong kho</th>
                                    <td><?php echo htmlspecialchars($product['SOLUONG']); ?> sản phẩm</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Tab Đánh giá -->
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">2 Đánh Giá Gần Đây</h4>
                                
                                <div class="media mb-4">
                                    <img src="img/user.jpg" alt="User" class="img-fluid mr-3 mt-1" 
                                         style="width: 45px; height: 45px; border-radius: 50%;">
                                    <div class="media-body">
                                        <h6>Kendrick Lmao<small> - <i>01/01/2045</i></small></h6>
                                        <div class="text-primary mb-2">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <p>Vợt nặng tay thiên về lối đánh tấn công, khó thuần, sản phẩm tốt.</p>
                                    </div>
                                </div>
                                
                                <div class="media mb-4">
                                    <img src="img/user2.jpg" alt="User" class="img-fluid mr-3 mt-1" 
                                         style="width: 45px; height: 45px; border-radius: 50%;">
                                    <div class="media-body">
                                        <h6>Đờ rếch<small> - <i>20/01/2045</i></small></h6>
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
                                <h4 class="mb-4">Để Lại Đánh Giá</h4>
                                <small class="text-muted">Bạn cần đăng nhập để đánh giá sản phẩm</small>
                                
                                <div class="d-flex my-3">
                                    <p class="mb-0 mr-2">Mức Đánh Giá *:</p>
                                    <div class="text-primary">
                                        <i class="far fa-star star-rating" data-rating="1"></i>
                                        <i class="far fa-star star-rating" data-rating="2"></i>
                                        <i class="far fa-star star-rating" data-rating="3"></i>
                                        <i class="far fa-star star-rating" data-rating="4"></i>
                                        <i class="far fa-star star-rating" data-rating="5"></i>
                                    </div>
                                </div>
                                
                                <form onsubmit="return showLoginAlert();">
                                    <div class="form-group">
                                        <label for="message">Đánh Giá Của Bạn *</label>
                                        <textarea id="message" cols="30" rows="5" class="form-control" 
                                                  placeholder="Nhập đánh giá của bạn..."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Tên Của Bạn *</label>
                                        <input type="text" class="form-control" id="name" placeholder="Nhập tên của bạn">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email Của Bạn *</label>
                                        <input type="email" class="form-control" id="email" placeholder="Nhập email của bạn">
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary px-3">
                                            Gửi đánh giá
                                        </button>
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

    <!-- Footer -->
    <?php include "src/footer.php"; ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>