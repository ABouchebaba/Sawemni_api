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
    	$query = "DELETE FROM `admintoken` WHERE `admintoken`.`id` = ?";

    	$stmt = $this->conn->prepare($query);

    	$id = htmlspecialchars(strip_tags($id));

    	$stmt->execute([$id]);

        return $stmt;

    }

    public function getToken($id)
	{
		$query = "SELECT token FROM  admintoken where idAdmin = ? ;";
        //prepare query statement
        $token = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));

        //execute query
        $token->execute([$id]);
    	$result = $token->fetch();
    	echo $result;
        if ($result) {
        	return $result;
        }
        else {
			$header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
			$payload = json_encode(['user_id' => $this->id]);
			$base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
			$base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
			$signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'abC123!', true);
			$base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
			$jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

			$query2 = "INSERT INTO `admintoken` (`idAdmin`, `token`) VALUES (?, ?)";

			$stmt2 = $this->conn->prepare($query2);

			$id = htmlspecialchars(strip_tags($id));
			$jwt = htmlspecialchars(strip_tags($jwt));
	        //execute query
	        $stmt2->execute([
	            $id,
	            $jwt
	        ]);
	        echo $jwt;
	        return $jwt;
			}
			
	}

}