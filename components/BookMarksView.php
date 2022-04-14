<?php
require_once 'modules/checkAuthentication.php';
require_once 'components/individualPostView.php';
require_once 'modules/mysqlConn.php';
require_once 'modules/classList.php'; 
require_once 'modules/dependencyFunctions.php';
$sql = 'SELECT * FROM bookmarks WHERE u_id = '.$_SESSION['user_id'] .' LIMIT 10';
$result = $conn->query($sql);
if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $post = getPost($row['p_id']);
        echo getIndividualPost($post);
    }
}else{
    echo '<div class="alert alert-danger" role="alert">
    No bookmarks found.
  </div>';
}
?>