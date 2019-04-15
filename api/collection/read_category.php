<?php
// required headers http://localhost/joka/api/line/read_category.php?category=1
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/collection.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$line = new Collection($db);

// set ID property of record to read
$category = isset($_GET['category']) ? $_GET['category'] : die();

// read the details of product to be edited
$stmt = $line->readLineFromCategory($category);

$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
    // products array
    $categories_arr=array();
    $categories_arr["collection"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $category_item=array(
            "id" => $id,
            "name" => $name,
            "category" => $category,
        );
        array_push($categories_arr["collection"], $category_item);
    }

    http_response_code(200);
    echo json_encode($categories_arr);
} else{
    http_response_code(404);
    echo json_encode(array("message" => "Collection does not exist."));
}
?>