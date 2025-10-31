<!DOCTYPE html>
<html lang="en">
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/admin/classes/ThongKe.php';

$data = new database();
$thongke = new ThongKe($data); 

// Nhận dữ liệu từ form (GET)
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$start  = isset($_GET['start']) ? $_GET['start'] : '';
$end    = isset($_GET['end']) ? $_GET['end'] : '';
$page   = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Gọi hàm trong class
$result = $thongke->getCustomers($search, $start, $end, $page, 5);

// Trích xuất dữ liệu
$customers = $result['data'];
$total_pages = $result['total_pages'];
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - MMB - Shop Bán Đồ Cầu Lông</title>
    <link href='../img/logo.png' rel='icon' type='image/x-icon' />
        <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="../css/indexadmin1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


</head>

<body>
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
                    <a href="trangchuadmin.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Trang chủ</span>
                    </a>
                </li>

                <li>
                    <a href="quanlydonhang.php"style="color: black;">
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
                    <a href="thongke.php"style="color: black;"id="active">
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
         
   
   

   
   
    <div class="banner">

    <form method="GET" action="">
    <div class="date1">
        <label for="start">Từ ngày: </label>
        <input type="date" id="start" name="start" value="<?= isset($_GET['start']) ? $_GET['start'] : '' ?>" min="2023-01-01" max="2025-12-31">

        <label for="end">đến</label>
        <input type="date" id="end" name="end" value="<?= isset($_GET['end']) ? $_GET['end'] : '' ?>" min="2023-01-01" max="2025-12-31">

        <button type="submit" class="search-btn">
            <i class="fa fa-search"></i> 
        </button>
    </div>
</form>
      
<form method="GET" action="">
                    <input id="timnguoidung" type="text" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" placeholder="Tên sản phẩm ...">   
                    <button type="submit" id="timnguoidung1">
        <i class="fa fa-search"></i> 
    </button>  
</form>
</div>
            

    

      
       

   
<div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Thống kê theo mặt hàng</h2>
            
        </div>
    <table>
        <thead>
            <tr>
                <td>Mã mặt hàng</td>
                <td>Tên mặt hàng</td>
                <td>Số Lượng bán ra</td>
                <td>Tổng tiền thu được</td>
                <td>Xem hóa đơn</td>
                <td></td>
            </tr>
        </thead>
  
        <tbody>
            <tr>
                <td>MH001</td>
                <td>Yonex</a></td>
                <td>200</td>
                <td>15.199.000 VND</td>
                <td> <a href="xemhoadon.php">Xem</td></a>
                <td></td>
            </tr>
            <tr>
                <td>MH002</td>
                <td> Lining </a></td>
                <td>100</td>
                <td>15.199.000 VND</td>
                <td> <a href="xemhoadon.php">Xem</td></a>
                <td></td>
            </tr>
            <tr>
                <td>MH003</td>
                <td>Victor </a></td>
                <td>100</td>
                <td>15.199.000 VND</td>
                <td> <a href="xemhoadon.php">Xem</td></a>
                <td></td>
            </tr>
            <tr>
                <td>MH004</td>
                <td>VNB </a></td>
                <td>50</td>
                <td>15.199.000 VND</td>
                <td> <a href="xemhoadon.php">Xem</td></a>
                <td></td>
            </tr>
            <tr>
                <td>MH005</td>
                <td>Mizuno</a></td>
                <td>100</td>
                <td>15.199.000 VND</td>
                <td> <a href="xemhoadon.php">Xem</td></a>
                <td></td>
            </tr>
            <tr>
                <td>MH005</td>
                <td>Apacs</a></td>
                <td>100</td>
                <td>15.199.000 VND</td>
                <td> <a href="xemhoadon.php">Xem</td></a>
                <td></td>
            </tr>
           
        </tbody>
  
    </table>
   
  
  
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

            <div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Thống kê theo khách hàng</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <td>Mã khách hàng</td>
                    <td>Tên khách hàng</td>
                    <td>Tổng số hóa đơn</td>
                    <td>Tổng tiền</td>
                    <td>Xem hóa đơn</td>
                    <td></td>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($customers as $row) { ?>
            <tr>
                <td><?= 'KH00' . $row['makh'] ?></td>
                <td><?= htmlspecialchars($row['tenkh']) ?></td>
                <td><?= $row['sohoadon'] ?></td>
                <td><?= number_format($row['tongtien'], 0, ',', '.') ?> VND</td>
                <td><a href="xemhoadon.php?id=<?= $row['makh'] ?>">Xem</a></td>
            </tr>
        <?php } ?>
            </tbody>
        </table>



