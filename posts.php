<?php

$title = "Posts";
include ('includes/admin_header.php');

$stmt = $pdo->prepare("SELECT p.image, p.title, p.id, p.category_id as cat_id, p.created_at, c.title as category_title FROM posts as p
                        JOIN category as c ON c.id = p.category_id");
$stmt->execute();
$posts = $stmt->fetchAll();

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    if($stmt->execute()) {
        $sucess = "Post Deleted Successfully";
    } else {
        $error = "Fail to delete";
    }
}

?>

<div class="dashboard-container">

        <?php

        if(isset($sucess)) {
            echo "<div style='margin:5px 5px;padding:10px 10px;color:green;'> $sucess </div>";
        } else if(isset($error)) {
            echo "<div style='margin:5px 5px;padding:10px 10px;color:red;'> $error </div>";
        }
        ?>

        <h2>All Posts</h2>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Replace with dynamic content -->

                <?php foreach($posts as $row): ?>
                <tr>
                    <td><img src="assests/img/<?php echo $row['image']?> " width="60px" height="60px"/></td>
                    <td><a href=" single.php?id=<?php echo $row['id']?> "><?php echo $row['title']?></a></td>
                    <td><?php echo $row['category_title']?></td>
                    <td><?php echo date('D d, M Y', strtotime($row['created_at'])) ?></td>
                    <td>
                        <a href="edit-post.php?id=<?php echo $row['id']?>">Edit</a> |
                        <a href="?id=<?php echo $row['id']?>">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <!-- Repeat for more posts -->
            </tbody>
        </table>
    </div>
    

</body>
</html>