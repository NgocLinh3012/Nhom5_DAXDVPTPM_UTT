<?php
/**
 * MODULE: Đề thi | THÀNH VIÊN: TV3
 * Xem README.md → Mục TV3 để biết chi tiết việc cần làm.
 *
 * FILE NÀY TV3 ĐƯỢC SỬA TỰ DO.
 * Phụ thuộc (chỉ gọi, không sửa): Cauhoi_m ← của TV2
 */
class DethiController extends Controller
{
    public function index()
    {
        $this->needAdmin();
        // TODO: TV3 – Danh sách đề thi
        $this->_todo("Đề thi", "TV3");
    }

    public function store()    { $this->needAdmin(); }
    public function edit($id)  { $this->needAdmin(); $this->_todo("Đề thi / Sửa #$id", "TV3"); }
    public function update()   { $this->needAdmin(); }
    public function delete($id){ $this->needAdmin(); }
    public function import()   { $this->needAdmin(); }
    public function template() { $this->needAdmin(); }

    private function _todo($title, $tv)
    {
        echo "<div style='font-family:sans-serif;padding:3rem;text-align:center'>
              <h2>🚧 $title</h2><p>Đang được <strong>$tv</strong> phát triển.</p></div>";
    }
}
