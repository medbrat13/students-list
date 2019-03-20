<?php

define('ROOT', dirname(__DIR__));
define('LAYOUTS', ROOT . '/app/layouts');
define('VIEWS', ROOT . '/app/views');
define('DEFAUT_LAYOUT', 'cuteTableLayout');
define('CONF', ROOT . '/config');


require_once ROOT . '/Autoloader.php';
new \StudentsList\Autoloader();

$di = new \StudentsList\Kernel\DI();
$services = require_once __DIR__ . '/services.php';
foreach ($services as $service) {
    $provider = new $service($di);
    $provider->init();
}