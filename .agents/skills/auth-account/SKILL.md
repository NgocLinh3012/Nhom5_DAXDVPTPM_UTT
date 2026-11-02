---
name: auth-account
description: "Phân tích, phát triển, rà soát và kiểm thử đăng nhập, đăng xuất, quản lý tài khoản, kiểm tra vai trò và quyền truy cập phiên trong dự án PHP MVC này. Dùng khi thay đổi AuthController, Auth, các hàm phân quyền của Controller, TaikhoanController, User_m, đăng nhập học viên hoặc quyền tài khoản."
---

# Xác thực và Quản lý Tài khoản

## Mục đích và Phạm vi

Sử dụng skill này cho các luồng xác thực và phân quyền trong `Nhom5_DAXDVPTPM_UTT`, bao gồm:

- Đăng nhập và đăng xuất tài khoản nhân sự.
- Đăng nhập học viên.
- Quản trị tài khoản người dùng: tạo, sửa, xóa, tìm kiếm, phân trang và nhập CSV.
- Kiểm tra vai trò và các action của controller được bảo vệ bằng session.
- Lỗi liên quan đến tài khoản bị khóa, chuyển hướng hoặc truy cập trang cần đăng nhập.

Không xem hồ sơ học viên và tài khoản nhân sự là cùng một loại tài khoản. Nghiệp vụ phòng thi, làm bài thi, quản lý học viên/lớp học và các module không liên quan nằm ngoài phạm vi, trừ khi yêu cầu trực tiếp liên quan đến xác thực hoặc quyền tài khoản.

## Cấu trúc riêng của dự án

Kiểm tra repository hiện tại trước khi giả định route, phương thức hoặc schema nào đó tồn tại:

- `Core/App.php` phân tích route dạng `index.php?url=Controller/action/...` và khởi tạo session.
- `Core/Controller.php` cung cấp `needLogin()`, `needAdmin()`, `needGV()` và `needHV()`.
- `Core/Auth.php` cung cấp các hàm session tĩnh được một số phần của ứng dụng sử dụng.
- `MVC/Controllers/AuthController.php` xử lý đăng nhập và đăng xuất.
- `MVC/Controllers/TaikhoanController.php` quản lý tài khoản nhân sự/người dùng.
- `MVC/Models/User_m.php` truy cập bảng `users`.
- `MVC/Models/Hocvien_m.php` tra cứu tài khoản học viên trong bảng `hoc_vien`.
- `MVC/Views/Pages/login.php` hiển thị biểu mẫu đăng nhập.

Luồng đăng nhập hiện tại sử dụng các session riêng biệt:

- Tài khoản nhân sự được lưu trong `$_SESSION["user"]`. `role` được dùng để kiểm tra quyền truy cập. Các vai trò hiện có gồm `admin` và `gv`.
- Tài khoản học viên được lưu trong `$_SESSION["hv"]` và được tra cứu bằng `ma_hv`; chúng không sử dụng bảng nhân sự `users`.
- Tài khoản nhân sự được chuyển hướng tùy theo vai trò; học viên được chuyển đến luồng phòng thi.
- Trạng thái tài khoản được lưu trong `trangthai`.
- Mật khẩu nhân sự mới được tạo bằng `password_hash(..., PASSWORD_BCRYPT)`. Luồng đăng nhập hiện tại cũng duy trì khả năng tương thích với mật khẩu dạng văn bản thuần cũ. Không âm thầm thay đổi hành vi có ảnh hưởng đến việc chuyển đổi dữ liệu này; hãy giải thích và kiểm thử mọi thay đổi được yêu cầu.

Đây là thông tin ghi nhận từ code hiện tại, không đảm bảo schema hoặc route trong tương lai sẽ giữ nguyên. Hãy xác minh schema và các nơi gọi liên quan trước khi chỉnh sửa.

## Quy trình bắt buộc

1. Kiểm tra `git status` và nhánh hiện tại; giữ nguyên mọi thay đổi sẵn có của người dùng.
2. Đọc controller, model, bộ điều phối route, hàm kiểm tra quyền, view và schema cơ sở dữ liệu có liên quan.
3. Lần theo toàn bộ luồng: biểu mẫu đăng nhập → action controller → tra cứu model → gán session → chuyển hướng; với action được bảo vệ, lần theo route đến hàm kiểm tra quyền.
4. Xác định thao tác liên quan đến tài khoản nhân sự (`users`) hay hồ sơ học viên (`hoc_vien`). Không dùng lẫn ID, thông tin đăng nhập hoặc khóa session giữa hai loại.
5. Thực hiện thay đổi nhỏ nhất để bảo đảm hành vi được yêu cầu ở phía máy chủ. Không xem việc ẩn liên kết hoặc nút trong view là biện pháp phân quyền.
6. Rà soát tất cả action liên quan, gồm các endpoint tạo/cập nhật/xóa/nhập/xuất/tải mẫu, để chính sách quyền được áp dụng nhất quán.
7. Chạy các bước kiểm tra hoặc test tập trung hiện có trong repository. Nêu rõ nội dung đã và chưa kiểm thử.

