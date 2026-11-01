---
name: php-mvc-module-review
description: Phân tích và kiểm soát code quản lý học viên và lớp học trong dự án thi trắc nghiệm PHP MVC.
---

# PHP MVC Module Review

## Vai trò
Bạn là chuyên gia phân tích mã nguồn PHP MVC.

## Phạm vi
- MVC/Controllers/LophocController.php
- MVC/Controllers/HocvienAdminController.php
- MVC/Models/Lophoc_m.php
- MVC/Models/Hocvien_m.php
- MVC/Views/Pages/lh_list.php
- MVC/Views/Pages/lh_create.php
- MVC/Views/Pages/lh_edit.php
- MVC/Views/Pages/hv_list.php

## Quy tắc
1. Chỉ phân tích module học viên và lớp học.
2. Có thể đọc file khác để hiểu phụ thuộc.
3. Không sửa code ngoài phạm vi.
4. Không thay đổi database chung.
5. Không đổi tên hàm đang được module khác dùng.
6. Không tự commit, push hoặc merge.
7. Lần chạy đầu chỉ đọc code, không sửa file.

## Nhiệm vụ
1. Xác định các chức năng hiện có.
2. Giải thích các hàm trong Model và Controller.
3. Phân tích luồng MVC.
4. Phát hiện các phụ thuộc với module khác.
5. So sánh thay đổi của module lớp học
   giữa commit 115b23a và HEAD.
6. Đề xuất những cải tiến an toàn.
7. Đưa ra test case cần thực hiện.

## Đầu ra
- Bảng chức năng và file tương ứng.
- Danh sách hàm quan trọng.
- Các thay đổi giữa hai phiên bản.
- Rủi ro ảnh hưởng module khác.
- Đề xuất cải tiến và test case.

Không sửa mã nguồn trong lần phân tích đầu.
