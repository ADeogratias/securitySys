<?php

session_start();

$username = "";
$password = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'smart_security');

// user logging in 
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['email']);
  $password = mysqli_real_escape_string($db, $_POST['pass']);

  if (empty($username)) array_push($errors, "Username is required");
  if (empty($password)) array_push($errors, "Password is required");

  if (count($errors) == 0) {
    
    // Admin log in 
    $query = "SELECT * FROM smart_security.admin WHERE adminName='$username' AND adminPassword='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $row=mysqli_fetch_assoc($results);

      $_SESSION['username'] = $username;      
      $userid=$row['id'];
      $_SESSION['userid'] = $userid;
      $_SESSION['adminT'] = $userid;
      
      header('location: adminsmartsec/index.php');

    } 
    
    else{
    $password = md5($password);
    
      // Client log in 
      $query = "SELECT * FROM smart_security.client WHERE client.email='$username' AND client.password='$password' AND client.isdeleted='no'";
      $results = mysqli_query($db, $query);
      if (mysqli_num_rows($results) == 1) {
        $row=mysqli_fetch_assoc($results);
        $_SESSION['username'] = $username;
        $_SESSION['acc_no'] = $row['acc_no'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['phone'] = $row['phone'];
            
        $userid=$row['id'];
        $_SESSION['userid'] = $userid;
        $_SESSION['ClientT'] = $userid;

        header('location: adminsmartsec/clientIndex.php');

      }
      else{
        // teller log in 
        $query = "SELECT * FROM smart_security.teller WHERE teller.email='$username' AND teller.password='$password' AND teller.isdeleted='no'";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {
              
          $row=mysqli_fetch_assoc($results);
          $_SESSION['username'] = $row['name'];
          $_SESSION['department'] = $row['department'];
          $_SESSION['email'] = $row['email'];
          $_SESSION['phone'] = $row['phone'];
                
          $userid=$row['id'];
          $_SESSION['userid'] = $userid;
          $_SESSION['TellerT'] = $userid;
        
          header('location: adminsmartsec/tellerIndex.php');
        }
      }
    }

    if (!(mysqli_num_rows($results) == 1)){
    $error = "username/password incorrect";
    $_SESSION['error'] = $error;
    array_push($errors, "Wrong username/password combination");
    header('location: index.php');
  }


  }else {
    $error = "username/password incorrect";
    $_SESSION['error'] = $error;
    array_push($errors, "Wrong username/password combination");
    header('location: index.php');
  }
}

?>