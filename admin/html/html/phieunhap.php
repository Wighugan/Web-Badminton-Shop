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
                    <a href="quanlykhachhang.php"style="color: black;" >
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý khách hàng</span>
                    </a>
                </li>
                <li>
                    <a href="quanlynhanvien.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý nhân viên</span>
                    </a>
                </li>
</li>

<li>
                    <a href="quanlyncc.php"style="color: black;">
                        <span class="icon">
                            <ion-icon name="business-outline"></ion-icon>
                        </span>
                        <span class="title">Quản lý nhà cung cấp</span>
                    </a>
                </li>

                </li>

<li>
                    <a href="quanlykho.php"style="color: black;" id="active">
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
      <h1>------------------------------------- Phiếu nhập hàng ----------------------------------</h1>

      <form action="nhaphang.php" method="POST" enctype="multipart/form-data" id="nhapHangForm">

        <!-- Tên nhà cung cấp -->
        <div class="form-group">
          <label for="TenNCC">Tên nhà cung cấp:</label>
          <select id="TenNCC" name="TenNCC" required>
            <option value="">-- Chọn nhà cung cấp --</option>
            <option value="Yonex Việt Nam">Yonex Việt Nam</option>
            <option value="Lining Sport">Lining Sport</option>
            <option value="Victor Corporation">Victor Corporation</option>
            <option value="Mizuno">Mizuno</option>
          </select>
        </div>

        <!-- Loại sản phẩm -->
        <div class="form-group">
          <label for="category">Loại:</label>
          <select id="category" name="category" required onchange="loadProducts(this.value)">
            <option value="">-- Chọn loại sản phẩm --</option>
            <option value="Yonex">Yonex</option>
            <option value="Mizuno">Mizuno</option>
            <option value="Lining">Lining</option>
            <option value="Victor">Victor</option>
          </select>
        </div>

        <!-- Tên sản phẩm -->
        <div class="form-group">
          <label for="name">Tên sản phẩm:</label>
          <select id="name" name="name" required onchange="setPrice(this)">
            <option value="">-- Chọn sản phẩm --</option>
          </select>
        </div>

        <!-- Số lượng nhập -->
        <div class="form-group">
          <label for="stock">Số lượng nhập:</label>
          <input type="text" id="stock" name="stock" min="1" required>
        </div>

        <!-- Đơn giá -->
        <div class="form-group">
          <label for="cost_price">Đơn giá (VNĐ):</label>
          <input type="text" id="cost_price" name="cost_price" readonly>
        </div>

        <!-- Tổng tiền -->
        <div class="form-group">
          <label for="TongTien">Tổng tiền (VNĐ):</label>
          <input type="text" id="TongTien" name="TongTien" readonly>
        </div>

        <!-- Nút xác nhận -->
        <div class="form-group">
                        <input type="submit" value="Xác nhận" onclick="myFunction()">
                        <button class="return"><a href="quanlykho.php">Quay lại</a></button>
                    </div>
                </form>
                <script>
                    function myFunction() {
                        alert("Đã lưu thành công thông tin  mới vào Database!");
                    }
                </script>

      </form>
    </div>
  </div>
</div>

<script>
function loadProducts(brand) {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "get_products.php?category=" + encodeURIComponent(brand), true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      const data = JSON.parse(xhr.responseText);
      const productSelect = document.getElementById("name");
      productSelect.innerHTML = '<option value="">-- Chọn sản phẩm --</option>';

      data.forEach(item => {
        const option = document.createElement("option");
        option.value = item.name; // 👈 gửi tên sản phẩm sang PHP
        option.textContent = item.name;
        option.dataset.price = item.cost_price;
        productSelect.appendChild(option);
      });
    }
  };
  xhr.send();
}

function setPrice(select) {
  const selectedOption = select.options[select.selectedIndex];
  document.getElementById("cost_price").value = selectedOption.dataset.price || '';
  tinhTong();
}

function tinhTong() {
  const soLuong = parseFloat(document.getElementById("stock").value) || 0;
  const donGia = parseFloat(document.getElementById("cost_price").value.replace(/,/g, '')) || 0;
  const tongTien = soLuong * donGia;
  document.getElementById("TongTien").value = tongTien.toLocaleString('vi-VN');
}

document.getElementById("stock").addEventListener("input", tinhTong);
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