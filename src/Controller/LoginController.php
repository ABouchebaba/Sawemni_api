<?php 

namespace App\Controller;

use App\Config\Database;
use App\Model\Auth;


class LoginController
{
	public function adminLogin()
	{
		//instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $login = new Auth($db);

        $data = json_decode(file_get_contents("php://input"));

        $login->email = $data->email;
        $login->password = $data->password;

        //query login
        $stmt = $login->loginAdmin();

        $response = $stmt->fetch();

        if ($response) 
        {
        	$checkToken = $login->getToken($response['id']);
        	$result = json_encode(['token' => $checkToken, 'user' => $response]);
        	echo $result;
        }

	}
}