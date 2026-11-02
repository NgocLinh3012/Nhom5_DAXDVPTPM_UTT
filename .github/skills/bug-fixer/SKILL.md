---
name: bug-fixer
description: Phát hiện, phân tích và sửa lỗi PHP, HTML, CSS và logic trong dự án hệ thống thi trắc nghiệm PHP MVC. Sử dụng khi người dùng yêu cầu kiểm tra hoặc khắc phục lỗi chương trình.
---
# Bug Fixer – PHP MVC

## Mục tiêu
Giúp phát hiện nguyên nhân và khắc phục lỗi trong hệ thống thi trắc nghiệm PHP MVC.

## Quy trình

1. Xác định lỗi người dùng mô tả.
2. Tìm Controller, Model và View liên quan.
3. Đọc code thực tế để xác định nguyên nhân.
4. Giải thích nguyên nhân bằng tiếng Việt.
5. Đề xuất cách sửa ít thay đổi nhất.
6. Chỉ chỉnh sửa khi người dùng đã yêu cầu sửa.
7. Kiểm tra cú pháp và chức năng sau khi sửa.
8. Báo cáo kết quả và các vấn đề chưa kiểm thử.

## Nguyên tắc

- Không sửa file ngoài phạm vi chức năng được giao.
- Không tự ý sửa cấu trúc database.
- Không xóa dữ liệu thật.
- Không thay đổi chức năng đang hoạt động nếu không cần thiết.
- Giữ nguyên kiến trúc PHP MVC.
- Sử dụng PDO prepared statements cho truy vấn có dữ liệu đầu vào.
- Escape dữ liệu khi hiển thị HTML.
- Kiểm tra phân quyền và CSRF cho thao tác thay đổi dữ liệu.
- Không tự ý commit, push hoặc merge Git.

## Kiểm thử

- Kiểm tra cú pháp PHP bằng php -l.
- Kiểm tra lỗi PHP và HTML.
- Kiểm tra dữ liệu NULL và dữ liệu không hợp lệ.
- Kiểm tra lại chức năng liên quan.
- Ghi nhận những bước chưa kiểm thử được.

## Kết quả đầu ra

1. Mô tả lỗi.
2. Nguyên nhân.
3. File và hàm liên quan.
4. Nội dung đã sửa.
5. Kết quả kiểm thử PASS/FAIL.
6. Những rủi ro hoặc việc cần kiểm tra thêm.

Trình bày bằng tiếng Việt, dễ hiểu.
