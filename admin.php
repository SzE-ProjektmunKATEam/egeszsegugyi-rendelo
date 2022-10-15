<?php 
session_start();
if(!$_SESSION['logged_in'] == "logged")
return header('Location: /login.php?message=notLoggedIn');
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h1><?php echo "Hello Again!" ?></h1>
    <form action="logoutProcess.php" method="POST">
        <input type="submit" value="Kilépés">
    </form>
</body>
</html>