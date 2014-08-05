<?php

if (!is_file($autoloadFile = __DIR__ . '/../vendor/autoload.php')) {
    throw new \LogicException('Could not find autoload.php in vendor/. Did you run "composer install --dev"?');
}

require $autoloadFile;
require __DIR__ . '/Mock/Map.php';
require __DIR__ . '/Mock/Router.php';