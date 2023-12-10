<?php

define('ROOT_PATH', realpath(__DIR__ . '/..'));
define('ROOT_URL', '/');

require_once ROOT_PATH . '/Autoloader.php';
Autoloader::register();
require_once ROOT_PATH . '/common_functions.php';
require_once ROOT_PATH . '/router.php';
require_once ROOT_PATH . '/routes.php';