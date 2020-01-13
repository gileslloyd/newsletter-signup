<?php
define("SRC", realpath(__DIR__."/../../").'/');
define("ROOT", realpath(SRC."../").'/');
define("APPLICATION", realpath(__DIR__."/../Application"));
define("INFRASTRUCTURE", realpath(__DIR__));

file_exists(APPLICATION.'/bootstrap.php') and require_once APPLICATION.'/bootstrap.php';

$container = \DI\Container::instance();
Domain\Event\EventBus::init($container);
