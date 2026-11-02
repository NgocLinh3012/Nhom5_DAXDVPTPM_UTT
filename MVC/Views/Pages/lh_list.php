
<?php
$rows = $data["rows"] ?? [];
$q = $data["q"] ?? "";
?>

<div class="page-head compact">
  <div class="page-title">QUẢN LÝ LỚP HỌC</div>

  <div class="page-actions">
    <a class="btn btn-primary btn-sm"
       href="<?= BASE_URL ?>/index.php?url=LophocController/template">
      Tải mẫu
    </a>

    <a class="btn btn-success btn-sm"
       href="<?= BASE_URL ?>/index.php?url=LophocController/create">
      Thêm mới
    </a>

    <form class="search-form" method="get"
          action="<?= BASE_URL ?>/index.php">
      <input type="hidden" name="url" value="LophocController/index">

      <input
        name="q"
        value="<?= htmlspecialchars((string)$q, ENT_QUOTES, 'UTF-8') ?>"
        placeholder="Tìm mã / tên lớp..."
      >

      <button type="submit" class="btn-search">Go</button>
    </form>
  </div>
</div>

<div class="box">
  <div class="box-sub">
    <div>
      Tổng số Lớp: <b><?= count($rows) ?></b>

      <?php if ($q !== ""): ?>
        — Kết quả cho:
        <b><?= htmlspecialchars((string)$q, ENT_QUOTES, 'UTF-8') ?></b>

        <a href="<?= BASE_URL ?>/index.php?url=LophocController/index">
          Xem tất cả
        </a>
      <?php endif; ?>
    </div>

    <button class="btn btn-warning btn-sm"
            type="button"
            onclick="openModal()">
      Import file
    </button>
  </div>

  <table class="tbl">
    <thead>
      <tr>
        <th style="width:60px;text-align:center">STT</th>
        <th style="width:120px;text-align:center">Mã lớp</th>
        <th>Tên lớp</th>
        <th style="width:100px;text-align:center">Trạng thái</th>
        <th style="text-align:center">Người tạo</th>
        <th style="width:130px;text-align:center">Thao tác</th>
        <th style="width:160px;text-align:center">Ngày tạo</th>
        <th style="width:100px;text-align:center">Số HV</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($rows as $i => $r): ?>
        <tr>
          <!-- STT -->
          <td style="text-align:center">
            <?= ($i + 1) + (($data['currPage'] ?? 1) - 1) * ($data['limit'] ?? 50) ?>
          </td>

          <!-- Mã lớp -->
          <td style="text-align:center">
            <?= htmlspecialchars((string)($r["ma_lop"] ?? ""), ENT_QUOTES, 'UTF-8') ?>
          </td>

          <!-- Tên lớp -->
          <td>
            <?= htmlspecialchars((string)($r["ten_lop"] ?? ""), ENT_QUOTES, 'UTF-8') ?>
          </td>

          <!-- Trạng thái -->
          <td style="text-align:center">
            <span class="pill <?= ((int)($r["trangthai"] ?? 0) === 1 ? 'yes' : 'no') ?>">
              <?= ((int)($r["trangthai"] ?? 0) === 1 ? 'Yes' : 'No') ?>
            </span>
          </td>

          <!-- Người tạo -->
          <td style="text-align:center">
            <?= htmlspecialchars((string)($r["nguoi_tao"] ?? 'Chưa xác định'), ENT_QUOTES, 'UTF-8') ?>
          </td>

          <!-- Thao tác -->
          <td style="text-align:center">
            <a class="action-btn edit"
               href="<?= BASE_URL ?>/index.php?url=LophocController/edit/<?= (int)($r["id"] ?? 0) ?>">
              Sửa
            </a>

            <a class="action-btn delete"
               href="#"
               onclick="confirmDelete(
                 '<?= BASE_URL ?>/index.php?url=LophocController/delete/<?= (int)($r["id"] ?? 0) ?>',
                 'Xóa lớp này?'
               ); return false;">
              Xóa
            </a>
          </td>

          <!-- Ngày tạo -->
          <td style="text-align:center">
            <?= htmlspecialchars((string)($r["created_at"] ?? ""), ENT_QUOTES, 'UTF-8') ?>
          </td>

          <!-- Số học viên -->
          <td style="text-align:center">
            <?= (int)($r["so_hoc_vien"] ?? 0) ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Phân trang -->
  <div class="pager">
    <?php for ($p = 1; $p <= ($data["totalPages"] ?? 1); $p++): ?>
      <a class="page <?= $p == ($data["currPage"] ?? 1) ? 'active' : '' ?>"
         href="<?= BASE_URL ?>/index.php?url=LophocController/index&amp;q=<?= rawurlencode((string)$q) ?>&amp;page=<?= $p ?>">
        <?= $p ?>
      </a>
    <?php endfor; ?>
  </div>
</div>

<!-- MODAL IMPORT -->
<div id="modal" class="modal">
  <div class="modal-card">
    <div class="modal-head">
      <div>Import lớp học</div>
      <button class="x" type="button" onclick="closeModal()">X</button>
    </div>

    <form method="post"
          enctype="multipart/form-data"
          action="<?= BASE_URL ?>/index.php?url=LophocController/import">

      <label>Chọn file (CSV)</label>

      <input type="file"
             name="file"
             accept=".csv"
             required>

      <div class="hint">
        CSV format: ma_lop, ten_lop, trangthai
      </div>

      <div class="modal-actions">
        <button class="btn btn-success" type="submit">
          Import
        </button>

        <button class="btn btn-secondary"
                type="button"
                onclick="closeModal()">
          Hủy
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function openModal() {
    document.getElementById('modal').classList.add('show');
  }

  function closeModal() {
    document.getElementById('modal').classList.remove('show');
  }

  function confirmDelete(url, message) {
    Swal.fire({
      icon: 'warning',
      title: 'Xác nhận xóa',
      text: message,
      showCancelButton: true,
      confirmButtonText: 'Xóa',
      cancelButtonText: 'Hủy',
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#64748b'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }
</script>
