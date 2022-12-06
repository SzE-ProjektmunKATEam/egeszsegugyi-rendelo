<?php 
session_start();
if(isset($_SESSION['logged_in']))
if($_SESSION['logged_in'] == "logged")  return header('Location: /admin.php');
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Regisztráció</title>
</head>
<body>
    <div class="loginWrapper">
    <form class="p-5 container" action="registerProcess.php" method="POST">
      <?php if(isset($_GET['message'])) {
        $message = $_GET['message']; ?>
    <div class="alert alert-info" role="alert">
  <?php switch($message) {
   case "existInDatabase":
    echo "E-mail cím már regisztrálva van!";
    break;
    case "tajInDatabase":
      echo "Taj szám már regisztrálva van!";
      break;
      default:
      echo "Valami hiba történt!";
  }?>
</div> <?php }?>
        <h1 id="loginHeading">Regisztráció</h1>
            <div class="form-group">
                <label for="exampleInputEmail1" class="font-weight-bold">Email cím</label>
                <input type="email" class="form-control" id="exampleInputEmail1" 
                name="email" aria-describedby="emailHelp" placeholder="Email cím" required>
              </div>
            <div class="form-group">
              <label for="exampleInputPassword1" class="font-weight-bold">Jelszó</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Jelszó"
              name="password" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1" class="font-weight-bold">Vezetéknév</label>
              <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Vezetéknév"
              name="first_name" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1" class="font-weight-bold">Keresztnév</label>
              <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Keresztnév"
              name="last_name" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1" class="font-weight-bold">TAJ szám</label>
              <input type="text" class="form-control" id="exampleInputPassword1" placeholder="taj"
              name="taj" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 w-lg-25">Regisztrálás</button>
            <div class="form-group pt-2">
            <a href="/">Vissza a főoldalra</a>
            </div>
          </form>
    </div>
</body>
</html>