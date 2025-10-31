<?php 
class SanPham {
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
    private $data;
    public function lietketspnb() {
        $data = new Database();
        $sql = "SELECT MASP, TENSP, IMAGE, DONGIA 
                FROM san_pham 
                ORDER BY MASP DESC 
                LIMIT 8";
        $data->select_prepare($sql);
        return $data->fetchAll(); // ✅ lấy toàn bộ kết quả
    }

    public function lietketspmoi() {
        $data = new Database();
        $sql = "SELECT MASP, TENSP, IMAGE, DONGIA 
                FROM san_pham 
                ORDER BY updated_at DESC 
                LIMIT 8";
        $data->select_prepare($sql);
        return $data->fetchAll(); // ✅ lấy toàn bộ kết quả
    }
    public function XemCTSP ($id){
        $sql = "SELECT sp.*, ls.TENLOAI 
        FROM san_pham sp
        LEFT JOIN loai_sp ls ON sp.MALOAI = ls.MALOAI
        WHERE sp.MASP = ?";
        $data = new Database();
        $data->select_prepare($sql, "i", $id);
        return $data->fetch();
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

        $data->select_prepare($sql, $types_with_limit, ...$params_with_limit);
        return $data->fetchAll();
    }

    // 👇 Hàm đếm tổng sản phẩm
    public function countProducts($where, $params, $types) {
        $data = new Database();
        $sql = "SELECT COUNT(*) AS total 
                FROM san_pham sp 
                JOIN loai_sp l ON sp.MALOAI = l.MALOAI 
                $where";
        $data->select_prepare($sql, $types, ...$params);
        $row = $data->fetch();
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