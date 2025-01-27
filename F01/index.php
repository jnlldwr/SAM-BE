<?php
session_start();
require 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['content']) && !empty($_POST['content'])) {
        $content = $_POST['content'];
        $userID = $_SESSION['userID'];

        $stmt = $pdo->prepare("INSERT INTO posts (userID, content) VALUES (:userID, :content)");
        if ($stmt->execute(['userID' => $userID, 'content' => $content])) {
            echo "Post created successfully!";
        } else {
            echo "Error: Unable to create the post.";
        }
    } else {
        echo "Content cannot be empty.";
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $userID = $_SESSION['userID'];

    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id AND userID = :userID");
    $stmt->execute(['id' => $delete_id, 'userID' => $userID]);
    $post = $stmt->fetch();

    if ($post) {
        $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
        $stmt->execute(['id' => $delete_id]);
        echo "Post deleted successfully!";
    } else {
        echo "You cannot delete this post.";
    }
}

$stmt = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.userID = users.userID ORDER BY postDate DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-white text-black sticky-top">
        <div class="container-fluid d-flex justify-content-between">
            <a class="navbar-brand" href="#">
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
                <a href="#" class="card-link text-decoration-none">
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
            <div class="post-form">
                <h4>Create a Post</h4>
                <form method="POST" action="index.php">
                    <textarea name="content" class="form-control" rows="4" placeholder="Write something..." required></textarea>
                    <button type="submit" class="btn btn-primary mt-3">Post</button>
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

                            <?php if ($post['userID'] == $_SESSION['userID']): ?>
                                <a href="index.php?delete_id=<?= $post['id'] ?>" class="btn btn-danger">
                                    <i class="fa fa-trash"></i> Delete
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>

        <aside class="trending d-none d-md-block">
            <h5 class="mb-3">Trending</h5>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">#Olympics</h6>
                    <p class="card-text text-muted">100K Posts</p>
                </div>
            </div>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">#GoldMedal</h6>
                    <p class="card-text text-muted">65K Posts</p>
                </div>
            </div>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">#Training</h6>
                    <p class="card-text text-muted">30K Posts</p>
                </div>
            </div>
            <a href="#" class="btn btn-link text-decoration-none">Show more</a>
        </aside>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>