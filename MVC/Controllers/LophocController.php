<?php

class LophocController extends Controller
{
    public function index()
    {
        $this->needAdmin();

        $m = $this->model("Lophoc_m");

        $rows = $m->getAll();

        $this->view("layout_admin", [
            "page" => "Pages/lh_list",
            "rows" => $rows
        ]);
    }

    public function create()
    {
        $this->needAdmin();

        $this->view("layout_admin", [
            "page" => "Pages/lh_create"
        ]);
    }

    public function store()
    {
        $this->needAdmin();

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: " . BASE_URL . "/index.php?url=LophocController/index");
            exit;
        }

        $ma_lop = trim($_POST["ma_lop"] ?? "");
        $ten_lop = trim($_POST["ten_lop"] ?? "");

        if ($ma_lop === "" || $ten_lop === "") {
            $this->view("layout_admin", [
                "page" => "Pages/lh_create",
                "err" => "Vui lòng nhập đầy đủ thông tin"
            ]);
            return;
        }

        $m = $this->model("Lophoc_m");

        if ($m->existsMaLop($ma_lop)) {
            $this->view("layout_admin", [
                "page" => "Pages/lh_create",
                "err" => "Mã lớp đã tồn tại"
            ]);
            return;
        }

        $ok = $m->insert($ma_lop, $ten_lop);

        if ($ok) {
            header("Location: " . BASE_URL . "/index.php?url=LophocController/index");
            exit;
        }

        $this->view("layout_admin", [
            "page" => "Pages/lh_create",
            "err" => "Không thể thêm lớp học"
        ]);
    }
}
