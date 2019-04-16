<?php
// required headers http://localhost/joka/api/controller/search.php?param=deluxe Eiche
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

// set ID property of record to read
$param = isset($_GET['param']) ? $_GET['param'] : die();
$parts = preg_split('/ +/', $param);
$clausel = "";

foreach ($parts as &$part) {
    $sql = "AND (ca.name LIKE '%".$part."%' OR co.name LIKE '%".$part."%' OR pr.name LIKE '%".$part."%' OR pr.eanNo like '%".$part."%')";
    $clausel .= $sql;
}

// read the details of product to be edited
$query = "SELECT ca.name as 'categoryName', co.name as 'collectionName', pr.name as 'productName', pr.id as 'productId', pr.eanNo as 'eanNo' FROM categories as ca 
            join collection co on ca.id = co.category 
            join products pr on pr.collection = co.id 
                WHERE pr.category_id = ca.id " . $clausel;
$stmt = $db->prepare( $query );
$stmt->execute();

$num = $stmt->rowCount();

if($num>0){
    // products array
    $product_arr=array();
    $product_arr["products"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $product=array(
            "categoryName" => $categoryName,
            "collectionName" => $collectionName,
            "productName" => $productName,
            "productId" => $productId,
            "eanNo" => $eanNo,
        );
        array_push($product_arr["products"], $product);
    }

    http_response_code(200);
    echo json_encode($product_arr);
} else{
    http_response_code(404);
    echo json_encode(array("message" => "No Product found", "querry" => $query));
}
?>