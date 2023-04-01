<?php
    class Author{
        //DB Stuff
        private $conn;
        private $table = 'authors';

        //Post Properties
        public $id;
        public $author; 

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        
        //Get quotes
        public function read(){
            // Create Query
            $query = 'SELECT 
                        a.id,
                        a.author
                    FROM  
                    ' . $this->table . ' a
                    ';

        //Prepared Statement
        $stmt = $this->conn->prepare($query);

        // Execute Statement
        $stmt->execute();

        return $stmt;
        }

        public function read_single(){
                //Create Query
                $query = '
            SELECT 
                a.id,
                a.author
            FROM  
            ' . $this->table . ' a
            WHERE
                a.id = ?
            LIMIT 1
            ';

            $stmt = $this->conn->prepare($query);

            //Bind params to ?
            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Set Properties
            $this->id = $row['id'];
            $this->author = $row['author'];
        }

        public function create(){
            //Create Query
            $query = 'INSERT INTO ' . $this->table . '
            (author)
            VALUES(
                :author
                )
            RETURNING id, author
            ';

            //Prepare Statement
            $stmt = $this->conn->prepare($query);

            //Clean Data
            $this->author = htmlspecialchars(strip_tags($this->author));

            //Bind Data
            $stmt->bindParam(':author', $this->author);

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
                author = :author
            WHERE
                id = :id
            ';

            //Prepare Statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->author = htmlspecialchars(strip_tags($this->author));

            //Bind Data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':author', $this->author);

            //Execute Query
            if($stmt->execute()){
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        //Delete Author
        public function delete(){
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(':id', $this->id);

            
            if($stmt->execute()){
                return true;
            }else{
                
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }

    }