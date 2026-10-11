<?php

class LophocController extends Controller
{
    public function index()
    {
        $m = $this->model("Lophoc_m");

        $rows = $m->getAll();

        $this->view("layout_admin", [
            "page" => "Pages/lh_list",
            "rows" => $rows
        ]);
    }


    public function create()
    {
        $this->view("layout_admin", [
            "page" => "Pages/lh_create"
        ]);
    }


    public function store()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header(
                "Location: " .
                BASE_URL .
                "/index.php?url=LophocController/index"
            );
            exit;
        }

        $ma = trim($_POST["ma_lop"] ?? "");
        $ten = trim($_POST["ten_lop"] ?? "");
        $trangthai = (int) ($_POST["trangthai"] ?? 1);

        if ($ma === "" || $ten === "") {
            die("Vui lòng nhập mã lớp và tên lớp.");
        }

        $m = $this->model("Lophoc_m");

        if ($m->existsMaLop($ma)) {
            die("Mã lớp đã tồn tại.");
        }

        $nguoi_tao = "Admin";

        $m->insert(
            $ma,
            $ten,
            $trangthai,
            $nguoi_tao
        );

        header(
            "Location: " .
            BASE_URL .
            "/index.php?url=LophocController/index"
        );

        exit;
    }
}