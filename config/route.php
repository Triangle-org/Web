<?php

use Triangle\Request;
use Triangle\Response;
use Triangle\Router;

Router::any('/hello/{name}', function (Request $request, string $name): Response {
    return response("Привет, $name!");
});