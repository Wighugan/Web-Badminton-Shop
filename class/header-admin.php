
<style>
        .success {
            color: green;
            font-weight: bold;
        }
        .pending {
            color: red;
            font-weight: bold;
        }
        .cancelled {
            color: gray;
            font-weight: bold;
        }
        .shipping {
            color: blue;
            font-weight: bold;
        }

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
        .admin-menu {
    position: relative;
}

.dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 5px;
    min-width: 150px;
    z-index: 1000;
}

.admin-menu li:hover .dropdown-menu {
    display: block;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 15px;
    color: black;
    text-decoration: none;
}

.dropdown-item:hover {
    background: #f0f0f0;
}
    </style>
<div class="container">
        <div class="navigation">
            <ul>
                <li>
                    
                        <div style="display: flex; align-items: center; position: relative;">

                        <img src="../img/logo.png" alt="a logo" width="85px" height="85px">

                        <span class="custom-font" style="margin-left: 10px; position: relative; top: 20px;">Shop</span>
</div>
                </li>

             <div class="admin-menu">
    <li>
        <a href="" style="color: black;">
            <span class="icon">
                <ion-icon name="person-outline"></ion-icon>
            </span>
            <span class="title">ADMIN                   
                <ion-icon name="chevron-down-outline" class="arrow-icon"></ion-icon>
</span>
        </a>
        <div class="dropdown-menu">
            <a href="?action=logout" style="color: black;" class="dropdown-item">
                <ion-icon name="log-out-outline"></ion-icon>
                Đăng xuất
            </a>
        </div>
    </li>
</div>

                <li>
                    <a href="trangchuadmin.php" style="color: black;" >
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Trang chủ</span>
                    </a>
                </li>

                <li>
                    <a href="quanlydonhang.php"style="color: black;" >
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
                    <a href="quanlykhachhang.php"style="color: black;">
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