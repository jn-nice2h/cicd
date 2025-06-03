<?php
require_once 'config/database.php';
require_once 'models/Task.php';
require_once 'models/User.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = new Task();
    $task->title = $_POST['title'];
    $task->description = $_POST['description'];
    $task->status = $_POST['status'];
    $task->priority = $_POST['priority'];
    $task->due_date = $_POST['due_date'];
    $task->progress = $_POST['progress'];
    $task->project_id = $_POST['project_id'] ?: null;
    $task->created_by = $_SESSION['user_id'];
    $task->assigned_to = $_POST['assigned_to'] ?: null;

    if ($task->create()) {
        $_SESSION['message'] = 'タスクを作成しました。';
        $_SESSION['message_type'] = 'success';
        header('Location: tasks.php');
        exit;
    } else {
        $_SESSION['message'] = 'タスクの作成に失敗しました。';
        $_SESSION['message_type'] = 'danger';
    }
}

require_once 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3>新規タスク作成</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="title" class="form-label">タイトル</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">説明</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">ステータス</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="not_started">未着手</option>
                                <option value="in_progress">進行中</option>
                                <option value="completed">完了</option>
                                <option value="on_hold">保留</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="priority" class="form-label">優先度</label>
                            <select class="form-select" id="priority" name="priority" required>
                                <option value="low">低</option>
                                <option value="medium" selected>中</option>
                                <option value="high">高</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="due_date" class="form-label">期限</label>
                            <input type="date" class="form-control" id="due_date" name="due_date">
                        </div>
                        <div class="col-md-6">
                            <label for="progress" class="form-label">進捗 (%)</label>
                            <input type="number" class="form-control" id="progress" name="progress" 
                                   min="0" max="100" value="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="assigned_to" class="form-label">担当者</label>
                        <select class="form-select" id="assigned_to" name="assigned_to">
                            <option value="">選択してください</option>
                            <?php
                            $user = new User();
                            $users = $user->getAll();
                            foreach ($users as $u) {
                                echo '<option value="' . $u['id'] . '">' . 
                                     htmlspecialchars($u['username']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">作成</button>
                        <a href="tasks.php" class="btn btn-secondary">キャンセル</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 