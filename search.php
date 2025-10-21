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
            while ($row = $data->fetch()) {
                echo '<div style="margin-bottom: 16px;">';
                echo '<img src="img/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '" style="width:100px;height:100px;object-fit:cover;margin-right:10px;">';
                echo '<span>' . htmlspecialchars($row['name']) . '</span>';
                echo '</div>';
            }
            $data->close();
        ?>
        <a href="index.php">Quay lại tìm kiếm</a>
    </body>
    </html>
<?php
}
?>