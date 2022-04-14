<?php
require_once 'dependencyImporter.php';

$result = signUp($_POST['fname'],$_POST['lname'],$_POST['username'],$_POST['email'],$_POST['pword']);
if($result){
    header('Location: ../login.php');
}else{
    header('Location: ../signup.php?err=1');
}

?>