<?php

abstract class ViewHandler
{
    use RouteSeeker;

    private Model $model;

    private int $status_code = 200;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function navigateView() : mixed
    {
        $method = $this->findRoute(View::class);

        if (!empty($method)) {
            return $this->{$method}();

        } else {
            return $this->response();
        }
    }

    protected function response() : bool|string
    {
        if (empty($this->model->getResponse())) {
            if ($this->status_code !== 200) {
                return $this->renderTemplate("templates/{$this->status_code}.html");
            }

            return $this->renderTemplate('templates/404.html');

        } else {
            return json_encode($this->model->getResponse());
        }
    }

    protected function getTemplate(string $template) : string
    {
        return file_get_contents(PROJECT_ROOT_PATH .'/'. $template);
    }

    protected function renderTemplate(string $template, array $context = []) : string
    {
        $layout = file_get_contents(PROJECT_ROOT_PATH .'/'. $template);

        foreach ($context as $key => $value) {
            $layout = str_replace(['[[ '. $key .' ]]'], $value, $layout);
        }

        return $layout;
    }
}