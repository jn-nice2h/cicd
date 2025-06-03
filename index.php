<?php
// index.php - モダン掲示板
$messages = [];

// IPアドレス取得関数
function getClientIP() {
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    return $_SERVER['REMOTE_ADDR'];
}

// 都道府県取得関数
function getPrefecture($ip) {
    $url = "https://ipapi.co/{$ip}/json/";
    $response = @file_get_contents($url);
    if ($response) {
        $data = json_decode($response, true);
        return $data['region'] ?? '不明';
    }
    return '不明';
}

// メッセージファイル読み込み
if (file_exists('messages.txt')) {
    $content = file_get_contents('messages.txt');
    $messages = $content ? json_decode($content, true) : [];
}

// 投稿処理
if ($_POST['message'] ?? false) {
    $ip = getClientIP();
    $prefecture = getPrefecture($ip);
    $new_message = [
        'content' => htmlspecialchars($_POST['message']),
        'datetime' => date('Y-m-d H:i:s'),
        'ip' => $ip,
        'prefecture' => $prefecture
    ];
    $messages[] = $new_message;
    file_put_contents('messages.txt', json_encode($messages));
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>モダン掲示板</title>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'M PLUS Rounded 1c', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h1 {
            color: #6c5ce7;
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 30px;
        }
        .success {
            background: #a8e6cf;
            color: #2d3436;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 30px;
        }
        textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            resize: vertical;
            min-height: 100px;
            margin-bottom: 10px;
            font-family: inherit;
        }
        button {
            background: #6c5ce7;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background 0.3s;
        }
        button:hover {
            background: #5b4bc4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #6c5ce7;
            color: white;
        }
        tr:nth-child(even) {
            background: #f8f9fa;
        }
        tr:hover {
            background: #f1f3f5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>💬 モダン掲示板</h1>
        
        <?php if (isset($success)): ?>
            <div class="success">✨ 投稿が完了しました！</div>
        <?php endif; ?>
        
        <form method="POST">
            <textarea name="message" placeholder="メッセージを入力してください..." required></textarea><br>
            <button type="submit">投稿する 📝</button>
        </form>
        
        <h2>💭 メッセージ一覧</h2>
        <table>
            <thead>
                <tr>
                    <th>投稿日時</th>
                    <th>メッセージ</th>
                    <th>IPアドレス</th>
                    <th>都道府県</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_reverse($messages) as $msg): ?>
                    <tr>
                        <td><?= htmlspecialchars($msg['datetime']) ?></td>
                        <td><?= nl2br(htmlspecialchars($msg['content'])) ?></td>
                        <td><?= htmlspecialchars($msg['ip']) ?></td>
                        <td><?= htmlspecialchars($msg['prefecture']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
