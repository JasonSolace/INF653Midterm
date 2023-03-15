<?php
// Headers
include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate category object
$category = new Category($db);


//Get Raw Quoted Data
$data = json_decode(file_get_contents("php://input"));

//Set ID to update
$category->id = $data->id;
$category->category = $data->category;

//Update quote
if ($category->update()){
    echo json_encode(
        array('message' => 'Category Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Category Not Updated')
    );
}