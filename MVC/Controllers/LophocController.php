<?php
/**
 * MODULE: Lớp học | THÀNH VIÊN: TV4
 * Xem README.md → Mục TV4 để biết chi tiết việc cần làm.
 */
class LophocController extends Controller
{
    public function index()
    {
        $this->needAdmin();

        try {
            $lopHocModel = $this->model("Lophoc_m");
            $lopHoc = $lopHocModel->getAll();
            $this->view("layout_admin", [
                "page" => "Pages/lh_list",
                "lop_hoc" => $lopHoc,
                "msg" => $this->getFlash("msg"),
                "err" => $this->getFlash("err"),
            ]);
        } catch (PDOException $e) {
            $this->view("layout_admin", [
                "page" => "Pages/lh_list",
                "lop_hoc" => [],
                "err" => "Không thể tải danh sách lớp học.",
            ]);
        }
    }

    public function create()
    {
        $this->needAdmin();
        $this->ensureCsrfToken();

        $this->view("layout_admin", [
            "page" => "Pages/lh_create",
            "csrf_token" => $_SESSION["lop_hoc_csrf_token"],
            "old" => [],
            "errors" => [],
        ]);
    }

    public function store()
    {
        $this->needAdmin();

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            http_response_code(405);
            header("Allow: POST");
            exit;
        }

        if (!$this->validateCsrfToken($_POST["csrf_token"] ?? null)) {
            http_response_code(403);
            exit("Yêu cầu không hợp lệ.");
        }

        $maLop = trim((string) ($_POST["ma_lop"] ?? ""));
        $tenLop = trim((string) ($_POST["ten_lop"] ?? ""));
        $trangthai = (string) ($_POST["trangthai"] ?? "1");
        $old = [
            "ma_lop" => $maLop,
            "ten_lop" => $tenLop,
            "trangthai" => $trangthai,
        ];
        $errors = [];

        if ($maLop === "") {
            $errors["ma_lop"] = "Mã lớp không được để trống.";
        } elseif ($this->textLength($maLop) > 20) {
            $errors["ma_lop"] = "Mã lớp không được vượt quá 20 ký tự.";
        }

        if ($tenLop === "") {
            $errors["ten_lop"] = "Tên lớp không được để trống.";
        } elseif ($this->textLength($tenLop) > 100) {
            $errors["ten_lop"] = "Tên lớp không được vượt quá 100 ký tự.";
        }

        if (!in_array($trangthai, ["0", "1"], true)) {
            $errors["trangthai"] = "Trạng thái không hợp lệ.";
        }

