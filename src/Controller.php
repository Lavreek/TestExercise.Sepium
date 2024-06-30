<?php

final class Controller
{
    private Model $model;

    private View $view;

    public function __construct()
    {
        new Auth();
    }

    public function createModel(): void
    {
        $this->model = new Model();
    }

    public function createView(): void
    {
        $this->view = new View($this->model);
    }

    public function response() : string
    {
        return $this->view->navigateView();
    }
}