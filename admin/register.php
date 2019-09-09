<?php

include("../lib/connexion.php");

if(isset($_REQUEST['btn_register'])) //button name "btn_register"
{
 $username = strip_tags($_REQUEST['txt_username']); //textbox name "txt_email"
 $email  = strip_tags($_REQUEST['txt_email']);  //textbox name "txt_email"
 $password = strip_tags($_REQUEST['txt_password']); //textbox name "txt_password"
  
 if(empty($username)){
  $errorMsg[]="Please enter username"; //check username textbox not empty 
 }
 else if(empty($email)){
  $errorMsg[]="Please enter email"; //check email textbox not empty 
 }
 else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
  $errorMsg[]="Please enter a valid email address"; //check proper email format 
 }
 else if(empty($password)){
  $errorMsg[]="Please enter password"; //check passowrd textbox not empty
 }
 else if(strlen($password) < 6){
  $errorMsg[] = "Password must be atleast 6 characters"; //check passowrd must be 6 characters
 }
 else
 { 
  try
  { 
   $select_stmt=$pdo->prepare("SELECT username, email FROM users 
          WHERE username=:uname OR email=:uemail"); // sql select query
   
   $select_stmt->execute(array(':uname'=>$username, ':uemail'=>$email)); //execute query 
   $row=$select_stmt->fetch(PDO::FETCH_ASSOC); 
   
   if($row["username"]==$username){
    $errorMsg[]="Sorry username already exists"; //check condition username already exists 
   }
   else if($row["email"]==$email){
    $errorMsg[]="Sorry email already exists"; //check condition email already exists 
   }
   else if(!isset($errorMsg)) //check no "$errorMsg" show then continue
   {
    $new_password = password_hash($password, PASSWORD_DEFAULT); //encrypt password using password_hash()
    
    $insert_stmt=$pdo->prepare("INSERT INTO users (username,email,password) VALUES
                (:uname,:uemail,:upassword)");   //sql insert query     
    
    if($insert_stmt->execute(array( ':uname' =>$username, 
                                    ':uemail'=>$email, 
                                    ':upassword'=>$new_password))){
             
     $registerMsg="Register Successfully..... Please Click On Login Account Link"; //execute query success message
    }
   }
  }
  catch(PDOException $e)
  {
   echo $e->getMessage();
  }
 }
}
?>

<?php
if(isset($errorMsg))
{
 foreach($errorMsg as $error)
 {
 ?>
  <div class="alert alert-danger">
   <strong>WRONG ! <?php echo $error; ?></strong>
  </div>
    <?php
 }
}
if(isset($registerMsg))
{
?>
 <div class="alert alert-success">
  <strong><?php echo $registerMsg; ?></strong>
 </div>
<?php
}
?> 
<form method="post" class="form-horizontal">
        
 <div class="form-group">
 <label class="col-sm-3 control-label">Username</label>
 <div class="col-sm-6">
 <input type="text" name="txt_username" class="form-control" placeholder="enter username" />
 </div>
 </div>
    
 <div class="form-group">
 <label class="col-sm-3 control-label">Email</label>
 <div class="col-sm-6">
 <input type="text" name="txt_email" class="form-control" placeholder="enter email" />
 </div>
 </div>
     
 <div class="form-group">
 <label class="col-sm-3 control-label">Password</label>
 <div class="col-sm-6">
 <input type="password" name="txt_password" class="form-control" placeholder="enter passowrd" />
 </div>
 </div>
     
 <div class="form-group">
 <div class="col-sm-offset-3 col-sm-9 m-t-15">
 <input type="submit"  name="btn_register" class="btn btn-primary " value="Register">
 </div>
 </div>
    
 <div class="form-group">
 <div class="col-sm-offset-3 col-sm-9 m-t-15">
 You have a account register here? <a href="index.php?page=login"><p class="text-info">Login Account</p></a>  
 </div>
 </div>
     
</form>