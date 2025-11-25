<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/order.php';

$data = new database();
$order = new order($data);

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'nhanvien'])) {
    header("Location: ../../Signin.php");
    exit();
}
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $quanly = new Database();
    $quanly->dangxuat();
    header('Location: ../../signin.php');
    exit();
}
// Nhận tham số lọc & tìm kiếm
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$start_date = isset($_GET['start']) ? $_GET['start'] : '';
$end_date = isset($_GET['end']) ? $_GET['end'] : '';
$district = isset($_GET['district']) ? trim($_GET['district']) : '';
$status = isset($_GET['status']) ? trim($_GET['status']) : '';

// Lấy danh sách đơn hàng và tổng số
$orders = $order->getOrders($page, $search, $start_date, $end_date, $district, $status);
$total_orders = $order->countOrders($search, $start_date, $end_date, $district, $status);
$total_pages = ceil($total_orders / $order->getLimit());
$stt = ($page - 1) * $order->getLimit() + 1;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - MMB - Shop Bán Đồ Cầu Lông</title>
    <link href='../img/logo.png' rel='icon' type='image/x-icon' />
    <link rel="stylesheet" href="../css/indexadmin.css">
    <link rel="stylesheet" href="../css/quanlydonhang.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
</head>

<body>
    <!-- =============== Navigation ================ -->
    <?php 
     include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/header-admin.php';
    ?>
        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="hello">
                    <p>CHÀO MỪNG ADMIN CỦA MMB</p>
                </div>
            </div>

            <div class="chartsBx">           
            </div>

            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Đơn hàng gần đây</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>STT</td>
                                <td>Mã đơn hàng</td>
                                <td>Người đặt</td>
                                <td>Tình trạng</td>
                                <td>Tổng tiền</td>
                                <td>Ngày</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($orders)) {
                                foreach ($orders as $row) {
                                    $code = htmlspecialchars($row['CODE']);
                                    $fullname = htmlspecialchars($row['HOTEN']);
                                    $status = htmlspecialchars($row['TRANGTHAI']);
                                    $total = number_format($row['TONGTIEN'], 0, ',', '.');
                                    $date = date('d/m/Y H:i', strtotime($row['NGAYLAP']));
                                    $madh = (int)$row['MADH'];
                                    ?>
                                    <tr>
                                        <td><?= $stt++ ?></td>
                                        <td>
                                            <a href="chitietdonhang.php?id=<?= $madh ?>" style="color: #0056b3; text-decoration: none;">
                                                <?= $code ?>
                                            </a>
                                        </td>
                                        <td><?= $fullname ?></td>
                                        <td class="<?= $status ?>"><?= $status ?></td>
                                        <td><?= $total ?> VND</td>
                                        <td><?= $date ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='6' style='text-align: center; padding: 20px;'>Không có đơn hàng nào</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Phân trang -->
                    <div class="pagination">
                        <?php
                        if ($page > 1) {
                            echo "<a href='trangchuadmin.php?page=" . ($page - 1) . "'>Trước</a>";
                        }

                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $page) {
                                echo "<span class='current'>$i</span>";
                            } else {
                                echo "<a href='trangchuadmin.php?page=$i'>$i</a>";
                            }
                        }

                        if ($page < $total_pages) {
                            echo "<a href='trangchuadmin.php?page=" . ($page + 1) . "'>Sau</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>