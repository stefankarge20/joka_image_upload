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
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function resizeAndSave($imageFile) {
        // https://www.php.net/manual/de/function.imagecopyresized.php
        $source_image = null;
        if($this->endsWith($imageFile, "png")){
            $source_image = imagecreatefrompng($imageFile);
        }else{
            $source_image = imagecreatefromjpeg($imageFile);
        }
        $this->saveinResolution($source_image, 300, 200, $imageFile);
        unlink($imageFile);
    }

    function saveinResolution($source_image, $dest_imagex, $dest_imagey, $oldFilename){
        $dest_image = imagecreatetruecolor($dest_imagex, $dest_imagey);
        $source_imagex = imagesx($source_image);
        $source_imagey = imagesy($source_image);
        imagecopyresampled($dest_image, $source_image, 0, 0, 0, 0,
            $dest_imagex, $dest_imagey, $source_imagex, $source_imagey);
        $filename = $this->getFileName($oldFilename, $dest_imagex, $dest_imagey);
        echo "<br/>resizeAndSave " . $oldFilename . "<br/>";
        if($this->endsWith($oldFilename, "png")){
            imagepng($dest_image, $filename,100);
        }else{
            imagejpeg($dest_image, $filename,100);
        }
    }

    function getFileName($oldFilename, $dest_imagex, $dest_imagey){
        return "";
    }

    function endsWith($string, $end){
        $length = strlen($end);
        if ($length == 0) {
            return true;
        }
        return (substr($string, -$length) === $end);
    }
}

?>