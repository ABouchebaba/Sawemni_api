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
        $res = $product->read($id);


        return json_encode($res);
    }

    public function read_all(){

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        //query products
        $res = $product->read_all();
        //$res["header"] = apache_request_headers()["Authorization"];
        return json_encode($res);

    }

    public function update($id){

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        //get product id to be edited
        $data = json_decode(file_get_contents("php://input"), true);

        $img = [];
        if (!is_null($data[1]) ) {
            //Save the image to the file system
            // returns the path in which the image has been saved
            $img = UtileController::saveImage("Public/Images/Product", $data[1]["base64"]);

            // if image not saved to file system => return error message
            if (!$img["saved"]) {
                return json_encode(
                    array("message" => "Unable to save product image.(update product)")
                );
            }
        }
        else {
            $img["path"] = null;
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
                ["id" => $id]
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
            $img["path"] = "";
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

        $product->barcode = $barcode;
        //query products
        $res = $product->barcode();
        if (isset($res["message"])) {
            http_response_code(400);
            exit($res);
        }


        return json_encode($res);
    }

    public function search(){

        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        //query products
        $res = $product->search();
        return json_encode($res);
    }



}