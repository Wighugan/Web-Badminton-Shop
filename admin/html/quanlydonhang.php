<!DOCTYPE html>
<html lang="en">
<?php
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
$sql = "SELECT orders.*, users.fullname, users.numberphone ,users.city
        FROM orders 
        JOIN users ON orders.user_id = users.id 
        ORDER BY orders.created_at ASC";

$result = mysqli_query($conn, $sql);
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
                <div class="search">
                    <label>
                        <input type="text" placeholder="Tìm kiếm chức năng quản trị">
                        <a href=" "><ion-icon name="search-outline"></ion-icon></a>
                    </label>
                </div>
            </div>

            <!-- ================ LÀM QUẢN LÝ ĐƠN HÀNG Ở ĐÂY ================= -->
            <div class="order">
                <!-- ================ LÀM BANNER ================= -->
                <div class="banner">
                    <select id="month">
                        <option>Tháng 12</option>
                        <option>Tháng 1</option>
                        <option>Tháng 2</option>
                        <option>Tháng 3</option>
                        <option>Tháng 4</option>
                        <option>Tháng 5</option>
                        <option>Tháng 6</option>
                        <option>Tháng 7</option>
                        <option>Tháng 8</option>
                        <option>Tháng 9</option>
                        <option>Tháng 10</option>
                        <option>Tháng 11</option>
                    </select>
                    <select id="month">
                        <option>Chọn Quận/Huyện</option>
                        <option>Quận 1</option>
                        <option>Quận 3</option>
                        <option>Quận 4</option>
                        <option>Quận 5</option>
                        <option>Quận 6</option>
                        <option>Quận 7</option>
                        <option>Quận 8</option>
                        <option>Quận 9</option>
                        <option>Quận 10</option>
                        <option>Quận 11</option>
                        <option>Quận 12</option>
                        <option>Bình Thạnh</option>
                        <option>Gò Vấp</option>
                        <option>Phú Nhuận</option>
                        <option>Tân Bình</option>
                        <option>Tân Phú</option>
                        <option>Bình Tân</option>
                        <option>Thủ Đức</option>
                        <option>Huyện Nhà Bè</option>
                        <option>Huyện Bình Chánh</option>
                        <option>Huyện Hóc Môn</option>
                        <option>Huyện Củ Chi</option>
                        <option>Huyện Cần Giờ</option>
                    </select>
                    <select id="chon" onchange="showCustomDate()">
                        <option value="today">Hôm nay</option>
                        <option value="yesterday">Hôm qua</option>
                        <option value="last7days">7 ngày trước</option>
                        <option value="last30days">30 ngày trước</option>
                        <option value="custom">Tùy chọn</option>
                    </select>

                    <div id="customDate" style="display: none;">
                        <label for="fromDate">Từ ngày:</label>
                        <input type="date" id="fromDate">
                        <label for="toDate">Đến ngày:</label>
                        <input type="date" id="toDate">
                        <label><input onclick="gui()" type="submit"></label>
                    </div>

                    <script>
                        function showCustomDate() {
                            const select = document.getElementById('chon');
                            const customDate = document.getElementById('customDate');

                            if (select.value === 'custom') {
                                customDate.style.display = 'block';
                            } else {
                                customDate.style.display = 'none';
                            }
                        }

                        function gui() {
                            const fromDate = document.getElementById('fromDate').value;
                            const toDate = document.getElementById('toDate').value;
                            const customDate = document.getElementById('customDate');

                            if (fromDate !== '' && toDate !== '') {
                                alert(`Đã cập nhật các đơn hàng từ ${fromDate} đến ${toDate}`);
                                customDate.style.display = 'none'; // Ẩn box khi nhấn OK trên alert
                            } else {
                                alert("Vui lòng nhập đầy đủ thông tin ngày");
                            }
                        }
                    </script>

                    <div class="finder">
                        <select id="find">
                            <option>Tìm theo mã đơn hàng</option>
                            <option>Tìm theo thời gian</option>
                            <option>Tìm theo SĐT</option>
                            <option>Tìm theo tên người dùng</option>
                        </select>
                       
                    </div>
                    <form action="">
                        <input id="timnguoidung" type="text" placeholder="Tên người dùng ...">
    
                        
                           
                      
                           
                        <a href ="" id="timnguoidung1" >
    
                            <i class="fa fa-search"></i> 
    
                        </a>  
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
?>

<td class="<?= $class ?>"><?= htmlspecialchars($status) ?></td>
        <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>

    </tr>
<?php } ?>



                        </tbody>
                    </table>
                    <div class="pagination">
                        <li class="hientai">1</li>
                        <li><a href="quanlydonhang.html" style="color: black;">2</a></li></a> 
                        <li><a href="quanlydonhang.html" style="color: black;" >NEXT</a></li>
                    </div>
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