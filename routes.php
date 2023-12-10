<?php

get(ROOT_URL, '\App\Controllers\Index::get');
any(ROOT_URL . 'add-task', '\App\Controllers\Tasks::addTask');
any(ROOT_URL . 'edit-task', '\App\Controllers\Tasks::editTask');
any(ROOT_URL . 'log-in', '\App\Controllers\Users::logIn');
get(ROOT_URL . 'log-out', '\App\Controllers\Users::logOut');
get(ROOT_URL . 'rebuild-db-tables','\App\Controllers\Users::rebuildDBTables');
any('404','App/Controllers/404.php');