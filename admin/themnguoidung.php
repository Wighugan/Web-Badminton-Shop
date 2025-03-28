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

    <link rel="stylesheet" href="../css/themnguoidung.css">
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
                    <a href="quanlysanpham.php" style="color: black;">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý sản phẩm</span>
                    </a>
                </li>

                <li>
                    <a href="quanlykhachhang.php"style="color: black;" id="active">
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
            <div class="details">
            <div class="recentOrders">
            <div class="addproduct">
                <h1>------------------------ Thêm Thông Tin Khách Hàng ----------------</h1>
                
                <form action="insert.php" method="POST" enctype="multipart/form-data" id="suaUserForm">
                   
                   
                    <div class="form-group">
                        <label for="name">Tên đăng nhập:</label>
                        <input type="text" id="username" name="username" >
                    </div>


                    

                    <div class="form-group">
    <label for="name">Ảnh đại diện:</label>
   
    
    <div>
        <span class="input-group-text">
            <i class="fa fa-user"></i>
        </span>
        <input type="file" class="form-control" name="avatar" id="avatar" accept="image/*" onchange="previewImage(event)">

    </div>      
    
    <img id="preview" src="https://www.w3schools.com/w3images/avatar2.png" class="preview" height="80" padding="20">

</div>
<script>
function previewImage(event) {
    var preview = document.getElementById('preview'); // Lấy thẻ <img>
    var file = event.target.files[0]; // Lấy file ảnh

    if (file) {
        var reader = new FileReader(); // Đọc file ảnh
        reader.onload = function(e) {
            preview.src = e.target.result; // Gán đường dẫn ảnh
            preview.style.display = "block"; // Hiển thị ảnh
        };
        reader.readAsDataURL(file); // Đọc file dưới dạng URL
    }
}

</script>




                    <div class="form-group">
                        <label for="name">Họ và tên:</label>
                        <input type="text" id="fullname" name="fullname">
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email">
                    </div>

                    <div class="form-group">
                        <label for="email">Số điện thoại:</label>
                        <input type="text" id="numberphone" name="numberphone">
                    </div>

                    <div class="form-group">
                        <label for="email">Địa chỉ:</label>
                        <input type="text" id="address" name="address">
                    </div>
                    <div class="form-group">
                        <label for="email">Ngày Sinh:</label>
                        <input type="text" id="birthday" name="birthday" onfocus="(this.type='date')" onblur="(this.type= this.value ? 'date' : 'text')" >
                    </div>
                   

                    <div class="form-group">
                        <input type="submit" value="Lưu vào Database" onclick="myFunction()">
                        <button class="return"><a href="quanlykhachhang.html">Quay lại</a></button>
                    </div>
                </form>
                <script>
                    function myFunction() {
                        alert("Đã lưu thành công thông tin khách hàng mới vào Database!");
                    }
                </script>

            </div>
        </div>
    </div>

                </div>
                </div>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>