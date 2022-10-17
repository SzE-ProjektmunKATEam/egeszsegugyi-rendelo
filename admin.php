<?php 
session_start();
if(!$_SESSION['logged_in'] == "logged")
return header('Location: /login.php?message=notLoggedIn');
require_once('mockdataBase.php');
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
    <a class="navbar-brand" href="/admin.php">Egészségügyi Rendelő</a>
    <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="width: 1em;"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/admin.php">Vezérlőpult<span class="sr-only">(current)</span></a>
        </li>
      </ul>
      <a href="login.php" type="button" class="btn btn-primary d-none d-md-block ml-3 px-4 rounded-pill">Új hír létrehozása</a>
      <form action="logoutProcess.php" method="POST">
        <input class="btn btn-danger d-none d-md-block ml-3 px-4 rounded-pill" type="submit" value="Kilépés">
    </form>
    </div>
  </nav>
    <div class="container-fluid p-3 d-flex">
        <div class="bg-white w-25 shadow-sm p-3 rounded ">
            <h2 class="pb-1">Hírek</h2>
            <hr>
        <?php foreach ($testArray as $element) { ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $element['title']?></h5>
                    <p class="card-text"><?php echo $element['date']?></p>
                    <?php $id = $element['id']?>
                    <a href='<?php echo "/edit.php?id={$id}" ?>' class="btn btn-primary">Szerkeztés</a>
                </div>
          </div> 
  <?php } ?>
        </div>
    </div>
</body>
</html>