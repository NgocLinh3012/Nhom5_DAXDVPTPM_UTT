<?php
/**
 * MODEL: Môn thi | THÀNH VIÊN: TV3
 * FILE NÀY TV3 ĐƯỢC SỬA TỰ DO.
 *
 * ⚠️  TV2 và TV4 gọi getAll() và find() từ file này.
 *     → Giữ đúng tên & signature các method công khai bên dưới.
 */
class Monthi_m extends Database
{
    // TODO: TV3 – Implement

    /** TV2 và TV4 gọi method này – PHẢI implement đúng */
    public function getAll()            { return []; }
    public function find($id)           { return null; }
    public function existsMa($ma)       { return false; }
    public function insert($ma, $ten)   { return 0; }
    public function update($id, $ma, $ten, $trangthai) {}
    public function delete($id) {}
}
