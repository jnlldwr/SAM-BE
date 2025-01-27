<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['is_admin'] != 1) {
    header('Location: login.php');  // Redirect to login if not logged in or not an admin
    exit();
}

// Connect to the database
require 'config.php';

// Fetch all users from the database (you can modify this to fetch other data as needed)
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all posts from the database
$stmt = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.userID = users.userID ORDER BY postDate DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="https://github.com/jnlldwr/SAM-BE/blob/main/F01/icon.png?raw=true" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #004974;
            color: white;
        }

        .sidebar {
            background-color: #004974;
            color: white;
            height: 100vh;
            width: 250px;
            padding-top: 20px;
        }

        .sidebar .nav-link {
            color: white;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .main-content h1 {
            font-size: 36px;
            margin-bottom: 30px;
        }

        .post {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
        }

        .post .user-info {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .buttons .btn {
            margin-right: 5px;
        }

        .admin-table th,
        .admin-table td {
            padding: 10px;
        }

        .admin-table th {
            background-color: #f2f2f2;
        }

        .admin-table td {
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="https://github.com/jnlldwr/SAM-BE/blob/main/F01/logoWhite.png?raw=true" width="80">
            </a>
            <div class="d-flex ms-auto">
                <a class="btn btn-outline-light" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center text-white">Admin Panel</h3>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Posts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Settings</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Admin Dashboard</h1>

        <!-- Users Section -->
        <div class="mb-5">
            <h2>Users</h2>
            <table class="admin-table table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['userID'] ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['is_admin'] ? 'Admin' : 'User' ?></td>
                            <td>
                                <a href="edit_user.php?id=<?= $user['userID'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="delete_user.php?id=<?= $user['userID'] ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Posts Section -->
        <div class="mb-5">
            <h2>Posts</h2>
            <table class="admin-table table table-striped table-bordered">
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
                            <td><?= $post['content'] ?></td>
                            <td><?= $post['postDate'] ?></td>
                            <td>
                                <a href="edit_post.php?id=<?= $post['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="index.php?delete_id=<?= $post['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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