<!DOCTYPE html>
<html lang="en">
<?php include 'src/header-login.php'; ?>
<?php
include 'database/connect.php';
$isLoggedIn = isset($_SESSION['user_id']);
if (!isset($_SESSION['user_id'])) {
    die("Bạn chưa đăng nhập!");
}
$order_db = new Database();
$user_id = $_SESSION['user_id'];
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Lấy thông tin người dùng
$user_db = new Database();
$user_stmt = $user_db->select_prepare("SELECT fullname, numberphone FROM users WHERE id = ?", "i", $user_id);
$user = $user_stmt->fetch();
$user_db->close();

if (!$user) {
    die("Người dùng không tồn tại!");
}

// Lấy tổng số đơn hàng
$count_db = new Database();
$count_stmt = $count_db->select_prepare("SELECT COUNT(*) as total FROM orders WHERE user_id = ?", "i", $user_id);
$count_result = $count_stmt->fetch();
$total_orders = $count_result['total'];
$count_db->close();

$total_pages = ceil($total_orders / $limit);

// Lấy các đơn hàng của người dùng (có phân trang)
$sql = "SELECT o.*, u.fullname, u.numberphone 
        FROM orders o
        JOIN users u ON o.user_id = u.id 
        WHERE o.user_id = ? 
        ORDER BY o.created_at DESC 
        LIMIT ?, ?";
$order_db->select_prepare($sql, "iii", $user_id, $offset, $limit);
// Sau này dùng $order_db->fetch() để lấy dữ liệu từng dòng
?>  
    <!-- Navbar End -->
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Lịch Sử Mua Hàng</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="logedin.php">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Lịch Sử Mua Hàng</p>
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
                            <th>Mã đơn hàng</th>
                            <th>Khách Hàng</th>
                            <th>Số điện thoại</th>
                            <th>Tổng tiền hàng</th>
                            <th>Giảm giá</th>
                            <th>Ngày Đặt Hàng</th>
                           
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php while($row = $order_db->fetch()) { ?>
<tr>
    <td><a href="chitiet.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['code']) ?></a></td>
    <td><?= htmlspecialchars($row['fullname']) ?></td>
    <td><?= htmlspecialchars($row['numberphone']) ?></td>
    <td><?= number_format($row['total'], 0, ',', '.') ?> VND</td>
    <td>0đ </td>
    <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
</tr>
<?php } ?>
                    </tbody>
                </table>
            </div>
           
                    </div>

                    <div class="col-12 pb-1">
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mb-3">
            <!-- Nút Previous -->
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?user_id=<?= $user_id ?>&page=<?= max(1, $page - 1) ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <!-- Các trang -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?user_id=<?= $user_id ?>&page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <!-- Nút Next -->
            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?user_id=<?= $user_id ?>&page=<?= min($total_pages, $page + 1) ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->


    <!-- Footer Start -->
    <?php include 'src/footer.php';?>
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