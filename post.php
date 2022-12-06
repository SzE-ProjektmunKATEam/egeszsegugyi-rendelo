<?php 
require_once 'connect.php';
if(isset($_GET["id"]))
$post_id = $_GET["id"];
if(!isset($post_id)) die("nincs ilyen hír!");
$stmt = $conn->query("SELECT * FROM news WHERE id=$post_id");
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Admin Panel</title>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-md navbar-light bg-white p-3">
    <a class="navbar-brand" href="index.php">Egészségügyi Rendelő</a>
    <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="width: 1em;"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Főoldal<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Kapcsolat</a>
        </li>
      </ul>
      <a href="login.php" type="button" class="btn btn-primary d-md-block mt-3 ml-md-3 mt-md-0 px-4 rounded-pill">Bejelentkezés</a>
    </div>
  </nav>
  <div class="container">
    <?php while ($row = $stmt->fetch()) {
          $content = $row['content'];
          echo $content;
        }?>
  </div>
</body>
</html>