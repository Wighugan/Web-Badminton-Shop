<?php
include  $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/order.php';
// Khởi tạo kết nối và class
$data = new database();
$order = new order($data);

// Nhận tham số lọc & tìm kiếm
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$start_date = isset($_GET['start']) ? $_GET['start'] : '';
$end_date = isset($_GET['end']) ? $_GET['end'] : '';
$DIACHI1 = isset($_GET['DIACHI1']) ? trim($_GET['DIACHI1']) : '';
$TRANGTHAI = isset($_GET['TRANGTHAI']) ? trim($_GET['TRANGTHAI']) : '';
// Lấy danh sách đơn hàng và tổng số
$orders = $order->getOrders($page, $search, $start_date, $end_date, $DIACHI1, $TRANGTHAI);
$total_orders = $order->countOrders($search, $start_date, $end_date, $DIACHI1, $TRANGTHAI);
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
                    <a href="quanlynhanvien.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý nhân viên</span>
                    </a>
                </li>
</li>

<li>
                    <a href="quanlyncc.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="business-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý nhà cung cấp</span>
                    </a>
                </li>

                </li>

<li>
                    <a href="quanlykho.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="cube-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý kho</span>
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
        <!-- Ngày -->
        <label for="start">Từ ngày: </label>
        <input type="date" id="start" name="start" 
            value="<?= isset($_GET['start']) ? htmlspecialchars($_GET['start']) : '' ?>" 
            min="2023-01-01" max="2025-12-31">

        <label for="end">đến</label>
        <input type="date" id="end" name="end" 
            value="<?= isset($_GET['end']) ? htmlspecialchars($_GET['end']) : '' ?>" 
            min="2023-01-01" max="2025-12-31">
    </div>

    <div class="date1">
        <!-- Quận/huyện -->
        <select name="DIACHI1" id="DIACHI1">
            <option value="">Chọn Quận/Huyện</option>
          
            <option value="Quận 2" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Quận 2') ? 'selected' : '' ?>>Quận 2</option>
<option value="Quận 3" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Quận 3') ? 'selected' : '' ?>>Quận 3</option>
  <option value="Quận 5" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Quận 5') ? 'selected' : '' ?>>Quận 5</option>
<option value="Quận 4" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Quận 4') ? 'selected' : '' ?>>Quận 4</option>
<option value="Quận 5" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Quận 5') ? 'selected' : '' ?>>Quận 5</option>
<option value="Quận 6" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Quận 6') ? 'selected' : '' ?>>Quận 6</option>
<option value="Quận 7" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Quận 7') ? 'selected' : '' ?>>Quận 7</option>
<option value="Quận 8" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Quận 8') ? 'selected' : '' ?>>Quận 8</option>
<option value="Quận 9" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Quận 9') ? 'selected' : '' ?>>Quận 9</option>
<option value="Quận 10" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Quận 10') ? 'selected' : '' ?>>Quận 10</option>
<option value="Quận 11" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Quận 11') ? 'selected' : '' ?>>Quận 11</option>
<option value="Quận 12" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Quận 12') ? 'selected' : '' ?>>Quận 12</option>


<option value="Gò Vấp" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Gò Vấp') ? 'selected' : '' ?>>Gò Vấp</option>
            <option value="Bình Thạnh" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Bình Thạnh') ? 'selected' : '' ?>>Bình Thạnh</option>
