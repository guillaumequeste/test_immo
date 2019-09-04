<?php
    include("../lib/connexion.php");
 
    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }

    if(!empty($_POST)) 
    {
        $id = checkInput($_POST['id']);
        $statement = $pdo->prepare("DELETE FROM biens WHERE id = ?");
        $statement->execute([$id]);
        header("Location: index.php?page=admin"); 
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
<form class="form" action="index.php?page=delete" role="form" method="post">
    <input type="hidden" name="id" value="<?= $id;?>"/>
    <p>Etes vous sur de vouloir supprimer ?</p>
    <div class="form-actions">
        <button type="submit">Oui</button>
        <a href="index.php?page=admin">Non</a>
    </div>
</form>
            
       

