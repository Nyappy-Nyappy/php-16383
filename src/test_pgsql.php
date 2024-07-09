<?php
$host = 'localhost';
$db = 'database';
$user = 'postgres';
$pass = 'stinger1126';
$charset = 'utf8';

$dsn = "pgsql:host=$host;port=5432;dbname=$db";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "PostgreSQLへの接続に成功しました！";
} catch (PDOException $e) {
    echo '接続失敗: ' . $e->getMessage();
}
?>