        try {
            $lopHocModel = $this->model("Lophoc_m");

            if (!isset($errors["ma_lop"]) && $lopHocModel->existsMa($maLop, 0)) {
                $errors["ma_lop"] = "Mã lớp đã tồn tại.";
            }

            if (!empty($errors)) {
                $this->view("layout_admin", [
                    "page" => "Pages/lh_create",
                    "csrf_token" => $_SESSION["lop_hoc_csrf_token"],
                    "old" => $old,
                    "errors" => $errors,
                ]);
                return;
            }

            $lopHocModel->insert($maLop, $tenLop, (int) $trangthai);
            $this->flash("msg", "Thêm lớp học thành công.");
            header("Location: " . BASE_URL . "/index.php?url=LophocController/index");
            exit;
        } catch (PDOException $e) {
            $isDuplicate = $e->getCode() === "23000";
            if ($isDuplicate) {
                $errors["ma_lop"] = "Mã lớp đã tồn tại.";
            } else {
                $errors["general"] = "Không thể thêm lớp học. Vui lòng thử lại.";
            }

            $this->view("layout_admin", [
                "page" => "Pages/lh_create",
                "csrf_token" => $_SESSION["lop_hoc_csrf_token"],
                "old" => $old,
                "errors" => $errors,
            ]);
        }
    }

    public function edit($id)
    {
        $this->needAdmin();

        if (!is_string($id) && !is_int($id)) {
            $this->redirectToListWithError("ID lớp học không hợp lệ.");
            return;
        }

        $id = trim((string) $id);
        if (!ctype_digit($id) || (int) $id <= 0) {
            $this->redirectToListWithError("ID lớp học không hợp lệ.");
            return;
        }

        try {
            $lopHocModel = $this->model("Lophoc_m");
            $lopHoc = $lopHocModel->find((int) $id);
            if (!$lopHoc) {
                $this->redirectToListWithError("Không tìm thấy lớp học.");
                return;
            }

            $this->ensureCsrfToken();
            $this->view("layout_admin", [
                "page" => "Pages/lh_edit",
                "lop_hoc" => $lopHoc,
                "csrf_token" => $_SESSION["lop_hoc_csrf_token"],
                "old" => [],
                "errors" => [],
            ]);
        } catch (PDOException $e) {
            $this->redirectToListWithError("Không thể tải thông tin lớp học.");
        }
    }

    public function update()
    {
        $this->needAdmin();

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            http_response_code(405);
            header("Allow: POST");
            exit;
        }

        if (!$this->validateCsrfToken($_POST["csrf_token"] ?? null)) {
            http_response_code(403);
            exit("Yêu cầu không hợp lệ.");
        }

        $id = trim((string) ($_POST["id"] ?? ""));
        if (!ctype_digit($id) || (int) $id <= 0) {
            http_response_code(422);
            exit("ID lớp học không hợp lệ.");
        }

        $id = (int) $id;
        $maLop = trim((string) ($_POST["ma_lop"] ?? ""));
        $tenLop = trim((string) ($_POST["ten_lop"] ?? ""));
        $trangthai = (string) ($_POST["trangthai"] ?? "");
        $old = [
            "id" => $id,
            "ma_lop" => $maLop,
            "ten_lop" => $tenLop,
            "trangthai" => $trangthai,
        ];
        $errors = [];

        if ($maLop === "") {
            $errors["ma_lop"] = "Mã lớp không được để trống.";
        } elseif ($this->textLength($maLop) > 20) {
            $errors["ma_lop"] = "Mã lớp không được vượt quá 20 ký tự.";
        }

        if ($tenLop === "") {
            $errors["ten_lop"] = "Tên lớp không được để trống.";
        } elseif ($this->textLength($tenLop) > 100) {
            $errors["ten_lop"] = "Tên lớp không được vượt quá 100 ký tự.";
        }

        if (!in_array($trangthai, ["0", "1"], true)) {
            $errors["trangthai"] = "Trạng thái không hợp lệ.";
        }

        try {
            $lopHocModel = $this->model("Lophoc_m");
            $lopHoc = $lopHocModel->find($id);
            if (!$lopHoc) {
                $this->redirectToListWithError("Không tìm thấy lớp học.");
                return;
            }

            if (!isset($errors["ma_lop"]) && $lopHocModel->existsMa($maLop, $id)) {
                $errors["ma_lop"] = "Mã lớp đã tồn tại ở lớp học khác.";
            }

            if (!empty($errors)) {
                $this->view("layout_admin", [
                    "page" => "Pages/lh_edit",
                    "lop_hoc" => $lopHoc,
                    "csrf_token" => $_SESSION["lop_hoc_csrf_token"],
                    "old" => $old,
                    "errors" => $errors,
                ]);
                return;
            }

            $lopHocModel->update($id, $maLop, $tenLop, (int) $trangthai);
            $this->flash("msg", "Cập nhật lớp học thành công.");
            header("Location: " . BASE_URL . "/index.php?url=LophocController/index");
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === "23000") {
                $errors["ma_lop"] = "Mã lớp đã tồn tại ở lớp học khác.";
            } else {
                $errors["general"] = "Không thể cập nhật lớp học. Vui lòng thử lại.";
            }

            $this->view("layout_admin", [
                "page" => "Pages/lh_edit",
                "lop_hoc" => $lopHoc ?? [],
                "csrf_token" => $_SESSION["lop_hoc_csrf_token"],
                "old" => $old,
                "errors" => $errors,
            ]);
        }
    }

    public function delete($id){ $this->needAdmin(); }

    private function redirectToListWithError($message)
    {
        $this->flash("err", $message);
        header("Location: " . BASE_URL . "/index.php?url=LophocController/index");
        exit;
    }

    private function _todo($title, $tv)
    {
        echo "<div style='font-family:sans-serif;padding:3rem;text-align:center'>
              <h2>🚧 $title</h2><p>Đang được <strong>$tv</strong> phát triển.</p></div>";
    }

    private function ensureCsrfToken()
    {
        if (empty($_SESSION["lop_hoc_csrf_token"])) {
            $_SESSION["lop_hoc_csrf_token"] = bin2hex(random_bytes(32));
        }
    }

    private function validateCsrfToken($token)
    {
        $this->ensureCsrfToken();
        return is_string($token)
            && hash_equals($_SESSION["lop_hoc_csrf_token"], $token);
    }

    private function textLength($value)
    {
        return function_exists("mb_strlen")
            ? mb_strlen($value, "UTF-8")
            : strlen($value);
    }
}
