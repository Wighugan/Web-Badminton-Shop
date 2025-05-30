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

    <link rel="stylesheet" href="../css/themsanpham.css">
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
                    <p>CHÀO MỪNG QUẢN TRỊ CỦA MMB</p>
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
                <h1>------------------------------ Thêm sản phẩm mới ------------------------------</h1>
                <form action="addproduct.php" method="POST" enctype="multipart/form-data" id="suaUserForm">

                    <div class="form-group">
                        <label for="goi">Danh mục:</label>
                        <select id="goi" name="goi">
                            <option>Không có</option>
                            <option>Vợt Cầu Lông</option>
                            <option>Giày Cầu Lông</option>
                            <option>Túi Cầu Lông</option>
                            <option>Quần Cầu Lông</option>
                            <option>Áo Cầu Lông</option>
                            <option>Váy Cầu Lông</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image1">Ảnh 1:</label>
                        <input type="file" id="image1" accept="image/*">

                    </div>

                  
                  
                    
                  
                    <div class="form-group">
                        <label for="color">Màu sắc:</label>
                        <select id="color" name="color">
                            <option>Không có</option>
                            <option>Xanh đen</option>
                            <option>Đỏ đen</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name">Mã sản phẩm:</label>
                        <input type="text" id="name" placeholder="KNS49">
                    </div>

                    <div class="form-group">
                        <label for="name">Tên sản phẩm:</label>
                        <input type="text" id="name" placeholder="Vợt Yonex 100zz Kurenai">
                    </div>


                    <div class="form-group">
                        <label for="email">Giá:</label>
                        <input type="text" id="email" placeholder="4.350.000 VND">
                    </div>
                   

                    <div class="form-group">
                        <label for="email">Xuất xứ:</label>
                        <input type="text" id="email" placeholder="Nhật Bản">
                    </div>


                    <div class="form-group">
                        <label for="email">Thương Hiệu:</label>
                        <input type="text" id="email" placeholder="Yonex">
                    </div>


                    
                    <div class="form-group">
                        <label for="description">Mô tả:</label>
                        <textarea style="height: 100px;"
                            id="description" placeholder="Vợt cầu lông Yonex Astrox 100ZZ kurenai đỏ tấn công cực kỳ mạnh mẽ, vung vợt nhanh, mượt và ít biến dạng thân vợt. Vợt nặng đầu, thân cứng cho ra các cú smash, tạt cầu uy lực, cầu bay nhanh, mạnh, cắm sân. Công nghệ vợt chống rung chống xoắn, giúp người chơi có những pha cầu chắc chắn, ổn định và chính xác nhất."></textarea>
                    </div>
                


                    <div class="form-group">
                        <input type="submit" value="Lưu vào Database" onclick="myFunction()">
                        <button class="return"><a href="quanlysanpham.html">Quay lại</a></button>
                    </div>
                </form>
                <script>
                    function myFunction() {
                        alert("Đã lưu thành công thông tin sản phẩm mới vào Database!");
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