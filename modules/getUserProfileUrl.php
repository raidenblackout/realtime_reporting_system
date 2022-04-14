<?php
require_once 'dependencyImporter.php';
$user_id = $_POST['user_id'];
$result = getProfileUrl($user_id);
$data =array();
$data['success'] = true;
$data['url'] = $result;
echo json_encode($data);
?>