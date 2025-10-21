<!DOCTYPE html>
<html lang="en">
<?php
// Thông tin kết nối database
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php'; $data = new database();
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
                
            </div>


            <!-- ================ LÀM QUẢN LÝ SẢN PHẨM Ở ĐÂY ================= -->
            <div class="details">
            <div class="recentOrders">
            <div class="addproduct">
                <h1>------------------------------ Thêm sản phẩm mới ------------------------------</h1>
                <form action="insertproduct.php" method="POST" enctype="multipart/form-data" id="suaUserForm">

                <div class="form-group">
            <label for="category">Loại:</label>
            <select id="category" name="category" required>
                <option value="Không có">Không có</option>
                <option value="Yonex">Yonex</option>
                <option value="Mizuno">Mizuno</option>
                <option value="Lining">Lining</option>
                <option value="Victor">Victor</option>
            </select>
        </div>

        <div class="form-group">
        <label for="image">Ảnh sản phẩm:</label>
            <input type="file" id="image" name="image" accept="image/*" required onchange="previewImage(event)">
            <br>
            <img id="preview" src="https://bizweb.dktcdn.net/100/485/982/collections/248f25eb211faf87af29dfe6be4b3b0b.jpg?v=1695029604207" alt="Xem trước ảnh" width="150" height="150" style="display: block; margin-top: 10px;">
        </div>

        

        <div class="form-group">
            <label for="productcode">Mã sản phẩm:</label>
            <input type="text" id="productcode" name="productcode" required>
        </div>

        <div class="form-group">
            <label for="name">Tên sản phẩm:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="text" id="price" name="price" required>
        </div>

        <div class="form-group">
            <label for="flex">Độ cứng:</label>
            <input type="text" id="flex" name="flex" required>
        </div>

        <div class="form-group">
            <label for="length">Chiều dài vợt:</label>
            <input type="text" id="length" name="length" required>
        </div>

        <div class="form-group">
            <label for="weight">Trọng lượng:</label>
            <input type="text" id="weight" name="weight" required>
        </div>

        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" required></textarea>
        </div>

        <div class="form-group">
                        <input type="submit" value="Lưu vào Database" onclick="myFunction()">
                        <button class="return"><a href="quanlysanpham.php">Quay lại</a></button>
                    </div>
    </form>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(event.target.files[0]);
            preview.style.display = 'block';
        }
    </script>


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