## Quy tắc triển khai và an toàn

- Tuân theo cấu trúc PHP MVC và quy ước route hiện có.
- Bảo vệ mọi action controller cần quyền bằng hàm kiểm tra phù hợp ở phía máy chủ. Dùng `needAdmin()` cho quản trị tài khoản chỉ dành cho quản trị viên; chỉ dùng vai trò khác khi nghiệp vụ hiện tại yêu cầu.
- Không mặc định vai trò gửi lên là hợp lệ hoặc được phép. Kiểm tra các lựa chọn vai trò và chính sách hiện hành trước khi thay đổi cách gán vai trò.
- Xác thực định danh, trường bắt buộc, giá trị trạng thái và quyền sở hữu tài khoản ở phía máy chủ.
- Dùng truy vấn SQL có tham số; tuân theo cách truy cập model/cơ sở dữ liệu hiện có.
- Escape dữ liệu do người dùng kiểm soát khi hiển thị HTML.
- Giữ riêng biệt ngữ cảnh session `user` và `hv` cùng hành vi đăng xuất/chuyển hướng của chúng, trừ khi tác vụ yêu cầu thay đổi rõ ràng.
- Không bao giờ ghi log, in ra, commit hoặc để lộ mật khẩu, ID session, bí mật hay dữ liệu tài khoản thật.
- Không tự thêm tính năng đặt lại mật khẩu, khóa tài khoản, CSRF, tái tạo session hoặc vai trò mới nếu chưa được yêu cầu và chưa xác nhận tính tương thích với dự án.
- Không thay đổi schema, hành vi dùng chung trong `Core/` hoặc file của module khác khi chưa xác nhận sự cần thiết và phạm vi.
- Hiển thị lỗi theo quy ước error/flash/redirect hiện có của dự án; không báo thành công nếu thao tác model thất bại.

## Danh sách kiểm tra xác minh

Kiểm tra các trường hợp phù hợp bằng tài khoản thử an toàn và cơ sở dữ liệu không dùng cho môi trường thật:

1. Thông tin đăng nhập nhân sự hợp lệ tạo session nhân sự và chuyển hướng đúng theo vai trò.
2. Thông tin đăng nhập học viên hợp lệ chỉ tạo session học viên và đưa người dùng đến luồng học viên.
3. Thông tin đăng nhập không hợp lệ và tài khoản bị khóa đều bị từ chối, không tiết lộ sai thông tin nào.
4. Yêu cầu chưa đăng nhập đến action được bảo vệ sẽ được chuyển hướng đến trang đăng nhập.
5. Tài khoản nhân sự không phải quản trị viên không thể truy cập action quản trị tài khoản, kể cả qua URL trực tiếp và endpoint thay đổi dữ liệu.
6. Quản trị viên thực hiện được các thao tác tài khoản được phép; dữ liệu không hợp lệ hoặc trùng lặp bị từ chối với thông báo rõ ràng.
7. Việc xóa tài khoản đang đăng nhập được xử lý theo cơ chế bảo vệ hiện có.
8. Đăng xuất xóa session tương ứng và không thể dùng session cũ để truy cập lại trang được bảo vệ.
9. Cách lưu mật khẩu và hành vi tương thích với thông tin xác thực cũ vẫn phù hợp với thay đổi được yêu cầu.

Không tuyên bố đã bao phủ kiểm thử bảo mật hoặc chức năng vượt quá các trường hợp thực tế đã chạy.

## Cách phản hồi

Trả lời bằng tiếng Việt, trừ khi người dùng yêu cầu ngôn ngữ khác. Tóm tắt:

- Hành vi xác thực/tài khoản đã thay đổi.
- Các file bị ảnh hưởng và lý do.
- Tác động đến phân quyền và xử lý thông tin đăng nhập.
- Các bài kiểm thử đã chạy và kết quả thực tế.
- Rủi ro chưa được giải quyết hoặc bước cần kiểm tra thủ công.
