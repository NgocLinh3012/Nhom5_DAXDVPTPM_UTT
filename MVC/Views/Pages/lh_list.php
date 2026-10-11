<?php
$rows = $data["rows"] ?? [];
?>

<div class="page-head compact">

  <div class="page-title">
    QUẢN LÝ LỚP HỌC
  </div>

  <div class="page-actions">

    <a
      class="btn btn-success btn-sm"
      href="<?= BASE_URL ?>/index.php?url=LophocController/create"
    >
      Thêm mới
    </a>

  </div>

</div>


<div class="box">

  <table class="tbl">

    <thead>

      <tr>
        <th>STT</th>
        <th>Mã lớp</th>
        <th>Tên lớp</th>
        <th>Trạng thái</th>
        <th>Người tạo</th>
        <th>Ngày tạo</th>
        <th>Số HV</th>
      </tr>

    </thead>


    <tbody>

      <?php foreach ($rows as $i => $r): ?>

        <tr>

          <td>
            <?= $i + 1 ?>
          </td>

          <td>
            <?= htmlspecialchars($r["ma_lop"]) ?>
          </td>

          <td>
            <?= htmlspecialchars($r["ten_lop"]) ?>
          </td>

          <td>
            <?= (int) $r["trangthai"] === 1
                ? "Yes"
                : "No" ?>
          </td>

          <td>
            <?= htmlspecialchars(
                $r["nguoi_tao"] ?? ""
            ) ?>
          </td>

          <td>
            <?= htmlspecialchars(
                $r["created_at"] ?? ""
            ) ?>
          </td>

          <td>
            <?= (int) (
                $r["so_hoc_vien"] ?? 0
            ) ?>
          </td>

        </tr>

      <?php endforeach; ?>

    </tbody>

  </table>

</div>