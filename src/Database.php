<?php

class Database extends PDOConnect
{
    public static function createTables()
    {
        $migrations = (new Loader())->getFiles(PROJECT_MIGRATION_PATH);

        foreach ($migrations as $table) {
            $migrationClass = new PDOMigrations();
            $migrationClass->createTable($table);
        }
    }

    public function insertQuery(string $table, array $keys) : string
    {
        $query_keys = implode('`, `', $keys);
        $query_values = implode(', :', $keys);

        return "INSERT INTO $table (`{$query_keys}`) VALUES (:{$query_values})";
    }

    public function getRequest(string $query, array $parameters = []) : array
    {
        try {
            $connection = $this->getConnection();

            $request = $connection->prepare($query);
            $request->execute($parameters);

            return [
                'result' => $request,
                'message' => 'Запрос выполнен.',
            ];

        } catch (PDOException $exception) {
            Logger::write($exception);

            return [
                'message' => 'Во время выполнения произошла ошибка.',
                'error' => [
                    'message' => $exception->getMessage(),
                ]
            ];
        }
    }
}