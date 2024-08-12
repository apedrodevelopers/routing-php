<?php

    require __DIR__ . "/Router.php";
    require __DIR__ . "/Controllers/ProductController.php";

    $httpMethod = $_SERVER["REQUEST_METHOD"];
    $url = $_SERVER["REQUEST_URI"];

    // GET / => show home page
    // GET /product/create => show form for creating a new product
    // POST /product/store => store the product data to db

    $router = new App\Router;

    $router->add(
        httpMethod: "GET",
        route: "/",
        handler: function () {
            echo "Home page";
        }
    );
    
    $router->add(
        httpMethod: "GET",
        route: "/product/create",
        handler: [App\Controllers\ProductController::class, "create"]
    );

    $router->add(
        httpMethod: "POST",
        route: "/product/store",
        handler: function () {
            echo "Create a new product";
            print_r( $_POST );
        }
    );

    $router->fallback( function () {
        echo "Not found";
    } );

    $router->run(
        httpMethod: $httpMethod,
        url: $url
    );

