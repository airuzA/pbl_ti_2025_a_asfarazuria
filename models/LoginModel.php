<?php

require_once __DIR__ . '/AccountsModel.php';

class LoginModel
{
    private $accounts;

    public function __construct()
    {
        $this->accounts = new AccountsModel();
    }

    public function authenticate($email, $password)
    {
        $account = $this->accounts->findByEmail($email);

        if ($account === null || !password_verify($password, $account['password'])) {
            return null;
        }

        return $account;
    }
}
