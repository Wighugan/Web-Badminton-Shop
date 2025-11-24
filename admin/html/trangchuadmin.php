<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/order.php';

// Khởi tạo kết nối và class
$data = new database();
$order = new order();

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

    <style>
        .success {
            color: green;
            font-weight: bold;
        }
        .pending {
            color: red;
            font-weight: bold;
        }
        .cancelled {
            color: gray;
            font-weight: bold;
        }
        .shipping {
            color: blue;
            font-weight: bold;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 30px 0;
            font-family: Arial, sans-serif;
            font-size: 13px;
        }

        .pagination a, .pagination .current {
            margin: 0 5px;
            padding: 5px 10px;
            text-decoration: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            color: #333;
            background-color: #f9f9f9;
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination a:hover {
            background-color: rgb(103, 104, 106);
            color: white;
            border-color: rgb(117, 119, 121);
        }

        .pagination .current {
            font-weight: bold;
            background-color: rgb(0, 0, 0);
            color: white;
            border-color: rgb(0, 0, 0);
            cursor: default;
        }
    </style>
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <div style="display: flex; align-items: center; position: relative;">
                        <img src="../img/logo.png" alt="logo" width="85px" height="85px">
                        <span class="custom-font" style="margin-left: 10px; position: relative; top: 20px;">Shop</span>
                    </div>
                </li>

                <div class="">
                    <li>
                        <a href="" style="color: black;">
                            <span class="icon">
                                <ion-icon name="person-outline"></ion-icon>
                            </span>
                            <span class="title">ADMIN</span>
                        </a>
                    </li>
                </div>

                <li>
                    <a href="trangchuadmin.php" style="color: black;" id="active">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Trang chủ</span>
                    </a>
                </li>

                <li>
                    <a href="quanlydonhang.php" style="color: black;">
                        <span class="icon">
                            <ion-icon name="cart-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý đơn hàng</span>
                    </a>
                </li>

                <li>
                    <a href="quanlysanpham.php" style="color: black;">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý sản phẩm</span>
                    </a>
                </li>

                <li>
                    <a href="quanlykhachhang.php" style="color: black;">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý khách hàng</span>
                    </a>
                </li>

                <li>
                    <a href="quanlynhanvien.php" style="color: black;">
                        <span class="icon">
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý nhân viên</span>
                    </a>
                </li>

                <li>
                    <a href="quanlyncc.php" style="color: black;">
                        <span class="icon">
                            <ion-icon name="business-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý nhà cung cấp</span>
                    </a>
                </li>

                <li>
                    <a href="quanlykho.php" style="color: black;">
                        <span class="icon">
                            <ion-icon name="cube-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý kho</span>
                    </a>
                </li>

                <li>
                    <a href="thongke.php" style="color: black;">
                        <span class="icon">
                            <ion-icon name="bar-chart-outline"></ion-icon>
                        </span>
                        <span class="title">Thống kê</span>
                    </a>
                </li>
            </ul>
        </div>

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