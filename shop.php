
<!DOCTYPE html>
<html lang="vi">
    
<?php
include 'db.php';
session_start();

$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    // Xử lý tìm kiếm
    $search = $conn->real_escape_string($_GET['query']);
    $search_sql = "SELECT * FROM product WHERE name LIKE '%$search%'";
    $search_result = $conn->query($search_sql);
} else {
    // Lấy tổng số sản phẩm
    $total_result = $conn->query("SELECT COUNT(*) AS total FROM product");
    $total_row = $total_result->fetch_assoc();
    $total_product = $total_row['total'];
    $total_pages = ceil($total_product / $limit);

    // Lấy sản phẩm theo trang
    $product_sql = "SELECT * FROM product ORDER BY id DESC LIMIT $limit OFFSET $offset";
    $result = $conn->query($product_sql);
}
?>

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                <a href="logedin.php" class="text-decoration-none">
                    <div style="display: flex; align-items: center; position: relative;">
                        <img src="img/logo.png" alt="a logo" width="85px" height="85px">
                        <span class="custom-font" style="margin-left: 10px; position: relative; top: 20px;">Shop</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
            <form action="shop.php" method="GET">
    <div class="input-group">
        <input type="text" id="search" name="query" class="form-control" placeholder="Nhập nội dung bạn muốn tìm kiếm">
        <div class="input-group-append">
            <button type="submit" class="input-group-text bg-transparent text-primary">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</form>
 </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge">0</span>
                </a>
                <a href="cart.php" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge">0</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <script>
        function showVot(event) {
            document.getElementById("output").innerText = "Vợt cầu lông";
        }
        function showGiay(event) {
            document.getElementById("output").innerText = "Giày cầu lông";
        }
        function showTui(event) {
            document.getElementById("output").innerText = "Túi cầu lông";
        }
        function showQuan(event) {
            document.getElementById("output").innerText = "Quần cầu lông";
        }
        function showAo(event) {
            document.getElementById("output").innerText = "Áo cầu lông";
        }
        function showVay(event) {
            document.getElementById("output").innerText = "Váy cầu lông";
        }
        function showVo(event) {
            document.getElementById("output").innerText = "Vớ cầu lông";
        }
        function showQuanCan(event) {
            document.getElementById("output").innerText = "Quấn cán vợt";
        }
        function showOngCau(event) {
            document.getElementById("output").innerText = "Ống cầu";
        }
    </script>
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
                            <a href="Login.php" class="nav-item nav-link">Đăng Nhập</a>
                            <a href="Signup.php" class="nav-item nav-link">Đăng Ký</a>
                        </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Cửa Hàng</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="logedin.php">Trang Chủ</a></p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <?php
require_once 'db.php';

$sort = $_GET['sort'] ?? '';
$price = $_GET['price'] ?? '';
$brands = isset($_GET['brand']) ? (array)$_GET['brand'] : [];

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6;
$offset = ($page - 1) * $limit;

// Bắt đầu điều kiện WHERE
$where = "WHERE 1";

// Lọc theo giá
if ($price == '0500') {
    $where .= " AND price < 500000";
} elseif ($price == '5001') {
    $where .= " AND price BETWEEN 500000 AND 1000000";
} elseif ($price == '12') {
    $where .= " AND price BETWEEN 1000000 AND 2000000";
} elseif ($price == '23') {
    $where .= " AND price BETWEEN 2000000 AND 3000000";
} elseif ($price == 'over3') {
    $where .= " AND price > 3000000";
}

// Lọc theo thương hiệu
if (!empty($brands)) {
    $escapedBrands = array_map(function($b) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $b) . "'";
    }, $brands);
    $where .= " AND category IN (" . implode(",", $escapedBrands) . ")";
}

// Tính tổng số dòng sau khi lọc
$count_sql = "SELECT COUNT(*) AS total FROM product $where";
$count_result = mysqli_query($conn, $count_sql);
$total_row = mysqli_fetch_assoc($count_result);
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit);

