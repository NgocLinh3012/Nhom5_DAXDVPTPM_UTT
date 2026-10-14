<?php

class User_m extends Database
{
    public function findByUsername($u)
    {
        $st = $this->con->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $st->execute([$u]);
        return $st->fetch();
    }

    public function find($id)
    {
        $st = $this->con->prepare("SELECT * FROM users WHERE id = ?");
        $st->execute([(int)$id]);
        return $st->fetch();
    }

    public function existsUsername($username, $ignoreId = 0)
    {
        $st = $this->con->prepare("SELECT id FROM users WHERE username = ? AND id <> ?");
        $st->execute([$username, (int)$ignoreId]);
        return (bool)$st->fetch();
    }

    public function getAll()
    {
        return $this->con->query("SELECT id, hoten, username, email, trangthai, role, created_at FROM users ORDER BY id")->fetchAll();
    }
}
