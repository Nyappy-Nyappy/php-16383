<?php
// エラーハンドリングの設定
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// データベース接続設定
$host = 'dpg-cq6ekcbv2p9s73ckkgd0-a';
$db = 'database';
$user = 'postgres';
$pass = 'passwd';
$charset = 'utf8';

$dsn = "pgsql:host=$host;port=5432;dbname=$db";  // ダブルクォートを使用して変数を展開
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "接続に成功しました！<br>";
} catch (PDOException $e) {
    echo '接続に失敗しました: ' . $e->getMessage();
    exit;
}

// イシューの登録処理
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'])) {
    $stmt = $pdo->prepare("INSERT INTO issues (title, label, priority, status, issue_commit) VALUES (:title, :label, :priority, 'not_started', :issue_commit)");
    $stmt->bindParam(':title', $_POST['title']);
    $stmt->bindParam(':label', $_POST['label']);
    $stmt->bindParam(':priority', $_POST['priority']);
    $stmt->bindParam(':issue_commit', $_POST['issue_commit']);
    $stmt->execute();
}

// イシューの更新処理
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_id'])) {
    $stmt = $pdo->prepare("UPDATE issues SET status = :status, complete_commit = :complete_commit WHERE issue_id = :issue_id");
    $stmt->bindParam(':status', $_POST['status']);
    $stmt->bindParam(':complete_commit', $_POST['complete_commit']);
    $stmt->bindParam(':issue_id', $_POST['update_id']);
    $stmt->execute();
}

// イシューの取得
$stmt = $pdo->query("SELECT * FROM issues ORDER BY priority DESC");
$issues = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>イシュー管理システム</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>イシュー管理システム</h1>
        <form id="issue-form" action="issue_tracker.php" method="POST">
            <label for="title">タイトル:</label>
            <input type="text" id="title" name="title" required><br>
            <label for="label">ラベル:</label>
            <select id="label" name="label">
                <option value="bug">バグ</option>
                <option value="feature">機能要求</option>
            </select><br>
            <label for="priority">優先順位:</label>
            <input type="number" id="priority" name="priority" required><br>
            <label for="issue_commit">イシューコミットID:</label>
            <input type="text" id="issue_commit" name="issue_commit" required><br>
            <input type="submit" value="登録">
        </form>
        
        <div id="error-message"></div>
        
        <h2>イシューリスト</h2>
        <table border="1" id="issue-table">
            <thead>
                <tr>
                    <th>タイトル</th>
                    <th>ラベル</th>
                    <th>優先順位</th>
                    <th>ステータス</th>
                    <th>イシューコミットID</th>
                    <th>完了コミットID</th>
                    <th>更新</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($issues as $issue): ?>
                    <tr>
                        <td><?= htmlspecialchars($issue['title']) ?></td>
                        <td><?= htmlspecialchars($issue['label']) ?></td>
                        <td><?= htmlspecialchars($issue['priority']) ?></td>
                        <td>
                            <form action="issue_tracker.php" method="POST">
                                <input type="hidden" name="update_id" value="<?= $issue['issue_id'] ?>">
                                <select name="status">
                                    <option value="not_started" <?= $issue['status'] == 'not_started' ? 'selected' : '' ?>>未着手</option>
                                    <option value="in_progress" <?= $issue['status'] == 'in_progress' ? 'selected' : '' ?>>着手中</option>
                                    <option value="completed" <?= $issue['status'] == 'completed' ? 'selected' : '' ?>>完了</option>
                                </select>
                        </td>
                        <td>
                            <input type="text" name="complete_commit" value="<?= htmlspecialchars($issue['complete_commit']) ?>">
                        </td>
                        <td>
                            <input type="submit" value="更新">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
