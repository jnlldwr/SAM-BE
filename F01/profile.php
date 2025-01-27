<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

echo "Welcome, " . $_SESSION['username'];
?>

<h1>Profile</h1>
<p>Username: <?= $_SESSION['username'] ?></p>
<a href="logout.php">Logout</a>