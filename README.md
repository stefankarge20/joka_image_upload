# joka_image_upload

Example Project with VueJS

## Installation
* Persistentce MySQL, DataBase="api_db", Username="api_db", Password="§%&ergsdg54"

CREATE TABLE `api_db`.`Images` ( `id` INT NOT NULL AUTO_INCREMENT , `productId` INT NOT NULL , `imageName` VARCHAR(255) NOT NULL , `imageType` VARCHAR(255) NOT NULL , `image` BLOB NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

## Layout
* CSS-Tree: https://bootsnipp.com/snippets/eNG7v
* Card: https://codepen.io/jstneg/pen/EVKYZj
 
 
 # Image upload
 * https://github.com/kartik-v/bootstrap-fileinput
 * Configure The "php.ini" File 
 ** First, ensure that PHP is configured to allow file uploads. 
 ** In your "php.ini" file, search for the file_uploads directive, and set it to On: