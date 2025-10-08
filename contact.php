<!DOCTYPE html>
<html lang="en">
<?php
session_start(); // 🔹 Đặt ở dòng đầu tiên của file!
$isLoggedIn = isset($_SESSION['user_id']); // Giả sử bạn lưu thông tin đăng nhập trong $_SESSION['user']


// Kiểm tra nếu chưa đăng nhập thì chuyển về login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
 include 'database/connect.php';
 $data = new Database();
?>
<?php include 'src/header-login.php'; ?>

    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Thông Tin Liên Hệ </h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="index.php">Trang Chủ</a></p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
<style>
button {
    width: 25%;
    padding: 8px; /* Giảm padding của nút */
    background-color: #000000;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 0.9rem; /* Giảm kích thước chữ trên nút */
}

button:hover {
    background-color: #969393;
}
.no-border-button-rec-contact{
        border: 0px;      /* Loại bỏ viền */
        border-radius: 0;
        outline: none;     /* Loại bỏ viền đen khi nhấn vào */
        background: #000000;  /* Loại bỏ nền, nếu muốn */
        cursor: pointer;   /* Hiển thị con trỏ tay khi di chuột */
}

.no-border-button-rec-contact:focus {
        outline: none;     /* Đảm bảo không có viền khi lấy focus */
}
</style>

    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Thông Tin Của Bạn</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form">
                    <div id="success"></div>
                    <form name="sentMessage" id="contactForm" novalidate="novalidate">
                        <div class="control-group">
                            <input type="text" class="form-control" id="name" placeholder="Họ Và Tên"
                                required="required" data-validation-required-message="Please enter your name" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="email" class="form-control" id="email" placeholder="Email Của Bạn"
                                required="required" data-validation-required-message="Please enter your email" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="text" class="form-control" id="subject" placeholder="Tiêu Đề"
                                required="required" data-validation-required-message="Please enter a subject" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <textarea class="form-control" rows="6" id="message" placeholder="Mô Tả"
                                required="required"
                                data-validation-required-message="Please enter your message"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div>
                            <button class="no-border-button-rec-contact" type="submit" id="sendMessageButton">Gửi Phản Hồi</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 mb-5">
                <h5 class="font-weight-semi-bold mb-3">MMB - Shop Bán Đồ Cầu Lông</h5>
                <p>Mọi Thắc Mắc Xin Liên Hệ.</p>
                <div class="d-flex flex-column mb-3">   
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>273 An Dương Vương, Phường 3, Quận 5, Thành Phố Hồ Chí Minh</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>MMBShopper102@gmail.com</p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>012345678</p>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Contact End -->


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