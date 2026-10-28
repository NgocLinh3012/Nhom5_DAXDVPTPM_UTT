<?php
/**
 * MODEL: Làm bài thi | THÀNH VIÊN: TV5
 * FILE NÀY TV5 ĐƯỢC SỬA TỰ DO.
 *
 * TV4 gọi getPhongStatus(), finishExam(), updatePhongHVAfterSubmit()
 * khi monitor và xử lý vi phạm.
 * → Giữ đúng signature các method công khai.
 */
class LamBai_m extends Database
{
    // TODO: TV5 – Implement

    public function listPhongThiByHocVien($hv_id)                           { return ["lop"=>null,"rows"=>[]]; }
    public function phongInfo($phong_id)                                     { return null; }
    public function hvInPhong($phong_id, $hv_id)                             { return null; }
    public function getBaiLamDoing($phong_id, $hv_id)                        { return null; }
    public function getBaiLam($bailam_id, $hv_id)                            { return null; }
    public function pickQuestions($phong)                                     { return []; }
    public function createBaiLam($phong_id, $hv_id, $de_id, $so_cau)        { return 0; }
    public function insertBaiLamCT($bailam_id, $cauhoi_id) {}
    public function setVaoPhongTime($phong_id, $hv_id) {}
    public function getQuestionsOfBaiLam($bailam_id)                         { return []; }
    public function getAnsweredStatus($bailam_id)                            { return []; }
    public function getReviewStatus($bailam_id)                              { return []; }
    public function getRemainingTime($bailam_id)                             { return 0; }
    public function saveAnswer($bailam_id, $cauhoi_id, $answer) {}
    public function markReview($bailam_id, $cauhoi_id, $phan_van) {}
    public function submit($bailam_id, $answers)                             { return []; }
    public function listHistory($hv_id)                                      { return []; }

    /** TV4 gọi – PHẢI implement đúng */
    public function getPhongStatus($phong_id)                                { return []; }
    public function finishExam($bailam_id)                                   { return []; }
    public function updatePhongHVAfterSubmit($phong_id, $hv_id, $kq) {}
}
