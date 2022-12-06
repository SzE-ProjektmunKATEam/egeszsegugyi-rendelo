<?php 
    require_once 'connect.php';

    $givenUser = $_POST['email'];
    $givenPass = $_POST['password'];
    $HashedPass = hash('sha512', $givenPass);

    $user_count_array = $conn->query("SELECT * FROM user");
$user_array = array();
while ($row = $user_count_array->fetch()) {
    $user_array[] = $row['id'];
  }

 $last_item = end($user_array);
  $user_id = $last_item + 1;

    $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(['email' => strval($givenUser)]);
    if ($stmt->rowCount() > 0) {
        return header('Location: /register.php?message=existInDatabase');
    } else {
        $insert_query = "INSERT INTO user (email, password, first_name, last_name, taj, worker) VALUES (?,?,?,?,?,?)";
    $var = $conn->prepare($insert_query);
    $var->execute([$givenUser, $HashedPass, $_POST["first_name"], $_POST["last_name"], intval($_POST["taj"]), 0]);
    session_start();
    $_SESSION['logged_in'] = "logged";
    $_SESSION['user_id'] = $user_id;
    return header('Location: /admin.php');
    }
?>