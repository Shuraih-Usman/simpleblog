<?php

if(!$_GET['id']) {
    header("Location:posts.php");
}  else {

    $title = "Edit Post";
    include ('includes/admin_header.php');

    $id  = $_GET['id'];

    $stmt = $pdo->prepare("SELECT p.*, c.id as cat_id, c.title as cat_title FROM posts as p
                        JOIN category as c ON c.id = p.category_id 
                        WHERE p.id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT * FROM category");
    $stmt->execute();
    $category = $stmt->fetchAll();



    if($_SERVER['REQUEST_METHOD'] == "POST") {

        $title = $_POST['title'];
        $category = $_POST['cats'];
        $content = $_POST['content'];
        $img = $_POST['img'];
        
        $image = $_FILES['image'];
    
        $imagename = $image['name'];
        $imageTmp = $image['tmp_name'];
        $imageSize = $image['size'];
    
        $allowedExt = ['jpg', 'jpeg', 'jfif', 'webp', 'png', 'gif'];
        $imageExt = pathinfo($imagename, PATHINFO_EXTENSION);
    
        if(empty($imagename)) {

            try {
                $stmt = $pdo->prepare("UPDATE posts SET title = :title, category_id = :cat, content = :content WHERE id= :id");
                $stmt->bindParam(":title", $title, PDO::PARAM_STR);
                $stmt->bindParam(":cat", $category, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id, PDO::PARAM_STR);
                $stmt->bindParam(":content", $content, PDO::PARAM_STR);
        
        
                    if($stmt->execute()) {
                        $sucess = "You successfully edit this post $title";
                    } else {
                        $error = "Error Fail";
                    }
            } catch(PDOException $e) {
                $error = "Error 1 ". $e->getMessage();
            } 

        } else {

            if(empty($title) | empty($category) | empty($content)) {
                $error = " All fiels are required";
            } else if($imageSize > 2000000) {
                $error = "Image size must not be greater than 2MB";
            } else if(!in_array($imageExt, $allowedExt))  {
                $error = "Image format not supported";
            } else {
        
                $folder = "assests/img/";
                $target_file = $folder.$imagename;
        
                if(move_uploaded_file($imageTmp, $target_file)) {
        
                    try {
                        $stmt = $pdo->prepare("UPDATE posts SET title = :title, category_id = :cat, content = :content, image = :image WHERE id= :id");
                        $stmt->bindParam(":title", $title, PDO::PARAM_STR);
                        $stmt->bindParam(":cat", $category, PDO::PARAM_STR);
                        $stmt->bindParam(":content", $content, PDO::PARAM_STR);
                        $stmt->bindParam(":image", $imagename, PDO::PARAM_STR);
                        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
                
                
                            if($stmt->execute()) {
                                $sucess = "You successfully edit this post $title";
                            } else {
                                $error = "Error Fail";
                            }
                    } catch(PDOException $e) {
                        $error = $e->getMessage();
                    } 
                } else {
                    $error = "Image uplodaed fail";
                }
        
        
        
            }
        }
    

    }

    ?>

<div class="post-container">
        <h2>Edit Post</h2>

        <?php

                if(isset($sucess)) {
                    echo "<div style='margin:5px 5px;padding:10px 10px;color:green;'> $sucess </div>";
                } else if(isset($error)) {
                    echo "<div style='margin:5px 5px;padding:10px 10px;color:red;'> $error </div>";
                }
                ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="img" value="<?=$post['image']?>">
            <div class="form-group">
                <label for="title">Post Title</label>
                <input type="text" id="title" name="title" value="<?=$post['title']?>" required>
            </div>
            <div class="form-group">
                <img src="assests/img/<?=$post['image']?>" width="200px"/>
                <label for="author">Image</label>
                <input type="file" id="author" name="image">
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select style="width: 100%;" name="cats" id="">
                    <option value="<?=$post['cat_id']?>"><?=$post['cat_title']?></option>
                    <?php
                    foreach($category as $row) {
                        echo "<option value='{$row['id']}'>{$row['title']} </option>";
                    }

                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" rows="10" required><?=$post['content']?></textarea>
            </div>
            <button type="submit">Update</button>
        </form>
    </div>
    

</body>
</html>



<?php
}