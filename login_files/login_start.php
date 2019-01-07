
<?php 
  $pageTitle = "Log In";
  $description = "Displays the cards for sale at Multiverse Marketplace";
  include ('../includes/login_header.php');
?>

  
    <main class="login">
        
        <form action="login.php" method="post"class="choose">
          <input type="radio" name="type" value="existing" id="existing">
          <label for="existing">I have an account.</label><br>
          <input type="radio" name="type" value="new" id="new" checked>
          <label for="new">I need to create an account</label><br>
          <input type="submit" value="Go"> 
        </form>
     
    </main>  
  </body>
</html>