// Thêm sắp xếp
$order = "ORDER BY id DESC";
if ($sort == 'az') {
    $order = "ORDER BY name ASC";
} elseif ($sort == 'za') {
    $order = "ORDER BY name DESC";
} elseif ($sort == 'price-asc') {
    $order = "ORDER BY price ASC";
} elseif ($sort == 'price-desc') {
    $order = "ORDER BY price DESC";
}

// Câu query chính thức với LIMIT
$sql = "SELECT * FROM product $where $order LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);
?>
  
    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <!-- Price Start -->
                <form id="filter-form" method="GET" >
    <!-- Sắp xếp -->
    <div class="mb-5">
        <h5 class="font-weight-semi-bold mb-4">Sắp xếp</h5>
        <div class="custom-control custom-radio custom-radio-square mb-3">
            <input type="radio" class="custom-control-input" name="sort" value="price-asc" id="sort-price-asc" >
            <label class="custom-control-label" for="sort-price-asc">Giá tăng dần</label>
        </div>
        <div class="custom-control custom-radio custom-radio-square mb-3">
            <input type="radio" class="custom-control-input" name="sort" value="price-desc" id="sort-price-desc">
            <label class="custom-control-label" for="sort-price-desc">Giá giảm dần</label>
        </div>
    </div>

    <!-- Giá -->
    <div class="border-bottom mb-4 pb-4">
        <h5 class="font-weight-semi-bold mb-4">Chọn mức giá</h5>
        <div class="custom-control custom-radio custom-radio-square mb-3">
            <input type="radio" class="custom-control-input" name="price" value="all" id="price-all">
            <label class="custom-control-label" for="price-all">Tất cả giá</label>
        </div>
        <div class="custom-control custom-radio custom-radio-square mb-3">
            <input type="radio" class="custom-control-input" name="price" value="0500" id="price-1">
            <label class="custom-control-label" for="price-1">Dưới 500.000đ</label>
        </div>
        <div class="custom-control custom-radio custom-radio-square mb-3">
            <input type="radio" class="custom-control-input" name="price" value="5001" id="price-2">
            <label class="custom-control-label" for="price-2">500.000đ - 1 triệu</label>
        </div>
        <div class="custom-control custom-radio custom-radio-square mb-3">
            <input type="radio" class="custom-control-input" name="price" value="12" id="price-3">
            <label class="custom-control-label" for="price-3">1 - 2 triệu</label>
        </div>
        <div class="custom-control custom-radio custom-radio-square mb-3">
            <input type="radio" class="custom-control-input" name="price" value="23" id="price-4">
            <label class="custom-control-label" for="price-4">2 - 3 triệu</label>
        </div>
        <div class="custom-control custom-radio custom-radio-square">
            <input type="radio" class="custom-control-input" name="price" value="over3" id="price-5">
            <label class="custom-control-label" for="price-5">Trên 3 triệu</label>
        </div>
    </div>

    <!-- Thương hiệu -->
    <div class="mb-5">
        <h5 class="font-weight-semi-bold mb-4">Thương hiệu</h5>
        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
            <input type="checkbox" class="custom-control-input" name="brand[]" value="VNB" id="brand-1">
            <label class="custom-control-label" for="brand-1">VNB</label>
        </div>
        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
            <input type="checkbox" class="custom-control-input" name="brand[]" value="Yonex" id="brand-2">
            <label class="custom-control-label" for="brand-2">Yonex</label>
        </div>
        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
            <input type="checkbox" class="custom-control-input" name="brand[]" value="Lining" id="brand-3">
            <label class="custom-control-label" for="brand-3">Lining</label>
        </div>
        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
            <input type="checkbox" class="custom-control-input" name="brand[]" value="Victor" id="brand-4">
            <label class="custom-control-label" for="brand-4">Victor</label>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Lọc</button>
</form>
<style>
/* Bo góc vuông cho radio */
.custom-radio-square .custom-control-input ~ .custom-control-label::before {
    border-radius: 0 !important;  /* ô vuông */
}

/* Tick dấu ✓ giống checkbox */
.custom-radio-square .custom-control-input:checked ~ .custom-control-label::before {
    background-color:rgb(0, 0, 0); /* màu tick nền xanh */
    border-color:rgb(0, 0, 0);
}

