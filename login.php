<?php
session_start();
if(isset($_SESSION['user_id'])){
    header('Location: /realtime_reporting_system/index.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login - Realtime Reporting System</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="static/stylesheets/login.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="static/images/favicon.png">
    <?php
    include_once 'modules/bootstrapdependencies.php';
    ?>
    <script src="static/js/login.js"></script>
</head>

<body>
    <div class="wrapper fadeInDown">
  <div id="formContent">


    <div class="login-header">
      <h3 style="color: var(--ic)">Login</h3>
      <h7 style="color: red">
        <?php
        if(isset($_GET['err'])){
            echo "Invalid username or password";
        }
        ?>
      </h7>
    </div>

    <form action="modules/login.php" method="post">
      <input type="text" id="login" class="fadeIn second" name="username" placeholder="Username" required>
      <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password" required>
      <input type="submit" class="fadeIn fourth" value="Log In">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="signup.php" data-toggle="tooltip" data-placement="bottom" data-title="Sign Up">Need an account?</a>
    </div>

  </div>
</div>
</body>

</html>