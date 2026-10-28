<?php
/**
 * MODULE: Ngân hàng Câu hỏi | THÀNH VIÊN: TV2
 * Xem README.md → Mục TV2 để biết chi tiết việc cần làm.
 *
 * FILE NÀY TV2 ĐƯỢC SỬA TỰ DO.
 * Chỉ gọi (không sửa) model: Monthi_m  ← của TV3
 */
class CauhoiController extends Controller
{
    public function index()
    {
        $this->needAdmin();
        // TODO: TV2 – Danh sách câu hỏi (lọc theo môn, tìm kiếm, phân trang 50/trang)
        $this->_todo("Câu hỏi", "TV2");
    }

    public function create()  { $this->needAdmin(); $this->_todo("Câu hỏi / Thêm mới", "TV2"); }
    public function store()   { $this->needAdmin(); }
    public function edit($id) { $this->needAdmin(); $this->_todo("Câu hỏi / Sửa #$id", "TV2"); }
    public function update()  { $this->needAdmin(); }
    public function delete($id){ $this->needAdmin(); }

    public function template()
    {
        $this->needAdmin();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=cauhoi_mau.csv');
        echo "\xEF\xBB\xBF";
        echo "ma_mon,noi_dung,A,B,C,D,dap_an,diem,giai_thich,loai,kich_hoat\n";
        echo "TOAN,2+2=?,3,4,5,6,B,1,,D,1\n";
        exit;
    }

    public function import()  { $this->needAdmin(); }

    private function _todo($title, $tv)
    {
        echo "<div style='font-family:sans-serif;padding:3rem;text-align:center'>
              <h2>🚧 $title</h2><p>Đang được <strong>$tv</strong> phát triển.</p></div>";
    }
}
