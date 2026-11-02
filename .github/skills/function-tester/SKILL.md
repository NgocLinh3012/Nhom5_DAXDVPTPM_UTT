---
name: function-tester
description: Kiểm thử chức năng của hệ thống thi trắc nghiệm PHP MVC. Sử dụng khi cần tạo test case, kiểm tra cú pháp, dữ liệu đầu vào, phân quyền và đánh giá kết quả PASS/FAIL.
---

# Function Tester – PHP MVC

## Mục tiêu

Hỗ trợ kiểm tra và đánh giá chất lượng các chức năng trong hệ thống thi trắc nghiệm PHP MVC.

## Quy trình thực hiện

### 1. Xác định chức năng
- Xác định chức năng cần kiểm thử.
- Tìm Controller, Model và View liên quan.
- Đọc mã nguồn thực tế trước khi kiểm thử.

### 2. Tạo test case
Tạo các trường hợp kiểm thử gồm:
- Thao tác hợp lệ.
- Dữ liệu để trống.
- Dữ liệu sai định dạng.
- Dữ liệu trùng lặp.
- ID không hợp lệ.
- Người dùng không có quyền.
- Các trường hợp bảo mật liên quan.

### 3. Kiểm tra chương trình
- Kiểm tra cú pháp PHP bằng php -l.
- Kiểm tra Controller và Model.
- Kiểm tra phương thức GET/POST.
- Kiểm tra validate dữ liệu.
- Kiểm tra phân quyền.
- Kiểm tra CSRF nếu có thao tác thay đổi dữ liệu.
- Kiểm tra lỗi liên quan đến database.

### 4. Đánh giá kết quả
Phân loại kết quả:

- PASS: Đã kiểm tra và đạt yêu cầu.
- FAIL: Đã kiểm tra và phát hiện lỗi.
- NOT TESTED: Chưa đủ điều kiện hoặc chưa chạy kiểm thử.

Phải phân biệt kiểm tra mã nguồn với kiểm thử thực tế.

### 5. Báo cáo
Tạo bảng gồm:
- Mã test case.
- Chức năng.
- Dữ liệu hoặc thao tác kiểm thử.
- Kết quả mong đợi.
- Kết quả thực tế.
- Trạng thái PASS/FAIL/NOT TESTED.
- Bằng chứng.

## Quy tắc

- Không tự ý sửa code.
- Không tự ý sửa cấu trúc database.
- Không xóa hoặc cập nhật dữ liệu thật.
- Không tự ý commit hoặc push Git.
- Không chạy kiểm thử có nguy cơ làm mất dữ liệu.
- Chỉ kiểm thử thao tác ghi dữ liệu khi có môi trường test an toàn và được người dùng cho phép.
- Không tự nhận PASS nếu chưa có bằng chứng kiểm tra.
- Nếu không thể chạy kiểm thử, ghi NOT TESTED và giải thích lý do.
- Ưu tiên kiểm thử các chức năng của thành viên 4.

## Kết quả đầu ra

1. Tên chức năng được kiểm thử.
2. Danh sách file liên quan.
3. Bảng test case.
4. Kết quả kiểm tra cú pháp PHP.
5. Kết quả kiểm tra bảo mật.
6. Tổng số PASS, FAIL và NOT TESTED.
7. Đề xuất khắc phục lỗi.

Trình bày bằng tiếng Việt, rõ ràng và dễ hiểu.
