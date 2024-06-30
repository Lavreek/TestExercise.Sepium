<?php

class Auth
{
    public function __construct()
    {
        $this->listenLogin();
    }

    private function redirectToLogin()
    {
        if (!isset($_COOKIE['login'], $_COOKIE['roles']) && $_SERVER['REQUEST_URI'] !== '/login') {
            header('Location: /login', true, 302);
        }
    }

    private function listenLogin()
    {
        if ($_SERVER['REQUEST_URI'] == '/login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $request = new LoginRequest();

            if ($request->getEmail() == 'admin' && $request->getPassword() == 'admin') {
                setcookie('login', 'admin');
                setcookie('roles', json_encode(['ADMIN', 'USER']));
                header('Location: /', true, 302);
            }
        }
    }

    public function checkCredentials(array $roles) : bool
    {
        if (!isset($_COOKIE['login'], $_COOKIE['roles'])) {
            $this->redirectToLogin();
        }

        $userRoles = json_decode($_COOKIE['roles'], true);

        foreach ($userRoles as $userRole) {
            if (in_array($userRole, $roles)) {
                return true;
            }
        }

        return false;
    }
}