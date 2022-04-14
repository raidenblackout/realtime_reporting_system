<?php

require_once 'mysqlConn.php';
require_once 'dependencyFunctions.php';


$post_id = $_POST['post_id'];
$user_id = $_POST['user_id'];

$currentStatus = getBookMarkStatus($post_id,$user_id);
if($currentStatus == 1){
    $sql = "DELETE FROM bookmarks WHERE p_id = '$post_id' AND u_id = '$user_id'";
    $result = $conn->query($sql);
}else{
    $sql = "INSERT INTO bookmarks (p_id, u_id) VALUES ('$post_id', '$user_id')";
    $result = $conn->query($sql);
}
$data=array();
$data['success']=''.true;
$data['bookmark_status']=''.getBookMarkStatus($post_id,$user_id);
echo json_encode($data);



?>