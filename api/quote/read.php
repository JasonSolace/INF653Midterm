<?php   
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $quote = new Quote($db);

    // Query
    $result = $quote->read();
    $num = $result->rowCount();

    if ($num < 0){
        $quotes_arr = array();
        $quotes_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => $quotation,
                'category' => $category,
                'category_id' => $category_id,
                'author_id' => $author_id
            );

            array_push($quotes_arr['data'], $quote_item);
        }

        echo json_encode($quotes_arr);
    } else {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }