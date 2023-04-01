<?php
    // Headers
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $author = new Author($db);

    //Get ID
    $author->id = isset($_GET['id']) ? $_GET['id'] : die();
    
    //Get Quote
    $author->read_single();

    if((isset($author->id) && isset($author->author))){
        $author_arr = array(
            'id' => $author->id,
            'author' => $author->author
        );
        print_r((json_encode($author_arr)));
    }else{
        print_r(json_encode(array("message" => "author_id Not Found")));
    }
    