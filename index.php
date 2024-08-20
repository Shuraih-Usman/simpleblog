<?php

$title = "Home";
require_once("includes/header.php");

$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;


$stmt = $pdo->prepare("SELECT COUNT(*) FROM posts");
$stmt->execute();
$total = $stmt->fetchColumn();
$total_pages = ceil($total / $limit);


$stmt = $pdo->prepare("SELECT p.*, c.id as cat_id, c.title as cat_title FROM posts as p
                        LEFT JOIN category as c ON c.id = p.category_id 
                        ORDER BY p.id DESC 
                        LIMIT :start, :limit");
$stmt->bindParam(":start", $start, PDO::PARAM_INT);
$stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<main>
    <section class="posts-grid">
        <?php foreach($posts as $post) : ?>
      <article class="post">
        <img src="assests/img/<?php echo $post['image'];?>" width="300px" height="300px" alt="<?php echo $post['title'];?>">
        <h2><?php echo $post['title'];?></h2>
        <a href="category.php?id=<?php echo $post['cat_id'];?>"><?php echo $post['cat_title'];?></a>
        <p><?php echo description($post['content']);?>.</p>
        <a href="single.php?post=<?php echo $post['id'];?>">Read More</a>
      </article>
      <?php endforeach; ?>

    </section>
    


    <div class="pagination">

    <?php if($page > 1) {
        echo '<a href="?page='.$page - 1 .'">&laquo; Previous</a>';
    }

    for($i =1; $i <= 3 && $i <= $total_pages; $i++) {
        echo '<a href="?page='. $i .'">'. $i .'</a>';
    }
     
    //   
    //   <a href="#">2</a>
    //   <a href="#">3</a>

      if($page < $total_pages) {
        echo '<a href="?page='.$page + 1 .'">Next &raquo;</a>';
      }

      ?>
      


    </div>
</main>

<?php
require_once("includes/footer.php");