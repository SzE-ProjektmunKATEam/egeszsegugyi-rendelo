<?php 
session_start();
if(!$_SESSION['logged_in'] == "logged")
return header('Location: /login.php?message=notLoggedIn');
require_once('mockdataBase.php');
require_once 'connect.php';

if(isset($_GET["deletecard"]))
{
  $card_id_to_delete = $_GET["deletecard"];
  $sql = "DELETE FROM card WHERE id=?";
  $stmt= $conn->prepare($sql);
  $stmt->execute([$card_id_to_delete]);
  return header('Location: /decks.php');
}

$key = 0;
$card_copy = array();
if(isset($_GET["statusChange"])) {
    $sql = "UPDATE card SET deck=? WHERE id=?";
$deck = $_GET['statusChange'];
$card_id = $_GET['cardID'];
$conn->prepare($sql)->execute([$deck, $card_id]);
}
$stmt = $conn->query("SELECT * FROM card WHERE deck=1");
$stmt2 = $conn->query("SELECT * FROM card WHERE deck=2");
$stmt3 = $conn->query("SELECT * FROM card WHERE deck=3");
$stmt4 = $conn->query("SELECT * FROM card WHERE deck=4");

$card_array_query = $conn->query("SELECT * FROM card");
$card_array = array();
while ($row = $card_array_query->fetch()) {
    $card_array[] = $row['id'];
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
    <a class="navbar-brand" href="/admin.php">Eg??szs??g??gyi Rendel??</a>
    <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="width: 1em;"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/admin.php">Vez??rl??pult<span class="sr-only">(current)</span></a>
        </li>
      </ul>
      <?php $last_item = end($card_array);
      $created_id = $last_item + 1;?>
      <a href='<?php echo "edit-card.php?id=$created_id" ?>' type="button" class="btn btn-primary d-none d-md-block ml-3 px-4 rounded-pill">??j Bejelent??s</a>
      <form action="logoutProcess.php" method="POST">
        <input class="btn btn-danger d-none d-md-block ml-3 px-4 rounded-pill" type="submit" value="Kil??p??s">
    </form>
    </div>
  </nav>
    <div class="container-fluid p-3">
    <div class="row">
  <div class="col-sm-3">
    <h2 class="h2">Bejelent??sek</h2>
    <?php while ($row = $stmt->fetch()) { 
        if($row["deck"] == 1) { ?>
    <div class="card mb-3">
    <form class="p-3" method="GET" id="<?php echo "name". $row["id"]?>">
            <div class="form-group">
                <label for="exampleInputEmail1" class="font-weight-600"><b>N??v: </b><?php echo $row['name']; ?></label>
                <hr>
                <small id="emailHelp" class="form-text"><b>D??tum: </b><?php echo $row['created']?></small>
            </div>
                <div class="form-group">
                    <select class="form-control" onchange="this.form.submit()" name="statusChange">
                    <option value="1">Bejelent??s</option>
                    <option value="2">Adminisztr??ci??</option>
                    <option value="3">Kivizsg??l??s</option>
                    <option value="4">Lez??rt</option>
                    </select>
                    <a href='<?php echo "/edit-card.php?id={$row['id']}" ?>' class="btn btn-primary mt-2">Szerkezt??s</a>
                    <a href='<?php echo "/decks.php?deletecard={$row['id']}" ?>' class="btn btn-danger mt-2">T??rl??s</a>
                </div>
                <input type="hidden" value="<?php echo $row['id'] ?>" name="cardID">
        </form> 
    </div>
    <?php }
    }?>
  </div>
  <div class="col-sm-3">
  <h2 class="h2">Adminisztr??ci??</h2>
  <?php while ($row = $stmt2->fetch()) { 
        if($row["deck"] == 2) { ?>
    <div class="card mb-3">
    <form class="p-3" method="GET" id="<?php echo "name". $row["id"]?>">
            <div class="form-group">
                <label for="exampleInputEmail1" class="font-weight-600"><b>N??v: </b><?php echo $row['name']; ?></label>
                <hr>
                <small id="emailHelp" class="form-text"><b>D??tum: </b><?php echo $row['created']?></small>
            </div>
                <div class="form-group">
                    <select class="form-control" onchange="this.form.submit()" name="statusChange">
                    <option value="1">Bejelent??s</option>
                    <option value="2" selected>Adminisztr??ci??</option>
                    <option value="3">Kivizsg??l??s</option>
                    <option value="4">Lez??rt</option>
                    </select>
                    <a href='<?php echo "/edit-card.php?id={$row['id']}" ?>' class="btn btn-primary mt-2">Szerkezt??s</a>
                    <a href='<?php echo "/decks.php?deletecard={$row['id']}" ?>' class="btn btn-danger mt-2">T??rl??s</a>
                </div>
                <input type="hidden" value="<?php echo $row['id'] ?>" name="cardID">
        </form> 
    </div>
    <?php }
    }?>
  </div>
  <div class="col-sm-3">
  <h2 class="h2">Kivizsg??l??s</h2>
  <?php while ($row = $stmt3->fetch()) { 
        if($row["deck"] == 3) { ?>
    <div class="card mb-3">
    <form class="p-3" method="GET" id="<?php echo "name". $row["id"]?>">
            <div class="form-group">
            <label for="exampleInputEmail1" class="font-weight-600"><b>N??v: </b><?php echo $row['name']; ?></label>
                <hr>
                <small id="emailHelp" class="form-text"><b>D??tum: </b><?php echo $row['created']?></small>
            </div>
                <div class="form-group">
                    <select class="form-control" onchange="this.form.submit()" name="statusChange">
                    <option value="1">Bejelent??s</option>
                    <option value="2">Adminisztr??ci??</option>
                    <option value="3" selected>Kivizsg??l??s</option>
                    <option value="4">Lez??rt</option>
                    </select>
                    <a href='<?php echo "/edit-card.php?id={$row['id']}" ?>' class="btn btn-primary mt-2">Szerkezt??s</a>
                    <a href='<?php echo "/decks.php?deletecard={$row['id']}" ?>' class="btn btn-danger mt-2">T??rl??s</a>
                </div>
                <input type="hidden" value="<?php echo $row['id'] ?>" name="cardID">
        </form> 
    </div>
    <?php }
    }?>
  </div>
  <div class="col-sm-3">
  <h2 class="h2">Lez??rt</h2>
  <?php while ($row = $stmt4->fetch()) { 
        if($row["deck"] == 4) { ?>
    <div class="card mb-3">
    <form class="p-3" method="GET" id="<?php echo "name". $row["id"]?>">
            <div class="form-group">
            <label for="exampleInputEmail1" class="font-weight-600"><b>N??v: </b><?php echo $row['name']; ?></label>
                <hr>
                <small id="emailHelp" class="form-text"><b>D??tum: </b><?php echo $row['created']?></small>
            </div>
                <div class="form-group">
                    <select class="form-control" onchange="this.form.submit()" name="statusChange">
                    <option value="1">Bejelent??s</option>
                    <option value="2">Adminisztr??ci??</option>
                    <option value="3">Kivizsg??l??s</option>
                    <option value="4" selected>Lez??rt</option>
                    </select>
                    <a href='<?php echo "/edit-card.php?id={$row['id']}" ?>' class="btn btn-primary mt-2">Szerkezt??s</a>
                    <a href='<?php echo "/decks.php?deletecard={$row['id']}" ?>' class="btn btn-danger mt-2">T??rl??s</a>
                </div>
                <input type="hidden" value="<?php echo $row['id'] ?>" name="cardID">
        </form> 
    </div>
    <?php }
    }?>
  </div>
</div>
    </div>
</body>
</html>