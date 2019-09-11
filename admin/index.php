<?php
    include("../lib/connexion.php");

    session_start();

 if(!isset($_SESSION['user_login'])) //check unauthorize user not access in "welcome.php" page
 {
  header("location: index.php?page=home");
 }
    
 $id = $_SESSION['user_login'];
    
 $select_stmt = $pdo->prepare("SELECT * FROM users WHERE id=:uid");
 $select_stmt->execute(array(":uid"=>$id));
 
 $row=$select_stmt->fetch(PDO::FETCH_ASSOC);

 if(isset($_SESSION['user_login']))
 {
 ?>

 Bienvenue 
 <?php
   echo $row['username'];
 }
 ?>

<h1>Liste des biens<a href="index.php?page=insert"> Ajouter</a></h1>
                
<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Prix</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $statement = $pdo->query('SELECT biens.id, biens.title, biens.price FROM biens ORDER BY biens.id DESC');
        while($bien = $statement->fetch()) 
        {
            echo '<tr>';
            echo '<td>'. $bien['title'] . '</td>';
            echo '<td>'. $bien['price'] . '</td>';
            echo '<td width=300>';
            echo '<a class="btn btn-default" href="index.php?page=view&id='.$bien['id'].'"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
            echo '<a class="btn btn-primary" href="index.php?page=update&id='.$bien['id'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
            echo '<a class="btn btn-danger" href="index.php?page=delete&id='.$bien['id'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>

<a href="index.php?page=logout">Se déconnecter</a>