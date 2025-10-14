<?php
// 載入共用頁首與資料庫連線
require_once "header.php";
require_once "db.php";
?>

<div class="container my-4">
  <h3 class="mb-4 text-center">求才資訊</h3>
  
  <!-- 建立表格 -->
  <table id="jobTable" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>求才廠商</th>
        <th>求才內容</th>
        <th>日期</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // 從資料庫讀取資料
      $sql = "SELECT * FROM job";
      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['company']}</td>";
        echo "<td>{$row['content']}</td>";
        echo "<td>{$row['pdate']}</td>";
        echo "</tr>";
      }
      mysqli_close($conn);
      ?>
    </tbody>
  </table>
</div>

<!-- ✅ 引入 DataTables 套件（CDN 版本） -->
<link rel="stylesheet" 
      href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
  // ✅ 啟用 DataTable 功能
  $(document).ready(function () {
    $('#jobTable').DataTable({
      language: {
        lengthMenu: "每頁顯示 _MENU_ 筆資料",
        zeroRecords: "查無資料",
        info: "顯示第 _START_ 到 _END_ 筆，共 _TOTAL_ 筆",
        infoEmpty: "無資料可顯示",
        infoFiltered: "(從 _MAX_ 筆資料中篩選)",
        search: "搜尋：",
        paginate: {
          first: "第一頁",
          last: "最後一頁",
          next: "下一頁",
          previous: "上一頁"
        }
      }
    });
  });
</script>

<?php require_once "footer.php"; ?>
