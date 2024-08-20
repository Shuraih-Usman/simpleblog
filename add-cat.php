<?php

$title = "Add new Category";
include ('includes/admin_header.php');

if($_SERVER['REQUEST_METHOD'] == "POST") {

    $title = $_POST['title'];

    if(empty($title)) {
        $error = " Category title cannot be null";
    } else {


        $stmt = $pdo->prepare("INSERT INTO category (title) VALUES (:title)");

        $stmt->bindParam(":title", $title, PDO::PARAM_STR);


            if($stmt->execute()) {
                $sucess = "You successfully add new category";
            } else {
                $error = "Error Fail";
            }

    }
}


?>

<div class="post-container">
        <h2>Create Category</h2>

        <?php

            if(isset($sucess)) {
                echo "<div style='margin:5px 5px;padding:10px 10px;color:green;'> $sucess </div>";
            } else if(isset($error)) {
                echo "<div style='margin:5px 5px;padding:10px 10px;color:red;'> $error </div>";
            }
            ?>

        <form method="POST">
            <div class="form-group">
                <label for="title"> Title</label>
                <input type="text" id="title" name="title">
            </div>
            <button type="submit">Publish</button>
        </form>
    </div>
</body>
</html>