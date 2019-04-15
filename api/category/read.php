

<?php
// required header  http://localhost/joka/api/category/read.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/category.php';

// instantiate database and category object
$database = new Database();
$db = $database->getConnection();

// initialize object
$category = new Category($db);

// query categorys
$stmt = $category->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
    // products array
    $categories_arr=array();
    $categories_arr["categories"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $category_item=array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description)
        );
        array_push($categories_arr["categories"], $category_item);
    }

    http_response_code(200);
    echo json_encode($categories_arr);
}

else{
    http_response_code(404);
    echo json_encode(
        array("message" => "No categories found.")
    );
}
?>