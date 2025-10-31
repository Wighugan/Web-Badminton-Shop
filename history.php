<?php
include 'src/user.php';
include 'src/order.php';
if (!isset($_SESSION['user_id'])) {
    die("Bạn chưa đăng nhập!");
}

$data = new Database();
$user = new QuanLyKhachHang($data);
$user_id = $_SESSION['user_id'];

// Tạo đối tượng Order và lấy phân trang
$dh = new Order($data);
$pagination = $dh->DemSoDonHang($user_id, 10);

$limit = $pagination['limit'];
$page = $pagination['page'];
$offset = $pagination['offset'];
$total_orders = $pagination['total_orders'];
$total_pages = $pagination['total_pages'];
// ✅ Gọi đúng class Order
$orders = $user->XemLichSuMuaHang($user_id, $limit, $offset);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch Sử Mua Hàng</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

    <!-- HEADER -->
     <?php
        include "src/header-login.php"; 
        ?>
    <!-- NỘI DUNG -->
    <div class="container py-5">
        <div class="table-responsive mb-5">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Tổng tiền hàng</th>
                        <th>Giảm giá</th>
                        <th>Ngày đặt hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $row): ?>
                    <tr>
                        <td><a class="order-link" href="chitiet.php?id=<?= htmlspecialchars($row['MADH']) ?>"><?= htmlspecialchars($row['MADH']) ?></a></td>
                        <td><?= htmlspecialchars($row['HOTEN']) ?></td>
                        <td><?= htmlspecialchars($row['SDT']) ?></td>
                        <td><?= number_format($row['TONGTIEN'], 0, ',', '.') ?> VND</td>
                        <td>0đ</td>
                        <td><?= date('d/m/Y', strtotime($row['NGAYLAP'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- PHÂN TRANG -->
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= max(1, $page - 1) ?>">&laquo;</a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>">&raquo;</a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- FOOTER -->
    <?php include "src/footer.php"; ?>
    <!-- NÚT LÊN ĐẦU -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
