<?php

declare(strict_types=1);

use League\Route\Router;
use Framework\Template\Renderer;
use GuzzleHttp\Psr7\HttpFactory;
use HttpSoft\Emitter\SapiEmitter;
use GuzzleHttp\Psr7\ServerRequest;
use App\Controllers\HomeController;
use Nyholm\Psr7\Factory\Psr17Factory;
use App\Controllers\ProductController;
use Framework\Template\PlatesRenderer;
use Framework\Template\RendererInterface;
use Psr\Http\Message\StreamFactoryInterface;
use League\Route\Strategy\ApplicationStrategy;
use Psr\Http\Message\ResponseFactoryInterface;

ini_set("display_errors", 1);

require dirname(__DIR__) . "/vendor/autoload.php";

$request = ServerRequest::fromGlobals();

$container = new DI\Container([
    ResponseFactoryInterface::class => DI\create(HttpFactory::class),
    StreamFactoryInterface::class => DI\create(HttpFactory::class),
    RendererInterface::class => DI\create(PlatesRenderer::class)
]);

$router = new Router;

$strategy = new ApplicationStrategy;
$strategy->setContainer($container);
$router->setStrategy($strategy);

$router->get("/", [HomeController::class, "index"]);

$router->get("/products", [ProductController::class, "index"]);

$router->get("/product/{id:number}", [ProductController::class, "show"]);

$response = $router->dispatch($request);

$emitter = new SapiEmitter;

$emitter->emit($response);