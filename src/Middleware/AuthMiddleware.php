<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 19/04/2019
 * Time: 20:37
 */

namespace App\Middleware;

use App\Config\Database;


class AuthMiddleware
{

    public function adminCheckToken(){

        $headers = apache_request_headers();

        if (!isset($headers["Authorization"])){
            return ["message" => "Access denied"];
        }
        $token = $headers["Authorization"];

        $db = new Database();
        $db = $db->getConnection();

        $query = "SELECT * FROM admintoken WHERE token = ? ";

        $stmt = $db->prepare($query);

        $stmt->execute([$token]);
        $res = $stmt->fetchAll();

        if (count($res) == 1){
            return true;
        }

        return ["message" => "Invalid token"];
    }

    public function userCheckToken(){
        $headers = apache_request_headers();

        if (!isset($headers["Authorization"])){
            return ["message" => "Access denied"];
        }
        $token = $headers["Authorization"];

        $db = new Database();
        $db = $db->getConnection();

        $query = "SELECT * FROM userstoken WHERE token = ? ";

        $stmt = $db->prepare($query);

        $stmt->execute([$token]);
        $res = $stmt->fetchAll();

        if (count($res) == 1){
            return true;
        }

        return ["message" => "Invalid token"];
    }

}