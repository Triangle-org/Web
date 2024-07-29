<?php

use Triangle\Router;

Router::any('/hello/{name}', function (support\Request $request, string $name) {
    return response("Привет, $name!");
});