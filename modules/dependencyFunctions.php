<?php
require_once 'classList.php';
function getUser($id){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);

    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $sql2="SELECT * FROM user WHERE u_id='".$id."'";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
    $user = new User($row2['f_name'],$row2['l_name'],$row2['u_email'],$row2['u_password'],$row2['u_id'],$row2['u_name']);
    return $user;
}

function getComment($id){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);

    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $sql2="SELECT * FROM comments WHERE c_id='".$id."'";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
    $user = getUser($row2['u_id']);
    $comment = new Comment($row2['c_id'],$row2['c_content'],$row2['u_id'],$row2['p_id'],$row2['c_time'],$user);
    $user_url = getProfileUrl($user->user_id)['profile_url'];
    $comment->user_url = $user_url;
    return $comment;
}

function getComments($id){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);

    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $sql2="SELECT * FROM comments WHERE p_id='".$id."'";
    $result2 = $conn->query($sql2);
    $comments = array();
    if($result2 && $result2->num_rows > 0){
        while($row2 = $result2->fetch_assoc()){
            $comment = getComment($row2['c_id']);
            array_push($comments,$comment);
        }
    }
    return $comments;
}
function getImages($id){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);

    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $sql2="SELECT * FROM post_image WHERE post_id='".$id."'";
    $result2 = $conn->query($sql2);
    $images = array();
    if($result2 && $result2->num_rows > 0){
        while($row2 = $result2->fetch_assoc()){
            $image = $row2['image_url'];
            array_push($images,$image);
        }
    }
    return $images;
}
function getUpVotes($id){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);

    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $sql2="SELECT * FROM votes WHERE p_id='".$id."' AND votes = 1";
    $result2 = $conn->query($sql2);
    $upvotes = $result2->num_rows;
    return $upvotes;
}
function getDownVotes($id){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);

    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $sql2="SELECT * FROM votes WHERE p_id='".$id."' AND votes = -1";
    $result2 = $conn->query($sql2);
    $downvotes = $result2->num_rows;
    return $downvotes;
}
function getPost($id){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM post WHERE p_id='".$id."'";
    $result = $conn->query($sql);
    if($result && $result->num_rows>0){
        $row = $result->fetch_assoc();
        $user = getUser($row['u_id']);
        $comments = getComments($row['p_id']);
        $images = getImages($row['p_id']);
        $post = new Post($row['p_id'],$row['p_content'],$row['u_id'],$row['p_datetime'],getUpVotes($row['p_id']),getDownVotes($row['p_id']),sizeof($comments),$row['post_owner'],$comments,$row['p_category'],$user);
        $post->images = $images;
        return $post;
    }else{
        return null;
    }
}
function checkVote($id,$u_id){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM votes WHERE p_id='".$id."' AND u_id='".$u_id."'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        return $row['votes'];
    }
    return 0;
}
function createPost($content,$user,$category){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);

    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO post (p_content,u_id,p_datetime,post_owner,p_category) VALUES ('".$content."','".$user."',NOW(),'".$user."','".$category."')";
    $result = $conn->query($sql);
    $id = $conn->insert_id;
    $post = getPost($id);
    return $post;
}

function upload($target_name,$post)
{
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rrs";
    $conn = new mysqli($hostname, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $target_dir = "../static/images/";
    $extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    if($extension == "mp4"){
        $target_dir="../static/videos/";
        $target_file = $target_dir . $target_name . "." . $extension;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO post_image (post_id,image_url) VALUES ('".$post."','".$target_name.".".$extension."')";
            $conn->query($sql);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }else if($extension == "jpg" || $extension == "png" || $extension == "jpeg"){
        $target_file = $target_dir . $target_name . "." . $extension;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO post_image (post_id,image_url) VALUES ('".$post."','".$target_name.".".$extension."')";
            $conn->query($sql);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }else{
        echo "Sorry, only JPG, JPEG, PNG & MP4 files are allowed.";
    }
}
function uploadProfilePic($target_name){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);
    $target_dir = "../static/images/";
    $extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    if($extension == "jpg" || $extension == "png" || $extension == "jpeg" ||"gif"){
        $target_file = $target_dir . $target_name . "." . $extension;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "UPDATE user SET profile_url='".$target_name.".".$extension."' WHERE u_id='".$target_name."'";
            $conn->query($sql);
            return true;
        } else {
            return false;
        }
    }else{
        return false;
    }
}

function getBookMarkStatus($id,$u_id){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM bookmarks WHERE p_id='".$id."' AND u_id='".$u_id."'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        return true;
    }
    return false;
}

function postComment($id,$content,$user){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO comments (p_id,c_content,u_id,c_time) VALUES ('".$id."','".$content."','".$user."',NOW())";
    $result = $conn->query($sql);
    $id = $conn->insert_id;
    $comment = getComment($id);
    return $comment;
}
function sharePost($id,$user){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);

    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $post = getPost($id);
    $sql = "INSERT INTO post (p_content,u_id,p_datetime,post_owner,p_category) VALUES ('".$post->content."','".$user."',NOW(),'".$post->post_owner."','".$post->category."')";
    $result = $conn->query($sql);
    $id = $conn->insert_id;
    $post = getPost($id);
    return $post;
}
function getCategories(){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM category ORDER BY c_priority DESC";
    $result = $conn->query($sql);
    $categories = array();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $categories[] = $row;
        }
    }
    return $categories;
}

function signUp($fname, $lname, $uname, $email, $pword){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO user (f_name,l_name,u_name,u_email,u_password) VALUES ('".$fname."','".$lname."','".$uname."','".$email."','".$pword."')";
    $result = $conn->query($sql);
    if($result){
        $id = $conn->insert_id;
        uploadProfilePic($id);
        return true;
    }else{
        return false;
    }
    
}
function login($uname, $pword){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM user WHERE u_name='".$uname."' AND u_password='".$pword."'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        return $row;
    }else{
        return false;
    }
}
function getProfileUrl($u_id){
    $hostname="localhost";
    $username="root";
    $password="";
    $dbname="rrs";
    $conn=new mysqli($hostname,$username,$password,$dbname);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT profile_url FROM user WHERE u_id='".$u_id."'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        return $row;
    }else{
        return false;
    }
}