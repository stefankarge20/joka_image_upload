<?php
class Image{

    // database connection and table name
    private $conn;
    private $table_name = "images";

    // object properties
    public $id;
    public $productId;
    public $name;
    public $resolution;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read($productId){
        $query = "SELECT  id, productId, name, resolution FROM " . $this->table_name . " WHERE productId = " . productId . " ";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }
}
?>