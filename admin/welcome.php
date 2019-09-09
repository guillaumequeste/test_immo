<div>
 <h2>
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
  Welcome,
 <?php
   echo $row['username'];
 }
 ?>
 </h2>
 
  <a href="index.php?page=logout">Logout</a>
  
</div>