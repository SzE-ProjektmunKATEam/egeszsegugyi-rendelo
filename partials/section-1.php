<?php
require_once "../connect.php";
$stmt = $conn->query("SELECT * FROM news");
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 mb-sm-4 col-lg-3">
            <h2 class="display-4 mb-3">Rendelés</h2>
            <ul class="list-group mb-3">
                <li class="list-group-item">Hétfő: 8:00 - 13:00</li>
                <li class="list-group-item">Kedd: 8:00 - 13:00</li>
                <li class="list-group-item">Szerda: 8:00 - 13:00</li>
                <li class="list-group-item">Csütörtök: 8:00 - 13:00</li>
                <li class="list-group-item">Péntek: 8:00 - 13:00</li>
              </ul>
        </div>
        <div class="col-sm-12 order-lg-4 mb-sm-4 col-lg-3">
            <h2 class="display-4 mb-3">Adatok</h2>
            <ul class="list-group mb-3">
                <li class="list-group-item">Cím: 2043 Budapest Kis utca 15/b</li>
                <li class="list-group-item">Dapibus ac facilisis in</li>
              </ul>
        </div>
        <div class="col-sm-12 order-lg-3 col-lg-6">
            <h2 class="display-4 mb-3">Hírek</h2>
            <?php  while ($row = $stmt->fetch()) { ?>
              <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['title']; ?></h5>
                    <p class="card-text"><?php echo $row['created']?></p>
                    <?php $id = $row['id']?>
                    <a href='<?php echo "/post.php?id={$id}" ?>' class="btn btn-primary">Megnézem</a>
                </div>
          </div> 
                <?php } ?>
        </div>
    </div>
</div>