<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 25/03/2019
 * Time: 18:21
 */

namespace App\Controller;

use App\Config\Database;
use App\Model\Product;

class ProductController
{

    public function read($id){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        //query products
        $stmt = $product->read($id);

        $response = json_encode($stmt->fetchAll());

        echo $response;
    }

    public function read_all(){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        //query products
        $stmt = $product->read_all();

        $response = json_encode($stmt->fetchAll());

        echo $response;
    }

    public function update(){

        $put = json_decode(file_get_contents('php://input'), true);

        print_r($put["key"]);

        echo "\nUpdating product to ";
    }

    public function delete(){

        $delete = json_decode(file_get_contents('php://input'), true);
//        print_r($del["blk"]);

        foreach ($delete as $k=>$v){
            print_r("$k => $v\n");
        }
        echo "\nDeleting product ID ";
    }

}