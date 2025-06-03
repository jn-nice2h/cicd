<?php
session_start();
require_once '../models/User.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($result = $user->login($email, $password)) {
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['username'] = $result['username'];
        header('Location: tasks.php');
        exit;
    } else {
        $error = 'メールアドレスまたはパスワードが正しくありません。';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン - タスク管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">ログイン</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">メールアドレス</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">パスワード</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">ログイン</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <a href="register.php">新規登録はこちら</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 