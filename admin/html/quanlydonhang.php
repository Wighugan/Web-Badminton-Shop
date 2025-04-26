<!DOCTYPE html>
<html lang="en">
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydp";

// Kết nối MySQL
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Lấy dữ liệu từ GET
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$start_date = isset($_GET['start']) ? $_GET['start'] : '';
$end_date = isset($_GET['end']) ? $_GET['end'] : '';

// Base query
$sql = "SELECT orders.*, users.fullname, users.numberphone, users.city 
        FROM orders 
        JOIN users ON orders.user_id = users.id ";
$where = [];
$params = [];
$param_types = "";

// Xử lý tìm kiếm
if (!empty($search)) {
    $where[] = "users.fullname LIKE ?";
    $params[] = "%$search%";
    $param_types .= "s";
}

// Xử lý lọc ngày
if (!empty($start_date) && !empty($end_date)) {
    $where[] = "DATE(orders.created_at) BETWEEN ? AND ?";
    $params[] = $start_date;
    $params[] = $end_date;
    $param_types .= "ss";
}

// Ghép điều kiện WHERE nếu có
if (!empty($where)) {
    $sql .= " WHERE " . implode(' AND ', $where);
}

// Sắp xếp và phân trang
$sql .= " ORDER BY orders.created_at DESC LIMIT ?, ?";
$params[] = $offset;
$params[] = $limit;
$param_types .= "ii";

// Chuẩn bị statement
$stmt = $conn->prepare($sql);

// Gắn giá trị vào statement
if (!empty($params)) {
    $stmt->bind_param($param_types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Đếm tổng số đơn hàng để phân trang
$sql_count = "SELECT COUNT(*) as total FROM orders JOIN users ON orders.user_id = users.id";
if (!empty($where)) {
    $sql_count .= " WHERE " . implode(' AND ', $where);
}
$stmt_count = $conn->prepare($sql_count);

// Gắn tham số cho count
if (!empty($params)) {
    // Bỏ LIMIT và OFFSET ra khỏi count
    $params_count = array_slice($params, 0, count($params) - 2);
    $types_count = substr($param_types, 0, strlen($param_types) - 2);
    if (!empty($params_count)) {
        $stmt_count->bind_param($types_count, ...$params_count);
    }
}
$stmt_count->execute();
$result_total = $stmt_count->get_result()->fetch_assoc();
$total_orders = $result_total['total'];
$total_pages = ceil($total_orders / $limit);

$stt = 1;
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - MMB - Shop Bán Đồ Cầu Lông</title>
    <link href='../img/logo.png' rel='icon' type='image/x-icon' />
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="../css/indexadmin.css">
    <link rel="stylesheet" href="../css/quanlydonhang.css">
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
                    <a href="quanlydonhang.php"style="color: black;" id="active">
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
                <div class="banner">
                <form method="GET" action="">
    <div class="date1">
        <label for="start">Từ ngày: </label>
        <input type="date" id="start" name="start" 
               value="<?= isset($_GET['start']) ? htmlspecialchars($_GET['start']) : '' ?>" 
               min="2023-01-01" max="2025-12-31">

        <label for="end">đến</label>
        <input type="date" id="end" name="end" 
               value="<?= isset($_GET['end']) ? htmlspecialchars($_GET['end']) : '' ?>" 
               min="2023-01-01" max="2025-12-31">

        <button type="submit" class="search-btn">
            <i class="fa fa-search"></i> 
        </button>
    </div>
</form>


                  
<form method="GET" action="">
    <input id="timnguoidung" type="text" name="search" 
           value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
           placeholder="Tên người dùng ...">

    <button type="submit" id="timnguoidung1" class="search-btn">
        <i class="fa fa-search"></i> 
    </button>  
</form>

                </div>
                <div class="chartsBx">
                  
                </div>
            

                    <div class="details">
                        <div class="recentOrders">
                    <table>
                        <thead>
                            <tr>
                                <td>STT</td>
                                <td>Mã đơn hàng</td>
                                <td>Người đặt</td>
                                <td>SĐT</td>
                                <td>Địa chỉ</td>
                             
                                <td>Tình Trạng</td>
                                <td>Ngày</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $stt++ ?></td>
        <td><a href="chitietdonhang.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['code']) ?></a></td>
        <td><?= htmlspecialchars($row['fullname']) ?></td>
        <td><?= htmlspecialchars($row['numberphone']) ?></td>
        <td><?= htmlspecialchars($row['city']) ?></td>

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
        <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>

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
                echo "<a href='quanlydonhang.php?page=" . ($page - 1) . "'>Trước</a>";
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo "<span class='current'>$i</span>";
                } else {
                    echo "<a href='quanlydonhang.php?page=$i'>$i</a>";
                }
            }

            if ($page < $total_pages) {
                echo "<a href='quanlydonhang.php?page=" . ($page + 1) . "'>Sau</a>";
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