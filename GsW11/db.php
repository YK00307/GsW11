<?php
$host = '';  // 桜サーバーのMySQLホスト名
$dbname = '';          // 桜サーバー上のデータベース名
$user = '';                    // MySQLユーザー名
$password = '';                // MySQLのパスワード

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    exit('DB接続エラー: ' . $e->getMessage());
}
?>
