<?php
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $category = new Category($db);

    $data = json_decode(file_get_contents("php://input"));

    $category->id = $data->id;

    if($category->delete()){  
        $category_arr = array(
            'id' => $category->id,
        );

        // Make JSON
        print_r(json_encode($category_arr));
    }else{
        echo json_encode(
            array('message' => 'Category Not Deleted')
        );  
    }