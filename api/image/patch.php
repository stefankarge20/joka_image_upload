<?php
// required header  http://localhost/joka/api/image/read.php?productId=6
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PATCH");
include_once '../config/database.php';
include_once '../objects/image.php';

$usageFor = isset($_GET['usageFor']) ? $_GET['usageFor'] : die();
$createdFromId = isset($_GET['createdFromId']) ? $_GET['createdFromId'] : die();

$database = new Database();
$db = $database->getConnection();
$image = new Image($db);
$result = $image->update($createdFromId, $usageFor);

if($result){
    http_response_code(200);
    echo json_encode(array("message" => "Usage changed for Image " . $imageId . " --> " . $usageFor));
}else{
    http_response_code(404);
    echo json_encode(array("message" => "Exception during change Usage for Image   " . $imageId . " --> " . $usageFor));
}
?>