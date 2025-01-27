<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $_POST['content'];
    $username = $_SESSION['username'];

    $stmt = $pdo->prepare("INSERT INTO posts (username, content) VALUES (:username, :content)");
    $stmt->execute(['username' => $username, 'content' => $content]);

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
