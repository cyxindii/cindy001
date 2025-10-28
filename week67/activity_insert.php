<?php
$title = "新增活動";
include("header.php");
require_once "db.php";

// 權限檢查：只有管理員 M 可以新增
$user = $_SESSION['user'] ?? null;
if (!$user || $user['role'] !== 'M') {
    echo "<div class='alert alert-danger'>您沒有權限操作此頁面</div>";
    exit;
}

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? "");
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? "");

    if ($name && $description) {
        $sql = "INSERT INTO event (name, description) VALUES (?, ?)";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $name, $description);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            $msg = "<div class='alert alert-success'>新增成功</div>";
        } else {
            $msg = "<div class='alert alert-danger'>新增失敗</div>";
        }
    }
}

?>

<div class="container my-4">
    <h2>新增活動</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">活動名稱</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">活動說明</label>
            <textarea name="description" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">送出</button>
        <?=$msg?>
    </form>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
