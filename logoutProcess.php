<?php
session_start();
$_SESSION['logged'] == null;
session_destroy();
return header('Location: /login.php?message=loggedout');
?>