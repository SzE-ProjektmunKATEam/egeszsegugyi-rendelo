<?php 

require_once 'connect.php';
if(isset($_POST['taj']) && isset($_POST['description'])) {
    $card_query = $conn->query("SELECT * FROM card ORDER BY id DESC LIMIT 1");
    $created_card_id = $card_query->fetch()['id'];
    $created_card_id += 1;

    
    $check_user = $conn->query("SELECT * FROM user");
    while($row = $check_user->fetch())
    {
        $taj_exist = true;
        if($row['taj'] !== intval($_POST['taj'])) $taj_exist = false;
    }
    $owner_id = intval($conn->lastInsertId());
    if(!$taj_exist) {
        $query = "INSERT INTO user (first_name, last_name, taj, worker) VALUES (?,?,?,?)";
        $var = $conn->prepare($query);
        $var->execute([$_POST['first_name'], $_POST['last_name'], intval($_POST['taj']), 0]);
    } else {
        $taj = $_POST['taj'];
        $user_by_taj = $conn->query("SELECT * FROM user WHERE taj=$taj ORDER BY id DESC LIMIT 1");
        while($row = $user_by_taj->fetch())
        {
         $owner_id = $row['id'];   
        }
    }


    $full_name = $_POST['first_name'] . " " . $_POST['last_name'];

    $query = "INSERT INTO card (id, name, description, deck, status, owner) VALUES (?,?,?,?,?,?)";
    $var = $conn->prepare($query);
    $var->execute([$created_card_id, $full_name, $_POST['description'], 1, 0, $owner_id]);
    return header("Location: /guest-card.php?message=sent");
}

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Bejelentés</title>
</head>
<body>
    <div class="loginWrapper">
    <form class="p-5 container" action="guest-card.php" method="POST">
      <?php if(isset($_GET['message'])) {
        $message = $_GET['message']; ?>
    <div class="alert alert-info" role="alert">
  <?php switch($message) {
   case "sent":
    echo "Bejelentés sikeresen elküldve!";
    break;
      default:
      echo "Valami hiba történt!";
  }?>
</div> <?php }?>
        <h1 id="loginHeading">Bejelentés</h1>
            <div class="form-group">
                <label for="exampleInputEmail1" class="font-weight-bold">Vezetéknév</label>
                <input type="text" class="form-control" id="exampleInputEmail1" 
                name="first_name" aria-describedby="emailHelp" placeholder="Vezetéknév" required>
              </div>
              <div class="form-group">
              <label for="exampleInputPassword1" class="font-weight-bold">Keresztnév</label>
              <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Keresztnév"
              name="last_name" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1" class="font-weight-bold">TAJ Szám</label>
              <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Taj Szám"
              name="taj" required>
            </div>
            <div class="form-group">
    <label for="description" class="font-weight-bold">Leírás</label>
    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
  </div>

            <button type="submit" class="btn btn-primary w-100 w-lg-25">Bejelentés elküldése</button>
            <div class="form-group pt-2">
            <a href="/">Vissza a főoldalra</a>
            </div>
          </form>
    </div>
</body>
</html>