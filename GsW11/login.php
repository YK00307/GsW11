<link rel="stylesheet" href="style.css">

<?php
session_start();
require('db.php');
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE username=?');
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();
    if ($user && password_verify($_POST['password'], $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'ログイン失敗';
    }
}
?>
<form method="post">
    ID: <input type="text" name="username"><br>
    PASS: <input type="password" name="password"><br>
    <input type="submit" value="ログイン">
</form>
<p><?=htmlspecialchars($error)?></p>
<a href="newregister.php">新規登録はこちら</a>
