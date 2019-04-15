<?php
// required headers http://localhost/joka/api/controller/search.php?param=deluxe
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$line = new Collection($db);

// set ID property of record to read
$param = isset($_GET['param']) ? $_GET['param'] : die();


// read the details of product to be edited
$stmt =  $query = "SELECT id, name, category FROM " . $this->table_name . " ORDER BY name";
$stmt = $this->conn->prepare( $query );
$stmt->execute();

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