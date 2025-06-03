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
        :root {
            --primary-blue: #4a90e2;
            --light-blue: #f0f8ff;
            --accent-blue: #2c7be5;
        }
        body {
            background: linear-gradient(135deg, var(--light-blue) 0%, #e6f3ff 100%);
            color: #2c3e50;
            min-height: 100vh;
        }
        .message-board {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .board-title {
            color: var(--primary-blue);
            font-weight: 600;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        .message-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(74, 144, 226, 0.1);
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(74, 144, 226, 0.1);
            transition: transform 0.2s ease;
        }
        .message-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(74, 144, 226, 0.15);
        }
        .message-time {
            color: var(--primary-blue);
            font-size: 0.9rem;
            font-weight: 500;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(74, 144, 226, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(74, 144, 226, 0.1);
        }
        .form-control {
            border: 2px solid rgba(74, 144, 226, 0.2);
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
        }
        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            border-radius: 10px;
            padding: 0.5rem 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: var(--accent-blue);
            border-color: var(--accent-blue);
            transform: translateY(-1px);
        }
        .success-message {
            background-color: rgba(74, 144, 226, 0.1);
            border: 1px solid rgba(74, 144, 226, 0.2);
            color: var(--primary-blue);
            animation: fadeOut 3s forwards;
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            70% { opacity: 1; }
            100% { opacity: 0; }
        }
        .section-title {
            color: var(--primary-blue);
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(74, 144, 226, 0.2);
        }
    </style>
</head>
<body>
    <div class="message-board">
        <h1 class="text-center mb-4 board-title">シンプル掲示板</h1>
        
        <?php if (isset($success)): ?>
            <div class="alert success-message" role="alert">
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

        <h2 class="section-title">メッセージ一覧</h2>
        <?php foreach (array_reverse($messages) as $msg): ?>
            <?php
            $parts = explode(' - ', $msg, 2);
            $time = $parts[0] ?? '';
            $content = $parts[1] ?? $msg;
            ?>
            <div class="message-card">
                <div class="message-time mb-2"><?= $time ?></div>
                <div class="message-content"><?= $content ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
