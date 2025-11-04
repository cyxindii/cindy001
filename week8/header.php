<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // 確保 session 只啟動一次
}
$title=$title??"活動系統";
function nav_active($file) {
    $current = basename($_SERVER['PHP_SELF']);
    return $current === $file ? ' active' : '';
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=$title?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="custom.css" />
</head>
<body class="bg-light">
  <nav class="navbar navbar-expand-lg custom-bg">
    <div class="container">
      <a class="navbar-brand" href="index.php">活動報名系統</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link<?=nav_active('index.php')?>" aria-current="page" href="index.php">首頁</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?=nav_active('status.php')?>" href="status.php">迎新茶會</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?=nav_active('conference.php')?>" href="conference.php">資管一日營</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?=nav_active('job.php')?>" href="job.php">求職資料</a>
          </li>
        </ul>
         <!-- 右側登入／登出按鈕 -->
<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
 <?php if (isset($_SESSION['user'])): ?>
  <li class="nav-item">
    <a class="nav-link" href="profile.php">個人資料</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="logout.php">登出</a>
  </li>
 <?php else: ?>
  <li class="nav-item">
   <a class="nav-link<?=nav_active('login.php')?>" href="login.php">登入</a>
  </li>
 <?php endif; ?>
</ul>
      </div>
    </div>
  </nav>
