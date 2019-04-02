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
        $data = json_decode(file_get_contents("php://input"));

        //set product property values
        $product->id = $id;
        $product->name = $data->PName;
        $product->category = $data->category;
        $product->barcode = $data->barcode;
        $product->producer = $data->producer;
        $product->description = $data->description;
        $product->price = $data->RefPrice;
        $product->imgURL = $data->imgURL;

        //lets create product now
        if ($product->update()) {
            return json_encode(
                array("message"=>"Product was updated.")
            );
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
        $data = json_decode(file_get_contents("php://input"));

        //set product property values
        $product->name = $data->PName;
        $product->category = $data->category;
        $product->barcode = $data->barcode;
        $product->producer = $data->producer;
        $product->description = $data->description;
        $product->price = $data->RefPrice;
        $product->imgURL = $data->imgURL;

        //lets create product now
        if($product->create()) {
            return json_encode(
                array("message"=>"Product was created.")
            );
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