<!DOCTYPE html>
<html lang="en">
<?php


// Kết nối đến MySQL
$conn = new mysqli("localhost", "root", "", "mydp");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy thông tin đơn hàng + khách hàng
$sql_order = "SELECT orders.*, users.fullname, users.numberphone , users.address1 FROM orders 
              JOIN users ON orders.user_id = users.id 
              WHERE orders.id = ?";
$stmt_order = $conn->prepare($sql_order);
$stmt_order->bind_param("i", $order_id);
$stmt_order->execute();
$result_order = $stmt_order->get_result();
$order = $result_order->fetch_assoc();

// Lấy danh sách sản phẩm trong đơn hàng
$sql_detail = "SELECT * FROM order_details WHERE order_id = ?";
$stmt_detail = $conn->prepare($sql_detail);
$stmt_detail->bind_param("i", $order_id);
$stmt_detail->execute();
$result_detail = $stmt_detail->get_result();
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - MMB - Shop Bán Đồ Cầu Lông</title>
    <link href='../img/logo.png' rel='icon' type='image/x-icon' />
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="../css/indexadmin3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

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
                    <a href="trangchuadmin.php" style="color: black;" >
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
                       <a href=""><ion-icon name="search-outline"></ion-icon></a>
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
                        <h2>CHI TIẾT ĐƠN HÀNG </h2>

                        
                       
                    </div>
                    <div class="card">
                    <div class="thongtinnguoimua">
                        <p> <span style="font-weight: bold;">Mã đơn hàng:</span> <?= $order['code'] ?></span></p>

                        <p> <span style="font-weight: bold;">Tên Khách Hàng:</span> <?= $order['fullname'] ?></span></p>
                        <p> <span style="font-weight: bold;">Số điện thoại:</span> <?= $order['numberphone'] ?></p>

                        
                        <p> <span style="font-weight: bold;">Địa chỉ giao hàng:</span>  <?= $order['address1'] ?></p>
                    </div>
                    <div class="thongtinnguoimua">
                        <p> <span style="font-weight: bold;">Ngày đặt hàng:</span> <?= $order['created_at'] ?></span></p>
                        <p> <span style="font-weight: bold;">Thanh toán:</span> Thanh toán khi nhận hàng</span></p>
                        <p> <span style="font-weight: bold;">Trạng thái đơn hàng:</span><span style="color: <?= $order['status'] === 'Thành công' ? 'green' : 'red' ?>">
                <?= $order['status'] ?>
            </span></p>

                    </div>
                </div>
                    <table>
                        <thead>
                            <tr>
                                <td>STT</td>
                                <td>Mã sản phẩm</td>
                                <td>Tên sản phẩm</td>
                                <td>Số lượng</td>
                                <td>Đơn giá</td>
                                <td>Thành tiền</td>
                                
                                <td></td>
                            </tr>
                        </thead>

                        <tbody>
                        <?php 
        $i = 1;
        $total = 0;
        while($row = $result_detail->fetch_assoc()) { 
            $thanhtien = $row['quantity'] * $row['product_price'];
            $total += $thanhtien;
        ?>
        <tr>
            <td><?= $i++ ?></td>
            <td>SP00<?= $row['id'] ?></td>
            <td><?= $row['product_name'] ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= number_format($row['product_price'], 0, ',', '.') ?> VND</td>
            <td><?= number_format($thanhtien, 0, ',', '.') ?> VND</td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="4"></td>
            <td><b>Tổng tiền:</b></td>
            <td><b><?= number_format($total, 0, ',', '.') ?> VND</b></td>
        </tr>
                           
                           

                            <tr>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <uL>
                            <li><span style="font-weight: bold;"></span></li>
                            <p style="opacity: 0.5;"> </p>
                            <P style="opacity: 0.5;"></P>
                            
                        </uL>
                       
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