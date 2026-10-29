<?php

class Auth
{
    public static function check()
    {
        return isset($_SESSION['account']);
    }

    public static function requireLogin()
    {
        if (!self::check()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public static function user()
    {
        return $_SESSION['account'] ?? null;
    }

    public static function login($account)
    {
        session_regenerate_id(true);

        $_SESSION['account'] = [
            'id' => $account['id'],
            'name' => $account['name'],
            'email' => $account['email'],
            'account_type_id' => $account['account_type_id'],
        ];
    }

    public static function logout()
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }
}
