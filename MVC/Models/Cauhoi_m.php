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
        // TODO: TV2
        return [];
    }

    public function count($mon_id, $q)
    {
        // TODO: TV2
        return 0;
    }

    public function find($id)
    {
        // TODO: TV2
        return null;
    }

    public function insert($mon_id, $noi_dung, $a, $b, $c, $d, $dap_an_dung, $diem, $giai_thich, $loai, $kich_hoat)
    {
        // TODO: TV2
    }

    public function updateBasic($id, $mon_id, $noi_dung, $a, $b, $c, $d, $dap_an_dung, $diem, $giai_thich, $loai, $kich_hoat)
    {
        // TODO: TV2
    }

    public function delete($id)
    {
        // TODO: TV2
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
