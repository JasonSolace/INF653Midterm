<?php
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $author = new Author($db);

    $data = json_decode(file_get_contents("php://input"));

    $author->id = $data->id;
   
    if($author->delete()){
        $author_arr = array(
            'id' => $author->id,
        );

        print_r(json_encode($author_arr));
    }else{
        echo json_encode(
            array('message' => 'Author Not Deleted')
        );  
    }