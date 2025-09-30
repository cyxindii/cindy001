<?php
// week03/conference.php
$title = "資管一日營報名";

include('header.php'); // 引入 header.php
?>

<div class="container my-5">
  <h2>資管一日營報名</h2>
  <form action="conference.php" method="post">
    <label class="form-label">姓名:</label>
    <input type="text" name="name" class="form-control" required /><br />

    <label class="form-label">身分:</label><br/>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="status" id="faculty" value="faculty"  />
      <label class="form-check-label" for="faculty">教職員</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="status" id="student" value="student" />
      <label class="form-check-label" for="student">學生</label>
    </div>
    <br/><br/>

    <label class="form-label">選擇場次:</label><br/>
    <input type="checkbox" name="program[]" value="1"  /> 上午場 (150元)<br />
    <input type="checkbox" name="program[]" value="2" /> 下午場 (100元)<br />
    <input type="checkbox" name="program[]" value="3"  /> 午餐 (50元)<br /><br/>

    <input type="submit" value="提交報名" class="btn btn-primary" />
  </form>

  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 使用 htmlspecialchars() 保護從表單獲得的資料
    $name = htmlspecialchars($_POST['name'] ?? '無名', ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars($_POST['status'] ?? '', ENT_QUOTES, 'UTF-8');
    $programs = $_POST['program'] ?? [];

    $total = 0;

    if ($status == 'faculty') {
      $total = 0; // 老師免費
    } elseif ($status == 'student') {
      // 學生的選項計算費用
      if (in_array(1, $programs)) $total += 150; // 上午場
      if (in_array(2, $programs)) $total += 100; // 下午場
      if (in_array(3, $programs)) $total += 50;  // 午餐
    }

    // 顯示報名資訊，並使用 htmlspecialchars() 確保輸出的安全
    echo "<h4>報名資訊：</h4>";
    echo "姓名：" . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "<br/>";
    echo "身分：" . ($status == 'faculty' ? '教職員' : '學生') . "<br/>";
    echo "選擇項目：<br/>";
    echo "上午場：" . (in_array(1, $programs) ? "是" : "否") . "<br/>";
    echo "下午場：" . (in_array(2, $programs) ? "是" : "否") . "<br/>";
    echo "午餐：" . (in_array(3, $programs) ? "是" : "否") . "<br/>";
    echo "<h4>總金額：" . htmlspecialchars($total, ENT_QUOTES, 'UTF-8') . " 元</h4>";
  }
  ?>
</div>

<?php include('footer.php'); // 引入 footer.php ?>
