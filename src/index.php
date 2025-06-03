<?php
$host = 'mysql';
$db   = 'testdb';
$user = 'testuser';
$pass = 'testpass';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
    $pdo = new PDO($dsn, $user, $pass);
    echo "データベース接続成功！\n";
    echo "PHP Version: " . phpversion();
} catch (\PDOException $e) {
    echo "接続失敗: " . $e->getMessage();
} 