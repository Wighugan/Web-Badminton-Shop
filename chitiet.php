 <?php 
 include "src/header-login.php";
 include_once 'class/order.php';
$data = new Database();
$dh = new Order($data);
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$order_details = $dh->getOrderDetails($order_id);
$data->close();
?>
 
<!DOCTYPE html>
<html lang="en">
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
                                <td>Thành tiền</td>
                        </tr>
                    </thead>
                    <?php
$i = 1;
$total = 0;
foreach ($order_details as $row) {
    $quantity = (int)$row['SOLUONG'];
    $product_price = (float)$row['DONGIA'];
    $thanhtien = $quantity * $product_price;
    $total += $thanhtien;
?>
    <tr>
        <td><?= $i++ ?></td>
        <td><img src="<?= htmlspecialchars($row['IMAGE']) ?>" width="80" alt="Ảnh sản phẩm"></td>
        <td><?= htmlspecialchars($row['TENSP']) ?></td>
        <td><?= $quantity ?></td>
        <td><?= number_format($product_price, 0, ',', '.') ?> VND</td>
        <td><?= number_format($thanhtien, 0, ',', '.') ?> VND</td>
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