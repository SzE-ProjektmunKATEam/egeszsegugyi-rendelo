<?php 
    $testUser = "admin@admin.com";
    $testPass = "admin";

    //check if user has login token
    if(!$_POST['email'] || !$_POST['password'])
    {
        return header('Location: /login.php?message=error');
    }
    if($_POST['email'] != $testUser || $_POST['password'] != $testPass)
    { 
        return header('Location: /login.php?message=notMatched');
    }
    session_start();
    $_SESSION['logged_in'] = "logged";
    return header('Location: /admin.php');
?>