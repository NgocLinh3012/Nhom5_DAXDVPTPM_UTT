
<?php
/**
 * VIEW: Sửa Câu hỏi | THÀNH VIÊN: TV2
 * FILE NÀY TV2 ĐƯỢC SỬA TỰ DO.
 */

$ch = $ch ?? [];
$mons = $mons ?? [];

$h = function ($value) {
    return htmlspecialchars(
        (string) ($value ?? ""),
        ENT_QUOTES,
        "UTF-8"
    );
};
?>

<div class="container-fluid py-4">

    <div class="page-head compact">
        <div class="page-title">SỬA CÂU HỎI</div>
        <a href="<?= BASE_URL ?>/index.php?url=CauhoiController/index"
           class="btn btn-secondary">
            Quay lại
        </a>
    </div>

    <?php if (!empty($err)): ?>
        <div class="alert alert-danger">
            <?= $h($err) ?>
        </div>
    <?php endif; ?>

    <div class="box">
        <form method="POST"
              action="<?= BASE_URL ?>/index.php?url=CauhoiController/update">

            <input type="hidden" name="id"
                   value="<?= (int) ($ch["id"] ?? 0) ?>">

            <div class="mb-3">
                <label class="form-label">Môn thi</label>
                <select name="mon_id" class="form-control" required>
                    <option value="">-- Chọn môn thi --</option>

                    <?php foreach ($mons as $mon): ?>
                        <option value="<?= (int) $mon["id"] ?>"
                            <?= (int) $mon["id"] === (int) ($ch["mon_id"] ?? 0)
                                ? "selected" : "" ?>>
                            <?= $h($mon["ten_mon"]) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nội dung câu hỏi</label>
                <textarea name="noi_dung"
                          class="form-control"
                          rows="3"
                          required><?= $h($ch["noi_dung"] ?? "") ?></textarea>
            </div>

            <?php
            $answers = [
                "a" => "Đáp án A",
                "b" => "Đáp án B",
                "c" => "Đáp án C",
                "d" => "Đáp án D"
            ];
            ?>

            <?php foreach ($answers as $key => $label): ?>
                <div class="mb-3">
                    <label class="form-label">
                        <?= $label ?>
                    </label>
                    <input type="text"
                           name="<?= $key ?>"
                           class="form-control"
                           value="<?= $h($ch["dap_an_" . $key] ?? "") ?>"
                           required>
                </div>
            <?php endforeach; ?>

            <div class="mb-3">
                <label class="form-label">Đáp án đúng</label>
                <select name="dap_an_dung" class="form-control">
                    <?php foreach (["A", "B", "C", "D"] as $ans): ?>
                        <option value="<?= $ans ?>"
                            <?= ($ch["dap_an_dung"] ?? "A") === $ans
                                ? "selected" : "" ?>>
                            <?= $ans ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Điểm</label>
                <input type="number"
                       name="diem"
                       class="form-control"
                       min="1"
                       value="<?= (int) ($ch["diem"] ?? 1) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Giải thích</label>
                <textarea name="giai_thich"
                          class="form-control"
                          rows="3"><?= $h($ch["giai_thich"] ?? "") ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Loại câu hỏi</label>
                <select name="loai" class="form-control">
                    <?php foreach (["D", "TB", "K"] as $loai): ?>
                        <option value="<?= $loai ?>"
                            <?= ($ch["loai"] ?? "D") === $loai
                                ? "selected" : "" ?>>
                            <?= $loai ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <select name="kich_hoat" class="form-control">
                    <option value="1"
                        <?= (int) ($ch["kich_hoat"] ?? 1) === 1
                            ? "selected" : "" ?>>
                        Kích hoạt
                    </option>
                    <option value="0"
                        <?= (int) ($ch["kich_hoat"] ?? 1) === 0
                            ? "selected" : "" ?>>
                        Không kích hoạt
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                Lưu thay đổi
            </button>

            <a href="<?= BASE_URL ?>/index.php?url=CauhoiController/index"
               class="btn btn-secondary">
                Hủy
            </a>

        </form>
    </div>
</div>
