<?php
$title = "刪除活動";
include("header.php");
include("db.php");

// 取得 id
$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $sql = "DELETE FROM event WHERE id=$id";
    mysqli_query($conn, $sql);
}

mysqli_close($conn);

// 刪除後導回活動列表
header("Location: index.php");
exit;
?>
