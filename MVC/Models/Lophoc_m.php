<?php
/**
 * MODEL: Lớp học | THÀNH VIÊN: TV4
 * FILE NÀY TV4 ĐƯỢC SỬA TỰ DO.
 *
 * TV5 gọi find() để kiểm tra trạng thái lớp khi vào thi.
 */
class Lophoc_m extends Database
{
    public function getAll()
    {
        $stmt = $this->con->prepare(
            "SELECT id, ma_lop, ten_lop, trangthai
             FROM lop_hoc
             ORDER BY id ASC"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function find($id)
    {
        $stmt = $this->con->prepare(
            "SELECT id, ma_lop, ten_lop, trangthai
             FROM lop_hoc
             WHERE id = ?
             LIMIT 1"
        );
        $stmt->execute([(int) $id]);
        return $stmt->fetch() ?: null;
    }
    public function existsMa($ma, $excId=0)
    {
        $sql = "SELECT 1 FROM lop_hoc WHERE ma_lop = ?";
        $params = [$ma];

        if ((int) $excId > 0) {
            $sql .= " AND id <> ?";
            $params[] = (int) $excId;
        }

        $sql .= " LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() !== false;
    }

    public function insert($ma, $ten, $trangthai)
    {
        $stmt = $this->con->prepare(
            "INSERT INTO lop_hoc (ma_lop, ten_lop, trangthai) VALUES (?, ?, ?)"
        );
        $stmt->execute([$ma, $ten, $trangthai]);
        return (int) $this->con->lastInsertId();
    }
    public function update($id, $ma, $ten, $trangthai)
    {
        $stmt = $this->con->prepare(
            "UPDATE lop_hoc
             SET ma_lop = ?, ten_lop = ?, trangthai = ?
             WHERE id = ?"
        );
        return $stmt->execute([(string) $ma, (string) $ten, (int) $trangthai, (int) $id]);
    }
    public function delete($id) {}
}
