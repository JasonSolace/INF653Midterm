<?php
    class Category{
        //DB Stuff
        private $conn;
        private $table = 'categories';

        //Post Properties
        public $id;
        public $category;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        
        //Get quotes
        public function read(){
            // Create Query
            $query = 'SELECT 
                        c.id,
                        c.category
                    FROM
                        ' . $this->table . ' c
                    ';

        //Prepared Statement
        $stmt = $this->conn->prepare($query);

        // Execute Statement
        $stmt->execute();

        return $stmt;
        }

        public function read_single(){
            //Create Query
            $query = 
            'SELECT 
                c.id,
                c.category
            FROM  
            ' . $this->table . ' c
            WHERE
                c.id = ?
            LIMIT 1
            ';

            $stmt = $this->conn->prepare($query);

            //Bind params to ?
            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Set Properties
            $this->id = $row['id'];
            $this->category = $row['category'];
        }

        public function create(){
            //Create Query
            $query = 'INSERT INTO ' . $this->table . '
            (category)
            VALUES(
                :category
                )
            RETURNING id, category
            ';

            //Prepare Statement
            $stmt = $this->conn->prepare($query);

            //Clean Data
            $this->category = htmlspecialchars(strip_tags($this->category));

            //Bind Data
            $stmt->bindParam(':category', $this->category);

            //Execute query
            if($stmt->execute()){
                return true;
            } else {
                printf("Error: %s.\n", $stmt->error);
                return false;
            }

        }

        public function update(){
            $query = 'UPDATE ' . $this->table . '
            SET
                category = :category
            WHERE
                id = :id
            ';

            //Prepare Statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));

            //Bind Data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':category', $this->category);

            //Execute Query
            if($stmt->execute()){
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }