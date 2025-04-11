
<!DOCTYPE html>
<html lang="vi">
    
<?php
include 'db.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Chuyển hướng nếu chưa đăng nhập
    exit();
}
// Xử lý tìm kiếm
// Xác định trang hiện tại (mặc định trang 1)
$limit = 6; // Số sản phẩm mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Lấy tổng số sản phẩm
$total_result = $conn->query("SELECT COUNT(*) AS total FROM product");
$total_row = $total_result->fetch_assoc();
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit);

// Lấy sản phẩm cho trang hiện tại
$sql = "SELECT * FROM product ORDER BY id ASC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
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
                <a href="logedin.html" class="text-decoration-none">
                    <div style="display: flex; align-items: center; position: relative;">
                        <img src="img/logo.png" alt="a logo" width="85px" height="85px">
                        <span class="custom-font" style="margin-left: 10px; position: relative; top: 20px;">Shop</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
            <form action="shoplogin.php" method="GET">
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
                <a href="cart.html" class="btn border">
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
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Phân Loại Nhãn Hàng</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                    <div class="navbar-nav w-100 overflow-hidden" style="height: 245px">
                        <a href="vot_login.html" class="nav-item nav-link">Yonex</a>
                        <a href="giay_login.html" class="nav-item nav-link">Lining</a>
                        <a href="tui_login.html" class="nav-item nav-link">Victor</a>
                        <a href="quan_login.html" class="nav-item nav-link">Mizuno</a>
                        <a href="ao_login.html" class="nav-item nav-link">VNB</a>
                        <a href="vay_login.html" class="nav-item nav-link">Apacs</a>
                       
                </nav>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
$(document).ready(function() {
    $("#search").keyup(function() {
        var query = $(this).val().trim();
        if (query.length > 0) { // 🔥 Nếu ô tìm kiếm có chữ
            $.ajax({
                url: "suggest.php",
                method: "GET",
                data: { query: query },
                success: function(data) {
                    if (data.trim() != '') {
                        $("#search-suggestions").html(data).show();
                    } else {
                        $("#search-suggestions").hide();
                    }
                }
            });
        } else { // 🔥 Nếu ô tìm kiếm rỗng thì ẩn luôn
            $("#search-suggestions").hide();
        }
    });

    $(document).on("click", ".suggestion-item", function() {
        $("#search").val($(this).text());
        $("#search-suggestions").hide();
    });
});
</script>


            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="logedin.html" class="text-decoration-none d-block d-lg-none">
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
                            <a href="logedin.php" class="nav-item nav-link">Trang Chủ</a>
                            <a href="shoplogin.php" class="nav-item nav-link">Sản Phẩm</a>
                            <a href="contact.php" class="nav-item nav-link">Liên Hệ</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link" data-toggle="dropdown"> <?php 
                    echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Khách"; 
                ?></a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="index.php" class="dropdown-item">Đăng Xuất</a>
                                    <a href="suathongtinuser.php" class="dropdown-item">Đổi Thông Tin</a>
                                    <a href="history.php" class="dropdown-item">Lịch sử mua hàng</a>
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
                <p class="m-0"><a href="logedin.html">Trang Chủ</a></p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <!-- Price Start -->
                <div class="mb-5">
                    <h5 class="font-weight-semi-bold mb-4">Sắp xếp</h5>
                    <form>
                       
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-1">
                            <label class="custom-control-label" for="size-1">Từ A → Z </label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-2">
                            <label class="custom-control-label" for="size-2">Từ Z → A </label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-3">
                            <label class="custom-control-label" for="size-3">Giá tăng dần</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-4">
                            <label class="custom-control-label" for="size-4">Giá giảm dần</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="size-5">
                            <label class="custom-control-label" for="size-5">Hàng mới nhất</label>
                        </div>
                    </form>
                </div>
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Chọn mức giá</h5>
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="price-all">
                            <label class="custom-control-label" for="price-all">Tất cả giá</label>
                            <span class="badge border font-weight-normal"></span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-1">
                            <label class="custom-control-label" for="price-1">Giá dưới 500.000đ</label>
                            <span class="badge border font-weight-normal">150</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-2">
                            <label class="custom-control-label" for="price-2">500.000đ - 1 triệu</label>
                            <span class="badge border font-weight-normal">295</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-3">
                            <label class="custom-control-label" for="price-3">1 - 2 triệu</label>
                            <span class="badge border font-weight-normal">246</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-4">
                            <label class="custom-control-label" for="price-4">2 - 3 triệu</label>
                            <span class="badge border font-weight-normal">145</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="price-5">
                            <label class="custom-control-label" for="price-5">Giá trên 3 triệu</label>
                            <span class="badge border font-weight-normal">168</span>
                        </div>
                    </form>
                </div>
                <!-- Price End -->
                
                

                <!-- Size Start -->
                <div class="mb-5">
                    <h5 class="font-weight-semi-bold mb-4">Thương hiệu</h5>
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="size-all">
                            <label class="custom-control-label" for="size-all">Tất cả</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-1">
                            <label class="custom-control-label" for="size-1">VNB</label>
                            <span class="badge border font-weight-normal">150</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-2">
                            <label class="custom-control-label" for="size-2">Yonex</label>
                            <span class="badge border font-weight-normal">295</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-3">
                            <label class="custom-control-label" for="size-3">Lining</label>
                            <span class="badge border font-weight-normal">246</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-4">
                            <label class="custom-control-label" for="size-4">Victor</label>
                            <span class="badge border font-weight-normal">145</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="size-5">
                            <label class="custom-control-label" for="size-5">Hãng khác</label>
                            <span class="badge border font-weight-normal">168</span>
                        </div>
                    </form>
                </div>
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
            <form action="shoplogin.php" method="GET">
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
.card {
    height: 97%;
    margin-bottom: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #eee;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Ảnh sản phẩm */
.card-img-top {
    height: 450px;
    object-fit: cover;
    transition: transform 0.4s ease;
}

/* Zoom ảnh khi hover */
.card-img-top:hover {
    transform: scale(0.5);
}

/* Nội dung sản phẩm */
.card-body {
    text-align: center;
}

/* Tên sản phẩm */
.card-title {
    font-size: 1.2rem;
    margin-bottom: 10px;
}

/* Giá sản phẩm */
.card-text {
    font-weight: bold;
    color:rgb(0, 0, 0);
    font-size: 1.1rem;
}
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
    $sql = "SELECT * FROM products WHERE name LIKE '%$search%'";
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
            echo '<img src="img/' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">';
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
                <a href="logedin.html" class="text-decoration-none">
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