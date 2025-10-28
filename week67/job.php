<?php
$title = "求才資訊列表";
include('check_login.php'); // 如果有登入檢查
require_once "header.php";

try {
    require_once 'db.php';

    // 取得表單送出的值
    $order = $_POST["order"] ?? "";
    $searchtxt = mysqli_real_escape_string($conn, $_POST["searchtxt"] ?? "");
    $date_start = $_POST["date_start"] ?? "";
    $date_end = $_POST["date_end"] ?? "";

    // 日期區間相反時自動交換
    if ($date_start && $date_end && $date_start > $date_end) {
        [$date_start, $date_end] = [$date_end, $date_start];
    }

    // 建立 WHERE 條件
    $where = [];
    if ($searchtxt) {
        $where[] = "(company LIKE '%$searchtxt%' OR content LIKE '%$searchtxt%')";
    }
    if ($date_start) {
        $where[] = "pdate >= '$date_start'";
    }
    if ($date_end) {
        $where[] = "pdate <= '$date_end'";
    }

    // 組合 SQL
    $sql = "SELECT * FROM job";
    if (count($where) > 0) {
        $sql .= " WHERE " . implode(' AND ', $where);
    }
    if ($order) {
        $sql .= " ORDER BY $order";
    } else {
        $sql .= " ORDER BY pdate DESC"; // 預設排序
    }

    $result = mysqli_query($conn, $sql);

?>
<div class="container my-4">
    <h3 class="mb-4 text-center">求才資訊</h3>

    <!-- 搜尋與排序表單 -->
    <form action="job.php" method="post" class="row g-2 align-items-center mb-3">
        <div class="col-auto">
            <select name="order" class="form-select">
                <option value="" <?=($order=="")?'selected':''?>>選擇排序欄位</option>
                <option value="company" <?=($order=="company")?'selected':''?>>求才廠商</option>
                <option value="content" <?=($order=="content")?'selected':''?>>求才內容</option>
                <option value="pdate" <?=($order=="pdate")?'selected':''?>>刊登日期</option>
            </select>
        </div>
        <div class="col-auto">
            <input type="text" name="searchtxt" class="form-control" placeholder="搜尋廠商及內容" value="<?=htmlspecialchars($searchtxt)?>">
        </div>
        <div class="col-auto">
            <input type="date" name="date_start" class="form-control" value="<?=htmlspecialchars($date_start)?>">
        </div>
        <div class="col-auto">
            <span>~</span>
        </div>
        <div class="col-auto">
            <input type="date" name="date_end" class="form-control" value="<?=htmlspecialchars($date_end)?>">
        </div>
        <div class="col-auto">
            <input type="submit" class="btn btn-primary" value="搜尋">
        </div>
    </form>

    <!-- 資料表 -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>求才廠商</th>
                <th>求才內容</th>
                <th>刊登日期</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?=$row["company"]?></td>
                <td><?=$row["content"]?></td>
                <td><?=$row["pdate"]?></td>
                <td>
                    <a href="job_delete.php?postid=<?=$row['postid']?>" class="btn btn-danger btn-sm">刪除</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php
    mysqli_close($conn);
} catch(Exception $e) {
    echo 'Message: '.$e->getMessage();
}

require_once "footer.php";
?>
