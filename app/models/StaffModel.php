<?php
class StaffModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllStaffs()
    {
        $stmt = $this->db->query("SELECT * FROM nhanvien");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getStaffsByPage($page, $limit)
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT nhanvien.*, phongban.Ten_Phong 
            FROM nhanvien 
            LEFT JOIN phongban ON nhanvien.Ma_Phong = phongban.Ma_Phong 
            LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // Tính tổng số trang
    public function getTotalPages($limit)
    {
        $sql = "SELECT COUNT(*) as total FROM nhanvien";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalRecords = $row['total'];

        return ceil($totalRecords / $limit);
    }

    public function getStaffById($id)
    {
        $sql = "SELECT * FROM nhanvien WHERE Ma_NV = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addStaff($data)
    {
        // Lấy mã nhân viên lớn nhất
        $sql = "SELECT Ma_NV FROM nhanvien ORDER BY Ma_NV DESC LIMIT 1";
        $stmt = $this->db->query($sql);
        $latestStaff = $stmt->fetch(PDO::FETCH_ASSOC);

        // Nếu có dữ liệu, tăng số ID lên
        if ($latestStaff) {
            preg_match('/([A-Za-z]+)([0-9]+)/', $latestStaff['Ma_NV'], $matches);
            $prefix = $matches[1]; // Chữ cái (A)
            $number = (int)$matches[2] + 1; // Số (01 → 02)
            $newId = sprintf("%s%02d", $prefix, $number); // Tạo ID mới (A02)
        } else {
            $newId = "A01"; // Nếu chưa có nhân viên nào, bắt đầu từ A01
        }

        // Thêm nhân viên với Ma_NV mới
        $sql = "INSERT INTO nhanvien (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong)
            VALUES (:ma_nv, :ten_nv, :phai, :noi_sinh, :ma_phong, :luong)";
        $stmt = $this->db->prepare($sql);

        // Gán giá trị vào mảng `$data`
        $data['ma_nv'] = $newId;

        return $stmt->execute($data);
    }


    // Cập nhật nhân viên
    public function updateStaff($id, $data)
    {
        $sql = "UPDATE nhanvien 
            SET Ten_NV = :ten_nv, Phai = :phai, Noi_Sinh = :noi_sinh, 
                Ma_Phong = :ma_phong, Luong = :luong
            WHERE Ma_NV = :ma_nv";

        $stmt = $this->db->prepare($sql);

        $data['ma_nv'] = $id; // Gán ID vào mảng dữ liệu

        return $stmt->execute($data);
    }


    // Xóa nhân viên
    public function deleteStaff($id)
    {
        $sql = "DELETE FROM nhanvien WHERE Ma_NV = :ma_nv";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':ma_nv', $id, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
