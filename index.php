<?php

  require("connection.php");

  if(isset($_POST["submit"])){
    var_dump($_POST);

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = PASSWORD_HASH($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $con->prepare("SELECT * FROM users WHERE username=:username OR email=:email");
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $userAlreadyExists = $stmt->fetchColumn();

    if(!$userAlreadyExists){
      //Registrieren
      registerUser($username, $email, $password);
    }

    else{
      //User existiert bereits
    }
  }

  function registerUser($username, $email, $password){

    global $con;

    $stmt = $con->prepare("INSERT INTO users(username, email, password) VALUES(:username, :email, :password)");
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    $stmt->execute();

    header("Location: index.php");
  }
 ?>

<?php

  require("connection.php");

  if(isset($_POST["submit-login"])){

    $email_login = $_POST["email-login"];
    $password_login = $_POST["password-login"];

    $stmt = $con->prepare("SELECT * FROM users WHERE username=:username");
    $stmt->bindParam(":username", $email_login);
    $stmt->execute();

    $userExists = $stmt->fetchAll();

    var_dump($userExists);

    $passwordHashed = $userExists[0]["password"];
    $checkPassword = password_verify($password_login, $passwordHashed);

    if($checkPassword === false){
      session_start();
      header("Location: index.php");
      echo "Login failed, the entered data is incorrect.";
    }

    if($checkPassword === true){

      session_start();

      $_SESSION["username"] = $userExists[0]["username"];

      header("Location: index.php");

    }

  }
 ?>

<!DOCTOTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title> Location Info </title>
  <link rel="stylesheet" href="css/style.css"/>
</head>

<body>
<header>

  <h2 class="logo">Geoloc</h2>
  <nav class="navigation">
    
    <a href="#" class="toggle-button">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </a>
    
    <div class="list-container">
      <ul class="uls">
        <li><a class="home" id="links" href="index.html">Home</a></li>

        <li>
          <a class="account" id="links" href="#">Account ▼</a>
          <ul class="dropdown">
            <li><a class="settings" id="links" href="#">Settings</a></li>
            <li><a class="data" id="links" href="#">Data</a></li>
          </ul>
        </li>

        <button class="btnLogin-popup">Login</button>

        <li><a class="contact" href="#">Contact Us</a></li>
      </ul>
    </div>
  </nav>

</header>

  <div class="wrapper">
    <span class="icon-close"><ion-icon name="close"></ion-icon></span>
    
    <div class="form-box login">
      <h2>Login</h2>
      <form action="index.php" method="POST">
        <div class="input-box">
          <span class="icon"><ion-icon name="mail"></ion-icon></span>
          <input type="email" name="email-login" autocomplete="off" required>
          <label>Email</label>
        </div>
        <div class="input-box">
          <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
          <input type="password" name="password-login" autocomplete="off" required>
          <label>Password</label>
        </div>
        <div class="remember-forgot">
          <label><input type="checkbox">Remember me</label>
          <a href="#">Forgot Password?</a>
        </div>
        <button name="submit-login" type="submit" class="btn">Login</button>
        <div class="login-register">
          <p>Don't have an account? <a href="#" class="register-link">Register</a> </p>
        </div>
      </form>
    </div>

    <div class="form-box register">
      <h2>Registration</h2>
      <form action="index.php" method="POST">
        <div class="input-box">
          <span class="icon"><ion-icon name="person"></ion-icon></span>
          <input type="text" name="username" autocomplete="off" required>
          <label>Username</label>
        </div>

        <div class="input-box">
          <span class="icon"><ion-icon name="mail"></ion-icon></span>
          <input type="email" name="email" autocomplete="off" required>
          <label>Email</label>
        </div>

        <div class="input-box">
          <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
          <input type="password" name="password" autocomplete="off" required>
          <label>Password</label>
        </div>

        <div class="remember-forgot">
          <label><input type="checkbox" checked>I agree to the <a href="#"> terms & conditions</a></label>
        </div>

        <button name="submit" type="submit" class="btn">Register</button>

        <div class="login-register">
          <p>Already have an account? <a href="#" class="login-link">Login</a> </p>
        </div>

      </form>
    </div>

  </div>

  <script src="js/script.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>