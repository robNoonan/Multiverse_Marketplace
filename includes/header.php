
<?php 
  $pageTitle = "Multiverse Marketplace";
  $description = "Displays the cards for sale at Multiverse Marketplace";
  include('includes/functions.php');
  require_once('includes/open_db.php');
?>

<html>
<head>
  <title><?php echo $pageTitle; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?php echo $description; ?>">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="shortcut icon" href="img/favicon/favicon.ico">
</head>
<body>
    
  <header>		
    <nav>
        <div class="main-wrapper">
            
            <ul>    
                <li><a href="index.php"><img src="img/shop_logo.png" alt="logo"></a></li>
            </ul>
            <div class="nav-login">
                <?php      
                     
                    if (isset($_SESSION['current_user'])){
                      $user = $_SESSION['current_user'];
                      echo "Welcome " . $user . "!";
                      echo "<form action='login_files/logout.php' method='post'>";
                      echo "<input type='submit' name='Logout' value='Log out'>";
                      echo "</form>";
                        //If the logged in user is an admin
                        if(check_admin($db, $user) == 'M'){
                            echo "<form action='admin.php'>";
                            echo "<input type='submit' value='Admin Page'>";
                            echo "</form>";
                            echo "<form action='index.php'>";
                            echo "<input type='submit' value='Customer Page'>";
                            echo "</form>";
                        }
                        //if the logged in user has an account
                        else{
                            echo "<form action='cart.php'>";
                            echo "<input type='submit' value='My Cart'>";
                            echo "</form>";
                            echo "<form action='orders.php' method='post'>";
                            echo "<input type='submit' value='Past Orders'>";
                            echo "</form>";
                        }
                    }
                    //for guest visitors
                   else {
                     echo "<form class='create' action='login_files/login_start.php' method='post'>";
                     echo "<input type='submit' value='Login/Create account'>";
                     echo "</form>";
                     echo "<form action='cart.php'>";
                     echo "<input type='submit' value='My Cart'>";
                     echo "</form>";
                    }    
                    
                 ?>
                
            </div>
      </div>
    </nav>
  </header>