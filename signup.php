<?php
session_start();
if(isset($_SESSION['user_id'])){
    header('Location: /realtime_reporting_system/index.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
<title>Sign Up - Realtime Reporting System</title>
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
      <h3 style="color: var(--ic)">Sign Up</h3>
    </div>

    <form action="modules/signup.php" method="post" enctype="multipart/form-data">
    <div class="profilepic-container" data-placement="top" data-toggle="tooltip" data-title="Add Profile Picture">
            <img src="static/images/defaultSignUp.png" id="profilepic-img" alt="Profile Picture" style="width:10vh; height:10vh; object-fit: scale-down; position: relative" onclick="showProfileDialogueBox(event)" >
        </div>
        <input type="text" id="fname" class="fadeIn second" name="fname" placeholder="First Name" required>
        <input type="text" id="lname" class="fadeIn third" name="lname" placeholder="Last Name" required>
        <input type="text" id="login" class="fadeIn second" name="username" placeholder="Username" required>
        <input type="text" id="email" class="fadeIn second" name="email" placeholder="Email" required>
        <input type="password" id="password" class="fadeIn third" name="pword" placeholder="Password" required>
        <input type="file" id="profilepic" class="fadeIn second" name="image" accept="image/*" placeholder="Profile Picture" hidden>
        
        <input type="submit" class="fadeIn fourth" value="Sign Up">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="login.php" data-toggle="tooltip" data-placement="bottom" data-title="Sign In">Already have an account?</a>
    </div>

  </div>
</div>
</body>

</html>