<?php
    // Headers
    
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate author object
    $author = new Author($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->author)){
        $author->author = $data->author;
    } else {
        $author->author = null;
    }

    if(isset($author->author)){
        $author_id = $author->create();
        //Create author
        if($author_id && $author->author){
            //Create array
            $author_arr = array(
                'id'            => $author_id,
                'author'        => $author->author,
            );

            // Make JSON
            print_r(json_encode($author_arr));
        }
    }else{
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );  
    }