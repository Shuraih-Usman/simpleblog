<?php

$title = "Add new Post";
include ('includes/admin_header.php');

if($_SERVER['REQUEST_METHOD'] == "POST") {

    $title = $_POST['title'];
    $category = $_POST['cats'];
    $content = $_POST['content'];
    $id = $_SESSION['userID'];
    
    $image = $_FILES['image'];

    $imagename = $image['name'];
    $imageTmp = $image['tmp_name'];
    $imageSize = $image['size'];

    $allowedExt = ['jpg', 'jpeg', 'jfif', 'webp', 'png', 'gif'];
    $imageExt = pathinfo($imagename, PATHINFO_EXTENSION);

    

    if(empty($title) | empty($category) | empty($content) | empty($imagename)) {
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
                $stmt = $pdo->prepare("INSERT INTO posts (title, category_id, user_id, content, image) VALUES (:title, :cat, :id, :content, :image)");
                $stmt->bindParam(":title", $title, PDO::PARAM_STR);
                $stmt->bindParam(":cat", $category, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id, PDO::PARAM_STR);
                $stmt->bindParam(":content", $content, PDO::PARAM_STR);
                $stmt->bindParam(":image", $imagename, PDO::PARAM_STR);
        
        
                    if($stmt->execute()) {
                        $sucess = "You successfully add new posts with name $title";
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

$stmt = $pdo->prepare("SELECT * FROM category");
$stmt->execute();
$category = $stmt->fetchAll();

?>


    <div class="post-container">
        <h2>Create New Post</h2>

        <?php

if(isset($sucess)) {
    echo "<div style='margin:5px 5px;padding:10px 10px;color:green;'> $sucess </div>";
} else if(isset($error)) {
    echo "<div style='margin:5px 5px;padding:10px 10px;color:red;'> $error </div>";
}
?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Post Title</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="title">Post Image</label>
                <input type="file" id="" name="image" required>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select style="width: 100%;" name="cats" id="">
                    <option>Select category</option>
                    <?php
                    foreach($category as $row) {
                        echo "<option value='{$row['id']}'>{$row['title']} </option>";
                    }

                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" rows="10" required></textarea>
            </div>
            <button type="submit">Publish</button>
        </form>
    </div>
</body>
</html>
