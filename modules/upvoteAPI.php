<?php

require_once 'mysqlConn.php';
require_once 'dependencyFunctions.php';
$post_id = $_POST['post_id'];
$user_id = $_POST['user_id'];
$sql = "SELECT votes FROM votes WHERE p_id = '$post_id' AND u_id = '$user_id'";
$result = $conn->query($sql);
if($result && $result->num_rows > 0){
    $row = $result->fetch_assoc();
    $votes = $row['votes'];
    if($votes == 1){
        $sql = "UPDATE votes SET votes = 0 WHERE p_id = '$post_id' AND u_id = '$user_id'";
        $result = $conn->query($sql);
    }else{
        $sql = "UPDATE votes SET votes = 1 WHERE p_id = '$post_id' AND u_id = '$user_id'";
        $result = $conn->query($sql);
    }
}else{
    $sql = "INSERT INTO votes (p_id, u_id, votes) VALUES ('$post_id', '$user_id', '1')";
    $result = $conn->query($sql);
}
$sql = "SELECT * FROM votes WHERE p_id = '$post_id' AND votes = 1";
$result = $conn->query($sql);
$data=array();
$data['upvote_count']=''.$result->num_rows;
$data['success']=''.true;
$sql = "SELECT * FROM votes WHERE p_id = '$post_id' AND votes = -1";
$result = $conn->query($sql);
$data['downvote_count']=''.$result->num_rows;
$data['my_vote']=checkVote($post_id,$user_id);
$data['user']=$user_id;
echo json_encode($data);
?>