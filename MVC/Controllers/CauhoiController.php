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

public function edit($id)
{
    $this->needAdmin();

    $mons = $this->model("Monthi_m")->getAll();
    $ch = $this->model("Cauhoi_m")->find((int) $id);

    if (!$ch) {
        die("Không tìm thấy câu hỏi!");
    }

    $this->view("layout_admin", [
        "page" => "Pages/ch_edit",
        "mons" => $mons,
        "ch" => $ch,
        "err" => $this->getFlash("err"),
    ]);
}

public function update()
{
    $this->needAdmin();

    $id = (int) ($_POST["id"] ?? 0);
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

    if ($id <= 0 || $mon_id <= 0 || $nd === "" ||
        $a === "" || $b === "" || $c === "" || $d === "") {

        $this->flash("err", "Không được để trống!");

        header("Location: " . BASE_URL .
            "/index.php?url=CauhoiController/edit/" . $id);
        exit;
    }

    if (!in_array($dad, ["A", "B", "C", "D"], true)) {
        $dad = "A";
    }

    $this->model("Cauhoi_m")->updateBasic(
        $id, $mon_id, $nd, $a, $b, $c, $d,
        $dad, $diem, $gt, $loai, $kich
    );

    $this->flash("msg", "Đã cập nhật câu hỏi!");

    header("Location: " . BASE_URL .
        "/index.php?url=CauhoiController/index&mon_id=" . $mon_id);
    exit;
}
public function delete()
{
    $this->needAdmin();

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        http_response_code(405);
        exit("Phương thức không hợp lệ!");
    }

    $id = (int) ($_POST["id"] ?? 0);

    if ($id <= 0) {
        $this->flash("err", "ID câu hỏi không hợp lệ!");
    } else {
        $m = $this->model("Cauhoi_m");
        $ch = $m->find($id);

        if (!$ch) {
            $this->flash("err", "Không tìm thấy câu hỏi!");
        } else {
            try {
                $m->delete($id);
                $this->flash("msg", "Đã xóa câu hỏi!");
            } catch (PDOException $e) {
                $this->flash(
                    "err",
                    "Không thể xóa câu hỏi vì có dữ liệu liên quan!"
                );
            }
        }
    }

    header("Location: " . BASE_URL .
        "/index.php?url=CauhoiController/index");
    exit;
}
    }
