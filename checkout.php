<!DOCTYPE html>
<html lang="en">
<?php
include 'db.php';
session_start();

$isLoggedIn = isset($_SESSION['user_id']); // Giả sử bạn lưu thông tin đăng nhập trong $_SESSION['user']
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Kết nối MySQL
$conn = new mysqli("localhost", "root", "", "mydp");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin user
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    die("Không tìm thấy người dùng!");
}

// Lấy sản phẩm trong giỏ hàng
$sql = "SELECT p.id as product_id, p.name as product_name, p.price as product_price, p.image, c.quantity
        FROM cart c 
        JOIN product p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_result = $stmt->get_result();

$cart_items = [];
$total = 0;

while ($row = $cart_result->fetch_assoc()) {
    $cart_items[] = $row;
}

if (empty($cart_items)) {
    die("Giỏ hàng trống, không thể đặt hàng!");
}

// Tạo mã đơn hàng ngẫu nhiên
$shipping_fee = 50000;
$insurance_fee = 30000;
// 1. Tạo đơn hàng trong bảng orders

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
                <form action="index.php">
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
                        <a href="giay_login.html" class="nav-item nav-link">Giày Cầu Lông</a>
                        <a href="tui_login.html" class="nav-item nav-link">Túi Cầu Lông</a>
                        <a href="quan_login.html" class="nav-item nav-link">Quần Cầu Lông</a>
                        <a href="ao_login.html" class="nav-item nav-link">Áo Cầu Lông</a>
                        <a href="vay_login.html" class="nav-item nav-link">Váy Cầu Lông</a>
                        
                            
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
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Địa Chỉ Giao Hàng</h4>
                    <form action="update.php" method="POST">
                    <div class="row">


                        <div class="col-md-6 form-group">
                            <label>Họ Và Tên</label>
                            <input class="form-control" type="text" name="fullname"  value="<?= $user['fullname'] ?>" required>
                        </div>
                       
                        <div class="col-md-6 form-group">
                            <label>E-mail:</label>
                            <input class="form-control" type="text" id="email" name="email" value="<?= $user['email'] ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số Điện Thoại:</label>
                            <input class="form-control" type="text" id="numberphone" name="numberphone" value="<?= $user['numberphone'] ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa Chỉ Liên Hệ:</label>
                            <input class="form-control" type="text" id="address" name="address" value="<?= $user['address1'] ?>" required>
                        </div>
                       
                      <div class="col-md-6 form-group">
                            <label>Quận:</label>
                            <input class="form-control" type="text" id="address" name="address" value="<?= $user['address'] ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Thành Phố:</label>
                            <input class="form-control" type="text" id="city" name="city" value="<?= $user['city'] ?>" required>
                        </div>
