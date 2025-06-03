<?php
// index.php - モダンデザイン掲示板
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>シンプル掲示板2025</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: #f8f9fa;
            color: #212529;
        }
        .message-board {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .message-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .message-time {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .form-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .success-message {
            animation: fadeOut 3s forwards;
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            70% { opacity: 1; }
            100% { opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="message-board">
        <h1 class="text-center mb-4">シンプル掲示板</h1>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success success-message" role="alert">
                メッセージを投稿しました！
            </div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="POST">
                <div class="mb-3">
                    <textarea 
                        class="form-control" 
                        name="message" 
                        placeholder="メッセージを入力してください..." 
                        rows="3" 
                        required
                    ></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">投稿する</button>
            </form>
        </div>

        <h2 class="mb-3">メッセージ一覧</h2>
        <?php foreach (array_reverse($messages) as $msg): ?>
            <?php
            $parts = explode(' - ', $msg, 2);
            $time = $parts[0] ?? '';
            $content = $parts[1] ?? $msg;
            ?>
            <div class="message-card">
                <div class="message-time mb-1"><?= $time ?></div>
                <div class="message-content"><?= $content ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
