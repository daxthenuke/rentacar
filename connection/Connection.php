<?php
class Connection {
    private $dsn = "mysql:host=localhost;dbname=rentacar";
    private $username='root';
    private $password='20071981777';
    protected $conn;

    public function connect(){
        try {
            $this->conn = new PDO($this->dsn, $this->username, $this->password);
        } catch (PDOException $e) {
            echo "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function query($sql){
        return $this->conn->query($sql);
    }

    public function exec($sql){
        return $this->conn->exec($sql);
    }

    public function errorInfo(){
        return $this->conn->errorInfo();
    }

}