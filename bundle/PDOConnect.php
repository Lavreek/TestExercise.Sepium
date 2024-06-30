<?php

class PDOConnect
{
    private $driver;

    private $host;

    private $database;

    private $user;

    private $password;

    private $charset;

    public function __construct()
    {
        $this->initialize(parse_ini_file(PROJECT_INI_CONFIGURATION));
    }

    private function initialize(array $config) : void
    {
        foreach ($config as $key => $value) {
            $key = strtolower($key);

            if (property_exists($this, $key)) {
                if ($this->checkEmpty($key, $value)) {
                    $this->{$key} = $value;
                }
            }
        }

        $connect = $this->getConnection();
        unset($connect);
    }

    public function executeQuery(string $query)
    {
        /** @var PDO $connection */
        $connection = $this->getConnection();
        $connection->beginTransaction();

        try {
            $exec = $connection->prepare($query);
            $exec->execute();

            if ($connection->inTransaction()) {
                $connection->commit();
            }
        } catch (PDOException $exception) {
            if ($connection->inTransaction()) {
                $connection->rollBack();
            }

            Logger::write($exception);
        }
    }

    protected function getConnection() : ?PDO
    {
        try {
            return new PDO($this->createDSN(), $this->getUser(), $this->getPassword());

        } catch (PDOException $exception) {
            Logger::write($exception);
        }

        return null;
    }

    private function createDSN() : string
    {
        return $this->getDriver() .
            ':host='. $this->getHost() .
            ';dbname='. $this->getDatabase() .
            ';charset='. $this->getCharset() .
            ';';
    }

    private function checkEmpty(string $key, string $value) : bool
    {
        if (empty($value)) {
            throw new Exception("PDO key \"{$key}\" cannot be empty.", 500);
        }

        return true;
    }

    protected function getDriver()
    {
        return $this->driver;
    }

    protected function getHost()
    {
        return $this->host;
    }

    protected function getDatabase()
    {
        return $this->database;
    }

    protected function getCharset()
    {
        return $this->charset;
    }

    private function getUser()
    {
        return $this->user;
    }

    private function getPassword()
    {
        return $this->password;
    }
}