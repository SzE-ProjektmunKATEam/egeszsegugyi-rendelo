<?php 
session_start();
if(!$_SESSION['logged_in'] == "logged")
return header('Location: /login.php?message=notLoggedIn');
require_once 'connect.php';

if(!isset($_GET['id'])) 
return header('Location: /admin.php');
$id = $_GET['id'];
$last_name = "";
$first_name = "";
$taj = "";
$description = "";
echo "<script src='https://code.jquery.com/jquery-3.3.1.slim.min.js' integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo' crossorigin='anonymous'></script>";
if(isset($_POST['description'])) {
  echo "<script>jQuery(document).ready(function() {
  jQuery('.alert').removeClass('d-none')
 jQuery('.alert').addClass('d-block') 
})</script>";

$user_to_insert = 0;
$taj = intval($_POST['taj']);
$check_card_id = $conn->query("SELECT * FROM card WHERE id={$id}");
if($check_card_id->rowCount() > 0)
{
    //Update
    $sql_card = "UPDATE card SET description=? WHERE id=?";
    $select_query = $conn->query("SELECT user.id FROM user
    INNER JOIN card
    ON user.id = card.owner
    WHERE user.taj = $taj
    ORDER BY card.id DESC LIMIT 1");
    $user = $select_query->fetch();
    $sql_user = "UPDATE user SET first_name=?, last_name=? WHERE id=?";
$conn->prepare($sql_card)->execute([$_POST['description'], $id]);
$conn->prepare($sql_user)->execute([$_POST['last_name'], $_POST['first_name'], $user['id']]);
} else {
$taj_query = $conn->query("SELECT * FROM user WHERE taj=$taj");
if($taj_query->rowCount() <= 0) // ha nincs user
{
    //create user
    $insert_query = "INSERT INTO user (first_name, last_name, taj, worker) VALUES (?,?,?,?)";
    $var = $conn->prepare($insert_query);
    $var->execute([$_POST['first_name'],$_POST['last_name'], $taj, 0]);

    //create card
    $insert_card_query = "INSERT INTO card (name, description, owner, deck, status, id) VALUES (?,?,?,?,?,?)";
    $var = $conn->prepare($insert_card_query);   
    $name = $_POST['first_name'] . " " . $_POST['last_name'];
    $var->execute([$name ,$_POST['description'], intval($conn->lastInsertId()), 1, 0, $id]);
} else { // ha van user
    $select_query = $conn->query("SELECT user.id, user.first_name, user.last_name FROM user
INNER JOIN card
ON user.id = card.owner
WHERE user.taj = $taj
ORDER BY card.id DESC LIMIT 1");
    while ($row = $select_query->fetch()) {
        $insert_card_query = "INSERT INTO card (name, description, owner, deck, status, id) VALUES (?,?,?,?,?,?)";
    $var = $conn->prepare($insert_card_query);   
    $name = $row['first_name'] . " " . $row['last_name'];
    $var->execute([$name ,$_POST['description'], intval($row['id']), 1, 0, $id]);
      }
}

}
} $check_card_id = $conn->query("SELECT * FROM card WHERE id={$id}");
if($check_card_id->rowCount() > 0)
{
$select_query = $conn->query("SELECT * FROM user
INNER JOIN card
ON user.id = card.owner
WHERE card.id = $id
ORDER BY card.id DESC LIMIT 1");
    while ($row = $select_query->fetch()) {
        $last_name = $row['first_name'];
        $first_name = $row['last_name'];
    $description = $row['description'];
    $taj = $row['taj'];
      }
}

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
     <link rel="stylesheet" href="/summernote/summernote-bs4.css">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
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
        <a class="nav-link" href="/decks.php">Bejelentések<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="/admin.php">Vezérlőpult<span class="sr-only">(current)</span></a>
        </li>
      </ul>
      <form action="logoutProcess.php" method="POST" class="m-0">
        <input class="btn btn-danger d-none d-md-block ml-3 px-4 rounded-pill" type="submit" value="Kilépés">
    </form>
    </div>
  </nav>

  <div class="container">
  <div class="alert alert-primary d-none" role="alert">
 Bejelentés frissítve!
</div>
    <form class="pt-5 container" action='<?php echo "/edit-card.php?id={$id}&updated=true" ?>' method="POST">
        <h1 id="loginHeading">Bejelentés szerkesztése</h1>
            <div class="form-group">
                <label for="first_name" class="font-weight-bold">Vezetéknév</label>
                <input type="text" class="form-control" id="first_name" 
                name="first_name" aria-describedby="titleHelp" placeholder="Vezetéknév" value="<?php echo $first_name ?>">
                <label for="last_name" class="font-weight-bold">Keresztnév</label>
                <input type="text" class="form-control" id="last_name" 
                name="last_name" aria-describedby="titleHelp" placeholder="Keresztnév" value="<?php echo $last_name ?>">
                <label for="taj" class="font-weight-bold">TAJ szám</label>
                <input type="text" class="form-control" id="taj " 
                name="taj" aria-describedby="titleHelp" placeholder="Taj szám" value="<?php echo $taj ?>" required>
              </div>
            <div class="form-group">
            <textarea id="summernote" name="description" required>
                <?php echo $description; ?>
            </textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100 w-lg-25">Mentés</button>
          </form>
  </div>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="./summernote/summernote-bs4.js"></script>
  <script>
    jQuery('#summernote').summernote()
  </script> 
</body>
</html>