# 🎓 Hệ thống Thi Trắc Nghiệm — Bộ Khung Nhóm

> **PHP MVC thuần + MySQL + Docker**  
> Mỗi thành viên đảm nhiệm **1 module độc lập**, làm việc song song không conflict.

---

## 📋 Bảng phân công

| TV | Module | Controller | Model | Views (Pages/) |
|---|---|---|---|---|
| **TV1** | Auth & Dashboard | `AuthController` `DashboardController` `TaikhoanController` | `User_m` | `login` `dashboard` `tk_*` |
| **TV2** | Ngân hàng Câu hỏi | `CauhoiController` | `Cauhoi_m` | `ch_*` |
| **TV3** | Đề thi & Môn thi | `DethiController` `MonthiController` | `Dethi_m` `Monthi_m` | `dt_*` `mt_*` |
| **TV4** | Phòng thi & Giám sát | `PhongthiController` `LophocController` `HocvienAdminController` | `Phongthi_m` `Lophoc_m` `Hocvien_m` | `pt_*` `lh_*` `hv_list` `hv_create` `hv_edit` |
| **TV5** | Làm bài thi (HV) | `HocvienController` | `LamBai_m` | `hv_phong_list` `hv_confirm` `hv_do` `hv_result` `hv_history` |

---

## ⚠️ Quy tắc KHÔNG được vi phạm

```
1. CHỈ sửa file trong danh sách module của mình.
2. KHÔNG sửa bất kỳ file nào trong Core/ hoặc Views/layout_*.php.
3. KHÔNG sửa file Model của TV khác — chỉ được GỌI method.
4. KHÔNG sửa thitracnghiem.sql, Dockerfile, docker-compose.yml.
5. Commit nhỏ & thường xuyên với message rõ ràng.
```

---

## 🔗 Phụ thuộc giữa các module (chỉ gọi, không sửa)

```
TV2 (Câu hỏi) ──gọi──▶ Monthi_m      (TV3 sở hữu)
TV3 (Đề thi)  ──gọi──▶ Cauhoi_m      (TV2 sở hữu)  → method: getByMonAndLoai()
TV4 (Phòng)   ──gọi──▶ Monthi_m      (TV3 sở hữu)  → method: getAll()
               ──gọi──▶ Dethi_m       (TV3 sở hữu)  → method: find(), list()
               ──gọi──▶ LamBai_m      (TV5 sở hữu)  → method: getPhongStatus(), finishExam(), updatePhongHVAfterSubmit()
TV5 (Làm bài) ──gọi──▶ Phongthi_m    (TV4 sở hữu)  → method: getViPhamStatus()
               ──gọi──▶ Lophoc_m      (TV4 sở hữu)  → method: find()
TV1 (Auth)    ──gọi──▶ Hocvien_m     (TV4 sở hữu)  → method: findByMaHV()
```

> Các method được đánh dấu `← TV* GỌI` trong stub file đã có sẵn signature đúng, chỉ cần implement.

---

## 🚀 Hướng dẫn bắt đầu nhanh

### Bước 1 — Clone repo

```bash
git clone <REMOTE_URL>
cd thitracnghiem-skeleton
```

### Bước 2 — Tạo branch của mình

```bash
# Thay tv2-cauhoi bằng tên module của bạn
git checkout -b feature/tv2-cauhoi
```

### Bước 3 — Khởi động môi trường Docker

```bash
docker compose up -d
```

Sau khi xong, truy cập:
- 🌐 **App**: http://localhost:8080/thitracnghiem/public/
- 🗄️ **phpMyAdmin**: http://localhost:8081

> Database (`thitracnghiem.sql`) tự động được import khi container MySQL khởi động lần đầu.

### Bước 4 — Làm việc

```bash
# Chỉ sửa file trong phạm vi module của mình
# Xem phần "Bảng phân công" và "Việc cần làm" bên dưới
```

Thay đổi code → **refresh trình duyệt** là thấy ngay (không cần restart Docker, vì volume mount trực tiếp).

### Bước 5 — Commit và Push

```bash
git add MVC/Controllers/CauhoiController.php  # chỉ add file của mình
git commit -m "feat(cauhoi): implement danh sách câu hỏi"
git push origin feature/tv2-cauhoi
```

### Bước 6 — Đồng bộ với main hàng ngày

```bash
git fetch origin
git rebase origin/main   # hoặc git merge origin/main
```

---

## 📌 Việc cần làm theo từng TV

### TV1 — Auth & Dashboard

**File:** `AuthController.php`, `DashboardController.php`, `TaikhoanController.php`, `User_m.php`  
**Views:** `login.php`, `dashboard.php`, `tk_list/create/edit.php`

