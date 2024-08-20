<?php

include("conn/connection.php");

if(!isset($_GET['post'])) {
header("Location: index.php");
} else {
    $id = $_GET['post'];

    
    
    $stmt = $pdo->prepare("SELECT p.*, a.name, a.username, c.id as cat_id, c.title as cat_title FROM posts as p
    LEFT JOIN category as c ON c.id = p.category_id 
    LEFT JOIN admins as a ON a.id = p.user_id WHERE p.id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch();

    if(!$post) {
        header("Location:index.php");
    } else {
        $title = $post['title'];
    }
}

require_once("includes/header.php");



?>


<main>
    <article class="single-post">
        <span>Category <a href="category.php?id=<?php echo $post['cat_id'];?>"><?php echo $post['cat_title'];?></a> </span> | <span>Post By <?php echo $post['name'];?></span> | <span>Created Date <?php echo   postDate($post['created_at']);  ?></span>
      <h2><?php echo $post['title'];?></h2>
      <img src="assests/img/<?php echo $post['image'];?>" alt="<?php echo $post['title'];?>">
      <p><?php echo $post['content'];?></p>
    </article>
  </main>

<?php
require_once("includes/footer.php");