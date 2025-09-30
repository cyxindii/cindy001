<?php
// week03/status.php
$title = "迎新茶會報名";

include('header.php'); // 引入 header.php
?>

<div class="container my-5">
  <h2>迎新茶會報名</h2>
  <form action="status.php" method="post">
    <label class="form-label">姓名:</label>
    <input type="text" name="name" class="form-control" required /><br />

    <label class="form-label">身分:</label><br/>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="status" id="faculty" value="faculty" />
      <label class="form-check-label" for="faculty">教職員</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="status" id="student" value="student" />
      <label class="form-check-label" for="student">學生</label>
    </div>
    <br/><br/>

    <label class="form-label">是否需要晚餐?</label><br/>
    <input type="checkbox" name="dinner" value="dinner" /> 需要晚餐 (60元)<br/><br/>
    
    <input type="submit" value="提交報名" class="btn btn-primary" />
  </form>

  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 使用 htmlspecialchars() 轉義用戶輸入的資料
    $name = htmlspecialchars($_POST['name'] ?? '無名', ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars($_POST['status'] ?? '', ENT_QUOTES, 'UTF-8');
    $dinner = isset($_POST['dinner']) ? 60 : 0;

    if ($status == 'faculty') {
      $total = 0; // 老師免費
    } elseif ($status == 'student' && $dinner > 0) {
      $total = 60; // 學生需要晚餐，費用 60
    } else {
      $total = 0; // 學生不用餐免費
    }

    // 使用 htmlspecialchars() 來顯示資料，避免 XSS 攻擊
    echo "<h4>報名資訊：</h4>";
    echo "姓名：" . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "<br/>";
    echo "身分：" . ($status == 'faculty' ? '教職員' : '學生') . "<br/>";
    echo "晚餐費用：" . ($dinner > 0 ? htmlspecialchars("$dinner 元", ENT_QUOTES, 'UTF-8') : "不需要晚餐") . "<br/>";
    echo "<h4>總金額：" . htmlspecialchars($total, ENT_QUOTES, 'UTF-8') . " 元</h4>";
  }
  ?>
</div>

<?php include('footer.php'); // 引入 footer.php ?>
