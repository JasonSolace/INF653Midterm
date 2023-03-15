<?php
    // Headers
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $category = new Category($db);

    // Quotes quote query
    $result = $category->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any quotes
    if($num > 0){
        // Quotes array
        $category_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $category_item = array(
                'id' => $id,
                'category' => $category
            );

            //Push to "data"
            array_push($category_arr, $category_item);
        }

        // Turn to JSON and output
        echo json_encode($category_arr);
    }else{
        // No Categories
        echo json_encode(
            array(
                'message' => 'No Quotes Found'
            )
        );
    }