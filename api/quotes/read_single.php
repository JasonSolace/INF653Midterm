<?php
    // Headers
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $quote = new Quote($db);

    //Get ID
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die();
    
    //Get Quote
    $quote->read_single();

    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'category' => $quote->category,
        'author' => $quote->author
    );

    //Make JSON
    print_r((json_encode($quote_arr)));
    