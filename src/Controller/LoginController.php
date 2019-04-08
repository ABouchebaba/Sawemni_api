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
        $auth = $login->loginAdmin();
        $response = $auth->fetch();
        //echo json_encode($response);

        if ($response) 
        {
        	$checkToken = $login->getToken($response[0]);
        	$result = json_encode(['token' => $checkToken, 'user' => $response]);
        	echo $result;
        }

	}

	public function adminLogout($id)
	{
		$database = new Database();
        $db = $database->getConnection();
        $auth = new Auth($db);

        $logout = $auth->logoutAdmin($id);

	}	
}