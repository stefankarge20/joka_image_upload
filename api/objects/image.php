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
    public $createdFromId;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read($productId){
        $query = "SELECT id, productId, name, usageFor, createdFromId FROM " . $this->table_name . " WHERE productId = :productId AND name like '%thumbnail%'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
        return $stmt;
    }

    public function update($createdFromId, $usageFor){
        $query = "UPDATE " . $this->table_name . " SET usageFor = :usageFor WHERE createdFromId = :createdFromId";
        $stmt = $this->conn->prepare($query);
        $this->usageFor=htmlspecialchars(strip_tags($usageFor));
        $this->createdFromId=htmlspecialchars(strip_tags($createdFromId));
        $stmt->bindParam(':usageFor', $this->usageFor);
        $stmt->bindParam(':createdFromId', $this->createdFromId);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function deleteImage($createdFromId){
        $this->deleteFromDisk($createdFromId);
        $result = $this->deleteImageFromDB($createdFromId);
        return $result;
    }

    function deleteFromDisk($createdFromId){
        $query = "SELECT name FROM " . $this->table_name . " WHERE createdFromId = :createdFromId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':createdFromId', $createdFromId);
        $stmt->execute();
        $num = $stmt->rowCount();
        echo "getImagesToDelete " . $num . "<br/>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $filepath = $this->getPathToImage($name);
            unlink($filepath);
        }
    }

    function getPathToImage($filename){
        $folder =  dirname(__FILE__);
        $currentFolder = "api" . DIRECTORY_SEPARATOR . "objects";
        $destinationFolder = "uploads" .$filename ."";
        $resStr = str_replace($currentFolder, $destinationFolder, $folder );
        return $resStr;
    }

    function deleteImageFromDB($createdFromId){
        $query = "DELETE FROM " . $this->table_name . " WHERE createdFromId = :createdFromId";
        $stmt = $this->conn->prepare($query);
        $this->createdFromId=htmlspecialchars(strip_tags($createdFromId));
        $stmt->bindParam(':createdFromId', $this->createdFromId);
        if($stmt->execute()){
            return true;
        }
        return false;
    }




    public function resizeAndSave($imageFile, $productId, $usageFor) {

        $source_image = null;
        if($this->endsWith($imageFile, "png")){
            $source_image = imagecreatefrompng($imageFile);
        }else{
            $source_image = imagecreatefromjpeg($imageFile);
        }


        $createdFromId = $this->saveinResolution($source_image,  $imageFile, "big", $productId, null, $usageFor);
        $this->saveinResolution($source_image,  $imageFile, "middle", $productId, $createdFromId, $usageFor);
        $this->saveinResolution($source_image,  $imageFile, "thumbnail", $productId, $createdFromId, $usageFor);
        return $imageFile;
    }

    function saveToDB($productId, $usageFor){


        $query = "INSERT INTO " . $this->table_name . " (`id`, `productId`, `usageFor`) VALUES (NULL, :productId, :usageFor)";
        $stmt = $this->conn->prepare($query);
        $this->productId=htmlspecialchars(strip_tags($productId));
        $this->usageFor=htmlspecialchars(strip_tags($usageFor));
        $stmt->bindParam(':productId', $this->productId);
        $stmt->bindParam(':usageFor', $this->usageFor);

        $stmt->execute();
        $last_id = $this->conn->lastInsertId();
        return $last_id;
    }

    function saveinResolution($source_image, $oldFilename,  $typeFolder,  $productId, $createdFromId, $usageFor){

        $imageId = $this->saveToDB($productId, $usageFor);
        if($createdFromId == null){
            $createdFromId = $imageId;
        }

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
        $this->updateFilename($imageId, $filename,  $createdFromId);
        return $createdFromId;
    }

    function getPathFileName($typeFolder, $fileExtension, $productId, $imageId){
        $folder =  dirname(__FILE__);
        $currentFolder = "api" . DIRECTORY_SEPARATOR . "objects";
        $destinationFolder = "uploads" . DIRECTORY_SEPARATOR.$typeFolder.DIRECTORY_SEPARATOR ."";
        $resStr = str_replace($currentFolder, $destinationFolder, $folder );
        $resStr .= $productId."_".$imageId.$fileExtension;
        return $resStr;
    }

    function updateFilename($lastId, $pathFileName,  $createdFromId){
        $postion = strrpos($pathFileName, 'uploads', 0);
        $path = substr($pathFileName, $postion);
        $filename = str_replace("uploads", "", $path);

        $query = "UPDATE " . $this->table_name . " SET name = :name, createdFromId = :createdFromId WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($lastId));
        $this->name=htmlspecialchars(strip_tags($filename));
        $this->createdFromId=htmlspecialchars(strip_tags($createdFromId));
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':createdFromId', $this->createdFromId);
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