<?php

class Lophoc_m extends Database
{
    public function getAll()
    {
        $sql = "
            SELECT l.*,
                   (SELECT COUNT(*)
                    FROM hoc_vien hv
                    WHERE hv.lop_id = l.id) AS so_hoc_vien
            FROM lop_hoc l
            ORDER BY l.id DESC
        ";

        return $this->con->query($sql)->fetchAll();
    }


    public function existsMaLop($ma_lop)
    {
        $st = $this->con->prepare("
            SELECT id
            FROM lop_hoc
            WHERE ma_lop = ?
        ");

        $st->execute([
            trim($ma_lop)
        ]);

        return (bool) $st->fetch();
    }


    public function insert($ma_lop, $ten_lop, $trangthai, $nguoi_tao)
    {
        $sql = "
            INSERT INTO lop_hoc
            (
                ma_lop,
                ten_lop,
                trangthai,
                nguoi_tao
            )
            VALUES (?, ?, ?, ?)
        ";

        $st = $this->con->prepare($sql);

        return $st->execute([
            trim($ma_lop),
            trim($ten_lop),
            (int) $trangthai,
            trim($nguoi_tao)
        ]);
    }
}