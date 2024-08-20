<?php
require_once("conn/connection.php");
require_once("conn/functions.php") ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?> | Simple Blog</title>
  <link rel="stylesheet" href="assests/css/styles.css">
</head>
<body>
<header>
    <div class="header-content">
      <h1>Simple Blog</h1>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="login.php">Login</a></li>
        </ul>
      </nav>
      <form method="GET" action="search.php" class="search-form">
        <input type="text" name="search" placeholder="Search...">
        <button type="submit">Search</button>
      </form>
    </div>
  </header>