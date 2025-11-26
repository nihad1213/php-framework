<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Controller\AbstractController;

class ProductController extends AbstractController
{
    public function index(): ResponseInterface
    {
        $host = '127.0.0.1';
        $db = 'shop_db';
        $user = 'root';
        $password = "";
        $port = 3307;
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=$charset";

        $pdo = new PDO($dsn, $user, $password);
        
        $stmt = $pdo->query("SELECT * FROM product");

        $stmt->setFetchMode(PDO::FETCH_OBJ);

        $products = $stmt->fetchAll();

        return $this->render("product/index", [
            "products" => $products,
        ]);
    }

    public function show(ServerRequestInterface $request, array $args): ResponseInterface
    {
        return $this->render("product/show", [
            "id" => $args["id"]
        ]);
    }
}
