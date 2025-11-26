<?php

declare(strict_types=1);

use GuzzleHttp\Psr7\ServerRequest;
use HttpSoft\Emitter\SapiEmitter;
use League\Route\Router;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseFactoryInterface;
use GuzzleHttp\Psr7\HttpFactory;
use League\Route\Strategy\ApplicationStrategy;
use Framework\Template\RendererInterface;
use Framework\Template\Renderer;
use Framework\Template\PlatesRenderer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;

ini_set("display_errors", 1);

require dirname(__DIR__) . "/vendor/autoload.php";

$request = ServerRequest::fromGlobals();

$builder = new DI\ContainerBuilder;

$builder->addDefinitions(dirname(__DIR__) . '/config/definitions.php');

$builder->useAttributes(true);

$container = $builder->build();

$router = new Router;

$strategy = new ApplicationStrategy;
$strategy->setContainer($container);
$router->setStrategy($strategy);

$routes = require dirname(__DIR__) . '/config/routes.php';
$routes($router);

$response = $router->dispatch($request);

$emitter = new SapiEmitter;

$emitter->emit($response);
