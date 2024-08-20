<?php

include ('conn/connection.php');
if(isset($_SESSION['userID']) ) {
    unset($_SESSION['userID']);
    unset($_SESSION['userName']);
    session_destroy();
    header("Location: login.php");
}