<?php

//CHECKED
function check_admin($db, $currentUser){
    
    $query = "SELECT user_type FROM users WHERE user_name = :currentUser";
    
    $statement = $db->prepare($query);
    $statement->bindValue(':currentUser', $currentUser);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result[0];
}

//CHECKED
function get_inventory($db, $search){  
  
    $query = $search;

    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $result;
    
}

//CHECKED
 function get_card_name($db, $card_ID){
 
     $query = "SELECT card_name
              FROM cards
              WHERE card_num = :card_id";

    $statement = $db->prepare($query);
    $statement->bindValue(':card_id', $card_ID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result[0];
    
}

//CHECKED
 function get_price($db, $card_ID){
  
     $query = "SELECT price 
              FROM cards
              WHERE card_num = :card_id";

    $statement = $db->prepare($query);
    $statement->bindValue(':card_id', $card_ID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result[0];
    
}

//CHECKED
function get_qty_available($db, $card_ID){
 
    $query = "SELECT qty from cards
              WHERE card_num = :card_id";

    $statement = $db->prepare($query);
    $statement->bindValue(':card_id', $card_ID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result[0];
    
}

//CHECKED
 function qty_in_cart($db, $card_ID){
   
   $query = "SELECT quantity 
              FROM cart
              WHERE card_ID = :card_id";

    $statement = $db->prepare($query);
    $statement->bindValue(':card_id', $card_ID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result[0];
    
 }
 
 //CHECKED
 function add_to_cart($db, $card_ID, $qty){
   
     $query1 = "INSERT into cart (card_ID, quantity)"
            . "VALUES (:card_id, :qty)";
     
     $query2 = "UPDATE cart SET quantity = quantity + :qty WHERE card_ID = :card_id";
     
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':card_id', $card_ID);
    $statement1->bindValue(':qty', $qty);
    
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':card_id', $card_ID);
    $statement2->bindValue(':qty', $qty);
    
    if(get_qty_available($db, $card_ID) == 0){
        
        echo '<p>There is insufficient quantity to fulfill your request.</p>';
    }
    elseif(qty_in_cart($db, $card_ID) > 0){
        
        $statement2->execute();
        $statement2->closeCursor();
    }
    else{
        $statement1->execute();
        $statement1->closeCursor();
    }
 }
 
 //CHECKED
 function top_order_num($db){
     
     $query = "SELECT MAX(order_num) FROM orderInfo";
     
     $statement = $db->prepare($query);
     $statement->execute();
     $result = $statement->fetch();
    $statement->closeCursor();
    return $result[0] + 1;
 }
 
 //CHECKED
 function track_orderinfo($db, $high_num, $user){
     
     $query1 = "INSERT into orderInfo (order_num, user_ID) VALUES (:high_num, :user)";
     
     $statement1 = $db->prepare($query1);
     $statement1->bindValue(':user', $user);
     $statement1->bindValue(':high_num', $high_num);
     $statement1->execute();
     $statement1->closeCursor();
 }
 
 //CHECKED
 function track_orderitems($db, $high_num, $card_ID, $quantity){
     
     $query2 = "INSERT into orderItems (order_num, card_ID, quantity)"
            . "VALUES (:high_num, :card_id, :qty)";
     
     $statement2 = $db->prepare($query2);
     $statement2->bindValue(':card_id', $card_ID);
     $statement2->bindValue(':qty', $quantity);
     $statement2->bindValue(':high_num', $high_num);
     $statement2->execute();
        $statement2->closeCursor();
 }

 //CHECKED
 function get_order_num($db, $user_ID){
     
     $query = "SELECT order_num FROM orderInfo WHERE user_ID = :ID";
     
    $statement = $db->prepare($query);
    $statement->bindValue(':ID', $user_ID);
    $statement->execute();
    $result = $statement->fetchall(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $result;
 }
 
 //CHECKED
 function get_order_items($db, $user_ID){
     
     $query = "SELECT orderItems.card_ID, orderItems.quantity, orderItems.order_num, orderInfo.order_date FROM orderItems INNER JOIN orderInfo WHERE orderInfo.order_num = orderItems.order_num AND orderInfo.user_ID = :ID ";
     
    $statement = $db->prepare($query);
    $statement->bindValue(':ID', $user_ID);
    $statement->execute();
    $result = $statement->fetchall(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $result;
 }
 
//returns the cart as an associative array CHECKED
 function get_cart($db){
     
   $query = "SELECT card_ID, quantity from cart";

    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $result;
    
 }
 
 //deletes all rows from the cart CHECKED
 function empty_cart($db){
     
   $query = "DELETE FROM cart";

    $statement = $db->prepare($query);
    $statement->execute();
    $statement->closeCursor();
   
 }

 //gets the total for all items in the cart CHECKED
 function get_order_total($db){
    
    $cart = get_cart($db);
    $total_price = 0;
    
    foreach ($cart as $card) {
            $unit_price = get_price($db, $card['card_ID']);
            $total_price += $unit_price * $card['quantity'];          
    }
    return $total_price;
    
 }
 
 //updates the inventory (decreases quantity available by the number of that item being purchased)
 //by calling the update_qty_available method for each item in the cart CHECKED
 function update_inventory($db){ 
     
    $cart = get_cart($db);
    
    foreach ($cart as $card) {
           update_qty_available($db, $card['card_ID'], $card['quantity']);           
    }
   
 }
 
  //updates the quantity in inventory by the $qty_decrease amount for the hat with the indicated upc CHECKED
 function update_qty_available($db, $upc, $qty_decrease){
     
  $query = "UPDATE cards
            SET qty = qty - :qty_decrease
            WHERE card_num = :upc";
  
    $statement = $db->prepare($query);
    $statement->bindValue(':upc', $upc);
    $statement->bindValue(':qty_decrease', $qty_decrease);
    $statement->execute();
    $statement->closeCursor();
 } 
 
 //CHECKED
 function admin_update_qty($db, $card_num, $new_qty){
     
  $query = "UPDATE cards
            SET qty = :new_qty
            WHERE card_num = :card_num";
  
    $statement = $db->prepare($query);
    $statement->bindValue(':card_num', $card_num);
    $statement->bindValue(':new_qty', $new_qty);
    $statement->execute();
    $statement->closeCursor();
    }
 

?>