/* Thêm dấu tick như checkbox */
.custom-radio-square .custom-control-input:checked ~ .custom-control-label::after {
    content: "";
    position: absolute;
    left: -1.15rem;
    top: 0.35rem;
    width: 0.3rem;
    height: 0.6rem;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}
</style>
                <!-- Size End -->
  
                

               
            </div>
            <!-- Shop Sidebar End -->
            <style>
                #output {
                    font-weight: bold;
                    font-size: 30px;
                }
                #votcaulong {
                    font-weight: bold;
                    font-size: 30px;
                }
            </style>
           <script>
function searchProduct() {
    let keyword = document.getElementById("searchInput").value;

    $.ajax({
        url: "search.php",
        type: "GET",
        data: { search: keyword },
        success: function(response) {
            document.getElementById("productList").innerHTML = response;
        },
        error: function(xhr, status, error) {
            console.error("Lỗi AJAX:", error);
        }
    });
}
</script>
            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-12">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                    <div class="col-lg-6 col-6 text-left">
            <form action="shop.php" method="GET">
    <div class="input-group">
        <input type="text" id="search" name="query" class="form-control" placeholder="Nhập nội dung bạn muốn tìm kiếm">
        <div class="input-group-append">
            <button type="submit" class="input-group-text bg-transparent text-primary">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</form>
 </div>
                        <p id="output"></p>
                    </div>
                    
                    <style>
.container {
    margin-top: 20px;
}

/* Giữ đúng lưới Bootstrap, chỉ cách đều bằng margin */


/* Ảnh sản phẩm */

/* Nội dung sản phẩm */

</style>



                    <?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "mydp"; 

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $search = $conn->real_escape_string($_GET['query']);
    $sql = "SELECT * FROM product WHERE name LIKE '%$search%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="container">';
        echo '<h2>Kết quả tìm kiếm:</h2>';
        echo '<div class="row">';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-md-4">';
            echo '<div class="card mb-4">';
            // Bọc ảnh bằng thẻ <a> để click vào ảnh => đi đến chi tiết
            echo '<a href="detaillogin.php?id=' . $row['id'] . '">';
            echo '<img src="' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">';
            echo '</a>';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
            echo '<p class="card-text">Giá: ' . number_format($row['price'], 0, ',', '.') . ' VNĐ</p>';
            echo '</div></div></div>';
        }
        echo '</div></div>';
    } else {
        echo "<h2>Không tìm thấy sản phẩm phù hợp.</h2>";
    }
} else {
    echo "<h2>Vui lòng nhập từ khóa tìm kiếm!</h2>";
}
?>
      
                    <div class="container">
    <div class="row">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <a href="detaillogin.php?id=<?= $row['id'] ?>">
                    <img class="img-fluid w-100" src="<?= str_replace('../', '', htmlspecialchars($row['image'])) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                    </a>                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3"><?= htmlspecialchars($row['name']) ?></h6>
                        <div class="d-flex justify-content-center">
                            <h6 class="font-weight-bold"><?= number_format($row['price'], 0, ',', '.') ?>đ</h6>
                        </div>
                    </div>
                    
                    <script>
                function done() {
                  alert("Đã thêm vào giỏ hàng!");
                }
              </script>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="col-12 pb-1">
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mb-3">
            <!-- Nút Previous -->
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= ($page > 1) ? ($page - 1) : 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>

            <!-- Hiển thị số trang -->
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php } ?>

            <!-- Nút Next -->
            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= ($page < $total_pages) ? ($page + 1) : $total_pages ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

</div>



<?php
$conn->close();
?>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->

     <!-- Footer Start -->
     <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="logedin.php" class="text-decoration-none">
                    <div style="display: flex; align-items: center; position: relative; top: -10px;">
                        <img src="img/logo.png" alt="a logo" width="85px" height="85px">
                        <span class="custom-font" style="margin-left: 10px; position: top; top: 10px;">Shop</span>
                    </div>
                </a>
                <p>Mọi mắc mắt xin liên hệ về.</p>
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