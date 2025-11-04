<?php
$title = "登入";
include('header.php'); // header.php 已經有 session_start()
require_once 'db.php'; // 連線資料庫
$error = '';

// 取得 redirect（登入前想進的頁面）
$redirect = $_GET['redirect'] ?? 'index.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $account = $_POST["account"] ?? '';
    $password = $_POST["password"] ?? '';

    // 避免 SQL Injection
    $account = mysqli_real_escape_string($conn, $account);
    $password = mysqli_real_escape_string($conn, $password);

    // 從資料庫查詢使用者
    $sql = "SELECT account, password, name, role FROM user WHERE account = '$account'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // 簡單比對密碼（未加密）
        if ($password === $user['password']) {
            $_SESSION['user'] = [
                'account' => $user['account'],
                'name' => $user['name'],
                'role' => $user['role']
            ];
            // 登入成功導向原本頁面
            header("Location: $redirect");
            exit;
        } else {
            $error = "帳號或密碼錯誤";
        }
    } else {
        $error = "帳號或密碼錯誤";
    }
}
mysqli_close($conn);
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
