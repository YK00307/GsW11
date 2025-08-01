<link rel="stylesheet" href="style.css">

<?php
require('db.php');
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    try {
        $stmt = $pdo->prepare('INSERT INTO users(username, password_hash) VALUES (?,?)');
        $stmt->execute([$username, $pass]);
        $msg = '登録完了！';
    } catch (Exception $e) {
        $msg = '登録失敗: 同じIDが存在しています。';
    }
}
?>
<form method="post">
    ID: <input name="username"><br>
    PASS: <input type="password" name="password"><br>
    <button>登録</button>
</form>
<p style="color:green"><?=$msg?></p>
<a href="login.php">ログインはこちら</a>
