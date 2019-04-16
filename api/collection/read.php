

<?php
// required header  http://localhost/joka/api/category/read.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/collection.php';

// instantiate database and category object
$database = new Database();
$db = $database->getConnection();
$collection = new Collection($db);
$stmt = $collection->read();
$num = $stmt->rowCount();


if($num>0){
    $collection_arr=array();
    $collection_arr["lines"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $collection_item=array(
            "id" => $id,
            "name" => $name,
            "category" => $category
        );
        array_push($collection_arr["lines"], $collection_item);
    }
    http_response_code(200);
    echo json_encode($collection_arr);
}

else{
    http_response_code(404);
    echo json_encode(
        array("message" => "No Lines found.")
    );}
?>