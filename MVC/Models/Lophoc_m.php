<?php
/**
 * MODEL: Lớp học | THÀNH VIÊN: TV4
 * FILE NÀY TV4 ĐƯỢC SỬA TỰ DO.
 *
 * TV5 gọi find() để kiểm tra trạng thái lớp khi vào thi.
 */
class Lophoc_m extends Database
{
    // TODO: TV4 – Implement

    public function getAll()                         { return []; }
    public function find($id)                        { return null; }
    public function existsMa($ma, $excId=0)          { return false; }
    public function insert($ma, $ten, $trangthai)    { return 0; }
    public function update($id, $ma, $ten, $trangthai) {}
    public function delete($id) {}
}
