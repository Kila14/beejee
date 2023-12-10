<?php

namespace App\Controllers;

class Users
{
    public function logIn() : void
    {
        if (\App\Models\User::isAuthenticated())
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post_data = $_POST;
            
            if (empty($errors = \App\Models\User::authenticate($post_data))) {
                if (isset($_COOKIE['http_referer']))
                    setcookie('http_referer', '', time() - 3600);
                
                header('Location: ' . ($_COOKIE['http_referer'] ?? '/'));
            }
        } else {
            if (isset($_SERVER['HTTP_REFERER']))
                setcookie('http_referer', $_SERVER['HTTP_REFERER']);
        }
        
        echo template('templates/user.php', ['h1' => 'Аутентификация', 'mode' => 'log_in', 'data' => $post_data ?? [], 'errors' => $errors ?? []]);
    }
    
    public function logOut() : void
    {
        if (! \App\Models\User::isAuthenticated())
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
        
        \App\Models\User::deauthenticate();
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
    }
}