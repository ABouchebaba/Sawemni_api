<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 25/03/2019
 * Time: 18:35
 */

namespace App\Model;


class Market
{
    //Database connection
    private $conn;

    public $id;
    public $name;
    public $logo;
    public $isActive;

    //constructor with $db as Database Connection
    public function __construct($db) {
        $this->conn = $db;
    }

    //read one product
    public function read($id) {
        //select query
        $query = "SELECT * FROM  markets WHERE id = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute([$id]);
        return $stmt;
    }

    //read all products
    public function read_all() {
        //select query
        $query = "SELECT * FROM  markets";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute();
        return $stmt;
    }

    //create a product
    public function create() {
        //select query
        $query = "INSERT INTO markets (name, logo, isActive) VALUES (?,?,?);";
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->logo = htmlspecialchars(strip_tags($this->logo));
        $this->isActive = htmlspecialchars(strip_tags($this->isActive));

        //execute query
        $stmt->execute([
            $this->name,
            $this->logo,
            $this->isActive]);


        $stmt = $this->conn->prepare("SELECT LAST_INSERT_ID();");
        $stmt->execute();

        $id =  $stmt->fetch()[0];

        // return the created product
        return array(
            "id" => $id,
            "name" => $this->name,
            "logo" => $this->logo,
            "isActive" => $this->isActive
        );


    }

    //delete a product
    public function delete($id) {
        //select query
        $query = "DELETE FROM markets WHERE markets.`id` = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute([$id]);
        return $stmt;
    }

    //update a product
    public function update(){
        //select query
        $query = "UPDATE markets SET name = ?, Logo = ?, isActive = ? WHERE id = ?";
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->logo = htmlspecialchars(strip_tags($this->logo));
        $this->isActive = htmlspecialchars(strip_tags($this->isActive));

        //execute query
        $stmt->execute([
            $this->name,
            $this->logo,
            $this->isActive,
            $this->id
        ]);

        return array(
            "id" => $this->id,
            "name" => $this->name,
            "logo" => $this->logo,
            "isActive" => $this->isActive
        );
    }
}