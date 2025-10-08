<?php
include 'database/connect.php';
$data = new Database();

if (isset($_GET['query'])) {
    $search = trim($_GET['query']);
    $sql = "SELECT * FROM products WHERE name LIKE ?";
    $params = "%" . $search . "%";
    $data->select_prepare($sql, "s", $params );
    ?>
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>Kết quả tìm kiếm</title>
    </head>
    <body>
        <h1>Kết quả cho "<?php echo htmlspecialchars($search); ?>"</h1>
        <?php
        if ($data->execute()) {
            while ($row = $data->fetch()) {
                echo "<p>" . htmlspecialchars($row['name']) . "</p>";
            }
        } else {
            echo "<p>Không tìm thấy sản phẩm nào.</p>";
        }
        ?>
        <a href="index.php">Quay lại tìm kiếm</a>
    </body>
    </html>
<?php
}
?>