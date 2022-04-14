<?php
require_once 'dependencyImporter.php';

$result = signUp($_POST['fname'],$_POST['lname'],$_POST['username'],$_POST['email'],$_POST['pword']);
// echo $result;
header('Location: ../login.php');

?>