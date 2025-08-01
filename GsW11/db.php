<?php
$host = 'mysql3109.db.sakura.ne.jp';  // 桜サーバーのMySQLホスト名
$dbname = 'rivside_gsw11';          // 桜サーバー上のデータベース名
$user = 'rivside_gsw11';                    // MySQLユーザー名
$password = 'HrhC5573';                // MySQLのパスワード

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
