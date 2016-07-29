<?php
declare(strict_types=1);
require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../core/Helper/functions.php';
\App\Helper\App::getAuth();
if(\App\Config::$MAINTENANCE && $_GET['url'] != 'maintenance'){
    header('Location: /maintenance');
    die();
}
$router = new App\Router\Router($_GET['url']);

$router->get("maintenance", "MaintenanceController@Maintenance");

$router->get("/", 'HomeController@Racine');

$router->get("home", "HomeController@index");

$router->run();
