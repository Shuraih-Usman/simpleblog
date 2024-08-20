<?php

if(!session_id()) {
    session_start();
}
require_once('database.php');

try {
    $pdo = new PDO("mysql:host=$databasehost;dbname=$databasename", $databaseuser, $databasepassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection Failed ".$e->getMessage());
}

$dashboard_server = $_SERVER['REQUEST_URI'];

if($dashboard_server == "/dashboard.php" | $dashboard_server == '/add-post.php' | $dashboard_server == '/add-cat.php' | $dashboard_server == '/posts.php' | $dashboard_server == '/edit-post.php' | $dashboard_server == '/cats.php' | $dashboard_server == '/edit-cat.php') {

    if(!isset($_SESSION['userID']) && !isset($_SESSION['userName'])) {
        header("Location: login.php");
    }
}



