<?php
require_once "dependencyImporter.php";
$post_id = $_POST['post_id'];
$user_id = $_POST['user_id'];
$content = $_POST['comment_text'];
$comment = postComment($post_id,$content,$user_id);
$data = array();
$data['success'] = true;
$data['comment'] = $comment;
echo json_encode($data);


?>