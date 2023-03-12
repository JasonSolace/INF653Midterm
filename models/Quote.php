<?php
    class Quote{
        //DB Stuff
        private $conn;
        private $table = 'quotes';

        //Post Properties
        public $id;
        public $quote;
        public $author_id;
        public $category_id;
        public $category;
        public $author; 

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Posts
        
        public function read(){
            // Create Query
            $query = 'SELECT 
                        q.id,
                        q.quote,
                        c.category,
                        a.author
                    FROM  
                    ' . $this->table . ' q
                    LEFT JOIN
                        categories c on q.category_id = c.id
                    LEFT JOIN
                        authors a on q.author_id = a.id
                    ';

        //Prepared Statement
        $stmt = $this->conn->prepare($query);

        // Execute Statement
        $stmt->execute();

        return $stmt;
        }
    }