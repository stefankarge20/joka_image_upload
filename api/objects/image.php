<?php

class Image{

    // database connection and table name
    private $conn;
    private $table_name = "images";

    // object properties
    public $id;
    public $productId;
    public $name;
    public $usageFor;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read($productId){
        $query = "SELECT id, productId, name, usageFor FROM " . $this->table_name . " WHERE productId = :productId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
        return $stmt;
    }

    public function update($imageId, $usageFor){
        $query = "UPDATE " . $this->table_name . " SET usageFor = :usageFor WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->usageFor=htmlspecialchars(strip_tags($usageFor));
        $this->id=htmlspecialchars(strip_tags($imageId));
        $stmt->bindParam(':usageFor', $this->usageFor);
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // delete the product_image
    function delete_image($imageId){
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function resizeAndSave($imageFile, $productId) {

        $source_image = null;
        if($this->endsWith($imageFile, "png")){
            $source_image = imagecreatefrompng($imageFile);
        }else{
            $source_image = imagecreatefromjpeg($imageFile);
        }


        $this->saveinResolution($source_image,  $imageFile, "big", $productId);
        $this->saveinResolution($source_image,  $imageFile, "middle", $productId);
        $this->saveinResolution($source_image,  $imageFile, "thumbnail", $productId);
        unlink($imageFile);
    }

    function saveToDB($productId){
        $query = "INSERT INTO " . $this->table_name . " (`id`, `productId`, `name`, `usage`) VALUES (NULL, '".$productId."', '', '')";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $last_id = $this->conn->lastInsertId();
        return $last_id;
    }

    function saveinResolution($source_image, $oldFilename,  $typeFolder,  $productId){
        $imageId = $this->saveToDB($productId);

        if($typeFolder == "big"){
            $dest_imagex = 1200;
            $dest_imagey = 2487;
        }else if($typeFolder == "middle"){
            $dest_imagex = 570;
            $dest_imagey = 570;
        }else{
            $dest_imagex = 300;
            $dest_imagey = 300;
        }

        $dest_image = imagecreatetruecolor($dest_imagex, $dest_imagey);
        $source_imagex = imagesx($source_image);
        $source_imagey = imagesy($source_image);
        imagecopyresampled($dest_image, $source_image, 0, 0, 0, 0, $dest_imagex, $dest_imagey, $source_imagex, $source_imagey);

        $filename = "";
        if($this->endsWith($oldFilename, "png")){
            $filename = $this->getPathFileName( $typeFolder, ".png",$productId, $imageId);
            imagepng($dest_image, $filename,100);
        }else{
            $filename = $this->getPathFileName( $typeFolder, ".jpg", $productId, $imageId);
            imagejpeg($dest_image, $filename,100);
        }
        $this->updateFilename($imageId, $filename);
    }

    function getPathFileName($typeFolder, $fileExtension, $productId, $imageId){
        $folder =  dirname(__FILE__);
        $currentFolder = "api" . DIRECTORY_SEPARATOR . "objects";
        $destinationFolder = "uploads" . DIRECTORY_SEPARATOR.$typeFolder.DIRECTORY_SEPARATOR ."";
        $resStr = str_replace($currentFolder, $destinationFolder, $folder );
        $resStr .= $productId."_".$imageId.$fileExtension;
        return $resStr;
    }

    function updateFilename($lastId, $pathFileName){
        $postion = strrpos($pathFileName, 'uploads', 0);
        $path = substr($pathFileName, $postion);
        $filename = str_replace("uploads", "", $path);
        $query = "UPDATE " . $this->table_name . " SET name = :name WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($lastId));
        $this->name=htmlspecialchars(strip_tags($filename));
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
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