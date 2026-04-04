<?php

class Database extends PDO
{
    private string $host = 'localhost';
    private string $dbname = 'f1_blog';
    private string $username = 'root';
    private string $password = '';

    public function __construct()
    {
        $dblog = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";

        try {
            parent::__construct($dblog, $this->username, $this->password);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            die("Chyba pripojenia k databáze: " . $e->getMessage());
        }
    }
}