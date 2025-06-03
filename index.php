<?php
// index.php - 超シンプル掲示板（15行）
$messages = [];

// メッセージファイル読み込み
if (file_exists('messages.txt')) {
    $content = file_get_contents('messages.txt');
    $messages = $content ? explode("\n", trim($content)) : [];
}

// 投稿処理
if ($_POST['message'] ?? false) {
    $new_message = date('H:i') . ' - ' . htmlspecialchars($_POST['message']);
    $messages[] = $new_message;
    file_put_contents('messages.txt', implode("\n", $messages));
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>シンプル掲示板(中島)</title>
</head>
<body>
    <h1>【テスト】シンプル掲示板</h1>
    
    <?php if (isset($success)): ?>
        <p style="color: green;">投稿しました！</p>
    <?php endif; ?>
    
    <form method="POST">
        <textarea name="message" placeholder="メッセージを入力 " required></textarea><br>
        <button type="submit">投稿</button>
    </form>
    
    <h2>メッセージ一覧</h2>
    <?php foreach (array_reverse($messages) as $msg): ?>
        <p><?= $msg ?></p>
    <?php endforeach; ?>
</body>
</html>
