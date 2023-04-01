<?php
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    $database = new Database();
    $db = $database->connect();

    $quote = new Quote($db);

    $data = json_decode(file_get_contents("php://input"));

    $quote->id = isset($data->id) ? $data->id : null;

    if (isset($quote->id)){
        if($quote->delete()){
            $quote_arr = array(
                'id' => $quote->id
            );

            print_r(json_encode($quote_arr));
        }else{
            echo json_encode(
                array('message' => 'No Quotes Found')
            );
        }
    }