<?php
    include("header.php");
    session_start();  

 if(isset($_SESSION["email"]))  
 {  
      echo '<h3>Welcome - '.$_SESSION["email"].'</h3>';  
      echo '<br /><br /><button type="button" class="btn btn-warning"><a href="logout.php">Logout</a></button>';  
 }  
 else  
 {  
      header("location:index.php");  
 } 
?>
<?php
    include("footer.php");
?>  