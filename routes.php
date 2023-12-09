<?php

get('/', '\App\Controllers\Index::get');
any('/404','App/Controllers/404.php');