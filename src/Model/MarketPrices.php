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
    public $prices = [];

    //constructor with $db as Database Connection
    public function __construct($db) {
        $this->conn = $db;
    }

    //read one product
    public function read($id) {
        //select query
        $query = "SELECT name , price, m.id 
                  FROM markets m 
                  LEFT JOIN (
                    SELECT * FROM marketprices where productID = ?
                  ) mp
                  ON m.id = mp.partnerID ;";

        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute([$id]);
        return $stmt->fetchAll();
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
        $query = "DELETE FROM marketPrices WHERE productID = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        //$this->partnerID = htmlspecialchars(strip_tags($this->partnerID));
        $this->productID = htmlspecialchars(strip_tags($this->productID));
//        $this->prices = htmlspecialchars(strip_tags($this->prices));
        //execute query
        $stmt->execute([$this->productID]);

        $query = "INSERT INTO marketPrices (partnerID, productID, price)
                  VALUES (?, ?, ?) ";

        $stmt = $this->conn->prepare($query);

        foreach($this->prices as $mp){
            $stmt->execute([$mp["id"], $this->productID, $mp["price"]]);
        }

        return $this->prices;
    }
}