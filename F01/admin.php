<?php
session_start();
require 'config.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['is_admin'] != 1) {
    header('Location: login.php');
    exit();
}

// Fetch all users and posts if the user is an admin
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT posts.id, posts.content, posts.postDate, users.username FROM posts JOIN users ON posts.userID = users.userID ORDER BY postDate DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle deletion of posts
if (isset($_GET['delete_id'])) {
    $postId = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
    if ($stmt->execute(['id' => $postId])) {
        header('Location: admin.php');
        exit();
    } else {
        echo "Error deleting post.";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .admin-container {
            padding: 20px;
        }

        .admin-section {
            margin-bottom: 30px;
        }

        .table th,
        .table td {
            text-align: center;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="admin-container">
        <h1>Admin Dashboard</h1>

        <div class="admin-section">
            <h2>Manage Users</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['userID'] ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['is_admin'] ? 'Admin' : 'User' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="admin-section">
            <h2>Manage Posts</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Post ID</th>
                        <th>Username</th>
                        <th>Content</th>
                        <th>Posted On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?= $post['id'] ?></td>
                            <td><?= $post['username'] ?></td>
                            <td><?= htmlspecialchars($post['content']) ?></td>
                            <td><?= $post['postDate'] ?></td>
                            <td>
                                <a href="admin.php?delete_id=<?= $post['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>