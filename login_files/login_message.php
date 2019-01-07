<?php
   session_start();   
   include ('../includes/login_header.php');
   
   $message = $_SESSION['message'];
   unset($_SESSION['message']);
?>


    <main class='login'> 
        <form class="success">
        <?php          
          echo "<h2>$message</h2>"; 
          echo "You will be redirected to the home page in 2 seconds.";
          header( "refresh:2; url=../index.php" );
        ?>
        </form>
    </main>        
   
  </body>
</html>


