<?php

use Triangle\Router;
use support\Request;

Router::any('/hello/{name}', function (Request $request, string $name) {
    return response("Привет, $name!");
});