- [x] Đăng nhập Admin/GV/Học viên (đã hoàn chỉnh)
- [x] Phân quyền 3 role: admin, gv, hv (đã hoàn chỉnh)
- [ ] Dashboard: hiển thị thống kê (số HV, lớp, môn, đề, câu hỏi, phòng thi)
- [ ] Quản lý tài khoản Admin/GV: danh sách, thêm, sửa, đổi mật khẩu, khóa

> ✅ **TV1 làm trước tiên** — sau khi đăng nhập hoạt động mới push lên main để TV khác clone.

---

### TV2 — Ngân hàng Câu hỏi

**File:** `CauhoiController.php`, `Cauhoi_m.php`  
**Views:** `ch_list.php`, `ch_create.php`, `ch_edit.php`

- [ ] `index()` — Danh sách câu hỏi: lọc theo môn, tìm kiếm từ khóa, phân trang 50/trang
- [ ] `create()` + `store()` — Form thêm câu hỏi (4 đáp án A/B/C/D, loại D/TB/K, giải thích)
- [ ] `edit($id)` + `update()` — Sửa câu hỏi
- [ ] `delete($id)` — Xóa câu hỏi
- [ ] `import()` — Import từ file CSV
- [ ] `template()` — Xuất file CSV mẫu (đã có stub)
- [ ] `Cauhoi_m::getByMonAndLoai($mon_id, $loai, $limit)` — **Bắt buộc implement**, TV3 gọi method này

**Schema bảng `cau_hoi`:**
```sql
id, mon_id, noi_dung, a, b, c, d, dap_an_dung, diem, giai_thich, loai (D/TB/K), kich_hoat, created_at
```

---

### TV3 — Đề thi & Môn thi

**File:** `DethiController.php`, `MonthiController.php`, `Dethi_m.php`, `Monthi_m.php`  
**Views:** `dt_list.php`, `dt_edit.php`, `mt_list.php`, `mt_edit.php`

- [ ] **Monthi:** CRUD môn thi (danh sách, thêm inline, sửa, xóa)
- [ ] `Monthi_m::getAll()` — **Bắt buộc implement**, TV2 & TV4 gọi method này
- [ ] **Dethi:** Danh sách đề thi, lọc theo môn
- [ ] `store()` — Tạo đề: chọn ngẫu nhiên N câu theo loại từ ngân hàng (gọi `Cauhoi_m::getByMonAndLoai()`)
- [ ] `delete($id)` — Xóa đề và dữ liệu liên quan
- [ ] `import()` — Import đề thi từ CSV
- [ ] `template()` — Xuất file CSV mẫu

**Schema bảng `de_thi`:**
```sql
id, ma_de, ten_de, thoi_gian (phút), mon_id, cau_de, cau_tb, cau_kho
```

---

### TV4 — Phòng thi & Giám sát

**File:** `PhongthiController.php`, `LophocController.php`, `HocvienAdminController.php`  
**Models:** `Phongthi_m.php`, `Lophoc_m.php`, `Hocvien_m.php`  
**Views:** `pt_*`, `lh_*`, `hv_list/create/edit.php`

- [ ] **Lớp học:** CRUD (danh sách, thêm, sửa, khóa/mở)
- [ ] **Học viên (admin):** Danh sách, thêm, sửa, xóa, import CSV
- [ ] `Hocvien_m::findByMaHV($ma)` — **Bắt buộc implement**, TV1 gọi khi đăng nhập HV
- [ ] **Phòng thi:** Tạo/Sửa/Xóa phòng (gắn lớp + đề + giờ bắt đầu), tự thêm HV vào phòng
- [ ] `vaoPhong($id)` — Quản lý HV trong phòng: kích hoạt, khóa, vi phạm, reset, hủy bài, ghi chú
- [ ] `monitor($id)` — Màn hình giám sát real-time
- [ ] `exportExcel($id)` — Xuất kết quả CSV
- [ ] `Phongthi_m::getViPhamStatus()` — **Bắt buộc implement**, TV5 gọi khi làm bài
- [ ] `Phongthi_m::tangViPham()` — TV5 gọi khi chuyển tab

**Schema bảng `phong_thi`:**
```sql
id, ma_phong, ten_phong, mon_id, de_id, lop_id, bat_dau, nguoi_tao, trangthai
```

---

### TV5 — Làm bài thi (Học viên)

**File:** `HocvienController.php`, `LamBai_m.php`  
**Views:** `hv_phong_list.php`, `hv_confirm.php`, `hv_do.php`, `hv_result.php`, `hv_history.php`

