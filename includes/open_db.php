<?php
    $servername = 'localhost';
    $username = 'multive8_noonan';
    $password = 'Ace1229!';
    $dbname = 'multive8_cards';
    
    try {
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo $error_message;
        exit();
    }
?>