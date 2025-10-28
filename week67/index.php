<?php
$title = "活動列表";
include "header.php";
include "db.php";

// 取得登入使用者
$user = $_SESSION['user'] ?? null;

// 從資料庫讀取活動資料
$sql = "SELECT * FROM event ";
$result = mysqli_query($conn, $sql);

// 如果查詢失敗，顯示錯誤
if (!$result) {
    echo "<div class='alert alert-danger'>資料庫錯誤：" . mysqli_error($conn) . "</div>";
}
?>

<div class="container mt-4">

    <h2 class="mb-4">活動列表</h2>

    <?php if ($user && $user['role'] === 'M'): ?>
        <!-- 管理員可新增活動 -->
        <a href="activity_insert.php" class="btn btn-success mb-3">新增活動</a>
    <?php endif; ?>

    <div class="row">
        <?php if ($result): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars($row['description'])) ?></p>

                            <!-- 報名按鈕 -->
                            <?php if ($row['name'] === '迎新茶會'): ?>
                                <a href="status.php" class="btn btn-primary">報名去</a>
                            <?php elseif ($row['name'] === '資管一日營'): ?>
                                <a href="conference.php" class="btn btn-primary">報名去</a>
                            <?php else: ?>
                                <a href="#" class="btn btn-secondary">更多資訊</a>
                            <?php endif; ?>

                            <!-- 管理員刪除按鈕 -->
                        <?php if ($user && $user['role'] === 'M'): ?>
                            <a href="activity_delete.php?id=<?= $row['id'] ?>" 
                               class="btn btn-danger mt-2"
                               onclick="return confirm('確定要刪除此活動嗎？');">
                               刪除
                            </a>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<?php
mysqli_close($conn);
include "footer.php";
?>
