<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization,Referer,Accept,Origin,User-Agent,Content-Type");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT, OPTIONS");

require "vendor/autoload.php";


$router = new App\Router\Router($_GET["url"]);

/***********  GET  ********************************************/

$router->get("/products", "ProductController.read_all");
        //->middleware(["AuthMiddleware.adminCheckToken"]);

$router->get("/products/:id", "ProductController.read");

$router->get("/products/barcode/:barcode", "ProductController.barcode");

$router->get("/products/name", "ProductController.search");

$router->get("/markets", "MarketController.read_all")
        ->middleware(["AuthMiddleware.adminCheckToken"]);

$router->get("/markets/:id", "MarketController.read");

$router->get("/markets/prices", "MarketController.read_allPrices");

$router->get("/markets/prices/:id", "MarketController.readPrices");

$router->get("/users/", "UserController.read_all")
        ->middleware(["AuthMiddleware.adminCheckToken"]);

$router->get("/userprices/:id", "UserController.read_userPrices");

/*************** POST  *************************************/

$router->post("/products", "ProductController.create")
        ->middleware(["AuthMiddleware.adminCheckToken"]);

$router->post("/markets", "MarketController.create")
    ->middleware(["AuthMiddleware.adminCheckToken"]);

$router->post("/markets/price", "MarketController.createPrice")
        ->middleware(["AuthMiddleware.adminCheckToken"]);

$router->post("/admin/login","LoginController.adminLogin");

$router->post("/users/signup","LoginController.userSignup")
        ->middleware(["AuthMiddleware.userCheckMailExists"]);

/*************** PUT  *************************************/

$router->put("/products/:id", "ProductController.update")
    ->middleware(["AuthMiddleware.adminCheckToken"]);

//$router->put("/products/image/:image", "ProductController.update");

$router->put("/users/ban/:id", "UserController.ban")
    ->middleware(["AuthMiddleware.adminCheckToken"]);

$router->put("/markets/:id", "MarketController.update")
    ->middleware(["AuthMiddleware.adminCheckToken"]);

$router->put("/markets/prices/:id", "MarketController.updatePrices")
    ->middleware(["AuthMiddleware.adminCheckToken"]);

/*************** DEL  *************************************/

$router->del("/products/:id", "ProductController.delete")
    ->middleware(["AuthMiddleware.adminCheckToken"]);

$router->del("/admin/logout/:id", "LoginController.adminLogout");

$router->del("/markets/:id", "MarketController.delete")
    ->middleware(["AuthMiddleware.adminCheckToken"]);

$router->del("/markets/price/:id", "MarketController.deletePrice")
    ->middleware(["AuthMiddleware.adminCheckToken"]);
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
