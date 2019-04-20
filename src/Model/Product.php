<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 25/03/2019
 * Time: 18:35
 */

namespace App\Model;


class Product
{
    //Database connection
    private $conn;

    public $id;
    public $name;
    public $category;
    public $barcode;
    public $producer;
    public $description;
    public $price;
    public $imgURL;

    //constructor with $db as Database Connection
    public function __construct($db) {
        $this->conn = $db;
    }

    //read one product
    public function read($id) {
        //select query
        $query = "SELECT * FROM  products WHERE id = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute([$id]);
        $res = ["product" => $stmt->fetch()];

        // get prices and put them in $res

        return $res;
    }

    //read all products
    public function read_all() {
        //select query
        $query = "SELECT * FROM  products";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute();

        return $stmt->fetchAll();
    }

    //create a product
    public function create()
    {
        //select query
        $query = "INSERT INTO `products` (`PName`, `category`, `barcode`, `producer`, `description`, `RefPrice`, `imgURL`) VALUES (?,?,?,?,?,?,?);";
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->barcode = htmlspecialchars(strip_tags($this->barcode));
        $this->producer = htmlspecialchars(strip_tags($this->producer));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->imgURL = htmlspecialchars(strip_tags($this->imgURL));
        $this->price = htmlspecialchars(strip_tags($this->price));

        //execute query
        $stmt->execute([
            $this->name,
            $this->category,
            $this->barcode,
            $this->producer,
            $this->description,
            $this->price,
            $this->imgURL
        ]);
        $stmt = $this->conn->prepare("SELECT LAST_INSERT_ID();");
        $stmt->execute();

        $id =  $stmt->fetch()[0];

        // return the created product
        return array(
            "id" => $id,
            "PName" => $this->name,
            "category" => $this->category,
            "barcode" => $this->barcode,
            "producer" => $this->producer,
            "description" => $this->description,
            "RefPrice" => $this->price,
            "imgURL" => $this->imgURL
        );
    }

    //delete a product
    public function delete($id) {
        //select query
        $query = "DELETE FROM `products` WHERE `products`.`id` = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute([$id]);
        return $stmt;
    }

    //update a product
    public function update(){
        //select query
        $query = "UPDATE `products` 
                  SET `PName` = ?,
                  `category` = ?,
                  `barcode` = ?,
                  `producer` = ?,
                  `description` = ?,
                  `RefPrice` = ?,
                  `updated_at` = CURRENT_TIMESTAMP,
                  `imgURL` = IFNULL(?, `imgURL`) 
                  WHERE `products`.`id` = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->barcode = htmlspecialchars(strip_tags($this->barcode));
        $this->producer = htmlspecialchars(strip_tags($this->producer));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->imgURL = htmlspecialchars(strip_tags($this->imgURL));
        $this->price = htmlspecialchars(strip_tags($this->price));

        $this->imgURL = ($this->imgURL === '')?null : $this->imgURL;
        //execute query
        $stmt->execute([
            $this->name,
            $this->category,
            $this->barcode,
            $this->producer,
            $this->description,
            $this->price,
            $this->imgURL,
            $this->id
        ]);

        // get the product info back from the db

        $query = "SELECT * FROM products where id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->execute([$this->id]);

        return $stmt->fetch();

    }

    public function barcode() {
        //select query
        $query = "SELECT * FROM  products WHERE barcode = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute([$this->barcode]);

        $res = ["product" => $stmt->fetch()];

        $this->id = $res["product"]["id"];
        $query = "SELECT m.id, m.name, m.Logo, mp.price 
                  FROM marketprices mp
                  JOIN markets m 
                  ON  m.id = mp.partnerID
                  where productID = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute([$this->id]);

        $res["prices"] = $stmt->fetchAll();

        return $res;
    }

    public function search() {
        //select query
        $query = "SELECT * FROM  products";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute();
        return $stmt->fetchAll();
    }


}
