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

    $mon_id = (int) ($_GET["mon_id"] ?? 0);
    $q = trim($_GET["q"] ?? "");

    $mons = $this->model("Monthi_m")->getAll();

    $page = max(1, (int) ($_GET["page"] ?? 1));
    $limit = 50;
    $offset = ($page - 1) * $limit;

    $m = $this->model("Cauhoi_m");
    $rows = $m->list($mon_id, $q, $offset);
    $total = $m->count($mon_id, $q);
    $totalPages = (int) ceil($total / $limit);

    $this->view("layout_admin", [
        "page" => "Pages/ch_list",
        "rows" => $rows,
        "mons" => $mons,
        "mon_id" => $mon_id,
        "q" => $q,
        "currPage" => $page,
        "totalPages" => $totalPages,
        "limit" => $limit,
        "total" => $total,
        "msg" => $this->getFlash("msg"),
        "err" => $this->getFlash("err"),
    ]);
}

public function create()
{
    $this->needAdmin();

    $mons = $this->model("Monthi_m")->getAll();

    $this->view("layout_admin", [
        "page" => "Pages/ch_create",
        "mons" => $mons,
        "err" => $this->getFlash("err"),
    ]);
}

public function store()
{
    $this->needAdmin();

    $mon_id = (int) ($_POST["mon_id"] ?? 0);
    $nd = trim($_POST["noi_dung"] ?? "");
    $a = trim($_POST["a"] ?? "");
    $b = trim($_POST["b"] ?? "");
    $c = trim($_POST["c"] ?? "");
    $d = trim($_POST["d"] ?? "");
    $dad = strtoupper(trim($_POST["dap_an_dung"] ?? "A"));
    $diem = (int) ($_POST["diem"] ?? 1);
    $gt = trim($_POST["giai_thich"] ?? "");
    $loai = trim($_POST["loai"] ?? "D");
    $kich = (int) ($_POST["kich_hoat"] ?? 1);

    if ($mon_id <= 0 || $nd === "" ||
        $a === "" || $b === "" || $c === "" || $d === "") {

        $this->flash("err", "Vui lòng nhập đủ dữ liệu câu hỏi!");

        header("Location: " . BASE_URL .
            "/index.php?url=CauhoiController/create");
        exit;
    }

    if (!in_array($dad, ["A", "B", "C", "D"])) {
        $dad = "A";
    }

    $this->model("Cauhoi_m")->insert(
        $mon_id, $nd, $a, $b, $c, $d,
        $dad, $diem, $gt, $loai, $kich
    );

    $this->flash("msg", "Đã thêm câu hỏi!");

    header("Location: " . BASE_URL .
        "/index.php?url=CauhoiController/index&mon_id=" . $mon_id);
    exit;
}

    }
