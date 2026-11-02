<?php
/**
 * MODEL: Câu hỏi | THÀNH VIÊN: TV2
 * FILE NÀY TV2 ĐƯỢC SỬA TỰ DO.
 *
 * Các method cần implement:
 *   list($mon_id, $q, $offset, $limit=50)
 *   count($mon_id, $q)
 *   find($id)
 *   insert($mon_id, $noi_dung, $a, $b, $c, $d, $dap_an_dung, $diem, $giai_thich, $loai, $kich_hoat)
 *   updateBasic($id, ...)
 *   delete($id)
 *   checkExist($mon_id, $noi_dung)
 *   getByMonAndLoai($mon_id, $loai, $limit)   ← TV3 sẽ gọi method này để chọn câu cho đề thi
 */
class Cauhoi_m extends Database
{
    // TODO: TV2 – Implement tất cả methods ở trên
    // Tham khảo schema bảng `cau_hoi` trong file thitracnghiem.sql

    public function list($mon_id, $q, $offset = 0, $limit = 50)
{
    $qLike = "%" . trim($q) . "%";
    $offset = max(0, (int) $offset);
    $limit = max(1, (int) $limit);

    $sql = "
        SELECT ch.*, m.ten_mon
        FROM cau_hoi ch
        JOIN mon_thi m ON m.id = ch.mon_id
        WHERE (? = 0 OR ch.mon_id = ?)
          AND (
              ch.noi_dung LIKE ?
              OR ch.dap_an_a LIKE ?
              OR ch.dap_an_b LIKE ?
              OR ch.dap_an_c LIKE ?
              OR ch.dap_an_d LIKE ?
          )
        ORDER BY ch.id DESC
        LIMIT $limit OFFSET $offset
    ";

    $st = $this->con->prepare($sql);
    $st->execute([
        (int) $mon_id, (int) $mon_id,
        $qLike, $qLike, $qLike, $qLike, $qLike
    ]);

    return $st->fetchAll();
}
   public function count($mon_id, $q)
{
    $qLike = "%" . trim($q) . "%";

    $sql = "
        SELECT COUNT(*) AS c
        FROM cau_hoi
        WHERE (? = 0 OR mon_id = ?)
          AND (
              noi_dung LIKE ?
              OR dap_an_a LIKE ?
              OR dap_an_b LIKE ?
              OR dap_an_c LIKE ?
              OR dap_an_d LIKE ?
          )
    ";

    $st = $this->con->prepare($sql);
    $st->execute([
        (int) $mon_id, (int) $mon_id,
        $qLike, $qLike, $qLike, $qLike, $qLike
    ]);

    return (int) ($st->fetch()["c"] ?? 0);
}
public function find($id)
{
    $sql = "SELECT * FROM cau_hoi WHERE id = ?";

    $st = $this->con->prepare($sql);
    $st->execute([(int) $id]);

    return $st->fetch();
}
public function insert($mon_id, $noi_dung, $a, $b, $c, $d, $dap_an_dung, $diem, $giai_thich, $loai, $kich_hoat)
{
    $sql = "INSERT INTO cau_hoi
        (mon_id, noi_dung, dap_an_a, dap_an_b, dap_an_c, dap_an_d,
         dap_an_dung, diem, giai_thich, loai, kich_hoat)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $st = $this->con->prepare($sql);

    return $st->execute([
        $mon_id,
        $noi_dung,
        $a,
        $b,
        $c,
        $d,
        $dap_an_dung,
        $diem,
        $giai_thich,
        $loai,
        $kich_hoat
    ]);
}
public function updateBasic($id, $mon_id, $noi_dung, $a, $b, $c, $d, $dap_an_dung, $diem, $giai_thich, $loai, $kich_hoat)
{
    $sql = "UPDATE cau_hoi SET
        mon_id = ?,
        noi_dung = ?,
        dap_an_a = ?,
        dap_an_b = ?,
        dap_an_c = ?,
        dap_an_d = ?,
        dap_an_dung = ?,
        diem = ?,
        giai_thich = ?,
        loai = ?,
        kich_hoat = ?
        WHERE id = ?";

    $st = $this->con->prepare($sql);

    return $st->execute([
        $mon_id,
        $noi_dung,
        $a,
        $b,
        $c,
        $d,
        $dap_an_dung,
        $diem,
        $giai_thich,
        $loai,
        $kich_hoat,
        (int) $id
    ]);
}
public function delete($id)
{
    $sql = "DELETE FROM cau_hoi WHERE id = ?";

    $st = $this->con->prepare($sql);

    return $st->execute([(int) $id]);
}
    public function checkExist($mon_id, $noi_dung)
    {
        // TODO: TV2
        return false;
    }

    /**
     * TV3 GỌI METHOD NÀY để lấy câu hỏi khi tạo đề.
     * TV2 phải implement đúng signature này.
     */
    public function getByMonAndLoai($mon_id, $loai, $limit)
    {
        // TODO: TV2 – Trả về mảng ['id', 'noi_dung', 'loai', ...]
        return [];
    }
}
