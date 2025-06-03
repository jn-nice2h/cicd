<?php
session_start();
require_once '../models/Task.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$task = new Task();
$error = '';
$message = '';

// タスク作成
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task->title = $_POST['title'] ?? '';
    $task->description = $_POST['description'] ?? '';
    $task->status = '未着手';
    $task->priority = $_POST['priority'] ?? '中';
    $task->due_date = $_POST['due_date'] ?? null;
    $task->user_id = $_SESSION['user_id'];

    if ($task->create()) {
        $message = 'タスクを作成しました。';
    } else {
        $error = 'タスクの作成に失敗しました。';
    }
}

// タスク一覧取得
$tasks = $task->read($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク一覧 - タスク管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">タスク管理</a>
            <div class="navbar-nav ms-auto">
                <span class="nav-item nav-link text-white">
                    <?php echo htmlspecialchars($_SESSION['username']); ?>さん
                </span>
                <a class="nav-link" href="logout.php">ログアウト</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">新規タスク作成</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="title" class="form-label">タイトル</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">説明</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="priority" class="form-label">優先度</label>
                                <select class="form-select" id="priority" name="priority">
                                    <option value="低">低</option>
                                    <option value="中" selected>中</option>
                                    <option value="高">高</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="due_date" class="form-label">期限</label>
                                <input type="date" class="form-control" id="due_date" name="due_date">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">作成</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <h4>タスク一覧</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>タイトル</th>
                                <th>状態</th>
                                <th>優先度</th>
                                <th>期限</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $tasks->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                    <td><?php echo htmlspecialchars($row['priority']); ?></td>
                                    <td><?php echo $row['due_date'] ? htmlspecialchars($row['due_date']) : '未設定'; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 