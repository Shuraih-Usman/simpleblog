<?php

if(!$_GET['id']) {
    header("Location:cats.php");
}  else {

    $title = "Edit Category";
    include ('includes/admin_header.php');

    $id  = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM category WHERE id =:id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch();




    if($_SERVER['REQUEST_METHOD'] == "POST") {

        $title = $_POST['title'];
       
    
        if(!empty($title)) {

            try {
                $stmt = $pdo->prepare("UPDATE category SET title = :title WHERE id= :id");
                $stmt->bindParam(":title", $title, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        
                    if($stmt->execute()) {
                        $sucess = "You successfully edit this category $title";
                    } else {
                        $error = "Error Fail";
                    }
            } catch(PDOException $e) {
                $error = "Error 1 ". $e->getMessage();
            } 

        }else {
            $error = "All fields are reuired";
        }

    }

    ?>

<div class="post-container">
        <h2>Edit Category</h2>

        <?php

                if(isset($sucess)) {
                    echo "<div style='margin:5px 5px;padding:10px 10px;color:green;'> $sucess </div>";
                } else if(isset($error)) {
                    echo "<div style='margin:5px 5px;padding:10px 10px;color:red;'> $error </div>";
                }
                ?>
        <form method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label for="title"> Title</label>
                <input type="text" id="title" name="title" value="<?=$post['title']?>" required>
            </div>
            <button type="submit">Update</button>
        </form>
    </div>
    

</body>
</html>



<?php
}