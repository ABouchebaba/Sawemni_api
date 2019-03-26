<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 25/03/2019
 * Time: 21:11
 */

namespace App\Config;


use PDO;
use PDOException;

class Database
{
    //Database Credentials
    private $host = "localhost";
    private $db_name = "sawemni";
    private $username = "root";
    private $password = ""; // If you're using xampp keep it blank
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            //echo "Connected Successfully";
        } catch(PDOException $exception) {
            echo "Connection Error : ". $exception->getMessage();
        }
        return $this->conn;
    }

}