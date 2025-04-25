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
    <link rel="stylesheet" href="../css/quanlykhachhang.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    

   
      
   
    

</head>

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
                    <a href="quanlysanpham.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý sản phẩm</span>
                    </a>
                </li>

                <li>
                    <a href="quanlykhachhang.php" style="color: black;" id="active">
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

            <!-- ================ LÀM QUẢN LÝ KHÁCH HÀNG Ở ĐÂY ================= -->
            <div class="user"  >         
                      <div class="banner">
                    <button id="adduser"><a href="themnguoidung.php">+ Thêm người dùng</a></button>
                    
                   

                   


                    <form action="">
                    <input id="timnguoidung" type="text" placeholder="Tên người dùng ...">   
                    <a href ="" id="timnguoidung1" >
                        <i class="fa fa-search"></i> 
                    </a>  
                </form>

                
                </div>
                <div class="chartsBx">
                    <h2></h2>
                </div>
                <?php
				// Câu lệnh SQL để lấy dữ liệu từ bảng user
				$sql = "SELECT * FROM users";
				$result = mysqli_query($conn, $sql);

				// Kiểm tra xem có dữ liệu hay không
			?>

                <div class="details">
                    <div class="recentOrders">
                        <div class="cardHeader">
                            <h2>THỐNG KÊ LƯỢNG ĐĂNG KÝ NĂM 2024</h2>
                        </div>
                    <table>
                        <thead>
                            <tr>
                                <td>STT</td>
                                <td>Ảnh đại diện </td>
                                <td>Tên đăng nhập </td>
                                <td>Họ và tên</td>
                                <td>Email</td>
                                <td>Số điện thoại</td>
                                <td>Địa chỉ</td>
                                <td>Ngày Sinh</td>
                                <td>Ghi chú</td>
                            </tr>
                        </thead>

                        <tbody>
                           
            
                        <?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>  <img src='../{$row['avatar']}' width='50' height='50' style='border-radius: 0%;'>    </td>
                <td>{$row['username']}</td>
                <td>{$row['fullname']}</td>
                <td>{$row['email']}</td>
                <td>{$row['numberphone']}</td>
                <td>{$row['address']}</td>
                <td>" . date("d/m/Y", strtotime($row['birthday'])) . "</td>
                <td>
                    <a href='suakhachhang.php?id={$row['id']}' id='suanguoidung'_{$row['id']}'>
                        <i class='fas fa-edit'></i> Sửa
                    </a>
                    <a href='#' onclick='deleteuser({$row['id']})' style='color: red;'>
                        <i class='fa-solid fa-trash'></i> Xóa
                    </a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='8'>Không có người dùng nào!</td></tr>";
}
$conn->close();
?>
        <script>
        function lockUser(userId) {
            const confirmation = confirm("Bạn có chắc chắn muốn khóa người dùng này?");
            if (confirmation) {
                alert("Khóa người dùng thành công!");
                window.location.href = 'quanlykhachhang.php?id=' + userId;
            }
        }

        function deleteuser(userId) {
        const confirmation = confirm("Bạn có chắc chắn muốn xóa người dùng này?");
        if (confirmation) {
            window.location.href = 'deleteuser.php?id=' + userId;

        }
    }
    </script>
                        </tbody>
                    </table>
                    <div class="pagination1">
                        <li class="hientai1">1</li>
                        <li><a href="quanlykhachhang.html" style="color: black;">2</a></li></a>
                        <li><a href="quanlykhachhang.html" style="color: black;">NEXT</a></li>
                    </div>
               
            <!-- ================ Add Charts JS ================= -->
            </div>
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