<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Chat application signUp</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>

  <body style="background-color: #ECE5DD; color:#075E54; margin-top: 200px;">
    <div class="col-lg-3 container">
        <h1 class="heading" style="margin-bottom: 20px;">Sign Up</h1>
      <div class="container">
        <form class="" action="signup.php" method="post">
          <div class="form-group">
            <label for="username">Username</label>
            <input class="form-control" type="text" name="username">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" type="password" name="password"><br>
          </div>
          <div class="form-group">
            <input class="btn btn-primary" type="submit" name="submit" value="OK">
          </div>
        </form>
      </div>
    </div>
  </body>
</html>

<?php
    if(!isset($_GET['error_id'])){
      if(isset($_POST['submit'])){
        include("db.php");
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(empty($username) || empty($password)){
            header("Location: signup.php?error_id=1");
        } else if($client -> hsetnx('users', $username, $password)){
            echo "<div class='center'>You have successfully signed up<br></div>";
        } else {
            echo "<p style='color: red'>*".$username." already exists."."</p>";
        }
        echo "<a href='login.php'><button class='btn btn-primary'>Login</button></a>";        
    }
    }
?>


<?php 

    if(isset($_GET['error_id'])){
        $error = $_GET['error_id'];
        if($error == 1){
        echo "<p style='color: red'>*Enter username/password</p>";
        }
    }

?>
