<?php

$title = "迎新茶會報名";
include('header.php');


// 如果沒有登入，導向登入頁
if (!isset($_SESSION['user'])) {
    $redirect = $_SERVER["REQUEST_URI"];
    header("Location: login.php?redirect=" . urlencode($redirect));
    exit;
}

$user = $_SESSION['user'];

?>

<div class="container my-5">
  <h2>迎新茶會報名</h2>
  <form action="status.php" method="post">
    <label class="form-label">姓名:</label>
    <input type="text" name="name" class="form-control" required /><br />

    <label class="form-label">身分:</label>
    <input type="text" class="form-control" value="<?= $user['role'] === 'teacher' ? '老師' : '學生' ?>" readonly /><br/><br/>
    <label class="form-label">是否需要晚餐?</label><br/>
    <input type="checkbox" name="dinner" value="60" /> 需要晚餐 (60元)<br/><br/>
    
    <input type="submit" value="提交報名" class="btn btn-primary" />
  </form>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = htmlspecialchars($user['name'], ENT_QUOTES);
      $role = $user['role'];
      $dinner = isset($_POST['dinner']) ? (int)$_POST['dinner'] : 0;
      $total = ($user['role'] === 'teacher') ? 0 : $dinner;

      // 顯示報名資訊
      echo "<h4 class='mt-4'>報名資訊：</h4>";
      echo "姓名：$name<br/>";
      echo "身分：" . ($role === 'teacher' ? '教職員' : '學生') . "<br/>";
      echo "晚餐費用：" . ($dinner > 0 ? "$dinner 元" : "不需要晚餐") . "<br/>";
      echo "<h4>總金額：$total 元</h4>";
  }
  ?>
</div>

<?php include('footer.php'); // 引入 footer.php ?>
