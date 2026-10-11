<?php
$u = $_SESSION["user"] ?? ["hoten" => "Khách"];
$page = $data["page"] ?? "";
?>

<!doctype html>
<html lang="vi">

<head>

  <meta charset="utf-8">

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1"
  >

  <title>
    Admin - Hệ thống thi trắc nghiệm UTT
  </title>

  <link
    rel="stylesheet"
    href="<?= BASE_URL ?>/assets/style.css?v=3"
  >

</head>


<body>

  <header class="site-header">

    <div class="header-top">

      <div class="header-logo">
        UTT EXAM SYSTEM
      </div>

      <div class="header-user">

        <span class="header-user-name">
          <?= htmlspecialchars($u["hoten"]) ?>
        </span>

      </div>

    </div>


    <nav class="header-nav">

      <a
        href="<?= BASE_URL ?>/index.php?url=LophocController/index"
        class="nav-link active"
      >
        Lớp Học
      </a>

    </nav>

  </header>


  <main class="page-wrap">

    <?php
    if ($page !== "") {
        require_once __DIR__ . "/" . $page . ".php";
    }
    ?>

  </main>


  <footer class="site-footer">
    © 2026 UTT All Rights Reserved
  </footer>

</body>

</html>