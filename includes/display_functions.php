<?php

function get_customer_html($card) {
  
    $image_file = "img/card_images/".$card['card_num'].".png";
    
    $formatted_price = sprintf("$%.2f",$card['price']);
    
    $html_out = <<<EOD
        <figure>
          <img src="{$image_file}" alt="{$card['card_num']}">
          <figcaption>
            <span class='cardName'>{$card['card_name']}</span><br>
            {$formatted_price}<br>
            Quantity In Stock: {$card['qty']}<br>
            <form class="addCart" method='post'>
              <input type="hidden" name="card_id" value={$card['card_num']}>
              <input class='amount' type="number" name="qty" min="1" max={$card['qty']}>
              <input type="submit" value="Add to Cart">        
            </form>
        </figcaption>
      </figure>
EOD;
    
    return $html_out;
 }
 
 function get_admin_html($card) {
  
    $image_file = "img/card_images/".$card['card_num'].".png";
    
    $formatted_price = sprintf("$%.2f",$card['price']); 
    
    $html_out = <<<EOD
        <figure>
          <img src="{$image_file}" alt="{$card['card_num']}">
          <figcaption>
            <span class='cardName'>{$card['card_name']}</span><br>
            {$formatted_price}<br>
            <form action="admin.php" method='POST'>
              <input type="hidden" name="card_id" value={$card['card_num']}>
              <input type="number" name="qty" value={$card['qty']} min="0">
              <input type="submit" name="update" value="Confirm Stock">        
            </form>
        </figcaption>
      </figure>
EOD;
    
    return $html_out;
 }
 
 function error_html() {
    
    $html_out = <<<EOD
            
        <div>
            <h3>Sorry, but the card information you entered yeilded no results.</h3>
            <br>
            <h3>Please try again :)</h3>
        </div>    
EOD;
    
    return $html_out;
 }
?>