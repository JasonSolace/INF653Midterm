<?php
// Headers
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate category object
$quote = new Quote($db);


//Get Raw Quoted Data
$data = json_decode(file_get_contents("php://input"));

if(!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

//Set ID to update
$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->category_id = $data->category_id;
$quote->author_id = $data->author_id;

//Update quote
if ($quote->update()){
    echo json_encode(
        array('message' => 'Quote Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Quote Not Updated')
    );
}