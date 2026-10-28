<?php
/**
 * MODEL: Đề thi | THÀNH VIÊN: TV3
 * FILE NÀY TV3 ĐƯỢC SỬA TỰ DO.
 *
 * TV5 sẽ gọi method find() và các method liên quan khi làm bài.
 * → Giữ đúng tên & signature các method công khai.
 */
class Dethi_m extends Database
{
    // TODO: TV3 – Implement

    public function list($mon_id, $q)       { return []; }
    public function find($id)               { return null; }
    public function existsMa($ma, $excId=0) { return false; }
    public function insertDe($ma, $ten, $thoi_gian, $mon_id) { return 0; }
    public function addQuestionsToDe($de_id, $ids) {}
    public function pickQuestions($mon_id, $loai, $so) { return []; }
    public function delete($id) {}
}
