<?php 
  session_start();

  $pageTitle = "Multiverse Marketplace";
  $description = "Displays the cards for sale at Multiverse Marketplace";
  include('includes/header.php');
  include('includes/display_functions.php');
?>

  <?php
  
    //adding item to cart
    if (isset($_POST['card_id'])) {
      add_to_cart($db, $_POST['card_id'], $_POST['qty']);
      unset($_POST['card_id']);      
    }
  ?>
    <main class="flex_content"> 
        <aside class="column1">
            <form action="index.php" method="POST">
                <h2>Card Search</h2>
                <input class="search" type="text" name="search" placeholder="Search..">
                <input class="searchButton" type="submit" value="Go" >
                <div>
                    <h3>Color</h3>
                            <fieldset>
                                <input type="checkbox" name="card_color[]" value="green"> Green
                                <br>
                                <input type="checkbox" name="card_color[]" value="red"> Red
                                <br>
                                <input type="checkbox" name="card_color[]" value="black"> Black
                                <br>
                                <input type="checkbox" name="card_color[]" value="blue"> Blue
                                <br>
                                <input type="checkbox" name="card_color[]" value="white"> White
                                <br>
                                <input type="checkbox" name="card_color[]" value="colorless"> Colorless
                            </fieldset>

                </div>
                <div>
                    <h3>Mana Cost</h3>
                            <fieldset>
                                <input type="checkbox" name="card_cost[]" value="= 1"> 1
                                <br>
                                <input type="checkbox" name="card_cost[]" value="= 2"> 2
                                <br>
                                <input type="checkbox" name="card_cost[]" value="= 3"> 3
                                <br>
                                <input type="checkbox" name="card_cost[]" value="= 4"> 4
                                <br>
                                <input type="checkbox" name="card_cost[]" value="= 5"> 5
                                <br>
                                <input type="checkbox" name="card_cost[]" value="= 6"> 6
                                <br>
                                <input type="checkbox" name="card_cost[]" value=">= 7"> 7+
                            </fieldset>

                </div>
                <div>
                    <h3>Rarity</h3>
                            <fieldset>
                                <input type="checkbox" name="card_rarity[]" value="C"> Common
                                <br>
                                <input type="checkbox" name="card_rarity[]" value="U"> Uncommon
                                <br>
                                <input type="checkbox" name="card_rarity[]" value="R"> Rare
                                <br>
                                <input type="checkbox" name="card_rarity[]" value="M"> Mythic
                            </fieldset>

                </div>
                <div>
                    <h3>Card Type</h3>
                            <fieldset>
                                <input type="checkbox" name="card_type[]" value="Creature"> Creatures
                                <br>
                                <input type="checkbox" name="card_type[]" value="Planeswalker"> Planeswalker
                                <br>
                                <input type="checkbox" name="card_type[]" value="Instant"> Instant
                                <br>
                                <input type="checkbox" name="card_type[]" value="Sorcery"> Sorcery
                                <br>
                                <input type="checkbox" name="card_type[]" value="Enchantment"> Enchantment
                                <br>
                                <input type="checkbox" name="card_type[]" value="Artifact"> Artifact
                                <br>
                                <input type="checkbox" name="card_type[]" value="Land"> Land
                            </fieldset>
                    
                </div>
            </form>
        </aside>
        <div class="column2">
            
            <?php
            
            $search = "SELECT card_num, card_name, price, qty FROM cards";
            
            if (isset($_POST["card_color"]) || isset($_POST["card_cost"]) || isset($_POST["card_rarity"]) || isset($_POST["card_type"])){
                
                $search = $search . " WHERE";
                
                if (isset($_POST["card_color"])){
                    
                    $color = $_POST["card_color"];
                    $search = $search . " (";
                    
                    foreach($color as $key => $attr){
                     $search = $search . "card_color LIKE '%" . $attr . "%' OR ";
                    }
                    
                    $search = chop($search, " OR");
                    $search = $search . ")";
                    
                    if (isset($_POST["card_cost"]) || isset($_POST["card_rarity"]) || isset($_POST["card_type"])){
                        $search = $search . " AND";
                    }
                }
                if (isset($_POST["card_cost"])){
                    
                    $cost = $_POST["card_cost"];
                    $search = $search . " (";
                    
                    foreach($cost as $key => $attr){
                     $search = $search . " (card_cost " . $attr . ") OR ";
                    }
                    
                    $search = chop($search, " OR");
                    $search = $search . ")";
                    
                    if (isset($_POST["card_rarity"]) || isset($_POST["card_type"])){
                        $search = $search . " AND";
                    }
                }
                if (isset($_POST["card_rarity"])){
                    
                    $rarity = $_POST["card_rarity"];
                    $search = $search . " (";
                    
                    foreach($rarity as $key => $attr){
                     $search = $search . " (card_rarity LIKE '%" . $attr . "%') OR ";
                    }
                    
                    $search = chop($search, " OR");
                    $search = $search . ")";
                    
                    if (isset($_POST["card_type"])){
                        $search = $search . " AND";
                    }
                }
                if (isset($_POST["card_type"])){
                    
                    $type = $_POST["card_type"];
                    $search = $search . " (";
                    
                    foreach($type as $key => $attr){
                     $search = $search . " (card_type LIKE '%" . $attr . "%') OR ";
                    }
                    
                    $search = chop($search, " OR");
                    $search = $search . ")";
                }
                $search = $search . " ORDER BY card_num DESC, card_color";
                
                $card_inventory = get_inventory($db, $search);
                        
                if($card_inventory == NULL){
                    echo error_html();
                }
                
                $inv_html = "";
                foreach($card_inventory as $card) { 
                    $inv_html = get_customer_html($card) . $inv_html;
                }
                echo $inv_html;
            }
            elseif(isset($_POST["search"])){
                
                $keyword = $_POST["search"];
                $search = $search . " WHERE card_name LIKE '%" . $keyword . "%'" . " ORDER BY card_num DESC";
                
                $card_inventory = get_inventory($db, $search);
                
                if($card_inventory == NULL){
                    echo error_html();
                }
                        
                $inv_html = "";
                foreach($card_inventory as $card) { 
                    $inv_html = get_customer_html($card) . $inv_html;
                }
                echo $inv_html;
            }
            else{
                $search = $search . " ORDER BY card_num DESC";
                
                $card_inventory = get_inventory($db, $search);
                        
                $inv_html = "";
                foreach($card_inventory as $card) { 
                    $inv_html = get_customer_html($card) . $inv_html;
                }
                echo $inv_html;
            }
            
            ?>
        </div>
        <div class="column3">
            <h2>My Cart</h2>
            <div>
                <?php
                
                if (get_cart($db) == NULL){
                    echo '<br> <br> <br> <br> <br> <br> <p> Your cart is empty </p>';
                }
                else{
                    
                    $my_cart = get_cart($db);
                    
                    echo "<br>";
                    
                    foreach($my_cart as $cart){
                        
                        $card_name = get_card_name($db, $cart['card_ID']);
                        
                        echo $cart["quantity"] . "x " . $card_name . "<br>";
                    }
                }
                
                ?>
            </div>
        </div>    
    </main>

<?php include('includes/footer.php') ?>