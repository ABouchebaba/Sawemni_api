<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 25/03/2019
 * Time: 18:21
 */

namespace App\Controller;

use App\Config\Database;
use App\Model\User;


class UserController
{
    /*
    public function read_all(){

        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $market = new User($db);

        //query market
        $stmt = $market->read_all();

        $response = json_encode($stmt->fetchAll());

        echo $response;
    }
    */

    public function read_userPrices($id){

        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $market = new User($db);

        //query market
        $stmt = $market->read_userPrices($id);

        $response = json_encode($stmt->fetchAll());

        echo $response;
    }

    public function read_all(){

        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $market = new User($db);

        //query market
        $stmt = $market->read_all();

        $response = json_encode($stmt->fetchAll());

        echo $response;
    }

    public function update($id){

        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $market = new User($db);

        //get market id to be edited
        //$data = json_decode(file_get_contents("php://input"));

        //set market property values
        $market->id = $id;
        //lets create product now
        if ($market->update()) {
            echo json_encode(
                array("message"=>"User was updated.")
            );
        } else { // if unable to do so
            echo json_encode(
                array("message"=>"Unable to update user.")
            );
        }
    }

}