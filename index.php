<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 25/03/2019
 * Time: 16:02
 */

require "vendor/autoload.php";


$router = new App\Router\Router($_GET["url"]);

/***********  GET  ********************************************/

$router->get("/products", "ProductController.read_all");

$router->get("/products/:id", "ProductController.read");

/*************** POST  *************************************/

$router->post("/products/:id", function ($id) {
    echo "Getting Products ". $id;
});

/*************** PUT  *************************************/

$router->put("/products", "ProductController.update");

/*************** DEL  *************************************/

$router->del("/products/", "ProductController.delete");


/**************************************************************/

$router->run();