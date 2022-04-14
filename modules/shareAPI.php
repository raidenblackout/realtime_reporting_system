<?php
session_start();
require_once 'dependencyImporter.php';
$post_id = $_POST['post_id'];
$result = sharePost($post_id,$_SESSION['user_id']);
$images = getImages($post_id);
$data = array();
$data['success'] = true;
$data['images'] = $images;
$data['post'] = $result;
if(sizeof($images)>0){
    $sql = "INSERT into post_image (post_id,image_url) VALUES ('$result->post_id','$images[0]')";
    $conn->query($sql);
}
echo json_encode($data);
?>