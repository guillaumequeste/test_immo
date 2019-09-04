<?php
    include("../lib/connexion.php");
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
          