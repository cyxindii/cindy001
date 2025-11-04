<?php
$title = "修改活動";
include("header.php");
require_once "db.php";

// 權限檢查：只有管理員 M 可以修改
$user = $_SESSION['user'] ?? null;
if (!$user || $user['role'] !== 'M') {
    echo "<div class='alert alert-danger'>您沒有權限操作此頁面</div>";
    exit;
}

// 取得活動 id
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    echo "<div class='alert alert-danger'>無效的活動 ID</div>";
    exit;
}

$msg = "";

// 讀取現有資料
$sql = "SELECT name, description FROM event WHERE id=?";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $name, $description);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// 處理表單送出
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = mysqli_real_escape_string($conn, $_POST['name'] ?? "");
    $new_desc = mysqli_real_escape_string($conn, $_POST['description'] ?? "");

    if ($new_name && $new_desc) {
        $sql = "UPDATE event SET name=?, description=? WHERE id=?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $new_name, $new_desc, $id);
        $res = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($res) {
            $msg = "<div class='alert alert-success'>修改成功</div>";
            $name = $new_name;
            $description = $new_desc;
        } else {
            $msg = "<div class='alert alert-danger'>修改失敗</div>";
        }
    } else {
        $msg = "<div class='alert alert-warning'>請填寫完整資料</div>";
    }
}
?>

<div class="container my-4">
    <h2>修改活動</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">活動名稱</label>
            <input type="text" name="name" class="form-control" value="<?=htmlspecialchars($name)?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">活動說明</label>
            <textarea name="description" class="form-control" rows="5" required><?=htmlspecialchars($description)?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">送出修改</button>
        <?=$msg?>
    </form>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
