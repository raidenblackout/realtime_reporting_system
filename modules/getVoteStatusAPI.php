<?php
$post_id = $_POST['post_id'];
$user_id = $_POST['user_id'];
require_once 'mysqlConn.php';
require_once 'dependencyFunctions.php';
echo json_encode(checkVote($post_id,$user_id));


?>