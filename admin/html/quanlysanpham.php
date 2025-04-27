<!DOCTYPE html>
<html lang="en">
<?php
// Thông tin kết nối database
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
// Xử lý phân trang
$limit = 3; // Số sản phẩm mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1; // Đảm bảo page bắt đầu từ 1
$offset = ($page - 1) * $limit; // Tính toán offset dựa trên page

// Truy vấn tổng số sản phẩm
$sql_total = "SELECT COUNT(*) as total FROM product";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_products = $row_total['total']; // Tổng số sản phẩm
$total_pages = ceil($total_products / $limit); // Số trang

// Truy vấn sản phẩm phân trang
$sql = "SELECT * FROM product ORDER BY updated_at DESC LIMIT $offset, $limit";
$result = $conn->query($sql);
?>
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
                    <a href="quanlysanpham.php"style="color: black;" id="active">
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
            <!-- ================ LÀM QUẢN LÝ SẢN PHẨM Ở ĐÂY ================= -->
            <div class="user">
                <div class="banner">


               
                    <button id="adduser"><a href="themsanpham.php">+ Thêm sản phẩm</a></button>
                    
                    <div class="date1">
    <label for="start">Từ ngày: </label>
    <input type="date" id="start" name="start" value="2024-11-24" min="2018-01-01" max="2024-12-31">
    
    <label for="end">đến</label>
    <input type="date" id="end" name="end" value="2024-11-30" min="2018-01-01" max="2024-12-31">

    <a href="" id="timnguoidung2" class="search-btn">
        <i class="fa fa-search"></i> 
    </a>
</div>

                    <select id="option">
                        <option>Lọc theo danh mục</option>
                        <option>Lọc theo thương hiệu</option>
                        
                    </select>
                   

                
                    <form action="">
                        <input id="timnguoidung" type="text" placeholder="Tên sản phẩm cần tìm">
    
                        
                           
                      
                           
                        <a href ="" id="timnguoidung1" >
    
                            <i class="fa fa-search"></i> 
    
                        </a>  
                    </form>
                </div>
                <!-- ================ Add Charts JS ================= -->
                <div class="chartsBx">
                    <h2></h2>
                   
                </div>

                <?php
				// Câu lệnh SQL để lấy dữ liệu từ bảng user
				$sql = "SELECT * FROM product";
				$result = mysqli_query($conn, $sql);

				// Kiểm tra xem có dữ liệu hay không
				if (mysqli_num_rows($result) > 0) 
			?>

                
<div class="details">
    <div class="recentOrders">
        <table>
            <thead>
                <tr>
                    <td>STT</td>
                    <td>Mã Sản Phẩm</td>
                    <td>Ảnh</td>
                    <td>Tên SP</td>
                    <td>Danh mục</td>
                    <td>Giá</td>
                    <td>Tồn kho</td>
                    <td>Ngày cập nhật</td>
                    <td>Thao tác</td>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    $stt = $offset + 1; // STT tính theo trang
                    while ($row = mysqli_fetch_assoc($result)) {
                        $formatted_price = number_format($row['price'], 0, ',', '.') . " VND";
                ?>
                        <tr>
                            <td><?= $stt++ ?></td>
                            <td><?= htmlspecialchars($row['productcode']) ?></td>
                            <td><img src="<?= '../../' . htmlspecialchars($row['image']) ?>" width="80"></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td><?= $formatted_price ?></td>
                            <td><?= htmlspecialchars($row['stock']) ?></td>
                            <td><?= date("d/m/Y H:i", strtotime($row['updated_at'])) ?></td>
                            <td>
                                <a href="suasanpham.php?id=<?= $row['id'] ?>" id="suanguoidung" style="display: block;">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="#" onclick="return confirmDelete(<?= $row['id'] ?>)" id="xoanguoidung" style="display: block;">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="9">Không có sản phẩm nào.</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <style>
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 30px 0;
            font-family: Arial, sans-serif;
            font-size: 13px;
        }

        .pagination a, .pagination .current {
            margin: 0 5px;
            padding: 5px 10px;
            text-decoration: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            color: #333;
            background-color: #f9f9f9;
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination a:hover {
            background-color: rgb(103, 104, 106);
            color: white;
            border-color: rgb(117, 119, 121);
        }

        .pagination .current {
            font-weight: bold;
            background-color: rgb(0, 0, 0);
            color: white;
            border-color: rgb(0, 0, 0);
            cursor: default;
        }
        </style>

        <!-- Phân trang -->
        <div class="pagination">
            <?php
            if ($page > 1) {
                echo "<a href='quanlysanpham.php?page=" . ($page - 1) . "'>Trước</a>";
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo "<span class='current'>$i</span>";
                } else {
                    echo "<a href='quanlysanpham.php?page=$i'>$i</a>";
                }
            }

            if ($page < $total_pages) {
                echo "<a href='quanlysanpham.php?page=" . ($page + 1) . "'>Sau</a>";
            }
            ?>
        </div>
    </div>
</div>

<?php $conn->close(); ?>

<!-- Confirm Delete script (để 1 lần duy nhất) -->
<script>
function confirmDelete(productId) {
    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
        window.location.href = 'deleteproduct.php?id=' + productId;
    }
}
</script>
        <!-- ======= Charts JS ====== -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
        <script src="../js/chartsachbanchay.js"></script>
        <!-- ====== ionicons ======= -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>