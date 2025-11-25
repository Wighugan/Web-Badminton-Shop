<?php
include  $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/class/products.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php';
$data = new database();
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
$product = new SanPham();
$page     = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$search   = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$products = $product->getProductsByPage($page, $search, $category); // ✔ exists
// Đếm tổng theo cùng bộ lọc (tự xây dựng where/params/types giống bên trong getProductsByPage)
$where  = "WHERE 1=1";
$params = [];
$types  = "";
if (!empty($search)) {
    $where  .= " AND sp.TENSP LIKE ?";
    $params[] = "%$search%";
    $types   .= "s";
}
if (!empty($category)) {
    $where  .= " AND l.MALOAI = ?";
    $params[] = $category;
    $types   .= "s";
}
$total_products = $product->demSoSanPham($where, $types, $params);
$total_pages = ceil($total_products / $product->getLimit());
$stt = ($page - 1) * $product->getLimit() + 1;
if (isset($_GET['delete'])) {
    $MASP = intval($_GET['delete']);
    $result = $product->deleteProduct($MASP);
    echo "<script>alert('{$result['message']}'); window.location='quanlysanpham.php';</script>";
    exit;
}
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
    <link rel="stylesheet" href="../css/quanlysanpham.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
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
            <!-- ================ LÀM QUẢN LÝ SẢN PHẨM Ở ĐÂY ================= -->
            <div class="user">
                <div class="banner">


               
                    <button id="adduser"><a href="themsanpham.php">+ Thêm sản phẩm</a></button>
                    
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
                <!-- ================ Add Charts JS ================= -->
                <div class="chartsBx">
                    <h2></h2>
                   
                </div>

                

                
                <div class="details">
                    <div class="recentOrders">
                    <table>
                        <thead>
                            <tr>
                                <td>STT</td>
                                <td>Ảnh</td>
                                <td>Tên SP </td>
                                <td>Danh mục</td>
                                <td>Giá</td>
                                <td>Ngày cập nhật</td>
                                <td>Thao tác</td>
                            </tr>
                        </thead>
                        <!-- ================ bảng sửa sản phẩm  ================= -->
                        <tbody>

                        <?php
// Duyệt qua từng sản phẩm và hiển thị
 // Biến đếm số thứ tự
 $stt = ($page - 1) * $product->getLimit() + 1;

if (!empty($products)) {
    foreach ($products as $row) {
    $formatted_price = number_format($row['DONGIA'], 0, ',', '.') . " VND"; // Định dạng giá
?>          
    <tr>
        <td><?= $stt ?></td> <!-- Số thứ tự tự tăng -->
        <td><img src="<?= '../../' . htmlspecialchars($row['IMAGE']) ?>" width="80"></td> <!-- Ảnh -->
        <td><?= htmlspecialchars($row['TENSP']) ?></td> <!-- Tên sản phẩm -->
        <td><?= htmlspecialchars($row['TENLOAI']) ?></td> <!-- Danh mục (Cố định, bạn có thể sửa thành dynamic nếu cần) -->
        <td><?= $formatted_price ?></td> <!-- Giá -->

        <td><?= date("d/m/Y H:i", strtotime($row['updated_at'])) ?></td>
<td>
            <a href="suasanpham.php?id=<?= $row['MASP']?>" id="suanguoidung" style="display: block;">
                <i class="fas fa-edit"></i> Sửa
            </a>  
            <a href="#" onclick="return confirmDelete(<?= $row['MASP'] ?>)" id="" style="display: block;">
    <i class="fas fa-trash-alt"></i> Xóa</a>  

<script>
    function confirmDelete(productId) {
        if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
            window.location.href = '?delete=' + productId;
        }
        return false;
    }
</script>



        </td>
    </tr>
    
<?php
    $stt++; // Tăng STT cho dòng tiếp theo
}
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
            </div>

            </div>
        <!-- ======= Charts JS ====== -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
        <script src="../js/chartsachbanchay.js"></script>
        <!-- ====== ionicons ======= -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>