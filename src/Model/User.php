<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 25/03/2019
 * Time: 18:35
 */

namespace App\Model;


class User
{
    //Database connection
    private $conn;
    public $id;
  /* 
    public $pseudo  
    public $FName   
    public $LName   
    public $email   
    public $password    
    public $phone   
    public $verified    
    public $canAddPrice 
  */
    //constructor with $db as Database Connection
    public function __construct($db) {
        $this->conn = $db;
    }

  /*
    public function read($id) {
        //select query
        $query = "SELECT * FROM  markets WHERE id = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute([$id]);
        return $stmt;
    }
  */

    //read all users
    public function read_all() {
        //select query
        $query = "SELECT * FROM  users";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute();
        return $stmt;
    }

    //update a user
    public function update(){
        //select query
        $query = "UPDATE user SET canAddPrice = ? WHERE id = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->canAddPrice = htmlspecialchars(strip_tags($this->canAddPrice));

        //execute query
        $stmt->execute([
            $this->canAddPrice,
            $this->id
        ]);
        return $stmt;
    }
}