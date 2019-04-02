<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 25/03/2019
 * Time: 18:35
 */

namespace App\Model;


class MarketPrices
{
    //Database connection
    private $conn;

    public $id;
    public $partnerID;
    public $productID;
    public $price;

    //constructor with $db as Database Connection
    public function __construct($db) {
        $this->conn = $db;
    }

    //read one product
    public function read($id) {
        //select query
        $query = "SELECT * FROM  marketprices WHERE id = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute([$id]);
        return $stmt;
    }

    //read all products
    public function read_all() {
        //select query
        $query = "SELECT * FROM  marketprices";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute();
        return $stmt;
    }

    //create a product
    public function create() {
        //select query
        $query = "INSERT INTO marketprices (partnerID, productID, price) VALUES (?,?,?);";
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->partnerID = htmlspecialchars(strip_tags($this->partnerID));
        $this->productID = htmlspecialchars(strip_tags($this->productID));
        $this->price = htmlspecialchars(strip_tags($this->price));

        //execute query
        $stmt->execute([$this->partnerID,
            $this->productID,
            $this->price]);
        return $stmt;
    }

    //delete a product
    public function delete($id) {
        //select query
        $query = "DELETE FROM marketprices WHERE marketprices.`id` = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute([$id]);
        return $stmt;
    }

    //update a product
    public function update(){
        //select query
        $query = "UPDATE marketprices SET partnerID = ?, productID = ?, price = ? WHERE id = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->partnerID = htmlspecialchars(strip_tags($this->partnerID));
        $this->productID = htmlspecialchars(strip_tags($this->productID));
        $this->price = htmlspecialchars(strip_tags($this->price));

        //execute query
        $stmt->execute([$this->partnerID,
            $this->productID,
            $this->price,
            $this->id]);
        return $stmt;
    }
}