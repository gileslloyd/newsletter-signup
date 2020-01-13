<?php

$autoloader = require __DIR__.'/../../../../../vendor/autoload.php';
$autoloader->addPsr4("", __DIR__.'/classes/');

require_once(__DIR__."/../../bootstrap.php");

$router = new Message\MessageHandler();
require_once(__DIR__.'/routes.php');

$app = new Message\MessageListener(new Configuration('rabbit'), $router);
$app->run();
