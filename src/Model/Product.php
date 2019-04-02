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
        return $stmt;
    }

    //read all products
    public function read_all() {
        //select query
        $query = "SELECT * FROM  products";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute();
        return $stmt;
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
        return $stmt;
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
                  `imgURL` = ? 
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
        return $stmt;
    }

    public function barcode($barcode) {
        //select query
        $query = "SELECT * FROM  products WHERE barcode = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute([$barcode]);
        return $stmt;
    }

    public function search($name) {
        //select query
        $query = "SELECT * FROM  products WHERE products.PName like ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute(['%'.$name.'%']);
        return $stmt;
    }
}
