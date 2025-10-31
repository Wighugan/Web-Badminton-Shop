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
  <!-- Nhà cung cấp -->
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
    <label for="category">Loại sản phẩm:</label>
    <select id="category" name="category" required onchange="loadProducts(this.value)">
      <option value="">-- Chọn loại sản phẩm --</option>
      <option value="YX">Yonex</option>
      <option value="MO">Mizuno</option>
      <option value="LG">Lining</option>
      <option value="VR">Victor</option>
    </select>
  </div>

  <!-- Sản phẩm -->
  <div class="form-group">
    <label for="MaSP">Tên sản phẩm:</label>
    <select id="MaSP" name="MaSP" required onchange="setPrice(this)">
      <option value="">-- Chọn sản phẩm --</option>
    </select>
  </div>

  <!-- Số lượng -->
  <div class="form-group">
    <label for="SoLuong">Số lượng nhập:</label>
    <input type="text" id="SoLuong" name="SoLuong" min="1" required>
  </div>

  <!-- Giá nhập -->
  <div class="form-group">
    <label for="GiaNhap">Giá nhập (VNĐ):</label>
    <input type="text" id="GiaNhap" name="GiaNhap" readonly>
  </div>

  <!-- Thành tiền -->
  <div class="form-group">
    <label for="ThanhTien">Thành tiền (VNĐ):</label>
    <input type="text" id="ThanhTien" name="ThanhTien" readonly>
  </div>

  <!-- Tổng tiền phiếu nhập -->
  <div class="form-group">
    <label for="TongTien">Tổng tiền phiếu nhập (VNĐ):</label>
    <input type="text" id="TongTien" name="TongTien" readonly>
  </div>

  <!-- Nút hành động -->
  <div class="form-group">
    <input type="submit" value="Xác nhận" onclick="return confirmSubmit()">
    <button type="button" class="return">
      <a href="quanlykho.php">Quay lại</a>
    </button>
  </div>
</form>

<script>
function loadProducts(category) {
  if (!category) return;

  const xhr = new XMLHttpRequest();
  xhr.open("GET", "get_products.php?category=" + encodeURIComponent(category), true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      const data = JSON.parse(xhr.responseText);
      const productSelect = document.getElementById("MaSP");
      productSelect.innerHTML = '<option value="">-- Chọn sản phẩm --</option>';

      data.forEach(item => {
        const option = document.createElement("option");
        option.value = item.MASP; // mã sản phẩm
        option.textContent = item.TENSP; // tên sản phẩm
        option.dataset.price = item.GIANHAP; // giá nhập
        productSelect.appendChild(option);
      });
    } else {
      alert("❌ Lỗi tải danh sách sản phẩm!");
    }
  };
  xhr.send();
}

function setPrice(select) {
  const selected = select.options[select.selectedIndex];
  document.getElementById("GiaNhap").value = selected.dataset.price || '';
  tinhThanhTien();
}

function tinhThanhTien() {
  const soLuong = parseFloat(document.getElementById("SoLuong").value) || 0;
  const giaNhap = parseFloat(document.getElementById("GiaNhap").value.replace(/,/g, '')) || 0;
  const thanhTien = soLuong * giaNhap;
  document.getElementById("ThanhTien").value = thanhTien.toLocaleString('vi-VN');
  document.getElementById("TongTien").value = thanhTien.toLocaleString('vi-VN');
}

document.getElementById("SoLuong").addEventListener("input", tinhThanhTien);

function confirmSubmit() {
  const maSP = document.getElementById("MaSP").value;
  const soLuong = document.getElementById("SoLuong").value;
  if (!maSP || !soLuong) {
    alert("⚠️ Vui lòng chọn sản phẩm và nhập số lượng!");
    return false;
  }
  return confirm("Xác nhận nhập hàng?");
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