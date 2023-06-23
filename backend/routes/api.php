<?php

namespace Routes;

use Dotenv\Dotenv;
use Bramus\Router\Router;
use Config\Database\Conexion;
use PDO;

// Router
$router = new Router();
$dotenv = Dotenv::createImmutable('./config/env/');
$dotenv->load();










$router->run();
?>