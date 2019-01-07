
  <?php 
    
    function verify_login($db, $username, $password)
    {
      $query = "SELECT user_pass FROM users WHERE user_name = :user";
      $statement = $db->prepare($query);
      $statement->bindValue(':user', $username);
      $statement->execute();
      $result = $statement->fetch();
      $statement->closeCursor();
      $hash = $result['user_pass'];
      return password_verify($password, $hash);
    }
    
    function existing_username($db, $username)
    {
      $query = "SELECT COUNT(user_name) FROM users WHERE user_name = :username";
      $statement = $db->prepare($query);
      $statement->bindValue(':username', $username);
      $statement->execute();
      $exists = $statement->fetch();
      $statement->closeCursor();
      return $exists[0] == 1;
    }

    function addUser($db, $username, $password) {
      $query = "INSERT INTO users (user_name, user_pass)
                VALUES (:username, :password)";
      $statement = $db->prepare($query);
      $statement->bindValue(':username', $username);
      $statement->bindValue(':password', $password);
      $success = $statement->execute();
      $statement->closeCursor();     
      return $success;
    }
    
     
    function validPassword($password){
      $valid_pattern = '/(?=^.{8,}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*$/';
      if (preg_match($valid_pattern, $password))
        return true;
      else
        return false;
    }

?>
