<?php 
session_start();
if(!$_SESSION['logged_in'] == "logged")
return header('Location: /login.php?message=notLoggedIn');
require_once('mockdataBase.php');
require_once 'connect.php';

$id = $_GET['id'];
echo "<script src='https://code.jquery.com/jquery-3.3.1.slim.min.js' integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo' crossorigin='anonymous'></script>";
if(isset($_POST['content'])) {
if($_POST['content']) {
  echo "<script>jQuery(document).ready(function() {
  jQuery('.alert').removeClass('d-none')
 jQuery('.alert').addClass('d-block') 
})</script>";
$sql = "UPDATE news SET content=? WHERE id=?";
$conn->prepare($sql)->execute([$_POST['content'], $id]);
if(isset($_POST['title'])) {
  $sql = "UPDATE news SET title=? WHERE id=?";
$conn->prepare($sql)->execute([$_POST['title'], $id]);
}
}
}
$title = "";
$content = "";
$stmt = $conn->query("SELECT * FROM news WHERE id=$id");
if($stmt->rowCount() > 0)
{
        while ($row = $stmt->fetch()) {
          $title = $row['title'];
          $content = $row['content'];
        }
      } else {
          $query = "INSERT INTO news (title, owner, content, id) VALUES (?,?,?,?)";
          $var = $conn->prepare($query);
          $var->execute([$title, $_SESSION['user_id'], $content, $id]);
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
 Cikk frissítve!
</div>
    <form class="pt-5 container" action='<?php echo "/edit.php?id={$id}" ?>' method="POST">
        <h1 id="loginHeading">Cikk szerkesztése</h1>
            <div class="form-group">
                <label for="exampleInputEmail1" class="font-weight-bold">Cím</label>
                <input type="text" class="form-control" id="title" 
                name="title" aria-describedby="titleHelp" placeholder="Cím" value="<?php echo $title ?>" required>
              </div>
            <div class="form-group">
            <textarea id="summernote" name="content" required>
              <?php echo $content?>
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