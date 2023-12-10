<?php

get('/', '\App\Controllers\Index::get');
any('/add-task', '\App\Controllers\Tasks::addTask');
any('/edit-task', '\App\Controllers\Tasks::editTask');
any('/log-in', '\App\Controllers\Users::logIn');
get('/log-out', '\App\Controllers\Users::logOut');
get('/rebuild-db-tables','\App\Controllers\Users::rebuildDBTables');
any('/404','App/Controllers/404.php');