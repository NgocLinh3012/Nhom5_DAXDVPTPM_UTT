<?php

class Hocvien_m extends Database
{
    /**
     * Tìm học viên theo mã học viên
     */
    public function findByMaHV($ma_hv)
    {
        $st = $this->con->prepare("
            SELECT *
            FROM hoc_vien
            WHERE ma_hv = ?
            LIMIT 1
        ");

        $st->execute([
            trim($ma_hv)
        ]);

        return $st->fetch();
    }

    /**
     * Tìm học viên theo ID
     */
    public function findById($id)
    {
        $id = (int)$id;

        $st = $this->con->prepare("
            SELECT
                hv.*,
                l.ma_lop,
                l.ten_lop,
                u.hoten AS nguoi_tao
            FROM hoc_vien hv
            JOIN lop_hoc l
                ON l.id = hv.lop_id
            LEFT JOIN users u
                ON u.id = hv.created_by
            WHERE hv.id = ?
            LIMIT 1
        ");

        $st->execute([$id]);

        $result = $st->fetch();

        return $result ?: null;
    }

    /**
     * Lấy danh sách lớp học
     */
    public function getLops()
    {
        $sql = "
            SELECT
                id,
                ma_lop,
                ten_lop
            FROM lop_hoc
            ORDER BY ma_lop
        ";

        return $this->con->query($sql)->fetchAll();
    }

    /**
     * Lấy danh sách học viên, tìm kiếm và lọc theo lớp
     */
    public function search($lop_id, $q, $limit = 50, $offset = 0)
    {
        $lop_id = (int)$lop_id;
        $limit  = max(1, (int)$limit);
        $offset = max(0, (int)$offset);
        $q      = trim($q);

        $sql = "
            SELECT
                hv.*,
                l.ma_lop,
                l.ten_lop,
                u.hoten AS nguoi_tao
            FROM hoc_vien hv
            JOIN lop_hoc l
                ON l.id = hv.lop_id
            LEFT JOIN users u
                ON u.id = hv.created_by
            WHERE 1 = 1
        ";

        $params = [];

        // Lọc theo lớp
        if ($lop_id > 0) {
            $sql .= " AND hv.lop_id = ?";
            $params[] = $lop_id;
        }

        // Tìm theo họ tên hoặc mã học viên
        if ($q !== '') {
            $sql .= "
                AND (
                    hv.hoten LIKE ?
                    OR hv.ma_hv LIKE ?
                )
            ";

            $params[] = "%{$q}%";
            $params[] = "%{$q}%";
        }

        $sql .= "
            ORDER BY hv.id DESC
            LIMIT {$limit}
            OFFSET {$offset}
        ";

        $st = $this->con->prepare($sql);
        $st->execute($params);

        return $st->fetchAll();
    }

    /**
     * Đếm tổng số học viên sau khi tìm kiếm và lọc
     */
    public function countSearch($lop_id, $q)
    {
        $lop_id = (int)$lop_id;
        $q      = trim($q);

        $sql = "
            SELECT COUNT(*) AS total
            FROM hoc_vien hv
            WHERE 1 = 1
        ";
        $params = [];

        // Lọc theo lớp
        if ($lop_id > 0) {
            $sql .= " AND hv.lop_id = ?";
            $params[] = $lop_id;
        }

        // Tìm theo họ tên hoặc mã học viên
        if ($q !== '') {
            $sql .= "
                AND (
                    hv.hoten LIKE ?
                    OR hv.ma_hv LIKE ?
                )
            ";

            $params[] = "%{$q}%";
            $params[] = "%{$q}%";
        }

        $st = $this->con->prepare($sql);
        $st->execute($params);

        $result = $st->fetch();

        return (int)($result['total'] ?? 0);
    }

    /**
     * Kiểm tra mã học viên đã tồn tại hay chưa
     */
    public function existsMaHV($ma_hv)
    {
        $st = $this->con->prepare("
            SELECT id
            FROM hoc_vien
            WHERE ma_hv = ?
            LIMIT 1
        ");

        $st->execute([
            trim($ma_hv)
        ]);

        return (bool)$st->fetch();
    }

    /**
     * Kiểm tra học viên có tồn tại theo ID hay không
     */
    public function existsById($id)
    {
        $id = (int)$id;

        $st = $this->con->prepare("
            SELECT id
            FROM hoc_vien
            WHERE id = ?
            LIMIT 1
        ");

        $st->execute([$id]);

        return (bool)$st->fetch();
    }

    /**
     * Thêm học viên
     */
    public function insert(
        $hoten,
        $ma_hv,
        $matkhau,
        $lop_id,
        $trangthai,
        $created_by
    ) {
        $st = $this->con->prepare("
            INSERT INTO hoc_vien (
                hoten,
                ma_hv,
                matkhau,
                trangthai,
                lop_id,
                created_by,
                created_at
            )
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");

        return $st->execute([
            trim($hoten),
            trim($ma_hv),
            $matkhau,
            (int)$trangthai,
            (int)$lop_id,
            (int)$created_by
        ]);
    }

    /**
     * Cập nhật học viên
     */
    public function update(
        $id,
        $hoten,
        $matkhau,
        $lop_id,
        $trangthai
    ) {
        $st = $this->con->prepare("
            UPDATE hoc_vien
            SET
                hoten = ?,
                matkhau = ?,
                lop_id = ?,
                trangthai = ?
            WHERE id = ?
        ");

        return $st->execute([
            trim($hoten),
            $matkhau,
            (int)$lop_id,
            (int)$trangthai,
            (int)$id
        ]);
    }

    /**
     * Kiểm tra học viên có được phép xóa hay không
     */
    public function canDelete($id)
    {
        $id = (int)$id;

        // Kiểm tra học viên đã có bài làm hay chưa
        $st = $this->con->prepare("
            SELECT COUNT(*) AS total
            FROM bai_lam
            WHERE hocvien_id = ?
            ");

        $st->execute([$id]);

        $result = $st->fetch();

        if ((int)($result['total'] ?? 0) > 0) {
            return false;
        }

        // Kiểm tra học viên đã được thêm vào phòng thi hay chưa
        $st = $this->con->prepare("
            SELECT COUNT(*) AS total
            FROM phong_thi_hoc_vien
            WHERE hocvien_id = ?
        ");

        $st->execute([$id]);

        $result = $st->fetch();

        if ((int)($result['total'] ?? 0) > 0) {
            return false;
        }

        return true;
    }

    /**
     * Xóa học viên
     */
    public function delete($id)
    {
        $id = (int)$id;

        $st = $this->con->prepare("
            DELETE FROM hoc_vien
            WHERE id = ?
        ");

        $st->execute([$id]);

        // Chỉ trả về true khi thực sự xóa được ít nhất một dòng
        return $st->rowCount() > 0;
    }
   
/**
 * Kiểm tra lớp học có tồn tại hay không
 */
public function existsLopById($id)
{
    $id = (int)$id;

    $st = $this->con->prepare("
        SELECT id
        FROM lop_hoc
        WHERE id = ?
        LIMIT 1
    ");

    $st->execute([$id]);

    return (bool)$st->fetch();
}


}