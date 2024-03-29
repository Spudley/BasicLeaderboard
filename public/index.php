<?php
require '../vendor/autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = \App\Database\DBFactory::newInstance();
$router = new \App\Core\Router($db);
try {
    echo $router->routeTo($_SERVER["REQUEST_URI"]);
} catch(Exception $e) {
    return(false);  //for the benefit of php's built-in web server, return false here tells it to try to load an actual file.
}

