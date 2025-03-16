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
                    <a href="trangchuadmin.html"style="color: black;">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Trang chủ</span>
                    </a>
                </li>

                <li>
                    <a href="quanlydonhang.html"style="color: black;">
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
                    <a href="thongke.html"style="color: black;">
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
				if (mysqli_num_rows($result) > 0) {
			?>

                
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
                                <td>Tồn kho</td>
                                <td>Ngày cập nhật</td>
                                <td>Thao tác</td>
                            </tr>
                        </thead>
                        <!-- ================ bảng sửa sản phẩm  ================= -->
                        <tbody>

                        <?php
// Duyệt qua từng sản phẩm và hiển thị
$stt = 1; // Biến đếm số thứ tự
while ($row = mysqli_fetch_assoc($result)) {  
    $formatted_price = number_format($row['price'], 0, ',', '.') . " VND"; // Định dạng giá
?>          
    <tr>
        <td><?= $stt++ ?></td> <!-- Số thứ tự -->
        <td><img src="<?= htmlspecialchars($row['image']) ?>" width="80"></td> <!-- Ảnh -->
        <td><?= htmlspecialchars($row['name']) ?></td> <!-- Tên sản phẩm -->
        <td><?= htmlspecialchars($row['category']) ?></td> <!-- Danh mục (Cố định, bạn có thể sửa thành dynamic nếu cần) -->
        <td><?= $formatted_price ?></td> <!-- Giá -->
        <td><?= htmlspecialchars($row['stock']) ?></td> <!-- Số lượng tồn kho -->
        <td><?= date("d/m/Y H:i", strtotime($row['updated_at'])) ?></td>
<td>
            <a href="suasanpham.html?id=<?= $row['id']?>" id="suanguoidung" style="display: block;">
                <i class="fas fa-edit"></i> Sửa
            </a>  
            <a href="quanlysanpham.php?id=<?= $row['id']?>" onclick="return confirmDelete()" id="xoanguoidung" style="display: block;">
                <i class="fas fa-trash-alt"></i> Xóa
            </a>  
            <script>
    function confirmDelete() {
        return confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?");
    }
</script>
        </td>
    </tr>
<?php
}
?>

<?php				
} else {
    echo "<p>Không có sản phẩm nào.</p>";
}
?>
   </table>                         
                   
                
                <div class="pagination">
                    <li class="hientai">1</li>
                    <li><a href="quanlysanpham.php" style="color: black;">2</a></li></a>
                    <li><a href="quanlysanpham.php" style="color: black;">NEXT</a></li>
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