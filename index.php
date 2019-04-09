<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Referer,Accept,Origin,User-Agent,Content-Type");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT, OPTIONS");

require "vendor/autoload.php";


$router = new App\Router\Router($_GET["url"]);

/***********  GET  ********************************************/

$router->get("/products", "ProductController.read_all");

$router->get("/products/:id", "ProductController.read");

$router->get("/products/barcode/:barcode", "ProductController.barcode");

$router->get("/products/name/:name", "ProductController.search");

$router->get("/markets", "MarketController.read_all");

$router->get("/markets/:id", "MarketController.read");

$router->get("/markets/prices", "MarketController.read_allPrices");

$router->get("/markets/prices/:id", "MarketController.readPrices");

$router->get("/users/", "UserController.read_all");

$router->get("/userprices/:id", "UserController.read_userPrices");

/*************** POST  *************************************/

$router->post("/products", "ProductController.create");

$router->post("/markets", "MarketController.create");

$router->post("/markets/price", "MarketController.createPrice");

$router->post("/admin/login","LoginController.adminLogin");

/*************** PUT  *************************************/

$router->put("/products/:id", "ProductController.update");

//$router->put("/products/image/:image", "ProductController.update");

$router->put("/users/ban/:id", "UserController.ban");

$router->put("/markets/:id", "MarketController.update");

$router->put("/markets/prices/:id", "MarketController.updatePrices");

/*************** DEL  *************************************/

$router->del("/products/:id", "ProductController.delete");

$router->del("/admin/logout/:id", "LoginController.adminLogout");

$router->del("/markets/:id", "MarketController.delete");

$router->del("/markets/price/:id", "MarketController.deletePrice");
/*************** OPTIONS  *************************************/

/**************************************************************/

try {
    http_response_code(200);
    echo $router->run();
}
catch(Exception $e){
//    http_response_code(400);
    echo json_encode(
        array("message" => "Route error")
    );
}
