<?php
/**
 * MODEL: Phòng thi | THÀNH VIÊN: TV4
 * FILE NÀY TV4 ĐƯỢC SỬA TỰ DO.
 *
 * TV5 gọi getViPhamStatus() khi hiển thị giao diện làm bài.
 * → Giữ đúng signature các method công khai.
 */
class Phongthi_m extends Database
{
    // TODO: TV4 – Implement

    public function list($lop_id, $q, $limit, $offset) { return []; }
    public function count($lop_id, $q)                 { return 0; }
    public function find($id)                          { return null; }
    public function existsMa($ma, $excId=0)            { return false; }
    public function insert($ma, $ten, $mon_id, $de_id, $lop_id, $bat_dau, $nguoi_tao, $trangthai) { return 0; }
    public function update($id, $ma, $ten, $mon_id, $de_id, $lop_id, $bat_dau, $trangthai) {}
    public function delete($id) {}
    public function addAllHocvienFromLop($phong_id, $lop_id) {}
    public function listHocvienInPhong($phong_id, $q)          { return []; }
    public function setKichHoat($phong_id, $hv_id, $val) {}
    public function resetLamLai($phong_id, $hv_id) {}
    public function huyBai($phong_id, $hv_id) {}
    public function updateGhiChu($phong_id, $hv_id, $note) {}
    public function tangViPham($phong_id, $hv_id)              { return null; }

    /** TV5 gọi method này khi hiển thị bài làm – PHẢI implement đúng */
    public function getViPhamStatus($phong_id, $hv_id)         { return ["so_lan_vi_pham"=>0]; }
}
