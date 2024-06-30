<?php

final class View extends ViewHandler
{
    #[Routing(path: '/')]
    public function index() : string
    {
        return $this->renderTemplate('templates/index.html', [
            'VIEW_CONTENT' => $this->getTemplate('templates/user_table.html')
        ]);
    }
}