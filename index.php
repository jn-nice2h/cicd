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
    <title>シンプル掲示板2025</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            animation: fadeInUp 0.8s ease-out;
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
        
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .header h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header p {
            color: rgba(255,255,255,0.8);
            font-size: 1.1rem;
            font-weight: 300;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
        
        .success-message {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            animation: slideIn 0.5s ease-out;
        }
        
        .success-message i {
            margin-right: 0.5rem;
            font-size: 1.2rem;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #555;
        }
        
        textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-family: inherit;
            font-size: 1rem;
            resize: vertical;
            min-height: 120px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        textarea:focus {
            outline: none;
            border-color: #4CAF50;
            background: white;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }
        
        .btn {
            background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 150px;
            justify-content: center;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(76, 175, 80, 0.3);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .messages-section h2 {
            color: #333;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .message-item {
            background: #f8f9fa;
            border-left: 4px solid #4CAF50;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            animation: messageSlideIn 0.5s ease-out;
        }
        
        .message-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }
        
        @keyframes messageSlideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .message-time {
            color: #4CAF50;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .message-content {
            color: #555;
            margin-top: 0.3rem;
            line-height: 1.6;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #666;
        }
        
        .empty-state i {
            font-size: 3rem;
            color: #ccc;
            margin-bottom: 1rem;
        }
        
        .empty-state p {
            font-size: 1.1rem;
        }
        
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
            
            .card {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }
            
            .container {
                padding: 0 10px;
            }
        }
        
        .footer {
            text-align: center;
            margin-top: 2rem;
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <h1>シンプル掲示板</h1>
    
    <?php if (isset($success)): ?>
        <p style="color: green;">投稿完了</p>
    <?php endif; ?>
    
    <form method="POST">
        <textarea name="message" placeholder="メッセージを入力 " required></textarea><br>
        <button type="submit">投稿</button>
    </form>
    
    <script>
        // フォーム送信後にテキストエリアをクリア
        <?php if (isset($success)): ?>
            document.getElementById('message').value = '';
        <?php endif; ?>
        
        // スムーズスクロール効果
        document.addEventListener('DOMContentLoaded', function() {
            const messages = document.querySelectorAll('.message-item');
            messages.forEach((message, index) => {
                message.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>
