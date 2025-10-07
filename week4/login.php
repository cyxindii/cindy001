<?php
require_once "user.php"; // 匯入使用者資料
$title = "登入";
include('header.php'); // header.php 裡已經有 session_start()
$error = '';

// 取得 redirect（登入前想進的頁面）
$redirect = $_GET['redirect'] ?? 'index.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $account = $_POST["account"] ?? '';
    $password = $_POST["password"] ?? '';

    if (isset($users[$account]) && $users[$account]['password'] === $password) {
        $_SESSION['user'] = [
            'account' => $account,
            'name' => $users[$account]['name'],
            'role' => $users[$account]['role']
        ];
        // 登入成功導向原本頁面
        header("Location: $redirect");
        exit;
    } else {
        $error = "帳號或密碼錯誤";
    }
}
?>

<div class="container my-5">
    <h2>登入</h2>
    <form method="post" class="mt-3">
        <div class="mb-3">
            <label class="form-label">帳號</label>
            <input type="text" name="account" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">密碼</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">登入</button>
    </form>
    <?php if ($error): ?>
        <div class="alert alert-danger mt-3"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>