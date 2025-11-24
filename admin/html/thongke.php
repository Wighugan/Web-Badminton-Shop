<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/ThongKe.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';

$data = new database();
$thongke = new ThongKe();
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

// Nhận dữ liệu từ GET
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$start  = isset($_GET['start']) ? $_GET['start'] : '';
$end    = isset($_GET['end']) ? $_GET['end'] : '';
$page   = isset($_GET['page']) ? intval($_GET['page']) : 1;

// ✅ Gọi hàm để lấy dữ liệu khách hàng
$result = $thongke->getCustomers($search, $start, $end, $page);

// ✅ Trích xuất dữ liệu
$customers = $result['data'];
$total_pages = $result['total_pages'];
$current_page = $result['page'];
$limit = $result['limit'];
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
    <link rel="stylesheet" href="../css/indexadmin1.css">
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
</div>
  
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>