<?php
  session_start();

  $pageTitle = "Payment Information";
  $description = "Displays order details and form for payment information";
  include('includes/other_header.php'); 
  
  $user = $_SESSION['current_user'];
  $order_check = get_order_items($db, $user);
  $order_num = get_order_num($db, $user);
  
  if ($order_check == NULL) {
    echo '<section class="empty_cart"><p>No orders to display.</p>';
    echo "<p><form action='index.php'>
          <input type='submit' value='Return to Store'>
          </form></p></section>";
    include('includes/footer.php');
    exit();
  }
  
?>
    <main class='cart'>
        <h2>Past Orders</h2>
          <?php  
           $check = 0;
               foreach ($order_check as $card) {
                $card_name = get_card_name($db, $card['card_ID']);
                $unit_price = get_price($db, $card['card_ID']);           
                $formatted_unit_price = sprintf("$%.2f",$unit_price);
                $formatted_total_2 = sprintf("$%.2f",$unit_price * $card['quantity']);
                $image_file = "img/card_images/".$card['card_ID'].".png";
            ?>
                <?php
                 if ($check != $card['order_num'] ){
                 ?>
                    <table>
                      <thead>
                        <tr>
                          <th colspan="4" id="table_title2"><?php echo substr($card['order_date'], 0, -9); ?></th>
                        </tr>
                        <tr>
                            <th class="table_head"></th>
                            <th class="table_head">Card</th>
                            <th class="table_head">Quantity</th>
                            <th class="table_head">Total Price</th>
                        </tr>
                      </thead>
                        <tbody>
                            <tr>
                             <?php
                             }
                                $check = $card['order_num'];
                             ?>
                             <td class='table_data'><?php echo "<img src=" . $image_file . " alt={" . $card['card_ID'] . "}>"; ?></td>
                             <td class='table_data'><?php echo $card_name; ?></td>
                             <td class='table_data'><?php echo $card['quantity']; ?></td>
                             <td class='table_data'><?php echo $formatted_total_2; ?></td>
                          </tr>
            <?php  
                }
            ?> 
        </tbody>
    </table>
    
        <a href="index.php" class="back"><input type="button" value="Back to Shop"></a>
   
</main>

<?php
   include('includes/footer.php'); 
?>

