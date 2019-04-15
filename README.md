# joka_image_upload

Example Project with VueJS

## Installation
* Persistentce MySQL, DataBase="api_db", Username="api_db", Password="§%&ergsdg54"

CREATE TABLE `api_db`.`Images` ( `id` INT NOT NULL AUTO_INCREMENT , `productId` INT NOT NULL , `imageName` VARCHAR(255) NOT NULL , `imageType` VARCHAR(255) NOT NULL , `image` BLOB NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

## Layout
* CSS-Tree: https://bootsnipp.com/snippets/eNG7v
* Search: https://github.com/twitter/typeahead.js/
* Card: https://codepen.io/jstneg/pen/EVKYZj
* typeahead: npm i vue-bootstrap-typeahead --save