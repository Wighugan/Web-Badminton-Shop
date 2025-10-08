<?php
include 'database/connect.php';
$data = new Database();
// Đọc từ khóa tìm kiếm và trang hiện tại
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$itemsPerPage = 9;  // Số sản phẩm mỗi trang

// Tính toán offset (bắt đầu của trang)
$offset = ($page - 1) * $itemsPerPage;
// Lọc tìm kiếm
$searchQuery = $search ? "WHERE name LIKE '%" . trim($search) . "%'" : "";

// Lấy tổng số sản phẩm phù hợp với tìm kiếm
$sql = "SELECT COUNT(*) AS total FROM products $searchQuery";
$data->select_prepare($sql);
$totalRows = $data->fetch()['total'];

// Tính toán số trang
$totalPages = ceil($totalRows / $itemsPerPage);

// Truy vấn sản phẩm cho trang hiện tại
$sql = "SELECT * FROM products $searchQuery LIMIT $itemsPerPage OFFSET $offset";
$data->select($sql);
// Lưu dữ liệu sản phẩm vào mảng
$products = [];
while ($row = $data->fetch()) {
    $products[] = $row;
}

// Đưa dữ liệu sản phẩm sang JavaScript
echo "<script>var products = " . json_encode($products) . ";</script>";
?>

