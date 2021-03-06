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
    public $added_price;
    public $product_id;
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
    //Get list of user prices
    public function read_userPrices($id) {
        //select query
        $query = "SELECT userprices.userID, 
                         products.PName,   
                         userprices.price, 
                         userprices.Localization, 
                         userprices.created_at 
                         from userprices 
                         INNER join products on products.id = userprices.productID 
                         where userID = ?";

        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute([$id]);
        return $stmt;
    }
    //read all users
    public function read_all() {
        //select query
        $query = "SELECT usersinfo.FName, usersinfo.email, usersinfo.pseudo,usersinfo.phone, users.fb_id, users.gm_id, usersinfo.verified, usersinfo.canAddprice, users.created_at FROM usersinfo INNER JOIN users on users.id = usersinfo.idUser; ";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute();
        return $stmt;
    }

    public function addUserPrice(){

        $query = "INSERT INTO userPrices (userID, productID, price) VALUES(?,?,?)";

        $stmt = $this->conn->prepare($query);

        $stmt->execute([$this->id, $this->product_id, $this->added_price]);

        $id = $this->conn->lastInsertId();

        return [
            "id" => $id,
            "userID" => $this->id,
            "productID" => $this->product_id,
            "price" => $this->added_price,
        ];
    }

    //update a user
    public function update(){
        //select query
        $query = "UPDATE users SET canAddPrice = IF (`canAddPrice`, 0, 1) WHERE id = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        //execute query
        $stmt->execute([
            $this->id
        ]);
        return $stmt;
    }

    //update a user
    public function ban(){
        //select query
        $query = "UPDATE users SET canAddPrice = IF (`canAddPrice`, 0, 1) WHERE id = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        //execute query
        $stmt->execute([
            $this->id
        ]);

        $query = "SELECT * FROM users where id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->execute([$this->id]);
        $res = $stmt->fetch();

        return array(

        );

    }
}