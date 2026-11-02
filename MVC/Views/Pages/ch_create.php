
<?php
/**
 * VIEW: Thêm Câu hỏi | THÀNH VIÊN: TV2
 */

$mons = $data["mons"] ?? [];
$err = $data["err"] ?? "";
?>

<div class="container-fluid py-4">
    <h3 class="mb-4">Thêm câu hỏi mới</h3>

    <?php if (!empty($err)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($err) ?>
        </div>
    <?php endif; ?>

    <form method="POST"
          action="<?= BASE_URL ?>/index.php?url=CauhoiController/store">

        <div class="mb-3">
            <label class="form-label">Môn thi</label>
            <select name="mon_id" class="form-select" required>
                <option value="">-- Chọn môn thi --</option>

                <?php foreach ($mons as $mon): ?>
                    <option value="<?= (int) $mon["id"] ?>">
                        <?= htmlspecialchars($mon["ten_mon"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Nội dung câu hỏi</label>
            <textarea name="noi_dung"
                      class="form-control"
                      rows="3"
                      required></textarea>
        </div>

        <?php foreach (["a", "b", "c", "d"] as $dapAn): ?>
            <div class="mb-3">
                <label class="form-label">
                    Đáp án <?= strtoupper($dapAn) ?>
                </label>

                <input type="text"
                       name="<?= $dapAn ?>"
                       class="form-control"
                       maxlength="255"
                       required>
            </div>
        <?php endforeach; ?>

        <div class="mb-3">
            <label class="form-label">Đáp án đúng</label>
            <select name="dap_an_dung"
                    class="form-select"
                    required>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Điểm</label>
            <input type="number"
                   name="diem"
                   class="form-control"
                   value="1"
                   min="1"
                   step="1"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Giải thích</label>
            <textarea name="giai_thich"
                      class="form-control"
                      rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Loại câu hỏi</label>
            <select name="loai" class="form-select">
                <option value="D">Dễ</option>
                <option value="TB">Trung bình</option>
                <option value="K">Khó</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select name="kich_hoat" class="form-select">
                <option value="1">Kích hoạt</option>
                <option value="0">Không kích hoạt</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Lưu câu hỏi
        </button>

        <a href="<?= BASE_URL ?>/index.php?url=CauhoiController/index"
           class="btn btn-secondary">
            Quay lại
        </a>
    </form>
</div>
