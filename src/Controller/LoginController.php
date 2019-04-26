<?php 

namespace App\Controller;

use App\Config\Database;
use App\Model\Auth;


class LoginController
{
	public function adminLogin(){
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

	public function adminLogout($id){

		$database = new Database();
        $db = $database->getConnection();
        $auth = new Auth($db);

        $logout = $auth->logoutAdmin($id);
	}

	public function userSignup(){

        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $login = new Auth($db);

        $data = json_decode(file_get_contents("php://input"), true);

        //print_r($data["mail"]);
        $login->email = filter_var($data["mail"], FILTER_SANITIZE_EMAIL);
        $login->password = filter_var($data["password"], FILTER_SANITIZE_STRING);
        $login->fullName = filter_var($data["fullName"], FILTER_SANITIZE_STRING);

        //echo($login->email);
        // add user to DB
        $user = $login->userSignup();

        //print_r($user);

        $token = $login->getUserToken($user["id"]);


        return json_encode([
            "user" => $user,
            "token" => $token
        ]);
    }

    public function userSignupFB(){
        
        $database = new Database();
        $db = $database->getConnection();
        $login = new Auth($db);

        $data = json_decode(file_get_contents("php://input"), true);

        //print_r($data["mail"]);
        $login->fb_id = filter_var($data["id"], FILTER_SANITIZE_EMAIL);
        $login->fullName = filter_var($data["name"], FILTER_SANITIZE_STRING);

        //echo($login->email);
        // add user to DB
        $user = $login->userSignupFB();

        //print_r($user);
        $token = $login->getUserToken($user["id"]);
        

        return json_encode([
            "user" => $user,
            "token" => $token
        ]);
    }

    public function userSignupGoogle(){
        
        $database = new Database();
        $db = $database->getConnection();
        $login = new Auth($db);

        $data = json_decode(file_get_contents("php://input"), true);

        //print_r($data["mail"]);
        $login->gm_id = filter_var($data["uid"], FILTER_SANITIZE_EMAIL);
        $login->fullName = filter_var($data["displayName"], FILTER_SANITIZE_STRING);
        $login->email = filter_var($data["email"], FILTER_SANITIZE_STRING);

        //echo($login->email);
        // add user to DB
        $user = $login->userSignupGoogle();

        //print_r($user);
        $token = $login->getUserToken($user["id"]);
        

        return json_encode([
            "user" => $user,
            "token" => $token
        ]);
    }

    public function userLogin(){
        //instantiate database and market object
        $database = new Database();
        $db = $database->getConnection();
        $login = new Auth($db);

        $data = json_decode(file_get_contents("php://input"), true);

        $login->email = filter_var($data["mail"], FILTER_SANITIZE_EMAIL);
        $login->password = filter_var($data["password"], FILTER_SANITIZE_STRING);

        $res = $login->userLogin();

        // if error return message
        if (isset($res["message"])){
            http_response_code(400);

            exit();
        }

        // there is no error
        http_response_code(200);

        if (isset($res["token"])){
            return json_encode($res);
        }

        $token = $login->getUserToken($res["user"]["id"]);

        $res["token"] = $token;

        return json_encode($res);
    }
}