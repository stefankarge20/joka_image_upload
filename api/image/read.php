

<?php
// required header  http://localhost/joka/api/image/read.php?productId=6
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/image.php';

$productId = isset($_GET['productId']) ? $_GET['productId'] : die();
$database = new Database();
$db = $database->getConnection();
$image = new Image($db);
$stmt = $image->read($productId);
$num = $stmt->rowCount();

if($num>0){
    // products array
    $line_arr=array();
    $line_arr["images"]=array(); //id, productId, name, type

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $image_item=array(
            "id" => $id,
            "productId" => $productId,
            "name" => $name,
            "usageFor" => $usageFor,
            "createdFromId" => $createdFromId,
        );
        array_push($line_arr["images"], $image_item);
    }
    http_response_code(200);
    echo json_encode($line_arr);
}else{
    http_response_code(404);
    echo json_encode(
        array("message" => "No Images found for ProductId " . $productId)
    );
}
?>