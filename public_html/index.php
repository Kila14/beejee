<?php

define('ROOT_PATH', realpath(__DIR__ . '/..'));

require_once ROOT_PATH . '/Autoloader.php';
Autoloader::register();
require_once ROOT_PATH . '/router.php';
require_once ROOT_PATH . '/routes.php';