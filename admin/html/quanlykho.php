<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/products.php';
include  $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';
$data =  new Database();
$product = new SanPham();
session_start();
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
// ✅ Nhận tham số GET
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
// ✅ Lấy danh sách sản phẩm theo trang
$products = $product->getProductsByPage($page, $search, $category);
// ✅ Đếm tổng sản phẩm để phân trang
$total_products = $product->demSoSanPham($search, $category);
$total_pages = ceil($total_products / $product->getLimit());
$stt = ($page - 1) * $product->getLimit() + 1;
// ✅ Lấy danh mục để hiển thị bộ lọc
$categories = $product->getCategories();
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
    <link rel="stylesheet" href="../css/quanlykhachhang.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
     <?php 
     include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/header-admin.php';
    ?>
    <!-- =============== Navigation ================ -->
    

        <div class="main">
            <div class="topbar">
                <div class="hello">
                    <p>CHÀO MỪNG ADMIN CỦA MMB</p>
                </div>
               
            </div>

            <div class="user"  >         
                      <div class="banner">
                    <button id="adduser"><a href="phieunhap.php">+ Tạo phiếu nhập</a></button>
                    
                                       <button id="adduser"><a href="xemphieunhap.php">+Xem danh sách phiếu nhập</a></button>

                    <form method="GET" action="" >

                   

                    <form method="GET" action="">
                    <input id="timnguoidung" type="text" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" placeholder="Tên người dùng ...">   
                    <button type="submit" id="timnguoidung1">
        <i class="fa fa-search"></i> 
    </button>  
</form>


                
                </div>
                <div class="chartsBx">
                    <h2></h2>
                </div>
                

                <div class="details">
                    <div class="recentOrders">
                        <div class="cardHeader">
                            <h2></h2>
                        </div>
                    <table>
                        <thead>
                            <tr>
                                <td>STT</td>
                                <td>Tên sản phẩm </td>
                            
                                <td>Giá nhập</td>
                                <td>Giá bán</td>
                                <td>Thương hiệu</td>
                                <td>Tồn kho</td>
                               
                            </tr>
                        </thead>

                        <tbody>
                           
            
   <?php
   $stt = ($page - 1) * $product->getLimit() + 1; 

        if (!empty($products)) {
            foreach ($products as $row) {
                  $id = (int)$row['MASP'];
    $image = htmlspecialchars($row['IMAGE']);
    $name = htmlspecialchars($row['TENSP']);
    $cost_price = number_format($row['GIANHAP'], 0, ',', '.') . ' VND';
    $price = number_format($row['DONGIA'], 0, ',', '.') . ' VND';
    $category = htmlspecialchars($row['TENLOAI']);
    $stock = (int)$row['SOLUONG'];
                
                echo "<tr>";
                echo "<td>{$stt}</td>";
                
            
                
                echo "<td>{$name}</td>";
                echo "<td>{$cost_price}</td>";
                echo "<td>{$price}</td>";
                echo "<td>{$category}</td>";
                echo "<td>{$stock}</td>";
echo "</tr>";
                $stt++;
            }
        } else {
            echo "<tr><td colspan=\"9\" class=\"text-center text-muted\">Không có người dùng nào!</td></tr>";
        }
        ?>






                        </tbody>
                    </table>

                    <div class="pagination">
    <?php
    // Nút Trước
    if ($page > 1) {
        echo "<a href='?page=" . ($page - 1) . "&search=" . urlencode($search) . "'>Trước</a>";
    }

    // Các số trang
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo "<span class='hientai1'>$i</span>";  // Trang hiện tại
        } else {
            echo "<a href='?page=$i&search=" . urlencode($search) . "'>$i</a>";  // Trang khác
        }
    }

    // Nút Sau
    if ($page < $total_pages) {
        echo "<a href='?page=" . ($page + 1) . "&search=" . urlencode($search) . "'>Sau</a>";
    }
    ?>
</div>


            <!-- ================ Add Charts JS ================= -->
            </div>

            
        </div>

  


            <!-- ================ Add Charts JS ================= -->
            </div>

        
        </div>


    </div>
    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="../js/chartuser.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
   
</body>

</html>