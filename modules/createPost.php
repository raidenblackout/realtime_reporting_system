<?php
session_start();
require_once 'dependencyFunctions.php';
require_once 'classList.php';
if(isset($_POST['submit'])){
    $content = $_POST['content'];
    if($content!="" || $_FILES['image']['size']>0){
        $category = $_POST['category'];
        $post=createPost($content,$_SESSION['user_id'],$category);
    }
    if($_FILES['image']['size']>0){
        upload($post->post_id."_".$post->user_id,$post->post_id);
    }
}
header("Location: ../index.php");

?>