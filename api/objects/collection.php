<?php
class Collection{

    // database connection and table name
    private $conn;
    private $table_name = "collection";

    // object properties
    public $id;
    public $name;
    public $category;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read(){
        $query = "SELECT  id, name, category  FROM " . $this->table_name . " ORDER BY name";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    public function readCollectionFromCategory($category){
        $query = "SELECT  id, name, category  FROM " . $this->table_name . " WHERE category =" . $category . "  ORDER BY name";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }


}
?>