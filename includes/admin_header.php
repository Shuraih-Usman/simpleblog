<?php require_once("conn/connection.php") ;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> | Simple Blog</title>
    <link rel="stylesheet" href="/assests/css/admin_styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>SIMPLE BLOG ADMIN PANEL</h2>
        <nav>
            <ul>
                <li><a href="add-post.php">New Post</a></li>
                <li><a href="posts.php">Manage Posts</a></li>
                <li><a href="add-cat.php">New Category</a></li>
                <li><a href="cats.php">Manage Category</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>