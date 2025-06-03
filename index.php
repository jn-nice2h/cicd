<?php
// index.php - デザイン性豊かな掲示板
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
    <title>✨ モダン掲示板 ✨</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            animation: fadeInUp 0.8s ease-out;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }

        .header h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: bounce 1s ease-in-out;
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .post-form {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 1.1rem;
        }

        .form-textarea {
            width: 100%;
            min-height: 120px;
            padding: 15px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 1rem;
            font-family: inherit;
            resize: vertical;
            transition: all 0.3s ease;
            background: #fafbfc;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
        }

        .submit-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .success-message {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: white;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
            animation: slideInDown 0.5s ease-out;
            box-shadow: 0 5px 15px rgba(17, 153, 142, 0.3);
        }

        .messages-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .messages-title {
            font-size: 1.8rem;
            margin-bottom: 25px;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .message-card {
            background: linear-gradient(135deg, #f8f9ff, #e8f2ff);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
            animation: fadeIn 0.6s ease-out;
        }

        .message-card:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.15);
        }

        .message-card:last-child {
            margin-bottom: 0;
        }

        .message-time {
            color: #667eea;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .message-content {
            margin-top: 8px;
            font-size: 1.05rem;
            line-height: 1.6;
            color: #444;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #888;
            font-size: 1.1rem;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #ccc;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }
            
            .header h1 {
                font-size: 2.2rem;
            }
            
            .post-form, .messages-section {
                padding: 20px;
                border-radius: 15px;
            }
            
            .submit-btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* スクロールバーのカスタマイズ */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-comments"></i> モダン掲示板</h1>
            <p>みんなでメッセージを共有しましょう！</p>
        </div>
        
        <?php if (isset($success)): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i> メッセージを投稿しました！
            </div>
        <?php endif; ?>
        
        <div class="post-form">
            <form method="POST">
                <div class="form-group">
                    <label for="message" class="form-label">
                        <i class="fas fa-pen"></i> あなたのメッセージ
                    </label>
                    <textarea 
                        id="message"
                        name="message" 
                        class="form-textarea"
                        placeholder="何か素敵なメッセージを書いてください..." 
                        required
                    ></textarea>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    メッセージを投稿
                </button>
            </form>
        </div>
        
        <div class="messages-section">
            <h2 class="messages-title">
                <i class="fas fa-list"></i>
                メッセージ一覧 (<?= count($messages) ?>件)
            </h2>
            
            <?php if (empty($messages)): ?>
                <div class="empty-state">
                    <i class="fas fa-comment-slash"></i>
                    <p>まだメッセージがありません<br>最初のメッセージを投稿してみましょう！</p>
                </div>
            <?php else: ?>
                <?php foreach (array_reverse($messages) as $msg): ?>
                    <?php 
                    $parts = explode(' - ', $msg, 2);
                    $time = $parts[0] ?? '';
                    $content = $parts[1] ?? $msg;
                    ?>
                    <div class="message-card">
                        <div class="message-time">
                            <i class="fas fa-clock"></i> <?= htmlspecialchars($time) ?>
                        </div>
                        <div class="message-content">
                            <?= htmlspecialchars($content) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // フォーム送信時のアニメーション
        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = document.querySelector('.submit-btn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 投稿中...';
            btn.disabled = true;
        });

        // メッセージカードの遅延アニメーション
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.message-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>
