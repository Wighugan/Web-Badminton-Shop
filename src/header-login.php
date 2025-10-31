<?php
// ============================================
// FILE: src/header-login.php (ĐÃ SỬA)
// ============================================

// Kiểm tra session đã start chưa
require_once 'src/systemManage.php';
include_once 'src/products.php';
$isLoggedIn = isset($_SESSION['user_id']);

// Xử lý logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $quanly = new QuanLyHeThong();
    $quanly->dangxuat();
    header('Location: index.php');
    exit();
}

// Lấy username nếu chưa có
if (isset($_SESSION['user_id']) && empty($_SESSION['username'])) {
    $db = new Database();
    $db->select_prepare("SELECT TENKH FROM khach_hang WHERE MAKH = ?", "i", $_SESSION['user_id']);
    $row = $db->fetch();
    if ($row) {
        $_SESSION['username'] = $row['TENKH'];
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
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
                <a class="text-dark px-2" href="" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="text-dark px-2" href="" title="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="text-dark px-2" href="" title="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a class="text-dark px-2" href="" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="text-dark pl-2" href="" title="YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Logo và Search -->
    <div class="row align-items-center py-3 px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
                <a href="login.php" class="text-decoration-none">
                    <div style="display: flex; align-items: center; position: relative;">
                        <img src="img/logo.png" alt="a logo" width="85px" height="85px">
                        <span class="custom-font" style="margin-left: 10px; position: relative; top: 20px;">Shop</span>
                    </div>
                </a>
            </div>
        
        <!-- Search Form -->
        <div class="col-lg-6 col-6 text-left">
            <form action="<?php echo $isLoggedIn ? 'shoplogin.php' : 'shop.php'; ?>" method="GET">
                <div class="input-group">
                    <input type="text" 
                           name="query" 
                           class="form-control" 
                           placeholder="Tìm kiếm sản phẩm..."
                           value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Cart Icon -->
        <div class="col-lg-3 col-6 text-right">
            <a href="<?php echo $isLoggedIn ? 'cart.php' : 'Signin.php'; ?>" class="btn border position-relative">
                <i class="fas fa-shopping-cart text-primary"></i>
            </a>
        </div>
    </div>
</div>
<!-- Topbar End -->

<!-- Navbar Start -->
<div class="container-fluid bg-white mb-2">
    <div class="row border-top px-xl-5">
        <div class="col-lg-12">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-0">
                
                <!-- Logo Mobile -->
                <a href="<?php echo $isLoggedIn ? 'login.php' : 'index.php'; ?>" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold">
                        <span class="text-primary font-weight-bold border px-3 mr-1">MMB</span>Shop
                    </h1>
                </a>
                
                <!-- Toggle button -->
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Content -->
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <!-- Menu bên trái -->
                    <div class="navbar-nav py-0">
                        <a href="<?php echo $isLoggedIn ? 'login.php' : 'index.php';?>" class="nav-item nav-link">
                            <i class="fas fa-home"></i> Trang Chủ
                        </a>
                        <a href="<?php echo $isLoggedIn ? 'shoplogin.php' : 'shop.php';?>" class="nav-item nav-link">
                            <i class="fas fa-shopping-bag"></i> Sản Phẩm
                        </a>
                        <a href="<?php echo $isLoggedIn ? 'contact.php' : 'contact.php'; ?>" class="nav-item nav-link">
                            <i class="fas fa-envelope"></i> Liên Hệ
                        </a>
                    </div>

                    <!-- Menu bên phải - User -->
                    <div class="navbar-nav ml-auto py-0">
                        <?php if ($isLoggedIn): ?>
                            <!-- User đã đăng nhập -->
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" 
                                   data-toggle="dropdown" id="userDropdown">
                                    <i class="fas fa-user-circle" style="font-size: 24px; margin-right: 8px;"></i>
                                    <span><?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                    <a href="suathongtinuser.php" class="dropdown-item">
                                        <i class="fas fa-user-edit text-primary"></i> Đổi thông tin
                                    </a>
                                    <a href="history.php" class="dropdown-item">
                                        <i class="fas fa-history text-info"></i> Lịch sử mua hàng
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="?action=logout" class="dropdown-item text-danger" 
                                       onclick="return confirm('Bạn có chắc muốn đăng xuất?')">
                                        <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- User chưa đăng nhập -->
                            <a href="Signin.php" class="nav-item nav-link">
                                <i class="fas fa-sign-in-alt"></i> Đăng Nhập
                            </a>
                            <a href="Signup.php" class="nav-item nav-link">
                                <i class="fas fa-user-plus"></i> Đăng Ký
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->