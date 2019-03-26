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
    public $imgURL;
    public $prices;

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

}