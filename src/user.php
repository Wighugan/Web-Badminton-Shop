<?php
require_once 'systemManage.php';
class QuanLyKhachHang extends QuanLyHeThong {
    public function __construct(Database $data) {
        parent::__construct();
    }
    public function CapNhatThongTin($MAKH, $TENKH, $HOTEN, $EMAIL, $DIACHI, $DIACHI1, $DIACHI2, $MAKHAU, $SDT, $birthday, $AVATAR) 
    {
        try {
            $baseFields = "TENKH = ?, HOTEN = ?, EMAIL = ?, DIACHI = ?, DIACHI1 = ?, TP = ?, NS = ?, SDT = ?";
            $baseParams = [$TENKH, $HOTEN, $EMAIL, $DIACHI, $DIACHI1, $DIACHI2, $birthday, $SDT];
            $types = "ssssssss";

            if ($AVATAR && !empty($MAKHAU)) {
                $sql = "UPDATE khach_hang SET $baseFields, MATKHAU = ?, AVATAR = ? WHERE MAKH = ?";
                $params = array_merge($baseParams, [$MAKHAU, $AVATAR, $MAKH]);
                $types .= "ssi";
            } elseif ($AVATAR) {
                $sql = "UPDATE khach_hang SET $baseFields, AVATAR = ? WHERE MAKH = ?";
                $params = array_merge($baseParams, [$AVATAR, $MAKH]);
                $types .= "si";
            } elseif (!empty($MAKHAU)) {
                $sql = "UPDATE khach_hang SET $baseFields, MATKHAU = ? WHERE MAKH = ?";
                $params = array_merge($baseParams, [$MAKHAU, $MAKH]);
                $types .= "si";
            } else {
                $sql = "UPDATE khach_hang SET $baseFields WHERE MAKH = ?";
                $params = array_merge($baseParams, [$MAKH]);
                $types .= "i";
            }
            return $this->data->command_prepare($sql, $types, ...$params);
        } catch (Exception $e) {
            // Add error handling here
            throw $e;
        }
    }
    public function XemLichSuMuaHang($MAKH, $limit, $offset) {
        $sql = "SELECT dh.*, kh.HOTEN, kh.SDT 
                FROM don_hang dh
                JOIN khach_hang kh ON dh.MAKH = kh.MAKH 
                WHERE dh.MAKH = ? 
                ORDER BY dh.NGAYLAP DESC 
                LIMIT ? OFFSET ?";
        $this->data->select_prepare($sql, "iii", $MAKH, $limit, $offset);
        return $this->data->fetchAll();
    }
    
    public function __destruct() {
        $this->data->close();
    }
    public function layThongTinUser($MAKH) {
    $sql = "SELECT * FROM khach_hang WHERE MAKH = ?";
    $this->data->select_prepare($sql, "i", $MAKH);
    return $this->data->fetch();
}
}


?>