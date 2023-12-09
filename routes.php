<?php

get('/', '\App\Controllers\Index::get');
any('/add-task', '\App\Controllers\Tasks::addTask');
any('/edit-task', '\App\Controllers\Tasks::editTask');
any('/404','App/Controllers/404.php');