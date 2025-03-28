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
$id = $_GET['id'] ?? '';
if (!$id) {
    die("Không tìm thấy sản phẩm!");
}

// Lấy thông tin sản phẩm từ database
$sql = "SELECT * FROM product WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
if (!$product) {
    die("Sản phẩm không tồn tại!");
}
$stmt->close();
$conn->close();
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
                    <a href="quanlysanpham.php" style="color: black;"id="active">
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
                    <p>CHÀO MỪNG ADMIN CỦA MMB !!!</p>
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
                <h1>------------------------------ Sửa Thông Tin Sản Phẩm ----------------------------</h1>
                <form action="updateproduct.php" method="POST" enctype="multipart/form-data" id="suaUserForm">
                    <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

                        <label for="goi">Loại:</label>
                        <select id="goi" name="category" required>

                        <?php
    $categories = ["Không có", "Yonex", "Mizuno", "Lining", "Victor"];
    foreach ($categories as $cat) {
        $selected = (trim($product['category']) == trim($cat)) ? "selected" : "";
        echo "<option value='$cat' $selected>$cat</option>";
    }
    ?>


                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="weight">Thay ảnh:</label>
                    </div>

                    <div class="form-group">

                        <label for="image1">Ảnh 1:</label>
<div>
                        <input class="form-group" type="file" id="image" name="image" accept="image/*"  onchange="previewImage(event)">
</div>
                        <img src="<?= $product['image'] ?>" width="50" id="preview"  height="80" padding="20">

                    </div>
                 
                   
                    <div class="form-group">
                        <label for="color">Màu sắc:</label>
                        <select id="color" name="color" required>
                        <?php
    $color = ["Không có", "Đỏ đen", "Xanh đen", "Trắng"];
    foreach ($color as $cat) {
        $selected = (trim($product['color']) == trim($cat)) ? "selected" : "";
        echo "<option value='$cat' $selected>$cat</option>";
    }
    ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name">Mã sản phẩm:</label>
        <input type="text" name="productcode" value="<?php echo $product['productcode']; ?>"required>
                    </div>
                    <div class="form-group">
                        <label for="name">Tên sản phẩm:</label>
                        <input type="text" name="name" value="<?php echo $product['name']; ?>"required>
                        </div>

                    <div class="form-group">
                        <label for="email">Giá:</label>
                        <input type="text" name="price" value="<?php echo $product['price']; ?>"required>
                        </div>
                   
                    <div class="form-group">
                        <label for="email">Độ Cứng:</label>
                        <input type="text" name="flex" value="<?php echo $product['flex']; ?>"required>
                        </div>

                    <div class="form-group">
                        <label for="email">Chiều dài vợt:</label>
                        <input type="text" name="length" value="<?php echo $product['length']; ?>"required>
                        </div>

                    <div class="form-group">
                        <label for="email">Trọng lượng:</label>
                        <input type="text" name="weight" value="<?php echo $product['weight']; ?>"required>
                        </div>


                    <div class="form-group">
                        <label for="email">Thương Hiệu:</label>
                        <input type="text" id="email" placeholder="Yonex">
                    </div>


                    <div class="form-group">
                        <label for="description">Mô tả:</label>
                        <textarea name="description"><?php echo $product['description']; ?></textarea required>

                    </div>
                    
                    <div class="form-group">
                        <input type="submit" value="Lưu vào Database" onclick="myFunction()">
                        <button class="return"><a href="quanlysanpham.php">Quay lại</a></button>
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