<?php

class Hocvien_m extends Database
{
    public function findByMaHV($ma_hv)
    {
        $st = $this->con->prepare("SELECT * FROM hoc_vien WHERE ma_hv = ? LIMIT 1");
        $st->execute([trim($ma_hv)]);
        return $st->fetch();
    }
}
