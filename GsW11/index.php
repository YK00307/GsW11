<link rel="stylesheet" href="style.css">

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>役を覚える麻雀ゲーム</h2>
<form method="get" action="kihon.php">
    <button name="mode" value="kihon">基本編</button>
</form>
<form method="get" action="jissen.php">
    <button name="mode" value="jissen">実践編</button>
</form>
<a href="login.php">ログアウト</a>

</body>
</html>
