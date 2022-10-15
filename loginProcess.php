<?php 
    $testUser = "admin";
    $testPass = "admin";

    if(!$_SESSION["logged_in"])
    header('Location: /login.html?message=error')

?>