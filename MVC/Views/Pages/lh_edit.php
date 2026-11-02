<?php
/**
 * VIEW: Sửa Lớp học | THÀNH VIÊN: TV4
 * FILE NÀY TV4 ĐƯỢC SỬA TỰ DO.
 * Biến $data được extract() từ Controller – xem Controller tương ứng.
 */
$lopHoc = $data["lop_hoc"] ?? [];
$old = $data["old"] ?? [];
$errors = $data["errors"] ?? [];
$csrfToken = $data["csrf_token"] ?? "";
$id = (int) ($old["id"] ?? $lopHoc["id"] ?? 0);
?>
<style>
  .lop-hoc-form-page {
    width: 100%;
    max-width: 780px;
    margin: 0 auto;
    padding: 32px 24px 48px;
    color: var(--text-primary);
  }

  .lop-hoc-form-heading {
    margin-bottom: 24px;
  }

  .lop-hoc-form-heading h1 {
    margin-bottom: 6px;
    font-size: 28px;
  }

  .lop-hoc-form-heading p {
    color: var(--text-secondary);
  }

  .lop-hoc-form-card {
    overflow: hidden;
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    background: var(--bg-secondary);
    box-shadow: var(--shadow-lg);
  }

  .lop-hoc-form-card-header {
    padding: 18px 22px;
    border-bottom: 1px solid var(--border);
    background: rgba(15, 23, 42, .35);
  }

  .lop-hoc-form-card-header h2 {
    font-size: 16px;
  }

  .lop-hoc-form {
    padding: 24px;
  }

  .lop-hoc-field {
    margin-bottom: 20px;
  }

  .lop-hoc-field label {
    display: block;
    margin-bottom: 8px;
    font-weight: 700;
  }

  .lop-hoc-field input,
  .lop-hoc-field select {
    width: 100%;
    height: 44px;
    border: 1px solid var(--border-light);
    border-radius: var(--radius-md);
    outline: none;
    background: var(--bg-primary);
    color: var(--text-primary);
    padding: 0 14px;
  }

  .lop-hoc-field input:focus,
  .lop-hoc-field select:focus {
    border-color: var(--accent-primary);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .18);
  }

  .lop-hoc-field-error {
    border-color: var(--danger) !important;
  }

  .lop-hoc-error-text {
    display: block;
    margin-top: 7px;
    color: #fca5a5;
    font-size: 13px;
  }

  .lop-hoc-required {
    color: #fca5a5;
  }

  .lop-hoc-form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding-top: 20px;
    border-top: 1px solid var(--border);
  }

  @media (max-width: 640px) {
    .lop-hoc-form-page {
      padding: 24px 16px 36px;
    }

    .lop-hoc-form {
      padding: 20px 16px;
    }

    .lop-hoc-form-actions {
      flex-direction: column-reverse;
    }

    .lop-hoc-form-actions .btn {
      width: 100%;
    }
  }
</style>

<div class="lop-hoc-form-page">
  <div class="lop-hoc-form-heading">
    <h1>Sửa lớp học</h1>
    <p>Cập nhật thông tin lớp học trong hệ thống.</p>
  </div>

  <?php if (!empty($errors["general"])): ?>
    <div class="alert error">
      <?= htmlspecialchars((string) $errors["general"], ENT_QUOTES, "UTF-8") ?>
    </div>
  <?php endif; ?>

  <section class="lop-hoc-form-card">
    <div class="lop-hoc-form-card-header">
      <h2>Thông tin lớp học</h2>
    </div>

    <form class="lop-hoc-form" method="post" action="<?= htmlspecialchars(BASE_URL . "/index.php?url=LophocController/update", ENT_QUOTES, "UTF-8") ?>">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string) $csrfToken, ENT_QUOTES, "UTF-8") ?>">
      <input type="hidden" name="id" value="<?= htmlspecialchars((string) $id, ENT_QUOTES, "UTF-8") ?>">

      <div class="lop-hoc-field">
        <label for="ma_lop">Mã lớp <span class="lop-hoc-required">*</span></label>
        <input
          id="ma_lop"
          name="ma_lop"
          type="text"
          maxlength="20"
          required
          value="<?= htmlspecialchars((string) (array_key_exists("ma_lop", $old) ? $old["ma_lop"] : ($lopHoc["ma_lop"] ?? "")), ENT_QUOTES, "UTF-8") ?>"
          class="<?= !empty($errors["ma_lop"]) ? "lop-hoc-field-error" : "" ?>"
        >
        <?php if (!empty($errors["ma_lop"])): ?>
          <span class="lop-hoc-error-text"><?= htmlspecialchars((string) $errors["ma_lop"], ENT_QUOTES, "UTF-8") ?></span>
        <?php endif; ?>
      </div>

      <div class="lop-hoc-field">
        <label for="ten_lop">Tên lớp <span class="lop-hoc-required">*</span></label>
        <input
          id="ten_lop"
          name="ten_lop"
          type="text"
          maxlength="100"
          required
          value="<?= htmlspecialchars((string) (array_key_exists("ten_lop", $old) ? $old["ten_lop"] : ($lopHoc["ten_lop"] ?? "")), ENT_QUOTES, "UTF-8") ?>"
          class="<?= !empty($errors["ten_lop"]) ? "lop-hoc-field-error" : "" ?>"
        >
        <?php if (!empty($errors["ten_lop"])): ?>
          <span class="lop-hoc-error-text"><?= htmlspecialchars((string) $errors["ten_lop"], ENT_QUOTES, "UTF-8") ?></span>
        <?php endif; ?>
      </div>

      <div class="lop-hoc-field">
        <label for="trangthai">Trạng thái</label>
        <select id="trangthai" name="trangthai" class="<?= !empty($errors["trangthai"]) ? "lop-hoc-field-error" : "" ?>">
          <?php $trangthaiHienTai = array_key_exists("trangthai", $old) ? $old["trangthai"] : (string) ($lopHoc["trangthai"] ?? "1"); ?>
          <option value="1" <?= $trangthaiHienTai === "1" ? "selected" : "" ?>>Hoạt động</option>
          <option value="0" <?= $trangthaiHienTai === "0" ? "selected" : "" ?>>Đã khóa</option>
        </select>
        <?php if (!empty($errors["trangthai"])): ?>
          <span class="lop-hoc-error-text"><?= htmlspecialchars((string) $errors["trangthai"], ENT_QUOTES, "UTF-8") ?></span>
        <?php endif; ?>
      </div>

      <div class="lop-hoc-form-actions">
        <a class="btn btn-secondary" href="<?= htmlspecialchars(BASE_URL . "/index.php?url=LophocController/index", ENT_QUOTES, "UTF-8") ?>">Quay lại</a>
        <button class="btn btn-primary" type="submit">Cập nhật lớp học</button>
      </div>
    </form>
  </section>
</div>
