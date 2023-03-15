<?php
    // Headers
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $author = new Author($db);

    // query
    $result = $author->read();
    // Get row count
    $num = $result->rowCount();

    
    if($num > 0){
        // Quotes array
        $author_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $author_item = array(
                'id' => $id,
                'author' => $author
            );

            //Push to "data"
            array_push($author_arr, $author_item);
        }

        // Turn to JSON and output
        echo json_encode($author_arr);
    }else{
        // No Categories
        echo json_encode(
            array(
                'message' => 'No Authors Found'
            )
        );
    }