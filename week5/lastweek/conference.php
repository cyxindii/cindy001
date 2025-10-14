<?php

$title = "資管一日營報名";
include('header.php');



// 沒有登入就導向登入頁
if (!isset($_SESSION['user'])) {
    $redirect = $_SERVER["REQUEST_URI"];
    header("Location: login.php?redirect=" . urlencode($redirect));
    exit;
}

$user = $_SESSION['user'];
?>

<div class="container my-5">
  <h2>資管一日營報名</h2>
  <form action="conference.php" method="post">
    <label class="form-label">姓名:</label>
    <input type="text" class="form-control" value="<?= htmlspecialchars($user['name'], ENT_QUOTES) ?>" readonly /><br/><br/>

    <label class="form-label">身分:</label>
    <input type="text" class="form-control" value="<?= $user['role'] === 'teacher' ? '老師' : '學生' ?>" readonly />

    <label class="form-label">選擇場次:</label><br/>
    <input type="checkbox" name="program[]" value="150" /> 上午場 (150元)<br />
    <input type="checkbox" name="program[]" value="100" /> 下午場 (100元)<br />
    <input type="checkbox" name="program[]" value="50" /> 午餐 (50元)<br />


    <input type="submit" value="提交報名" class="btn btn-primary" />
  </form>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = htmlspecialchars($user['name'], ENT_QUOTES);
      $role = $user['role'];

      // 計算費用，老師免費
      $total = 0;
      if ($role !== 'teacher') {
          $programs = $_POST['program'] ?? [];
          foreach ($programs as $p) {
              $total += (int)$p;
          }
      }
    // 顯示報名資訊，並使用 htmlspecialchars() 確保輸出的安全
    echo "<h4 class='mt-4'>報名資訊：</h4>";
    echo "姓名：$name<br/>";
    echo "身分：" . ($role === 'teacher' ? '老師' : '學生') . "<br/>";
    echo "<h4>總金額：" . $total . " 元</h4>";
  }
  ?>
</div>

<?php include('footer.php'); // 引入 footer.php ?>