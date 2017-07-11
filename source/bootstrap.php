<?php
require(__DIR__ . '/class/Autoloader.php');
ini_set('display_errors', 'on');

$coreAutoloader = new \DZR\Autoloader('DZR', __DIR__ . '/class');
$coreAutoloader->register();

$applicationAutoloader = new \DZR\Autoloader('DZR\Application', __DIR__ . '/Application');
$applicationAutoloader->register();


