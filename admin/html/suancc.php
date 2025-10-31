
<?php
// Kết nối MySQL
include $_SERVER['DOCUMENT_ROOT'] . '/Web-Badminton-Shop/database/connect.php'; $data = new database();
// Kiểm tra nếu có ID hợp lệ
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM ncc WHERE MANCC = ?";
    $data->select_prepare($sql,'i',$id);
    $nhacungcap = $data->fetch();
    if (!$nhacungcap) {
        die("Không tìm thấy người dùng!");
    }
} else {
    die("ID không hợp lệ!");
}
$data->close();
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

    <link rel="stylesheet" href="../css/themnguoidung.css">

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
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
                    <a href="quanlykhachhang.php"style="color: black;" >
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý khách hàng</span>
                    </a>
                </li>
                <li>
                    <a href="quanlynhacungcap.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý nhân viên</span>
                    </a>
                </li>
</li>

<li>
                    <a href="quanlyncc.php"style="color: black;"id="active">
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
                
            </div>


            <!-- ================ LÀM QUẢN LÝ SẢN PHẨM Ở ĐÂY ================= -->
            <div class="details">
            <div class="recentOrders">
            <div class="addproduct">
                <h1>------------------------------ Sửa Thông Tin nhân viên ---------------------------</h1>
                <form action="updateuser.php?type=ncc"method="POST" enctype="multipart/form-data">                   
                <input type="hidden" name="MANCC" value="<?= $nhacungcap['MANCC'] ?>">




                   
                        
                <div class="form-group">
                    
                    <label for="name">Logo:</label>
                    <div>
                    <input class="form-group" type="file" id="avatar" name="AVATAR" accept="image/*"  onchange="previewImage(event)">
</div>
                    <img src="<?= '../../' .$nhacungcap['AVATAR'] ?>" width="30" id="preview"  height="50" padding="20">
                    
                 </div>
                  <div class="form-group">
                        <label for="name">Tên nhà cung cấp:</label>
                        <input type="text" name="TENNCC" value="<?= $nhacungcap['TENNCC'] ?>" required>
                        </div>


                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="EMAIL" value="<?= $nhacungcap['EMAIL'] ?>" required>
                        
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Số điện thoại:</label>
                        <input type="text" id="numberphone" name="SDT" value="<?= $nhacungcap['SDT'] ?>" required>
                        
                    </div>

                  
                    <div class="form-group">
                        <label for="email">Địa chỉ:</label>
                        <input type="TEXT" id="birthday" name="DIACHI" value="<?= $nhacungcap['DIACHI'] ?>" required>
                        </div>
                    

                    <div class="form-group">
                        <label for="email">Người đại diện:</label>
                        <input type="text" id="NguoiDaiDien" name="NGUOIDD" value="<?= $nhacungcap['NGUOIDD'] ?>" required>
                        </div>

                    <div class="form-group">
                        <input type="submit" value="Lưu vào Database" onclick="myFunction()">
                        <button class="return"><a href="quanlynhacungcap.php">Quay lại</a></button>
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