<?php

//Classe qui établit la connection à la base de données

class DatabaseConnection
{
    public ?mysqli $conn=null;

    public function __construct(string $username, string $password,string $dbname,string $servername="localhost")
    {
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        } else {
            echo "<script>console.log('Connected to database succesfully')</script>";
        }
    }

}
