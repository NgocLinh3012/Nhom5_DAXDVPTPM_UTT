<?php
/**
 * VIEW: Danh sách Lớp học | THÀNH VIÊN: TV4
 * FILE NÀY TV4 ĐƯỢC SỬA TỰ DO.
 * Biến $data được extract() từ Controller – xem Controller tương ứng.
 */
?>
<style>
  .lop-hoc-page {
    width: 100%;
    max-width: 1180px;
    margin: 0 auto;
    padding: 32px 24px 48px;
    color: var(--text-primary);
  }

  .lop-hoc-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 24px;
  }

  .lop-hoc-heading h1 {
    margin-bottom: 6px;
    font-size: 28px;
    color: var(--text-primary);
  }

  .lop-hoc-heading p {
    color: var(--text-secondary);
  }

  .lop-hoc-count {
    min-width: 112px;
    padding: 14px 18px;
    border: 1px solid rgba(96, 165, 250, .35);
    border-radius: var(--radius-md);
    background: linear-gradient(135deg, rgba(30, 64, 175, .85), rgba(59, 130, 246, .55));
    box-shadow: var(--shadow-md);
    text-align: center;
  }

  .lop-hoc-count strong,
  .lop-hoc-count span {
    display: block;
  }

  .lop-hoc-count strong {
    font-size: 26px;
    line-height: 1.1;
  }

  .lop-hoc-count span {
    margin-top: 4px;
    color: #dbeafe;
    font-size: 12px;
  }

  .lop-hoc-card {
    overflow: hidden;
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    background: var(--bg-secondary);
    box-shadow: var(--shadow-lg);
  }

  .lop-hoc-card-header {
    padding: 18px 22px;
    border-bottom: 1px solid var(--border);
    background: rgba(15, 23, 42, .35);
  }

  .lop-hoc-card-header h2 {
    font-size: 16px;
  }

  .lop-hoc-table-wrap {
    overflow-x: auto;
  }

  .lop-hoc-table {
    width: 100%;
    min-width: 620px;
    border-collapse: collapse;
  }

  .lop-hoc-table th,
  .lop-hoc-table td {
    padding: 16px 22px;
    border-bottom: 1px solid var(--border);
    text-align: left;
    vertical-align: middle;
  }

  .lop-hoc-table th {
    background: var(--bg-tertiary);
    color: #bfdbfe;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .04em;
    text-transform: uppercase;
  }

  .lop-hoc-table tbody tr {
    background: var(--bg-secondary);
    transition: var(--transition-fast);
  }

  .lop-hoc-table tbody tr:nth-child(even) {
    background: rgba(51, 65, 85, .18);
  }

  .lop-hoc-table tbody tr:hover {
    background: rgba(59, 130, 246, .12);
  }

  .lop-hoc-table tbody tr:last-child td {
    border-bottom: 0;
  }

  .lop-hoc-code {
    color: #93c5fd;
    font-weight: 700;
  }

  .lop-hoc-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 5px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
  }

  .lop-hoc-status::before {
    content: "";
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: currentColor;
  }

  .lop-hoc-status-active {
    border: 1px solid rgba(34, 197, 94, .35);
    background: rgba(34, 197, 94, .14);
    color: #86efac;
  }

  .lop-hoc-status-locked {
    border: 1px solid rgba(239, 68, 68, .35);
    background: rgba(239, 68, 68, .14);
    color: #fca5a5;
  }

  .lop-hoc-status-unknown {
    border: 1px solid rgba(148, 163, 184, .35);
    background: rgba(148, 163, 184, .14);
    color: #cbd5e1;
  }

  .lop-hoc-empty {
    padding: 54px 24px;
    border-top: 1px solid var(--border);
    text-align: center;
  }

  .lop-hoc-empty strong {
    display: block;
    margin-bottom: 6px;
    font-size: 17px;
  }

  .lop-hoc-empty span {
    color: var(--text-secondary);
  }

  @media (max-width: 640px) {
    .lop-hoc-page {
      padding: 24px 16px 36px;
    }

    .lop-hoc-header {
      align-items: stretch;
      flex-direction: column;
    }

    .lop-hoc-heading h1 {
      font-size: 24px;
    }

    .lop-hoc-count {
      display: flex;
      align-items: baseline;
      justify-content: center;
      gap: 8px;
    }

    .lop-hoc-count span {
      margin-top: 0;
    }
  }
</style>

<div class="lop-hoc-page">
  <div class="lop-hoc-header">
    <div class="lop-hoc-heading">
      <h1>Danh sách lớp học</h1>
      <p>Quản lý và theo dõi các lớp học trong hệ thống thi trắc nghiệm.</p>
    </div>

    <?php $lopHoc = $data["lop_hoc"] ?? []; ?>
    <?php $tongLop = is_array($lopHoc) ? count($lopHoc) : 0; ?>
    <div class="lop-hoc-count" aria-label="<?= htmlspecialchars((string) $tongLop, ENT_QUOTES, "UTF-8") ?> lớp học">
      <strong><?= htmlspecialchars((string) $tongLop, ENT_QUOTES, "UTF-8") ?></strong>
      <span>Tổng số lớp</span>
    </div>
  </div>

  <?php if (!empty($data["err"])): ?>
    <div class="alert alert-danger">
      <?= htmlspecialchars((string) $data["err"], ENT_QUOTES, "UTF-8") ?>
    </div>
  <?php endif; ?>

  <section class="lop-hoc-card" aria-labelledby="lop-hoc-table-title">
    <div class="lop-hoc-card-header">
      <h2 id="lop-hoc-table-title">Danh mục lớp học</h2>
    </div>

    <?php if (empty($lopHoc) && empty($data["err"])): ?>
      <div class="lop-hoc-empty">
        <strong>Chưa có lớp học nào</strong>
        <span>Danh sách lớp học hiện đang trống.</span>
      </div>
    <?php elseif (!empty($lopHoc)): ?>
      <div class="lop-hoc-table-wrap">
        <table class="lop-hoc-table">
          <thead>
            <tr>
              <th scope="col">Mã lớp</th>
              <th scope="col">Tên lớp</th>
              <th scope="col">Trạng thái</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($lopHoc as $lop): ?>
              <tr>
                <td class="lop-hoc-code"><?= htmlspecialchars((string) ($lop["ma_lop"] ?? ""), ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars((string) ($lop["ten_lop"] ?? ""), ENT_QUOTES, "UTF-8") ?></td>
                <td>
                  <?php if ((int) ($lop["trangthai"] ?? -1) === 1): ?>
                    <span class="lop-hoc-status lop-hoc-status-active">Hoạt động</span>
                  <?php elseif ((int) ($lop["trangthai"] ?? -1) === 0): ?>
                    <span class="lop-hoc-status lop-hoc-status-locked">Đã khóa</span>
                  <?php else: ?>
                    <span class="lop-hoc-status lop-hoc-status-unknown">Không xác định</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>
</div>
