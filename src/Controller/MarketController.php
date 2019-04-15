<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 25/03/2019
 * Time: 18:21
 */

namespace App\Controller;

use App\Config\Database;
use App\Model\Market;
use App\Model\MarketPrices;
use App\Controller\UtileController;


class MarketController
{
    //---------MARKET---------------------//
    public function read($id){

        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $market = new Market($db);

        //query markets
        $stmt = $market->read($id);

        $response = json_encode($stmt->fetchAll());

        echo $response;

    }

    public function read_all(){

        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $market = new Market($db);

        //query market
        $res = $market->read_all();

        return json_encode($res);
    }

    public function update($id){

        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $market = new Market($db);

        //get market id to be edited
        $data = json_decode(file_get_contents("php://input"), true);

        $img = [];
        if (!is_null($data[1])) {
            //Save the image to the file system
            // returns the path in which the image has been saved
            $img = UtileController::saveImage("Public/Images/Market", $data[1]["base64"]);

            // if image not saved to file system => return error message
            if (!$img["saved"]) {
                return json_encode(
                    array("message" => "Unable to save market image.(create market)")
                );
            }

        }
        else {
            $img["path"] = null;
        }

        //var_dump($img);
        //set market property values
        $market->id = $id;
        $market->name = $data[0]["name"];
        $market->isActive = $data[0]["isActive"];
        $market->logo = $img["path"];

        //lets create product now
        if ($res = $market->update()) {
            return json_encode($res);
        } else { // if unable to do so
            return json_encode(
                array("message"=>"Unable to update market.")
            );
        }
    }

    public function delete($id){

        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $market = new Market($db);

        //query markets

        if($market->delete($id)) {
            return json_encode(
                array("message"=>"Market was deleted.")
            );
        }
        else { // if unable to create market, notify user
            return json_encode(
                array("message"=>"Unable to delete market.")
            );
        }
    }

    public function create(){
         //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $market = new Market($db);

        //get posted data
        $data = json_decode(file_get_contents("php://input"), true);

        $img = [];
        if (isset($data[1]["base64"])) {

            //Save the image to the file system
            // returns the path in which the image has been saved
            $img = UtileController::saveImage("Public/Images/Market", $data[1]["base64"]);

            // if image not saved to file system => return error message
            if (!$img["saved"]) {
                return json_encode(
                    array("message" => "Unable to save market image.(create market)")
                );
            }
        } else {
            $img["path"] = "Public/Images/Market/default.jpg";
        }

        //set product property values
        $market->name = $data[0]["name"];
        $market->logo = $img["path"];
        $market->isActive = $data[0]["isActive"];

        //lets create product now
        if($res = $market->create()) {
            return  json_encode($res);
        }
        else { // if unable to create product, notify user
            return json_encode(
                array("message"=>"Unable to create Market.")
            );
        }
    }

    //--------PRICES----------------------//
    public function readPrices($productID){

        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $marketprice = new MarketPrices($db);

        //query markets
        //var_dump($marketprice->read($productID));
        return  json_encode($marketprice->read($productID));
    }

    public function read_allPrice(){


        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $marketprice = new MarketPrices($db);

        //query market
        $stmt = $marketprice->read_all();

        $response = json_encode($stmt->fetchAll());

        echo $response;
    }

    public function updatePrices($product_id){

        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $marketprice = new MarketPrices($db);

        //get market id to be edited
        $data = json_decode(file_get_contents("php://input"), true);

        //return (json_encode($data));
        //set market property values
        $marketprice->productID = $product_id;
        $marketprice->prices = $data;

        //lets create product now
        if ($res = $marketprice->update()) {
            return json_encode($res);
        } else { // if unable to do so
            echo json_encode(
                array("message"=>"Unable to update marketprice.")
            );
        }
    }

    public function deletePrices($id){

        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $marketprice = new MarketPrices($db);

        //query markets

        if($marketprice->delete($id)) {
            return json_encode(
                array("message"=>"marketprice was deleted.")
            );
        }
        else { // if unable to create market, notify user
            return json_encode(
                array("message"=>"Unable to delete marketprice.")
            );
        }
    }

    public function createPrice(){
        //instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();
        $marketprice = new MarketPrices($db);

        //get posted data
        $data = json_decode(file_get_contents("php://input"));

        //set product property values
        $marketprice->partnerID = $data->partnerID;
        $marketprice->productID = $data->productID;
        $marketprice->price = $data->price;

        //lets create product now
        if($marketprice->create()) {
            echo json_encode(
                array("message"=>"Market was created.")
            );
        }
        else { // if unable to create product, notify user
            echo json_encode(
                array("message"=>"Unable to create Market.")
            );
        }
    }
}