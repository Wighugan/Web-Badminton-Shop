<!DOCTYPE html>
<html lang="en">

<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydp";

// Kết nối đến MySQL
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if (!$conn) {
	die("Kết nối thất bại: " . mysqli_connect_error());
}

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $new_status = $_POST['status'];
    $update_sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt_update = $conn->prepare($update_sql);
    $stmt_update->bind_param("si", $new_status, $order_id);
    if ($stmt_update->execute()) {
        // Load lại trang để hiển thị trạng thái mới
        echo "<script>location.href='chitietdonhang.php?id=$order_id';</script>";
        exit;
    } else {
        echo "<script>alert('Cập nhật trạng thái thất bại!');</script>";
    }
}

// Lấy thông tin đơn hàng + khách hàng
$sql_order = "SELECT orders.*, users.fullname, users.numberphone , users.address1 FROM orders 
              JOIN users ON orders.user_id = users.id 
              WHERE orders.id = ?";

              
$stmt_order = $conn->prepare($sql_order);
$stmt_order->bind_param("i", $order_id);
$stmt_order->execute();
$result_order = $stmt_order->get_result();
$order = $result_order->fetch_assoc();

// Lấy danh sách sản phẩm trong đơn hàng
$sql_detail = "SELECT order_details.*, product.image 
               FROM order_details 
             left JOIN product ON order_details.product_id = product.id 
               WHERE order_details.order_id = ?";
$stmt_detail = $conn->prepare($sql_detail);
$stmt_detail->bind_param("i", $order_id);
$stmt_detail->execute();
$result_detail = $stmt_detail->get_result();
?>

<?php include 'header.php'; ?>
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
                        <a href="logedin.php" class="nav-item nav-link active">Trang Chủ</a>
                        <a href="shoplogin.php" class="nav-item nav-link">Sản Phẩm</a>
                        <a href="contact.php" class="nav-item nav-link">Liên Hệ</a>
                    </div>

                    <!-- Tài khoản bên phải nhưng đẩy vào trái 20px -->
                    <div class="navbar-nav py-0" style="margin-right: 65px;"> <!-- thêm khoảng cách vào trái -->
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link" data-toggle="dropdown">
                                <?php 
                                echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Khách"; 
                                ?>
                            </a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="logout.php" class="dropdown-item">Đăng Xuất</a>
                                <a href="suathongtinuser.php" class="dropdown-item">Đổi Thông Tin</a>
                                <a href="history.php" class="dropdown-item">Lịch sử mua hàng</a>
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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Chi tiết đơn Hàng</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="logedin.php">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Chi tiết đơn hàng</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row1 px-xl-6">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                        <td>id</td>
                                <td>Ảnh</td>
                                 <td>Tên SP</td>
                                 <td>Số lượng</td>
                                <td>Giá tiền </td>
                        </tr>
                    </thead>
                    <?php 
        $i = 1;
        $total = 0;
        while($row = $result_detail->fetch_assoc()) { 
            $thanhtien = $row['quantity'] * $row['product_price'];
            $total += $thanhtien;
        ?>
        <tr>
            <td><?= $i++ ?></td>

            <td><img src="<?=  htmlspecialchars($row['image']) ?>" width="80"></td> <!-- Ảnh -->
            <td><?= $row['product_name'] ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= number_format($row['product_price'], 0, ',', '.') ?> VND</td>
        </tr>
        <?php } ?>

                    </tbody>
        </table>        
                
                <div class="thanhtoan">
            <table>
        <tbody>
         

            <tr>
            
                <td>Tổng tiền hàng:</td>
                <td><b><?= number_format($total, 0, ',', '.') ?> VND</b></td>
            </tr>
            <tr>
                <td>Phí vận chuyển:</td>
                <td>50.000 VND</td>
            </tr>
            <tr>
                <td>Giảm giá phí vận chuyển:</td>
                <td>-50.000 VND</td>
            </tr>
            <tr>
                <td>Phí Bảo Đảm:</td>
                <td>30.000 VND</td>
            </tr>
            <tr>
                <td><b>Thành tiền:</b></td>
                <td>
                    <b>
                        <?php 
                        $total_final = $total + 30000; // phí bảo đảm, miễn phí vận chuyển
                        echo number_format($total_final, 0, ',', '.'); 
                        ?> VND
                    </b>
                </td>
            </tr>
            <tr>
                <td>Phương thức thanh toán:</td>
                <td>COD</td>
                            </tr>

        </table>



            </div>
           
                    </div>

                    




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