<?php
 // Headers
 include_once '../../config/Database.php';
 include_once '../../models/Quote.php';

 // Instantiate DB & connect
 $database = new Database();
 $db = $database->connect();

 // Instantiate category object
 $quote = new Quote($db);

 //Get Raw Posted Data
 $data = json_decode(file_get_contents("php://input"));

 $quote->quote = $data->quote;
 $quote->category_id = $data->category_id;
 $quote->author_id = $data->author_id;

 if (isset($quote->quote) && isset($quote->author_id) && isset($quote->category_id)){
 //Create post
    if ($quote->create()){
        echo json_encode(
            array(
                'id' => $quote->id,
                'quote' => $quote->quote,
                'author_id' => $quote->author_id,
                'category_id' => $quote->category_id
            )
        );
    } else {
        echo json_encode(
            array('message' => 'Quote not created')
        );
    }
}
