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

    // used by select drop-down list
    public function readAll(){
        $query = "SELECT id, name, category FROM " . $this->table_name . " ORDER BY name";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    // used by select drop-down list
    public function read(){
        $query = "SELECT  id, name, category  FROM " . $this->table_name . " ORDER BY name";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    // used by select drop-down list
    public function readLineFromCategory($category){
        $query = "SELECT  id, name, category  FROM " . $this->table_name . " WHERE category =" . $category . "  ORDER BY name";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }
}
?>