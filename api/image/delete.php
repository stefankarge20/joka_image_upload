<?php
// required header  http://localhost/joka/api/image/read.php?productId=6
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
include_once '../config/database.php';
include_once '../objects/image.php';

$createdFromId = isset($_GET['createdFromId']) ? $_GET['createdFromId'] : die();

$database = new Database();
$db = $database->getConnection();
$image = new Image($db);
$result = $image->deleteImage($createdFromId);

if($result){
    http_response_code(200);
    echo json_encode(array("message" => "Delete Image " . $createdFromId . " succesfull"));
}else{
    http_response_code(404);
    echo json_encode(array("message" => "Exception during delete Image   " . $imageId));
}
?>