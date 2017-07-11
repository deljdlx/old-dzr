<?php

use DZR\Application\Configuration\Datasource;

require(__DIR__ . '/../class/Autoloader.php');
ini_set('display_errors', 'on');

$coreAutoloader = new \DZR\Autoloader('DZR', __DIR__ . '/../class');
$coreAutoloader->register();

$applicationAutoloader = new \DZR\Autoloader('DZR\Application', __DIR__ );
$applicationAutoloader->register();

//=======================================================


$pdo=new PDO(
    Datasource::getDSN(),
    Datasource::getLogin(),
    Datasource::getPassword()
);

$datasource=new \DZR\Datasource($pdo);
$application = new \DZR\Application();
$application->register('datasource', $datasource);