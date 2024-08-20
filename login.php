<?php
$title = "Login Page";
include('includes/admin_header.php');


if($_SERVER['REQUEST_METHOD'] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username");
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch();

    if($user) {

        $oldpassword = $user['password'];

        if(password_verify($password, $oldpassword)) {
            $sucess = "You Successfully Login";
            $_SESSION['userID'] = $user['id'];
            $_SESSION['userName'] = $user['username'];
            header("Location: dashboard.php");
        } else {
            $error = "Invalid Password";
        }
    } else {
        $error = "Invalid username";
    }
}


?>


<div class="login-container">
        <h2>Admin Login</h2>
        <?php

        if(isset($sucess)) {
            echo "<div style='margin:5px 5px;padding:10px 10px;color:green;'> $sucess </div>";
        } else if(isset($error)) {
            echo "<div style='margin:5px 5px;padding:10px 10px;color:red;'> $error </div>";
        }
        ?>

        <form  method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>