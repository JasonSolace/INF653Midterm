<?php
    class Quote{
        //DB Stuff
        private $conn;
        private $table = 'quotes';

        //Post Properties
        public $id;
        public $quotation;
        public $category_id;
        public $category_name;
        public $author; //We need to get this still
        public $author_id;

        // Constructor with DB
        public function __construc($db) {
            $this->conn = $db;
        }

        // Get Posts
        
        public function read(){
            // Create Query
            $query = 'SELECT 
                c.category as category_name,
                q.id,
                q.quote,
                q.category_id,
                q.author_id
            FROM  
                ' . $this->table . ' q
            LEFT JOIN
                categories c on q.category_id = c.id';

        //Prepared Statement
        $stmt = $this->conn->prepare($query);

        // Execute Statement
        $stmt->execute();

        return $stmt;
        }
    }