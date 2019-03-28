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

$router->get("/products/barcode/:barcode", "ProductController.barcode");

$router->get("/products/name/:name", "ProductController.search");

/*************** POST  *************************************/

$router->post("/products", "ProductController.create");

/*************** PUT  *************************************/

$router->put("/products", "ProductController.update");

/*************** DEL  *************************************/

$router->del("/products/", "ProductController.delete");


/**************************************************************/

$router->run();