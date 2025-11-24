<?php 
require_once __DIR__ . '/systemManage.php';
class SanPham extends QuanLyHeThong {
    private $id;
    private $name;
    private $category;
    private $price;
    private $stock;
    private $image;
    private $code;
    private $update;
    private $weight;
    private $length;
    private $flex;
    protected $data;
    private $limit = 3;
    public function __construct() {
        $this->data = new Database();
    }
    public function lietketspnb() {
        $sql = "SELECT MASP, TENSP, IMAGE, DONGIA 
                FROM san_pham 
                ORDER BY MASP DESC 
                LIMIT 8";
        $this->data->select_prepare($sql);
        return $this->data->fetchAll(); // ✅ lấy toàn bộ kết quả
    }
    public function lietketspmoi() {
        $data = new Database();
        $sql = "SELECT MASP, TENSP, IMAGE, DONGIA 
                FROM san_pham 
                ORDER BY updated_at DESC 
                LIMIT 8";
        $this->data->select_prepare($sql);
        return $this->data->fetchAll(); // ✅ lấy toàn bộ kết quả
    }
    public function XemCTSP ($id){
        $sql = "SELECT sp.*, ls.TENLOAI 
        FROM san_pham sp
        LEFT JOIN loai_sp ls ON sp.MALOAI = ls.MALOAI
        WHERE sp.MASP = ?";
        $this->data->select_prepare($sql, "i", $id);
        return $this->data->fetch();
    }
    public function getProductsByPage($page, $search, $category) {
    $limit = $this->getLimit();
    $offset = ($page - 1) * $limit;

    // tạo câu điều kiện
    $where = "WHERE 1=1";
    $params = [];
    $types = "";

    if (!empty($search)) {
        $where .= " AND sp.TENSP LIKE ?";
        $params[] = "%$search%";
        $types .= "s";
    }

    if (!empty($category)) {
        $where .= " AND l.MALOAI = ?";
        $params[] = $category;
        $types .= "s";
    }

    $sql = "SELECT sp.*, l.TENLOAI
            FROM san_pham sp 
            JOIN loai_sp l ON sp.MALOAI = l.MALOAI
            $where
            ORDER BY sp.MASP DESC
            LIMIT ? OFFSET ?";

    $params[] = $limit;
    $params[] = $offset;
    $types .= "ii";

    $this->data->select_prepare($sql, $types, ...$params);
    return $this->data->fetchAll();
}
     public function timkiemsp($search = '', $price = '', $brands = [], $sort = '') {
        $where = "WHERE 1=1";
        $params = [];
        $types = "";
        $order = " ORDER BY sp.MASP DESC"; // mặc định: mới nhất

        // 🔍 Tìm kiếm theo tên
        if (!empty($search)) {
            $where .= " AND sp.TENSP LIKE ?";
            $params[] = "%$search%";
            $types .= "s";
        }

        // 💰 Lọc theo giá
        switch ($price) {
            case '0500':
                $where .= " AND sp.DONGIA < ?";
                $params[] = 500000;
                $types .= "i";
                break;
            case '5001':
                $where .= " AND sp.DONGIA BETWEEN ? AND ?";
                $params[] = 500000;
                $params[] = 1000000;
                $types .= "ii";
                break;
            case '12':
                $where .= " AND sp.DONGIA BETWEEN ? AND ?";
                $params[] = 1000000;
                $params[] = 2000000;
                $types .= "ii";
                break;
            case '23':
                $where .= " AND sp.DONGIA BETWEEN ? AND ?";
                $params[] = 2000000;
                $params[] = 3000000;
                $types .= "ii";
                break;
            case 'over3':
                $where .= " AND sp.DONGIA > ?";
                $params[] = 3000000;
                $types .= "i";
                break;
        }

        // 🏷️ Lọc theo thương hiệu
        if (!empty($brands)) {
            $placeholder = implode(',', array_fill(0, count($brands), '?'));
            $where .= " AND l.TENLOAI IN ($placeholder)";
            foreach ($brands as $brand) {
                $params[] = $brand;
                $types .= "s";
            }
        }

        // 🔽 Sắp xếp theo giá
        if ($sort === 'price-asc') {
            $order = " ORDER BY sp.DONGIA ASC";
        } elseif ($sort === 'price-desc') {
            $order = " ORDER BY sp.DONGIA DESC";
        }

        // 🔁 Trả về 4 phần: điều kiện, tham số, kiểu dữ liệu, và sắp xếp
        return [$where, $params, $types, $order];
    }
    // 👇 Hàm lấy sản phẩm có phân trang
    public function getProducts($where, $params, $types, $limit, $offset) {
        $data = new Database();
        $sql = "SELECT sp.*, l.TENLOAI
                FROM san_pham sp 
                JOIN loai_sp l ON sp.MALOAI = l.MALOAI
                $where 
                ORDER BY sp.MASP DESC 
                LIMIT ? OFFSET ?";
        
        $params_with_limit = array_merge($params, [$limit, $offset]);
        $types_with_limit = $types . "ii";

        $this->data->select_prepare($sql, $types_with_limit, ...$params_with_limit);
        return $this->data->fetchAll();
    }

