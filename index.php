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

$router->get("/markets/price", "MarketController.read_allPrice");

$router->get("/markets/price/:id", "MarketController.readPrice");

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

$router->put("/users/:id", "UserController.update");

$router->put("/markets/:id", "MarketController.update");

$router->put("/markets/price/", "MarketController.updatePrice");

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
