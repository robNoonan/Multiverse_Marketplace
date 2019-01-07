<?php

  $pageTitle = "Payment Information";
  $description = "Displays order details and form for payment information";
  include('includes/other_header.php'); 
  
  
  if (isset($_POST['cancel'])) {
    empty_cart($db);
    unset($_POST['cancel']);
  }
  
  $cart = get_cart($db);
  
  if (count($cart) == 0) {
    echo '<section class="empty_cart"><p>Your cart is empty.</p>';
    echo "<p><form action='index.php'>
          <input type='submit' value='Return to Store'>
          </form></p></section>";
    include('includes/footer.php');
    exit();
  }
  
?>


  <main class='cart'>
    <table>
      <thead>
        <tr>
          <th colspan="4" id="table_title">My Cart</th>
        </tr>
        <tr>
            <th class="table_head"></th>
            <th class="table_head">Card</th>
            <th class="table_head">Quantity</th>
            <th class="table_head">Unit Price</th>
            <th class="table_head">Total Price</th>
        </tr>
      </thead>
      <tbody>
        <?php  
         $order_total = 0;
         
         foreach ($cart as $card) {
           $card_name = get_card_name($db, $card['card_ID']);
           $unit_price = get_price($db, $card['card_ID']);           
           $formatted_unit_price = sprintf("$%.2f",$unit_price);
           $formatted_unit_price2 = sprintf("$%.2f",$unit_price * $card['quantity']);
           $image_file = "img/card_images/".$card['card_ID'].".png";
           
        ?>
            <tr>
               <td class='table_data'><?php echo "<img src=" . $image_file . " alt={" . $card['card_ID'] . "}>"; ?></td> 
               <td class='table_data'><?php echo $card_name; ?></td>
               <td class='table_data'><?php echo $card['quantity']; ?></td>
               <td class='table_data'><?php echo $formatted_unit_price; ?></td>
               <td class='table_data'><?php echo $formatted_unit_price2; ?></td>
            </tr>
       <?php     
         } 
       ?> 
      
      </tbody>
          <tfoot>
            <tr>
                <td></td>
              <td colspan="3" >Order Total</td>
              <?php $formatted_total = sprintf("$%.2f",get_order_total($db)); ?>
              <td><?php echo $formatted_total ?></td>
            </tr>
          </tfoot>
      </table>
    
      <a href="shipping.php"><input type="submit" value="Place Order"></a>
      <br>
      <a href="index.php"><input type="submit" value="Continue Shopping"></a>
    
      <form action='cart.php' method='post' id='cancel_form'>
        <input type='submit' name='cancel' value='Cancel Order'>
      </form>
      
   
</main>

<?php
   include('includes/footer.php'); 
?>

