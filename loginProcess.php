<?php 
    require_once 'connect.php';

    $testUser = false;
    $testPass = false;

    $givenUser = $_POST['email'];
    $giverPass = $_POST['password'];

    $user_id = 0;

    $stmt = $conn->query("SELECT * FROM user");
    while ($row = $stmt->fetch()) {
      if($givenUser == $row['email']) $testUser = true;
      if($giverPass == $row['password']) $testPass = true;
      if( $testUser ||  $testPass)
      $user_id = $row['id'];
  }

    //check if user has login token
    if(!$_POST['email'] || !$_POST['password'])
    {
        return header('Location: /login.php?message=error');
    }
    if( ! $testUser || ! $testPass )
    { 
        return header('Location: /login.php?message=notMatched');
    }
    session_start();
    $_SESSION['logged_in'] = "logged";
    $_SESSION['user_id'] = $user_id;
    return header('Location: /admin.php');
?>