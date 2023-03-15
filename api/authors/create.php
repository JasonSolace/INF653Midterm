<?php
 // Headers
 include_once '../../config/Database.php';
 include_once '../../models/Author.php';

 // Instantiate DB & connect
 $database = new Database();
 $db = $database->connect();

 // Instantiate category object
 $author = new Author($db);

 //Get Raw Posted Data
 $data = json_decode(file_get_contents("php://input"));

 $author->author = $data->author;

 //Create post
 if ($author->create()){
    echo json_encode(
        array('message' => 'Author created')
    );
 } else {
    echo json_encode(
        array('message' => 'Author not created')
    );
 }
