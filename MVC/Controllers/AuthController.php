<?php

class AuthController extends Controller
{
    public function login()
    {
        $this->view("layout_login", [
            "page" => "Pages/login",
            "err" => ($_SESSION["err"] ?? "")
        ]);
        unset($_SESSION["err"]);
    }

    public function doLogin()
    {
        $u = trim($_POST["username"] ?? "");
        $p = $_POST["password"] ?? "";

        if ($u === "" || $p === "") {
            $_SESSION["err"] = "Vui lòng nhập đầy đủ tài khoản và mật khẩu!";
            header("Location: " . BASE_URL . "/index.php?url=AuthController/login");
            exit;
        }

        // 1. Kiểm tra tài khoản User (Admin / Giảng viên)
        $mUser = $this->model("User_m");
        $user = $mUser->findByUsername($u);

        if ($user) {
            $dbPass = $user["password_hash"];
            $ok = false;

            if (is_string($dbPass) && strlen($dbPass) > 20 && strpos($dbPass, '$2y$') === 0) {
                if (password_verify($p, $dbPass)) {
                    $ok = true;
                }
            } else {
                if ($p === $dbPass) {
                    $ok = true;
                }
            }

            if (!$ok) {
                $_SESSION["err"] = "Sai tài khoản hoặc mật khẩu!";
                header("Location: " . BASE_URL . "/index.php?url=AuthController/login");
                exit;
            }

            if ((int) ($user["trangthai"] ?? 1) !== 1) {
                $_SESSION["err"] = "Tài khoản đang bị khóa!";
                header("Location: " . BASE_URL . "/index.php?url=AuthController/login");
                exit;
            }

            $_SESSION["user"] = [
                "id" => $user["id"],
                "hoten" => $user["hoten"],
                "username" => $user["username"],
                "role" => $user["role"] ?? "admin"
            ];

            // Điều hướng theo phân quyền
            if (($_SESSION["user"]["role"] ?? "admin") === "gv") {
                if (file_exists(__DIR__ . "/PhongthiController.php")) {
                    header("Location: " . BASE_URL . "/index.php?url=PhongthiController/index");
                } else {
                    header("Location: " . BASE_URL . "/index.php?url=LophocController/index");
                }
            } else {
                if (file_exists(__DIR__ . "/DashboardController.php")) {
                    header("Location: " . BASE_URL . "/index.php?url=DashboardController/index");
                } else {
                    header("Location: " . BASE_URL . "/index.php?url=LophocController/index");
                }
            }
            exit;
        }

        // 2. Kiểm tra tài khoản Học viên
        if (file_exists(__DIR__ . "/../Models/Hocvien_m.php")) {
            $mhvModel = $this->model("Hocvien_m");
            $hv = method_exists($mhvModel, 'findByMaHV') ? $mhvModel->findByMaHV($u) : null;

            if ($hv) {
                $dbPassHV = $hv["password_hash"] ?? ($hv["matkhau"] ?? "");
                $okHV = false;

                if (is_string($dbPassHV) && strlen($dbPassHV) > 20 && strpos($dbPassHV, '$2y$') === 0) {
                    if (password_verify($p, $dbPassHV)) {
                        $okHV = true;
                    }
                } else {
                    if ($p === $dbPassHV) {
                        $okHV = true;
                    }
                }

                if (!$okHV) {
                    $_SESSION["err"] = "Sai tài khoản hoặc mật khẩu!";
                    header("Location: " . BASE_URL . "/index.php?url=AuthController/login");
                    exit;
                }

                if ((int) ($hv["trangthai"] ?? 1) !== 1) {
                    $_SESSION["err"] = "Tài khoản học viên đang bị khóa!";
                    header("Location: " . BASE_URL . "/index.php?url=AuthController/login");
                    exit;
                }

                $_SESSION["hv"] = [
                    "id" => $hv["id"],
                    "hoten" => $hv["hoten"] ?? ($hv["tenhv"] ?? ""),
                    "ma_hv" => $hv["ma_hv"] ?? ($hv["mahv"] ?? $u),
                    "lop_id" => $hv["lop_id"] ?? ($hv["malop"] ?? 0)
                ];

                if (file_exists(__DIR__ . "/HocvienController.php")) {
                    header("Location: " . BASE_URL . "/index.php?url=HocvienController/phongthi");
                } else {
                    header("Location: " . BASE_URL . "/index.php?url=LophocController/index");
                }
                exit;
            }
        }

        $_SESSION["err"] = "Sai tài khoản hoặc mật khẩu!";
        header("Location: " . BASE_URL . "/index.php?url=AuthController/login");
        exit;
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        header("Location: " . BASE_URL . "/index.php?url=AuthController/login");
        exit;
    }
}
