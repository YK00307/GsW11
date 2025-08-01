<?php
session_start();
require('db.php');

// ログイン必須ならこのチェックを有効に（不要ならコメントアウト可能）
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// 実践編問題をランダムに1件取得
$stmt = $pdo->query("SELECT * FROM questions WHERE category='実践' ORDER BY RAND() LIMIT 1");
$q = $stmt->fetch();

if (!$q) {
    echo '<p>実践問題がありません。</p>';
    exit;
}
$_SESSION['question_id'] = $q['id'];

// 手牌JSONと選択肢JSONの解凍
$tiles = json_decode($q['tiles_json'], true);
$choices = json_decode($q['choices_json'], true);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>実践編 問題</title>
<style>
body {
    background-color: #0b3d0b;
    color: #fff;
    font-family: 'Arial', sans-serif;
    text-align: center;
    padding: 20px;
}
.tile-set img {
    margin: 0 5px;
    width: 40px;
    cursor: default;
}
button {
    border: none;
    background: #f1e7c9;
    color: #1a1a1a;
    font-weight: 600;
    border-radius: 6px;
    padding: 10px 20px;
    margin: 8px;
    cursor: pointer;
    box-shadow: 0 3px 0 #b89d53;
    transition: background-color 0.3s ease;
}
button:hover {
    background-color: #fffde7;
}
input[type=text] {
    border-radius: 6px;
    border: 1.5px solid #b1b174;
    padding: 8px 15px;
    font-size: 1rem;
    margin: 15px 0;
    width: 220px;
    text-align: center;
    outline: none;
    transition: border-color 0.3s ease;
}
input[type=text]:focus {
    border-color: #f5f3be;
}
</style>
</head>
<body>

<p>この手牌で、あと1枚どの牌を引けば「<?=htmlspecialchars($q['yaku_name'])?>」を完成できるでしょう？</p>

<div class="tile-set">
<?php foreach($tiles as $tile): ?>
    <img src="images/titles/<?=htmlspecialchars($tile)?>.jpg" alt="<?=htmlspecialchars($tile)?>">
<?php endforeach; ?>
</div>

<form method="post" action="correct.php">
    <input type="hidden" name="mode" value="jissen">
    <?php foreach($choices as $c): ?>
        <button type="submit" name="answer" value="<?=htmlspecialchars($c)?>">
            <img src="images/titles/<?=htmlspecialchars($c)?>.jpg" alt="<?=htmlspecialchars($c)?>">
        </button>
    <?php endforeach; ?>
</form>

</body>
</html>
