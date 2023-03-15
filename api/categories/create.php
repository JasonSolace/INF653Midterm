<?php
 // Headers
 include_once '../../config/Database.php';
 include_once '../../models/Category.php';

 // Instantiate DB & connect
 $database = new Database();
 $db = $database->connect();

 // Instantiate category object
 $category = new Category($db);

 //Get Raw Posted Data
 $data = json_decode(file_get_contents("php://input"));

 $category->category = $data->category;

 //Create post
 if ($category->create()){
    echo json_encode(
        array('message' => 'Category created')
    );
 } else {
    echo json_encode(
        array('message' => 'Category not created')
    );
 }
