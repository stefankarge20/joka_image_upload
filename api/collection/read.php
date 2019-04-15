

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

// initialize object
$line = new Line($db);

// query lines
$stmt = $line->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // products array
    $line_arr=array();
    $line_arr["lines"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $line_item=array(
            "id" => $id,
            "name" => $name,
            "category" => $category,

        );

        array_push($line_arr["lines"], $line_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show categories data in json format
    echo json_encode($line_arr);
}

else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no categories found
    echo json_encode(
        array("message" => "No Lines found.")
    );
}
?>