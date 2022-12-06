<?php 
session_start();
if(!$_SESSION['logged_in'] == "logged")
return header('Location: /login.php?message=notLoggedIn');
require_once('mockdataBase.php');
require_once 'connect.php';

$user_id = $_SESSION['user_id'];
$is_admin = false;
$user_query = $conn->query("SELECT * FROM user WHERE id=$user_id");
while($row = $user_query->fetch())
{
  if($row["worker"] == 1) $is_admin = true;
}

$stmt = $conn->query("SELECT * FROM news");
$count_array = $conn->query("SELECT * FROM news");
$news_array = array();
while ($row = $count_array->fetch()) {
  $news_array[] = $row['id'];
}
if(isset($_GET["deletepost"]))
{
  $post_id_to_delete = $_GET["deletepost"];
  $sql = "DELETE FROM news WHERE id=?";
  $stmt= $conn->prepare($sql);
  $stmt->execute([$post_id_to_delete]);
  return header('Location: /admin.php');
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
     <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
     <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-md navbar-light bg-white p-3">
    <a class="navbar-brand" href="/index.php">Egészségügyi Rendelő</a>
    <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="width: 1em;"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
      <?php if($is_admin) {?>
        <li class="nav-item active">
        <a class="nav-link" href="/admin.php">Vezérlőpult<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
        <a class="nav-link" href="/decks.php">Bejelentések<span class="sr-only">(current)</span></a>
        </li>
      </ul>
      <?php 
      $last_item = end($news_array);
      $created_id = $last_item + 1; ?>
      <a href='<?php echo "edit.php?id=${created_id}" ?>' type="button" class="btn btn-primary d-none d-md-block ml-3 px-4 rounded-pill">Új hír létrehozása</a>
      <?php } ?>
      <form action="logoutProcess.php" method="POST">
        <input class="btn btn-danger d-none d-md-block ml-3 px-4 rounded-pill" type="submit" value="Kilépés">
    </form>
    </div>
  </nav>
  <?php if($is_admin) {?>
    <div class="container-fluid p-3 d-flex">
        <div class="bg-white w-25 shadow-sm p-3 rounded" id="parent">
            <h2 class="pb-1">Hírek</h2>
            <hr>
        <?php 
        while ($row = $stmt->fetch()) { ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['title']; ?></h5>
                    <p class="card-text"><?php echo $row['created']?></p>
                    <?php $id = $row['id']?>
                    <a href='<?php echo "/edit.php?id={$id}" ?>' class="btn btn-primary">Szerkeztés</a>
                    <a href='<?php echo "/admin.php?deletepost={$id}" ?>' class="btn btn-danger">Törlés</a>
                </div>
          </div> 
  <?php } 
  }?>
        </div>
    </div>
</body>
</html>