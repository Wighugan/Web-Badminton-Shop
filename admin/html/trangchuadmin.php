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
$sql = "SELECT orders.*, users.fullname, users.numberphone 
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
                    
                        <div style="display: flex; align-items: center; position: relative;">

                        <img src="../img/logo.png" alt="a logo" width="85px" height="85px">

                        <span class="custom-font" style="margin-left: 10px; position: relative; top: 20px;">Shop</span>
</div>
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
                    <a href="trangchuadmin.php" style="color: black;" id="active">
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
                    <a href="quanlysanpham.php" style="color: black;">
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
       
                <div class="search" >
                    <label>
                        <input type="text" placeholder="Tìm kiếm chức năng quản trị">
                       <a href=" "><ion-icon name="search-outline"></ion-icon></a>
                    </label>
                </div>
            </div>
            <!-- ======================= Cards ================== -->
            
            <!----
            <h2 style="margin-left: 20px;">Thống kê tình hình kinh doanh</h2>
        
            <div class="filter">
                <div class="flex">
                <span><input type="radio" name="chon" value="ten" id="ten" onclick="checkTen()" checked>Theo tên sản phẩm</span>
                <span><input type="radio" name="chon" value="loai" id="loai" onclick="checkLoai()">Theo loại sản phẩm</span>
                <input type="text" name="tenSp" id="tenSp" placeholder="Tên sản phẩm">
                <select name="loaiSp" id="loaiSp">
                    <option value="Kỹ năng sống - Phát triển bản thân">Kỹ năng sống - Phát triển bản thân</option>
                    <option value="Manga-Comic">Manga-Comic</option>
                    <option value="Nghệ thuật-Văn hóa">Nghệ thuật-Văn hóa</option>
                </select>
                </div>
                <div class="date">
                    <label for="start">Từ ngày: </label>
                    <input type="date" id="start" name="start" value="2023-11-24" min="2018-01-01" max="2023-12-31">
                    <label for="start">đến </label>
                    <input type="date" id="end" name="end" value="2023-11-30" min="2018-01-01" max="2023-12-31">
                </div>
                <button class="thongke"><a href="thongke.html">Thống kê</a></button>
            </div>
        -->
        <div class="chartsBx">
            <h2>                                                   </h2>
           
        </div>

            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Đơn hàng gần đây</h2>
                        <a href="quanlydonhang.html" class="btn">Xem chi tiết</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>STT</td>
                                <td>Mã Đơn hàng</td>
                                <td>Người đặt</td>
                                <td>SĐT</td>
                                <td>Tình trạng</td>
                                <td>Tổng tiền</td>
                                <td>Ngày</td>
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

<td class="<?= $class ?>"><?= htmlspecialchars($status) ?></td>        <td><?= number_format($row['total'], 0, ',', '.') ?> VND</td>

        <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
    </tr>
<?php } ?>

                        </tbody>
                    </table>
                    <div class="pagination">
                        <li class="hientai">1</li>
                        <li><a href="trangchuadmin.html" style="color: black;">2</a></li></a> 
                        <li><a href="trangchuadmin.html" style="color: black;" >NEXT</a></li>
                    </div>
                </div>
           
                
               

            <script>
            
                    ten = document.getElementById("ten");
                    loai = document.getElementById("loai");
                    tenSp = document.getElementById("tenSp");
                    loaiSp = document.getElementById("loaiSp");
                    function checkTen(){
                        tenSp.style.display="block";
                        loaiSp.style.display="none";
                    }
        
                    function checkLoai(){
                        tenSp.style.display="none";
                        loaiSp.style.display="block";
                    }
                      
            </script>
            </div>
    </div>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>