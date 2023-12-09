<?php

session_start();

function get($route, $path) : void {
    if (mb_strtolower($_SERVER['REQUEST_METHOD']) === 'get')
        route($route, $path);
}

function post($route, $path) : void {
    if (mb_strtolower($_SERVER['REQUEST_METHOD']) === 'post')
        route($route, $path);
}

function put($route, $path) : void {
    if (mb_strtolower($_SERVER['REQUEST_METHOD']) === 'put')
        route($route, $path);
}

function patch($route, $path) : void {
    if (mb_strtolower($_SERVER['REQUEST_METHOD']) === 'patch')
        route($route, $path);
}

function delete($route, $path) : void {
    if (mb_strtolower($_SERVER['REQUEST_METHOD']) === 'delete')
        route($route, $path);
}

function cli($route, $path) : void {
    if (mb_strtolower(php_sapi_name()) === 'cli')
        route($route, $path);
}

function any($route, $path) : void {
    route($route, $path);
}

function route($route, $path) : void {
    $root = '/' . trim(ROOT_PATH, ' /');
    $route = '/' . trim($route, ' /');
    $path = is_string($path) ? trim($path, ' /') : $path;
    
    if ($route === '/404') {
        include_once("$root/$path");
        exit();
    }
    
    $request_uri = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
    $request_uri = rtrim($request_uri, ' /');
    $request_uri = $request_uri === '' ? '/' : $request_uri;
    $request_uri = strtok($request_uri, '?');
    $route_parts = explode('/', $route);
    $request_uri_parts = explode('/', $request_uri);
    array_shift($route_parts);
    array_shift($request_uri_parts);
    
    if ($route_parts[0] === '' && count($request_uri_parts) === 0) {
        include_once("$root/$path");
        exit();
    }
    
    if (count($route_parts) !== count($request_uri_parts))
        return;
    
    $parameters = [];
    for ($i = 0; $i < count($route_parts); $i++) {
        $route_part = $route_parts[$i];
        if (preg_match("/^[$]/", $route_part)) {
            $route_part = ltrim($route_part, '$');
            array_push($parameters, $request_uri_parts[$i]);
            $$route_part = $request_uri_parts[$i];
        } else if ($route_parts[$i] != $request_uri_parts[$i]) {
            return;
        }
    }
    
    if (is_callable($path)) {
        call_user_func($path);
        exit();
    }
    
    if (str_contains($path, '::')) {
        $path_arr = explode('::', $path);
        $controller = $path_arr[0];
        $method = $path_arr[1];
        
        (new $controller)->{$method}();
        exit();
    }
    
    include_once("$root/$path");
    exit();
}