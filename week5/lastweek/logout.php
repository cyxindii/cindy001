
<?php
session_start();          // 開啟 session
session_destroy();        // 銷毀 session
header("Location: index.php"); // 登出後導回登入頁
exit;
?>
