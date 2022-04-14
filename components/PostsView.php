<?php
require_once 'modules/checkAuthentication.php';
require_once 'components/individualPostView.php';
require_once 'modules/mysqlConn.php';
require_once 'modules/classList.php'; 
require_once 'modules/dependencyFunctions.php';  
$sql = "SELECT * FROM post ORDER BY p_datetime DESC LIMIT 10";
$result = $conn->query($sql);
if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $post = getPost($row['p_id']);
        echo getIndividualPost($post);
    }
}

?>