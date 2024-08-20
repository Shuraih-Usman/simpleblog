
<?php 
$title = "Categories";
include ('includes/admin_header.php');

$stmt = $pdo->prepare("SELECT * FROM category");
$stmt->execute();
$cats = $stmt->fetchAll();


if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM category WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    if($stmt->execute()) {
        $sucess = "category Deleted Successfully";
    } else {
        $error = "Fail to delete";
    }
}

?>




<div class="dashboard-container">
        <h2>All Categories</h2>

        <?php

if(isset($sucess)) {
    echo "<div style='margin:5px 5px;padding:10px 10px;color:green;'> $sucess </div>";
} else if(isset($error)) {
    echo "<div style='margin:5px 5px;padding:10px 10px;color:red;'> $error </div>";
}
?>


        <table>
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Actions</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <!-- Replace with dynamic content -->

                <?php foreach($cats as $cat) :?>
                <tr>
                    <td><?php echo $cat['title']?></td>
                    <td>
                        <a href="edit-cat.php?id=<?php echo $cat['id']?>">Edit</a> |
                        <a href="?id=<?php echo $cat['id']?>">Delete</a>
                    </td>
                    <td><?php echo $cat['created_at']?></td>
                </tr>
                <?php endforeach; ?>
                <!-- Repeat for more categories -->
            </tbody>
        </table>
    </div>

</body>
</html>