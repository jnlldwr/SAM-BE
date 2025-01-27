<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['content']) && !empty($_POST['content'])) {
        $content = $_POST['content'];
        $userID = $_SESSION['userID']; // Ensure userID is set in session

        $imageUrl = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $imagePath = 'uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            $imageUrl = $imagePath;
        }

        $stmt = $pdo->prepare("INSERT INTO posts (userID, content, imageUrl) VALUES (:userID, :content, :imageUrl)");
        if ($stmt->execute(['userID' => $userID, 'content' => $content, 'imageUrl' => $imageUrl])) {
            echo "Post created successfully!";
        } else {
            echo "Error: Unable to create the post.";
        }
    } else {
        echo "Content cannot be empty.";
    }
}

$isAdminPage = strpos($_SERVER['REQUEST_URI'], '/admin') !== false;

if ($isAdminPage) {
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.userID = users.userID ORDER BY postDate DESC");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.userID = users.userID ORDER BY postDate DESC");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OLYMPICS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="https://github.com/jnlldwr/SAM-BE/blob/main/F01/icon.png?raw=true" type="image/x-icon">
    <style>
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        #content {
            display: flex;
            flex-grow: 1;
            overflow: hidden;
        }

        .sidebar {
            background-color: #004974;
            padding: 10px;
            width: 250px;
            transition: width 0.3s ease;
            overflow-x: hidden;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: white;
        }

        .sidebar .nav-link i {
            font-size: 20px;
        }

        .sidebar .nav-link span {
            margin-left: 10px;
            white-space: nowrap;
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }

            .sidebar .nav-link span {
                display: none;
            }

            .sidebar .nav-link i {
                font-size: 24px;
            }
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .trending {
            width: 300px;
            background-color: #f8f9fa;
            padding: 20px;
            overflow-y: auto;
        }

        .post {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .post .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .post .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .post .buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }

        .navbar {
            background-color: #004974;
            color: white;
        }

        .navbar .navbar-brand,
        .navbar .nav-link {
            color: white;
        }

        .card-link {
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .card-body {
            cursor: pointer;
        }

        .dropdown-menu {
            right: 0;
            left: auto;
        }

        .dropdown-item {
            color: #000;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .trending .card {
            margin-bottom: 10px;
        }

        .trending .card-body {
            padding: 10px;
        }

        .trending .card-title {
            font-size: 16px;
            font-weight: bold;
        }

        .trending .card-text {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-white text-black sticky-top">
        <div class="container-fluid d-flex justify-content-between">
            <a class="navbar-brand" href="index.php">
                <img src="https://github.com/jnlldwr/SAM-BE/blob/main/F01/logoWhite.png?raw=true" width="80">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (!isset($_SESSION['username'])): ?>
                        <li class="nav-item"><a class="nav-link" href="signin.php">Sign In</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user-circle"></i> <?= $_SESSION['username'] ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="content">
        <aside class="sidebar">
            <div class="card mb-2">
                <a href="index.php" class="card-link text-decoration-none">
                    <div class="card-body d-flex align-items-center">
                        <i class="fa fa-home me-3"></i>
                        <span>Home</span>
                    </div>
                </a>
            </div>
            <div class="card mb-2">
                <a href="#" class="card-link text-decoration-none">
                    <div class="card-body d-flex align-items-center">
                        <i class="fa fa-envelope me-3"></i>
                        <span>Messages</span>
                    </div>
                </a>
            </div>
            <div class="card mb-2">
                <a href="#" class="card-link text-decoration-none">
                    <div class="card-body d-flex align-items-center">
                        <i class="fa fa-users me-3"></i>
                        <span>Communities</span>
                    </div>
                </a>
            </div>
        </aside>

        <main class="main-content">
            <?php if ($isAdminPage): ?>
                <h1>Admin Dashboard</h1>
                <div class="mb-5">
                    <h2>Users</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
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

                <div class="mb-5">
                    <h2>Posts</h2>
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
                                    <td><?= $post['content'] ?></td>
                                    <td><?= $post['postDate'] ?></td>
                                    <td>
                                        <a href="index.php?admin=1&delete_id=<?= $post['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="post-form mb-3 pb-5">
                    <h4>Create a Post</h4>
                    <form method="POST" action="index.php" enctype="multipart/form-data">
                        <textarea name="content" class="form-control" rows="4" placeholder="Write something..." required></textarea>
                        <input type="file" name="image" class="form-control mt-2">
                        <button type="submit" class="btn btn-primary mt-3 float-end">Post</button>
                    </form>
                </div>

                <div id="posts">
                    <?php foreach ($posts as $post): ?>
                        <div class="post">
                            <div class="user-info">
                                <img src="" class="rounded-circle">
                                <div>
                                    <strong><?= htmlspecialchars($post['username']) ?></strong>
                                    <a href="#" class="text-decoration-none">@<?= htmlspecialchars($post['username']) ?></a>
                                </div>
                            </div>
                            <p><?= htmlspecialchars($post['content']) ?></p>
                            <div class="buttons">
                                <button class="btn"><i class="fa fa-comment"></i></button>
                                <button class="btn"><i class="fa fa-heart"></i></button>
                                <button class="btn"><i class="fa fa-retweet"></i></button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>