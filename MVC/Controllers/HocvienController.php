<?php
/**
 * MODULE: Làm bài thi (Học viên) | THÀNH VIÊN: TV5
 * Xem README.md → Mục TV5 để biết chi tiết việc cần làm.
 *
 * FILE NÀY TV5 ĐƯỢC SỬA TỰ DO.
 * Phụ thuộc (chỉ gọi, không sửa): Phongthi_m ← TV4
 */
class HocvienController extends Controller
{
    public function index()   { $this->phongthi(); }

    public function phongthi()
    {
        $this->needHV();
        // TODO: TV5 – Danh sách phòng thi của học viên
        $this->_todo("Phòng thi của tôi", "TV5");
    }

    public function confirm($phong_id)
    {
        $this->needHV();
        // TODO: TV5 – Xác nhận thông tin trước khi thi
        $this->_todo("Xác nhận vào thi", "TV5");
    }

    public function start()       { $this->needHV(); }
    public function do($id = null){ $this->needHV(); $this->_todo("Làm bài thi", "TV5"); }
    public function saveAnswer()  { header("Content-Type: application/json"); echo json_encode(["ok"=>false,"msg"=>"TODO"]); exit; }
    public function saveViolation(){ header("Content-Type: application/json"); echo json_encode(["ok"=>false]); exit; }
    public function markReview()  { header("Content-Type: application/json"); echo json_encode(["ok"=>false]); exit; }
    public function submit()      { $this->needHV(); }

    public function result($id)
    {
        $this->needHV();
        // TODO: TV5 – Kết quả bài thi
        $this->_todo("Kết quả bài thi", "TV5");
    }

    public function history()
    {
        $this->needHV();
        // TODO: TV5 – Lịch sử thi
        $this->_todo("Lịch sử thi", "TV5");
    }

    public function logout()
    {
        unset($_SESSION["hv"]);
        header("Location: " . BASE_URL . "/index.php?url=AuthController/login");
        exit;
    }

    private function _todo($title, $tv)
    {
        echo "<div style='font-family:sans-serif;padding:3rem;text-align:center'>
              <h2>🚧 $title</h2><p>Đang được <strong>$tv</strong> phát triển.</p></div>";
    }
}
