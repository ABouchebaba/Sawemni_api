<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 25/03/2019
 * Time: 18:35
 */

namespace App\Model;


class Auth
{

	private $conn;
    public $id;
    public $pseudo;
    public $email;
    public $password;

    //constructor with $db as Database Connection
    public function __construct($db) {
        $this->conn = $db;
    }

    public function loginAdmin()
    {
    	$query = "SELECT id, pseudo, email FROM `admins` where email = ? and password = md5(?)";
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        //execute query
        $stmt->execute([
            $this->email,
            $this->password
        ]);

        return $stmt;
    }

    public function logoutAdmin($id)
    {
    	$query = "DELETE FROM `admintoken` WHERE `admintoken`.`idAdmin` = ?";

    	$stmt = $this->conn->prepare($query);

    	$id = htmlspecialchars(strip_tags($id));

    	if ($stmt->execute([$id])) 
    	{
    		echo "admin logout successfully";
        }
        else {
        	echo "error logout";
    	}

        return $stmt;

    }

    public function getToken($id)
	{
		$query = "INSERT INTO `admintoken` (`idAdmin`, `token`, `created_at`) VALUES ( ?, ?, CURRENT_TIMESTAMP);";

		//generate Token
		$header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
		$payload = json_encode(['user_id' => $id]);
		$base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
		$base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
		$signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'abC123!', true);
		$base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
		$token = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $token = htmlspecialchars(strip_tags($token));

        //execute query
        $stmt->execute([$id,$token]);

    	$result = $stmt->fetch();
    	//echo $result;
        return $token;
		
	}

}