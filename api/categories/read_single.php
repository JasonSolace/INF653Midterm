    <?php
    // Headers
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $category = new Category($db);

    //Get ID
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();
    
    //Get Quote
    $category->read_single();

    if((isset($category->id) && isset($category->category))){
        $category_arr = array(
            'id' => $category->id,
            'category' => $category->category,
        );

        //Make JSON
        print_r((json_encode($category_arr)));
    }else{
        print_r(json_encode(array("message" => "category_id Not Found")));
    }
    