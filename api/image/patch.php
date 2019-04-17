

<?php
// required header  http://localhost/joka/api/image/read.php?productId=6
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PATCH");
include_once '../config/database.php';
include_once '../objects/image.php';

$imageId = isset($_GET['imageId']) ? $_GET['imageId'] : die();
$usage = isset($_GET['usage']) ? $_GET['usage'] : die();

$database = new Database();
$db = $database->getConnection();
$image = new Image($db);
$result = $image->update($imageId, $usage);

if($result){
    echo json_encode(array("message" => "Usage changed for Image " . $imageId . " --> " . $usage));
    http_response_code(200);
}else{
    http_response_code(404);
    echo json_encode(array("message" => "Exception during change Usage for Image   " . $imageId . " --> " . $usage));
}
?>