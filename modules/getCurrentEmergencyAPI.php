<?php
require_once 'dependencyImporter.php';

$sql = "SELECT * FROM `post` WHERE `p_category` = 'Emergency' ORDER BY `p_id` DESC LIMIT 1";
$result = $conn->query($sql);
$row = '';
if($result && $result->num_rows>0){
    $row = $result->fetch_assoc();
    $data = array();
    $data['success'] = true;
    $data['post'] = $row;
    echo json_encode($data);
}else{
    $data = array();
    $data['success'] = false;
    echo json_encode($data);
}



?>