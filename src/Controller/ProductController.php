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

    public function update($id){

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        //get product id to be edited
        $data = json_decode(file_get_contents("php://input"));

        //set product property values
        $product->id = $id;
        $product->name = $data->name;
        $product->category = $data->category;
        $product->barcode = $data->barcode;
        $product->producer = $data->producer;
        $product->description = $data->description;
        $product->price = $data->price;
        $product->imgURL = $data->imgURL;

        //lets create product now
        if ($product->update()) {
            echo json_encode(
                array("message"=>"Product was updated.")
            );
        } else { // if unable to do so
            echo json_encode(
                array("message"=>"Unable to update product.")
            );
        }
    }

    public function delete($id){

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        //query products

        if($product->delete($id)) {
            echo json_encode(
                array("message"=>"Product was deleted.")
            );
        }
        else { // if unable to create product, notify user
            echo json_encode(
                array("message"=>"Unable to delete product.")
            );
        }

    }

    public function create(){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        //get posted data
        $data = json_decode(file_get_contents("php://input"));

        //set product property values
        $product->name = $data->name;
        $product->category = $data->category;
        $product->barcode = $data->barcode;
        $product->producer = $data->producer;
        $product->description = $data->description;
        $product->price = $data->price;
        $product->imgURL = $data->imgURL;

        //lets create product now
        if($product->create()) {
            echo json_encode(
                array("message"=>"Product was created.")
            );
        }
        else { // if unable to create product, notify user
            echo json_encode(
                array("message"=>"Unable to create product.")
            );
        }
    }

    public function barcode($barcode){

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        //query products
        $stmt = $product->barcode($barcode);

        $response = json_encode($stmt->fetchAll());

        echo $response;


    }

    public function search($name){


        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        //query products
        $stmt = $product->search($name);
        $response = json_encode($stmt->fetchAll());
        echo $response;

    }
}