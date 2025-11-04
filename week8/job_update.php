<?php
include "db.php"; // 資料庫連線

// 1️⃣ 取得要修改的資料（GET 方式）
if(isset($_GET['postid'])){
    $id = $_GET['postid'];
    $sql = "SELECT * FROM job WHERE postid=$id";
    $result = mysqli_query($conn, $sql);
    if($row = mysqli_fetch_assoc($result)){
        $company = $row['company'];
        $content = $row['content'];
    } else {
        echo "找不到該筆資料";
        exit;
    }
}

// 2️⃣ 表單送出後更新資料（POST 方式）
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['postid'];
    $company = $_POST['company'];
    $content = $_POST['content'];

    $sql = "UPDATE job SET company='$company', content='$content' WHERE postid=$id";
    if(mysqli_query($conn, $sql)){
        header("Location: job.php"); // 更新成功回到列表
        exit();
    } else {
        echo "更新失敗：" . mysqli_error($conn);
    }
}

$title = "修改求才資料";
require_once "header.php";
?>

<div class="container my-4">
    <h3 class="mb-4 text-center">修改求才資料</h3>

    <form action="job_update.php" method="post">
        <div class="mb-3 row">
            <label for="_company" class="col-sm-2 col-form-label">求才廠商</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="company" id="_company" 
                    placeholder="公司名稱" value="<?=isset($company)?$company:''?>" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="_content" class="form-label">求才內容</label>
            <textarea class="form-control" id="_content" name="content" rows="10" required><?=isset($content)?$content:''?></textarea>
        </div>
        <input type="hidden" name="postid" value="<?=isset($id)?$id:''?>">
        <input class="btn btn-primary" type="submit" value="送出">
    </form>
</div>

<?php
require_once "footer.php";
?>