<div class="pagination">
    <?php
    $base_url = "?search=" . urlencode($search) . "&start=" . urlencode($start) . "&end=" . urlencode($end);
    if ($page > 1) echo "<a href='{$base_url}&page=" . ($page - 1) . "'>Trước</a>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo ($i == $page)
            ? "<span class='hientai1'>$i</span>"
            : "<a href='{$base_url}&page=$i'>$i</a>";
    }
    if ($page < $total_pages) echo "<a href='{$base_url}&page=" . ($page + 1) . "'>Sau</a>";
    ?>
</div>
    </div>
        </div>

        

        <div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Top 5 Khách Hàng Mua Nhiều Nhất</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <td>STT</td>
                    <td>Tên khách hàng</td>
                    <td>Số đơn hàng</td>
                    <td>Tổng tiền</td>
                    <td>Xem hóa đơn</td>
                </tr>
            </thead>
            <tbody>
               <body>
    <?php
        // Lấy 5 khách hàng mua nhiều nhất
        $sql = "SELECT 
                    khach_hang.MAKH AS makh, 
                    khach_hang.HOTEN AS tenkh, 
                    COUNT(don_hang.MADH) AS sohoadon, 
                    SUM(don_hang.TONGTIEN) AS tongtien
                FROM khach_hang
                LEFT JOIN don_hang ON khach_hang.MAKH = don_hang.MAKH
                GROUP BY khach_hang.MAKH, khach_hang.HOTEN
                ORDER BY sohoadon DESC 
                LIMIT 5";

        $data->select($sql);
        $stt = 1; // Khởi tạo số thứ tự
    ?>

    <?php while ($row = $data->fetch()) { ?>
        <tr>
            <td><?= $stt++ ?></td> <!-- Hiển thị số thứ tự -->
            <td><?= htmlspecialchars($row['tenkh']) ?></td>
            <td><?= $row['sohoadon'] ?></td>
            <td><?= number_format($row['tongtien'], 0, ',', '.') ?> VND</td>
            <td><a href="xemhoadon.php?id=<?= $row['makh'] ?>">Xem</a></td>
        </tr>
    <?php } ?>
</body>

            </tbody>
        </table>
    </div>
</div>

    <div class="details">
        <div class="recentOrders">
            <div class="cardHeader">
                <h2>Sản phẩm bán chạy nhất</h2>
                
            </div>
        <table>
            <thead>
                <tr>
                    <td>Mã mặt hàng</td>
                    <td>Tên mặt hàng</td>
                    <td>Ảnh</td>
                    <td>Số Lượng bán ra</td>
                    <td>Tổng tiền thu được</td>
                    <td></td>
                </tr>
            </thead>
      
            <tbody>
                <tr>
                    <td>MH001</td>
                    <td>Vợt Yonex Astrox 100zz</a></td>
                                                <td><img src="../img/product-1.jpg"></td>
                
                    <td>200</td>
                    <td>150.199.000 VND</td>
                    <td></td>
                </tr>
                
               
            </tbody>
      
        </table>
      </div>
      </div>
      <div class="details">
        <div class="recentOrders">
            <div class="cardHeader">
                <h2>Sản phẩm bán ế nhất</h2>
                
            </div>
        <table>
            <thead>
                <tr>
                    <td>Mã mặt hàng</td>
                    <td>Tên mặt hàng</td>
                    <td>Ảnh</td>
                    <td>Số Lượng bán ra</td>
                    <td>Tổng tiền thu được</td>
                    <td></td>
                </tr>
            </thead>
      
            <tbody>
                <tr>
                    <td>MH002</td>
                    <td>Vợt Lining Calibar 900B</a></td>
                    <td><img src="../img/product-8.jpg"></td>
                
                    <td>50</td>
                    <td>15.199.000 VND</td>
                    <td></td>
                </tr>
                
               
            </tbody>
      
        </table>
       
      
      
      
      
      </div>
      </div>
  
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>