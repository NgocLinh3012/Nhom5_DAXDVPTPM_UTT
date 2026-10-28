<?php
/**
 * MODULE: Quản lý Học viên (phía Admin) | THÀNH VIÊN: TV4
 * Xem README.md → Mục TV4 để biết chi tiết việc cần làm.
 */
class HocvienAdminController extends Controller
{
    public function index()
    {
        $this->needAdmin();
        // TODO: TV4 – Danh sách học viên
        $this->_todo("Học viên (Admin)", "TV4");
    }

    public function create()   { $this->needAdmin(); $this->_todo("Học viên / Thêm mới", "TV4"); }
    public function store()    { $this->needAdmin(); }
    public function edit($id)  { $this->needAdmin(); $this->_todo("Học viên / Sửa #$id", "TV4"); }
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
