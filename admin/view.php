<?php
    include("../lib/connexion.php");

    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }
     
    $statement = $pdo->prepare("SELECT biens.id, biens.title, biens.price, biens.image FROM biens WHERE biens.id = ?");
    $statement->execute([$id]);
    $bien = $statement->fetch();

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

?>

<h1>Voir un bien</h1>
<form>
    <div class="form-group">
        <label>Titre:</label><?= '  '.$bien['title'];?>
    </div>
    <div class="form-group">
        <label>Prix:</label><?= '  ' . (int)$bien['price'] . ' €';?>
    </div>
    <div class="form-group">
        <label>Image:</label><img src="./images/<?= $bien['image'];?>">
    </div>
</form>
<div class="form-actions">
    <a href="index.php?page=admin">Retour</a>
</div>