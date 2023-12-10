<?php

namespace App\Models;

class User extends Model
{
    private static array $users = [
        '21232f297a57a5a743894a0e4a801fc3' => [
            'user_name' => 'admin',
            'user_password' => '202cb962ac59075b964b07152d234b70',
            'group' => 'admins',
        ]
    ];
    
    private static ? bool $is_authenticated = null;
    private static ? bool $is_admin = null;
    
    public static function isAuthenticated() : bool
    {
        if (! is_null(self::$is_authenticated))
            return self::$is_authenticated;
        
        if (empty($authenticated = $_SESSION['authenticated'] ?? ''))
            return self::$is_authenticated = false;
        
        return (self::$is_authenticated = isset(self::$users[$authenticated]));
    }
    
    public static function isAdmin() : bool
    {
        if (! self::isAuthenticated())
            return false;
        
        if (! is_null(self::$is_admin))
            return self::$is_admin;
        
        return self::$is_admin = self::$users[$_SESSION['authenticated']]['group'] === 'admins';
    }
    
    public static function authenticate(array $data) : array
    {
        $errors = [];
        $user_name = $data['user_name'] ?? '';
        $user_password = $data['user_password'] ?? '';
        
        if (empty($user_name))
            $errors['user_name'] = 'Введите имя пользователя';
        
        if (empty($user_password))
            $errors['user_password'] = 'Введите пароль';
        
        if (! empty($errors))
            return $errors;
        
        foreach (self::$users as $user_hash => $user) {
            if ($user_name === $user['user_name'] && md5($user_password) === $user['user_password']) {
                $_SESSION['authenticated'] = $user_hash;
                return [];
            }
        }
        
        return ['Данные введены неверно'];
    }
    
    public static function deauthenticate() : void
    {
        unset($_SESSION['authenticated']);
    }
}