</form>
                        <!--<div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="newaccount">
                                <label class="custom-control-label" for="newaccount">Create an account</label>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="shipto">
                                <label class="custom-control-label" for="shipto"  data-toggle="collapse" data-target="#shipping-address">Ship to different address</label>
                            </div>
                        </div>-->
                    </div>
                </div>
                <div class="collapse mb-4" id="shipping-address">
                    <h4 class="font-weight-semi-bold mb-4">Shipping Address</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control" type="text" placeholder="John">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control" type="text" placeholder="Doe">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="text" placeholder="example@email.com">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control" type="text" placeholder="+123 456 789">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1</label>
                            <input class="form-control" type="text" placeholder="123 Street">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 2</label>
                            <input class="form-control" type="text" placeholder="123 Street">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <select class="custom-select">
                                <option selected>United States</option>
                                <option>Afghanistan</option>
                                <option>Albania</option>
                                <option>Algeria</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input class="form-control" type="text" placeholder="New York">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <input class="form-control" type="text" placeholder="New York">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>ZIP Code</label>
                            <input class="form-control" type="text" placeholder="123">
                        </div>
                    </div>
                </div>
            </div>

           <div class="col-lg-4">
    <div class="card border-secondary mb-5">
        <div class="card-header bg-secondary border-0">
            <h4 class="font-weight-semi-bold m-0">Tổng Đơn Hàng</h4>
        </div>
        <form action="checkout_process.php" method="POST">
        <div class="card-body">
            <h5 class="font-weight-medium mb-3">Sản Phẩm</h5>

            <?php foreach ($cart_items as $row): ?>
                <div class="d-flex justify-content-between">
                    <p><img src="<?= str_replace('../', '', htmlspecialchars($row['image'])) ?>" width="50"> </p>
                    <p><?= $row['product_name'] ?></p>
                    <p><?= number_format($row['product_price'] * $row['quantity'], 0, ',', '.') ?>đ</p>
                </div>
                <?php $total += $row['product_price'] * $row['quantity']; ?>
                <?php endforeach; ?>

            <hr class="mt-0">
            <div class="d-flex justify-content-between mb-3 pt-1">
                <h6 class="font-weight-medium">Tổng</h6>
                <h6 class="font-weight-medium"><?= number_format($total, 0, ',', '.') ?> đ</h6>
            </div>
            <div class="d-flex justify-content-between">
                <h6 class="font-weight-medium">Phí Vận Chuyển</h6>
                <h6 class="font-weight-medium"><?= number_format($shipping_fee, 0, ',', '.') ?> đ</h6>
            </div>
            <div class="d-flex justify-content-between">
                <h6 class="font-weight-medium">Phí Bảo Đảm</h6>
                <h6 class="font-weight-medium"><?= number_format($insurance_fee, 0, ',', '.') ?> đ</h6>
            </div>
        </div>
        <div class="card-footer border-secondary bg-transparent">
            <div class="d-flex justify-content-between mt-2">
                <h5 class="font-weight-bold">Tổng Cộng</h5>
                <h5 class="font-weight-bold">
                    <?= number_format($total + $shipping_fee + $insurance_fee, 0, ',', '.') ?> đ
                </h5>
            </div>
        </div>
    </div>


                    
            



                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Hình Thức Thanh Toán</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="paypal">
                                <label class="custom-control-label" for="paypal">Thanh Toán Bằng Tiền Mặt</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="directcheck" onclick="showBankPopup()">
                                <label class="custom-control-label" for="directcheck">Ngân Hàng</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="eWallet" onclick="showEWalletPopup()">
                                <label class="custom-control-label" for="eWallet">Ví Điện Tử</label>
                            </div>
                        </div>
                        
                        <script>
                            function showBankPopup() {
                                const popupContent = `
                                    <style>
                                        /* Toàn bộ popup */
                                        #popup {
                                            position: fixed;
                                            top: 50%;
                                            left: 50%;
                                            transform: translate(-50%, -50%);
                                            background-color: #f9f9f9;
                                            border-radius: 15px;
                                            border: 1px solid #e0e0e0;
                                            padding: 20px;
                                            width: 600px;
                                            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
                                            z-index: 1000;
                                            font-family: Arial, sans-serif;
                                            color: #333;
                                        }
                                        #popup h3 {
                                            text-align: center;
                                            margin-bottom: 20px;
                                            font-size: 24px;
                                            color: #444;
                                        }
                                        #popup .form-control {
                                            width: 100%;
                                            padding: 10px;
                                            margin-bottom: 15px;
                                            font-size: 16px;
                                            border: 1px solid #ccc;
                                            border-radius: 8px;
                                            box-sizing: border-box;
                                            outline: none;
                                            transition: border-color 0.3s ease;
                                        }
                                        #popup .form-control:focus {
                                            border-color: #007bff;
                                            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
                                        }
                                        #popup button {
                                            width: 100%;
                                            padding: 12px 20px;
                                            font-size: 18px;
                                            color: white;
                                            background-color: #000000;
                                            border: none;
                                            border-radius: 8px;
                                            cursor: pointer;
                                            transition: background-color 0.3s ease;
                                        }
                                        #popup button:hover {
                                            background-color: #999999;
                                        }
                                        #popup-overlay {
                                            position: fixed;
                                            top: 0;
                                            left: 0;
                                            width: 100%;
                                            height: 100%;
                                            background: rgba(0, 0, 0, 0.5);
                                            z-index: 999;
                                        }
                                    </style>
                                    <div id="popup">
                                        <h3>Thanh Toán Qua Ngân Hàng</h3>
                                        <label for="bankName">Nhập Ngân Hàng</label>
                                        <input type="text" class="form-control" id="bankName" placeholder="Nhập Ngân Hàng">
                                        <label for="cardNumber">Số Thẻ</label>
                                        <input type="text" class="form-control" id="cardNumber" placeholder="Số Thẻ">
                                        <label for="cardHolder">Tên Chủ Thẻ</label>
                                        <input type="text" class="form-control" id="cardHolder" placeholder="Tên Chủ Thẻ">
                                        
                                        <button onclick="closePopup()">Xác Nhận</button>
                                    </div>
                                    <div id="popup-overlay" onclick="closePopup()"></div>
                                `;
                                document.body.insertAdjacentHTML('beforeend', popupContent);
                            }
                        
                            function showEWalletPopup() {
                                const popupContent = `
                                    <style>
                                        /* Toàn bộ popup */
                                        #popup {
                                            position: fixed;
                                            top: 50%;
                                            left: 50%;
                                            transform: translate(-50%, -50%);
                                            background-color: #f9f9f9;
                                            border-radius: 15px;
                                            border: 1px solid #e0e0e0;
                                            padding: 20px;
                                            width: 500px;
                                            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
                                            z-index: 1000;
                                            font-family: Arial, sans-serif;
                                            color: #333;
                                        }
                                        #popup h3 {
                                            text-align: center;
                                            margin-bottom: 20px;
                                            font-size: 24px;
                                            color: #444;
                                        }
                                        #popup .form-control {
                                            width: 100%;
                                            padding: 10px;
                                            margin-bottom: 15px;
                                            font-size: 16px;
                                            border: 1px solid #ccc;
                                            border-radius: 8px;
                                            box-sizing: border-box;
                                            outline: none;
                                            transition: border-color 0.3s ease;
                                        }
                                        #popup .form-control:focus {
                                            border-color: #007bff;
                                            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
                                        }
                                        #popup button {
                                            width: 100%;
                                            padding: 12px 20px;
                                            font-size: 18px;
                                            color: white;
                                            background-color: #000000;
                                            border: none;
                                            border-radius: 8px;
                                            cursor: pointer;
                                            transition: background-color 0.3s ease;
                                        }
                                        #popup button:hover {
                                            background-color: #999999;
                                        }
                                        #popup-overlay {
                                            position: fixed;
                                            top: 0;
                                            left: 0;
                                            width: 100%;
                                            height: 100%;
                                            background: rgba(0, 0, 0, 0.5);
                                            z-index: 999;
                                        }
                                    </style>
                                    <div id="popup">
                                        <h3>Thanh Toán Bằng Ví Điện Tử</h3>
                                        <label for="walletType">Loại Ví Điện Tử</label>
                                        <input type="text" class="form-control" id="walletType" placeholder="Nhập tên ví điện tử (Momo, ZaloPay,...)">
                                        <label for="walletID">Tên Tài Khoản</label>
                                        <input type="text" class="form-control" id="walletID" placeholder="Nhập tên">
                                        <label for="walletID">Số Ví</label>
                                        <input type="text" class="form-control" id="walletID" placeholder="Nhập số ví của bạn">
                                        <button onclick="closePopup()">Xác Nhận</button>
                                    </div>
                                    <div id="popup-overlay" onclick="closePopup()"></div>
                                `;
                                document.body.insertAdjacentHTML('beforeend', popupContent);
                            }
                        
                            function closePopup() {
                                const popup = document.getElementById('popup');
                                const overlay = document.getElementById('popup-overlay');
                                if (popup) popup.remove();
                                if (overlay) overlay.remove();
                            }
                        </script>
                    </div>
                   

                    <div class="card-footer border-secondary bg-transparent">
                       
                        <button onclick="done()" type="submit" name="place_order" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Đặt Hàng</button>
                        
                    </div>
                        </form>

                            <script>
                        function done() {
                          alert("Đã đặt hàng thành công!");
                        }
                      </script>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->


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
                            <a class="text-dark" href="contact.php"><i class="fa fa-angle-right mr-2"></i>Liên Hệ</a>
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