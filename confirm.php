<?php 
    session_start();

  $pageTitle = "Order Confirmation";
  $description = "Displays confirmation message";
  include('includes/other_header.php');
  
?>

    
		
  <main class="confirm_notice">
    <h2>Order Confirmation</h2>
    
    <?php
    if (isset($_SESSION['current_user'])){	  
        $cart = get_cart($db);
        $high_num = top_order_num($db);
        $user = $_SESSION['current_user'];
        track_orderinfo($db, $high_num, $user);
      
        foreach ($cart as $card) {
            track_orderitems($db, $high_num, $card['card_ID'], $card['quantity']);         
        }
    }    
      $customer_name = htmlspecialchars(filter_input(INPUT_POST, 'name'));
      $street_address = htmlspecialchars(filter_input(INPUT_POST, 'street'));
      $city = htmlspecialchars(filter_input(INPUT_POST, 'city'));
      $state = $_POST['state'];
      $zip = htmlspecialchars(filter_input(INPUT_POST, 'zip'));
      
       
      $order_total = get_order_total($db);
      $formatted_total = sprintf("$%.2f",$order_total);
     
      echo "<div class='confirm'>";
      
        echo "<p>Your order was placed on ". date('F j' . ', ' . 'Y')." at ".date('g:i a')."</p>";

        echo "<p>Your order total is $formatted_total.</p>";

        echo "<p>Your order will be shipped to the following address:</p>";
        echo '<p>';
        echo $customer_name . '<br />';
        echo $street_address . '<br />';
        echo $city . ', ' . $state . '  ' . $zip . '<br />';
        echo '</p>';
        
      echo "</div>";

      //only update if cart is not empty; shouldn't be possible to get here otherwise
      update_inventory($db);  
      empty_cart($db);
      
      echo '<a href="index.php"><input type="button" value="Continue Shopping"></a>';

    ?>
        
  </main>

<?php include('includes/footer.php') ?>