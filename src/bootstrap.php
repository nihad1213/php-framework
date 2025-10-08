<?php

declare(strict_types=1);

use League\Route\Router;
use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\Psr7\Response;
use HttpSoft\Emitter\SapiEmitter;
use GuzzleHttp\Psr7\ServerRequest;
use App\Controllers\HomeController;

ini_set("display_errors", 1);

require dirname(__DIR__) . "/vendor/autoload.php";

$request = ServerRequest::fromGlobals();

$router = new Router();

$router->map("GET", "/", [HomeController::class, "index"]);

$response = $router->dispatch($request);

$emitter = new SapiEmitter;

$emitter->emit($response);