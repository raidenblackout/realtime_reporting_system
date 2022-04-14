<?php
require_once 'modules/checkAuthentication.php';
require_once 'components/individualPostView.php';
require_once 'modules/mysqlConn.php';
require_once 'modules/classList.php'; 
require_once 'modules/dependencyFunctions.php';
if(isset($_GET['category'])){
    $category = $_GET['category'];  
    $sql = "SELECT * FROM post WHERE p_category = '".$category."' ORDER BY p_datetime DESC LIMIT 10";
    $result = $conn->query($sql);
    if($result && $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $post = getPost($row['p_id']);
            echo getIndividualPost($post);
        }
    }else{
        echo '<div class="alert alert-danger" role="alert">
        No posts found in this category.
      </div>';
    }
}else if(isset($_GET['search'])){
    $search = $_GET['search'];  
    $sql = "SELECT * FROM post WHERE p_content LIKE '%".$search."%' ORDER BY p_datetime DESC LIMIT 10";
    $result = $conn->query($sql);
    if($result && $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $post = getPost($row['p_id']);
            echo getIndividualPost($post);
        }
    }else{
        echo '<div class="alert alert-danger" role="alert">
        No posts found that matches the query.
      </div>';
    }
}else if(isset($_GET['post_id'])){
    $post_id = $_GET['post_id'];
    $post = getPost($post_id);
    echo getIndividualPost($post);
}else{
    $sql = "SELECT * FROM post ORDER BY p_datetime DESC LIMIT 10";
    $result = $conn->query($sql);
    if($result && $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $post = getPost($row['p_id']);
            echo getIndividualPost($post);
        }
    }
}

?>