<?php
require_once "header.php";

try {
    require_once 'db.php';
    $msg = "";

    // 如果使用者送出表單
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $company = mysqli_real_escape_string($conn, $_POST['company'] ?? '');
        $content = mysqli_real_escape_string($conn, $_POST['content'] ?? '');

        if ($company && $content) {
            $sql = "INSERT INTO job (company, content, pdate) VALUES ('$company', '$content', NOW())";

            if (mysqli_query($conn, $sql)) {
                $msg = "<div class='alert alert-success'>新增成功！</div>";
            } else {
                $msg = "<div class='alert alert-danger'>新增失敗: " . mysqli_error($conn) . "</div>";
            }
        } else {
            $msg = "<div class='alert alert-warning'>請填寫完整資料</div>";
        }
    }
?>
<div class="container my-4">
    <h3 class="mb-4 text-center">新增求才資訊</h3>
    <form action="job_insert.php" method="post">
        <div class="mb-3 row">
            <label for="_company" class="col-sm-2 col-form-label">求才廠商</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="company" id="_company" placeholder="公司名稱" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="_content" class="form-label">求才內容</label>
            <textarea class="form-control" name="content" id="_content" rows="10" placeholder="輸入求才內容" required></textarea>
        </div>
        <input class="btn btn-primary" type="submit" value="送出">
        <?=$msg?>
    </form>
</div>
<?php
    mysqli_close($conn);
} catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
}

require_once "footer.php";
?>
