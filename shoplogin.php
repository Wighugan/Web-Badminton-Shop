
<?php
include "src/header-login.php";
$data = new Database();
$sp = new SanPham();
// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
// Phân trang
$limit = 6;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
// Tham số lọc và tìm kiếm
$search = isset($_GET['query']) ? trim($_GET['query']) : '';
$price = $_GET['price'] ?? '';
$brands = isset($_GET['brand']) ? (array)$_GET['brand'] : [];
$sort = $_GET['sort'] ?? '';
// Nếu có tìm kiếm hoặc lọc
if ($search !== '' || $price !== '' || !empty($brands) || $sort !== '') {
    list($where, $params, $types, $order) = $sp->timkiemsp($search, $price, $brands, $sort);
    $total_products = $sp->demSoSanPham($where, $types, $params);
    $products = $sp->layDanhSachSanPham($where, $order, $types, $params, $limit, $offset);
} else {
    // Ngược lại: lấy toàn bộ sản phẩm
    $result = $sp->layTatCaSanPham($limit, $page);
    $products = $result['products'];
    $total_products = $result['total_products'];
}
// Tính tổng số trang
$total_pages = ceil($total_products / $limit);
$current_page = $page;
?>
<!DOCTYPE html>
<html lang="vi">
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
    <!-- Topbar End -->

    <!-- <script>
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
    Navbar Start 
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
            </div> -->
    <!-- Navbar End -->
    <!-- Page Header Start -->
     <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Cửa Hàng</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="login.php">Trang Chủ</a></p>
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
      <form id="filter-form" method="GET" >

    <div class="input-group">
    <input type="text" id="search" name="query" class="form-control" placeholder="Nhập nội dung bạn muốn tìm kiếm">
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-search"></i>
    </button>
</div>

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
            <input type="checkbox" class="custom-control-input" name="brand[]" value="Mizuno" id="brand-1">
            <label class="custom-control-label" for="brand-1">Mizuno</label>
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
</div>
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
    <div class="row">
<?php if (!empty($products)): ?>
    <?php foreach ($products as $product): ?>
        <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <a href="detaillogin.php?id=<?= $product['MASP'] ?>">
                        <img class="img-fluid w-100"
                             src="<?= htmlspecialchars($product['IMAGE']) ?>"
                             alt="<?= htmlspecialchars($product['TENSP']) ?>"
                             style="height:300px;object-fit:cover;">
                    </a>
                </div>
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h6 class="text-truncate mb-3"><?= htmlspecialchars($product['TENSP']) ?></h6>
                    <div class="d-flex justify-content-center">
                        <h6><?= number_format($product['DONGIA'], 0, ',', '.') ?>đ</h6>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="col-12 text-center"><h5>Không tìm thấy sản phẩm nào.</h5></div>
<?php endif; ?>
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
<?php
$data->close();
?>
 </div>
 </div>
 </div>
<!-- Shop Product End -->
       
    <!-- Shop End -->

     <!-- Footer Start -->
    <?php include 'src/footer.php'; ?>
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