<?php
$title = "修改個人資料";
include("header.php");
require_once "db.php";

// 必須登入
$user = $_SESSION['user'] ?? null;
if (!$user) {
    $redirect = $_SERVER["REQUEST_URI"];
    header("Location: login.php?redirect=" . urlencode($redirect));
    exit;
}

$msg = "";

// 處理表單送出
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = mysqli_real_escape_string($conn, $_POST['name'] ?? "");
    $old_password = $_POST['old_password'] ?? "";
    $new_password = $_POST['new_password'] ?? "";
    $confirm_password = $_POST['confirm_password'] ?? "";

    // 驗證舊密碼
    $sql = "SELECT password FROM user WHERE account=?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $user['account']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $current_password);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    $update_password = false;
    if ($old_password || $new_password || $confirm_password) {
        if ($old_password !== $current_password) {
            $msg .= "<div class='alert alert-danger'>舊密碼錯誤</div>";
        } elseif ($new_password !== $confirm_password) {
            $msg .= "<div class='alert alert-danger'>新密碼與確認密碼不一致</div>";
        } else {
            $update_password = true;
        }
    }

    // 更新姓名
    if ($new_name) {
        $sql = "UPDATE user SET name=? WHERE account=?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $new_name, $user['account']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $_SESSION['user']['name'] = $new_name;
        $msg .= "<div class='alert alert-success'>姓名更新成功</div>";
    }

    // 更新密碼
    if ($update_password) {
        $sql = "UPDATE user SET password=? WHERE account=?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $new_password, $user['account']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $msg .= "<div class='alert alert-success'>密碼更新成功</div>";
    }
}
?>

<div class="container my-4">
    <h2>修改個人資料</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">帳號 (不可修改)</label>
            <input type="text" class="form-control" value="<?=htmlspecialchars($user['account'])?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">身分 (不可修改)</label>
            <input type="text" class="form-control" value="<?=($user['role']==='M')?'管理員':'學生'?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">姓名</label>
            <input type="text" name="name" class="form-control" value="<?=htmlspecialchars($user['name'])?>" required>
        </div>
        <hr>
        <h5>修改密碼</h5>
        <div class="mb-3">
            <label class="form-label">舊密碼</label>
            <input type="password" name="old_password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">新密碼</label>
            <input type="password" name="new_password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">確認新密碼</label>
            <input type="password" name="confirm_password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">更新資料</button>
    </form>
    <?=$msg?>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
