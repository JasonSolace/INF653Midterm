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

        
        //Get quotes
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

        public function read_single(){
            //Create Query
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
                WHERE
                    q.id = ?
                LIMIT 1
            ';

            $stmt = $this->conn->prepare($query);

            //Bind params to ?
            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Set Properties
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->category = $row['category'];
            $this->author = $row['author'];
        }

        public function create(){
            //Create Query
            $query = 'INSERT INTO ' . $this->table . '
            (quote, category_id, author_id)
            VALUES(
                :quote,
                :author_id,
                :category_id
                )
            RETURNING id, quote, category_id, author_id
            ';

            //Prepare Statement
            $stmt = $this->conn->prepare($query);

            //Clean Data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));

            //Bind Data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':author_id', $this->author_id);

            //Execute query
            if($stmt->execute()){
                return true;
            } else {
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }
    }