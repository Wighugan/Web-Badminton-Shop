<!DOCTYPE html>
<html lang="en">
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydp";

// Kết nối đến MySQL
$conn = mysqli_connect($servername, $username, $password, $dbname);

$limit = 10;

// Lấy số trang hiện tại từ query string, nếu không có thì mặc định là 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
// Kiểm tra kết nối
if (!$conn) {
	die("Kết nối thất bại: " . mysqli_connect_error());
}
$sql = "SELECT orders.*, users.fullname, users.numberphone  , users.address ,users.id AS makh
        FROM orders 
        JOIN users ON orders.user_id = users.id 
        ORDER BY orders.created_at DESC
        LIMIT $offset, $limit";

$result = mysqli_query($conn, $sql);
$stt = 1;

$sql_total = "SELECT COUNT(*) as total FROM orders";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_orders = $row_total['total'];
$total_pages = ceil($total_orders / $limit);
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - MMB - Shop Bán Đồ Cầu Lông</title>
    <link href='../img/logo.png' rel='icon' type='image/x-icon' />
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="../css/indexadmin2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
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
   
</style>
<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <div style="display: flex; align-items: center; position: relative;">

                            <img src="../img/logo.png" alt="a logo" width="85px" height="85px">
    
                            <span class="custom-font" style="margin-left: 10px; position: relative; top: 20px;">Shop</span>
    </div>
    
                        </a>
                </li>

                </li>
                
                <div class="">
                <li>
                    <a href="" style="color: black;" id="">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">ADMIN</span>
                    </a>
                </li>
            </div>

                <li>
                    <a href="trangchuadmin.php" style="color: black;">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Trang chủ</span>
                    </a>
                </li>

                <li>
                    <a href="quanlydonhang.php"style="color: black;" >
                        <span class="icon">
                            <ion-icon name="cart-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý đơn hàng</span>
                    </a>
                </li>

                <li>
                    <a href="quanlysanpham.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý sản phẩm</span>
                    </a>
                </li>

                <li>
                    <a href="quanlykhachhang.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý khách hàng</span>
                    </a>
                </li>
                <li>
                    <a href="thongke.php"style="color: black;">
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

            <!-- ================ LÀM QUẢN LÝ ĐƠN HÀNG Ở ĐÂY ================= -->
            <div class="order">
                <!-- ================ LÀM BANNER ================= -->
              
                <div class="chartsBx">
                  
                </div>
            

                    <div class="details">
                        <div class="recentOrders">
                            <div class="cardHeader">
                                <h2>DANH SÁCH ĐƠN HÀNG </h2>
        
                                
                               
                            </div>
                    <table>
                        <thead>
                            <tr>
                                <td>STT</td>
                                <td>Mã đơn hàng</td>
                                <td>Người đặt</td>
                                <td>SĐT</td>
                                <td>Địa chỉ</td>
                                <td>Ngày đặt hàng</td>
                                <td>Tình Trạng</td>
                                <td>Chi tiết</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $stt++ ?></td>
        <td><a href="chitietdonhang.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['code']) ?></a></td>
        <td><?= htmlspecialchars($row['fullname']) ?></td>
        <td><?= htmlspecialchars($row['numberphone']) ?></td>
        <td><?= htmlspecialchars($row['address']) ?></td>

        <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>

        <?php
$status = $row['status'];
$class = '';

if ($status == 'Thành công') {
    $class = 'success';
} elseif ($status == 'Chờ xác nhận') {
    $class = 'pending';
} elseif ($status == 'Đã hủy') {
    $class = 'cancelled';
}
elseif ($status == 'Đang giao') {
    $class = 'shipping';
}
?>

<td class="<?= $class ?>"><?= htmlspecialchars($status) ?></td>

<td><a href="hoadon.php?id=<?= $row['id'] ?>">Xem chi tiết</a></td>

    </tr>
<?php } ?>

                        </tbody>
                    </table>
                    <style>
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 30px 0;
    font-family: Arial, sans-serif;
    font-size: 13px; /* giảm cỡ chữ */
}

.pagination a, .pagination .current {
    margin: 0 5px;
    padding: 5px 10px; /* giảm padding cho gọn */
    text-decoration: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    color: #333;
    background-color: #f9f9f9;
    transition: background-color 0.3s, color 0.3s;
}

.pagination a:hover {
    background-color:rgb(103, 104, 106);
    color: white;
    border-color:rgb(117, 119, 121);
}

.pagination .current {
    font-weight: bold;
    background-color:rgb(0, 0, 0);
    color: white;
    border-color:rgb(0, 0, 0);
    cursor: default;
}
</style>
        <!-- Phân trang -->
        <div class="pagination">
            <?php
            // Hiển thị liên kết phân trang
            if ($page > 1) {
                echo "<a href='xemhoadon.php?page=" . ($page - 1) . "'>Trước</a>";
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo "<span class='current'>$i</span>";
                } else {
                    echo "<a href='xemhoadon.php?page=$i'>$i</a>";
                }
            }

            if ($page < $total_pages) {
                echo "<a href='xemhoadon.php?page=" . ($page + 1) . "'>Sau</a>";
            }
            ?>
        </div>




                <!-- ================ Add Charts JS ================= -->


            </div>
        </div>
    </div>
    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="../js/chartdonhang.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>