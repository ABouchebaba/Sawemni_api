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

    public function __construct()
    {

    }

    public function read($id){

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        //query products
        $stmt = $product->read($id);

        return json_encode($stmt->fetchAll());
    }

    public function read_all(){

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        //query products
        $stmt = $product->read_all();

        return json_encode($stmt->fetchAll());

    }

    public function update($id){

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        //get product id to be edited
        $data = json_decode(file_get_contents("php://input"), true);

        //Save the image to the file system
        // returns the path in which the image has been saved
        $img = UtileController::saveImage("Public/Images/Product", $data[1]["base64"]);

        // if image not saved to file system => return error message
        if(!$img["saved"]){
            return json_encode(
                array("message"=>"Unable to save product image.(update product)")
            );
        }

        //set product property values
        $product->id = $id;
        $product->name = $data[0]["PName"];
        $product->category = $data[0]["category"];
        $product->barcode = $data[0]["barcode"];
        $product->producer = $data[0]["producer"];
        $product->description = $data[0]["description"];
        $product->price = $data[0]["RefPrice"];
        $product->imgURL = $img["path"];

        //lets update product now
        if ($res = $product->update()) {
            return json_encode($res);
        } else { // if unable to do so
            return json_encode(
                array("message"=>"Unable to update product.")
            );
        }
    }

    public function delete($id){

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        if($product->delete($id)) {
            return json_encode(
                array("message"=>"Product was deleted.")
            );
        }
        else { // if unable to delete product, notify user
            return json_encode(
                array("message"=>"Unable to delete product.")
            );
        }
    }

    public function create(){

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        //get posted data
        $data = json_decode(file_get_contents("php://input"), true);

        $img = [];
        if (isset($data[1]["base64"])) {

            //Save the image to the file system
            // returns the path in which the image has been saved
            $img = UtileController::saveImage("Public/Images/Product", $data[1]["base64"]);

            // if image not saved to file system => return error message
            if (!$img["saved"]) {
                return json_encode(
                    array("message" => "Unable to save product image.(create product)")
                );
            }
        } else {
            $img["path"] = "Public/Images/Product/default.jpg";
        }
        //set product property values
        $product->name = $data[0]["PName"];
        $product->category = $data[0]["category"];
        $product->barcode = $data[0]["barcode"];
        $product->producer = $data[0]["producer"];
        $product->description = $data[0]["description"];
        $product->price = $data[0]["RefPrice"];
        $product->imgURL = $img["path"];

        //lets create product now
        if($res = $product->create()) {
            return json_encode($res);
        }
        else { // if unable to create product, notify user
            return json_encode(
                array("message"=>"Unable to create product.")
            );
        }
    }

    public function barcode($barcode){

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        //query products
        $stmt = $product->barcode($barcode);

        return json_encode($stmt->fetchAll());
    }

    public function search($name){

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        //query products
        $stmt = $product->search($name);
        return json_encode($stmt->fetchAll());
    }



}