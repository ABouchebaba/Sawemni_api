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
        $stmt = $market->read_all();

        $response = json_encode($stmt->fetchAll());

        echo $response;
    }

    public function update($id){

        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $market = new Market($db);

        //get market id to be edited
        $data = json_decode(file_get_contents("php://input"));

        //set market property values
        $market->id = $id;
        $market->name = $data->name;
        $market->logo = $data->logo;
        $market->isActive = $data->isActive;

        //lets create product now
        if ($market->update()) {
            echo json_encode(
                array("message"=>"market was updated.")
            );
        } else { // if unable to do so
            echo json_encode(
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
            echo json_encode(
                array("message"=>"Market was deleted.")
            );
        }
        else { // if unable to create market, notify user
            echo json_encode(
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
        $data = json_decode(file_get_contents("php://input"));

        //set product property values
        $market->name = $data->name;
        $market->logo = $data->logo;
        $market->isActive = $data->isActive;

        //lets create product now
        if($market->create()) {
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

    //--------PRICES----------------------//
    public function readPrice($id){

        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $marketprice = new MarketPrices($db);

        //query markets
        $stmt = $marketprice->read($id);

        $response = json_encode($stmt->fetchAll());

        echo $response;
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

    public function updatePrice(){

        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $marketprice = new MarketPrices($db);

        //get market id to be edited
        $data = json_decode(file_get_contents("php://input"));

        //set market property values
        $marketprice->id = $data->id;
        $marketprice->partnerID = $data->partnerID;
        $marketprice->productID = $data->productID;
        $marketprice->price = $data->price;

        //lets create product now
        if ($marketprice->update()) {
            echo json_encode(
                array("message"=>"marketprice was updated.")
            );
        } else { // if unable to do so
            echo json_encode(
                array("message"=>"Unable to update marketprice.")
            );
        }
    }

    public function deletePrice($id){

        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $marketprice = new MarketPrices($db);

        //query markets

        if($marketprice->delete($id)) {
            echo json_encode(
                array("message"=>"marketprice was deleted.")
            );
        }
        else { // if unable to create market, notify user
            echo json_encode(
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