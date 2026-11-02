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

    }
