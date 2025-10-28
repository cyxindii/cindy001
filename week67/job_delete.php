<?php
require_once "header.php";

try {
    // 初始化變數
    $postid = "";
    $company = "";
    $content = "";
    $pdate = "";

    // 檢查是否有 GET 參數
    if ($_GET) {
        require_once 'db.php';
        $action = $_GET["action"] ?? "";

        if ($action == "confirmed") {
            // ✅ 刪除資料
            $postid = $_GET["postid"];
            $sql = "DELETE FROM job WHERE postid=?";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "i", $postid);
            $result = mysqli_stmt_execute($stmt);
            mysqli_close($conn);

            // 刪除後導回列表頁
            header('location:job.php');
            exit();
        } else {
            // ✅ 顯示確認刪除的資料
            $postid = $_GET["postid"];
            $sql = "SELECT postid, company, content, pdate FROM job WHERE postid=?";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "i", $postid);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
                mysqli_stmt_bind_result($stmt, $postid, $company, $content, $pdate);
                mysqli_stmt_fetch($stmt);
            }

            mysqli_close($conn);
        }
    }
} catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
}
?>

<div class="container my-4">
    <h3 class="mb-3">刪除確認</h3>
    <p>請確認是否要刪除以下求才資料：</p>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>編號</th>
                <th>求才廠商</th>
                <th>求才內容</th>
                <th>刊登日期</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?=$postid?></td>
                <td><?=$company?></td>
                <td><?=$content?></td>
                <td><?=$pdate?></td>
            </tr>
        </tbody>
    </table>

    <a href="job_delete.php?postid=<?=$postid?>&action=confirmed" class="btn btn-danger">刪除</a>
    <a href="job.php" class="btn btn-secondary">取消</a>
</div>

<?php
require_once "footer.php";
?>
