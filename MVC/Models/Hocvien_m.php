<?php
/**
 * MODEL: Học viên | THÀNH VIÊN: TV4
 * FILE NÀY TV4 ĐƯỢC SỬA TỰ DO.
 *
 * TV1 (Auth) gọi findByMaHV() để đăng nhập học viên.
 * → Giữ đúng signature method này.
 */
class Hocvien_m extends Database
{
    // TODO: TV4 – Implement

    /** TV1 gọi method này khi đăng nhập – PHẢI implement đúng */
    public function findByMaHV($ma_hv)      { return null; }

    public function list($lop_id, $q, $limit, $offset) { return []; }
    public function count($lop_id, $q)                 { return 0; }
    public function find($id)                          { return null; }
    public function insert($ma_hv, $hoten, $lop_id, $password_hash, $trangthai) { return 0; }
    public function update($id, $ma_hv, $hoten, $lop_id, $trangthai) {}
    public function updatePassword($id, $hash) {}
    public function delete($id) {}
    public function existsMa($ma, $excId=0) { return false; }
    public function getByLop($lop_id)       { return []; }
}
