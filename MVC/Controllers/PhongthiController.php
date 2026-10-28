<?php
/**
 * MODULE: Phòng thi & Giám sát | THÀNH VIÊN: TV4
 * Xem README.md → Mục TV4 để biết chi tiết việc cần làm.
 *
 * FILE NÀY TV4 ĐƯỢC SỬA TỰ DO.
 * Phụ thuộc (chỉ gọi, không sửa): Dethi_m ← TV3 | LamBai_m ← TV5
 */
class PhongthiController extends Controller
{
    public function index()
    {
        $this->needGV();
        // TODO: TV4 – Danh sách phòng thi
        $this->_todo("Phòng thi", "TV4");
    }

    public function store()          { $this->needAdmin(); }
    public function edit($id)        { $this->needAdmin(); $this->_todo("Phòng thi / Sửa #$id", "TV4"); }
    public function update()         { $this->needAdmin(); }
    public function delete($id)      { $this->needAdmin(); }
    public function vaoPhong($id)    { $this->needGV();   $this->_todo("Vào Phòng thi #$id", "TV4"); }
    public function kichhoat()       { $this->needGV(); }
    public function reset()          { $this->needGV(); }
    public function huy()            { $this->needGV(); }
    public function ghichu()         { $this->needGV(); }
    public function vipham()         { $this->needGV(); }
    public function monitor($id)     { $this->needLogin(); $this->_todo("Monitor Phòng thi #$id", "TV4"); }
    public function exportExcel($id) { $this->needLogin(); }
    public function template()       { $this->needLogin(); }
    public function import()         { $this->needAdmin(); }

    private function _todo($title, $tv)
    {
        echo "<div style='font-family:sans-serif;padding:3rem;text-align:center'>
              <h2>🚧 $title</h2><p>Đang được <strong>$tv</strong> phát triển.</p></div>";
    }
}