    // 👇 Hàm đếm tổng sản phẩm
    public function countProducts($where, $params, $types) {
        $sql = "SELECT COUNT(*) AS total 
                FROM san_pham sp 
                JOIN loai_sp l ON sp.MALOAI = l.MALOAI 
                $where";
        $this->data->select_prepare($sql, $types, ...$params);
        $row = $this->data->fetch();
        return $row['total'] ?? 0;
    }

public function timkiem($keyword) {
    $data = new Database();
    if (empty(trim($keyword))) {
        echo '<div class="container text-center my-5"><h4>Vui lòng nhập từ khóa tìm kiếm!</h4></div>';
        return;
    }

    $sql = "SELECT * FROM san_pham WHERE TENSP LIKE ?";
    $data->select_prepare($sql, "s", "%" . trim($keyword) . "%");
    $results = $data->fetchAll();

    if (count($results) > 0) {
        echo '<div class="container my-5">';
        echo '<h2 class="text-center mb-4">Kết quả tìm kiếm</h2>';
        echo '<div class="row">';

        foreach ($results as $row) {
            // Kiểm tra ảnh
            $imagePath = 'img/' . htmlspecialchars($row['IMAGE']);
            if (!file_exists($imagePath) || empty($row['IMAGE'])) {
                $imagePath = 'img/no-image.png';
            }

            echo '<div class="col-md-4 col-sm-6 mb-4">';
            echo '<div class="card border-dark shadow-sm h-100">';
            echo '<a href="detaillogin.php?id=' . htmlspecialchars($row['MASP']) . '">';
            echo '<img src="' . $imagePath . '" class="card-img-top product-img" alt="' . htmlspecialchars($row['TENSP']) . '">';
            echo '</a>';
            echo '<div class="card-body text-center">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['TENSP']) . '</h5>';
            echo '<p class="card-text font-weight-bold mb-0">Giá: ' . number_format($row['DONGIA'], 0, ',', '.') . ' VNĐ</p>';
            echo '</div></div></div>';
        }

        echo '</div></div>';
    } else {
        echo '<div class="container text-center my-5"><h4>Không tìm thấy sản phẩm phù hợp.</h4></div>';
    }
}  
    public function demSoSanPham($where, $types, $params = []) {
        $data = new Database();
        $sql = "SELECT COUNT(*) AS total 
                FROM san_pham sp 
                JOIN loai_sp l ON sp.MALOAI = l.MALOAI 
                $where";

        // Gọi hàm select_prepare trong Database (giống bạn đang dùng)
        $data->select_prepare($sql, $types, ...$params);
        $row = $data->fetch();
        return $row['total'] ?? 0;
    }
     public function layDanhSachSanPham($where, $order, $types, $params = [], $limit = 6, $offset = 0) {
        $data = new Database();
        $sql = "SELECT sp.*, l.TENLOAI 
                FROM san_pham sp 
                JOIN loai_sp l ON sp.MALOAI = l.MALOAI 
                $where 
                $order 
                LIMIT ? OFFSET ?";

        // Thêm limit + offset vào cuối danh sách tham số
        $params[] = $limit;
        $params[] = $offset;
        $types .= "ii";

        // Thực hiện truy vấn
        $data->select_prepare($sql, $types, ...$params);
        return $data->fetchAll();
    }
    public function layTatCaSanPham($limit = 6, $page = 1) {
        $offset = ($page - 1) * $limit;
        $data = new Database();
        // Đếm tổng sản phẩm
        $count_sql = "SELECT COUNT(*) AS total FROM san_pham";
        $data->select($count_sql);
        $total_row = $data->fetch();
        $total_products = $total_row['total'];
        $total_pages = ceil($total_products / $limit);

        // Lấy danh sách sản phẩm cho trang hiện tại
        $sql = "SELECT * FROM san_pham ORDER BY MASP DESC LIMIT ? OFFSET ?";
        $data->select_prepare($sql, "ii", $limit, $offset);
        $products = $data->fetchAll();

        // Trả về dữ liệu
        return [
            'products' => $products,
            'total_products' => $total_products,
            'total_pages' => $total_pages,
            'current_page' => $page
        ];
    }
    public function getCategories() {
        $sql = "SELECT MALOAI, TENLOAI FROM loai_sp ORDER BY TENLOAI ASC";
        $this->data->select($sql);
        return $this->data->fetchAll() ?? [];
    }
public function addProduct($TENSP, $MALOAI, $DONGIA, $file, $WEIGHT, $MOTA, $LENGTH, $FLEX, $BARCODE, $GIANHAP) {
    try {   
        $image = "uploads/default.jpg"; // Ảnh mặc định
        $relative_path = $_SERVER['DOCUMENT_ROOT'] . "/Web-Badminton-Shop/uploads/";
        $public_path = "uploads/";
        if (!is_dir($relative_path)) {
            mkdir($relative_path, 0777, true);
        }
        // Kiểm tra file upload
        if (!empty($file) && isset($file["name"]) && $file["error"] === UPLOAD_ERR_OK) {
            // Sinh tên file an toàn
            $filename = time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/', '', basename($file["name"]));
            $target_file = $relative_path . $filename;
            // Kiểm tra loại file
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $file_type = mime_content_type($file["tmp_name"]);
            
            if (!in_array($file_type, $allowed_types)) {
                return ['success' => false, 'message' => '❌ Chỉ chấp nhận file ảnh (jpg, png, gif, webp)!'];
            }
            // Kiểm tra kích thước (max 5MB)
            if ($file["size"] > 5 * 1024 * 1024) {
                return ['success' => false, 'message' => '❌ File ảnh không được vượt quá 5MB!'];
            }

            // Upload file
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $image = $public_path . $filename;
            } else {
                return ['success' => false, 'message' => '❌ Lỗi khi tải ảnh lên máy chủ!'];
            }
        }
        $check_sql = "SELECT MALOAI FROM loai_sp WHERE MALOAI = ?";
        $this->data->select_prepare($check_sql, "s", $MALOAI);
         $this->data->fetch();
        $sql = "INSERT INTO san_pham (MALOAI, TENSP, DONGIA, updated_at, IMAGE, BARCODE, WEIGHT, MOTA, LENGTH, FLEX, GIANHAP)
        VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?)";    
        $this->data->command_prepare($sql,"ssdssssssd", $MALOAI, $TENSP,$DONGIA,$image,$BARCODE,$WEIGHT,$MOTA,$LENGTH,$FLEX,$GIANHAP);
        $this->data->execute();
    } catch (Exception $e) {
        error_log("Lỗi addProduct: " . $e->getMessage());
        return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
    }
}
    public function deleteProduct($MASP) {
    try {
        // Kiểm tra tồn tại
        $sql_check = "SELECT * FROM san_pham WHERE MASP = ?";
        $this->data->select_prepare($sql_check, "i", $MASP);
        $product = $this->data->fetch();
        if (!$product) {
            throw new Exception("Sản phẩm không tồn tại!");
        }
        // Xóa file ảnh nếu tồn tại
        if (!empty($product['IMAGE'])) {
            $imgPath = $_SERVER['DOCUMENT_ROOT'] . "/Web-Badminton-Shop/" . $product['IMAGE'];
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }
        // Xóa khỏi DB
        $sql_delete = "DELETE FROM san_pham WHERE MASP = ?";
        $this->data->command_prepare($sql_delete, "i", $MASP);
        $this->data->execute();
        return [
            'success' => true,
            'message' => "Đã xóa sản phẩm thành công!"
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}
    public function laySanPhamTheoLoai($category) {
    try {
        if (empty($category)) {
            return [];
        }
        $sql = "SELECT MASP, TENSP, GIANHAP 
                FROM san_pham 
                WHERE MALOAI = ?";
        $this->data->select_prepare($sql, "s", $category);
        $result = $this->data->fetchAll();

        return $result ?? [];
    } catch (Exception $e) {
        // Ghi log hoặc thông báo lỗi tùy hệ thống
        return [];
    }
}
    
    public function getLimit() {
        return $this->limit;
    }
    public function __destruct() {
        // Cleanup code if needed
        $this->name = null;
        $this->category = null;
        $this->price = null;
        $this->stock = null;
        $this->image = null;
        $this->code = null;
        $this->update = null;
        $this->weight = null;
        $this->length = null;
        $this->flex = null;
}
}
?>