- [ ] `phongthi()` — Xem danh sách phòng được phân công + trạng thái
- [ ] `confirm($id)` — Trang xác nhận trước khi thi (kiểm tra giờ, kích hoạt, lớp)
- [ ] `start()` — Tạo bài làm, chọn câu hỏi ngẫu nhiên từ đề
- [ ] `do($id)` — Giao diện làm bài: hiển thị câu hỏi, đồng hồ đếm ngược
- [ ] `saveAnswer()` — AJAX lưu đáp án từng câu (không reload trang)
- [ ] `markReview()` — AJAX đánh dấu câu cần xem lại
- [ ] `saveViolation()` — AJAX ghi nhận chuyển tab/rời màn hình
- [ ] `submit()` — Nộp bài và chấm điểm
- [ ] `result($id)` — Trang kết quả: điểm số, đáp án đúng/sai, giải thích
- [ ] `history()` — Lịch sử thi
- [ ] `LamBai_m::getPhongStatus($phong_id)` — **Bắt buộc implement**, TV4 gọi trong monitor
- [ ] `LamBai_m::finishExam($id)` + `updatePhongHVAfterSubmit()` — TV4 gọi khi thu bài

**Schema bảng `bai_lam`:**
```sql
id, phong_id, hocvien_id, de_id, so_cau, so_dung, diem, status (Doing/Done), start_at, end_at
```

---

## 📁 Cấu trúc thư mục

```
thitracnghiem-skeleton/
├── Core/                      ← 🔒 KHÔNG SỬA (TV1 setup)
│   ├── App.php                  Router
│   ├── Auth.php                 Helper xác thực
│   ├── Controller.php           Base class
│   ├── Database.php             Kết nối PDO
│   └── config.php               Cấu hình (env-based)
├── MVC/
│   ├── Controllers/
│   │   ├── AuthController.php       TV1 ✅
│   │   ├── DashboardController.php  TV1
│   │   ├── TaikhoanController.php   TV1
│   │   ├── CauhoiController.php     TV2 🚧
│   │   ├── MonthiController.php     TV3 🚧
│   │   ├── DethiController.php      TV3 🚧
│   │   ├── LophocController.php     TV4 🚧
│   │   ├── HocvienAdminController.php TV4 🚧
│   │   ├── PhongthiController.php   TV4 🚧
│   │   └── HocvienController.php    TV5 🚧
│   ├── Models/
│   │   ├── User_m.php           TV1 ✅
│   │   ├── Cauhoi_m.php         TV2 🚧
│   │   ├── Dethi_m.php          TV3 🚧
│   │   ├── Monthi_m.php         TV3 🚧
│   │   ├── Lophoc_m.php         TV4 🚧
│   │   ├── Hocvien_m.php        TV4 🚧
│   │   ├── Phongthi_m.php       TV4 🚧
│   │   └── LamBai_m.php         TV5 🚧
│   └── Views/
│       ├── layout_admin.php     🔒 KHÔNG SỬA
│       ├── layout_hv.php        🔒 KHÔNG SỬA
│       ├── layout_hv_blank.php  🔒 KHÔNG SỬA
│       ├── layout_login.php     🔒 KHÔNG SỬA
│       └── Pages/               (mỗi TV sửa file của mình)
├── public/
│   ├── index.php                🔒 KHÔNG SỬA
│   └── assets/
├── thitracnghiem.sql            🔒 KHÔNG SỬA
├── composer.json
├── Dockerfile                   🔒 KHÔNG SỬA
├── docker-compose.yml           🔒 KHÔNG SỬA
└── README.md                    (có thể cập nhật ghi chú)
```

---

## 🌿 Git workflow

### Branch naming
```
feature/tv1-auth-dashboard
feature/tv2-cauhoi
feature/tv3-dethi-monthi
feature/tv4-phongthi-giasat
feature/tv5-lambaithi
```

### Commit message format
```
feat(cauhoi): thêm chức năng import CSV
fix(phongthi): sửa lỗi kích hoạt học viên
refactor(lambai): tối ưu query chọn câu hỏi
```

### Flow chuẩn mỗi ngày
```bash
# 1. Sync với main
git fetch origin
git rebase origin/main

# 2. Làm việc
# ... code ...

# 3. Commit thường xuyên (mỗi chức năng nhỏ = 1 commit)
git add <file của mình>
git commit -m "feat(module): mô tả ngắn"

# 4. Push lên remote
git push origin feature/tv2-cauhoi

# 5. Tạo Pull Request → nhờ TV1 merge vào main
```

---

## 🔑 Tài khoản mặc định (từ thitracnghiem.sql)

| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `123456` (hoặc xem trong SQL) |
| Giáo viên | `gv` | `123456` |
| Học viên | mã HV | mã HV (hoặc xem trong SQL) |

> Kiểm tra trong bảng `users` và `hoc_vien` qua phpMyAdmin: http://localhost:8081
