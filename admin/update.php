<?php

    include("../lib/connexion.php");

    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }

    $titleError = $priceError = $imageError = $title = $price = $image = "";

    if(!empty($_POST)) 
    {
        $title      = checkInput($_POST['title']);
        $price      = checkInput($_POST['price']);
        $image              = checkInput($_FILES["image"]["name"]);
        $imagePath          = './images/'. basename($image);
        $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
        $isSuccess  = true;
       
        if(empty($title)) 
        {
            $titleError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($price)) 
        {
            $priceError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($image)) // le input file est vide, ce qui signifie que l'image n'a pas ete update
        {
            $isImageUpdated = false;
        }
        else
        {
            $isImageUpdated = true;
            $isUploadSuccess =true;
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) 
            {
                $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
                $isUploadSuccess = false;
            }
            if(file_exists($imagePath)) 
            {
                $imageError = "Le fichier existe deja";
                $isUploadSuccess = false;
            }
            if($_FILES["image"]["size"] > 500000) 
            {
                $imageError = "Le fichier ne doit pas depasser les 500KB";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess) 
            {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) 
                {
                    $imageError = "Il y a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                } 
            } 
        }
         
        if (($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated)) 
        { 
            if($isImageUpdated)
            {
                $statement = $pdo->prepare("UPDATE biens  set title = ?, price = ?, image = ? WHERE id = ?");
                $statement->execute([$title,$price,$image,$id]);
            }
            else
            {
                $statement = $pdo->prepare("UPDATE biens  set title = ?, price = ? WHERE id = ?");
                $statement->execute([$title,$price,$id]);
            }
            header("Location: index.php");
        }
        else if($isImageUpdated && !$isUploadSuccess)
        {
            $statement = $pdo->prepare("SELECT * FROM biens where id = ?");
            $statement->execute([$id]);
            $bien = $statement->fetch();
            $image          = $item['image'];
           
        }
    }
    else 
    {
        $statement = $pdo->prepare("SELECT * FROM biens where id = ?");
        $statement->execute([$id]);
        $item = $statement->fetch();
        $title           = $item['title'];
        $price          = $item['price'];
        $image          = $item['image'];
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

?>

<h1><strong>Modifier un bien</strong></h1>

<form class="form" action="<?= 'index.php?page=update&id='.$id;?>" role="form" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Titre:</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Titre" value="<?= $title;?>">
        <span class="help-inline"><?= $titleError;?></span>
    </div>
    <div class="form-group">
        <label for="price">Prix: (en €)</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?= $price;?>">
        <span class="help-inline"><?= $priceError;?></span>
    </div>
    <div class="form-group">
        <label for="image">Image:</label>
        <img src="./images/<?= $image;?>" />
        <label for="image">Sélectionner une nouvelle image:</label>
        <input type="file" id="image" name="image"> 
        <span class="help-inline"><?= $imageError;?></span>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
        <a class="btn btn-primary" href="index.php?page=admin"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
    </div>
</form>
