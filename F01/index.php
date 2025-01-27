<?php
session_start();


if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
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
                        <li class="nav-item dropdown d-none">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i>
                                <?= $_SESSION['username'] ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
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
            <div class="post">
                <div class="user-info">
                    <img src="">
                    <div>
                        <strong>Name</strong>
                        <a href=" #" class="text-decoration-none">@username</a>
                    </div>
                </div>
                <p>Text content</p>
                <img src="" class="img-fluid">
                <div class="buttons">
                    <button class="btn"><i class="fa fa-comment"></i></button>
                    <button class="btn"><i class="fa fa-heart"></i></button>
                    <button class="btn"><i class="fa fa-retweet"></i></button>
                </div>
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