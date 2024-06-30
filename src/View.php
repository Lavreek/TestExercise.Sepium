<?php

final class View extends ViewHandler
{
    #[Routing(path: '/', roles: ['USER'])]
    public function index() : string
    {
        return $this->renderTemplate('templates/index.html', [
            'VIEW_CONTENT' => $this->getTemplate('templates/user_table.html')
        ]);
    }

    #[Routing(path: '/login')]
    public function login() : string
    {
        return $this->renderTemplate('templates/login.html');
    }
}