<?php

include_once('config/setup.php');
class CreateDb
{
    private $con;
    function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->con = $db;
    }

    public function createDB()
    {
        try
        {
            $stmt = $this->con->prepare("CREATE DATABASE IF NOT EXISTS dbcamagru");
            $stmt->execute();
            $this->con->exec("USE dbcamagru");
            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function TblUsers()
    {
        try
        {
            $stmt = $this->con->prepare("CREATE TABLE IF NOT EXISTS `tblUsers` (
                                                  `user_id` int(11) NOT NULL AUTO_INCREMENT,
                                                  `user_name` varchar(20) NOT NULL,
                                                  `user_email` varchar(80) NOT NULL,
                                                  `user_pass` varchar(255) NOT NULL,
                                                  PRIMARY KEY (`user_id`)
                                                )");
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function TblTemp()
    {
        try
        {
            $stmt = $this->con->prepare("CREATE TABLE IF NOT EXISTS tblTemp (
                                                  user_id int(11) NOT NULL AUTO_INCREMENT,
                                                  user_name varchar(20) NOT NULL,
                                                  user_email varchar(80) NOT NULL,
                                                  user_pass varchar(255) NOT NULL,
                                                  regKey varchar(255) NOT NULL,
                                                  PRIMARY KEY (user_id)
                                                )");
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function TblImages()
    {
        try
        {
            $stmt = $this->con->prepare("CREATE TABLE IF NOT EXISTS `tblImages` (
                                                  `img_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                                  `image` varchar(255) NOT NULL,
                                                  `capture_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                                  `user_id` INT NOT NULL,
                                                   FOREIGN KEY (`user_id`) REFERENCES tblUsers(user_id)
                                                )");
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function TblComments()
    {
        try
        {
            $stmt = $this->con->prepare("CREATE TABLE IF NOT EXISTS `tblComments` (
                                                  `cmnt_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                                  `comment` varchar(255) NOT NULL,
                                                  `user_id` INT NOT NULL,
                                                  `img_id` INT NOT NULL,
                                                   FOREIGN KEY (user_id) REFERENCES tblUsers(user_id),
                                                   FOREIGN KEY (img_id) REFERENCES tblImages(img_id)
                                                )");
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function TblLikes()
    {
        try
        {
            $stmt = $this->con->prepare("CREATE TABLE IF NOT EXISTS tblLikes (
                                                  like_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                                  likes INT NOT NULL,
                                                  user_id INT NOT NULL,
                                                  img_id INT NOT NULL,
                                                  FOREIGN KEY (user_id) REFERENCES tblUsers(user_id),
                                                  FOREIGN KEY (img_id) REFERENCES tblImages(img_id)
                                                )");
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

}