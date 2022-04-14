<?php
require_once 'dependencyImporter.php';
$username = $_POST['username'];
$password = $_POST['password'];
$result = login($username,$password);

if($result){
    session_start();
    $_SESSION['user_id'] = $result['u_id'];
    $_SESSION['user'] = $result['u_username'];
    setcookie('user_id',$result['u_id'],time()+3600);
    header('Location: ../index.php');
}else{
    header('Location: ../login.php?err=1');
}


?>