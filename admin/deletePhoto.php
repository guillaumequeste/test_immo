<?php
    include("../lib/connexion.php");

    $succes = null;
    $erreur = null;
 
    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }

    if(!empty($_POST)) 
    {
        $id = checkInput($_POST['id']);
        $statement = $pdo->prepare("DELETE FROM images WHERE id = ?");
        $statement->execute([$id]);
        $succes = "L'image a été supprimée.";
        header("refresh:2; index.php?page=admin");
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>

<h1>Supprimer un item</h1>

<?php if ($erreur): ?>
<div class="alert alert-danger">
    <?= $erreur ?>
</div>
<?php elseif ($succes): ?>
<div class="alert alert-success">
    <?= $succes ?>
</div>
<?php endif ?>

<form class="form" action="index.php?page=deletePhoto" role="form" method="post">
    <input type="hidden" name="id" value="<?= $id;?>"/>
    <p>Etes vous sur de vouloir supprimer ?</p>
    <div class="form-actions">
        <button type="submit">Oui</button>
    </div>
</form>
            
       