<option value="Phú Nhuận" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Phú Nhuận') ? 'selected' : '' ?>>Phú Nhuận</option>
<option value="Tân Bình" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Tân Bình') ? 'selected' : '' ?>>Tân Bình</option>
<option value="Tân Phú" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Tân Phú') ? 'selected' : '' ?>>Tân Phú</option>
<option value="Bình Tân" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Bình Tân') ? 'selected' : '' ?>>Bình Tân</option>
<option value="Thủ Đức" <?= (isset($_GET['DIACHI1']) && $_GET['DIACHI1'] == 'Thủ Đức') ? 'selected' : '' ?>>Thủ Đức</option>      
  </select>
    </div>

    <div class="date1">
        <!-- Tình trạng -->
        <select name="TRANGTHAI" id="TRANGTHAI">
            <option value="">Tình Trạng</option>
            <option value="Thành công" <?= (isset($_GET['TRANGTHAI']) && $_GET['TRANGTHAI'] == 'Thành công') ? 'selected' : '' ?>>Thành công</option>
            <option value="Chờ xác nhận" <?= (isset($_GET['TRANGTHAI']) && $_GET['TRANGTHAI'] == 'Chờ xác nhận') ? 'selected' : '' ?>>Chờ xác nhận</option>
            <option value="Đã hủy" <?= (isset($_GET['TRANGTHAI']) && $_GET['TRANGTHAI'] == 'Đã hủy') ? 'selected' : '' ?>>Đã hủy</option>
            <option value="Đang giao" <?= (isset($_GET['TRANGTHAI']) && $_GET['TRANGTHAI'] == 'Đang giao') ? 'selected' : '' ?>>Đang giao</option>
        </select>
    </div>

    <div class="date1">
        <button type="submit" class="search-btn">
            <i class="fa fa-search"></i> Tìm kiếm
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
                        <?php foreach ($orders as $row): ?>
            <tr>
                <td><?= $stt++ ?></td>
                <td><a href="chitietdonhang.php?id=<?= htmlspecialchars($row['MADH']) ?>"><?= htmlspecialchars($row['CODE']) ?></a></td>
                <td><?= htmlspecialchars($row['HOTEN']) ?></td>
                <td><?= htmlspecialchars($row['SDT']) ?></td>
                <td><?= htmlspecialchars($row['DIACHI1']) ?></td>
                <?php
                $status = $row['TRANGTHAI'];
                $class = '';
                if ($status == 'Thành công') {
                    $class = 'success';
                } elseif ($status == 'Chờ xác nhận') {
                    $class = 'pending';
                } elseif ($status == 'Đã hủy') {
                    $class = 'cancelled';
                } elseif ($status == 'Đang giao') {
                    $class = 'shipping';
                }
                ?>
                <td class="<?= htmlspecialchars($class) ?>"><?= htmlspecialchars($status) ?></td>
                <td><?= date('d/m/Y', strtotime($row['NGAYLAP'])) ?></td>
            </tr>
        <?php endforeach; ?>



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
// Function để xây dựng URL pagination, giữ tất cả GET params trừ 'page'
function buildPageUrl($pageNumber, $extraParams = []) {
    $currentParams = $_GET; // Lấy tất cả GET params hiện tại
    unset($currentParams['page']); // Bỏ param 'page' cũ
    $newParams = array_merge($currentParams, $extraParams, ['page' => $pageNumber]); // Thêm page mới và extra nếu có
    return '?' . http_build_query($newParams); // Trả về query string như ?search=abc&page=2
}

// ... (Phần code query trước đó: $data->select_prepare, lưu $orders[], tính $total_pages)

// Pagination (đặt sau loop hiển thị)
if ($total_pages > 1) { // Chỉ hiển thị nếu có nhiều trang
    echo '<div class="pagination">'; // Wrapper CSS cho đẹp (thêm style nếu cần)
    
    // Link "Trước"
    if ($page > 1) {
        echo "<a href='" . buildPageUrl($page - 1) . "'>Trước</a> ";
    }

    // Các số trang (có thể thêm ellipsis cho dài)
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo "<span class='current'>$i</span> ";
        } else {
            echo "<a href='" . buildPageUrl($i) . "'>$i</a> ";
        }
    }

    // Link "Sau"
    if ($page < $total_pages) {
        echo "<a href='" . buildPageUrl($page + 1) . "'>Sau</a>";
    }
    echo '</div>';
} else {
    echo "<p>Chỉ có 1 trang kết quả.</p>";
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