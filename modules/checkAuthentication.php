<?php
//check if the user is logged in
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
}

?>