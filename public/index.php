<?php

declare(strict_types=1);

ini_set('display_errors', '1');

$page = $_GET['page'] ?? 'home';

require __DIR__ . "/{$page}" . '.php';