<link rel="stylesheet" href="style.css">
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
require('db.php');

if (!isset($_SESSION['user_id'])) exit('ログインされていません。');
if (!isset($_SESSION['question_id'])) exit('問題がセットされていません。');
if (!isset($_POST['answer'])) exit('回答が送信されていません。');

$user_id = $_SESSION['user_id'];
$question_id = $_SESSION['question_id'];
$mode = $_POST['mode'] ?? '';

$stmt = $pdo->prepare('SELECT * FROM questions WHERE id=?');
$stmt->execute([$question_id]);
$q = $stmt->fetch();
if (!$q) exit('問題が見つかりません。');

$is_correct = false;
if ($mode === 'kihon') {
    $is_correct = (trim($_POST['answer']) === trim($q['answer']));
} elseif ($mode === 'jissen') {
    $is_correct = ($_POST['answer'] === $q['missing_tile']);
} else {
    exit('不明なモードです。');
}

// 回答履歴を保存
$stmt2 = $pdo->prepare("INSERT INTO answers(user_id, question_id, user_answer, is_correct) VALUES (?, ?, ?, ?)");
$stmt2->execute([$user_id, $question_id, $_POST['answer'], (int)$is_correct]);

// 表示するメッセージ
if ($is_correct) {
    echo "<p style='color:green;'>正解！</p>";
} else {
    if ($mode === 'kihon') {
        echo "<p style='color:red;'>不正解。正解は「" . htmlspecialchars($q['answer']) . "」です。</p>";
    } else {
        echo "<p style='color:red;'>不正解。正解は <img src='images/tiles/" . htmlspecialchars($q['missing_tile']) . ".png' width='40'> です。</p>";
    }
}

echo '<a href="index.php">スタート画面</a> | ';
echo '<a href="' . ($mode === 'kihon' ? 'kihon.php' : 'jissen.php') . '">次の問題へ</a>';
?>
