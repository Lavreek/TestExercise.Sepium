<?php

abstract class ModelHandler
{
    use RouteSeeker;

    protected $response;

    protected Database $database;

    public function __construct()
    {
        $this->database = new Database();
        $this->parseInput();
        $this->getProcessed();
    }

    private function getProcessed(): void
    {
        $method = $this->findRoute(Model::class);

        if (!empty($method)) {
            $this->{$method}();
        }
    }

    protected function setResponse($response): void
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function parseInput(): void
    {
        $inputData = file_get_contents('php://input');

        if (!empty($inputData)) {
            $decoded = json_decode($inputData, true);

            if (!is_null($decoded)) {
                switch ($_SERVER['REQUEST_METHOD']) {
                    case 'GET' : {
                        $_GET += $decoded;
                        break;
                    }
                    case 'POST' : {
                        $_POST += $decoded;
                        break;
                    }
                }
            }
        }
    }
}