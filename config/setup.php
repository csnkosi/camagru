<?php

include_once("database.php");
class Database
{
    private $DSN;
    private $USER;
    private $PASSWORD;
    public $conn;

    public function __construct()
    {
        global $DB_DSN;
        global $DB_USER;
        global $DB_PASSWORD;

        $this->DSN = $DB_DSN;
        $this->USER = $DB_USER;
        $this->PASSWORD = $DB_PASSWORD;
    }

    public function dbConnection()
    {

        $this->conn = null;
        try
        {
            $this->conn = new PDO($this->DSN, $this->USER, $this->PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            echo "Connection error: " . $e->getMessage();
        }

        return $this->conn;
    }
}
