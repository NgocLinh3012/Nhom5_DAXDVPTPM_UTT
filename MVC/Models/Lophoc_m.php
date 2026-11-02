<?php
/**
 * MODEL: Lớp học | THÀNH VIÊN: TV4
 * FILE NÀY TV4 ĐƯỢC SỬA TỰ DO.
 *
 * TV5 gọi find() để kiểm tra trạng thái lớp khi vào thi.
 */
class Lophoc_m extends Database
{
    public function getAll()
    {
        $stmt = $this->con->prepare(
            "SELECT id, ma_lop, ten_lop, trangthai
             FROM lop_hoc
             ORDER BY id ASC"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function find($id)                        { return null; }
    public function existsMa($ma, $excId=0)          { return false; }
    public function insert($ma, $ten, $trangthai)    { return 0; }
    public function update($id, $ma, $ten, $trangthai) {}
    public function delete($id) {}
}
