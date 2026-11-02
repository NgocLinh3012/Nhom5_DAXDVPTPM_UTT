
<?php
$rows = $data["rows"] ?? [];
$mons = $data["mons"] ?? [];
$mon_id = (int) ($data["mon_id"] ?? 0);
$q = $data["q"] ?? "";
?>

<div class="page-head compact">
    <div class="page-title">QUẢN LÝ CÂU HỎI</div>
</div>

<div class="box">
    <table class="tbl">
        <thead>
            <tr>
                <th>STT</th>
                <th>Môn thi</th>
                <th>Câu hỏi</th>
                <th>A</th>
                <th>B</th>
                <th>C</th>
                <th>D</th>
                <th>Đáp án đúng</th>
                <th>Điểm</th>
                <th>Loại</th>
                <th>Kích hoạt</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $i => $r): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($r["ten_mon"] ?? "") ?></td>
                    <td><?= htmlspecialchars($r["noi_dung"]) ?></td>
                    <td><?= htmlspecialchars($r["dap_an_a"]) ?></td>
                    <td><?= htmlspecialchars($r["dap_an_b"]) ?></td>
                    <td><?= htmlspecialchars($r["dap_an_c"]) ?></td>
                    <td><?= htmlspecialchars($r["dap_an_d"]) ?></td>
                    <td><?= htmlspecialchars($r["dap_an_dung"]) ?></td>
                    <td><?= (int) $r["diem"] ?></td>
                    <td><?= htmlspecialchars($r["loai"] ?? "") ?></td>
                    <td><?= (int) $r["kich_hoat"] === 1 ? "Yes" : "No" ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
