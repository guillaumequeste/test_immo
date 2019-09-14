<?php
     
     include("../lib/connexion.php");
 
    $titleError = $priceError = $imageError = $title = $price = $image = "";
    $succes = null;
    $erreur = null;
    if(!empty($_POST)) 
    {
        $title      = checkInput($_POST['title']);
        $price      = checkInput($_POST['price']);
        $image      = checkInput($_FILES["image"]["name"]);
        $imagePath  = '../public/images/'. basename($image);
        $imageExtension = pathinfo($imagePath,PATHINFO_EXTENSION);
        $isSuccess  = true;
        $isUploadSuccess    = false;
        
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
        if(empty($image)) 
        {
            $imageError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        else
        {
            $isUploadSuccess = true;
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
        
        if($isSuccess && $isUploadSuccess) 
        {
            $statement = $pdo->prepare("INSERT INTO biens (title,price,image,created_at) values(?, ?, ?, NOW())");
            $statement->execute([$title,$price,$image]);
            $succes = 'Le bien a été ajouté.';
            header("refresh:2; index.php?page=admin");
        } else {
            $erreur = "Le bien n'a pas été ajouté correctement.";
        }
    }
    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>

<h1>Ajouter un bien</h1>

<?php if ($erreur): ?>
<div class="alert alert-danger">
    <?= $erreur ?>
</div>
<?php elseif ($succes): ?>
<div class="alert alert-success">
    <?= $succes ?>
</div>
<?php endif ?>

<form class="form" action="index.php?page=insert" role="form" method="post" enctype="multipart/form-data">
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
        <label for="image">Sélectionner une image:</label>
        <input type="file" id="image" name="image"> 
        <span class="help-inline"><?= $imageError;?></span>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
        <a class="btn btn-primary" href="index.php?page=admin"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
    </div>
</form>