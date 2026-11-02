<?php
/**
 * MODULE: Lớp học | THÀNH VIÊN: TV4
 * Xem README.md → Mục TV4 để biết chi tiết việc cần làm.
 */
class LophocController extends Controller
{
    public function index()
    {
        $this->needAdmin();

        try {
            $lopHocModel = $this->model("Lophoc_m");
            $lopHoc = $lopHocModel->getAll();
            $this->view("layout_admin", [
                "page" => "Pages/lh_list",
                "lop_hoc" => $lopHoc,
            ]);
        } catch (PDOException $e) {
            $this->view("layout_admin", [
                "page" => "Pages/lh_list",
                "lop_hoc" => [],
                "err" => "Không thể tải danh sách lớp học.",
            ]);
        }
    }

    public function store()    { $this->needAdmin(); }
    public function edit($id)  { $this->needAdmin(); $this->_todo("Lớp học / Sửa #$id", "TV4"); }
    public function update()   { $this->needAdmin(); }
    public function delete($id){ $this->needAdmin(); }

    private function _todo($title, $tv)
    {
        echo "<div style='font-family:sans-serif;padding:3rem;text-align:center'>
              <h2>🚧 $title</h2><p>Đang được <strong>$tv</strong> phát triển.</p></div>";
    }
}
